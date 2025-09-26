<?php
require_once "../../models/BookingModel.php";
require_once "cookieController.php";

$db = new Database();
$pdo = $db->getConnection();
$bookingModel = new BookingModel($pdo);

function getMyBookings($userId)
{
    checkCookie();
    global $bookingModel;
    return $bookingModel->getUserBookings($userId);
}
