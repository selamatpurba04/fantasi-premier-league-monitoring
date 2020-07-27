<?php

require("id.php");

$result = array();
$tempCaptAll = [];
$tempNameCapt = [];

for( $x = 0; $x < count($temp_uid); $x++){
	$temp_points = array();
	$val = null;
	$myfile = fopen( "../assets/data/".$temp_uid[$x].".json", "r") or die("Unable to open file!");
	$val = fread($myfile,filesize("../assets/data/".$temp_uid[$x].".json"));
	$val = (array) json_decode($val);

	$allPlayer = fopen( "../assets/dataStatic/allPlayer.json", "r") or die("Unable to open file!");
	$valAllPlayer = fread($allPlayer,filesize("../assets/dataStatic/allPlayer.json"));
	$valAllPlayer = (array) json_decode($valAllPlayer);

	$tempCaptain = [];
	for ($i=0; $i < count($val); $i++) { 
		if( !in_array($i, $zeroWeeks) ){
			$picks = $val[$i]->picks;
			foreach ($picks as $key => $value) {
				if($value->is_captain){
					if(!isset($tempCaptain[$value->element]))
						$tempCaptain[$value->element] = 1;	
					else
						$tempCaptain[$value->element] += 1;
					break;
				}
			}
		}
	}

	$capt = [];
	foreach ($tempCaptain as $key => $val) {
		foreach ($valAllPlayer as $k => $v) {
			if($v->id == $key){
				if(!in_array($v->web_name, $tempNameCapt))
					array_push($tempNameCapt, $v->web_name);
				$capt[$v->web_name] = $val;
				break;
			}
		}
	}
	array_push($tempCaptAll, $capt);
}

$tempData = [];

if(!empty($tempNameCapt)){
	foreach ($tempNameCapt as $k => $v) {
		$tempVal = [];
		for( $x = 0; $x < count($temp_uid); $x++){
			if(isset($tempCaptAll[$x][$v]))
				array_push($tempVal, $tempCaptAll[$x][$v]);
			else
				array_push($tempVal, 0);
		}
		// echo json_encode($tempVal);die();
		$res = array(
			"label" => $v,
			"backgroundColor" => $temp_barChart_color[$k],
			"borderColor" => $temp_barChart_color[$k],
			"data" => $tempVal,
			"fill" => false,
		);
		array_push($tempData, $res);
	}
}

$result['data'] = $tempData;

echo json_encode($result);