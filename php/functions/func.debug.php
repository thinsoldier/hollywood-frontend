<?php


/**
* Replacement for preprintr and htmlprintr.
* Silently returns print_r wrapped in a PRE tag.
* @param $data array
* @param $label string
* @param $htmlentities bool
*/

function tellme($data, $label=null, $htmlentities=false)
{
	$output = '<pre class="showme debug">';
	$output .= "<div class=\"debuglabel\"><b>$label</b></div>";
	$output .= '<div class="debuginfo">';
		$print = print_r($data, true);
		if($htmlentities){ $print = htmlentities($print); }
	$output .= $print;
	$output .= '</div>';
	$output .= '</pre>';
	
	return $output;
}

/**
* Does not return anything, it just echoes results of tellme
*/
function showme($data, $label=null, $htmlentities=false)
{
	echo tellme($data, $label, $htmlentities);
}

?>