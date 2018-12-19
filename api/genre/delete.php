<?php 

    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: DELETE');

    include_once '../../config/database.php';
    include_once '../../models/genre.php';

    // DB Instanz
    $database = new Database();
    $db = $database->connect();

    // Film Instanz
    $genre = new Genre($db);

    // Row-Daten
    $data = json_decode(file_get_contents("php://input"));

    // id setzen
    $genre->id = $data->id;

    // Film löschen
    if($genre->Delete())
    {
        echo json_encode(
            array('message' => 'Genre gelöscht')
        );
    }
    else
    {
        echo json_encode(
            array('message' => 'Genre nicht gelöscht')
        );
    }
?>