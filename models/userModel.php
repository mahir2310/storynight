<?php

require_once "database.php";

class UserModel {
    private $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function usernameExists($username) {

        $sql = "SELECT user_id FROM users WHERE username = :username LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':username' => $username]);
        return $stmt->fetch() ? true : false;
    }

    // Check if email exists
    public function emailExists($email) {
        $sql = "SELECT user_id FROM users WHERE email = :email LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':email' => $email]);
        return $stmt->fetch() ? true : false;
    }

    // Register new user
    public function registerUser($username, $email, $password, $role) {
        if ($this->usernameExists($username)) {
            return [
                'success' => false,
                'message' => 'Username already taken.'
            ];
        }
        if ($this->emailExists($email)) {
            return [
                'success' => false,
                'message' => 'Email already registered.'
            ];
        }

        $sql = "INSERT INTO users (username, email, password, role) 
                VALUES (:username, :email, :password, :role)";
        $stmt = $this->pdo->prepare($sql);

        $success = $stmt->execute([
            ':username' => $username,
            ':email'    => $email,
            ':password' => $password,
            ':role'     => $role
        ]);

        return $success ? [
            'success' => true,
            'message' => 'User registered successfully!'
        ] : [
            'success' => false,
            'message' => 'Registration failed.'
        ];
    }

    // Login user
    public function loginUser($email, $password) {
        $sql = "SELECT * FROM users WHERE email = :email LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch();

        if ($user['status'] == 'banned') {
            return [
                'success' => false,
                'message' => 'You are banned from the system.'
            ];
        }

        if ($user && $password == $user['password']) {
            unset($user['password']);
            return [
                'success' => true,
                'user'    => $user
            ];
        }

        return [
            'success' => false,
            'message' => 'Invalid credentials.'
        ];
    }

    // Change password
    public function changePassword($email, $newPassword) {
        if (!$this->emailExists($email)) {
            return ['success' => false, 'message' => 'Email not found.'];
        }

        $sql = "UPDATE users SET password = :password WHERE email = :email";
        $stmt = $this->pdo->prepare($sql);

        $success = $stmt->execute([
            ':password' => $newPassword,
            ':email'    => $email
        ]);

        return $success 
            ? ['success' => true, 'message' => 'Password updated successfully!'] 
            : ['success' => false, 'message' => 'Failed to update password.'];
    }





    // Get all users
    public function getAllUsers()
    {
        $sql = "SELECT user_id, username, email, role, status, created_at 
            FROM users 
            ORDER BY created_at DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Remove user
    public function removeUser($userId)
    {
        $sql = "DELETE FROM users WHERE user_id = :user_id";
        $stmt = $this->pdo->prepare($sql);
        $success = $stmt->execute([':user_id' => $userId]);

        return $success
            ? ['success' => true, 'message' => 'User removed successfully!']
            : ['success' => false, 'message' => 'Failed to remove user.'];
    }

    // Ban/Unban user
    public function toggleUserStatus($userId, $currentStatus)
    {
        $newStatus = $currentStatus === 'banned' ? 'active' : 'banned';
        $action = $newStatus === 'banned' ? 'banned' : 'unbanned';

        $sql = "UPDATE users SET status = :status WHERE user_id = :user_id";
        $stmt = $this->pdo->prepare($sql);
        $success = $stmt->execute([
            ':status' => $newStatus,
            ':user_id' => $userId
        ]);

        return $success
            ? ['success' => true, 'message' => "User {$action} successfully!"]
            : ['success' => false, 'message' => "Failed to {$action} user."];
    }

    // Update user role
    public function updateUserRole($userId, $newRole)
    {
        $validRoles = ['customer', 'manager', 'admin'];
        if (!in_array($newRole, $validRoles)) {
            return ['success' => false, 'message' => 'Invalid role specified.'];
        }

        $sql = "UPDATE users SET role = :role WHERE user_id = :user_id";
        $stmt = $this->pdo->prepare($sql);
        $success = $stmt->execute([
            ':role' => $newRole,
            ':user_id' => $userId
        ]);

        return $success
            ? ['success' => true, 'message' => 'User role updated successfully!']
            : ['success' => false, 'message' => 'Failed to update user role.'];
    }

    // Update account settings
    public function updateAccountSettings($userId, $newPassword, $oldPassword, $profilePic, $phone, $address, $gender, $dob, $critic, $bio)
    {
        // check old password
        if (!empty($newPassword)) {
            $checkSql = "SELECT password FROM users WHERE user_id = :user_id LIMIT 1";
            $checkStmt = $this->pdo->prepare($checkSql);
            $checkStmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
            $checkStmt->execute();
            $result = $checkStmt->fetch(PDO::FETCH_ASSOC);

            if (!$result || $result['password'] !== $oldPassword) {
                return ['success' => false, 'message' => 'Password mismatch'];
            }
            unset($_SESSION['errors']);
        }

        $sql = "UPDATE users 
            SET profile_pic = :profile_pic,
                phone = :phone,
                address = :address,
                gender = :gender,
                dob = :dob,
                critic = :critic,
                bio = :bio";

        if (!empty($newPassword)) {
            $sql .= ", password = :password";
        }

        $sql .= " WHERE user_id = :user_id";

        $stmt = $this->pdo->prepare($sql);

        $stmt->bindParam(':profile_pic', $profilePic, PDO::PARAM_STR);
        $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
        $stmt->bindParam(':address', $address, PDO::PARAM_STR);
        $stmt->bindParam(':gender', $gender, PDO::PARAM_STR);
        $stmt->bindParam(':dob', $dob, PDO::PARAM_STR);
        $stmt->bindParam(':critic', $critic, PDO::PARAM_INT);
        $stmt->bindParam(':bio', $bio, PDO::PARAM_STR);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);

        // Bind password if not empty
        if (!empty($newPassword)) {
            $stmt->bindParam(':password', $newPassword, PDO::PARAM_STR);
        }

        $success = $stmt->execute();

        return $success
            ? ['success' => true, 'message' => 'Account settings updated successfully!']
            : ['success' => false, 'message' => 'Failed to update account settings.'];
    }

    // Get user by ID
    public function getUserById($userId)
    {
        $sql = "SELECT * FROM users WHERE user_id = :user_id LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            unset($user['password']);
        }

        return $user;
    }

}
?>