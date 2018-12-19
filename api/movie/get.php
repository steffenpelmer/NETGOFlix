<?php 

    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/database.php';
    include_once '../../models/movie.php';

    // DB Instanz
    $database = new Database();
    $db = $database->connect();

    // Film Instanz
    $movie = new Movie($db);

    // Wurde eine ID Übergeben?
    $movie->id = isset($_GET['id']) ? $_GET['id'] : die();

    // Film-Daten
    $movie->GetSingle();

    $dataArr = array(
        'id' => $movie->id,
        'name' => utf8_encode($movie->name),
        'year' => $movie->year,
        'fsk' => $movie->fsk,
        'rating' => $movie->rating,
        'duration' => $movie->duration,
        'keyGenre1' => $movie->keyGenre1,
        'keyGenre2' => $movie->keyGenre2

    );

    // JSON Format
    echo json_encode($dataArr);
?>