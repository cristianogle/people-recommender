<?php
	session_start();
	
	if( isset( $_SESSION['fb_access_token'] ) ){
		
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
			
		$imgSrc = 'https://graph.facebook.com/'.$graphNode['id'].'/picture?type=square';

		echo '<img src="'.$imgSrc.'" alt="profile picture">'; 
	}else{
		echo '<i class="fa fa-user fa-5x" aria-hidden="true"></i>';
	}
?>