<html>

<head>
	<title>NETGOFlix</title>
	
	<meta name="description" content="Probearbeit für Anwendungsentwickler" />
	<meta name="kewords" content="netgoflix, netgo flix, movies" />
	<meta charset="UTF-8">
	
	<link rel="stylesheet" type="text/css" href="style/style.css" />
</head>

<body>
	<div id="main">
		<?php include "header.php" ?>
		
		<div id="menubar">
			<ul id="menu">
				<li><a href="index.php">Start</a></li>
				<li><a href="movies.php">Filme</a></li>
				<li  class="selected"><a href="edit.php">Verwaltung</a></li>
				<li><a href="search.php">Suche</a></li>
				<li><a href="users.php">Benutzer</a></li>
			</ul>
		</div>
		
		<div id="content">
			<?php 
			     header('Content-type: text/html; charset=utf-8'); 
			     include 'functions.php';
			     
			     if(isset($_REQUEST['action']))
			         $action = $_REQUEST['action'];
			     else
			         $action = "";
			     
			     switch ($action)
			     {
			         default:
                            echo '<h1>Film Verwaltung</h1>
                                    <form action="edit.php" method="get">
                                    	<input type="submit" name="action" value="Hinzufügen">
                                    	<input type="submit" name="action" value="Editieren">
                                    	<input type="submit" name="action" value="Löschen">
                                    </form>';
			             break;
			             
			         case 'Hinzufügen':
			             
			             $dropdown1 = '<select name="keyGenre1">'.GetGenreDropdown().'</select>';
			             $dropdown2 = '<select name="keyGenre2">'.GetGenreDropdown().'</select>';		             
			             
			             echo '<h3>Hinzufügen</h3>
                                    <form action="functions.php" method="POST">
                                        <input type="hidden" name="_url" value="V1/movie">
                                    	<label for="name">Name</label><input type="text" name="name" id="name""/><br>
                                    	<label for="year">Jahr</label><input type="text" name="year" id="year""/><br>
                                        <label for="fsk">FSK</label><input type="text" name="fsk" id="fsk""/><br>
                                        <label for="rating">Bewertung</label><input type="text" name="rating" id="rating""/><br>
                                        <label for="duration">Dauer(min)</label><input type="text" name="duration" id="duration""/><br>
                                    	<label for="keyGenre1">Kategorie 1</label>'.$dropdown1.'<br><label for="keyGenre2">Kategorie 2</label>'.$dropdown2.'<br><br>
                                        <input type="submit" name="form" value="Speichern"><br>
                                    </form>';
			             break;
			             
			         case 'Editieren':
			             echo '<h3>Aktualisieren</h3>
                                    <form action="edit.php" method="POST">
                                        <input type="hidden" name="action" value="EditierenShow">
                                        <select name="idMovie">'.GetMoviesDropdown().'</select><br><br>
                                        <input type="submit" name="form" value="Auswählen"><br>
                                    </form>';
			             break;
                    
			         case 'EditierenShow':
			             echo '<h3>Aktualisieren</h3>';
			             
			             if(isset($_REQUEST['idMovie']));
			                 $id = $_REQUEST['idMovie'];
			                 
		                 $dataset = CallApi('movie', 'GET', "id=$id");
			              
		                 $dropdown1 = '<select name="keyGenre1">'.GetGenreDropdown($dataset['keyGenre1']).'</select>';
		                 $dropdown2 = '<select name="keyGenre2">'.GetGenreDropdown($dataset['keyGenre2']).'</select>';
		                 
		                 echo '<form action="functions.php" method="POST">
                                    <input type="hidden" name="_url" value="V1/movie">
                                    <input type="hidden" name="id" value="'.$dataset['id'].'">
                                    <label for="name">Name</label><input type="text" name="name" id="name" value="'.$dataset['name'].'"/><br>
                                    <label for="year">Jahr</label><input type="text" name="year" id="year"value="'.$dataset['year'].'"/><br>
                                    <label for="fsk">FSK</label><input type="text" name="fsk" id="fsk" value="'.$dataset['fsk'].'"/><br>
                                    <label for="rating">Bewertung</label><input type="text" name="rating" id="rating" value="'.$dataset['rating'].'"/><br>
                                    <label for="duration">Dauer(min)</label><input type="text" name="duration" id="duration" value="'.$dataset['duration'].'"/><br>
                                    <label for="keyGenre1">Kategorie 1</label>'.$dropdown1.'<br><label for="keyGenre2">Kategorie 2</label>'.$dropdown2.'<br><br>
                                    <input type="submit" name="form" value="Aktualisieren"><br>
                               </form>';
			             break;
			             
			         case 'Löschen':
			             echo '<h3>Löschen</h3>';
			             
			             echo '<form action="functions.php" method="POST">
                                 <input type="hidden" name="_url" value="V1/movie">
        			             <select name="idMovie">'.GetMoviesDropdown().'</select><br><br>
        			             <input type="submit" name="form" value="Loeschen"><br>
    			               </form>';
			             break;             
			     }
			     
			     if($action != "")
			         echo '<br><br><a href=edit.php >zurück</a>';
			?>
		</div>
		
		<div id="footer">
			<?php include "footer.php" ?>
		</div>
		
	</div>
</body>

</html>

<?php 
    
function GetGenreDropdown($selectedId=-1)
{
    $dataset = CallApi('genre', 'GETALL');
    $data = $dataset['data'];
    $dropdown = "";
    
    if($selectedId!=-1)
        $id = $selectedId;
    else
        $id = 0;
    
    for($i=0; $i < count($data); $i++)
    {
        $s="";
        if($data[$i]['id'] == $id)
            $s = "selected";
            
            $dropdown.= '<option '.$s.' value="'.$data[$i]['id'].'">'.$data[$i]['name'].'</option>';
    }
    return $dropdown;
}

function GetMoviesDropdown()
{
    $dataset = CallApi('movie', 'GETALL');
    $data = $dataset['data'];
    $dropdown = "";
    
    for($i=0; $i < count($data); $i++)
    {
        $s="";
        if($data[$i]['id'] == 0)
            $s = "selected";
            
            $dropdown.= '<option '.$s.' value="'.$data[$i]['id'].'">'.$data[$i]['name'].' ('.$data[$i]['year'].')</option>';
    }
    return $dropdown;
}

?>