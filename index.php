<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang=""> <!--<![endif]-->

<head>
  <meta charset="utf-8">
  <!-- <meta http-equiv="refresh" content="180"> -->
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Halaman Home</title>
  <meta name="description" content="Monitoring Jurnal">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="apple-touch-icon" href="images/uinws.png">
  <link rel="shortcut icon" href="images/uinws.png">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/normalize.css@8.0.0/normalize.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lykmapipo/themify-icons@0.1.2/css/themify-icons.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pixeden-stroke-7-icon@1.2.3/pe-icon-7-stroke/dist/pe-icon-7-stroke.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.2.0/css/flag-icon.min.css">
  <link rel="stylesheet" href="assets/css/cs-skin-elastic.css">
  <link rel="stylesheet" href="assets/css/style.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
  <!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/html5shiv/3.7.3/html5shiv.min.js"></script> -->
  <link href="https://cdn.jsdelivr.net/npm/chartist@0.11.0/dist/chartist.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/jqvmap@1.5.1/dist/jqvmap.min.css" rel="stylesheet">

  <link href="https://cdn.jsdelivr.net/npm/weathericons@2.1.0/css/weather-icons.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/fullcalendar@3.9.0/dist/fullcalendar.min.css" rel="stylesheet" />

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.6/jspdf.plugin.autotable.min.js"></script>
  <script type="text/javascript" src="assets/js/pdf/main.js"></script>

</head>

<body>
  <!-- Left Panel -->
  <aside id="left-panel" class="left-panel">
    <nav class="navbar navbar-expand-sm navbar-default">
      <div id="main-menu" class="main-menu collapse navbar-collapse">
        <ul class="nav navbar-nav">
          <li class="">
            <a href="Halaman_Home.php"><i class="menu-icon fa fa-home"></i>Halaman Home </a>
          </li>
          <li class="">
            <a href="Halaman_Jurnal.php"><i class="menu-icon fa fa-laptop"></i>Halaman Jurnal</a>
          </li>
          <li class="">
            <a href="Halaman_Artikel.php"><i class="menu-icon fa fa-book"></i>Halaman Artikel</a>
          </li>
        </ul>
      </div><!-- /.navbar-collapse -->
    </nav>
  </aside>
  <!-- /#left-panel -->
  <!-- Right Panel -->
  <div id="right-panel" class="right-panel">
    <!-- Header-->
    <header id="header" class="header">
      <div class="top-left">
        <div class="navbar-header">
          <a class="navbar-brand" href=""><img src="images/uinws (2).png" alt="Logo"></a>
          <a class="navbar-brand hidden" href=""><img src="images/uinws (2).png" alt="Logo"></a>
          <a id="menuToggle" class="menutoggle"><i class="fa fa-bars"></i></a>
        </div>
      </div>
    </header>
    <!-- /#header -->
    <!-- Content -->
    <div class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">
              <h3 class="box-title text-center">Informations</h3>
            </div>
            <div class="card-body">
              <p class="card-text">Informasi Mengenai Sistem Monitoring:<br>
              <br>
              1. Script Web Scraper untuk mengecek update jurnal dijalankan secara otomatis setiap jam<br>
              2. Tombol Check Update pada halaman Home digunakan untuk memeriksa pembaruan secara mandiri oleh pengguna<br>
              3. Tombol Check Update akan menjalankan Script Web Scraper di latar belakang sistem (durasi sekitar 5-10 menit)<br>
              4. Proses Check Update akan tetap berjalan bahkan jika halaman website ditutup<br>
              5. Proses Check Update yang masih berjalan ditandai dengan simbol refresh yang berjalan<br>
              6. Progress Bar fungsi Check Update akan penuh apabila fungsi Check Update selesai menjalankan Script Web Scraper dan halaman Home tidak ditutup<br>
              7. Progress Bar fungsi Check Update tidak akan terisi apabila mengganti halaman Home dengan halaman lain<br>
              8. Data artikel ditampilkan secara urut sesuai nama alfabet<br>
              9. Apabila data artikel tidak tampil secara otomatis ketika fungsi filter digunakan, harap kembali ke page 1 (jump to page = 1)<br>
              10. Apabila terdapat "Fatal Error" ketika menampilkan data artikel, hal ini berarti sistem sedang menjalankan Script Web Scraper. Mohon refresh Halaman Artikel ketika hal ini terjadi. 
              </p><br>
              <br>
              <?php
              if (isset($_POST['checkUpdate'])) {
                $descriptorspec = array(
                  0 => array("pipe", "r"),  // stdin
                  1 => array("pipe", "w"),  // stdout
                  2 => array("pipe", "w")   // stderr
                );
                
                $process = proc_open('/home/monito29/virtualenv/public_html/jurnalscraper/3.10/bin/python3 JurnalScraper.py &', $descriptorspec, $pipes);
                
                if (is_resource($process)) {
                    fclose($pipes[0]);
            
                    $output = stream_get_contents($pipes[1]);
                    fclose($pipes[1]);
            
                    $error = stream_get_contents($pipes[2]);
                    fclose($pipes[2]);
                }
              }
              ?>
                <div class="progress mb-3">
                <?php
                if (isset($_POST['checkUpdate'])) {
                    echo '<div class="progress-bar bg-success" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>';
                } else {
                    echo '<div class="progress-bar bg-success" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>';
                }
                ?>
                </div>

                
                <div class="row mt-4">
                    <div class="col-md-12 d-flex justify-content-center">
                    <form action="" method="post">
                        <button type="submit" class="btn button-78" name="checkUpdate" id="checkUpdateBtn">Check Update</button>
                    </form>
                    </div>
                </div>
                </div>
            </div>
          </div>
        </div>
      </div>
    <!-- /.content -->


    <div class="clearfix"></div>
    <!-- Footer -->
    <footer class="site-footer">
      <div class="footer-inner bg-white">
        <div class="row">
          <div class="col-sm-6">
            Copyright &copy; 2024 Hasyim Yahya
          </div>
        </div>
      </div>
    </footer>
    <!-- /.site-footer -->
  </div>
  <!-- /#right-panel -->

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/jquery@2.2.4/dist/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.4/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/jquery-match-height@0.7.2/dist/jquery.matchHeight.min.js"></script>
  <script src="assets/js/main.js"></script>

  <!--  Chart js -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js@2.7.3/dist/Chart.bundle.min.js"></script>

  <!--Chartist Chart-->
  <script src="https://cdn.jsdelivr.net/npm/chartist@0.11.0/dist/chartist.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chartist-plugin-legend@0.6.2/chartist-plugin-legend.min.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/jquery.flot@0.8.3/jquery.flot.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/flot-pie@1.0.0/src/jquery.flot.pie.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/flot-spline@0.0.1/js/jquery.flot.spline.min.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/simpleweather@3.1.0/jquery.simpleWeather.min.js"></script>
  <script src="assets/js/init/weather-init.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/moment@2.22.2/moment.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/fullcalendar@3.9.0/dist/fullcalendar.min.js"></script>
  <script src="assets/js/init/fullcalendar-init.js"></script>

</body>

</html>