<?php
require_once "../../models/BookingModel.php";

$db = new Database();
$pdo = $db->getConnection();
$bookingModel = new BookingModel($pdo);

function getMyBookings($userId)
{
    global $bookingModel;
    return $bookingModel->getUserBookings($userId);
}
