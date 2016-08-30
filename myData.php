<?php
	header( "Content-Type: application/json" );
	session_start();
	require_once( "config.php" );
	
	if( isset( $_SESSION['fb_access_token'] ) ){
		//echo "<h3>MyData.php<br/>Session Access Token:</h3>";
		//echo $_SESSION['fb_access_token'];
		
		
		$fb = new Facebook\Facebook( array(
			'app_id' => APP_ID,
			'app_secret' => APP_SECRET,
			'default_graph_version' => 'v2.6'
		) );
		
		
		
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
		
		if( !isset( $_SESSION['user_id'] ) || $_SESSION['user_id'] != $graphNode['id'] ){
			$_SESSION['user_id'] = $graphNode['id'];
		}
		
		$userData = array( "id" => $graphNode['id'] ,
						   "name" => $graphNode['name'] ,
		 			       "picture" => $imgSrc = 'https://graph.facebook.com/'.$graphNode['id'].'/picture?type=square' );
		echo json_encode( $userData );
	}else{
		echo json_encode( array( "error" => "No access Token" ) );
	}
?>