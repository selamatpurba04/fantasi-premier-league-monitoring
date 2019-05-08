<?php
require("id.php");

$result = array();
$temp_array = array();

for( $x = 0; $x < count($temp_uid); $x++){
	$myfile = fopen( "../assets/data/".$temp_uid[$x].".json", "r") or die("Unable to open file!");
	$val = fread($myfile,filesize("../assets/data/".$temp_uid[$x].".json"));
	$val = (array) json_decode($val);
	array_push($temp_array, $val);
}

$temp_points = array();
if( !empty($temp_array) ){
	for ($i=0; $i < 38; $i++) {
		$pointWeek = 0;
		$temp_points[$i] = array();
		for( $x = 0; $x < count($temp_uid); $x++){
			if( isset($temp_array[$x][$i]) ){
				$pointWeek = (int)  $temp_array[$x][$i]->entry_history->points;
				array_push($temp_points[$i], $pointWeek);
			}else{
				break;
			}
		}
	}
}

$temp_goa_perweek = array();
if( !empty($temp_points) ){

	for($i = 0; $i < 38; $i++){
		if( !empty($temp_points[$i]) ){
			$min = min($temp_points[$i]);
			array_push($temp_goa_perweek, array_keys($temp_points[$i], $min));
		}
	}

}

$temp_result = array(
	0,0,0,0,0,0,0
);

if( !empty($temp_goa_perweek) ){

	for($i = 0; $i < 38; $i++){
		if( isset($temp_goa_perweek[$i]) ){
			foreach ($temp_goa_perweek[$i] as $v) {
				$temp_result[$v] += 1;
			}
		}
	}

}

$res = array(
	"label" => "Kali NgeGOA",
	"backgroundColor" => $temp_color[0],
	"borderColor" => $temp_color[0],
	"data" => $temp_result,
	"fill" => false,
);
array_push($result, $res);

echo json_encode($result);