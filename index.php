<html>

<head>
	<title>NETGOFlix</title>
	
	<meta name="description" content="Probearbeit für Anwendungsentwickler" />
	<meta name="kewords" content="netgoflix, netgo flix, movies" />
	<meta http-equiv="Content-Type" content="text/html" charset="utf-8" />
	
	<link rel="stylesheet" type="text/css" href="style/style.css" />
</head>

<body>
	<div id="main">
		<?php include "header.php" ?>
		
		<div id="menubar">
			<ul id="menu">
				<li class="selected"><a href="index.php">Start</a></li>
				<li><a href="movies.php">Filme</a></li>
				<li><a href="edit.php">Verwaltung</a></li>
				<li><a href="search.php">Suche</a></li>
				<li><a href="users.php">Benutzer</a></li>
			</ul>
		</div>
		
		<div id="content">
			<h1>Willkommen bei NETGOFlix</h1>
			
				<?php 
                    include 'functions.php';
				?>
		</div>
		
		<div id="footer">
			<?php include "footer.php" ?>
		</div>
		
	</div>
</body>

</html>