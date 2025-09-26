<?php
require_once "cookieController.php";

function generateCookie()
{
    $userId = $_SESSION['user']['user_id'];
    $expiry = time() + (60 * 60 * 24); // 24 hours
    $token = $userId . "|" . $expiry;

    // Set cookie
    setcookie(
        "auth_token",
        $token,
        $expiry,
        "/",
    );

}

function checkCookie()
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (!isset($_COOKIE['auth_token'])) {
        logoutAndRedirect();
    }

    list($userId, $expiry) = explode('|', $_COOKIE['auth_token']);

}

function logoutAndRedirect()
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    session_unset();
    session_destroy();
    setcookie("auth_token", "", time() - 3600, "/");
    header("Location: /storynight/views/login.php");
    exit();
}
