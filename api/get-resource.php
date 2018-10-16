<?php

require("id.php");

foreach( $temp_uid as $k => $v ){
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
	$myfile = fopen("assets/data/".$v.".json", "w") or die("Unable to open file!");
	fwrite($myfile, $txt);
	fclose($myfile);

	// read file
	$myfile = fopen("assets/data/".$v.".json", "r") or die("Unable to open file!");
	$value = fread($myfile,filesize("assets/data/".$v.".json"));
	$value = str_replace('"{', '{', $value);
	$value = str_replace('}"', '}', $value);
	$value = str_replace('\\"', '"', $value);

	//rewrite after fixing
	$myfile = fopen("assets/data/".$v.".json", "w") or die("Unable to open file!");
	fwrite($myfile, $value);
	fclose($myfile);
}
echo json_encode(array("status"=>"done"));