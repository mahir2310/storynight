<?php
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'customer') {
    header("Location: ../login.php");
    exit();
}

$user = $_SESSION['user'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Bookings</title>
</head>
<body>
    <h1>My Bookings</h1>
</body>
</html>