window.fbAsyncInit = function() {
    FB.init({
        appId      : '511638992294104',
        xfbml      : true,
        cookie	   : true,
        version    : 'v2.6'
	});
	
	checkStatus();
};

(function(d, s, id){
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) {return;}
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

function checkStatus(){
	FB.getLoginStatus( function( response ){ 
		console.log( response.status );
		if( response.status == "unknown" ){  //User not logged into facebook
			xhr = new XMLHttpRequest();
			xhr.onreadystatechange = function(){
				if( xhr.readyState == 4 && xhr.status == 200 ){
					$( "#login-wrapper" ).html( xhr.responseText );	
				}
			};
			
			xhr.open( "GET" , "login.php" );
			xhr.send();
		}
	});
}
