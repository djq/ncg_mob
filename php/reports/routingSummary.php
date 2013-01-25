<?
//error_reporting(0);				// Turn off all error reporting
error_reporting(E_ALL);				// use during debugging ONLY (this can be a security risk otherwise)

$key = $_POST['key'];				// $key	= '3000'	 temp value
$key =''; 							// make the 'key' empty for testing 
$r_id = $_POST['r_id'];

// change the working directory
chdir("/home/urbmet/webapps/ncg/reports/".$key);	// set wd
$wd = '/home/urbmet/webapps/ncg/reports/'.$key;

// get stored extent of route
$con = pg_connect('host=178.79.170.172 port=5432 dbname=routing user=postgres password=s0meth1ng');  // open connection to linode
if (!$con){echo 'error connecting'; die; }	
$sql = "SELECT extent, bounds FROM tmp.extent WHERE r_id = $r_id"; 
$query = pg_query($con, $sql);
$ext = pg_fetch_result($query, 0, 0);
$bounds = pg_fetch_result($query, 0, 1);

//$ext="-693990.129101548 7038781.40567537 -687395.918689323 7053672.66421891";



//////////////////////////////////////////////
/// OSM excerpt
//////////////////////////////////////////////
	// Define google Query for file generation
	/*
	$googleUrl = "http://maps.google.com/maps/api/staticmap?size=640x640&maptype=terrain&format=png32&sensor=false&path=color:0x00000000|weight:0|fillcolor:0x666666|";
	$googleUrl = $googleUrl.$pointlist;

	// Create PNG file on server
	$outmap = "googleMap.png";
	$command = "wget -O $outmap \"$googleUrl\"";
	exec($command);	*/

	//$outmap = "http://pafciu17.dev.openstreetmap.org/?module=map&bbox=".$bounds."&height=805";
	//$command = 'wget "http://pafciu17.dev.openstreetmap.org/?module=map&bbox=0,70,40,50&width=600&height=800" -O basemap.png';
	//$command = 'wget "'.$outmap.'" -O basemap.png';
	//echo($command);
	//exec($command);

// mapserver calls

exec('wget "ncg.urbmet.com/mapserv.cgi?map=../../mapfiles/demo_sub.map&layer=t1&layer=dublin_all&layer=start&layer=end&r_id='.$r_id.'&MAPEXT='.$ext.'&mode=map&FORMAT=image/png" -O routeMap.png');
exec('wget "ncg.urbmet.com/mapserv.cgi?map=../../mapfiles/demo_sub.map&layer=t1&layer=dublin_main&layer=start&layer=end&r_id='.$r_id.'&MAPEXT='.$ext.'&mode=map&FORMAT=image/png" -O routeMap1.png');
exec('wget "ncg.urbmet.com/mapserv.cgi?map=../../mapfiles/demo_sub.map&layer=t2&layer=dublin_main&layer=start&layer=end&r_id='.$r_id.'&MAPEXT='.$ext.'&mode=map&FORMAT=image/png" -O routeMap2.png');
exec('wget "ncg.urbmet.com/mapserv.cgi?map=../../mapfiles/demo_sub.map&layer=t3&layer=dublin_main&layer=start&layer=end&r_id='.$r_id.'&MAPEXT='.$ext.'&mode=map&FORMAT=image/png" -O routeMap3.png');
exec('wget "ncg.urbmet.com/mapserv.cgi?map=../../mapfiles/demo_sub.map&layer=t4&layer=dublin_main&layer=start&layer=end&r_id='.$r_id.'&MAPEXT='.$ext.'&mode=map&FORMAT=image/png" -O routeMap4.png');
exec('wget "ncg.urbmet.com/mapserv.cgi?map=../../mapfiles/demo_sub.map&layer=t5&layer=dublin_main&layer=start&layer=end&r_id='.$r_id.'&MAPEXT='.$ext.'&mode=map&FORMAT=image/png" -O routeMap5.png');
 
	
//////////////////////////////////////////////
/// Call Latex to create pdf
//////////////////////////////////////////////
exec("/home/urbmet/texlive/bin/i386-linux/pdflatex -interaction=nonstopmode -jobname=cityScaleRoutingReport /home/urbmet/templates/template_routing.tex");

//////////////////////////////////////////////
/// Return PDF file to user
//////////////////////////////////////////////
$file = "/home/urbmet/webapps/ncg/reports/".$key."cityScaleRoutingReport.pdf";

$time = 5; //how long in seconds do you allow your program to run/search
$found = false;
for($i=0; $i<$time; $i++){
 
    if(file_exists($file)){          
        $found = true;	// Found it
        break;
    }
    sleep(1); // if not found wait one second before continue looping
}

// Check if pdf build was succesful
if($found)
	echo "http://ncg.urbmet.com/reports/".$key."cityScaleRoutingReport.pdf";
else
	echo "notFound";

?>
