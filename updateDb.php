<?php
	session_start();
	require_once( "config.php" ); 
	if( isset( $_SESSION['fb_access_token'] ) ) {
		// Create db connection
		$conn = new mysqli(DB_SERVERNAME, DB_USERNAME, DB_PASSWORD, "peoplerecommender");
		if ($conn->connect_error)
    		die("Connection failed: " . $conn->connect_error);
		echo "Connected successfully";
		
		// if connection ok, get user's data
		$fb = new Facebook\Facebook( array(
			'app_id' => APP_ID,
			'app_secret' => APP_SECRET,
			'default_graph_version' => 'v2.6'
		) );
		
		$userRequest = $fb->request('GET', 'me?fields=first_name,last_name,gender,birthday');
		$userRequest->setAccessToken( $_SESSION['fb_access_token'] );
		$pathRequest = $fb->request('GET', 'me/tagged_places');
		$pathRequest->setAccessToken( $_SESSION['fb_access_token'] );
		$pathRequest->setParams( array( 'limit' => 500, 'type_format' => 'U') );
		
		// Send the request to Graph
		try {
		  $userResponse = $fb->getClient()->sendRequest($userRequest);
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
		
		
		$userGraphNode = $userResponse->getGraphNode();
		$userId = $userGraphNode["id"];

		$pathGraphNode = $pathResponse->getGraphList();
		
		$firstName = $userGraphNode["first_name"];
		$lastName = $userGraphNode["last_name"];
		$gender = $userGraphNode["gender"];
		//$age = date("Y")-$userGraphNode["birthday"]->format("Y");
		$firstCheck = $pathGraphNode[sizeof($pathGraphNode)-1]['created_time'];
		$firstCheck = $firstCheck->format("Y");
		$lastCheck = $pathGraphNode[0]['created_time'];
		$lastCheck = $lastCheck->format("Y");
		
		$sql = "REPLACE INTO user (id, first_name, last_name, gender, 99 , first_check, last_check)
			VALUES ('$userId','$firstName','$lastName','$gender', '$age', '$firstCheck', '$lastCheck')";
		
		if ($conn->query($sql) === TRUE)
			echo "<br>New user record created successfully";
		else
			echo "<br>Error: " . $sql . "<br>" . $conn->error;
		
		// update path table
		$decodedPath = json_decode($pathGraphNode, true);
		foreach($decodedPath as $check) {
			var_dump($check);
			$placeId = $check["place"]["id"];
			$date = $check["created_time"]["date"];
			$placeName = '"'.$check["place"]["name"].'"';
			$placeName = mysqli_real_escape_string($conn, $check["place"]["name"]);
			// se ci son posti che non hanno coordinate, li scarto
			if(!empty($check["place"]["location"]["latitude"]) && !empty($check["place"]["location"]["longitude"]) ) {
				$lat = $check["place"]["location"]["latitude"];
				$lng = $check["place"]["location"]["longitude"];
				$sql = "REPLACE INTO path(user_id, place_id, date, place_name, lat, lng)
						VALUES('$userId','$placeId','$date','$placeName','$lat','$lng')";
				if ($conn->query($sql) === TRUE)
	    			echo "<br>New path record created successfully";
				else
	    			echo "<br>Error: " . $sql . "<br>" . $conn->error;
			}
		}
		
		// close the connection
		$conn->close();
		echo "<br>conn closed succesfully";
	}
?>