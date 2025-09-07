<?php
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'customer') {
    header("Location: ../login.php");
    exit();
}

$user = $_SESSION['user'];
$currentPage = isset($_GET['page']) ? $_GET['page'] : 'customer_dashboard';
?>

<div class="dashboard-sidebar">
    <div class="sidebar-header">
        <h2>Customer Panel</h2>
        <p>Welcome, <?php echo $user['username']; ?></p>
    </div>
    
    <ul class="sidebar-nav">
        <li>
            <a href="?page=customer_dashboard" class="nav-link <?php echo $currentPage === 'customer_dashboard' ? 'active' : ''; ?>">
                <img src="../../assets/icons/tachometer.svg" alt="Dashboard">
                <span>Dashboard</span>
            </a>
        </li>
        <li>
            <a href="?page=browse_movies" class="nav-link <?php echo $currentPage === 'browse_movies' ? 'active' : ''; ?>">
                <img src="../../assets/icons/film.svg" alt="Browse Movies">
                <span>Browse Movies</span>
            </a>
        </li>
        <li>
            <a href="?page=my_bookings" class="nav-link <?php echo $currentPage === 'my_bookings' ? 'active' : ''; ?>">
                <img src="../../assets/icons/ticket-yellow.svg" alt="My Bookings">
                <span>My Bookings</span>
            </a>
        </li>
        <li>
            <a href="?page=account_settings" class="nav-link <?php echo $currentPage === 'account_settings' ? 'active' : ''; ?>">
                <img src="../../assets/icons/cog.svg" alt="Account Settings">
                <span>Account Settings</span>
            </a>
        </li>
        <li>
            <a href="../logout.php" class="nav-link">
                <img src="../../assets/icons/sign-out.svg" alt="Logout">
                <span>Logout</span>
            </a>
        </li>
    </ul>
</div>
