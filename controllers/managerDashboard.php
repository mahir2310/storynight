<?php
require_once "../../models/Dashboard.php";
require_once "cookieController.php";

$db = new Database();
$pdo = $db->getConnection();
$dashboard = new Dashboard($pdo);

function managerDashboard()
{
    checkCookie();
    global $dashboard;
    return $dashboard->manageDashboard();
}
