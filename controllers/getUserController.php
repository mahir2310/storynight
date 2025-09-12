<?php
require_once "../../models/UserModel.php";

$db = new Database();
$pdo = $db->getConnection();
$userModel = new UserModel($pdo);

// Get all users for views
function getAllUsers()
{
    global $userModel;
    return $userModel->getAllUsers();
}

