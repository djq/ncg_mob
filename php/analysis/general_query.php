<?php    
//error_reporting(0);				// Turn off all error reporting
error_reporting(E_ALL);				// use during debugging ONLY (this can be a security risk otherwise)
include('../reports/dynamicValues.php');

$msc = microtime(true);				// time query - start timer
$zoom = $_POST['zoom'];
$polygon = $_POST['vertices']; 
$polygon = implode(',', $polygon);


$subquery = "'SRID=900913;POLYGON(($polygon))'::geometry"; 	// using the google proj
//echo $subquery;
	
//////////////////////////////////////////////
// Connect to Database and Analyze
//////////////////////////////////////////////
	$con = pg_connect('host=178.79.170.172 port=5432 dbname=routing user=postgres password=s0meth1ng');  // open connection to linode!
	if (!$con){echo 'error connecting'; die; }	
	
	/*
	$sql = "SELECT 
			AVG(pop_den)	
		 FROM	
			public.pop
		 WHERE 
			ST_Intersects(ST_Centroid(geom), $subquery)";

	$query = pg_query($con, $sql);								// run query
	$avgPopDen = ROUND(pg_fetch_result($query, 0, 0), 2); 	// Round query result to two 	
	*/
	
	/********************************/
	// get polygon geometry from a table 
	/********************************/
	$arrayData = array(); 				// Store geometric results from query in arrays		
	$t1 = array();
	$t2 = array();
	$t3 = array();
	$t4 = array();
	$t5 = array();
	$t6 = array();
	
	$sql = "SELECT 
				ST_AsGeoJSON(															
					ST_Intersection(geom, $subquery)
							),
				t1, t2, t3, t4, t5, t6
			 FROM	
				dublin_traffic
			 WHERE 
				ST_Intersects(geom, $subquery)";					

	$query = pg_query($con, $sql);		// Run detailed query on relevant table	
	
	
	$count=pg_num_rows($query);
	if($count < 1500){		
		while($r = pg_fetch_row($query)) {	// Parse results
			$arrayData[] = $r[0];
			$t1[] = $r[1];			
			$t2[] = $r[2];		
			$t3[] = $r[3];		
			$t4[] = $r[4];		
			$t5[] = $r[5];		
			//$t6[] = $r[6];		
			}	
	}
	else{
		$arrayData = 0;
		$t1 = 0;
	}
	
	/* function to calculate average */
	function avgT($a){
		return array_sum($a) / count($a);
	
	}

	$avgTraffic = array(avgT($t1), avgT($t2), avgT($t3), avgT($t4), avgT($t5));


	/********************************/
	// organize and return data
	/********************************/										
	$msc=round(microtime(true)-$msc, 2); $querytime = "$msc s"; // end timing; format string;
		$queryData = array('vectorCount' => $count, 'zoom' => $zoom, 'time' => $querytime, 'polygons'=> $arrayData, 
	't1' => $t1,
	't2' => $t2,
	't3' => $t3,
	't4' => $t4,
	't5' => $t5,
	//'t6' => $t6,
	'avg' => $avgTraffic
	);	
	echo json_encode($queryData);		// return values to browser for updating 

	//////////////////////////////////////////////
	/// LaTeX Output
	//////////////////////////////////////////////
	$key=''; // tmp
	//mkdir("/home/urbmet/webapps/ncg/reports/".$key);	//tmp
	chdir("/home/urbmet/webapps/ncg/reports/".$key);	// set wd
	$file =  "dynamicValues.tex";	// write latex file		
	$texString = makeLatexString( 'Dublin' );				
	file_put_contents($file, $texString);

// Close connection								
pg_close($con); 	

?>  




