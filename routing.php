<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" >
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
        <meta name="apple-mobile-web-app-capable" content="yes">                
               
	    <title>cityscale | v6 : routing</title>
	            
        <!-- ########################## LIBRARIES ########################## -->
        <script src="https://maps.googleapis.com/maps/api/js?sensor=false"></script><!-- google: basemap-->    	
    	<!-- <script type="text/javascript" src="lib/jquery.js" ></script>-->	 			<!-- jQuery  --> 
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
		<script type="text/javascript" src="lib/raphael.js"></script>    			<!-- Raphael  -->
		<script type="text/javascript" src="lib/highcharts.js"></script>			<!-- highcharts  -->	   
    	<script type="text/javascript" src="lib/OpenLayers.debug.js"></script> 		<!-- OpenLayers  -->		
		<script type="text/javascript" src="lib/proj4js-combined.js"></script>      <!-- proj4  -->
		<script type="text/javascript" src="lib/spin.js"></script>      			<!-- spin: http://fgnass.github.com/spin.js/ -->
		<script type="text/javascript" src="lib/stamen.js"></script>			    <!-- stamen maps -->
        <script type="text/javascript" src="lib/simple-slider.js"></script>         <!-- slider -->
        
        <!-- ########################## General Scripts ########################## -->
        <script type="text/javascript" src="js/openlayersSettings.js"></script> 		<!-- Openlayers styles  -->		
        <script type="text/javascript" src="js/routing_createMap.js"></script>    		<!-- Make map controls  -->		
		<script type="text/javascript" src="js/routing_mapControls.js"></script>    	<!-- Make map controls  -->						
		<script type="text/javascript" src="js/routing_makeInterface.js"></script>  	<!-- Make raphael interface  -->	
				
		<!-- ########################## NCG Visualization ########################## -->							
		<script type="text/javascript" src="js/routing_query.js"></script>	        <!-- prepare and run queries  -->									
		<script type="text/javascript" src="js/routing_generateReport.js"></script> <!-- report generation --> 
		<script type="text/javascript" src="js/routing_animate.js"></script> 		<!-- make dynamic --> 
		
		<!-- ########################## CSS STYLE ########################## -->            
        <link rel="stylesheet" href="css/routing.css" type="text/css">  
        <link rel="stylesheet" href="css/simple-slider.css" type="text/css"> 
        <link rel="stylesheet" href="css/simple-slider-volume.css" type="text/css">          
        <link rel="icon" type="image/ico" href="favicon.ico" >

	</head>
  
	<body onload="initialize();">

		<!-- Map canvas-->
		<div id="basicMap"></div>	

		<!-- Charts-->
	<!--	<div id="chart-1" class="chart">
	 <table>
    <tr>
        <td class="a">&nbsp;</td>
        <td class="b">&nbsp;</td>
        <td class="c">&nbsp;</td>
        <td class="b">&nbsp;</td>
        <td class="c">&nbsp;</td>
        <td class="a">&nbsp;</td>
        <td class="c">&nbsp;</td>
  </tr>
    <tr>
        <td class="a">&nbsp;</td>
        <td class="b">&nbsp;</td>
        <td class="c">&nbsp;</td>
        <td class="b">&nbsp;</td>
        <td class="c">&nbsp;</td>
        <td class="a">&nbsp;</td>
        <td class="c">&nbsp;</td>
  </tr>
    <tr>
        <td class="a">&nbsp;</td>
        <td class="b">&nbsp;</td>
        <td class="c">&nbsp;</td>
        <td class="b">&nbsp;</td>
        <td class="c">&nbsp;</td>
        <td class="a">&nbsp;</td>
        <td class="c">&nbsp;</td>
  </tr>
    <tr>
        <td class="b">&nbsp;</td>
        <td class="b">&nbsp;</td>
        <td class="c">&nbsp;</td>
        <td class="a">&nbsp;</td>
        <td class="c">&nbsp;</td>
        <td class="a">&nbsp;</td>
        <td class="a">&nbsp;</td>
  </tr>
   <tr>
        <td class="a">&nbsp;</td>
        <td class="c">&nbsp;</td>
        <td class="c">&nbsp;</td>
        <td class="a">&nbsp;</td>
        <td class="c">&nbsp;</td>
        <td class="a">&nbsp;</td>
        <td class="b">&nbsp;</td>
  </tr>
   <tr>
        <td class="c">&nbsp;</td>
        <td class="b">&nbsp;</td>
        <td class="a">&nbsp;</td>
        <td class="c">&nbsp;</td>
        <td class="b">&nbsp;</td>
        <td class="a">&nbsp;</td>
        <td class="b">&nbsp;</td>
  </tr>
   <tr>
        <td class="c">&nbsp;</td>
        <td class="b">&nbsp;</td>
        <td class="a">&nbsp;</td>
        <td class="c">&nbsp;</td>
        <td class="b">&nbsp;</td>
        <td class="a">&nbsp;</td>
        <td class="b">&nbsp;</td>
  </tr>
</table> 
		</div>	-->
			
		<!-- Sidebar controls -->
		<div id="sidebar" >

            <!-- Pan control -->
            <div id="controls-bg"></div>
            <div id="controls"></div>   
    		
    		<!-- enter Origin/Dest-->
    		 <div id = "user_address" class="grayBg"> Analyze Route
    					<div id="circle_start" class="circle"></div><input id="address_start" class="text" type="text" title = "Enter start" value="Raheny, Co. Dublin">  
    					<div id="circle_end" class="circle"></div><input id="address_end" class="text" type="text" title = "Enter end" value="1, Drumalee Dr, Dublin">        
    					<input id="geocode_button" class= "input_button" type="button" value="Get Directions" onclick="codeAddress()">     
    		</div>
    		
            <!--Time slider -->            
            <div id="timer_slider" >                     
                <div class="grayBg">
                    <!--<div id="start_time"></div>-->
                </div> 
                <div id="slider1">
                    <input type="text" data-slider="true" data-slider-range="0,24" data-slider-step="6" data-slider-theme="volume">  
                </div>
            </div> 

            <!--Time Ticker -->
    		<div id="timer" >			
    			<div id="sideOutbg_2" class="grayBg">
    				<div id="timer_div">TIME: 0:00</div>
    			</div>
    		</div> 
    		
            <!--Make Report -->
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