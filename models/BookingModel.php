<?php
require_once "Database.php";

class BookingModel
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // Add booking with tickets count
    public function addBooking($userId, $movieId, $tickets,$totalPrice)
    {
        try {
            $this->pdo->beginTransaction();

            // Check if seats are available
            $stmt = $this->pdo->prepare("SELECT available_seats FROM movies WHERE movie_id = :movie_id FOR UPDATE");
            $stmt->execute(['movie_id' => $movieId]);
            $movie = $stmt->fetch();

            if (!$movie || $movie['available_seats'] < $tickets) {
                $this->pdo->rollBack();
                return ['success' => false, 'message' => 'Not enough available seats'];
            }

            // Check if user already has booked the movie
            $stmt = $this->pdo->prepare(
                "SELECT tickets FROM bookings WHERE user_id = :user_id AND movie_id = :movie_id"
            );
            $stmt->execute([
                'user_id' => $userId,
                'movie_id' => $movieId
            ]);
            $existingBooking = $stmt->fetch();

            if ($existingBooking) {
                // Update ticket count
                $oldTickets = $existingBooking['tickets'];

                // Adjust available seats
                $adjustSeats = $oldTickets - $tickets;
                $stmt = $this->pdo->prepare(
                    "UPDATE movies 
                 SET available_seats = available_seats + :adjust 
                 WHERE movie_id = :movie_id"
                );
                $stmt->execute([
                    'adjust' => $adjustSeats,
                    'movie_id' => $movieId
                ]);

                // Update booking with new tickets & price
                $stmt = $this->pdo->prepare(
                    "UPDATE bookings 
                 SET tickets = :tickets, price = :price,booked_at = NOW() 
                 WHERE user_id = :user_id AND movie_id = :movie_id"
                );
                $stmt->execute([
                    'tickets' => $tickets,
                    'price' => $totalPrice,
                    'user_id' => $userId,
                    'movie_id' => $movieId
                ]);
            } else {
                // Insert new booking with price
                $stmt = $this->pdo->prepare(
                    "INSERT INTO bookings (user_id, movie_id, tickets, price,booked_at) 
                 VALUES (:user_id, :movie_id, :tickets,:price, NOW())"
                );
                $stmt->execute([
                    'user_id' => $userId,
                    'movie_id' => $movieId,
                    'tickets' => $tickets,
                    'price' => $totalPrice
                ]);

                // Decrease available seats
                $stmt = $this->pdo->prepare(
                    "UPDATE movies 
                 SET available_seats = available_seats - :tickets 
                 WHERE movie_id = :movie_id"
                );
                $stmt->execute([
                    'tickets' => $tickets,
                    'movie_id' => $movieId
                ]);
            }

            $this->pdo->commit();
            return ['success' => true, 'message' => "Booked $tickets ticket(s) successfully"];
        } catch (Exception $e) {
            $this->pdo->rollBack();
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }


    // Remove booking
    public function removeBooking($userId, $movieId)
    {
        try {
            $this->pdo->beginTransaction();

            // Get tickets count
            $stmt = $this->pdo->prepare(
                "SELECT tickets FROM bookings WHERE user_id = :user_id AND movie_id = :movie_id"
            );
            $stmt->execute([
                'user_id' => $userId,
                'movie_id' => $movieId
            ]);
            $booking = $stmt->fetch();

            if (!$booking) {
                $this->pdo->rollBack();
                return ['success' => false, 'message' => 'No booking found'];
            }

            $tickets = $booking['tickets'];

            // Delete booking row
            $stmt = $this->pdo->prepare(
                "DELETE FROM bookings WHERE user_id = :user_id AND movie_id = :movie_id"
            );
            $stmt->execute([
                'user_id' => $userId,
                'movie_id' => $movieId
            ]);

            // Restore available seats
            $stmt = $this->pdo->prepare(
                "UPDATE movies 
                 SET available_seats = available_seats + :tickets 
                 WHERE movie_id = :movie_id"
            );
            $stmt->execute([
                'tickets' => $tickets,
                'movie_id' => $movieId
            ]);

            $this->pdo->commit();
            return ['success' => true, 'message' => "Cancelled booking of $tickets ticket(s)"];
        } catch (Exception $e) {
            $this->pdo->rollBack();
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    // Get all booked movies for a user
    public function getUserBookings($userId)
    {
        $stmt = $this->pdo->prepare(
            "SELECT b.booking_id, b.movie_id, b.tickets, b.booked_at
         FROM bookings b
         WHERE b.user_id = :user_id"
        );
        $stmt->execute(['user_id' => $userId]);
        $bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $bookedMovies = [];
        foreach ($bookings as $booking) {
            $stmt = $this->pdo->prepare(
                "SELECT movie_id, title, description, genre, duration, release_date, hall_name,
                    show_datetime, total_seats, available_seats, base_price, created_at, poster, discount
             FROM movies 
             WHERE movie_id = :movie_id"
            );
            $stmt->execute(['movie_id' => $booking['movie_id']]);
            $movie = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($movie) {
                $movie['booking_id'] = $booking['booking_id'];
                $movie['tickets'] = $booking['tickets'];
                $movie['booking_date'] = $booking['booked_at'];
                $bookedMovies[] = $movie;
            }
        }

        return $bookedMovies;
    }
}
