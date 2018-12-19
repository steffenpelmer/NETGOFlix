<?php 

    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/database.php';
    include_once '../../models/genre.php';

    // DB Instanz
    $database = new Database();
    $db = $database->connect();

    // Genre Instanz
    $genre = new Genre($db);

    // Wurde eine ID Übergeben?
    $genre->id = isset($_GET['id']) ? $_GET['id'] : die();

    // Genre-Daten
    $genre->GetSingle();

    $dataArr = array(
        'id' => $genre->id,
        'name' => utf8_encode($genre->name)
    );

    // JSON Format
    echo json_encode($dataArr);
?>