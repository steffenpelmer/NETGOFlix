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
				<li><a href="index.php">Start</a></li>
				<li><a href="movies.php">Filme</a></li>
				<li><a href="edit.php">Verwaltung</a></li>
				<li><a href="search.php">Suche</a></li>
				<li class="selected"><a href="users.php">Benutzer</a></li>
			</ul>
		</div>
		
		<div id="content">
			<h1>Benutzer wechseln</h1>
			
				<?php 
				    require 'functions.php';
				    
				    $id="";
				    if(isset($_REQUEST['optradio']))
				        $id = $_REQUEST['optradio'];
				    
				    $database = new Database();
				    $db = $database->connect();
				    
				    if($id != "")
				    {
				        $activ = new User($db);
				        $activ->id = $id;
				        $activ->SetActiveUser($id);
				        echo '<script language="javascript">alert("Benutzer wurde gewechselt");</script>';
				    }
				    else
				    {
				        $activ = new User($db);
				        $activ->GetActiveUser();
				    }
				    
				    $u = new User($db);
				    $data = $u->GetAll();
				    echo PrintUser($data, $activ->id);
				?>
		</div>
		
		<div id="footer">
			<?php include "footer.php" ?>
		</div>
		
	</div>
</body>

</html>