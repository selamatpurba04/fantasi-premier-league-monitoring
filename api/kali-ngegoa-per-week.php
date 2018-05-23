<?php
	//juara group per minggu
	$temp_uid = array(    
		2915154, //aji
	    2885971, //filar
	    2889556, //selamat
	    1065481, //enye
	    1067651, //bala
	    2902466 //indra
	);

	$temp_name = array(    
		"Aji",
	    "Filar",
	    "Selamat",
	    "Enye",
	    "Bala",
	    "Indra"
	);

	$temp_color = array(    
		"#f45042",
	    "#fce807",
	    "#12ba03",
	    "#0155af",
	    "#8900af",
	    "#000000"
	);

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
				$pointWeek = (int)  $temp_array[$x][$i]->entry_history->points;
				array_push($temp_points[$i], $pointWeek);
			}

			// $res = array(
			// 	"label" => $temp_name[$x],
			// 	"backgroundColor" => $temp_color[$x],
			// 	"borderColor" => $temp_color[$x],
			// 	"data" => $temp_points,
			// 	"fill" => false,
			// );
			// array_push($result, $res);
		}

	}
	$temp_win_perweek = array();
	if( !empty($temp_points) ){

		for($i = 0; $i < 38; $i++){
			$min = min($temp_points[$i]);
			array_push($temp_win_perweek, array_search($min, $temp_points[$i]));
		}

	}

	$temp_result = array(
		0,0,0,0,0,0
	);
	if( !empty($temp_win_perweek) ){

		for($i = 0; $i < 38; $i++){
			$temp_result[$temp_win_perweek[$i]] += 1;
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

	// echo json_encode($temp_win_perweek);die();

	echo json_encode($result);

	