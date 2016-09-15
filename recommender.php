<?php
	require_once( "config.php" );
	require_once( "usersSupplier.php" );
	require_once( "userDistance.php" );
	
	define( "CELL_ENTROPY_THRESHOLD" , 0.05 );
	define( "TEMPORAL_SMOOTHING" , 100.0 );
	define( "DISTANCE_FILTER_THRASHOLD" , 2.0 );
	define( "TEMPORAL_DISTANCE_THRESHOLD" , 365.0 );
	
	session_start();
	
	if( !isset( $_SESSION['user_id'] ) ){
		die( "Ops this is very embarassing. It seems we don't recognize you." );
	}else{
		$mysqli=getMysqliConnection();
		$myIndexes = myIndexes( $mysqli );
		
		$similarUsers = array();
		foreach( $myIndexes as $indexData ){
			$cellUsers = fetchUsersFromCell( $mysqli , $indexData , CELL_ENTROPY_THRESHOLD );
			
			foreach( $cellUsers as $user ){
			if( !in_array( $user , $similarUsers ) )
				array_push( $similarUsers , $user ); 
			}
		} 
		
		$distances = distanceFromSet( $_SESSION['user_id'] , $similarUsers , TEMPORAL_SMOOTHING , 
																			 DISTANCE_FILTER_THRASHOLD , 
																			 TEMPORAL_DISTANCE_THRESHOLD );
		
		$normalizedDistances = normalizeDistances( $distances );
																			 
		$suggestions = array();
		foreach( $similarUsers as $user ){
			array_push( $suggestions , array( "id" => $user , 
										      "name" => "Test ".$user." User" ,
										      "gender" => "M" ,
										      "age" => "20" , 
										      "progress" => $normalizedDistances[$user] ) );
		}
		
		echo json_encode( $suggestions );
	}
	
	function normalizeDistances( $distances ){
		$min = 0;
		$max = reset( $distances );
		
		foreach( $distances as $distance ){
			if( $distance > $max )
				$max = $distance;	
		}
		
		$max += 20; //Random!!!!!
		
		$normalizedDistances = array();
		foreach( $distances as $userId => $distance ){
			$normalized = ( 1 - ( $distance - $min ) / ( $max - $min ) ) * 100;
			$normalizedDistances[$userId] = intval( $normalized );
		}
		
		return $normalizedDistances;
	}

?>