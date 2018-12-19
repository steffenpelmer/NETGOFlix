<?php 

    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');

    include_once '../../config/database.php';
    include_once '../../models/genre.php';

    // DB Instanz
    $database = new Database();
    $db = $database->connect();

    // Film Instanz
    $genre = new Genre($db);

    // Row-Daten
    $data = json_decode(file_get_contents("php://input"));

    $genre->name = $data->name;

    // Film anlegen
    if($genre->Create())
    {
        echo json_encode(
            array('message' => 'Genre angelegt')
        );
    }
    else
    {
        echo json_encode(
            array('message' => 'Genre nicht angelegt')
        );
    }
?>