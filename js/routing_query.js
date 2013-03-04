
// remove all layers and points
function clearAll(removePoints){

	
	pointlist = [];					// Clear data point list
	//r_unique = null;				// reset unique id

	// Remove features		
	if(r1.features[0] != null){ 	r1.removeAllFeatures();	}	
	if(r2.features[0] != null){ 	r2.removeAllFeatures();	}	
	if(r3.features[0] != null){ 	r3.removeAllFeatures();	}	
	if(r4.features[0] != null){ 	r4.removeAllFeatures();	}	
	if(r5.features[0] != null){ 	r5.removeAllFeatures();	}	
	//if(r6.features[0] != null){ 	r6.removeAllFeatures();	}	
	
	if(removePoints){
		if(pointStart.features[0] != null){ pointStart.removeAllFeatures();	}		
		if(pointEnd.features[0] != null){ 	pointEnd.removeAllFeatures();	}
	}	

	//$('#timer_div').html('TIME: 0:00')		// reset timer
	$("[data-slider]").simpleSlider("setValue", 0);
	
}


// Create layer from geoJson polygon and load to screen
showGeoJson = function(geoJsonArray, t, layer){
	
	geoJsonArray = eval('[' + geoJsonArray + ']');        
		
	var featurecollection = {
          "type": "FeatureCollection", 
          "features": [
            {"geometry": {
							"type": "GeometryCollection", 
							"geometries": geoJsonArray
		             	}, 
            "type": "Feature", 
            "properties": {
				width: t[0], vol: [eval(t[0]), eval(t[1]), eval(t[2]), eval(t[3]), eval(t[4])]			
            }
         }] 
       };
     
	var geojson_format = new OpenLayers.Format.GeoJSON();
	layer.addFeatures(geojson_format.read(featurecollection));
}

getColor = function (val) {    
   
    return val > 6 ? '#800026' :
           val > 5 ? '#BD0026' :
           val > 4 ? '#E31A1C' :
           val > 3 ? '#FC4E2A' :
           val > 2 ? '#FD8D3C' :
           val > 1 ? '#FEB24C' :
           val > 0  ? '#FED976' :
                      '#FFEDA0' ;
}

showGeoJsonRoutes = function(geoJsonArray, layer){
	
	geoJsonArray = eval('[' + geoJsonArray + ']');        
		
	var featurecollection = {
          "type": "FeatureCollection", 
          "features": [
            {"geometry": {
							"type": "GeometryCollection", 
							"geometries": geoJsonArray
		             	}, 
            "type": "Feature", 
            "properties": {
				//width: t[0] * 2,
				myColor: function(){return "red"}	//getColor(t[0]) //				
            }
         }] 
       };
     
	var geojson_format = new OpenLayers.Format.GeoJSON();
	layer.addFeatures(geojson_format.read(featurecollection));
}








