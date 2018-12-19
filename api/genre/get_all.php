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

    // Genre-Daten
    $result = $genre->GetAll();

    // Daten zählen
    $count = $result->rowCount();

    // Daten vorhanden?
    if($count > 0)
    {
        $dataArr = array();
        $dataArr['data'] = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC))
        {
            extract($row);
            $item = array(
                'id' => $id,
                'name' => utf8_encode($name)
            );
            
            // an Array hängen
            array_push($dataArr['data'], $item);
        }

        // JSON Format
        echo json_encode($dataArr);
    }
    else
    {
        // Keine Daten!
        echo json_decode(
            array('message' => 'Keine Post Daten')
        );
    }
?>