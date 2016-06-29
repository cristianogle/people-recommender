<?php
	session_start();

	require_once( "config.php" );

	$fb = new Facebook\Facebook( array(
			'app_id' => APP_ID ,
			'app_secret' => APP_SECRET,
			'default_graph_version' => 'v2.6'
		  ) );

	//if( !isset($_SESSION['fb_access_token'] ) ){
	$permissions = array( "public_profile" , "user_friends" , "user_location" );
	$helper = $fb->getRedirectLoginHelper();
	$loginUrl = $helper->getLoginUrl( 'https://localhost/people_recommender_test/accessHandler.php' , $permissions );
	
	//Redirection link output
	echo '<a href="'.htmlspecialchars( $loginUrl ).'">Log in with Facebook!</a>';
	echo '<br><br>'.$loginUrl;
	/*}else{
		//User has already an access token
		echo "<b>Has already an access token</b>";
		
		//Tryng retrieve user data to validate login
		$request = $fb->request('GET', '/me');
		$request->setAccessToken( $_SESSION['fb_access_token'] );
		
		// Send the request to Graph
		try {
		  $response = $fb->getClient()->sendRequest($request);
		} catch(Facebook\Exceptions\FacebookResponseException $e) {
		  // When Graph returns an error
		  echo 'Graph returned an error: ' . $e->getMessage();
		  exit;
		} catch(Facebook\Exceptions\FacebookSDKException $e) {
		  // When validation fails or other local issues
		  echo 'Facebook SDK returned an error: ' . $e->getMessage();
		  exit;
		}
		
		$graphNode = $response->getGraphNode();
		
		echo '<br><br><br>ID: '.$graphNode['id'];
	}*/
?>