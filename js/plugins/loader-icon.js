//DEPENDENCIES: 
//	loader-icon.css
//	jQuery
//
//USAGE: 
//	$("{div to be transformed selector}").loaderIcon( "#000" );
//
//NOTES:
//  The div to be transformed must be empty.

( function( $ ) {
	
	$.fn.loaderIcon = function( color ){
		if( this.is( $("div") ) ){
			$(this).addClass( "custom-icon-loader" );
			for( var i = 0 ; i < 5  ; i++ )
				$(this).append( '<div class="custom-icon-loader-bar"></div>' );
				
			$( ".custom-icon-loader .custom-icon-loader-bar" ).css( "background-color" , color );
				
			var index = 0;
			$(this).children().each( function(){
				
				if( index > 0 ){
					$(this).css( '-webkit-animation-delay' , '-'+( 1.2 - 0.1*index )+'s' );
					$(this).css( 'animation-delay', '-'+( 1.2 - 0.1*index )+'s' );
				}
				
				index++;
			});	 
		}
	};
	
}( jQuery ));
