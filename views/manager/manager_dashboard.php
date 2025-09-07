<?php
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'manager') {
    header("Location: ../login.php");
    exit();
}

$user = $_SESSION['user'];

// dummy movie stats
$stats = [
    'total_movies'     => 132,
    'upcoming_movies'  => 18,
    'total_customers'  => 1543,
    'total_bookings'   => 4872,
];
?>

<div class="dashboard-header">
    <h1>Manager Dashboard</h1>
    <p>Welcome back, <?php echo $user['username']; ?>! Here’s your movie overview.</p>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon">
            <img src="../../assets/icons/film-black.svg" alt="Total Movies">
        </div>
        <div class="stat-info">
            <h3><?php echo $stats['total_movies']; ?></h3>
            <p>Total Movies</p>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon">
            <img src="../../assets/icons/calendar-black.svg" alt="Upcoming Movies">
        </div>
        <div class="stat-info">
            <h3><?php echo $stats['upcoming_movies']; ?></h3>
            <p>Upcoming Movies</p>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon">
            <img src="../../assets/icons/users.svg" alt="Total Customers">
        </div>
        <div class="stat-info">
            <h3><?php echo $stats['total_customers']; ?></h3>
            <p>Total Customers</p>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon">
            <img src="../../assets/icons/ticket.svg" alt="Total Bookings">
        </div>
        <div class="stat-info">
            <h3><?php echo $stats['total_bookings']; ?></h3>
            <p>Total Bookings</p>
        </div>
    </div>
</div>


<div class="dashboard-section">
    <h2>Quick Actions</h2>
    <div class="action-grid">
        <a href="?page=add_movie" class="action-card">
            <div class="action-icon">
                <img src="../../assets/icons/plus-square.svg" alt="Add Movie">
            </div>
            <h3>Add Movie</h3>
            <p>Add a new movie for hall release</p>
        </a>

        <a href="?page=manage_movies" class="action-card">
            <div class="action-icon">
                <img src="../../assets/icons/film.svg" alt="Manage Movies">
            </div>
            <h3>Manage Movies</h3>
            <p>Search, delete movies or add discounts</p>
        </a>
    </div>
</div>
