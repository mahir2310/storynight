<?php
session_start();
require_once "../models/UserModel.php";

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

    $result = loginUser($email, $password);

    if ($result == true)
    {
        header("Location: ../views/dashboard.php");
        exit();
    } else {
        $errors['general'] = $result;
        $_SESSION['errors'] = $errors;
        header("Location: ../views/login.php");
        exit();
    }

    echo $result;


}
?>