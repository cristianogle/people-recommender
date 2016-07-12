$(document).ready(function(){
    $("#user-icon").click(function(){
        $("#check-with").toggle();
    });
    /*$("#place-icon").click(function(){
        $("#check-place").toggle();
    });*/
    $("#tagged-p").click(function(){
        $("#check-with").toggle();
    });
    
    $("#post-button").prop( 'disabled' , true );
    showPlacesHint();
});

function setVisibilitySelection( optAnchor ){
	var selectedOption = $(optAnchor).find( ".visibility-option" ).html();
	var selectedOptionId = $(optAnchor).find( ".visibility-option" ).attr( "id" );
	
	$("#check-publish #visibility-button #selected-visibility" ).html( selectedOption );
	$("#check-publish #visibility-button #selected-visibility" ).attr( "value" , selectedOptionId );
}

function clearCheckForm(){
	$("#with-search").val('').trigger('change');
	$("#places-search").val('').trigger('change');
	$("#status-text").val('');
	
	$("#tagged-friends #tagged-p").empty();
	$("#tagged-friends").hide();
}
