<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" >
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
        <meta name="apple-mobile-web-app-capable" content="yes">                
               
	    <title>cityscale | v6</title>
	            
        <!-- ########################## LIBRARIES ########################## -->     	
    	<script type="text/javascript" src="lib/jquery.js" ></script>	 			<!-- jQuery  -->
		<script type="text/javascript" src="lib/raphael.js"></script>    			<!-- Raphael  -->

        
        <!-- ########################## General Scripts ########################## -->
        <script type="text/javascript" src="js/intro.js"></script> 	<!-- Intro functionality  -->		      
		
		<!-- ########################## CSS STYLE ########################## -->            
        <link rel="stylesheet" href="css/intro.css" type="text/css">          
        <link rel="icon" type="image/ico" href="favicon.ico" >
         <link href='http://fonts.googleapis.com/css?family=Glegoo' rel='stylesheet' type='text/css'>

	</head>
<body onload="intro()">
	<div id="gradient-bg" class="footer"></div>
	<div id="roads" class="footer"></div>

	<div class="wrapper">
	<div id="worktitle">cityscale:dublin</div>
	<a href="http://ncg.urbmet.com/v6/routing.php">
		<div id="v1" class="version">
			<div class="title">Optimize Routing</div>
				<div class="progress">	
				Best time and route to go from A to B			
				</div>
		</div>
	</a>

	<a href="http://ncg.urbmet.com/v6/area.php">
		<div id="v2" class="version">
			<div class="title">Area Assessment</div>
				<div class="progress">				
				How much congestion is in this area?
				How walkable is it?
				</div>
		</div>
	</a>

	<a href="http://ncg.urbmet.com/v6/iso.php">
		<div id="v3" class="version">
			<div class="title">How far can I travel?</div>
			<div class="progress">		
			See how far you can travel from your home in 30 minutes using car, public-transport, or cycling			
			</div>
		</div>
	</a>

</div>



</body>


</html>