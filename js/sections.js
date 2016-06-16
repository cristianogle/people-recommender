$( '#sections-nav .sections-tab' ).click(
	function(){
		$( '#sections-nav .sections-tab.active' ).toggleClass( 'active' );
		$( this ).toggleClass( 'active' );
		
		console.log( $(this).attr( 'id' ) );
	}
);


