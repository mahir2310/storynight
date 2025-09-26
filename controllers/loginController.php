<?php
session_start();
require_once "../models/UserModel.php";
require_once "cookieController.php";

$db = new Database();
$pdo = $db->getConnection();
$userModel = new UserModel($pdo);

$errors = [];


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = $_POST["email"] ?? "";
    $password = $_POST["password"] ?? "";

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

    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        header("Location: ../views/login.php");
        exit();
    }

    $result = $userModel->loginUser($email, $password);

    if ($result['success'] == true)
    {
        $_SESSION['user'] = $result['user'];
        generateCookie();

        // redirect to personalized dashboard based on user role
        if ($result['user']['role'] == 'admin') {
            header("Location: ../views/admin/admin_layout.php");
        } elseif ($result['user']['role'] == 'manager') {
            header("Location: ../views/manager/manager_layout.php");
        } elseif ($result['user']['role'] == 'customer') {
            header("Location: ../views/customer/customer_layout.php");
        }
        exit();
    } else {
        $errors['login'] = $result['message'];
        $_SESSION['errors'] = $errors;
        header("Location: ../views/login.php");
        exit();
    }

    echo $result;


}
?>