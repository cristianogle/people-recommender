<?php 
	ini_set('display_errors', 'On');
	error_reporting(E_ALL);

	require_once __DIR__.'/resources/libraries/facebook-php-sdk-v4-5.0.0/src/Facebook/autoload.php';
	
	define( 'APP_ID' , '515943968530273' );
	define( 'APP_SECRET' , 'd45f2e3dedf382c87e79c5c3af6a09cf' );
	define( 'AUTOLOAD_DIRECTORY' , 'resources/autoload');
	
	define( 'DB_SERVERNAME' , 'localhost' );
	define( 'DB_USERNAME' , 'root' );
	define( 'DB_PASSWORD' , 'root');
	
	spl_autoload_register( function($class){
		$file = __DIR__.'/'.AUTOLOAD_DIRECTORY.'/'.$class.".php";
		
		echo "<p>".$file."</p>";
		
		if( file_exists( $file ) ){
			require $file;	
		}
	});
?>