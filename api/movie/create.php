<?php 

    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');

    include_once '../../config/database.php';
    include_once '../../models/movie.php';

    // DB Instanz
    $database = new Database();
    $db = $database->connect();

    // Film Instanz
    $movie = new Movie($db);

    // Row-Daten
    $data = json_decode(file_get_contents("php://input"));
    
    $movie->name = $data->name;
    $movie->year = $data->year;
    $movie->fsk = $data->fsk;
    $movie->rating = $data->rating;
    $movie->duration = $data->duration;
    $movie->keyGenre1 = $data->keyGenre1;
    $movie->keyGenre2 = $data->keyGenre2;

    // Film anlegen
    if($movie->Create())
    {
        echo json_encode(
            array('message' => 'Film angelegt')
        );
    }
    else
    {
        echo json_encode(
            array('message' => 'Film nicht angelegt')
        );
    }
?>