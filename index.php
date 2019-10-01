<?php
require("api/id.php");

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
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Cete Championship 2019/2020</title>

  <link rel="icon" href="/assets/images/favicon2.ico">

  <!-- Bootstrap core CSS -->
  <link href="/assets/v/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom fonts for this template -->
  <link href="/assets/v/fontawesome-free/css/all.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Varela+Round" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="assets/css/grayscale.min.css" rel="stylesheet">
  <style>
    body, html {
        text-align: center;
    }
    /*PRELOADING------------ */
    #overlayer {
      width:100%;
      height:100%;  
      position:absolute;
      z-index:1;
      background:#4a4a4a;
    }
    .loader {
      display: inline-block;
      width: 30px;
      height: 30px;
      position: absolute;
      z-index:3;
      border: 4px solid #Fff;
      top: 50%;
      animation: loader 2s infinite ease;
    }

    .loader-inner {
      vertical-align: top;
      display: inline-block;
      width: 100%;
      background-color: #fff;
      animation: loader-inner 2s infinite ease-in;
    }

    @keyframes loader {
      0% {
        transform: rotate(0deg);
      }
      
      25% {
        transform: rotate(180deg);
      }
      
      50% {
        transform: rotate(180deg);
      }
      
      75% {
        transform: rotate(360deg);
      }
      
      100% {
        transform: rotate(360deg);
      }
    }

    @keyframes loader-inner {
      0% {
        height: 0%;
      }
      
      25% {
        height: 0%;
      }
      
      50% {
        height: 100%;
      }
      
      75% {
        height: 100%;
      }
      
      100% {
        height: 0%;
      }
    }
  </style>
</head>

<body id="page-top">
  <div id="overlayer"></div>
  <span class="loader">
    <span class="loader-inner"></span>
  </span>
  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
    <div class="container">
      <a class="navbar-brand js-scroll-trigger" href="#page-top">Cete Championship <span style="font-size:10px;">2019/2020</span></a>
      <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        Menu
        <i class="fas fa-bars"></i>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="#point">Point</a>
          </li>
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="#cost">Cost</a>
          </li>
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="#pronoob">Pro&Noob</a>
          </li>
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="#monthly">Monthly</a>
          </li>
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="#total">Total</a>
          </li>
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="#topbot">Top&Bot</a>
          </li>
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="#capt">Capt</a>
          </li>
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="#rules">Rules</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Header -->
  <header class="masthead">
    <div class="container d-flex h-100 align-items-center">
      <div class="mx-auto text-center col-md-12">
        <table class="table lead text-white-50 thead-dark">
          <thead>
            <tr>
              <th>Rank</th>
              <th class="text-left">Club Name</th>
              <th>Last Point</th>
              <th>Total Point</th>
            </tr>
          </thead>
          <tbody>
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
          </tbody>
        </table>
      </div>
    </div>
  </header>

  <!-- Point Section -->
  <section id="point" class="point-section text-center pb-5">
    <div class="container">
      <div class="row">
        <div class="col-lg-8 mx-auto">
          <h2 class="mb-4 pt-3">Point Weekly</h2>
        </div>
        <canvas id="canvas_point_weekly"></canvas>
      </div>
    </div>
  </section>

  <!-- Cost Section -->
  <section id="cost" class="cost-section bg-light text-center pt-3 pb-5">
    <div class="container">
      <div class="row">
        <div class="col-lg-8 mx-auto">
          <h2 class="mb-4">Transfer Cost Weekly</h2>
        </div>
        <canvas id="canvas_cost_weekly"></canvas>
      </div>
    </div>
  </section>

  <!-- Pro&Noob Section -->
  <section id="pronoob" class="pronoob-section text-center pb-5">
    <div class="container">
      <div class="row">
        <div class="col-lg-8 mx-auto">
          <h2 class="mb-4 pt-3">Pro & Noob Weekly</h2>
        </div>
        <canvas id="canvas_pronoob_weekly"></canvas>
      </div>
    </div>
  </section>

  <!-- Monthly Section -->
  <section id="monthly" class="monthly-section bg-light text-center pt-3 pb-5">
    <div class="container">
      <div class="row">
        <div class="col-lg-8 mx-auto">
          <h2 class="mb-4">Point Monthly</h2>
        </div>
        <canvas id="canvas_point_monthly"></canvas>
      </div>
    </div>
  </section>

  <!-- Total Section -->
  <section id="total" class="total-section text-center pb-5">
    <div class="container">
      <div class="row">
        <div class="col-lg-8 mx-auto">
          <h2 class="mb-4 pt-3">Total Point</h2>
        </div>
        <canvas id="canvas_total"></canvas>
      </div>
    </div>
  </section>

  <!-- Top&Bot Section -->
  <section id="topbot" class="topbot-section bg-light text-center pt-3 pb-5">
    <div class="container">
      <div class="row">
        <div class="col-lg-8 mx-auto">
          <h2 class="mb-4">Top & Bot</h2>
        </div>
        <canvas id="canvas_topbot"></canvas>
      </div>
    </div>
  </section>

  <!-- Capt Section -->
  <section id="capt" class="capt-section text-center pb-5">
    <div class="container">
      <div class="row">
        <div class="col-lg-8 mx-auto">
          <h2 class="mb-4 pt-3">Most Picked Captain</h2>
        </div>
        <canvas id="canvas_capt"></canvas>
      </div>
    </div>
  </section>

  <!-- Rules Section -->
  <section id="rules" class="rules-section bg-light text-center pt-3 pb-5">
    <div class="container">
      <div class="row">
        <div class="col-lg-12 mx-auto">
          <h2 class="mb-4">PERATURAN CETE CHAMPIONSHIP (LIGA BANYAK ATURAN)</h2>
        </div>
        <div id="col-lg-8 mx-auto">
          <table>
            <tr>
              <td>1.</td>
              <td>&nbsp;</td>
              <td class="text-left">NO Baper dan No Alibi(Jika ada yang baper, silahkan baku hantam. Akomodasi ditanggung pihak yang baku hantam).</td>
            </tr>
            <tr>
              <td>2.</td>
              <td>&nbsp;</td>
              <td class="text-left">Memberitahu Deadline Transfer tidak dilarang (Kalau sudah DNA NOOB gak akan bisa ngelak, GOA).</td>
            </tr>
            <tr>
              <td>3.</td>
              <td>&nbsp;</td>
              <td class="text-left">Penghuni GOA Mingguan wajib absen 2x sehari (pagi dan sore/malam).</td>
            </tr>
            <tr>
              <td></td>
              <td>&nbsp;</td>
              <td class="text-left">Poin a. Absen sampai H-1 Matchday.</td>
            </tr>
            <tr>
              <td></td>
              <td>&nbsp;</td>
              <td class="text-left">Poin b. Peringkat 3 teratas minggu tsb berhak menentukan format absen untuk si GOA.</td>
            </tr>
            <tr>
              <td></td>
              <td>&nbsp;</td>
              <td class="text-left">Poin c. Jika poin sama, maka penentuan GOA dihitung dari total poin orang tsb. Jika total poin masih sama, dihitung dari minus di week tsb.</td>
            </tr>
            <tr>
              <td>4.</td>
              <td>&nbsp;</td>
              <td class="text-left">BLAMMING session = panggilan untuk penghuni GOA (wajib nyaut).</td>
            </tr>
            <tr>
              <td></td>
              <td>&nbsp;</td>
              <td class="text-left">Poin a. BLAMMING session bebas menggunakan meme atau kata-kata (No sara, No porn).</td>
            </tr>
            <tr>
              <td></td>
              <td>&nbsp;</td>
              <td class="text-left">Poin b. BLAMMING tidak boleh pilih kasih.</td>
            </tr>
            <tr>
              <td></td>
              <td>&nbsp;</td>
              <td class="text-left">Poin c. Gambar polosan boleh dishare sehingga memudahkan para pembuat meme.</td>
            </tr>
            <tr>
              <td>5.</td>
              <td>&nbsp;</td>
              <td class="text-left">Peringkat terbawah dalam 1 bulan berhak di BLAME selama 1 minggu (wajib absen : format merujuk ke rules no.3).</td>
            </tr>
            <tr>
              <td>6.</td>
              <td>&nbsp;</td>
              <td class="text-left">Peringkat 1 di akhir musim wajib membuat rules untuk musim depan.</td>
            </tr>
            <tr>
              <td>7.</td>
              <td>&nbsp;</td>
              <td class="text-left">Selama masa liga berlangsung, boleh melakukan revisi aturan dan akan diimplemetasikan untuk bulan berikutnya.</td>
            </tr>
          </table>
        </div>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="bg-black small text-center text-white-50 signup-section">
    <div class="container">
      Copyright &copy; Cete Championship 2019/2020
    </div>
  </footer>

  <!-- Bootstrap core JavaScript -->
  <script src="/assets/v/jquery/jquery.min.js"></script>
  <script>
    $(window).on('load', function() {
      $(".loader").delay(2500).fadeOut("slow");
      $("#overlayer").delay(2500).fadeOut("slow");
    })
  </script>
  <script src="/assets/v/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Plugin JavaScript -->
  <script src="/assets/v/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for this template -->
  <script src="/assets/js/grayscale.min.js"></script>
  
  <script src="/assets/js/Chart.min.js"></script>
  <script src="/assets/js/id.js"></script>
  <script src="/assets/js/point-weekly.js"></script> <!--Point-->
  <script src="/assets/js/transfer-cost-weekly.js"></script><!--Cost-->
  <script src="/assets/js/pro-noob-weekly.js"></script><!--Pro&Noob-->
  <script src="/assets/js/point-monthly.js"></script><!--Monthly-->
  <script src="/assets/js/total-point-weekly.js"></script><!--Total-->
  <script src="/assets/js/top-bot-weekly.js"></script><!--Top&Bot-->
  <script src="/assets/js/most-captain.js"></script><!--Capt-->
</body>

</html>
