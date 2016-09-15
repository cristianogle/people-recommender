<?php
	session_start();
	require_once("config.php");
	if( isset( $_SESSION['fb_access_token'] ) ) {
		// Create db connection
		$conn = new mysqli(DB_SERVERNAME, DB_USERNAME, DB_PASSWORD, "peoplerecommender");
		if ($conn->connect_error)
    		die("Connection failed: " . $conn->connect_error);
		//echo "Connected successfully";
		
		$userId =  $_GET["id"];
		//echo $userId;
		$sql = 'SELECT user_id, place_name, date, lat, lng FROM path 
				WHERE user_id="'.$userId.'"';
		//echo '<br>'.$sql;
		
		$result = $conn->query($sql);
		
		$retArray = array();
		
		if ($result->num_rows > 0) 
	    	// output data of each row
	    	while($row = $result->fetch_assoc()) {
				array_push($retArray, array("id"=>$row["user_id"], "name"=>$row["place_name"], "date"=>$row["date"], "lat"=>$row["lat"], "lng"=>$row["lng"]) );
			}	

		$conn->close();
		
		echo json_encode($retArray);
	}
?>