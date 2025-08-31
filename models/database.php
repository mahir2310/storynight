<?php

$host = "localhost";
$db   = "storynight";
$user = "root";
$pass = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    $_SESSION["db_error"] = $e;
    die("Database connection failed: " . $e->getMessage());
}
