<?php
session_start();
require_once "../models/MovieModel.php";
require_once "cookieController.php";

$db = new Database();
$pdo = $db->getConnection();
$movieModel = new MovieModel($pdo);

$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    checkCookie();

    $title         = $_POST["title"] ?? "";
    $genre         = $_POST["genre"] ?? "";
    $description   = $_POST["description"] ?? "";
    $duration      = $_POST["duration"] ?? "";
    $release_date  = $_POST["release_date"] ?? "";
    $hall_name     = $_POST["hall_name"] ?? "";
    $show_datetime = $_POST["show_datetime"] ?? "";
    $total_seats   = $_POST["total_seats"] ?? "";
    $base_price    = $_POST["base_price"] ?? "";
    $poster        = "";
    $available_seats = $total_seats;

    // Form validation
    if (empty($title)) $errors['title'] = "Title is required";
    if (empty($genre)) $errors['genre'] = "Genre is required";
    if (empty($description)) $errors['description'] = "Description is required";
    if (empty($duration) || $duration <= 0) $errors['duration'] = "Duration must be greater than 0";
    if (empty($release_date)) $errors['release_date'] = "Release date is required";
    if (empty($hall_name)) $errors['hall_name'] = "Hall name is required";
    if (empty($show_datetime)) $errors['show_datetime'] = "Show date & time is required";
    if (empty($total_seats) || $total_seats <= 0) $errors['total_seats'] = "Total seats must be greater than 0";
    if ($base_price === "" || $base_price < 0) $errors['base_price'] = "Base price must be 0 or more";

    // Handle poster upload
    if (isset($_FILES['movie_poster']) && $_FILES['movie_poster']['error'] == 0) {
        $uploadDir = "../uploads/posters/";
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $fileTmp  = $_FILES['movie_poster']['tmp_name'];
        $fileName = time() . "_" . basename($_FILES['movie_poster']['name']);
        $filePath = $uploadDir . $fileName;

        if (move_uploaded_file($fileTmp, $filePath)) {
            // Save path
            $poster = "uploads/posters/" . $fileName;
        } else {
            $errors['poster'] = "Failed to upload poster";
        }
    }

    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        header("Location: ../views/manager/manager_layout.php?page=add_movie");
        exit();
    }

    $result = $movieModel->addMovie(
        $title,
        $description,
        $genre,
        $duration,
        $release_date,
        $hall_name,
        $show_datetime,
        $total_seats,
        $available_seats,
        $base_price,
        $poster
    );

    if ($result['success'] == true) {
        $_SESSION['success'] = $result['message'];
        header("Location: ../views/manager/manager_layout.php?page=add_movie"); 
        exit();
    } else {
        $errors['add_movie'] = $result['message'];
        $_SESSION['errors'] = $errors;
        header("Location: ../views/manager/manager_layout.php?page=add_movie");
        exit();
    }
}
