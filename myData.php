<?php
	session_start();
	
	if( isset( $_SESSION['fb_access_token'] ) ){
		echo "<h3>Session Access Token:</h3>";
		echo $_SESSION['fb_access_token'];
		
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
			
		echo "<h3>Graph Node on Me:</h3>";
		var_dump( $graphNode );
		
		MyClass::test();
	}else{
		echo "<h3>No Access Token</h3>";
	}
	
	/*require_once( "config.php" );
	
	$fb = new Facebook\Facebook( array(
		'app_id' => '511638992294104',
		'app_secret' => 'd785a07c67ebb99933301a5e65dbaff8',
		'default_graph_version' => 'v2.6'
	) );
	
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
		
	var_dump( $graphNode );*/
?>