<?php

require_once "database.php";

function usernameExists($username) {
    global $pdo;
    $sql = "SELECT user_id FROM users WHERE username = :username LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':username' => $username]);
    return $stmt->fetch(PDO::FETCH_ASSOC) ? true : false; // return true if username exists
}

function emailExists($email) {
    global $pdo;
    $sql = "SELECT user_id FROM users WHERE email = :email LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':email' => $email]);
    return $stmt->fetch(PDO::FETCH_ASSOC) ? true : false; // return true if email exists
}

function registerUser($username, $email, $password, $role) {
    global $pdo;
    if (usernameExists($username)) {
        return "Username already taken.";
    }
    if (emailExists($email)) {
        return "Email already registered.";
    }

    $sql = "INSERT INTO users (username, email, password, role) 
            VALUES (:username, :email, :password, :role)";
    $stmt = $pdo->prepare($sql);

    $success = $stmt->execute([
        ':username'      => $username,
        ':email'         => $email,
        ':password'      => $password,
        ':role'          => $role,
    ]);

    return $success ? "User registered successfully!" : "Registration failed.";
}

function loginUser($email, $password) {
    global $pdo;
    $sql = "SELECT user_id, username, password, role FROM users WHERE email = :email LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && $password == $user['password']) {
        session_start();
        $_SESSION['user_id']  = $user['user_id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role']     = $user['role'];
        return true;
    }

    return false;
}
