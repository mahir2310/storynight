<?php
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'customer') {
    header("Location: ../login.php");
    exit();
}

$user = $_SESSION['user'];

$pageTitle = "Browse Movies";

// Sample movie data
$movies = [
    [
        'movie_id' => 1,
        'title' => 'The Dark Knight',
        'genre' => 'Action',
        'duration' => 152,
        'hall_name' => 'Main Hall',
        'show_datetime' => '2023-12-20 19:30:00',
        'available_seats' => 45,
        'base_price' => 599,
        'poster' => '../../assets/posters/dark_knight.jpg',
        'booked' => false
    ],
    [
        'movie_id' => 2,
        'title' => 'Inception',
        'genre' => 'Sci-Fi',
        'duration' => 148,
        'hall_name' => 'IMAX Hall',
        'show_datetime' => '2023-12-22 20:00:00',
        'available_seats' => 78,
        'base_price' => 599,
        'poster' => '../../assets/posters/inception.jpg',
        'booked' => true,
        'booking_id' => 101
    ],
    [
        'movie_id' => 3,
        'title' => 'The Shawshank Redemption',
        'genre' => 'Drama',
        'duration' => 142,
        'hall_name' => 'VIP Hall',
        'show_datetime' => '2023-12-25 18:00:00',
        'available_seats' => 12,
        'base_price' => 699,
        'poster' => '../../assets/posters/shawshank.jpg',
        'booked' => false
    ]
];
?>

<link rel="stylesheet" href="../../assets/styles/browse_movies.css">

<div class="dashboard-header">
    <h1>Browse Movies</h1>
    <p>Discover and book your favorite movies</p>
</div>

<div class="dashboard-section">
    <div class="search-container">
        <input type="text" id="movieSearch" placeholder="Search movies..." class="search-input">
    </div>
    
    <div class="movies-grid">
        <?php foreach ($movies as $movie): ?>
        <div class="movie-card">
            <div class="movie-poster">
                <img src="<?php echo $movie['poster']; ?>" alt="<?php echo htmlspecialchars($movie['title']); ?>"
                onerror="this.src='../../assets/imgs/poster.png';">
                <?php if ($movie['available_seats'] == 0): ?>
                    <div class="sold-out">Sold Out</div>
                <?php endif; ?>
            </div>
            
            <div class="movie-info">
                <h3><?php echo htmlspecialchars($movie['title']); ?></h3>
                <p class="movie-genre"><?php echo htmlspecialchars($movie['genre']); ?> • <?php echo $movie['duration']; ?> min</p>
                
                <div class="movie-details">
                    <p><strong>Hall:</strong> <?php echo htmlspecialchars($movie['hall_name']); ?></p>
                    <p><strong>Date:</strong> <?php echo date('M j, Y', strtotime($movie['show_datetime'])); ?></p>
                    <p><strong>Time:</strong> <?php echo date('g:i A', strtotime($movie['show_datetime'])); ?></p>
                    <p><strong>Seats:</strong> <?php echo $movie['available_seats']; ?> available</p>
                </div>
                
                <div class="movie-footer">
                    <span class="price">৳<?php echo number_format($movie['base_price'], 2); ?></span>
                    
                    <div class="movie-actions">
                        <?php if ($movie['booked']): ?>
                            <button class="btn-booked" disabled>Booked</button>
                        <?php elseif ($movie['available_seats'] > 0): ?>
                            <button class="btn-book" 
                                    data-id="<?php echo $movie['movie_id']; ?>"
                                    data-title="<?php echo htmlspecialchars($movie['title']); ?>"
                                    data-price="<?php echo $movie['base_price']; ?>">
                                Book Ticket
                            </button>
                        <?php else: ?>
                            <button class="btn-disabled" disabled>Sold Out</button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- Booking Modal -->
<div id="bookingModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Book Tickets</h2>
        </div>
        <div class="modal-body">
            <p>Movie: <span id="modalMovieTitle"></span></p>
            <p>Price per ticket: $<span id="ticketPrice"></span></p>
            
            <div class="form-group">
                <label>Number of Tickets (Max: 5)</label>
                <input type="number" id="ticketQuantity" min="1" value="1" max="5">
            </div>
            
            <div class="total-price">
                <h3>Total: ৳<span id="totalPrice">0.00</span></h3>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn-cancel">Cancel</button>
            <button class="btn-confirm">Confirm Booking</button>
        </div>
    </div>
</div>

<script src="../../assets/scripts/browse_movies.js"></script>