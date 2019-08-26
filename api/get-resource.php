<?php
ini_set('max_execution_time', 300);
require("id.php");

$existedGW = 0;
$ongoingGW = 0;

if( file_exists("../assets/data/".$temp_uid[0].".json") ){

	$myfile = fopen( "../assets/data/".$temp_uid[0].".json", "r") or die("Unable to open file!");
	$val = fread($myfile,filesize("../assets/data/".$temp_uid[0].".json"));
	$val = (array) json_decode($val);
	$existedGW = $val[count($val) - 1]->entry_history->event;
	
	$url = 'https://fantasy.premierleague.com/api/bootstrap-static/';
	$context = stream_context_create($opts);
	$headers = get_headers($url, false, $context);
	$status = substr($headers[0], 9, 3);
	
	if( $status !== "200" )
		echo json_encode(array("status"=>false, "message" => "failed get all bootstrap"));
	else{
  $response = file_get_contents($url, false, $context);
		$value = stripslashes($response);
		$value = json_decode($value, true);
		foreach($value['events'] as $k => $v){
			if($v['is_current']){
				$ongoingGW = $v['id'];
				break;
			}
		}
	}

}

if( ( $existedGW != $ongoingGW ) || ( empty($existedGW) && empty($ongoingGW)) ){
	foreach( $temp_uid as $k => $v ){
		$dir_id = "../assets/data/".$v.".json";
		// get data from internet
		$tempArray = array();
		for( $w = $ongoingGW; $w <= 38; $w++){
			$url = 'https://fantasy.premierleague.com/api/entry/'.$v.'/event/'.$w.'/picks/';
			$headers = get_headers($url);
			$status = substr($headers[0], 9, 3);
			if( $status !== "200" ){
				break;
			}else{
				$response = file_get_contents($url);
				$response = stripslashes($response);
				array_push($tempArray, $response);
			}
		}
	
		$myfile = fopen( "../assets/data/".$temp_uid[$k].".json", "r") or die("Unable to open file!");
		$valExisted = fread($myfile,filesize("../assets/data/".$temp_uid[$k].".json"));
		$valExisted = stripslashes($valExisted);
		$valExisted = rtrim($valExisted,"]");
	
		if(!empty($valExisted) && !empty($tempArray)){
			foreach($tempArray as $v){
				$valExisted = $valExisted . ", " . $v;
			}
			$valExisted .= "]";
			$value = $valExisted;
		}
		
		//rewrite after fixing
		$myfile = fopen($dir_id, "w") or die("Unable to open file!");
		fwrite($myfile, $value);
		fclose($myfile);
	}
}

echo json_encode(array("status"=> true));