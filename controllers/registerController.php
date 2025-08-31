<?php
session_start();
$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST["name"] ?? "";
    $email = $_POST["email"] ?? "";
    $password = $_POST["password"] ?? "";
    $confirm = $_POST["confirmPassword"] ?? "";
    $role = "customer";

    // Name cannot be empty
    if (empty($name)) {
        $errors['name'] = "Name is required";
    }

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
    if (empty($confirm)) {
        $errors['confirm'] = "Please confirm password";
    } elseif ($confirm !== $password) {
        $errors['confirm'] = "Passwords do not match";
    }

    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        header("Location: ../views/register.php");
        exit();
    }

}
?>