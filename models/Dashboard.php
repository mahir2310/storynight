<?php
require_once "Database.php";

class Dashboard
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // Customer Dashboard 
    public function customerDashboard($userId)
    {
        try {
            // Count total movies
            $stmt = $this->pdo->prepare("SELECT COUNT(*) AS total_movies FROM movies");
            $stmt->execute();
            $totalMovies = $stmt->fetchColumn();

            // Count total bookings by this user
            $stmt = $this->pdo->prepare("SELECT COUNT(*) AS user_bookings FROM bookings WHERE user_id = :user_id");
            $stmt->execute(['user_id' => $userId]);
            $userBookings = $stmt->fetchColumn();

            // Count upcoming bookings for this user 
            $stmt = $this->pdo->prepare(
                "SELECT COUNT(*) 
                FROM bookings b
                INNER JOIN movies m ON b.movie_id = m.movie_id
                WHERE b.user_id = :user_id AND m.show_datetime > NOW()"
            );
            $stmt->execute(['user_id' => $userId]);
            $upcomingBookings = $stmt->fetchColumn();

            return [
                'total_movies' => (int)$totalMovies,
                'my_bookings' => (int)$userBookings,
                'upcoming_bookings' => (int)$upcomingBookings
            ];
        } catch (Exception $e) {
            return [
                'error' => true,
                'message' => $e->getMessage()
            ];
        }
    }

    // Management dashboard 
    public function manageDashboard()
    {
        try {
            // Total movies
            $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM movies");
            $stmt->execute();
            $totalMovies = $stmt->fetchColumn();

            // Upcoming movies shows
            $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM movies WHERE show_datetime > NOW()");
            $stmt->execute();
            $upcomingMovies = $stmt->fetchColumn();

            // Total sales 
            $stmt = $this->pdo->prepare("SELECT COALESCE(SUM(price), 0) FROM bookings");
            $stmt->execute();
            $totalSales = $stmt->fetchColumn();

            // Total tickets sold
            $stmt = $this->pdo->prepare("SELECT COALESCE(SUM(tickets), 0) FROM bookings");
            $stmt->execute();
            $totalTickets = $stmt->fetchColumn();

            return [
                'total_movies'   => (int)$totalMovies,
                'upcoming_movies'=> (int)$upcomingMovies,
                'total_sales'    => (float)$totalSales,
                'total_tickets'  => (int)$totalTickets
            ];
        } catch (Exception $e) {
            return [
                'error' => true,
                'message' => $e->getMessage()
            ];
        }
    }

    public function adminDashboard()
    {
        try {
            // Total users
            $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM users");
            $stmt->execute();
            $totalUsers = $stmt->fetchColumn();

            // Customers
            $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM users WHERE role = 'customer'");
            $stmt->execute();
            $totalCustomers = $stmt->fetchColumn();

            // Managers
            $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM users WHERE role = 'manager'");
            $stmt->execute();
            $totalManagers = $stmt->fetchColumn();

            // Banned users
            $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM users WHERE status = 'banned'");
            $stmt->execute();
            $bannedUsers = $stmt->fetchColumn();

            return [
                'total_users'   => (int)$totalUsers,
                'total_customers'     => (int)$totalCustomers,
                'total_managers'      => (int)$totalManagers,
                'banned_users'  => (int)$bannedUsers
            ];
        } catch (Exception $e) {
            return [
                'error'   => true,
                'message' => $e->getMessage()
            ];
        }
    }
}
