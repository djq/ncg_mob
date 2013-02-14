// colors
/*var colors = ['#1A9641', '#A6D96A', '#FFFFBF', '#FDAE61', '#D7191C'];*/ // from colorbrewer
var colors = ['#1A9641', '#A6D96A', '#FFFFBF', '#FDAE61', '#D7191C']; // Low -> High
var activityStatus = ['Very Quiet', 'Quiet', 'Normal', 'Busy', 'Very Busy'];
var travelStatus = ['Very Fast', 'Fast', 'Normal', 'Slow', 'Very Slow'];
//var colors = ['#00bf00', '#999999', '#ff7f00', '#bc0000', '#'];
var title_sizes = [50, 30, 20];	// font-sizes

function loadjscssfile(filename, filetype){
	 if (filetype=="js"){ //if filename is a external JavaScript file
	  var fileref=document.createElement('script')
	  fileref.setAttribute("type","text/javascript")
	  fileref.setAttribute("src", filename)
	 }
	 else if (filetype=="css"){ //if filename is an external CSS file
	  var fileref=document.createElement("link")
	  fileref.setAttribute("rel", "stylesheet")
	  fileref.setAttribute("type", "text/css")
	  fileref.setAttribute("href", filename)
	 }
	 if (typeof fileref!="undefined")
	  document.getElementsByTagName("head")[0].appendChild(fileref)
}

function flipDiv(){
	    // enable small info box to flip div    
    $('.info_front').click(function(){    	
    	$x = $(this).parent().parent();    			 
        $x.addClass('flipped')   
        /*$y = $x.children('.back').children('.info_back');
        $y.css({
			'z-index':1000		
		})*/
        //console.log();     
        //return false;
    });

    $('.info_back').click(function(){
    	//x = $(this).parent().children('.card');
    	x = $(this).parent().parent();
    	console.log(x) 		 
    	x.removeClass('flipped');
        return false;
    });
}

$( document ).ready(function() {

	layout();

});

/*
var cw = $('.child').width();
$('.child').css({'height':cw+'px'});
*/



var layout = function layout(){	

	// using width of wrapper div
	w = $('#wrapper').width()
	h = $('#wrapper').height()
	//var w = screen.width;
	//var h = screen.height;
   
	// have some way of classifying screens into small / medium / large 
	// get browser size and choose roughtly what it is 	
	var m = '';
	console.log(w, h);	
	if(w > 1260 ){	//large
		s = 0; 
		loadjscssfile("css/intro_large.css", "css") // dynamically load and add this .css file
		loadjscssfile("css/intro_medium.css", "css") // dynamically load and add this .css file
   		$("#cover").hide();
   		console.log('large');
	}
	else if(w <= 1260 && w >= 600){	//medium
		s = 1; 
		loadjscssfile("css/intro_medium.css", "css") // dynamically load and add this .css file
   		$("#cover").hide();
   		console.log('medium');
	}
	else if(w < 600){	//small
		s = 2; 
		loadjscssfile("css/intro_mob.css", "css") // dynamically load and add this .css file
		//loadjscssfile("css/intro_medium.css", "css") // dynamically load and add this .css file
   		$("#cover").hide();
   		$("#basicMap").remove();
   		$("#wrapper").css({
			'margin-left': 200		
		})
   		console.log('mobile');
	}
	console.log(s);

	// update .state size based on state_width
	state_width = (w - 35) / 2;
	state_height = (h - 100) / 3;	
	/*$('.state')
		.width( state_width )
		.height( state_height )*/
/*
	$('.state').css({		
		'max-height':180
	})

	// adjust font sizes accordingly
	$('#pagetitle').css({
		'font-size': title_sizes[s]		
	})

	// adjust font sizes accordingly
	$('#u1_b').css({
		'font-size': title_sizes[s]	/ 2	
	})*/

	flipDiv();	
	//cityState();	// call function to assess city state
	initialize();	// call map functions

}

// on window resize adjust blocks
$(window).resize(function() {
  layout();
});

// random numbers
function getRandomArbitary (min, max) {
    return Math.random() * (max - min) + min;
}

// get city state
var cityState = function cityState(){

	// using a color pallette of green to red set blocks to color for transport modes
	for(var i=1;i < 5; i++){
		id = '#v' + i;
		status = '#v' + i + '_a';
		time = '#v' + i + '_b';
		//console.log(id);
		z = Math.round(getRandomArbitary(0,4));
		$(id).css({
			'background-color': colors[z] 
		})
		
		if(i<4){ // travel times
			$(status).html(travelStatus[z]);
			$(time).html(Math.round(getRandomArbitary(20,40)) + ' min');
		}
		if(i==4){ // activity levels			
			$(time).html(activityStatus[z]);
		}
	}	

}


