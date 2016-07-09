<?php
	session_start();
	require_once( "config.php" );

	$fb = new Facebook\Facebook( array(
			'app_id' => APP_ID ,
			'app_secret' => APP_SECRET,
			'default_graph_version' => 'v2.6'
		  ) );
		  
	$_SESSION['loginStatus']='forced';
	$permissions = array( "public_profile" , "user_friends" , "user_location" , "user_photos" , "user_tagged_places" );
	$helper = $fb->getRedirectLoginHelper();
	$loginUrl = $helper->getLoginUrl( 'https://localhost/people_recommender_test/accessHandler.php' , $permissions );
	
	//Redirection link output
	echo $loginUrl;
?>