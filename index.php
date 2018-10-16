<?php
require("api/id.php");

$url = 'https://fantasy.premierleague.com/drf/leagues-classic-standings/'.$id_liga;
$headers = get_headers($url);
$status = substr($headers[0], 9, 3);
if( $status === "200" ){
    $response = file_get_contents($url);
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
    <link rel="icon" href="../../../../favicon.ico">

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
          <h3 class="masthead-brand"><?= $txt->league->name ?></h3>
          <nav class="nav nav-masthead justify-content-center">
            <a class="nav-link active" href="/">Home</a>
            <a class="nav-link" href="/point-per-week.php">Point</a>
            <a class="nav-link" href="/total-point-per-week.php">Total Point</a>
            <a class="nav-link" href="/kali-ngegoa-per-week.php">NgeGOA</a>
            <a class="nav-link" href="/kali-juara-klasemen-per-week.php">Kali Juara Klasemen</a>
            <a class="nav-link" href="/kali-noob-klasemen-per-week.php">Kali Underdog Klasemen</a>
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
            echo "<tr>";
            echo "<td>".$v->rank."</td>";
            echo "<td class=\"text-left\">".$v->entry_name."</td>";
            echo "<td>".$v->event_total."</td>";
            echo "<td>".$v->total."</td>";
            echo "</tr>";
          }
        ?>
        </table>
      </main>
		
      <footer class="mastfoot mt-auto">
        <div class="inner">
          <p>Monitoring System for Noob</p>
        </div>
      </footer>
    </div>


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="/assets/js/jquery-3.3.1.slim.min.js"></script>
    <script src="/assets/js/popper.min.js"></script>
    <script src="/assets/js/bootstrap.min.js"></script>
  </body>
</html>


