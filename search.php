<html>

<head>
	<title>NETGOFlix</title>
	
	<meta name="description" content="Probearbeit für Anwendungsentwickler" />
	<meta name="kewords" content="netgoflix, netgo flix, movies" />
	<meta http-equiv="content-type" content="text/html; charset=windows-1252" />
	
	<link rel="stylesheet" type="text/css" href="style/style.css" />
</head>

<body>
	<div id="main">
		<?php include "header.php" ?>
		
		<div id="menubar">
			<ul id="menu">
				<li><a href="index.php">Start</a></li>
				<li><a href="movies.php">Filme</a></li>
				<li><a href="edit.php">Verwaltung</a></li>
				<li  class="selected"><a href="search.php">Suche</a></li>
				<li><a href="users.php">Benutzer</a></li>
			</ul>
		</div>
		
		<div id="content">
			<h1>Suche</h1>
			<?php 
			     include 'functions.php';
		        			     			     
			     echo '<form name="search" action="search.php" method="POST">
                            <label for="name">Name</label><input type="text" name="name" id="name" required pattern="[a-zA-z0-9-_()]{3,}" oninvalid="this.setCustomValidity(\'mindestens 3 Zeichen\')" oninput="setCustomValidity(\'\')" /><br><br>
                            <input type="submit" name="form" value="Suchen"><br>
                       </form>';
			     
			     if(isset($_REQUEST['name']))
			     {
			         $title = $_REQUEST['name'];
			         $data = Search($title);
			         
			         if(is_array($data))
			             echo PrintMovies($data); 
                     else
                         echo "<h1>$data</h1>";
			                 
			     }
			?>
		</div>
		
		<div id="footer">
			<?php include "footer.php" ?>
		</div>
		
	</div>
</body>

</html>