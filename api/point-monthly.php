<?php
require("id.php");

$result = array();
$myfile = fopen( "../assets/dataStatic/phases.json", "r") or die("Unable to open file!");
$valPhases = fread($myfile,filesize("../assets/dataStatic/phases.json"));
$valPhases = (array) json_decode($valPhases);

for( $x = 0; $x < count($temp_uid); $x++){
	$temp_points = array();
	foreach($valPhases['phases'] as $k => $v){
		$val = null;
		$myfile = fopen( "../assets/data/".$temp_uid[$x].".json", "r") or die("Unable to open file!");
		$val = fread($myfile,filesize("../assets/data/".$temp_uid[$x].".json"));
		$val = (array) json_decode($val);
		$lv = 0;
		$nv = 0;

		if(isset($val[$v->start_event - 2]))
			$lv = $val[$v->start_event - 2]->entry_history->total_points;

		for($e = $v->stop_event - 1; $e > $v->start_event - 2; $e--){
			if(isset($val[$e])){
				$nv = $val[$e]->entry_history->total_points - $lv;
				break;
			}
		}
		array_push($temp_points, $nv);
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