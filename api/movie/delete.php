<?php 

    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: DELETE');

    include_once '../../config/database.php';
    include_once '../../models/movie.php';

    // DB Instanz
    $database = new Database();
    $db = $database->connect();

    // Film Instanz
    $movie = new Movie($db);

    // Row-Daten
    $data = json_decode(file_get_contents("php://input"));

    // id setzen
    $movie->id = $data->id;

    // Film l�schen
    if($movie->Delete())
    {
        echo json_encode(
            array('message' => 'Film gelöscht')
        );
    }
    else
    {
        echo json_encode(
            array('message' => 'Film nicht gelöscht')
        );
    }
?>