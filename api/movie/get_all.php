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
    
    // Film-Daten
    $result = $movie->GetAll();

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
                'name' => utf8_encode($name),
                'year' => $year,
                'fsk' => $fsk,
                'rating' => $rating,
                'duration' => $duration,
                'keyGenre1' => $keyGenre1,
                'keyGenre2' => $keyGenre2
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