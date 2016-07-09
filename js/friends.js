function showFriendsHint() {
	var myCookie = getCookie("FriendsHintCookie");
	if(myCookie == null ) {
		setCookie("FriendsHintCookie", "friendshintcookie", 1);
		console.log("cookie settato");
		$.ajax({
			url: 'getFriends.php',
			dataType: 'json',
			method: 'GET'
		}).done(function(response) {
			$("#with-search").select2({
				width: '100%',
				theme: 'bootstrap' ,
				placeholder: "Who are you with?",
				allowClear: true,
			    minimumInputLength: 1,
			    tags: false,				// disabilita possibilità di selezionare ciò che si è scritto
			    data: response
			    //quietMillis: 50
			});
		} );
	}
	else {
		console.log("c'è gia il cookie...");
	}
}

// cookies management functions-----------
function setCookie(name,value,days) {
	if (days) {
		var date = new Date();
		date.setTime(date.getTime()+(days*24*60*60*1000));
		var expires = "; expires="+date.toGMTString();
	}
	else var expires = "";
	document.cookie = name+"="+value+expires+"; path=/";
}

function getCookie(name) {
	var nameEQ = name + "=";
	var ca = document.cookie.split(';');
	for(var i=0;i < ca.length;i++) {
		var c = ca[i];
		while (c.charAt(0)==' ') c = c.substring(1,c.length);
		if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
	}
	return null;
}

function deleteCookie(name) {
	setCookie(name,"",-1);
}
// --------------------------------------

//remove cookie on page unload (refresh)
$(window).unload(function() {
	console.log("cookie eliminato");
  	deleteCookie('FriendsHintCookie');
});


// gestione comparsa amici taggati in #tagged-friends p ( eventi select2 friends )

$('#with-search').on('select2:select', function (evt) {
	var newContent = " ";
	var data = $('#with-search').select2('data');
	for( var i in data )
		newContent+=data[i].text+" ";
	$('#tagged-friends p').html(newContent);
	
	if( i == 0 )
		$("#tagged-friends").toggle();
});

$('#with-search').on('select2:unselect', function (evt) {
  	var newContent = " ";
	var data = $('#with-search').select2('data');
	for( var i in data )
		newContent+=data[i].text+" ";
	$('#tagged-friends p').html(newContent);  
	
	if( newContent == " " )
		$("#tagged-friends").toggle();	
});


// altrimenti non compare interamente il placeholder perchè veniva inizializzato a 100px da bootstrap:
$(".select2-search__field").css("width", "100%");
