<?php    
//error_reporting(0);				// Turn off all error reporting
error_reporting(E_ALL);				// use during debugging ONLY (this can be a security risk otherwise)
include('routing.php');
include('/home/urbmet/server_connections/linode_ncg.php');

$msc = microtime(true);				// time query - start timer
$key =''; 							// make the 'key' empty for testing 

// restructure as array
$x1 = $_POST['x1']; 
$y1 = $_POST['y1'];
$x2 = $_POST['x2']; 
$y2 = $_POST['y2']; 
$r_id = $_POST['r_id']; 
$start_ad = $_POST['start_ad']; 
$end_ad = $_POST['end_ad']; 

//////////////////////////////////////////////
// Connect to Database and Analyze
//////////////////////////////////////////////
	// open connection to linode
	if (!$con){echo 'error connecting'; die; }	
	
	$sql = 	"SELECT source
	 		FROM dublin_traffic
	 		WHERE ST_DWithin(ST_Transform(st_setsrid(st_makepoint($y1, $x1),4326), 900913), geom, 100.0) 
			ORDER BY geom <-> ST_Transform(st_setsrid(st_makepoint($y1, $x1),4326), 900913)
			LIMIT 1;";

	$query = pg_query($con, $sql);								// run query
	$id_start = pg_fetch_result($query, 0, 0); 		

	$sql = "SELECT i.target
			FROM dublin_traffic as i			
			WHERE ST_DWithin(ST_Transform(st_setsrid(st_makepoint($y2, $x2),4326), 900913), geom, 100.0) 
			ORDER BY geom <-> ST_Transform(st_setsrid(st_makepoint($y2, $x2),4326), 900913)
			LIMIT 1;";

	$query = pg_query($con, $sql);								// run query
	$id_end = pg_fetch_result($query, 0, 0); 		
	
	// call routing function	
	$routeData = getRoute($con, $id_start, $id_end, 't1');
	
	/********************************/
	// organize and return data
	/********************************/										
	$msc=round(microtime(true)-$msc, 2); $querytime = "$msc s"; // end timing; format string;
	$queryData = array('x1' => $x1, 'y1' => $y1, 'x2' => $x2, 'y2' => $y1,'query_time' => $querytime, 'id_start' => $id_start, 'id_end' => $id_end,
						'r_id' => $r_id);	
	$result = array_merge($queryData, $routeData);

	echo json_encode($result);		// return values to browser for updating 

// Close connection								
pg_close($con); 	

?>  




