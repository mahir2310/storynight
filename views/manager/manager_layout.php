<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'manager') {
    header("Location: ../login.php");
    exit();
}

$user = $_SESSION['user'];
$pageTitle = "Manager Dashboard";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StoryNight - <?php echo $pageTitle; ?></title>
    <link rel="stylesheet" href="../../assets/styles/dashboard.css">
</head>

<body>
    <div class="dashboard-container">
        <?php include 'manager_sidebar.php'; ?>

        <div class="dashboard-content">
            <?php
            if (isset($_GET['page'])) {
                $page = $_GET['page'];

                if ($page === 'account_settings') {
                    include '../account_settings.php';
                } else {
                    $file = $page . '.php';
                    if (file_exists($file)) {
                        include $file;
                    } else {
                        include 'manager_dashboard.php';
                    }
                }
            } else {
                include 'manager_dashboard.php';
            }
            ?>

        </div>
    </div>
</body>

</html>