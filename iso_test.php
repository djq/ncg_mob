<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" >
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
        <meta name="apple-mobile-web-app-capable" content="yes">                
               
	    <title>cityscale | v6 : isochrones</title>
	            
        <!-- ########################## LIBRARIES ########################## -->
        <script src="https://maps.googleapis.com/maps/api/js?sensor=false"></script><!-- google: basemap-->    	
    	<script type="text/javascript" src="lib/jquery.js" ></script>	 			<!-- jQuery  -->
		<script type="text/javascript" src="lib/raphael.js"></script>    			<!-- Raphael  -->
		<script type="text/javascript" src="lib/highcharts.js"></script>			<!-- highcharts  -->	   
    	<script type="text/javascript" src="lib/OpenLayers.debug.js"></script> 		<!-- OpenLayers  -->		
		<script type="text/javascript" src="lib/proj4js-combined.js"></script>      <!-- proj4  -->
		<script type="text/javascript" src="lib/spin.js"></script>      			<!-- spin: http://fgnass.github.com/spin.js/ -->
		<script type="text/javascript" src="lib/stamen.js"></script>				<!-- stamen maps -->
		<script type="text/javascript" src="lib/simple-slider.js"></script>         <!-- slider -->
        
        <!-- ########################## General Scripts ########################## -->
        <script type="text/javascript" src="js/openlayersSettings.js"></script> 		<!-- Openlayers styles  -->		
        <script type="text/javascript" src="js/iso_createMap_con.js"></script>    		<!-- Make map controls  -->		
		<script type="text/javascript" src="js/iso_mapControls.js"></script>    	<!-- Make map controls  -->						
		<script type="text/javascript" src="js/iso_makeInterface.js"></script>  	<!-- Make raphael interface  -->	
		
				
		<!-- ########################## NCG Visualization ########################## -->							
		<script type="text/javascript" src="js/query.js"></script>	<!-- prepare and run queries  -->									
		<script type="text/javascript" src="js/generateReport.js"></script> <!-- report generation --> 
		<script type="text/javascript" src="js/animate.js"></script> 		<!-- make dynamic --> 
		
		<!-- ########################## CSS STYLE ########################## -->            
        <link rel="stylesheet" href="css/iso.css" type="text/css">    
        <link rel="stylesheet" href="css/simple-slider.css" type="text/css"> 
        <link rel="stylesheet" href="css/simple-slider-volume.css" type="text/css">        
        <link rel="icon" type="image/ico" href="favicon.ico" >

	</head>
  
	<body onload="initialize();">

		<!-- Map canvas-->
		<div id="basicMap"></div>	

		<!-- Charts-->
		<div id="chart-1" class="chart">
			[currently uses OSM network with distance as a cost] Isochrones of what can be reached in a certain travel time using car, public-transport, bikes, walking. 
			See <a href="https://github.com/djq/ncg_cityscale/tree/master/sql">github</a> for SQL implementation using pgRouting and functions for Dublin</br></br>
			this works by precalculating shapes based on how far can be travelled up to 2km on the network from the start location; these values are then returned as overlays. 
			These shapes are calculated on a 1km grid so that a user can pull out the shapes near their area of interest based on a geocoded address (grid size can be made smaller)</br></br>
			Contact hit-the-road to see if their routing method can be used?<br/><br/>
			This is closely inspired by Mapumental; contact regarding png / maptile magic?</br></br>
			--</br>
			Once demo is working, see if we would be allowed to overlay daft property rentals on this? </br></br>
		</div>	
			
		<!-- Sidebar controls -->
		<div id="sidebar" >

			  <!-- Pan control -->
            <div id="controls-bg"></div>
            <div id="controls"></div>   	

		
		<!-- enter Origin/Dest-->
		 <div id = "user_address" class="grayBg"><div id="user_title"> What I can I reach in 5 minutes?</div>
					<div id="circle_start" class="circle"></div><input id="address_start" class="text" type="text" title = "Enter start" value="Enter Dublin address">  					
					<input id="geocode_button" class= "input_button" type="button" value="Calculate" onclick="codeAddress()">     
		</div>
		
		<div id="timer" >			
			 <div class="grayBg">
                    <div id="start_time">Time:</div>
                </div> 
                <div id="slider1">
                    <input type="text" data-slider="true" data-slider-values="5, 10, 15, 20, 25, 30, 35" data-slider-theme="volume">  
                    <div id="slider_output">5</div>
                </div>
		</div> 


		
		<div id="sideOut" >			
			<div id="sideOutbg" class="grayBg">

				<div id="spinner"></div>
			</div>
		</div> 
						
		</div>	

		<!-- Report output box -->
		<div id="report" class="grayBg rep">		

			<div id="report-text" clas="rep"></div>		
		</div>					
	
		<!-- No Javscript -->
		<noscript>
			<style type="text/css">
				.pagecontainer {display:none;}
			</style>
			<div class="noscriptmsg" style="color:black">
			:( You don't have javascript enabled. Javascript is required for this site to work. 			
			</div>
		</noscript>
	</body>
</html>