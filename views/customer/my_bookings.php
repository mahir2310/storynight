<?php
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'customer') {
    header("Location: ../login.php");
    exit();
}

$user = $_SESSION['user'];

$user = $_SESSION['user'];
$pageTitle = "My Bookings";

// Sample booked movies data
$bookedMovies = [
    [
        'movie_id' => 2,
        'title' => 'Inception',
        'genre' => 'Sci-Fi',
        'duration' => 148,
        'hall_name' => 'IMAX Hall',
        'show_datetime' => '2023-12-22 20:00:00',
        'base_price' => 15.99,
        'poster' => '../../assets/posters/inception.jpg',
        'booking_id' => 101,
        'booking_date' => '2023-12-15',
        'seats' => 'A12, A13',
        'total_price' => 31.98
    ],
    [
        'movie_id' => 4,
        'title' => 'The Matrix',
        'genre' => 'Sci-Fi',
        'duration' => 136,
        'hall_name' => 'Main Hall',
        'show_datetime' => '2023-12-24 18:30:00',
        'base_price' => 12.99,
        'poster' => '../../assets/posters/matrix.jpg',
        'booking_id' => 102,
        'booking_date' => '2023-12-16',
        'seats' => 'B7, B8',
        'total_price' => 25.98
    ]
];
?>

<link rel="stylesheet" href="../../assets/styles/browse_movies.css">
<link rel="stylesheet" href="../../assets/styles/my_bookings.css">

<div class="dashboard-header">
    <h1>My Bookings</h1>
    <p>View and manage your movie bookings</p>
</div>

<div class="dashboard-section">
    <div class="search-container">
        <input type="text" id="bookingSearch" placeholder="Search your bookings..." class="search-input">
    </div>

    <div class="movies-grid">
        <?php foreach ($bookedMovies as $movie): ?>
            <div class="movie-card">
                <div class="movie-poster">
                    <img src="<?php echo $movie['poster']; ?>" alt="<?php echo htmlspecialchars($movie['title']); ?>"
                        onerror="this.src='../../assets/imgs/poster.png';">
                </div>

                <div class="movie-info">
                    <h3><?php echo htmlspecialchars($movie['title']); ?></h3>
                    <p class="movie-genre"><?php echo htmlspecialchars($movie['genre']); ?> • <?php echo $movie['duration']; ?> min</p>

                    <div class="movie-details">
                        <p><strong>Hall:</strong> <?php echo htmlspecialchars($movie['hall_name']); ?></p>
                        <p><strong>Date:</strong> <?php echo date('M j, Y', strtotime($movie['show_datetime'])); ?></p>
                        <p><strong>Time:</strong> <?php echo date('g:i A', strtotime($movie['show_datetime'])); ?></p>
                        <p><strong>Seats:</strong> <?php echo $movie['seats']; ?></p>
                        <p><strong>Booked on:</strong> <?php echo date('M j, Y', strtotime($movie['booking_date'])); ?></p>
                    </div>

                    <div class="movie-footer">
                        <span class="price">$<?php echo number_format($movie['total_price'], 2); ?></span>

                        <div class="movie-actions">
                            <button class="btn-print" data-id="<?php echo $movie['booking_id']; ?>">Print Ticket</button>
                            <button class="btn-cancel" data-id="<?php echo $movie['booking_id']; ?>">Cancel Booking</button>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- Cancel Booking Modal -->
<div id="cancelModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Cancel Booking</h2>
        </div>
        <div class="modal-body">
            <p>Are you sure you want to cancel your booking?</p>
        </div>
        <div class="modal-footer">
            <button class="btn-cancel btn-modal">No</button>
            <button class="btn-confirm">Yes, Cancel</button>
        </div>
    </div>
</div>