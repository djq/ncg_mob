<?php    
//error_reporting(0);				// Turn off all error reporting
error_reporting(E_ALL);				// use during debugging ONLY (this can be a security risk otherwise)
include('routing.php');
include('../reports/dynamicRoutingValues.php');

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
	$con = pg_connect('host=178.79.170.172 port=5432 dbname=routing user=postgres password=s0meth1ng');  // open connection to linode
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

	
	/********************************/
	/********************************/	
	// REPORTING 	
	/********************************/
	/********************************/	
	
	/********************************/
	// run again to store in table for mapserver
	/********************************/	
	$sql_routing_2 = "INSERT INTO tmp.routes(r_id, geom, t1, t2, t3, t4, t5, t6, congestrank)
					  SELECT $r_id, geom, t1, t2, t3, t4, t5, t6, 0
					  FROM dublin_traffic
							JOIN
							   (SELECT * FROM shortest_path('
								  SELECT id AS id, 
									  source::int4 AS source, 
									  target::int4 AS target, 
									  cost::float8 AS cost
								  FROM dublin_traffic',
							  $id_start,
							  $id_end,
							  false,
							  false)) AS route
						ON
					   dublin_traffic.id = route.edge_id;";

	$query = pg_query($con, $sql_routing_2);						// run query	

	// add a congestion ranking
	
	$congest=  "UPDATE tmp.routes a
				SET    congestrank = x.rn
				FROM (
				    SELECT t6, geom, row_number() OVER (ORDER BY t6 DESC) AS rn
				    FROM   tmp.routes  
				    WHERE   r_id = $r_id
				    AND t1 > 3
				    --AND t2 < 5
				    --ORDER  BY t6 DESC
				    LIMIT  10
				    ) x
				WHERE x.geom = a.geom;";
	$query = pg_query($con, $congest);						// run query	
	

	// also store extents of query in another table for MAPEXT runtime substitution
	$sql_extent = "SELECT ST_Extent(ST_Buffer(geom, 300)) FROM tmp.routes WHERE r_id = $r_id"; // buffer geom to add a small amount of spacing
	$query = pg_query($con, $sql_extent);
	$ext = pg_fetch_result($query, 0, 0);
	$ext = preg_replace('/^BOX\(/', '', $ext);	// this is a pretty messy regex to convert BBOX to a format that mapserver accepts
	$ext = preg_replace('/,/', ' ', $ext);
	$ext = preg_replace('/\)/', '', $ext);	
	//echo($ext);

	// now insert into table with r_id
	$sql_route_extent = "INSERT INTO tmp.extent(r_id, extent) VALUES ($r_id, '$ext')";
	$query = pg_query($con, $sql_route_extent);

	// also, add start and end points as geom points to extent table
	$sql_update = "UPDATE tmp.extent
	 				SET r_start = ST_Transform(st_setsrid(st_makepoint($y1, $x1),4326), 900913),
	 					r_end   = ST_Transform(st_setsrid(st_makepoint($y2, $x2),4326), 900913)"; 
	$query = pg_query($con, $sql_update);

	// add a query string for the static map
	$sql_bounds = "select 
						st_xmin(st_extent(st_transform(ST_Buffer(geom, 300), 4326))),
						st_ymax(st_extent(st_transform(ST_Buffer(geom, 300), 4326))),						
						st_xmax(st_extent(st_transform(ST_Buffer(geom, 300), 4326))),
						st_ymin(st_extent(st_transform(ST_Buffer(geom, 300), 4326)))						
					from tmp.routes
					where r_id = $r_id;";
	$query = pg_query($con, $sql_bounds);
	$bounds = pg_fetch_row($query);
	$bounds = implode(",", $bounds);
	$sql_update_bounds = "UPDATE tmp.extent SET bounds = '$bounds'"; 
	$query = pg_query($con, $sql_update_bounds);

	//////////////////////////////////////////////
	/// LaTeX Output
	//////////////////////////////////////////////
	//mkdir("/home/urbmet/webapps/ncg/reports/".$key);	//tmp
	chdir("/home/urbmet/webapps/ncg/reports/".$key);	// set wd
	$file =  "dynamicRoutingValues.tex";	// write latex file		
	$texString = makeLatexString( $start_ad, $end_ad);				
	file_put_contents($file, $texString); 

// Close connection								
pg_close($con); 	

?>  




