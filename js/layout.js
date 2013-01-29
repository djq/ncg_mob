// colors
/*var colors = ['#1A9641', '#A6D96A', '#FFFFBF', '#FDAE61', '#D7191C'];*/ // from colorbrewer
var colors = ['#1A9641', '#A6D96A', '#FFFFBF', '#FDAE61', '#D7191C'];
//var colors = ['#00bf00', '#999999', '#ff7f00', '#bc0000', '#'];

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

	$('.state').css({
		'max-width':300,
		'max-height':300
	})

	// have some way of classifying screens into small / medium / large 
	// adjust font accordingly

	// enable the divs to flip
	// works fine
	/*
    $('.flip').click(function(){
    	console.log('clicked')

    	// add control logic if flipped to return
    	if($(this).find('.card').hasClass('flipped')){    		 
    		 $(this).find('.card').removeClass('flipped');
    	}
    	else{    		 
        	$(this).find('.card').addClass('flipped')
        }  
        return false;
    }); */

    // enable small info box to flip div    
    $('.info').click(function(){
    	x = $(this).parent().children('.card');
    	console.log(x)

    	// add control logic if flipped to return
    	if(x.hasClass('flipped')){    		 
    		 x.removeClass('flipped');
    	}
    	else{    		 
        	x.addClass('flipped')
        }  
        return false;
    });

	// call function to assess city state
	cityState();

}

// on window resize adjust blocks
$(window).resize(function() {
  divResize();
});

// random numbers
function getRandomArbitary (min, max) {
    return Math.random() * (max - min) + min;
}



// get city state
var cityState = function cityState(){

	// using a color pallette of green to red set blocks to color
	for(var i=1;i < 8; i++){
		id = '#v' + i;
		console.log(id);
		$(id).css({'background-color': colors[ Math.round(getRandomArbitary(0,4)) ]})
	}

}


