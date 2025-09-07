<?php
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'manager') {
    header("Location: ../login.php");
    exit();
}

$user = $_SESSION['user'];

$currentPage = isset($_GET['page']) ? $_GET['page'] : 'manager_dashboard';
?>

<div class="dashboard-sidebar">
    <div class="sidebar-header">
        <h2>Manager Panel</h2>
        <p>Welcome, <?php echo $user['username']; ?></p>
    </div>
    
    <ul class="sidebar-nav">
        <li>
            <a href="?page=manager_dashboard" class="nav-link <?php echo $currentPage === 'manager_dashboard' ? 'active' : ''; ?>">
                <img src="../../assets/icons/tachometer.svg" alt="Dashboard">
                <span>Dashboard</span>
            </a>
        </li>
        <li>
            <a href="?page=add_movie" class="nav-link <?php echo $currentPage === 'add_movie' ? 'active' : ''; ?>">
                <img src="../../assets/icons/plus-square.svg" alt="Add Movie">
                <span>Add Movie</span>
            </a>
        </li>
        <li>
            <a href="?page=manage_movies" class="nav-link <?php echo $currentPage === 'manage_movies' ? 'active' : ''; ?>">
                <img src="../../assets/icons/film.svg" alt="Manage Movies">
                <span>Manage Movies</span>
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
