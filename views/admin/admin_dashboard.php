<?php
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {
    header("Location: ../login.php");
    exit();
}

$user = $_SESSION['user'];

require_once __DIR__ . "/../../controllers/adminDashboard.php";

$stats = adminDashboard();
?>

<div class="dashboard-header">
    <h1>Admin Dashboard</h1>
    <p>Welcome back, <?php echo $user['username']; ?>! Here's an overview of your platform.</p>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon">
            <img src="../../assets/icons/users.svg" alt="Total Users">
        </div>
        <div class="stat-info">
            <h3><?php echo $stats['total_users']; ?></h3>
            <p>Total Users</p>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon">
            <img src="../../assets/icons/user-tie.svg" alt="Total Managers">
        </div>
        <div class="stat-info">
            <h3><?php echo $stats['total_managers']; ?></h3>
            <p>Managers</p>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon">
            <img src="../../assets/icons/user-friends.svg" alt="Total Customers">
        </div>
        <div class="stat-info">
            <h3><?php echo $stats['total_customers']; ?></h3>
            <p>Customers</p>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon">
            <img src="../../assets/icons/user-slash.svg" alt="Banned Users">
        </div>
        <div class="stat-info">
            <h3><?php echo $stats['banned_users']; ?></h3>
            <p>Banned Users</p>
        </div>
    </div>
</div>

<div class="dashboard-section">
    <h2>Quick Actions</h2>
    <div class="action-grid">
        <a href="?page=manage_users" class="action-card">
            <div class="action-icon">
                <img src="../../assets/icons/user-tie-yellow.svg" alt="Manage Users">
            </div>
            <h3>Manage Users</h3>
            <p>Change user roles, remove users</p>
        </a>

        <a href="?page=manage_users" class="action-card">
            <div class="action-icon">
                <img src="../../assets/icons/search.svg" alt="Search User">
            </div>
            <h3>Search User</h3>
            <p>Find specific user accounts</p>
        </a>
        
        <a href="?page=manage_users" class="action-card">
            <div class="action-icon">
                <img src="../../assets/icons/ban.svg" alt="Ban/Unban Users">
            </div>
            <h3>Ban/Unban Users</h3>
            <p>Restrict or restore user access</p>
        </a>
    </div>
</div>