<?php
	define( "SESSION_INACTIVE_LIFETIME" , 900 ); //In seconds

	
	function logout(){
		//session_start();
		// resets the session data for the rest of the runtime
		echo "<h1>LOGOUT</h1>";
		$_SESSION = array();
		// sends as Set-Cookie to invalidate the session cookie
		if (isset($_COOKIE[session_name()])) { 
		    $params = session_get_cookie_params();
		    setcookie(session_name(), '', 1, $params['path'], $params['domain'], $params['secure'], isset($params['httponly']));
		}
		session_destroy();
	}
	
	function auto_logout(){
		//session_start();
		
		/*var_dump( $_SESSION );
		echo "<br>";*/
		
		$t = time();
		
		if( !isset($_SESSION[ 'user_time' ] ) )
			$_SESSION[ 'user_time' ] = time();
		
		$t0 = $_SESSION[ 'user_time' ];
		$diff = $t - $t0;
		
		/*var_dump( $diff );
		echo "<br>";
		var_dump( $t0 );*/
		
		
		if( $diff > SESSION_INACTIVE_LIFETIME ){
			//echo "<br>LOGOUT REQUIRED<br>";
			return true;
		}else{
			$_SESSION[ 'user_time' ] = time();
		} 
	}
?>