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
          <h3 class="masthead-brand"><a href="/"><?= $txt->league->name ?></a></h3>
          <nav class="nav nav-masthead justify-content-center">
            <a class="nav-link" href="/point-per-week.php">Point</a>
            <a class="nav-link" href="/transfer-cost-per-week.php">Cost</a>
            <a class="nav-link" href="/kali-ngegoa-per-week.php">Pro&Noob</a>
            <a class="nav-link" href="/point-per-month.php">Monthly</a>
            <a class="nav-link" href="/total-point-per-week.php">Total</a>
            <a class="nav-link" href="/kali-juara-klasemen-per-week.php">Top&Bot</a>
            <a class="nav-link" href="/most-captain.php">Capt</a>
            <a class="nav-link active" href="/rules.php">Rules</a>
          </nav>
        </div>
      </header>
      
      <main role="main" class="inner cover">
        <div class="row">
          <div class="col-xs-12 text-left"><h5>PERATURAN CETE CHAMPIONSHIP (LIGA BANYAK ATURAN)</h5></div>
        </div>
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
            <td class="text-left">selama masa liga berlangsung, boleh melakukan revisi aturan dan akan diimplemetasikan untuk bulan berikutnya.</td>
          </tr>
        </table>
      </main>
		
      <footer class="mastfoot mt-auto">
        <div class="inner">
          <p id="status"><i>Revisi ke-1 (Ketok Palu jika mayoritas peserta sudah setuju).</i></p>
        </div>
      </footer>
    </div>
    
    <script src="/assets/js/jquery-3.3.1.min.js"></script>
    <script src="/assets/js/popper.min.js"></script>
    <script src="/assets/js/bootstrap.min.js"></script>
  </body>
</html>


