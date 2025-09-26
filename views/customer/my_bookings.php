<?php
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'customer') {
    header("Location: ../login.php");
    exit();
}

$user = $_SESSION['user'];

$user = $_SESSION['user'];
$pageTitle = "My Bookings";

require_once __DIR__ . "/../../controllers/getBookingsController.php";

$bookedMovies = getMyBookings($user['user_id']) ?? [];
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
                    <img src="../../<?php echo $movie['poster']; ?>" alt="<?php echo htmlspecialchars($movie['title']); ?>"
                        onerror="this.src='../../assets/imgs/poster.png';">
                </div>

                <div class="movie-info">
                    <h3><?php echo htmlspecialchars($movie['title']); ?></h3>
                    <p class="movie-genre"><?php echo htmlspecialchars($movie['genre']); ?> • <?php echo $movie['duration']; ?> min</p>

                    <div class="movie-details">
                        <p><strong>Hall:</strong> <?php echo htmlspecialchars($movie['hall_name']); ?></p>
                        <p><strong>Date:</strong> <?php echo date('M j, Y', strtotime($movie['show_datetime'])); ?></p>
                        <p><strong>Time:</strong> <?php echo date('g:i A', strtotime($movie['show_datetime'])); ?></p>
                        <p><strong>Seats:</strong> <?php echo $movie['tickets']; ?></p>
                        <p><strong>Booked on:</strong> <?php echo date('M j, Y', strtotime($movie['booking_date'])); ?></p>
                    </div>

                    <div class="movie-footer">
                        <span class="price">Taka<?php echo number_format($movie['base_price'] * $movie['tickets'], 2); ?></span>

                        <div class="movie-actions">
                            <button class="btn-print" data-id="<?php echo $movie['booking_id']; ?>" >Print Ticket</button>
                            <button class="btn-cancel" data-id="<?php echo $movie['booking_id']; ?>" data-mid="<?php echo $movie['movie_id']; ?>">Return Tickets</button>
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

<script src="../../assets/scripts/my_bookings.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="../../assets/scripts/print_ticket.js"></script>