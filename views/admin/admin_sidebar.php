<?php
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {
    header("Location: ../login.php");
    exit();
}

$user = $_SESSION['user'];

$currentPage = isset($_GET['page']) ? $_GET['page'] : 'admin_dashboard';
?>

<div class="dashboard-sidebar">
    <div class="sidebar-header">
        <h2>Admin Panel</h2>
        <p>Welcome, <?php echo $user['username']; ?></p>
    </div>
    
    <ul class="sidebar-nav">
        <li>
            <a href="?page=admin_dashboard" class="nav-link <?php echo $currentPage === 'admin_dashboard' ? 'active' : ''; ?>">
                <img src="../../assets/icons/tachometer.svg" alt="Dashboard">
                <span>Dashboard</span>
            </a>
        </li>
        <li>
            <a href="?page=manage_users" class="nav-link <?php echo $currentPage === 'manage_users' ? 'active' : ''; ?>">
                <img src="../../assets/icons/user-tie-yellow.svg" alt="Manage Users">
                <span>Manage Users</span>
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