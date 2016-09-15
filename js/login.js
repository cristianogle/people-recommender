window.fbAsyncInit = function() {
    FB.init({
        appId      : '515943968530273',
        xfbml      : true,
        cookie	   : true,
        version    : 'v2.6'
	});
	
	/*$.ajax({
		url: "validator.php" ,
		dataType: "html" ,
		method: "GET"
	}).done( function( validatorResponse ){ 
		console.log( validatorResponse );	
	});*/
	
	FB.getLoginStatus( function(response){
		//console.log( response.status );
		
		
		var loginRequest = $.ajax({
						      url: "login.php?loginStatus="+response.status ,
						      method: "GET" ,
						      dataType: "html"
						   }); 
			
		//Perform an AJAX request to login.php, when the request is complete 
		//perform the callback passed to the done() method
		//The callback perform an AJAX request to myData.php to retrieve user data 				   
		$.when( loginRequest ).done( function(loginResponse){
			if( loginResponse != "authentication_required" ){
				//DEBUG
				//$( "#login-wrapper" ).html( loginResponse );
				
				$(".modal-content").empty();
				
				$.ajax({
					url: "myData.php" ,
					dataType: "json" ,
					method: "GET" 
				}).done( function( userData ) {
					console.log( userData );
					$(".modal-content").append( '<div class="modal-header"><h1>Connected</h1></div>' + 
													'<div class="modal-body"><img src="' + userData.picture + '" alt="profile picture"><br/>' + 
													'<div id="modal-user">' + userData.name + '</div>' +
												    '<button type="button" class="btn btn-default" data-dismiss="modal">GO!</button></div>' ) ;
					
					$("#status-img").empty();							    
					$("#status-img").append( '<img src="' + userData.picture + '" alt="profile picture">' );							    
				});
			}else{
				$("#custom-modal").modal( "show" );
			}
		});					   
	});
	
	$(document).ready( function(){
		showLoginModal();
		$("#custom-modal").modal( "show" );
 	});
	
};

(function(d, s, id){
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) {return;}
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

function showLoginModal(){
	var modalOpening = '<div id="custom-modal" class="modal fade" role="dialog"><div class="modal-dialog"><div class="modal-content">';
	var modalClosing = '</div></div></div>';
	var modalContent = '<div class="modal-header"><h1>People Recommender</h1></div>' +
					   '<div class="modal-body"><div>People Recommender is a facebook application, you don&#39t need any registration.<br/>Just log in with Facebook!</div>' +
					   '<div id="modal-disclaimer"><i class="fa fa-info-circle fa-lg" aria-hidden="true"></i> We don&#39t publish anything on your profile unless you tell us!</div>' +
					   '<div id="login-button-wrapper"><a id="login-button"><i class="fa fa-facebook-square fa-2x" aria-hidden="true"></i><span id="login-button-text">Log In</span></a></div>';
					   
	$(document.body).append( modalOpening + modalContent + modalClosing);	
	$("#custom-modal").modal({
		backdrop: "static" ,
		keyboard: false ,
		show: false
	});
	
	$.ajax({
		url: "forced_login.php" ,
		dataType: "json" ,
		method: "GET"
	}).done( function( response ){
		$("#login-button").attr( "href" , response.fbLoginUrl );
		console.log( "SERVER_ADDR: " + response.serverAddr );
	});
}
