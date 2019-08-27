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
				$pointWeek = (int)  $temp_array[$x][$i]->entry_history->total_points;
				array_push($temp_points[$i], $pointWeek);
			}else{
				break;
			}
		}
	}

}

$temp_win_perweek = array();
if( !empty($temp_points) ){

	for($i = 0; $i < 38; $i++){
		if( !empty($temp_points[$i]) ){
			$max = max($temp_points[$i]);
			array_push($temp_win_perweek, array_search($max, $temp_points[$i]));
		}else
			break;
	}

}

$temp_result = array( 0,0,0,0,0,0,0,0 );
$gw = array([], [], [], [], [] ,[], [], [] );

if( !empty($temp_win_perweek) ){
	for($i = 0; $i < 38; $i++){
		if( isset($temp_win_perweek[$i]) ){
			$temp_result[$temp_win_perweek[$i]] += 1;
			array_push($gw[$temp_win_perweek[$i]], $i+1);
		}else
			break;
	}
}

$res = array(
	"label" => "Kali Juara",
	"backgroundColor" => $temp_color[0],
	"borderColor" => $temp_color[0],
	"data" => $temp_result,
	"gw" => $gw,
	"fill" => false,
);
array_push($result, $res);

echo json_encode($result);