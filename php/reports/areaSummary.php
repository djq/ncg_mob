<?
//error_reporting(0);				// Turn off all error reporting
error_reporting(E_ALL);				// use during debugging ONLY (this can be a security risk otherwise)

$pointlist = $_POST['pointlist'];	// Get polygon coordinates from pointlist from post
$key	= $_POST['key'];			//$key	= '3000';	// temp value
$key =''; 							// make the 'key' empty for testing 

// change the working directory
chdir("/home/urbmet/webapps/ncg/reports/".$key);	// set wd

//////////////////////////////////////////////
/// Google excerpt
//////////////////////////////////////////////
	// Define google Query for file generation
	
	$googleUrl = "http://maps.google.com/maps/api/staticmap?size=640x640&maptype=terrain&format=png32&sensor=false&path=color:0x00000000|weight:0|fillcolor:0x666666|";
	$googleUrl = $googleUrl.$pointlist;

	// Create PNG file on server
	$outmap = "googleMap.png";
	$command = "wget -O $outmap \"$googleUrl\"";
	exec($command);
	
	
	
// arguments: [1] folder key [2] pop_plot [3] mat_plot [4] energy_plot [5] popDens [6] mat_inf [7] mat_bldg [8] energy_building [9] energy_trans [10] norm
$wd = '/home/urbmet/webapps/ncg/reports/'.$key;
   


//////////////////////////////////////////////
/// Call Latex to create pdf
//////////////////////////////////////////////
exec("/usr/bin/pdflatex -interaction=nonstopmode -jobname=urbmetReport /home/urbmet/templates/template.tex ");

//////////////////////////////////////////////
/// Return PDF file to user
//////////////////////////////////////////////
$file = "/home/urbmet/webapps/ncg/reports/".$key."urbmetReport.pdf";

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
	echo "http://ncg.urbmet.com/reports/".$key."urbmetReport.pdf";
else
	echo "notFound";

?>
