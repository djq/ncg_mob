
var divResize = function divResize(){

	// get screen size
	/*
	var w = screen.width;
	var h = screen.height;	
	console.log(w, h);	*/

	// using width of wrapper div
	w = $('#wrapper').width()
	h = $('#wrapper').height()

	// update .state size based on width
	state_width = (w - 35) / 2;
	state_height = (h - 100) / 4;	
	$('.state')
		.width( state_width )
		.height( state_height )


}


$(window).resize(function() {
  divResize();
});

