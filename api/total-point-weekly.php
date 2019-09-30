<?php
require("id.php");

$result = array();

for( $x = 0; $x < count($temp_uid); $x++){
	$temp_points = array();
	$val = null;
	$pointWeek = 0;
	$myfile = fopen( "../assets/data/".$temp_uid[$x].".json", "r") or die("Unable to open file!");
	$val = fread($myfile,filesize("../assets/data/".$temp_uid[$x].".json"));
	$val = (array) json_decode($val);
	for ($i=0; $i < count($val); $i++) { 
		$pointWeek = (int)  $val[$i]->entry_history->total_points;
		array_push($temp_points, $pointWeek);
	}

	$res = array(
		"label" => $temp_name[$x],
		"backgroundColor" => $temp_color[$x],
		"borderColor" => $temp_color[$x],
		"data" => $temp_points,
		"fill" => false,
	);
	array_push($result, $res);
}

echo json_encode($result);