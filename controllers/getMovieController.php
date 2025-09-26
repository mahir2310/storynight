<?php
require_once "../../models/MovieModel.php";
require_once "cookieController.php";

$db = new Database();
$pdo = $db->getConnection();
$movieModel = new MovieModel($pdo);

function getAllMovies()
{
    checkCookie();
    global $movieModel;
    return $movieModel->getAllMovies();
}
