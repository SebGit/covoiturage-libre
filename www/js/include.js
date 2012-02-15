$(document).ready(function(){
	
	$('.listepays').mouseover(function(){
		$('.listepays').animate({
		height: '200px'
	    }, 500, function() {
	    });
	});
	
	
	$('.listepays a').click(function(event){
		var pays=$(event.target || event.srcElement).attr('id');
		alert(pays);
	});
});