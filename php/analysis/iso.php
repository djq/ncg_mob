<?php    
//error_reporting(0);				// Turn off all error reporting
error_reporting(E_ALL);				// use during debugging ONLY (this can be a security risk otherwise)
include('../reports/dynamicValues.php');
include('/home/urbmet/server_connections/linode_ncg.php');

$msc = microtime(true);				// time query - start timer
$x = $_POST['x'];
$y = $_POST['y'];
	
//////////////////////////////////////////////
// Connect to Database and Analyze
//////////////////////////////////////////////
	// open connection to linode!
	if (!$con){echo 'error connecting'; die; }	

	$sql = "select fish_id
			FROM _fishnet_dublin
			WHERE ST_Intersects(geom, ST_Transform(ST_SetSRID(ST_MakePoint($x, $y), 4326),900913))";

	$query = pg_query($con, $sql);
	$id = pg_fetch_result($query, 0); 

	/********************************/
	// identify fishnet cell
	/********************************/										
	$msc=round(microtime(true)-$msc, 2); $querytime = "$msc s"; // end timing; format string;
	$queryData = array('querytime' => $querytime, 'id' => $id, 'x' => $x, 'y' => $y );	

	echo json_encode($queryData);		// return polygon ID to browser? or could I call Mapserver from here......

	//////////////////////////////////////////////
	/// LaTeX Output
	//////////////////////////////////////////////
	/*
	$key=''; // tmp
	//mkdir("/home/urbmet/webapps/ncg/reports/".$key);	//tmp
	chdir("/home/urbmet/webapps/ncg/reports/".$key);	// set wd
	$file =  "dynamicValues.tex";	// write latex file		
	$texString = makeLatexString( 'Dublin' );				
	file_put_contents($file, $texString);
	*/

// Close connection								
pg_close($con); 	

?>  




