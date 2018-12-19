<?php 

require 'config/database.php';
require 'models/movie.php';
require 'models/user.php';

define("GET", "get.php");
define("GETALL", "get_all.php");
define("INSERT", "create.php");
define("UPDATE", "update.php");
define("DELETE", "delete.php");

$action = "";

if(isset($_REQUEST['form']))
    $action = $_REQUEST['form'];

if(isset($_REQUEST['_url']))
    $table = substr($_REQUEST['_url'], 3); 
    
switch ($action)
{
    case 'Speichern':
        
        $fields = [
        'name' => $_REQUEST['name'],
        'year' => $_REQUEST['year'],
        'fsk' => $_REQUEST['fsk'],
        'rating' => $_REQUEST['rating'],
        'duration' => $_REQUEST['duration'],
        'keyGenre1' => isset($_REQUEST['keyGenre1']) ? $_REQUEST['keyGenre1'] : 0,
        'keyGenre2' => isset($_REQUEST['keyGenre2']) ? $_REQUEST['keyGenre2'] : 0,
        ];
        
        $json = json_encode($fields);
        $result = CallApi($table, 'INSERT', null, $json);
        echo '<script language="javascript">alert("'.$result['message'].'");document.location.href="movies.php";</script>';
        break;

    case 'Aktualisieren':

        $fields = [
        'id' => $_REQUEST['id'],
        'name' => $_REQUEST['name'],
        'year' => $_REQUEST['year'],
        'fsk' => $_REQUEST['fsk'],
        'rating' => $_REQUEST['rating'],
        'duration' => $_REQUEST['duration'],
        'keyGenre1' => isset($_REQUEST['keyGenre1']) ? $_REQUEST['keyGenre1'] : 0,
        'keyGenre2' => isset($_REQUEST['keyGenre2']) ? $_REQUEST['keyGenre2'] : 0,
        ];
        
        $json = json_encode($fields);
        $result = CallApi($table, 'UPDATE', null, $json);
        echo '<script language="javascript">alert("'.$result['message'].'");document.location.href="movies.php";</script>';
        break; 
        
    case 'Loeschen':
        
        $fields = [
        'id' => $_REQUEST['idMovie'],
        ];
        
        $json = json_encode($fields);
        $result = CallApi($table, 'DELETE', null, $json);
        echo '<script language="javascript">alert("'.$result['message'].'");document.location.href="movies.php";</script>';
        break; 
        
    case 'Favorit':
        
}

function CallApi($table, $method, $query=null, $post=null)
{
    $ch = curl_init();
    
    switch ($method)
    {
        case 'GET':
            $page = GET;
            break;
            
        case 'GETALL':
            $page = GETALL;
            $method = 'GET';
            break;
            
        case 'INSERT':
            $page = INSERT;
            $method = 'POST';
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
            break;
            
        case 'UPDATE':
            $page = UPDATE;
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
            break;
            
        case 'DELETE':
            $page = DELETE;
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
            break;
    }
    
    if(isset($query) && $method == 'GET')
        $query = '?'.$query;
        
    curl_setopt($ch, CURLOPT_URL, "localhost/netgoflix/api/".$table."/".$page.$query);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);							        
    
    $data = curl_exec($ch);
    curl_close($ch);
    
    return json_decode($data, true);
}

function PrintMovies($data, $genre = null)
{
    $html = "<table id='$genre' style=\"display:inline;\">";
    $html.= "<th>Name</th><th>Jahr</th><th>FSK</th><th>Bewertung</th><th>Dauer(min)</th><th>Kategorie</th>";
    for($i=0; $i < count($data); $i++)
    {
        $html.= "<tr>";
        $html.= "<td>".$data[$i]['name']."</td>";
        $html.= "<td>".$data[$i]['year']."</td>";
        $html.= "<td>".$data[$i]['fsk']."</td>";
        $html.= "<td>".$data[$i]['rating']."</td>";
        $html.= "<td>".$data[$i]['duration']."</td>";
        
        $genre1 = CallApi('genre', 'GET', 'id='.$data[$i]['keyGenre1']);
        $g1 = $genre1['name'];
        $genre2 = CallApi('genre', 'GET', 'id='.$data[$i]['keyGenre2']);
        $g2 = $genre2['name'];
        $html.= "<td>".$g1.", ".$g2."</td>";
        
        $html.= "</tr>";
    }
    $html.= "</table><br>";
    return $html;
}

function PrintUser($data, $selectedId=-1)
{

    $html = '<form name="change" action="users.php" method="POST"><table>';
    $html.= "<th>Name</th><th>Nachname</th><th>eMail</th><th>Aktiv</th>";
    for($i=0; $i < count($data); $i++)
    {
        if(strcmp($data[$i]['id'], $selectedId)==0)
            $s = 'checked';
        else
            $s= '';
            
        $html.= "<tr>";
        $html.= "<td>".$data[$i]['name']."</td>";
        $html.= "<td>".$data[$i]['lastname']."</td>";
        $html.= "<td>".$data[$i]['email']."</td>";
        $html.= "<td><input type=\"radio\" id=\"us\" name=\"optradio\" value=\"".$data[$i]['id']."\"".$s."></td>";
        $html.= "</tr>";
    }
    $html.= "</table>";
    $html.= '<input type="submit" name="form" value="Wechsel"><br>';
    $html.= "</form><br>";
    return $html;
}

function Search($title)
{
    $database = new Database();
    $db = $database->connect();
    
    // Film Instanz
    $movie = new Movie($db);
    
    // Film-Daten
    $result = $movie->GetSearchByTitle($title);
    
    // Daten zählen
    $count = $result->rowCount();
    
    // Daten vorhanden?
    if($count > 0)
    {
        $dataArr = array();
        
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
            array_push($dataArr, $item);
        }
        
        // JSON Format
        return $dataArr;
    }
    else
    {
        // Keine Daten!
        return 'Keine Daten gefunden';
    }
}

?>