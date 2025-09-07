<?php
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'manager') {
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
    <title>Manage Movies</title>
</head>
<body>
    <h1>Manage Movies</h1>
</body>
</html>