<?php
require_once "../models/UserModel.php";
require_once "cookieController.php";

$db = new Database();
$pdo = $db->getConnection();
$userModel = new UserModel($pdo);


if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // header('Content-Type: application/json');
    checkCookie();
    $_SESSION['error'] = $_GET['action'];
    $action = $_GET['action'];
    $userId = isset($_GET['user_id']) ? (int)$_GET['user_id'] : null;

    switch ($action) {
        case 'remove':
            $result = removeUser($userId);
            echo json_encode($result);
            break;

        case 'toggle_status':
            $currentStatus = isset($_GET['current_status']) ? $_GET['current_status'] : '';
            $result = toggleUserStatus($userId, $currentStatus);
            echo json_encode($result);
            break;

        case 'update_role':
            $newRole = isset($_GET['new_role']) ? $_GET['new_role'] : '';
            $result = updateUserRole($userId, $newRole);
            echo json_encode($result);
            break;

        default:
            $result = 'Invalid action.';
            echo json_encode($result);
            break;
    }

    exit();
}


// Remove user action
function removeUser($userId)
{
    checkCookie();
    global $userModel;
    if (!$userId) {
        $_SESSION['error'] = 'User ID is required.';
        return;
    }

    $result = $userModel->removeUser($userId);
    if ($result['success']) {
        $_SESSION['admin_success'] = $result['message'];
    } else {
        $_SESSION['admin_error'] = $result['message'];
    }
    return $result;
}

// Ban/Unban user action
function toggleUserStatus($userId, $currentStatus)
{
    checkCookie();
    global $userModel;
    if (!$userId) {
        $_SESSION['admin_error'] = 'User ID is required.';
        return;
    }

    $result = $userModel->toggleUserStatus($userId, $currentStatus);
    if ($result['success']) {
        $_SESSION['admin_success'] = $result['message'];
    } else {
        $_SESSION['admin_error'] = $result['message'];
    }
    return $result;
}

// Update user role action
function updateUserRole($userId, $newRole)
{
    checkCookie();
    global $userModel;
    if (!$userId) {
        $_SESSION['admin_error'] = 'User ID is required.';
        return;
    }

    $result = $userModel->updateUserRole($userId, $newRole);
    if ($result['success']) {
        $_SESSION['admin_success'] = $result['message'];
    } else {
        $_SESSION['admin_error'] = $result['message'];
    }
    return $result;
}