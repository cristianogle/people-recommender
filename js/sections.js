$( '#sections-nav .sections-tab' ).click(
	function(){
		if( $( this ).attr( 'id' ) != $( '#sections-nav .sections-tab.active' ).attr( 'id' ) ){
			var oldActive = $( '#sections-nav .sections-tab.active' ).attr('id');
			var newActive = $(this).attr('id');
			
			$( '#sections-nav .sections-tab.active' ).toggleClass( 'active' );
			$( this ).toggleClass( 'active' );
			
			
			if(oldActive === "sections-suggestions-tab")
				$('#content-wrapper').hide();
			else if ( oldActive === "sections-myprofile-tab" )
				$('#myprofile-wrapper').hide();
			else if ( oldActive === "sections-help-tab")
				$('#help-wrapper').hide();
				
			if(newActive === "sections-suggestions-tab")
				$('#content-wrapper').show();
			else if ( newActive === "sections-myprofile-tab" )
				$('#myprofile-wrapper').show();
			else if ( newActive === "sections-help-tab")
				$('#help-wrapper').show();
			
			//loadSection( $(this).attr( "id" ) );
		}
	}
);

function loadSection(name){
	$( "#content-wrapper" ).html( name );
}

