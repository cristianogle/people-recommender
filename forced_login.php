<?php
	session_start();
	require_once( "config.php" );

	$fb = new Facebook\Facebook( array(
			'app_id' => APP_ID ,
			'app_secret' => APP_SECRET,
			'default_graph_version' => 'v2.6'
		  ) );	  
		  
	$_SESSION['loginStatus']='forced';
	$permissions = array( "public_profile" , 
	                      "user_friends" , 
	                      "user_location" , 
	                      "user_photos" , 
	                      "user_tagged_places" , 
	                      "publish_actions" );
	$helper = $fb->getRedirectLoginHelper();
	 
	$serverAddr = $_SERVER['SERVER_ADDR'] == "::1" || $_SERVER['SERVER_ADDR'] == "127.0.0.1" ? 'localhost' : $_SERVER['SERVER_ADDR'];
	 
	$loginUrl = $helper->getLoginUrl( 'https://'.$serverAddr.'/people_recommender_test/accessHandler.php' , $permissions );
	
	echo json_encode( array( "fbLoginUrl" => $loginUrl ,  "serverAddr" => $serverAddr ) );
	
	//Redirection link output
	//echo $loginUrl;
?>