<?php
	session_start();
	require_once( "config.php" );
	
	define( "AUTH_REQUIRED" , "authentication_required");
	define( "AUTHENTICATED" , "authenticated");

	$fb = new Facebook\Facebook( array(
			'app_id' => APP_ID ,
			'app_secret' => APP_SECRET,
			'default_graph_version' => 'v2.6'
		  ) );
		  
 	//echo '<h4>$_GET[ "loginStatus"]: </h4>'.$_GET['loginStatus'];
	$_SESSION['loginStatus'] = $_GET['loginStatus'];
	if( $_GET['loginStatus'] == "unknown" ){
		
		if( isset( $_SESSION['fb_access_token'] ) ){
			//If the access token is unset in this step, then every script loaded directly
			//in index.php would see the access token, so the unset in this case does not prevent
			//user data information retrivial (reason: loaded at the end of page loading)
			//This happens in: Connect to Facebook --> Log Out --> Page Reload
			//So login.php MUST RUN before every possible access token use
			//echo "<h4>There's an access token, unset it</h4>";
			unset( $_SESSION['fb_access_token'] );
		}
		
		echo AUTH_REQUIRED;
	}else{
		if( $_GET['loginStatus'] == "connected" ){
			//echo "<h1>FB Login Status: Connected!</h1>";
			if( isset( $_SESSION['fb_access_token'] ) ){
				//echo "login.php <b>see</b> access token.";
				echo AUTHENTICATED;
			}else{
				//The application send connected but there's no access token set
				//so this would be a potential corrupted request
				//follow normal flow!
				//echo "login.php <b>don't see</b> access token.";
				//loginLinkOutput($fb);
				echo AUTH_REQUIRED;
			}
		}else{ // not_authorized
			echo "<h1>FB Login Status: Not Authorized</h1>";
		}
	}
?>