<?php
	session_start();
	require_once( "config.php" );
	require_once( "resources/lang.php" );
?>

<!DOCTYPE html>
<html>
	<head>
		<title>People Recommender</title>
		<meta http-equiv="X-UA-Compatible" content="IE=Edge"/>
		<meta charset="UTF-8"/>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">
		<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
		<link href="css/select2-bootstrap.min.css" rel="stylesheet" />
		<link rel="stylesheet" href="css/check.css">
		<link rel="stylesheet" href="css/style.css">
		<link rel="stylesheet" href="css/sections.css">
		<link rel="stylesheet" href="css/popup.css">
	</head>
	
	<body>
		<!-- LOGO BAR -->
		<div id="logo-bar">
			<div id="logo"></div>
			<div id="lang-dropdown" class="dropdown pull-right">
			  <button class="btn btn-default btn-sm dropdown-toggle" type="button" id="lang-button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
	    	      IT
		  	  	  <span class="caret"></span>
			  </button>
	  		  <ul class="dropdown-menu" aria-labelledby="lang-button" onclick="clearCheckForm()">
		    	  <li><a href="#">IT</a></li>
			      <li><a href="#">EN</a></li>
	    	      <li><a href="#">FR</a></li>
		    	  <li><a href="#">ES</a></li>
	  		  </ul>
			</div>
		</div>
		<!-- END LOGO BAR -->
		
		<!-- USER BAR -->
		<div id="user-bar">
		    <?php include 'resources/header/check.php' ?>
		    <?php include 'resources/header/sections.php' ?>		
		</div>
		
		<div id="content-wrapper">
		</div>
		
		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
		<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"   integrity="sha256-xNjb53/rY+WmG+4L6tTl9m6PpqknWZvRt0rO1SRnJzw="   crossorigin="anonymous"></script>  
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
		<script src="login.js" ></script>
		<script src="js/sections.js"></script>
		<script src="js/check.js"></script>
		<script src="js/friends.js"></script>
		<script src="js/check-places.js"></script>
		<script src="publish.js"></script>
		<script src="popup.js"></script>
	</body>
</html>

