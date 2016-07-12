<?php
	session_start();
	require_once( 'config.php' );
	
	define( "PRIVACY_PUBLIC" , "public-visibility" );
	define( "PRIVACY_FRIENDS" , "friends-visibility" );
	define( "PRIVACY_ME" , "me-visibility" );
	
	$fb = new Facebook\Facebook( array(
			'app_id' => APP_ID ,
			'app_secret' => APP_SECRET,
			'default_graph_version' => 'v2.6'
		  ) );
		  
	$applicationResponse = array( "published" => false , "message" => "" );  
	if( isset( $_SESSION['fb_access_token'] ) ){
		$request = $fb->request( 'POST' , '/me/feed' );
		$request->setAccessToken( $_SESSION['fb_access_token'] );
		
		try{
			$request->setParams( mapPostParameters() );
		}catch( Exception $ex ){
			echo json_encode( $ex->getMessage() ); 
			exit;
		}
		
		try {
		  $response = $fb->getClient()->sendRequest($request);
		  $applicationResponse['published'] = true;
		} catch(Facebook\Exceptions\FacebookResponseException $e) {
		  // When Graph returns an error
		  $applicationResponse['published'] = false;
		  $applicationResponse['message'] = 'Graph returned an error: ' . $e->getMessage();
		  echo json_encode( $applicationResponse );
		  exit;
		} catch(Facebook\Exceptions\FacebookSDKException $e) {
		  // When validation fails or other local issues
		  $applicationResponse['published'] = false;
		  $applicationResponse['message'] = 'Facebook SDK returned an error: ' . $e->getMessage();
		  echo json_encode( $applicationResponse );
		  exit;
		}		
		
		echo json_encode( $applicationResponse );
	}else{
		$applicationResponse['published'] = false;
		$applicationResponse['message'] = "No access token";
		
		echo json_encode( $applicationResponse );
	}

	function mapPostParameters(){
		$parameters = array();
		
		if( isset( $_POST['message'] ) )
			$parameters['message'] = $_POST['message'];
		
		if( isset( $_POST['tags'] ) ){
			$tags = "";
			foreach( $_POST['tags'] as $tag )
				$tags .= $tag.',';
		
			$parameters['tags'] = substr( $tags , 0 , strlen($tags) - 1 );
		} 
		
		if( isset( $_POST['place'] ) ){
			$parameters['place'] = $_POST['place'];
		}else{
			throw new Exception( 'Could not publish post - Missing POST parameter: place' );
		}
		
		if( isset( $_POST['privacy'] ) ){
			if( $_POST['privacy'] == PRIVACY_PUBLIC )
				$privacy = 'EVERYONE';
			elseif( $_POST['privacy'] == PRIVACY_FRIENDS )
				$privacy = 'ALL_FRIENDS';
			elseif( $_POST['privacy'] == PRIVACY_ME )
				$privacy = 'SELF';
			
			$parameters['privacy'] = "{value:'".$privacy."'}";
		}else{
			throw new Exception( 'Could not publish post - Missing POST parameter: privacy' );
		}
		
		return $parameters;
	}
?>