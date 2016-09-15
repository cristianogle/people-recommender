var map;

$(document).ready(function(){
	suggestUsers();
	
	// Creazione mappa. viene fatta una sola volta e resta la stessa per tutte le view profile
	var mapScript = "https://maps.googleapis.com/maps/api/js?key=AIzaSyBPVkGRyXBxbTXbyfSDAhynq2LE6cV8FXE&callback=initialize";
	loadScript(mapScript);
	console.log("loaded");
	//per far funzionare spinner la prima volta(boh!!)
	$("#load-sugg-spinner").show();
	$("#load-sugg-spinner").hide();
});

function suggestUsers() {
	$.ajax({
			url: 'recommender.php',
			dataType: 'json',
			method: 'GET',
			data: function(params){
				return{
					id: params.id,
					name: params.name, 
					gender: params.gender,
					age: params.age,
					progress: params.progress
				};
		  	} ,
			success: function(users) {
				var recommendedOpening = '<div class="recommended-user" id="';
				var imgClosing = '"><div class="user-img"><img src="https://graph.facebook.com/';
				var imgLinkOpening = '/picture?type=square"</img></div>';
				var userOpening = '<div class="user-info"><span class="user-name">';
				var nameClosing = '</span><span class="mutual">';
				var userClosing = ' years</span></div>';
				var progressOpening = '<div class="progress"><div class="progress-bar progress-bar-info progress-bar-striped" role="progressbar" aria-valuenow="';
				var barOpening = '" aria-valuemin="0" aria-valuemax="100" style="width:';
				var barClosing = '%">';
				var progressClosing = '</div></div>';
				var htmlButtons = '<div class="recommended-buttons"><div class="btn-group" role="group" aria-label="..."><button type="button" class="btn btn-success"><a href="http://www.facebook.com/';
				var linkButtons = '" target="blank">Send request</a></button></div><div class="btn-group" role="group" aria-label="..."><button id="';
				var closing = '" type="button" class="btn btn-default" onclick="viewProfile(this)">View profile</button></div></div></div>';
				for( var i = 0; i < users.length; i++ ) {
					var btnId = id+"btn";
					var userStruct = recommendedOpening+users[i].id+imgClosing+users[i].id+imgLinkOpening+userOpening+users[i].name+nameClosing+users[i].gender+", "+users[i].age+userClosing+progressOpening+users[i].progress+barOpening+users[i].progress+barClosing+users[i].progress+"%"+progressClosing+htmlButtons+users[i].id+linkButtons+btnId+closing;
					document.getElementById('recommended').innerHTML += userStruct;
				}
			}
	});	
}


function initialize() {
	var minZoomLevel = 2;
	map = new google.maps.Map(document.getElementById('map'), {
			mapTypeControl: false,
			zoom: 5,
			center: { lat: 48.85661400000001, lng: 2.3522219000000177},
			streetViewControl: false 
	});
	if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(function(position) {
	            var pos = { lat: position.coords.latitude, lng: position.coords.longitude };
	            map.setCenter(pos);
			});
    }
    
    // Limit the zoom level
	 google.maps.event.addListener(map, 'zoom_changed', function () {
	     if (map.getZoom() < minZoomLevel) map.setZoom(minZoomLevel);
	 });
}

function loadScript(src){
    var script = document.createElement("script");
    script.type = "text/javascript";
    document.getElementsByTagName("head")[0].appendChild(script);
    script.src = src;
}

// Suggestions ordering

function preOrder( optAnchor ) {
	var selectedOption = $(optAnchor).find( ".order-option" ).html();
	$("#order-div #order-button #selected-order" ).html( selectedOption );
	
	$("#load-sugg-spinner").show();
	console.log("spinner shown");
}

function afterOrder() {
	$("#load-sugg-spinner").hide();
}

function setOrderSelection( optAnchor ){
	//$("#load-sugg-spinner").show();
	
	var selectedOptionId = $(optAnchor).find( ".order-option" ).attr( "id" );
	console.log(selectedOptionId);
	
	if($("#selected-order").attr("value") != selectedOptionId ||  $("#selected-order").attr("value") == "random-order") {
		$("#order-div #order-button #selected-order" ).attr( "value" , selectedOptionId );

		orderSuggestions(selectedOptionId);
	}
	//$("#load-sugg-spinner").hide();
}


function orderSuggestions(type) {
	var map = new Array();
	if( type == "similarity-order" ) {
		$('#recommended').children('div').each(function () {
			var id = $(this).attr('id');
			var sim = $(this).children('.progress').children('div').text().trim();
			sim = sim.substring(0, sim.length - 1);
			map.push({id: id, val: sim});
		});
		
		map.sort(function(a,b) {
    	return a.val - b.val;
		});
		
		for( var i = 0; i < map.length; i++ ) {
			var sel = '<div class="recommended-user" id="'+map[i].id+'">'+$("#"+map[i].id).detach().html()+'</div>';
			document.getElementById('recommended').innerHTML = sel + document.getElementById('recommended').innerHTML;
		}
	}
	else if( type == "name-order" ) {
		$('#recommended').children('div').each(function () {
			var id = $(this).attr('id');
			var name = $(this).children(".user-info").children(".user-name").html();
			console.log("name: "+name);
			map.push({id: id, val: name});
		});
		
		map.sort(function(a,b) {
			return ( a.val < b.val ) ? -1 : ( a.val > b.val ) ? 1 : 0;
		});

		for( var i = 0; i < map.length; i++ ) {
			var sel = '<div class="recommended-user" id="'+map[i].id+'">'+$("#"+map[i].id).detach().html()+'</div>';
			document.getElementById('recommended').innerHTML = document.getElementById('recommended').innerHTML + sel;
		}
	}
	else if(type == "random-order" ) {
		$('#recommended').children('div').each(function () {
			var id = $(this).attr('id');
			map.push('<div class="recommended-user" id="'+id+'">'+$(this).html()+'</div>');
		});
		
		shuffle(map);
		document.getElementById('recommended').innerHTML = "";
		for( var i = 0; i < map.length; i++ )
			document.getElementById('recommended').innerHTML += map[i];
	}
}

function shuffle(a) {
    var j, x, i;
    for (i = a.length; i; i--) {
        j = Math.floor(Math.random() * i);
        x = a[i - 1];
        a[i - 1] = a[j];
        a[j] = x;
    }
}
