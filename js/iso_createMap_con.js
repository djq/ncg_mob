var _x, _y, id, fid;
var pointStart;
var geocoder;
var t15;

// global vars for map
var map;	
var proj_900913 = new OpenLayers.Projection('EPSG:900913');    
var proj_4326 = new OpenLayers.Projection('EPSG:4326');   	

//intial function
initialize = function (){	
		
		// Create map controls	
		createMap();			// Main map		
		mapControls();			// Map controls 
		makeInterface();		// Interface

		$('#report').hide();					
		geocoder = new google.maps.Geocoder();	// google function (limit of 15000 per day) but also rate-limited 

        // Handle user input 
		// handle pressing enter key
		$(".text").keyup(function(event){
			   if(event.keyCode == 13){
				   codeAddress();		
			   }
		   }); 	 	
				   
		// clear box on focus		
		$('.text').focus(function() {				
				$(this).val('')
					}).blur(function() {
				if (this.value == "") {
					$(this).val(this.title);
				}
				}); 		     

		$("[data-slider]").simpleSlider("setValue", 5); // set slider to 15 on reload (maybe different due to cached)    	
			
}

// get lat/lng of address; Ireland priorized
codeAddress = function() {

	console.log('geocoding');	
	
    var address = $("#address_start").val() //+ ', co. dublin, Ireland';
    	console.log(address);
        geocoder.geocode( { 'address': address, 'region': 'IE'}, function(results1, status) {
			if (status == google.maps.GeocoderStatus.OK) {											
					_y = results1[0].geometry.location.lat();
					_x = results1[0].geometry.location.lng();
					console.log('Start Point - x:', _x, ' y: ', _y);	
					
					fishnet_id(_x, _y);	// call function					
					centerMap(_x, _y);	// center map

			}	
			else {			
				console.log("Geocoding start address was not successful. Reason: " + status);
		  }	  
	});	 	
	
}

// reverese geocode when user drags points
codeLatLng = function (lat, lng, where) {
   
    var latlng = new google.maps.LatLng(lat, lng);
    geocoder.geocode({'latLng': latlng}, function(results, status) {
      if (status == google.maps.GeocoderStatus.OK) {
        if (results[0]) {               	
          if(where == 'start'){
          		$('#address_start').val(results[0].address_components[0].short_name + ', ' + results[0].address_components[1].short_name + ', ' + results[0].address_components[2].short_name);
          }else
          {
          		$('#address_end').val(results[0].address_components[0].short_name + ', ' + results[0].address_components[1].short_name + ', ' + results[0].address_components[2].short_name);
          }
          console.log(results[0].formatted_address);   
          console.log(results)       
        }
      } else {
        console.log("Reverse geocoder failed due to: " + status);
      }
    });
  }

// get polygon ID
fishnet_id = function fishnet_id(_x, _y){
$.ajax({ 
				type: "POST",
				url: "php/analysis/iso.php",       
				data:{x:_x, y:_y}, 
				async: true,
				success: function(result){																				
					console.log(result);	
					makeLayers(result.id);	

				}, 
			dataType:'json'
			});	

}

// Set up base map
createMap = function (){

		// map options		
		var options = {
			projection: proj_900913,
			units: "m",
			numZoomLevels: 20,
			maxResolution: 15654.0339,
			maxExtent: new OpenLayers.Bounds(-20037508.34, -20037508.34, 20037508.34, 20037508.34),
			displayProjection: proj_900913,			
			controls: [		//remove controls from the screen
				new OpenLayers.Control.Navigation(),
				new OpenLayers.Control.ArgParser(),
				new OpenLayers.Control.Attribution()
			],
			renderers: ["SVG", "Canvas", "VML"]
		};	
		var options2 = {
			projection: proj_900913,
			units: "m",
			numZoomLevels: 20,
			maxResolution: 15654.0339,
			maxExtent: new OpenLayers.Bounds(-20037508.34, -20037508.34, 20037508.34, 20037508.34),
			displayProjection: proj_900913,			
			controls: [		//remove controls from the screen
				new OpenLayers.Control.Navigation(),
				new OpenLayers.Control.ArgParser(),
				new OpenLayers.Control.Attribution()
			]
		};		
					
		//map = new OpenLayers.Map("basicMap", options);
		map = new OpenLayers.Map("basicMap", options2);

		// Use OSM
		osm = new OpenLayers.Layer.OSM();			
		map.addLayer(osm);	 				
				
		// put center point on map (maybe)
		pointStart = new OpenLayers.Layer.Vector("start", {styleMap:startPoint});	   
		map.addLayers([pointStart]);	

		centerMap(-6.26, 53.35)		// center map on Ireland				

		makeLayers(19475);	//  this is the default fishnet_id for loading	   		    	
		
		/* handle sliding*/	
		$("[data-slider]")
	    .bind("slider:ready slider:changed", function (event, data) {
	      $(this)
	        .nextAll(".output:first")
	          .html(data.value.toFixed(0));
	          var val = data.value.toFixed(0);	  
	          $('#slider_output').html(val);        
	          if(val == 5){
	          	$('#user_title').html('What I can I reach in 5 minutes?')
	          	t10.setOpacity(0.7)
				t20.setOpacity(0);
				t30.setOpacity(0);
				t40.setOpacity(0);	
				t50.setOpacity(0);	
				t60.setOpacity(0);	
				t70.setOpacity(0);	
	          }
	          if(val == 10){
	          	$('#user_title').html('What I can I reach in 10 minutes?')
	          	t10.setOpacity(0)
				t20.setOpacity(0.7);
				t30.setOpacity(0);
				t40.setOpacity(0);	
				t50.setOpacity(0);	
				t60.setOpacity(0);	
				t70.setOpacity(0);			
	          }
	          if(val == 15){
	          	$('#user_title').html('What I can I reach in 15 minutes?')
	          	t10.setOpacity(0)
				t20.setOpacity(0);
				t30.setOpacity(0.7);
				t40.setOpacity(0);	
				t50.setOpacity(0);	
				t60.setOpacity(0);	
				t70.setOpacity(0);		
	          }
	          if(val == 20){
	          	$('#user_title').html('What I can I reach in 20 minutes?')
	          	t10.setOpacity(0)
				t20.setOpacity(0);
				t30.setOpacity(0);
				t40.setOpacity(0.7);	
				t50.setOpacity(0);	
				t60.setOpacity(0);	
				t70.setOpacity(0);			
	          }
	          if(val == 25){
	          	$('#user_title').html('What I can I reach in 25 minutes?')
	          	t10.setOpacity(0)
				t20.setOpacity(0);
				t30.setOpacity(0);
				t40.setOpacity(0);	
				t50.setOpacity(0.7);	
				t60.setOpacity(0);	
				t70.setOpacity(0);			
	          }
	          if(val == 30){
	          	$('#user_title').html('What I can I reach in 30 minutes?')
	          	t10.setOpacity(0)
				t20.setOpacity(0);
				t30.setOpacity(0);
				t40.setOpacity(0);	
				t50.setOpacity(0);	
				t60.setOpacity(0.7);	
				t70.setOpacity(0);			
	          }
	          if(val == 35){
	          	$('#user_title').html('What I can I reach in 35 minutes?')
	          	t10.setOpacity(0)
				t20.setOpacity(0);
				t30.setOpacity(0);
				t40.setOpacity(0);	
				t50.setOpacity(0);	
				t60.setOpacity(0);	
				t70.setOpacity(0.7);			
	          }
	    });  	
}

// center map (currently Dublin is hardcoded)
centerMap = function (x, y) {	
	
	var centerPoint = new OpenLayers.LonLat(x, y);		// dublin, zoom 11
	centerPoint.transform(new OpenLayers.Projection("EPSG:4326"), map.getProjectionObject()); 
	map.setCenter(centerPoint, 15); //11

	// reset slider to 15? or not....
	$("[data-slider]").simpleSlider("setValue", 5);
	
}


makeLayers = function(fid){
	
	// first test for existance; if exists destroy
	for (var i=0; i<map.layers.length; i++){
		if(map.layers[i].name == "iso"){map.layers[i].destroy()}
	}	
	
	var mapfile = "http://ncg.urbmet.com/mapserv.cgi?map=../../mapfiles/iso_convex.map"

	t10 = new OpenLayers.Layer.WMS( 
		"iso",
		mapfile, 
		{layers: 't10', fish_id:fid, transparent:true}, 
		{isBaseLayer:false, singleTile:true, ratio:1, opacity:0.7}
    );

	
    t20 = new OpenLayers.Layer.WMS( 
		"iso",
		mapfile, 
		{layers: 't20', fish_id:fid, transparent:true},
		{isBaseLayer:false, singleTile:true, ratio:1, opacity:0}
    );

    t30 = new OpenLayers.Layer.WMS( 
		"iso",
		mapfile, 
		{layers: 't30', fish_id:fid, transparent:true},
		{isBaseLayer:false, singleTile:true, ratio:1, opacity:0}
    );

    t40 = new OpenLayers.Layer.WMS( 
		"iso",
		mapfile, 
		{layers: 't40', fish_id:fid, transparent:true},
		{isBaseLayer:false, singleTile:true, ratio:1, opacity:0}
    );

    t50 = new OpenLayers.Layer.WMS( 
		"iso",
		mapfile, 
		{layers: 't50', fish_id:fid, transparent:true},
		{isBaseLayer:false, singleTile:true, ratio:1, opacity:0}
    );

    t60 = new OpenLayers.Layer.WMS( 
		"iso",
		mapfile, 
		{layers: 't60', fish_id:fid, transparent:true},
		{isBaseLayer:false, singleTile:true, ratio:1, opacity:0}
    );

    t70 = new OpenLayers.Layer.WMS( 
		"iso",
		mapfile, 
		{layers: 't70', fish_id:fid, transparent:false},
		{isBaseLayer:false, singleTile:true, ratio:1, opacity:0}
    );

     map.addLayers([t10, t20, t30, t40, t50, t60, t70]);

}






