function showPopup( message , alertClass , autoFadeTime ){
	if( $( "#popup" ).length ){
		removePopup( popup , function(){ _showPopup( message , alertClass , autoFadeTime ); } );	
	}else{
		_showPopup( message , alertClass , autoFadeTime );
	}
}

function removePopup( popup , anotherPopupFunction){
	if( $("#popup").length )
		$("#popup").fadeOut( "fast" , 
					   	     "linear" , 
					   	     function(){ 
					       	     popup.remove();
				    	   
				       	   	     if( anotherPopupFunction !== undefined )
				               	     anotherPopupFunction(); 
				   	   		 }
	     				   );
}

function _showPopup( message , alertClass , autoFadeTime ){
	$(document.body).append( '<div id="popup"><div id="popup-content" class="alert ' +  alertClass + '" role="alert">' + 
							 message + '</div></div>' );
	
	var popup = $( "#popup" );
	popup.hide();
	popup.height( $("#popup-content").height() );
	popup.width( $(document.body).width() / 2 );
	popup.fadeIn( "fast" , "linear" );
	
	if( autoFadeTime !== undefined && autoFadeTime > 0 ){
		setTimeout( function(){
			removePopup( popup );	
		} , autoFadeTime );
	}
}
