<?php
ini_set('max_execution_time', 300);
require("id.php");

$existedGW = 0;
$ongoingGW = 0;

if( file_exists("../assets/data/".$temp_uid[0].".json") ){

	$myfile = fopen( "../assets/data/".$temp_uid[0].".json", "r") or die("Unable to open file!");
	$val = fread($myfile,filesize("../assets/data/".$temp_uid[0].".json"));
	$val = (array) json_decode($val);
	$existedGW = $val[count($val) - 1]->event->id;
	
	$url = 'https://fantasy.premierleague.com/drf/bootstrap-static';
	$headers = get_headers($url);
	$status = substr($headers[0], 9, 3);
	
	if( $status !== "200" )
		echo json_encode(array("status"=>false, "message" => "failed get all bootstrap"));
	else{
		$response = file_get_contents($url);
		$value = str_replace('"{', '{', $response);
		$value = str_replace('}"', '}', $value);
		$value = str_replace('\\"', '"', $value);
		$value = json_decode($value, true);
		$ongoingGW = $value['events'][count($value['events']) - 1]['id'];
	}

}

if( ( $existedGW != $ongoingGW ) || ( empty($existedGW) && empty($ongoingGW)) ){
	foreach( $temp_uid as $k => $v ){
		$dir_id = "../assets/data/".$v.".json";
		// get data from internet
		$tempArray = array();
		for( $w = 1; $w <= 38; $w++){
			$url = 'https://fantasy.premierleague.com/drf/entry/'.$v.'/event/'.$w.'/picks';
			$headers = get_headers($url);
			$status = substr($headers[0], 9, 3);
			if( $status !== "200" ){
				break;
			}else{
				$response = file_get_contents($url);
				array_push($tempArray, $response);
			}
		}
		
		$txt = json_encode($tempArray);
		$value = str_replace('"{', '{', $txt);
		$value = str_replace('}"', '}', $value);
		$value = str_replace('\\"', '"', $value);
		
		//rewrite after fixing
		$myfile = fopen($dir_id, "w") or die("Unable to open file!");
		fwrite($myfile, $value);
		fclose($myfile);
	}
}

echo json_encode(array("status"=> true));