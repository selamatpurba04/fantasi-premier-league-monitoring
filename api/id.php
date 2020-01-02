<?php 

$id_liga = "228438";
$temp_uid = array(    
	967889, //aji
	969435, //filar
    969793, //edi
	1009865, //indra,
	4002072, //bala
	419041, //selamat
	816860, //enye
    1012893 //bowo
);

$temp_name = array(    
    "Aji",
    "Filar",
    "Edi",
    "Indra",
    "Bala",
    "Selamat",
    "Enye",
    "Bowo"
);

$temp_color = array(    
    "#f45042",
    "#fce807",
    "#12ba03",
    "#0155af",
    "#8900af",
    "#706b06",
    "#00af9a",
    "#f720ed"

);

$temp_barChart_color = array(
    "#0155af",
    "#c4c3d0",
    "#f3e5ab",
    "#f78fa7",
    "#ff7f50",
    "#b03060",
    "#ffff00",
    "#614051",
    "#9d81ba",
    "#fffaf0",
    "#e0ffff",
    "#9bc4e2",
    "#3d2b1f",
    "#21abcd",
    "#a9ba9d",
    "#c8a2c8",
    "#8a2be2",
    "#daa520",
    "#5d3954",
    "#6c541e",
    "#1e4d2b"
);

// Create a stream
$opts = [
    "http" => [
        "method" => "GET",
        "header" => "Accept-language: en\r\n" .
            "Cookie: _ga=GA1.2.972335778.1562951777; pl_profile=eyJzIjogIld6SXNNekUwT0RFM056VmQ6MWh5WWtuOkdKcVVWREk2ajl0a1pVOG1UNUNaS1FZMWh3TSIsICJ1IjogeyJpZCI6IDMxNDgxNzc1LCAiZm4iOiAiU2xhbWV0IiwgImxuIjogIk5vc2lrdWVsIiwgImZjIjogbnVsbH19; csrftoken=NFp3ZREEmn09OLWsbr6w1zMaCOce2GYiR5URr4ezYKYaEGBSI7YRFqyGPBsol2H0; sessionid=.eJyrVopPLC3JiC8tTi2Kz0xRslIyNjSxMDQ3N1XSQZZKSkzOTs0DyRfkpBXk6IFk9AJ8QoFyxcHB_o5ALqqGjMTiDKBqwzST5DRzizRjgzRj0zQTI5NEAzNTC9NkM0tT02SLJAsT4xQTQwtLY6VaAHpIK8c:1hyYko:Ed00e0IosPZajQCTCeZ2FieE1zM; _gid=GA1.2.592751596.1566268521\r\n"
    ]
];

$upImg = "<img src='/assets/images/up-arrow.png' width='12'>";
$downImg = "<img src='/assets/images/down-arrow.png' width='12'>";
$stayImg = "<img src='/assets/images/stay-arrow.png' width='12'>";

$currentGW = 21;
$startGW = 16;