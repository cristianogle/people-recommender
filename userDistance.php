<?php
	require_once( "config.php" );
	require_once( "http://localhost:8080/UserDistance/java/Java.inc" ); 
	
	function distanceBetween( $user1Id , $user2Id , $temporalSmoothing , $distanceFilterRange , $temporalFilterRange ){
		$distance = java( "trajdst.DistanceCalculator" )->distanceBetween( $user1Id , $user2Id , $temporalSmoothing , //100.0
																								 $distanceFilterRange , //2.0
																								 $temporalFilterRange ); //365.0
		return java_values( $distance );
	}
	
	function distanceFromSet( $userId , $usersSet , $temporalSmoothing , $distanceFilterRange , $temporalFilterRange ){
		$java = java( "trajdst.DistanceCalculator" );
		
		$result = array();
		foreach( $usersSet as $user ){
			$javaDistance = $java->distanceBetween( $userId , $user , $temporalSmoothing , $temporalFilterRange , $distanceFilterRange );
			$distance = java_values( $javaDistance );
			
			if( !isset( $distance ) || $distance == null )
				$result[$user] = 0.0;
			else
				$result[$user] = java_values( $distance );
		}
		
		return $result;
	}
	
	
?>