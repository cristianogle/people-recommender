<?php
	session_start();
	require_once( "config.php" ); 
	if( isset( $_SESSION['fb_access_token'] ) ) {
		$fb = new Facebook\Facebook( array(
			'app_id' => APP_ID,
			'app_secret' => APP_SECRET,
			'default_graph_version' => 'v2.6'
		) );
		
		$idRequest = $fb->request('GET', '/me');
		$idRequest->setAccessToken( $_SESSION['fb_access_token'] );
		$pathRequest = $fb->request('GET', 'me/feed');
		$pathRequest->setAccessToken( $_SESSION['fb_access_token'] );
		$pathRequest->setParams(array( 'with' => 'location', 'limit' => 100));
		
		// Send the request to Graph
		try {
			$idResponse = $fb->getClient()->sendRequest($idRequest);
		  $pathResponse = $fb->getClient()->sendRequest($pathRequest);
		} catch(Facebook\Exceptions\FacebookResponseException $e) {
		  // When Graph returns an error
		  echo 'Graph returned an error: ' . $e->getMessage();
		  exit;
		} catch(Facebook\Exceptions\FacebookSDKException $e) {
		  // When validation fails or other local issues
		  echo 'Facebook SDK returned an error: ' . $e->getMessage();
		  exit;
		}
		
		$idGraphNode = $idResponse->getGraphNode();
		$pathGraphNode = $pathResponse->getGraphList();
		
		$profileArray = array();
		// il primo elemento del json restituito contiene solo l'user-id del client
		array_push($profileArray, array("id"=>$idGraphNode['id'], "name"=>"", "date"=>"", "author"=>"") );
		
		$decodedPath = json_decode($pathGraphNode, true);
		foreach($decodedPath as $check) {
			//var_dump(json_encode($check));
			//echo '<br><br>';
			$splitArray =  explode( '_', $check["id"]);
			$author = $splitArray[0];
			$placeId = $splitArray[1];
			if (preg_match("/\bat \b/i", $check["story"])) {
				$placeName = explode( 'at ', $check["story"]);
				$placeName = $placeName[1];
			}
			else if (preg_match("/\bin \b/i", $check["story"])) {		// qualche tagged place "strano" ha "in" invece che "at"
				$placeName = explode( 'in ', $check["story"]);
				$placeName = $placeName[1];
			}
			$placeName = substr_replace($placeName, '', -1);		// rimuove il punto finale del nome del luogo
			$date = $check["created_time"]["date"];
			$date = substr( $date, 0, 16 );		// si scartano secondi e millesimi di secondo
			//echo "<br>".$date;
			if (isset($placeName))
				array_push($profileArray, array("id"=>$placeId, "name"=>$placeName, "date"=>$date, "author"=>$author) );
		}
		
		echo json_encode($profileArray);
		
	}
?>