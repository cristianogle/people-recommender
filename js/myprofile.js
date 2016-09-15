function showMyProfile() {
	$("#load-profile-spinner").show();
	$.ajax({
			url: 'getProfilePlaces.php',
			dataType: 'json',
			method: 'GET',
			data: function(params){
				return{
					id: params.id,
					name: params.name, 
					date: params.date,
					author: params.author
				};
		  	} ,
			success: function(data) {
				var checkOpening = '<li><div class="check" id="';
				var checkClosing = '"><div class="desc"><span class="desc-name">';
				var nameClosing = '</span><span class="desc-date">';
				var actionsOpening = '</span></div><div class="actions"><a target="blank" href="';
				var linkClosing = '"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span></a></div></div></li>';
				var userId = data[0].id;
				//reset per aggiornamento "automatico" causato da check interno all'app
				document.getElementById('check-list').innerHTML ="";
				
				for( var i=1; i< data.length; i++ ) {
					var postUrl = "https://www.facebook.com/"+data[i].author+"/posts/"+data[i].id;
					//console.log("url: "+postUrl);
					var check = checkOpening+data[i].id+checkClosing+data[i].name+nameClosing+data[i].date+actionsOpening+postUrl+linkClosing;
					//console.log(check);
					document.getElementById('check-list').innerHTML += check;
					//	console.log( data[i].author+"-->"+data[i].name );
				}
				$("#load-profile-spinner").hide();
				// Filter search with ListJs
				var options = {
				  valueNames: [ 'desc-name' ]
				};
				
				var userList = new List('profile', options);
			}
	});
}
