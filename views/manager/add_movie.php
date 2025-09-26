<?php
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'manager') {
    header("Location: ../login.php");
    exit();
}

$user = $_SESSION['user'];

?>

<link rel="stylesheet" href="../../assets/styles/add_movie.css">

<div class="dashboard-header">
    <h1>Add New Movie</h1>
    <p>Fill in the details below to add a new movie to the system</p>
</div>

<div class="dashboard-section">
    <form id="addMovieForm" action="../../controllers/addMovies.php"  method="POST" enctype="multipart/form-data">
        <div class="form-row">
            <div class="form-group">
                <label for="title" class="form-label">Movie Title *</label>
                <input type="text" id="title" name="title" class="form-control" required>
            </div>
            
            <div class="form-group">
                <label for="genre" class="form-label">Genre *</label>
                <select id="genre" name="genre" class="form-control" required>
                    <option value="">Select Genre</option>
                    <option value="Action">Action</option>
                    <option value="Comedy">Comedy</option>
                    <option value="Drama">Drama</option>
                    <option value="Horror">Horror</option>
                    <option value="Sci-Fi">Sci-Fi</option>
                    <option value="Romance">Romance</option>
                    <option value="Thriller">Thriller</option>
                    <option value="Animation">Animation</option>
                    <option value="Documentary">Documentary</option>
                </select>
            </div>
        </div>
        
        <div class="form-group">
            <label for="description" class="form-label">Description *</label>
            <textarea id="description" name="description" class="form-control" rows="4" required></textarea>
        </div>
        
        <div class="form-row">
            <div class="form-group">
                <label for="duration" class="form-label">Duration (minutes) *</label>
                <input type="number" id="duration" name="duration" class="form-control" min="1" required>
            </div>
            
            <div class="form-group">
                <label for="release_date" class="form-label">Release Date *</label>
                <input type="date" id="release_date" name="release_date" class="form-control" required>
            </div>
        </div>
        
        <div class="form-row">
            <div class="form-group">
                <label for="hall_name" class="form-label">Hall Name *</label>
                <select id="hall_name" name="hall_name" class="form-control" required>
                    <option value="">Select Hall</option>
                    <option value="Main Hall">Main Hall</option>
                    <option value="VIP Hall">VIP Hall</option>
                    <option value="3D Hall">3D Hall</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="show_datetime" class="form-label">Show Date & Time *</label>
                <input type="datetime-local" id="show_datetime" name="show_datetime" class="form-control" required>
            </div>
        </div>
        
        <div class="form-row">
            <div class="form-group">
                <label for="total_seats" class="form-label">Total Seats *</label>
                <input type="number" id="total_seats" name="total_seats" class="form-control" min="1" required>
            </div>
            
            <div class="form-group">
                <label for="base_price" class="form-label">Base Price  (৳)*</label>
                <input type="number" id="base_price" name="base_price" class="form-control" min="0" step="0.01" required>
            </div>
        </div>
        
        <div class="form-group">
            <label for="movie_poster" class="form-label">Movie Poster</label>
            <input type="file" id="movie_poster" name="movie_poster" class="form-control" accept="image/*">
        </div>
        
        <button type="submit" class="btn">Add Movie</button>
    </form>
</div>