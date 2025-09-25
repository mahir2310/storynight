<?php
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'manager') {
    header("Location: ../login.php");
    exit();
}

$user = $_SESSION['user'];
$pageTitle = "Manage Movies";

require_once __DIR__ . "/../../controllers/getMovieController.php";

$movies = getAllMovies() ?? [];
?>

<link rel="stylesheet" href="../../assets/styles/manage_movies.css">

<div class="dashboard-header">
    <h1>Manage Movies</h1>
    <p>Search, edit, add discounts or delete movies from the system</p>
</div>

<div class="dashboard-section">
    <div class="search-container">
        <input type="text" id="movieSearch" placeholder="Search movies by title, genre or hall..." class="search-input">
    </div>
    
    <div class="table-container">
        <table class="movies-table">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Genre</th>
                    <th>Duration</th>
                    <th>Hall</th>
                    <th>Show Time</th>
                    <th>Available Seats</th>
                    <th>Price</th>
                    <th>Discount</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($movies as $movie): ?>
                <tr>
                    <td><?php echo htmlspecialchars($movie['title']); ?></td>
                    <td><?php echo htmlspecialchars($movie['genre']); ?></td>
                    <td><?php echo htmlspecialchars($movie['duration']); ?> min</td>
                    <td><?php echo htmlspecialchars($movie['hall_name']); ?></td>
                    <td><?php echo date('M j, Y g:i A', strtotime($movie['show_datetime'])); ?></td>
                    <td><?php echo htmlspecialchars($movie['available_seats']); ?>/<?php echo htmlspecialchars($movie['total_seats']); ?></td>
                    <td>৳<?php echo number_format($movie['base_price'], 2); ?></td>
                    <td>
                        <?php if ($movie['discount'] > 0): ?>
                            <span class="discount-badge"><?php echo $movie['discount']; ?>% off</span>
                        <?php else: ?>
                            <span class="no-discount">None</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <div class="action-buttons">
                            <button class="btn-discount">Add Discount</button>
                            <button class="btn-delete" data-movie-id="<?php echo $movie['movie_id']; ?>" data-movie-title="<?php echo htmlspecialchars($movie['title']); ?>">Delete</button>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Delete Modal -->
<div id="deleteModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Confirm Deletion</h2>
        </div>
        <div class="modal-body">
            <p>Are you sure you want to delete <span id="movieTitle"></span>? This action cannot be undone.</p>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn-cancel">Cancel</button>
            <button type="button" class="btn-confirm-delete">Delete</button>
        </div>
    </div>
</div>

<script src="../../assets/scripts/manage_movies.js"></script>