<?php
session_start();
require_once "../models/BookingModel.php";
require_once "cookieController.php";

$db = new Database();
$pdo = $db->getConnection();
$bookingModel = new BookingModel($pdo);

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    checkCookie();
    $action = $_GET['action'] ?? '';
    $bookingId = isset($_GET['booking_id']) ? (int)$_GET['booking_id'] : null;
    $userId = $_SESSION['user']['user_id'] ?? null;
    $movieId = isset($_GET['movie_id']) ? (int)$_GET['movie_id'] : null;
    $tickets = isset($_GET['tickets']) ? (int)$_GET['tickets'] : 1;
    $totalPrice = isset($_GET['total_price']) ? (float)$_GET['total_price'] : 0;

    switch ($action) {
        case 'book':
            if (!$userId || !$movieId) {
                echo json_encode(['success' => false, 'message' => 'User ID and Movie ID required.', 'movieId'=>$movieId, 'userId'=>$userId]);
                break;
            }
            $result = bookMovie($userId, $movieId, $tickets, $totalPrice);
            echo json_encode($result);
            break;

        case 'cancel':
            if (!$movieId) {
                echo json_encode(['success' => false, 'message' => 'Movie ID required.']);
                break;
            }
            $result = cancelBooking($userId, $movieId);
            echo json_encode($result);
            break;

        default:
            echo json_encode(['success' => false, 'message' => 'Invalid action.']);
            break;
    }
    exit();
}

// Book movie
function bookMovie($userId, $movieId, $tickets = 1, $totalPrice)
{
    global $bookingModel;
    $result = $bookingModel->addBooking($userId, $movieId, $tickets, $totalPrice);
    $_SESSION['flash_message'] = $result['message'];
    return $result;
}

// Cancel booking
function cancelBooking($userId, $movieId)
{
    global $bookingModel;
    $result = $bookingModel->removeBooking($userId, $movieId);
    return $result;
}