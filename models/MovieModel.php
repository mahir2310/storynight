<?php
require_once "Database.php";

class MovieModel
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    // Get all movies
    public function getAllMovies()
    {
        $sql = "SELECT * FROM movies ORDER BY created_at DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Add new movie
    public function addMovie($title, $description, $genre, $duration, $release_date, $hall_name, $show_datetime, $total_seats, $available_seats, $base_price, $poster)
    {
        $sql = "INSERT INTO movies 
            (title, description, genre, duration, release_date, hall_name, show_datetime, total_seats, available_seats, base_price, poster) 
            VALUES 
            (:title, :description, :genre, :duration, :release_date, :hall_name, :show_datetime, :total_seats, :available_seats, :base_price, :poster)";
        
        $stmt = $this->pdo->prepare($sql);
        $success = $stmt->execute([
            ':title'         => $title,
            ':description'   => $description,
            ':genre'         => $genre,
            ':duration'      => $duration,
            ':release_date'  => $release_date,
            ':hall_name'     => $hall_name,
            ':show_datetime' => $show_datetime,
            ':total_seats'   => $total_seats,
            ':available_seats'=> $available_seats,
            ':base_price'    => $base_price,
            ':poster'        => $poster
        ]);

        return $success
            ? ['success' => true, 'message' => 'Movie added successfully!']
            : ['success' => false, 'message' => 'Failed to add movie.'];
    }

    // Update discount
    public function updateDiscount($movieId, $discount)
    {
        $sql = "UPDATE movies SET discount = :discount WHERE movie_id = :movie_id";
        $stmt = $this->pdo->prepare($sql);
        $success = $stmt->execute([
            ':discount' => $discount,
            ':movie_id' => $movieId
        ]);

        return $success
            ? ['success' => true, 'message' => 'Discount updated successfully!']
            : ['success' => false, 'message' => 'Failed to update discount.'];
    }

    // Delete movie
    public function deleteMovie($movieId)
    {
        $sql = "DELETE FROM movies WHERE movie_id = :movie_id";
        $stmt = $this->pdo->prepare($sql);
        $success = $stmt->execute([':movie_id' => $movieId]);

        return $success
            ? ['success' => true, 'message' => 'Movie deleted successfully!']
            : ['success' => false, 'message' => 'Failed to delete movie.'];
    }
}
