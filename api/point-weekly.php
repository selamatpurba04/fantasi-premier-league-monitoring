<?php
require("id.php");

$datasets = array();

for( $x = 0; $x < count($temp_uid); $x++){
	$temp_points = array();
	$temp_chips = array();
	$val = null;
	$myfile = fopen( "../assets/data/".$temp_uid[$x].".json", "r") or die("Unable to open file!");
	$val = fread($myfile,filesize("../assets/data/".$temp_uid[$x].".json"));
	$val = (array) json_decode($val);
	for ($i=$startGW -1; $i < count($val); $i++) {
		array_push($temp_points, $val[$i]->entry_history->points);
		array_push($temp_chips, $val[$i]->active_chip);
	}

	$res = array(
		"label" => $temp_name[$x],
		"backgroundColor" => $temp_color[$x],
		"borderColor" => $temp_color[$x],
		"data" => $temp_points,
		"chips" => $temp_chips,
		"fill" => false
	);
	array_push($datasets, $res);
}

$rest = (object) [
	'startGW' => $startGW,
	'currentGW' => $currentGW,
	'datasets' => $datasets
];

echo json_encode($rest);