<?php
session_start();
require_once "../models/UserModel.php";

$errors = [];

$db = new Database();
$pdo = $db->getConnection();
$userModel = new UserModel($pdo);

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = $_POST["email"] ?? "";
    $password = $_POST["newPassword"] ?? "";
    $confirmPassword = $_POST["confirmPassword"] ?? "";

    // Email cannot be empty or invalid
    if (empty($email)) {
        $errors['email'] = "Valid email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Invalid email format";
    }

    // Password must be at least 8 characters long
    if (strlen($password) == 0) {
        $errors['password'] = "*Password is required";
    } elseif (strlen($password) < 8) {
        $errors['password'] = "Password must be at least 8 characters";
    }

    // Confirm Password must match Password
    if (empty($confirmPassword)) {
        $errors['confirmPasswordError'] = "Please confirm password";
    } elseif ($confirmPassword !== $password) {
        $errors['confirmPasswordError'] = "Passwords do not match";
    }
    
    $result = $userModel->changePassword($email, $password);

    if ($result['success'] == true)
    {
        $_SESSION['forgot_password'] = $result['message'];

        header("Location: ../views/login.php");
        exit();
    } else {
        $errors['forgot_password'] = $result['message'];
        $_SESSION['errors'] = $errors;
        header("Location: ../views/forgot_password.php");
        exit();
    }

    echo $result;
}
?>