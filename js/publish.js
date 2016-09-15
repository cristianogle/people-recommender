function publishPost(){
	
	var postObj = {
		message: $( "#check-status #status-text" ).val() ,
		privacy: $("#check-publish #visibility-button #selected-visibility" ).attr( "value" )
	};
	
	if( $( "#places-search" ).data( "select2" ) ){
		var selectedPlace = $( "#places-search" ).select2( "data" );
		
		if( typeof selectedPlace != 'undefined' ){
			postObj.place = selectedPlace[0].id;
		}
	}
		
	
	if( $( "#with-search" ).data( "select2" ) ){
		var taggedFriends = $( "#with-search" ).select2( "data" );
		var friendsIds = [];
		for( var i in taggedFriends )
			friendsIds.push( taggedFriends[i].id );
		
		postObj.tags = friendsIds;
	}
	
	$.ajax({
		url: "publish.php" ,
		dataType: "json" ,
		method: "POST" ,
		data: postObj , 
		beforeSend: function(){ 
						clearCheckForm();
						showPopup({ 
								     message: "Posting your check on Facebook" , 
								     alertClass: "alert-info" , 
								     loaderIcon: true ,
								     loaderIconColor: "#337ab7" 
						         }); 
					}
	}).done( function(response){
		if( response.published == true ){
			showPopup({
					     message: "Your check has been published on your Facebook profile" , 
					   	 alertClass: "alert-success" , 
					   	 autoFadeTime: 2000
					 }); 
			// aggiornamento "automatico" quando si fa un nuovo check dall'app e siamo in myprofile
			if ( $( '#sections-nav .sections-tab.active' ).attr('id') === "sections-myprofile-tab" ) {
   				showMyProfile();
			}				 
		}else{
         	showPopup({
         			     message: "An error has occurred. Nothing has been published on your profile. Try again." , 
         			     alertClass: "alert-danger" , 
         			     autoFadeTime: 2000 
         			 });
		}
	});
}


