<?php
require_once "../../models/UserModel.php";
require_once "cookieController.php";

$db = new Database();
$pdo = $db->getConnection();
$userModel = new UserModel($pdo);

// Get all users for views
function getAllUsers()
{
    checkCookie();
    global $userModel;
    return $userModel->getAllUsers();
}

