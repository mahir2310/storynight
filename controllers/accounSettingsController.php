<?php
session_start();
require_once "../models/UserModel.php";
require_once "cookieController.php";

$db = new Database();
$pdo = $db->getConnection();
$userModel = new UserModel($pdo);

$errors = [];

$user = $_SESSION['user'];
$userId = $_SESSION['user']['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    checkCookie();

    // POST data
    $newPassword = $_POST['new_password'] ?? '';
    $oldPassword = $_POST['old_password'] ?? '';
    $profilePic  = $_POST['profile_pic'] ?? '';
    $phone       = $_POST['phone'] ?? '';
    $address     = $_POST['address'] ?? '';
    $gender      = $_POST['gender'] ?? '';
    $dob         = $_POST['dob'] ?? '';
    $bio         = $_POST['bio'] ?? '';
    $critic      = isset($_POST['critic']) ? 1 : 0;


    // Handle pfp upload
    if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] == 0) {
        $uploadDir = "../uploads/profile_pics/";
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $fileTmp  = $_FILES['profile_pic']['tmp_name'];
        $fileName = time() . "_" . basename($_FILES['profile_pic']['name']);
        $filePath = $uploadDir . $fileName;

        if (move_uploaded_file($fileTmp, $filePath)) {
            // Save path
            $profilePic = "uploads/profile_pics/" . $fileName;
        } else {
            $errors['profile_pic'] = "Failed to upload profile picture";
        }
    }

    // Update account settings
    $result = $userModel->updateAccountSettings(
        $userId,
        $newPassword,
        $oldPassword,
        $profilePic,
        $phone,
        $address,
        $gender,
        $dob,
        $critic,
        $bio
    );

    if ($result['success']) {
        // Reload user data
        $user = $userModel->getUserById($userId);
        $_SESSION['user'] = $user;

        $_SESSION['success'] = $result['message'];
    } else {
        $_SESSION['errors'] = $result['message'];
    }

    if ($user['role'] == 'customer') {
        header("Location: ../views/customer/customer_layout.php?page=account_settings");
    } elseif ($user['role'] == 'manager') {
        header("Location: ../views/manager/manager_layout.php?page=account_settings");
    } elseif ($user['role'] == 'admin') {
        header("Location: ../views/admin/admin_layout.php?page=account_settings");
    }

    exit();
}
