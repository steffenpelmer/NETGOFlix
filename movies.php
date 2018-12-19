<html>

<head>
	<title>NETGOFlix</title>
	
	<meta name="description" content="Probearbeit f�r Anwendungsentwickler" />
	<meta name="kewords" content="netgoflix, netgo flix, movies" />
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	
	<link rel="stylesheet" type="text/css" href="style/style.css" />
</head>

<body>
	<div id="main">
		<?php include "header.php" ?>
		
		<div id="menubar">
			<ul id="menu">
				<li><a href="index.php">Start</a></li>
				<li  class="selected"><a href="movies.php">Filme</a></li>
				<li><a href="edit.php">Verwaltung</a></li>
				<li><a href="search.php">Suche</a></li>
				<li><a href="users.php">Benutzer</a></li>
			</ul>
		</div>
		
		<div id="content">
			<h1>Ansicht aller Filme</h1>
			
			<?php 
			    include_once 'functions.php';
			    
                $dataset = CallApi('movie', 'GETALL');
                $data = $dataset['data'];
                
                echo PrintMovies($data)."<br><br>";
    			
    			$dataset2 = CallApi('genre', 'GETALL');
    			$data2 = $dataset2['data'];

    			
    			for($i=0; $i < count($data2); $i++)  // Alle Genre
    			{    
    			    $printData = array();
    			        			    
    			    for($j=0; $j < count($data); $j++)   // Alle Filme
    			    {
    			        if($data2[$i]['id'] == $data[$j]['keyGenre1'] || $data2[$i]['id'] == $data[$j]['keyGenre2'])
    			            array_push($printData, $data[$j]);
    			    }
    			    
    			    echo "<p style=\"color:#000; font-size:20px;\">".$data2[$i]['name'].": ".count($printData)."<br>";
    			    echo PrintMovies($printData, $data2[$i]['name']);
    			    echo "</p><br><br>";
    			}
			?>
			
		</div>
		
		<div id="footer">
			<?php include "footer.php" ?>
		</div>
		
	</div>
</body>

</html>