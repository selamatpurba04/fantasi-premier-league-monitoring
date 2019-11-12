<?php

require("id.php");

$result = (object) array();
$photo_baseUrl = "https://platform-static-files.s3.amazonaws.com/premierleague/photos/players/110x140/p";
$uid = $_GET['uid'];
$gw = $_GET['gw'];

$temp_points = array();
$val = null;
$myfile = fopen( "../assets/data/".$uid.".json", "r") or die("Unable to open file!");
$val = fread($myfile,filesize("../assets/data/".$uid.".json"));
$val = (array) json_decode($val);

$allPlayer = fopen( "../assets/dataStatic/allPlayer.json", "r") or die("Unable to open file!");
$valAllPlayer = fread($allPlayer,filesize("../assets/dataStatic/allPlayer.json"));
$valAllPlayer = (array) json_decode($valAllPlayer);

$tempCaptain = [];
$picks_old = [];

$i = $gw;
$picks = $val[$i]->picks;
if(isset($val[$i-1])){
  $picks_old = $val[$i-1]->picks;
}

$element = [];
$element_old = [];
if(!empty($picks_old)){
  foreach($picks_old as $k => $v){
    array_push($element_old, $picks_old[$k]->element);
  }
}

if(!empty($picks)){
  foreach($picks as $k => $v){
    array_push($element, $picks[$k]->element);
  }
}

$eTransferIn = array_diff($element, $element_old);
$eTransferOut = array_diff($element_old, $element);

$playerIn = [];
$playerOut = [];
if(!empty($eTransferIn)){
  foreach($eTransferIn as $v){
    $a = array_search($v, array_column($valAllPlayer, 'id'));
    $name = $valAllPlayer[$a]->web_name;
    $photo = $valAllPlayer[$a]->photo;
    array_push($playerIn, (object) ['name' => $name, 'photo' => $photo_baseUrl. str_replace(".jpg", ".png", $photo) ]);
  }
}

if(!empty($eTransferOut)){
  foreach($eTransferOut as $v){
    $a = array_search($v, array_column($valAllPlayer, 'id'));
    $name = $valAllPlayer[$a]->web_name;
    $photo = $valAllPlayer[$a]->photo;
    array_push($playerOut, (object) ['name' => $name, 'photo' => $photo_baseUrl. str_replace(".jpg", ".png", $photo) ]);
  }
}

$result->in = $playerIn;
$result->out = $playerOut;

echo json_encode($result);