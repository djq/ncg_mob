<?php  
/************************************/
// get values from query, insert them in latex
/***********************************/
function makeLatexString(
	$start, $end			
){	

$str = <<<EOD

\\put(350,-55){\\mbox{\\textbf{Routing Summary}}}					% Routing Summary
\\put(310,-72){\\mbox{	
		\\footnotesize	
		\\begin{tabular}{ p{8em}  l }	
		\\hline				
		\\rule{0pt}{2ex}\\hspace{1em}Start				& $start				 	\\\\	
		\\hline	
		\\rule{0pt}{2ex}\\hspace{1em}Destination		& $end				 		\\\\	
		\\hline
		\\end{tabular}
	}}	
\\definecolor{tempgreen}{RGB}{34,139,34} 
\\definecolor{temporange}{RGB}{255, 140, 0}  
\\definecolor{tempred}{RGB}{255,0,0}  

\\put(312,-67.5){
	\\begin{tikzpicture}		
		\\draw[tempgreen, fill=tempgreen] (0,0) circle (0.1);		
	\\end{tikzpicture} 
}

\\put(312,-78.7){
	\\begin{tikzpicture}		
		\\draw[tempred, fill=tempred] (0,0) circle (0.1);		
	\\end{tikzpicture} 
}


\\put(350,-130){\\mbox{\\textbf{Route Patterns}}}					% Routing Patterns

% route segment coloring

\\put(310,-190){\\mbox{	
		\\footnotesize	
		\\begin{tabular}{ r | l l l l l l }	
		\\hline				
		\\rule{0pt}{2ex}Road & 00 & 04 & 08 & 12 & 16 & 20		\\\\	
		\\hline	
		\\rule{0pt}{2ex}1		
				& \\cellcolor{temporange} &  \\cellcolor{tempgreen} &  \\cellcolor{temporange} &  \\cellcolor{tempgreen} &  \\cellcolor{tempred} &  \\cellcolor{tempgreen}			 	\\\\	
		2		& \\cellcolor{tempgreen}	&  \\cellcolor{tempgreen} &  \\cellcolor{temporange} &  \\cellcolor{tempgreen} &  \\cellcolor{tempgreen} &  \\cellcolor{temporange}		 		\\\\	
		3		& \\cellcolor{tempred}			&  \\cellcolor{tempgreen} &  \\cellcolor{tempgreen} &  \\cellcolor{temporange} &  \\cellcolor{tempred} &  \\cellcolor{tempgreen} 		\\\\
		4		& \\cellcolor{tempred}			&  \\cellcolor{temporange} &  \\cellcolor{tempred} &  \\cellcolor{tempgreen} &  \\cellcolor{tempgreen} &  \\cellcolor{temporange} 		\\\\	
		5		& \\cellcolor{tempgreen}			&  \\cellcolor{temporange} &  \\cellcolor{tempred} &  \\cellcolor{temporange} &  \\cellcolor{tempgreen} &  \\cellcolor{tempgreen} 		\\\\
		6		& \\cellcolor{tempgreen}	&  \\cellcolor{tempgreen} &  \\cellcolor{tempred} &  \\cellcolor{tempgreen} &  \\cellcolor{tempgreen} &  \\cellcolor{temporange}		 		\\\\	
		7		& \\cellcolor{tempred}			&  \\cellcolor{tempgreen} &  \\cellcolor{tempred} &  \\cellcolor{tempgreen} &  \\cellcolor{tempred} &  \\cellcolor{tempgreen} 		\\\\	
		8		& \\cellcolor{temporange}&  \\cellcolor{temporange} &  \\cellcolor{tempgreen} &  \\cellcolor{temporange} &  \\cellcolor{tempred} &  \\cellcolor{temporange}			 	\\\\	
		9		& \\cellcolor{tempred}			&  \\cellcolor{temporange} &  \\cellcolor{temporange} &  \\cellcolor{temporange} &  \\cellcolor{tempgreen} &  \\cellcolor{temporange} 		\\\\	
		10		& \\cellcolor{tempgreen}&  \\cellcolor{temporange} &  \\cellcolor{tempgreen} &  \\cellcolor{temporange} &  \\cellcolor{tempgreen} &  \\cellcolor{tempgreen}			 		\\\\			
		\\end{tabular}
	}}

\\put(350,-275){\\mbox{\\textbf{Explanation}}}					% Routing explanation
\\put(310,-290){\\mbox{Each road that you travel on is shown, coloured}}
\\put(310,-300){\\mbox{by congestion for each time of day. The numbers }}
\\put(310,-310){\\mbox{correspond to the map (at the moment they don't }}
\\put(310,-320){\\mbox{as this is a test, but they can!)}}

EOD;

return $str;
}

?>  