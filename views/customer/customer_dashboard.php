<?php
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'customer') {
    header("Location: ../login.php");
    exit();
}

$user = $_SESSION['user'];

require_once __DIR__ . "/../../controllers/customerDashboard.php";

$stats = customerDashboard($user['user_id']);
?>

<div class="dashboard-header">
    <h1>Customer Dashboard</h1>
    <p>Welcome back, <?php echo $user['username']; ?>! Here’s your activity overview.</p>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon">
            <img src="../../assets/icons/film-black.svg" alt="Available Movies">
        </div>
        <div class="stat-info">
            <h3><?php echo $stats['total_movies']; ?></h3>
            <p>Available Movies</p>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon">
            <img src="../../assets/icons/ticket.svg" alt="My Bookings">
        </div>
        <div class="stat-info">
            <h3><?php echo $stats['my_bookings']; ?></h3>
            <p>My Bookings</p>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon">
            <img src="../../assets/icons/calendar-black.svg" alt="Upcoming Bookings">
        </div>
        <div class="stat-info">
            <h3><?php echo $stats['upcoming_bookings']; ?></h3>
            <p>Upcoming Bookings</p>
        </div>
    </div>
</div>

<div class="dashboard-section">
    <h2>Quick Actions</h2>
    <div class="action-grid">
        <a href="?page=browse_movies" class="action-card">
            <div class="action-icon">
                <img src="../../assets/icons/film.svg" alt="Browse Movies">
            </div>
            <h3>Browse Movies</h3>
            <p>Explore movies and book tickets</p>
        </a>

        <a href="?page=my_bookings" class="action-card">
            <div class="action-icon">
                <img src="../../assets/icons/ticket-yellow.svg" alt="My Bookings">
            </div>
            <h3>My Bookings</h3>
            <p>View and manage your bookings</p>
        </a>
    </div>
</div>
