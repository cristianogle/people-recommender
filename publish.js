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
						showPopup( "Posting your check on Facebook" , "alert-info" , 0 ); 
					}
	}).done( function(response){
		if( response.published == true ){
			showPopup( "Your check has been published on your Facebook profile" , 
					   "alert-success" , 
					   2000 ); 
		}else{
         	showPopup( "An error has occurred. Nothing has been published on your profile. Try again." , 
         			   "alert-danger" , 
         			   2000 );
		}
	});
}


