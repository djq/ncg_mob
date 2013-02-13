<?php    
//error_reporting(0);				// Turn off all error reporting
error_reporting(E_ALL);				// use during debugging ONLY (this can be a security risk otherwise)
include('routing.php');
include('/home/urbmet/server_connections/linode_ncg.php');

$msc = microtime(true);				// time query - start timer
$key =''; 							// make the 'key' empty for testing 

$r_id = $_POST['r_id']; 
$start_id = $_POST['start_id']; 
$end_id = $_POST['end_id']; 
$cost = $_POST['cost'];

/********************************/
// Connect to Database and Analyze
/********************************/
	// open connection to linode
	if (!$con){echo 'error connecting'; die; }	
				
	$routeData = getRoute($con, $start_id, $end_id, $cost);	// call routing function
	
	/********************************/
	// organize and return datanons
	/********************************/										
	$msc=round(microtime(true)-$msc, 2); $querytime = "$msc s"; // end timing; format string;
	$queryData = array('query_time' => $querytime, 'id_start' => $start_id, 'id_end' => $end_id, 'r_id' => $r_id);	
	$result = array_merge($queryData, $routeData);
	echo json_encode($result);		

	// currently removed reporting while I figure out how to make different routes work

// Close connection								
pg_close($con); 	

?>  




