<?php
require_once "../../models/Dashboard.php";
require_once "cookieController.php";

$db = new Database();
$pdo = $db->getConnection();
$dashboard = new Dashboard($pdo);

function adminDashboard()
{
    checkCookie();
    global $dashboard;
    return $dashboard->adminDashboard();
}
