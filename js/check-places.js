function showPlacesHint(){
	
	$("#places-search").select2({
		theme: "bootstrap" ,
		width: '100%' ,
		allowClear: true ,
		placeholder: "Where are you?" ,
  		multiple: true ,
  		maximumSelectionLength: 1 ,
		ajax: {
			url: "getPlaces.php" ,
			delay: 200 ,
			method: "GET" , 
			dataType: "json" ,
			//minimumInputLength: 2 ,
			data: function(params){
				return{
					q: params.term,
					page: params.page
				};
		  	} ,
				  
			processResults: function(data , params){
				console.log( data.length ); 
				console.log( data ); 
				
				return{
					results: $.map(data, function(obj) {				
						
						var returnObj = { 
										  id: obj.id, 
							     	      text: obj.name,
							     	      city: obj.location.city ,
							     	      country: obj.location.country
							     	    };
							
					     if( obj.hasOwnProperty( "category_list" ) ){
					     	var category = obj.category_list[0];
					     	returnObj['category'] = category;
					     } 				
					     
					     return returnObj;
			     	})
				};		
			}
		} ,
		templateResult: getTemplateData
	});
	
	// altrimenti non compare interamente il placeholder perchè veniva inizializzato a 100px da bootstrap:
	$(".select2-search__field").css("width", "100%");
	
	function getTemplateData( result ){
		$rowMarkup = '<div class="select2-place-suggestion" ><div class="select2-place-suggestion-text">' + 
					 result.text +
				  	 '</div><div class="select2-place-suggestion-city">';
				  
	    if( result.hasOwnProperty('category') )
	    	$rowMarkup += result.category.name + " , ";
				   
		$rowMarkup += result.city + " , " + result.country +
			  	  	  '</div></div>';
		
		$row = $( $rowMarkup );
		return $row;
	}
}


$('#places-search').on('select2:select' , function(evt) {
	$("#post-button").prop( 'disabled' , false );
});

$('#places-search').on('select2:unselect' , function(evt) {
	$("#post-button").prop( 'disabled' , true );
});
