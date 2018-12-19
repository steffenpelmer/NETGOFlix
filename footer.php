<?php 
    
    $database = new Database();
    $db = $database->connect();
    
    $u = new User($db);

    $u->GetActiveUser();
    if(isset($u))
        echo "<p>Aktiver Benutzer: ".$u->name." ".$u->lastname."</p>";
    else
        echo "<p>Aktiver Benutzer: Keiner</p>";
?>