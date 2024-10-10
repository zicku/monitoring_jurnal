

<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <!-- <meta http-equiv="refresh" content="180"> -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Halaman Jurnal</title>
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
            <!-- Animated -->
            <div class="animated fadeIn">
                <div class="clearfix"></div>
                <!-- Orders -->
                <div class="orders">
                    <div class="row">
                        <div class="col-lg-12">
                            <!-- Filter -->
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="box-title text-center">Filter</h3>
                                </div>
                                <div class="card-body">
                                    <form id="filterForm">
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="sortingFilter">Sort by:</label>
                                                <select class="form-control" id="sortingFilter" name="sorting">
                                                    <option value="none" <?php echo (!isset($_GET['sorting']) || $_GET['sorting'] == 'none') ? 'selected' : ''; ?>>None</option>
                                                    <option value="name" <?php echo (isset($_GET['sorting']) && $_GET['sorting'] == 'name') ? 'selected' : ''; ?>>Nama</option>
                                                    <option value="indeks" <?php echo (isset($_GET['sorting']) && $_GET['sorting'] == 'indeks') ? 'selected' : ''; ?>>Indeks</option>
                                                    <option value="volume" <?php echo (isset($_GET['sorting']) && $_GET['sorting'] == 'volume') ? 'selected' : ''; ?>>Volume Terbaru</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="keywordSearch">Journal Search:</label>
                                                <input type="text" class="form-control" id="keywordSearch" name="keyword" placeholder="Enter Journal Name..." value="<?php echo isset($_GET['keyword']) ? htmlspecialchars($_GET['keyword']) : ''; ?>">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div> <!-- /.col-lg-12 -->
                    </div>
                </div>
                <!-- /.orders -->
            </div>

            <!-- JavaScript for automatic filtering and searching -->
            <script>
                document.getElementById('sortingFilter').addEventListener('change', function() {
                    updateQueryParams();
                });

                document.getElementById('keywordSearch').addEventListener('keydown', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        updateQueryParams();
                    }
                });

                function updateQueryParams() {
                    const sorting = document.getElementById('sortingFilter').value;
                    const keyword = document.getElementById('keywordSearch').value;
                    let queryParams = '?page=1';

                    if (sorting !== 'none') {
                        queryParams += '&sorting=' + sorting;
                    }
                    if (keyword) {
                        queryParams += '&keyword=' + encodeURIComponent(keyword);
                    }

                    window.location.href = window.location.pathname + queryParams;
                }
            </script>

            <!-- Animated -->
            <div class="animated fadeIn">
                <div class="clearfix"></div>
                <!-- Orders -->
                <div class="orders">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="box-title text-center">Jurnal Ilmiah</h3>
                                </div>
                                <div class="card-body">
                                    <div class="table-stats order-table ov-h">
                                        <table class="table" id="table-1">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Nama Jurnal</th>
                                                    <th>Indeks SINTA & Jadwal Terbit</th>
                                                    <th>Volume Terbaru</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                                include "Koneksi.php";

                                                // Get query parameters for sorting and search
                                                $sorting = isset($_GET['sorting']) ? $_GET['sorting'] : 'none';
                                                $keyword = isset($_GET['keyword']) ? mysqli_real_escape_string($koneksi, $_GET['keyword']) : '';

                                                // Pagination Variables
                                                $limit = 20; // Number of items per page
                                                $page = isset($_GET['page']) ? intval($_GET['page']) : 1; // Current page
                                                $start = ($page - 1) * $limit; // Starting index for fetching data

                                                // Build the base query
                                                $query = "SELECT * FROM jurnal WHERE 1";

                                                // Add keyword search filter
                                                if ($keyword !== '') {
                                                    $query .= " AND nama_jurnal LIKE '%$keyword%'";
                                                }

                                                // Add sorting logic
                                                switch ($sorting) {
                                                    case 'name':
                                                        $query .= " ORDER BY nama_jurnal ASC";
                                                        break;
                                                    case 'indeks':
                                                        $query .= " ORDER BY FIELD(indeks_jurnal, 'S1', 'S2', 'S3', 'S4', 'S5', 'S6', 'Not Found')";
                                                        break;
                                                    case 'volume':
                                                        $query .= " ORDER BY (SELECT MAX(tanggal_terbit) FROM artikel WHERE asal_artikel = jurnal.id_jurnal) DESC";
                                                        break;
                                                    default:
                                                        $query .= " ORDER BY nama_jurnal ASC";
                                                }

                                                // Add pagination limit
                                                $query .= " LIMIT $start, $limit";

                                                $result = mysqli_query($koneksi, $query);

                                                // Display fetched data
                                                $no = $start + 1;
                                                while ($data = mysqli_fetch_array($result)) {
                                                    $volume_query = "SELECT MAX(tanggal_terbit) as max_date FROM artikel WHERE asal_artikel = " . intval($data['id_jurnal']);
                                                    $volume_result = mysqli_query($koneksi, $volume_query);
                                                    $volume_data = mysqli_fetch_assoc($volume_result);
                                                    $tanggal_final = $volume_data['max_date'];
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $no++; ?></td>
                                                        <td><a class="nama_jurnal" href="<?php echo $data['link_jurnal']; ?>"><?php echo $data['nama_jurnal']; ?></a></td>
                                                        <td><a class="indeks_jurnal" href="<?php echo $data['link_indeks']; ?>"><?php echo $data['indeks_jurnal']; ?></a>
                                                            <br>
                                                            <?php echo $data['jadwal_terbit']; ?>
                                                        </td>
                                                        <td>
                                                            <span class="volume_terbaru">
                                                                <?php echo $data['volume_terbaru']; ?><br> 
                                                                Diterbitkan pada: 
                                                                <?php echo $tanggal_final; ?>
                                                            </span>
                                                        </td> 
                                                    </tr>
                                                    <?php
                                                }
                                            ?>
                                            </tbody>
                                        </table>
                                    </div> <!-- /.table-stats -->

                                    <!-- Pagination Links -->
                                    <div class="pagination justify-content-center">
                                        <?php
                                        $total_query = "SELECT COUNT(*) as total FROM jurnal WHERE 1";
                                        
                                        // Add keyword search filter to count query
                                        if ($keyword !== '') {
                                            $total_query .= " AND nama_jurnal LIKE '%$keyword%'";
                                        }
                                        
                                        $total_result = mysqli_query($koneksi, $total_query);
                                        $total_data = mysqli_fetch_assoc($total_result)['total'];
                                        $total_pages = ceil($total_data / $limit);

                                        // Previous page link
                                        if ($page > 1) {
                                            echo '<a class="page-link" href="?page=' . ($page - 1) . '&sorting=' . $sorting . '&keyword=' . urlencode($keyword) . '">Previous</a>';
                                        }

                                        // Page links
                                        for ($i = 1; $i <= $total_pages; $i++) {
                                            $active_class = ($page == $i) ? ' active' : '';
                                            echo '<a class="page-link' . $active_class . '" href="?page=' . $i . '&sorting=' . $sorting . '&keyword=' . urlencode($keyword) . '">' . $i . '</a>';
                                        }

                                        // Next page link
                                        if ($page < $total_pages) {
                                            echo '<a class="page-link" href="?page=' . ($page + 1) . '&sorting=' . $sorting . '&keyword=' . urlencode($keyword) . '">Next</a>';
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div> <!-- /.card -->
                        </div>  <!-- /.col-lg-12 -->
                    </div>
                </div>
                <!-- /.orders -->
            </div>
            <!-- .animated -->
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