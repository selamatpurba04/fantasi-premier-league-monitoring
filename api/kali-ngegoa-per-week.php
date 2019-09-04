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
$temp_pro_perweek = array();
if( !empty($temp_points) ){
	for($i = 0; $i < 38; $i++){
		if( !empty($temp_points[$i]) ){
			$min = min($temp_points[$i]);
			$mostMin = [];
			$minKeys = array_keys($temp_points[$i], $min);
			$tempMin = 9999;
			$tempKeyMin = -1;
			
			$max = max($temp_points[$i]);
			$mostMax = [];
			$maxKeys = array_keys($temp_points[$i], $max);
			$tempMax = 9999;
			$tempKeyMax = -1;

			if(count($minKeys) > 1){
				foreach($minKeys as $v){
					$tm = $temp_points[$i][$v] - $temp_array[$v][$i]->entry_history->event_transfers_cost;
					if($tm < $tempMin){
						$tempMin = $tm;
						$tempKeyMin = $v;
					}
				}
				$minKeys = [$tempKeyMin];
			}

			if(count($maxKeys) > 1){
				foreach($maxKeys as $v){
					$tm = $temp_points[$i][$v] - $temp_array[$v][$i]->entry_history->event_transfers_cost;
					if($tm < $tempMax){
						$tempMax = $tm;
						$tempKeyMax = $v;
					}
				}
				$maxKeys = [$tempKeyMax];
			}
			
			array_push($temp_goa_perweek, $minKeys);
			array_push($temp_pro_perweek, $maxKeys);
		}
		else
			break;
	}
}

$temp_result_goa = array( 0,0,0,0,0,0,0,0 );
$gw_goa = array( [], [], [], [], [] ,[], [], [] );
if( !empty($temp_goa_perweek) ){
	for($i = 0; $i < 38; $i++){
		if( isset($temp_goa_perweek[$i]) ){
			foreach ($temp_goa_perweek[$i] as $v) {
				$temp_result_goa[$v] += 1;
				array_push($gw_goa[$v], $i+1);
			}
		}else
			break;
	}
}

$temp_result_pro = array( 0,0,0,0,0,0,0,0 );
$gw_pro = array( [], [], [], [], [] ,[], [], [] );
if( !empty($temp_pro_perweek) ){
	for($i = 0; $i < 38; $i++){
		if( isset($temp_pro_perweek[$i]) ){
			foreach ($temp_pro_perweek[$i] as $v) {
				$temp_result_pro[$v] += 1;
				array_push($gw_pro[$v], $i+1);
			}
		}else
			break;
	}
}

$res_goa = array(
	"label" => "Kali Goa Weekly",
	"backgroundColor" => $temp_color[0],
	"borderColor" => $temp_color[0],
	"data" => $temp_result_goa,
	"gw" => $gw_goa,
	"fill" => false,
);

$res_pro = array(
	"label" => "Kali Pro Weekly",
	"backgroundColor" => $temp_color[2],
	"borderColor" => $temp_color[0],
	"data" => $temp_result_pro,
	"gw" => $gw_pro,
	"fill" => false,
);
array_push($result, $res_pro);
array_push($result, $res_goa);

echo json_encode($result);