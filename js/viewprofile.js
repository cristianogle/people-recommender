// map markers and infowindows
var markers = [];
var infowins = [];

// Define a symbol using SVG path notation, with an opacity of 1.-- dashed line
var lineSymbol = {
  path: 'M 0,-1 0,1',
  strokeOpacity: 1,
  scale: 4
};
var lastPolyline = null;
var blueMarkers = [];

// google chart
var chart;
var obj = [];		// json object from php. contains check-to-check distance considered in the algorithm
var dataChart;

function viewProfile(user) {
	var userIdButton = $(user).attr( "id" );
	if( $("#"+userIdButton).text() == "View profile" ) {
		userId = userIdButton.substring(0, userIdButton.length - 3);
		$('#recommended').hide();
		var selectedUserHtml = '<div class="recommended-user" id="'+userId+'">'+$("#"+userId).html()+'</div>';
		$("#"+userId).remove();
		document.getElementById('selected-user').innerHTML = selectedUserHtml;
		$("#"+userIdButton).text("Hide profile");
		$("#order-div").hide();
		deleteMarkers(2);
		lastPolyline = null;
		$("#view-profile").slideToggle("slow");
		google.maps.event.trigger(map, 'resize');
		
		// lettura dal DB dei last checks
		$.ajax({
				url: 'getDbChecks.php?id='+userId,
				dataType: 'json',
				method: 'GET',
				data: function(params){
					return{
						id: params.id,
						name: params.name, 
						date: params.date,
						lat: params.lat,
						lng: params.lng
					};
				}
		}).done(function(data) {
			drawChecks(data);
		    $('#'+userIdButton).delay(100).fadeOut('slow').fadeIn('slow');
		    //Google chart draw
			google.charts.load('current', {'packages':['corechart']});
			google.charts.setOnLoadCallback(drawChart);
		});
	}
	else if ( $("#"+userIdButton).text() == "Hide profile" ) {
		$("#view-profile").css("display", "none");
		//document.getElementById('recommended').innerHTML = "";
		//suggestUsers();
		var selectedUserHtml = document.getElementById('selected-user').innerHTML;
		var otherHtml = document.getElementById('recommended').innerHTML;
		/*document.getElementById('selected-user').innerHTML = "";*/
		document.getElementById('recommended').innerHTML = selectedUserHtml + otherHtml;
		$("#"+userIdButton).text("View profile");
		if ( lastPolyline != null )
			lastPolyline.setMap(null);		// delete last dashed polyline
		$('#recommended').show();
		$("#order-div").show();
	}
}

function drawChecks(data) {
	deleteMarkers(1);
	locations = [];
	for( var i = 0; i < data.length; i++ ) {
		var check  =  [data[i].name, data[i].date, data[i].lat, data[i].lng];
		locations.push(check);
	}
	
	var label = 1;
	
	for (var i = 0; i < locations.length; i++) {  
	 	var m = createMarker({
    		position: new google.maps.LatLng(locations[i][2], locations[i][3]),
    		map: map,
    		animation: google.maps.Animation.DROP
  			}, "<h3>"+locations[i][0]+"</h3><p>Checked in: "+locations[i][1].substring(0, locations[i][1].length - 9)+"</p>", 1);
    	label++;
		//marker.setIcon('http://maps.google.com/mapfiles/ms/icons/blue-dot.png');
	}
}

function createMarker(options, html, type) {
    var marker = new google.maps.Marker(options);
    if (html) {
      google.maps.event.addListener(marker, "click", function () {
      	closeAllInfoWindows();
      	var infoWindow = new google.maps.InfoWindow();
        infoWindow.setContent(html);
        infoWindow.open(options.map, this);
        infowins.push(infoWindow);
      });
    }
    type == 1 ? markers.push(marker) : blueMarkers.push(marker);
    return marker;
}

// Sets the map on all markers in the array.
function setMapOnAll(type, map) {
	if( type == 1 ) {
		for (var i = 0; i < markers.length; i++)
			markers[i].setMap(map);
	}
	else if ( type == 2 ) {
		for (var i = 0; i < blueMarkers.length; i++)
			blueMarkers[i].setMap(map);
	}
}

// Removes the markers from the map, but keeps them in the array.
function clearMarkers(type) {
	setMapOnAll(type, null);
}

// Deletes all markers in the array by removing references to them.
function deleteMarkers(type) {
	clearMarkers(type);
    type == 1 ? markers = []: blueMarkers = [];
}

// to open windows once a time
function closeAllInfoWindows() {
  for (var i=0;i<infowins.length;i++) {
     infowins[i].close();
     infowins.splice(i, 1);
  }
}

function makeChecksPolyline(locations, selectedRow) {
	var arr = [];
	
	var marker; 
	
	marker = createMarker({
		position: new google.maps.LatLng(locations[0][0], locations[0][1]),
		map: map
	},
	'<div style="color:blue;"><h3>'+obj[selectedRow][1]+'</h3><p>Checked in: '+obj[selectedRow][2]+'</p></div>', 2);
 	marker.setIcon('https://maps.google.com/mapfiles/ms/icons/blue-dot.png');		// marker color: blue
	arr.push(marker.getPosition());
	
	marker = createMarker({
		position: new google.maps.LatLng(locations[1][0], locations[1][1]),
		map: map
	},
	'<div style="color:blue;"><h3>'+obj[selectedRow][3]+'</h3><p>Checked in: '+obj[selectedRow][4]+'</p></div>', 2);
 	marker.setIcon('https://maps.google.com/mapfiles/ms/icons/blue-dot.png');		// marker color: blue
	arr.push(marker.getPosition());

	lastPolyline = new google.maps.Polyline({
    	path: arr,
    	geodesic: true,
      	strokeColor: '#0033cc',
      	strokeOpacity: 0,
      	strokeWeight: 3,  
      	icons: [{
            icon: lineSymbol,
            offset: '0',
            repeat: '20px'
          }],
      	map: map
    });
    return marker;
}


//--------------------- Google chart ----------------------

function drawChart() {
	// obj: json from php
	obj = [
	// la prima riga contiene i nomi dei due utenti
		[0, 'Cristiano Gelli', 0, 'Christian Panconi',0 , 0, 0, 0, 0, 0],
	//  id | place1 |    date1       | place2   | date2 | distance   lat1    | lng1         | lat2         | lng2
		[1, 'La Sala', '08/09/2016', 'La Sala', '08/09/2016', 3, 43.932708, 10.916451, 43.932708, 10.916451],
		[2, 'Capostrada', '07/09/2016', 'Gelateria Monterosa', '07/09/2016', 4,  43.961859, 10.908763, 43.950857, 10.90311],
		[3, 'Festa Badia', '05/09/2016', 'Festa Badia', '03/09/2016', 9, 43.910298, 10.95768, 43.910298, 10.95768],
		[4, 'Wish Outdoor', '29/08/2016', 'Le Cascine', '29/08/2016', 4, 43.781495, 11.227726, 43.777007, 11.232627],
		[5, 'Fiaschetteria', '20/08/2016', 'Covo', '20/08/2016', 1, 43.930348, 10.907859, 43.932742, 10.916072999999983],
		[6, 'Il posto nero', '16/06/2016', 'TomJerry', '16/06/2016', 2, 43.930348, 10.907859, 43.933846 , 10.932363]
	];
	
	var user1 = obj[0][1];
	var user2 = obj[0][3];
	
	dataChart = new google.visualization.DataTable();
	
	dataChart.addColumn('number', 'y');
    dataChart.addColumn('number', 'usersDistance');
    // Use custom HTML content for the domain tooltip.
  	dataChart.addColumn({'type': 'string', 'role': 'tooltip', 'p': {'html': true}});
  	
  	for( var i = 1; i < obj.length; i++ ) {
    	var temp = [];
    	temp.push(obj[i][0]);
    	temp.push(obj[i][5]);
    	temp.push(myTooltip(user1, user2, obj[i][1], obj[i][2], obj[i][3], obj[i][4]));
    	dataChart.addRow(temp);
    }
    
    var options = {
        title: 'Users comparison: matched checks',
        legend: {position: 'none'},
		tooltip: { isHtml: true }
		//colors: ['red']
    };

    chart = new google.visualization.LineChart(document.getElementById('chart_div'));
    chart.draw(dataChart, options);
    google.visualization.events.addListener(chart, 'select', selectHandler);
}


function myTooltip( nameA, nameB, placeA, dateA, placeB, dateB ) {
	return '<div style="padding:5px 5px 5px 5px;"><h2 style="display:inline;">'+nameA+'<br></h2>Place: <h3 style="display:inline;">'+placeA+'<br></h3>Date: <h3 style="display:inline;">'+dateA+'<br><br></h3>'+
	'<h2 style="display:inline;">'+nameB+'<br></h2>Place: <h3 style="display:inline;">'+placeB+'<br></h3>Date: <h3 style="display:inline;">'+dateB+'<br></h3></div>';
}

function selectHandler(e) {
	deleteMarkers(2);
	if( lastPolyline != null )
		lastPolyline.setMap(null);
	console.log('A table row was selected');	
	var selectedItem = chart.getSelection()[0];
    if (selectedItem) {
    	var selectedRow = selectedItem.row+1;
     	console.log('The user selected ' + selectedRow);
     	var locations = [ 
     		[ obj[selectedRow][6], obj[selectedRow][7] ],
     		[ obj[selectedRow][8], obj[selectedRow][9] ]
     	];
     	var m = makeChecksPolyline(locations, selectedRow);
     	console.log("polyline drawn");
		var latLng = m.getPosition();
		map.setCenter(latLng);
		map.setZoom(13);
		console.log("map centered");
    }
}

