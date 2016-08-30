$( '#sections-nav .sections-tab' ).click(
	function(){
		if( $( this ).attr( 'id' ) != $( '#sections-nav .sections-tab.active' ).attr( 'id' ) ){
			$( '#sections-nav .sections-tab.active' ).toggleClass( 'active' );
			$( this ).toggleClass( 'active' );
			
			loadSection( $(this).attr( "id" ) );
		}
	}
);

function loadSection(name){
	$( "#content-wrapper" ).html( name );
}

