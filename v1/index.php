<?php
require("../api/id.php");

$url = 'https://fantasy.premierleague.com/api/leagues-classic/'.$id_liga.'/standings/';
$context = stream_context_create($opts);

$headers = get_headers($url, false, $context);
$status = substr($headers[0], 9, 3);

if( $status == "200" ){
  // Open the file using the HTTP headers set above
  $response = file_get_contents($url, false, $context); 
  $txt = (object) json_decode($response);
}
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="/assets/images/favicon2.ico">

    <title><?= $txt->league->name ?></title>

    <!-- Bootstrap core CSS -->
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="/assets/css/cover.css" rel="stylesheet">
  </head>

  <body class="text-center">

    <div class="container d-flex w-100 h-100 p-3 mx-auto flex-column">
      <header class="masthead mb-auto">
        <div class="inner">
          <h3 class="masthead-brand"><a href="/v1/"><?= $txt->league->name ?></a></h3>
          <nav class="nav nav-masthead justify-content-center">
            <a class="nav-link" href="/v1/point-weekly.php">Point</a>
            <a class="nav-link" href="/v1/transfer-cost-weekly.php">Cost</a>
            <a class="nav-link" href="/v1/pro-noob-weekly.php">Pro&Noob</a>
            <a class="nav-link" href="/v1/point-monthly.php">Monthly</a>
            <a class="nav-link" href="/v1/total-point-weekly.php">Total</a>
            <a class="nav-link" href="/v1/top-bot-weekly.php">Top&Bot</a>
            <a class="nav-link" href="/v1/most-captain.php">Capt</a>
            <a class="nav-link" href="/v1/rules.php">Rules</a>
          </nav>
        </div>
      </header>
      
      <main role="main" class="inner cover">
        <table class="table lead">
          <tr>
            <th>Rank</th>
            <th class="text-left">Club Name</th>
            <th>Last Point</th>
            <th>Total Point</th>
          </tr>
          <?php 
            foreach( $txt->standings->results as $k => $v){
              $img = $stayImg;
              if($v->rank < $v->last_rank)
                $img = $upImg;
              else if($v->rank > $v->last_rank)
              $img = $downImg;

              echo "<tr>";
              echo "<td>".$v->rank." ".$img."</td>";
              echo "<td class=\"text-left\">".$v->entry_name." <i style='font-size:10px;'>".$v->player_name."</i></td>";
              echo "<td>".$v->event_total."</td>";
              echo "<td>".$v->total."</td>";
              echo "</tr>";
            }
          ?>
        </table>
      </main>
		
      <footer class="mastfoot mt-auto">
        <!-- <div class="inner">
          <p id="status">Monitoring System for Noob</p>
          <p>
            <img id="loading_img" height="35" src="/assets/images/loading-small.gif">
            <img id="done_img" height="35" src="/assets/images/done.png">
          </p>
        </div> -->
      </footer>
    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="/assets/js/jquery-3.3.1.min.js"></script>
    <script src="/assets/js/popper.min.js"></script>
    <script src="/assets/js/bootstrap.min.js"></script>
    <!-- <script src="/assets/js/get-resource.js"></script> -->
  </body>
</html>


