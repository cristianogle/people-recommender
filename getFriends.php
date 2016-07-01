<?php
	session_start();
	require_once( "config.php" ); 
	if( isset( $_SESSION['fb_access_token'] ) ) {
		$fb = new Facebook\Facebook( array(
			'app_id' => APP_ID,
			'app_secret' => APP_SECRET,
			'default_graph_version' => 'v2.6'
		) );
		
		$request = $fb->request('GET', '/me/taggable_friends?fields=name&limit=4000');
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
		
		// Convert json array to array name
		$graphNode = $response->getGraphList();		//json array	
		$js = json_decode($graphNode, true);		// json decoded. true: array associativo
		
		$arrayFriends = array();		
		foreach($js as $item) { //foreach element in $arr
			array_push($arrayFriends, $item['name']);
		}

		// get the q parameter from URL
		$q = $_GET["q"];
		
		
		// lookup all hints from array if $q is different from "" 
		$q = strtolower($q);
		$friendsHint = "";
		
		$explodedReq = explode(" ", $q);
		$numWordReq = sizeof($explodedReq);
		
		if( $q !== "") {
			foreach($arrayFriends as $f ) {
				$f = strtolower($f);
				$exploded = explode(" ", $f);

				$count = 0;
				foreach($exploded as $e) {
					foreach($explodedReq as $wordReq) {
						if (strlen(stristr($e, $wordReq)) > 0) {
							$count++;
						}
					}
				}
				if($count >= $numWordReq ) {
					if( $friendsHint == "")
						$friendsHint = $f;
					else
						$friendsHint .= ", ".$f;
				}
			}
		}
		// Output hint
		echo $friendsHint;
	}
?>
