<?php
	require_once( "resources/lang.php" );
?>

<!DOCTYPE html>
<html>
	<head>
		<title>People Recommender</title>
		<meta http-equiv="X-UA-Compatible" content="IE=Edge"/>
		<meta charset="UTF-8"/>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
		<link rel="stylesheet" href="css/style.css">
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
	  		  <ul class="dropdown-menu" aria-labelledby="lang-button">
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
			<div id="fast-check-wrapper">
				
			</div>
			<nav id="sections-nav">
				<div class="section-tab active">Suggestions</div>
				<div class="section-tab">My Profile</div>
				<div class="section-tab">Help</div>
			</nav>
		</div>
		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script> 
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
	</body>
</html>