<?php 
	ini_set('display_errors', 'On');
	error_reporting(E_ALL);

	require_once __DIR__.'/resources/libraries/facebook-php-sdk-v4-5.0.0/src/Facebook/autoload.php';
	
	define( 'APP_ID' , '{app-id}' );
	define( 'APP_SECRET' , '{app-secret}' );
	define( 'AUTOLOAD_DIRECTORY' , 'resources/autoload');
	
	spl_autoload_register( function($class){
		$file = __DIR__.'/'.AUTOLOAD_DIRECTORY.'/'.$class.".php";
		
		echo "<p>".$file."</p>";
		
		if( file_exists( $file ) ){
			require $file;	
		}
	});
?>
