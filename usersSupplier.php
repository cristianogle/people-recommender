<?php
	require_once("resources/GridLatLong.php");
	require_once("config.php");
	
	define( "INDEXING_TABLE" , "users_indexing" );
	define( "CHECKINS_TABLE" , "checkins_reduced" );
	
	function myIndexes( $mysqli ){
		if( !isset( $_SESSION['user_id'] ) ){
			throw new Exception( "Session Error: user_id not set" );
		}else{
			$query = 'SELECT grid_index , user_cell_entropy , first_check , last_check 
					  FROM '.INDEXING_TABLE.' 
					  WHERE user_id = "'.$_SESSION['user_id'].'" 
					  ORDER BY user_cell_entropy DESC';
			$result = $mysqli->query( $query );
			
			if( !$result ){
				throw new Exception( "MYSql Error" ); 
			}else{
				$myIndexes = array();
				while( $row = $result->fetch_assoc() ){
					array_push( $myIndexes , array( "grid_index" => $row['grid_index'] ,
													"cell_entropy" => $row['user_cell_entropy'] ,
													"first_check" => $row['first_check'] ,
													"last_check" => $row['last_check'] ) );
				}
				
				return $myIndexes;
			}
		}
	}
	
	function myChecksCount( $mysqli ){
		if( !isset( $_SESSION['user_id'] ) ){
			throw new Exception( "Session Error: user_id not set" );
		}else{
			$query = 'SELECT count(*) as mycheckscount FROM '.CHECKINS_TABLE.' WHERE user_id = "'.$_SESSION['user_id'].'"';
			$result  =$mysqli->query( $query );
			
			if( !$result ){
				throw new Exception( "MYSql Error" );
			}else{
				$row = $result->fetch_assoc();
				return $row['mycheckscount'];
			}
		}
	}

	function fetchUsersFromCell( $mysqli , $indexData , $minimumEntropy ){
		$query = "SELECT distinct user_id 
		          FROM ".INDEXING_TABLE." 
		          WHERE grid_index = ".$indexData['grid_index'].' 
		          AND (first_check < "'.$indexData['last_check'].'" AND last_check <= "'.$indexData['first_check'].'") 
		          AND user_cell_entropy >= '.$minimumEntropy;
		
		$similarUsers = array();
		$result = $mysqli->query( $query );
		if( !$result ){
			throw new Exception( "MYSql Error" );
		}else{
			while( $row = $result->fetch_assoc() ){
				array_push( $similarUsers  , $row['user_id'] );
			}
		}

		return $similarUsers;
	}
	
	
	function fetchUsersByCheckins( $mysqli , $myIndexes ){
		$query = "SELECT distinct user_id FROM ".INDEXING_TABLE." WHERE grid_index IN (";
		foreach( $myIndexes as $index ){
			$query .= $index['grid_index'].',';
		}
		$query = substr( $query , 0 , strlen( $query ) - 1 );
		$query .= ")";
		
		echo $query;
		
		$similarUsers = array();
		$result = $mysqli->query( $query );
		if( !$result ){
			throw new Exception( "MYSql Error" );
		}else{
			while( $row = $result->fetch_assoc() ){
				array_push( $similarUsers  , $row['user_id'] );
			}
		}

		var_dump( $similarUsers );
	}

?>