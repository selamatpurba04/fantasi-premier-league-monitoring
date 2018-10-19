<?php
ini_set('max_execution_time', 300);
require("id.php");

$days = 10;
$fileExist = 0;
if( file_exists("../assets/data/".$temp_uid[0].".json") ){
	$getTime = filemtime ( "../assets/data/".$temp_uid[0].".json" );
	$diff = strtotime(date("Ymd")) - $getTime;
	$years = floor($diff / (365*60*60*24));
	$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
	$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
}

if( $days > 3 ){
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
echo json_encode(array("status"=>"done"));