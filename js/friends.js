function showFriendsHint(str) {
	console.log("show friends hint");
	var xmlhttp;
	
	if (str.length == 0) {
    	document.getElementById("friendsHint").innerHTML = "";
    	return;
  	}
	
	if (window.XMLHttpRequest) {		// code for IE7+, Firefox, Chrome, Opera, Safari
  		xmlhttp=new XMLHttpRequest();
  	}
	else {								// code for IE6, IE5
  		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  	}
  	
	xmlhttp.onreadystatechange=function() {
  		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
  			console.log("response: "+xmlhttp.responseText);
    		//document.getElementById("friendsHint").innerHTML=xmlhttp.responseText;
    	}
 	};
	xmlhttp.open("GET","getFriends.php?q="+str,true);
	xmlhttp.send();
}