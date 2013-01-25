<?php  
/************************************/
// get values from query, insert them in latex
/***********************************/
function makeLatexString(
	$city			
){	

$str = <<<EOD
% map
\\put(100,-55){\\mbox{\\textbf{City}: $city}}											% MAP TITLE
\\put(0,-350){\\mbox{\\includegraphics[width=0.5\\linewidth]{googleMap.png}}}			% MAP

EOD;

return $str;
}

?>  