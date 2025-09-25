<?php
require_once "../../models/MovieModel.php";

$db = new Database();
$pdo = $db->getConnection();
$movieModel = new MovieModel($pdo);

function getAllMovies()
{
    global $movieModel;
    return $movieModel->getAllMovies();
}
