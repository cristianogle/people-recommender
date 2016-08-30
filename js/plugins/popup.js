//DEPENDENCIES: 
//  popup.css
//  jQuery
//  Bootstrap




/*
 * showPopup() function takes a javascript object wit the following properties
 * {
 * 	message: (String)the message to display inside the popup 
 *  alertClass: (String) the alert bootstrap class for the popup content 
 *  autoFadeTime: specified the time in milliseconds after wich the popup automatically fade out 
 *  loaderIcon: (true|false) if true inserts a loading icon at the bottom of the popup 
 *  loaderIconColor: (color String) the color of the loading icon , this parameter is considered only if the laoderIcon property is true
 * }
 * 
 * If there's already a popup displayed the showPopup() function fades out the popup and removes it from the DOM 
 */
function showPopup( parameters ){
	if( parameters.message !== undefined ){
		var message = parameters.message;
		var alertClass = (parameters.alertClass !== undefined ) ? parameters.alertClass : "alert-info";
		var autoFadeTime = (parameters.autoFadeTime !== undefined ) ? parameters.autoFadeTime : 0;
		var loaderIcon = (parameters.loaderIcon !== undefined ) ? parameters.loaderIcon : false;
		var loaderIconColor = (parameters.loaderIconColor !== undefined) ? parameters.loaderIconColor : "#000";
		
		if( $( "#popup" ).length ){
			removePopup( popup , function(){ _showPopup( message , alertClass , autoFadeTime , loaderIcon , loaderIconColor ); } );	
		}else{
			_showPopup( message , alertClass , autoFadeTime , loaderIcon , loaderIconColor );
		}
	}
}

function removePopup( popup , anotherPopupFunction){
	if( $("#popup").length )
		$("#popup").fadeOut( "fast" , 
					   	     "linear" , 
					   	     function(){ 
					       	     $("#popup").remove();
				    	   
				       	   	     if( anotherPopupFunction !== undefined )
				               	     anotherPopupFunction(); 
				   	   		 }
	     				   );
}

function _showPopup( message , alertClass , autoFadeTime , loaderIcon , loaderIconColor ){
	$(document.body).append( '<div id="popup"><div id="popup-content" class="alert ' +  alertClass + '" role="alert">' + 
							 message + '</div></div>' );
	
	var popup = $( "#popup" );
	popup.hide();
	popup.height( $("#popup-content").height() );
	popup.width( $(document.body).width() / 2 );
	
	if( loaderIcon ){
		$( "#popup-content").append( '<div class="loader-icon"><div>' );
		$( ".loader-icon" ).loaderIcon( loaderIconColor );
		$( ".loader-icon" ).css( "margin" , "0 auto" );
	}
	
	popup.fadeIn( "fast" , "linear" );
	
	if( autoFadeTime !== undefined && autoFadeTime > 0 ){
		setTimeout( function(){
			removePopup( popup );	
		} , autoFadeTime );
	}
}
