<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" >
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
        <meta name="apple-mobile-web-app-capable" content="yes">                
               
	    <title>cityscale | v6 : area assessment</title>
	            
        <!-- ########################## LIBRARIES ########################## -->
        <script src="https://maps.googleapis.com/maps/api/js?sensor=false"></script><!-- google: basemap-->    	
    	<script type="text/javascript" src="lib/jquery.js" ></script>	 			<!-- jQuery  -->
		<script type="text/javascript" src="lib/raphael.js"></script>    			<!-- Raphael  -->
		<script type="text/javascript" src="lib/highcharts.js"></script>			<!-- highcharts  -->	   
    	<script type="text/javascript" src="lib/OpenLayers.debug.js"></script> 		<!-- OpenLayers  -->		
		<script type="text/javascript" src="lib/proj4js-combined.js"></script>      <!-- proj4  -->
		<script type="text/javascript" src="lib/spin.js"></script>      			<!-- spin: http://fgnass.github.com/spin.js/ -->
		<script type="text/javascript" src="lib/stamen.js"></script>
        
        <!-- ########################## General Scripts ########################## -->
        <script type="text/javascript" src="js/openlayersSettings.js"></script> <!-- Openlayers styles  -->		
        <script type="text/javascript" src="js/area_createMap.js"></script>    		<!-- Make map controls  -->		
		<script type="text/javascript" src="js/area_mapControls.js"></script>    	<!-- Make map controls  -->						
		<script type="text/javascript" src="js/area_makeInterface.js"></script>  	<!-- Make raphael interface  -->	
				
		<!-- ########################## NCG Visualization ########################## -->				
		<script type="text/javascript" src="js/area_createCharts.js"></script>  	<!-- create charts  -->						
		<script type="text/javascript" src="js/query.js"></script>	<!-- prepare and run queries  -->									
		<script type="text/javascript" src="js/generateReport.js"></script> <!-- report generation --> 
		<script type="text/javascript" src="js/animate.js"></script> 		<!-- make dynamic --> 
		
		<!-- ########################## CSS STYLE ########################## -->            
        <link rel="stylesheet" href="css/area.css" type="text/css">          
        <link rel="icon" type="image/ico" href="favicon.ico" >

	</head>
  
	<body onload="initialize();">

		<!-- Map canvas-->
		<div id="basicMap"></div>
	
		<!-- Analysis Zone Tags -->
		<div id="tag-0" class="tag"></div> 
		<div id="tag-1" class="tag"></div>
		<div id="tag-2" class="tag"></div>
		<div id="tag-3" class="tag"></div>
		<div id="tag-4" class="tag"></div>
		<div id="tag-5" class="tag"></div>
		<div id="tag-6" class="tag"></div>
		<div id="tag-7" class="tag"></div>
		<div id="tag-8" class="tag"></div>		
		
		<!-- Charts-->
		<div id="chart-1" class="chart"></div>
		<div id="chart-2" class="chart"></div>
		<div id="chart-3" class="chart"></div>
			
		<!-- Sidebar controls -->
		<div id="sidebar" >

			<!-- Pan control -->
			<div id="controls-bg"></div>
			<div id="controls"></div>	


		<div id="sideIn" >
			<div id="sideInbg" class="grayBg"></div>
		</div>
		
		<div id="timer" >			
			<div id="sideOutbg" class="grayBg">
				<div id="timer_div">TIME: </div>
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
			You don't have javascript enabled. Javascript is required for this site to work. 			
			</div>
		</noscript>
	</body>
</html>