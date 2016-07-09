<?php
	header( "Content-Type: application/json" );  
	session_start();
	require_once( "config.php" );
	
	$fb = new Facebook\Facebook( array(
			'app_id' => APP_ID ,
			'app_secret' => APP_SECRET,
			'default_graph_version' => 'v2.6'
		  ) );
		  
	if ( isset($_GET['q']) && $_GET['q'] != "" ){
		//If not empty retrieve from /search
		$request = $fb->request( "GET"  , "/search" );
		$request->setAccessToken( $_SESSION['fb_access_token'] );
		$request->setParams( array( 'type' => 'place' , 
					    'q' => $_GET['q'] , 
					    'limit' => 50 ) );
		try{													
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
		
		$graphObj = $response->getGraphEdge()->asArray();
		
		echo json_encode( $graphObj );
	}else{
		//If empty retrieve my tagged places from /my_tagged_places
		$request = $fb->request( "GET" , "/me/tagged_places" );
		$request->setAccessToken( $_SESSION['fb_access_token'] );
		
		try{													
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
		
		$graphObjArray = $response->getGraphEdge()->asArray();
		$myTaggedPlaces = array();
		
		foreach( $graphObjArray as $taggedPlace )
			array_push( $myTaggedPlaces , $taggedPlace['place'] );
		
		echo json_encode( $myTaggedPlaces );
	}
?>
