<?php
require_once "../models/MovieModel.php";

$db = new Database();
$pdo = $db->getConnection();
$movieModel = new MovieModel($pdo);

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $action = $_GET['action'] ?? '';
    $movieId = isset($_GET['movie_id']) ? (int)$_GET['movie_id'] : null;

    switch ($action) {
        case 'delete':
            $result = deleteMovie($movieId);
            echo json_encode($result);
            break;

        case 'add_discount':
            $discount = isset($_GET['discount']) ? (int)$_GET['discount'] : 0;
            $result = addMovieDiscount($movieId, $discount);
            echo json_encode($result);
            break;

        default:
            $result = ['success' => false, 'message' => 'Invalid action.'];
            echo json_encode($result);
            break;
    }

    exit();
}

// Delete movie action
function deleteMovie($movieId)
{
    global $movieModel;
    if (!$movieId) {
        $_SESSION['admin_error'] = 'Movie ID is required.';
        return ['success' => false, 'message' => 'Movie ID is required.'];
    }

    $result = $movieModel->deleteMovie($movieId);
    if ($result['success']) {
        $_SESSION['admin_success'] = $result['message'];
    } else {
        $_SESSION['admin_error'] = $result['message'];
    }
    return $result;
}

// Add movie discount
function addMovieDiscount($movieId, $discount)
{
    global $movieModel;
    if (!$movieId) {
        $_SESSION['admin_error'] = 'Movie ID is required.';
        return ['success' => false, 'message' => 'Movie ID is required.'];
    }

    $result = $movieModel->updateDiscount($movieId, $discount);
    if ($result['success']) {
        $_SESSION['admin_success'] = $result['message'];
    } else {
        $_SESSION['admin_error'] = $result['message'];
    }
    return $result;
}
