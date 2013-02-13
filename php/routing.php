<?php    
//error_reporting(0);				// Turn off all error reporting
error_reporting(E_ALL);				// use during debugging ONLY (this can be a security risk otherwise)

	/********************************/
	// Function to perform routing 
	/********************************/
	function getRoute($con, $start_id, $end_id, $cost){	

		$arrayData = array(); 				// Store geometric results from query in arrays		
		$t1 = array();
		$t2 = array();
		$t3 = array();
		$t4 = array();
		$t5 = array();
		$t6 = array();	
			
		$sql_routing = "SELECT  ST_AsGeoJSON(geom),
								t1, t2, t3, t4, t5, t6
						   FROM dublin_traffic
								JOIN
								   (SELECT * FROM shortest_path('
									  SELECT id AS id, 
										  source::int4 AS source, 
										  target::int4 AS target, 
										  $cost::float8 AS cost
									  FROM dublin_traffic',
								  $start_id,
								  $end_id,
								  false,
								  false)) AS route
							ON
						   dublin_traffic.id = route.edge_id;";

		$query = pg_query($con, $sql_routing);		// Run query	
		$route = array(); 							// Store results in array
		while($r = pg_fetch_row($query) ) {			// Parse results			
				$route[] = $r[0];			
				$t1[] = $r[1];			
				$t2[] = $r[2];		
				$t3[] = $r[3];		
				$t4[] = $r[4];		
				$t5[] = $r[5];		
		}		

		/* function to calculate average */
		function avgT($a){
			return array_sum($a) / count($a);	
		}

	$avgTraffic = array(avgT($t1), avgT($t2), avgT($t3), avgT($t4), avgT($t5));
		  	
				
		return 	array(	'start_id' => $start_id, 
						'end_id' => $end_id,
						't1' => $t1,
						't2' => $t2,
						't3' => $t3,
						't4' => $t4,
						't5' => $t5,	
						'avg' => $avgTraffic,						
						'roads' => $route
						);
							 
	}


?>  




