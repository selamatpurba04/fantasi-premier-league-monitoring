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
$temp_noob_perweek = array();
if( !empty($temp_points) ){

	for($i = 0; $i < 38; $i++){
		if( !empty($temp_points[$i]) ){
			$max = max($temp_points[$i]);
			array_push($temp_win_perweek, array_search($max, $temp_points[$i]));

			$min = min($temp_points[$i]);
			array_push($temp_noob_perweek, array_search($min, $temp_points[$i]));
		}else
			break;
	}

}

$temp_result_win = array( 0,0,0,0,0,0,0,0 );
$gw_win = array([], [], [], [], [] ,[], [], [] );

if( !empty($temp_win_perweek) ){
	for($i = 0; $i < 38; $i++){
		if( isset($temp_win_perweek[$i]) ){
			$temp_result_win[$temp_win_perweek[$i]] += 1;
			array_push($gw_win[$temp_win_perweek[$i]], $i+1);
		}else
			break;
	}
}

$temp_result_noob = array( 0,0,0,0,0,0,0,0 );
$gw_noob = array([], [], [], [], [] ,[], [], [] );

if( !empty($temp_noob_perweek) ){
	for($i = 0; $i < 38; $i++){
		if( isset($temp_noob_perweek[$i]) ){
			$temp_result_noob[$temp_noob_perweek[$i]] += 1;
			array_push($gw_noob[$temp_noob_perweek[$i]], $i+1);
		}else
			break;
	}
}

$res_win = array(
	"label" => "Kali Top Klasemen",
	"backgroundColor" => $temp_color[0],
	"borderColor" => $temp_color[0],
	"data" => $temp_result_win,
	"gw" => $gw_win,
	"fill" => false,
);

$res_noob = array(
	"label" => "Kali Underdog Klasemen",
	"backgroundColor" => $temp_color[2],
	"borderColor" => $temp_color[0],
	"data" => $temp_result_noob,
	"gw" => $gw_noob,
	"fill" => false,
);

array_push($result, $res_win);
array_push($result, $res_noob);

echo json_encode($result);