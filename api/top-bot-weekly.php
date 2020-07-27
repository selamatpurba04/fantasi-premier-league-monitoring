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

	for ($i=0; $i < 47; $i++) {
		
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

$temp_top_perweek = array();
$temp_bot_perweek = array();
if( !empty($temp_points) ){

	for($i = 0; $i < 47; $i++){
		if( !empty($temp_points[$i]) ){
			$max = max($temp_points[$i]);
			array_push($temp_top_perweek, array_search($max, $temp_points[$i]));

			$min = min($temp_points[$i]);
			array_push($temp_bot_perweek, array_search($min, $temp_points[$i]));
		}else
			break;
	}

}

$temp_result_top = array( 0,0,0,0,0,0,0,0 );
$gw_top = array([], [], [], [], [] ,[], [], [] );

if( !empty($temp_top_perweek) ){
	$j = 0;
	for($i = 0; $i < 47; $i++){
		if( isset($temp_top_perweek[$i])  && !in_array($i, $zeroWeeks) ){
			$temp_result_top[$temp_top_perweek[$i]] += 1;
			array_push($gw_top[$temp_top_perweek[$i]], $j+1);
			$j++;
		}
	}
}

$temp_result_bot = array( 0,0,0,0,0,0,0,0 );
$gw_bot = array([], [], [], [], [] ,[], [], [] );

if( !empty($temp_bot_perweek) ){
	$j = 0;
	for($i = 0; $i < 47; $i++){
		if( isset($temp_bot_perweek[$i]) && !in_array($i, $zeroWeeks) ){
			$temp_result_bot[$temp_bot_perweek[$i]] += 1;
			array_push($gw_bot[$temp_bot_perweek[$i]], $j+1);
			$j++;
		}
	}
}

$res_win = array(
	"label" => "Top Klasemen",
	"backgroundColor" => $temp_color[2],
	"borderColor" => $temp_color[2],
	"data" => $temp_result_top,
	"gw" => $gw_top,
	"fill" => false,
);

$res_noob = array(
	"label" => "Bot Klasemen",
	"backgroundColor" => $temp_color[0],
	"borderColor" => $temp_color[0],
	"data" => $temp_result_bot,
	"gw" => $gw_bot,
	"fill" => false,
);

array_push($result, $res_win);
array_push($result, $res_noob);

echo json_encode($result);