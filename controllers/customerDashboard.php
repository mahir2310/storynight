<?php
require_once "../../models/Dashboard.php";
require_once "cookieController.php";

$db = new Database();
$pdo = $db->getConnection();
$dashboard = new Dashboard($pdo);

function customerDashboard($userId)
{
    checkCookie();
    global $dashboard;
    return $dashboard->customerDashboard($userId);
}
