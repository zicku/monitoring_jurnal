<?php
    include "Koneksi.php";
?>


<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <!-- <meta http-equiv="refresh" content="180"> -->
    
    <title>Halaman Artikel</title>
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
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="startYearFilter">Start Year:</label>
                                            <select class="form-control" id="startYearFilter" name="start_year">
                                                <option value="none">None</option>
                                                <?php
                                                $yearQuery = "SELECT DISTINCT YEAR(tanggal_terbit) as year FROM artikel ORDER BY year DESC";
                                                $yearResult = mysqli_query($koneksi, $yearQuery);
                                                $selectedStartYear = isset($_GET['start_year']) ? $_GET['start_year'] : 'none';
                                                while ($row = mysqli_fetch_assoc($yearResult)) {
                                                    $selected = ($row['year'] == $selectedStartYear) ? 'selected' : '';
                                                    echo '<option value="' . $row['year'] . '" ' . $selected . '>' . $row['year'] . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="endYearFilter">End Year:</label>
                                            <select class="form-control" id="endYearFilter" name="end_year">
                                                <option value="none">None</option>
                                                <?php
                                                $yearResult = mysqli_query($koneksi, $yearQuery); // Reuse the same query
                                                $selectedEndYear = isset($_GET['end_year']) ? $_GET['end_year'] : 'none';
                                                while ($row = mysqli_fetch_assoc($yearResult)) {
                                                    $selected = ($row['year'] == $selectedEndYear) ? 'selected' : '';
                                                    echo '<option value="' . $row['year'] . '" ' . $selected . '>' . $row['year'] . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <label for="sortFilter">Sort By:</label>
                                        <select class="form-control" id="sortFilter" name="sort_by">
                                            <option value="none" <?php echo isset($_GET['sort_by']) && $_GET['sort_by'] === 'none' ? 'selected' : ''; ?>>None</option>
                                            <option value="nama" <?php echo isset($_GET['sort_by']) && $_GET['sort_by'] === 'nama' ? 'selected' : ''; ?>>Nama</option>
                                            <option value="tanggal_terbit" <?php echo isset($_GET['sort_by']) && $_GET['sort_by'] === 'tanggal_terbit' ? 'selected' : ''; ?>>Tanggal Terbit</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="jurnalFilter">Journal Filter:</label>
                                        <select class="form-control" id="jurnalFilter" name="jurnal">
                                            <option value="none">None</option>
                                            <?php
                                            $jurnalQuery = "SELECT id_jurnal, nama_jurnal FROM jurnal ORDER BY nama_jurnal ASC";
                                            $jurnalResult = mysqli_query($koneksi, $jurnalQuery);
                                            $selectedJurnal = isset($_GET['jurnal']) ? $_GET['jurnal'] : 'none';
                                            while ($row = mysqli_fetch_assoc($jurnalResult)) {
                                                $selected = ($row['nama_jurnal'] == $selectedJurnal) ? 'selected' : '';
                                                echo '<option value="' . $row['nama_jurnal'] . '" ' . $selected . '>' . $row['nama_jurnal'] . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="keywordSearch">Keyword Search:</label>
                                        <input type="text" class="form-control" id="keywordSearch" name="keyword" placeholder="Enter keywords..." value="<?php echo isset($_GET['keyword']) ? $_GET['keyword'] : ''; ?>">
                                    </div>

                                    </div>
                                </div>
                            </div>
                        </div> <!-- /.col-lg-12 -->
                    </div>
                </div>
                <!-- /.orders -->
            </div>

            <!-- Animated -->
            <div class="animated fadeIn">
                <div class="clearfix"></div>
                <!-- Orders -->
                <div class="orders">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="box-title text-center">Artikel Ilmiah</h3>
                                </div>
                                <div class="card-body">
                                    <div class="table-stats order-table ov-h">
                                        <table class="table" id="table-1">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Nama Artikel</th>
                                                    <th>Tanggal Terbit</th>
                                                    <th>Asal Artikel</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                // Pagination Variables
                                                $limit = 20; // Number of items per page
                                                $page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1; // Current page, default to 1 if not valid
                                                $start = ($page - 1) * $limit; // Starting index for fetching data

                                                // Default query to fetch all articles
                                                $query = "SELECT * FROM artikel";

                                                // Handle filters
                                                $conditions = [];

                                                // Start Year filter
                                                if (isset($_GET['start_year']) && $_GET['start_year'] !== 'none') {
                                                    $selectedStartYear = mysqli_real_escape_string($koneksi, $_GET['start_year']);
                                                    $conditions[] = "YEAR(tanggal_terbit) >= $selectedStartYear";
                                                }

                                                // End Year filter
                                                if (isset($_GET['end_year']) && $_GET['end_year'] !== 'none') {
                                                    $selectedEndYear = mysqli_real_escape_string($koneksi, $_GET['end_year']);
                                                    $conditions[] = "YEAR(tanggal_terbit) <= $selectedEndYear";
                                                } else if (isset($_GET['start_year']) && $_GET['start_year'] !== 'none') {
                                                    // If only start year is selected, show articles from start year to max year
                                                    $maxYearQuery = "SELECT MAX(YEAR(tanggal_terbit)) as max_year FROM artikel";
                                                    $maxYearResult = mysqli_query($koneksi, $maxYearQuery);
                                                    $maxYear = mysqli_fetch_assoc($maxYearResult)['max_year'];
                                                    $conditions[] = "YEAR(tanggal_terbit) <= $maxYear";
                                                }

                                                // Journal filter
                                                if (isset($_GET['jurnal']) && $_GET['jurnal'] !== 'none') {
                                                    $selectedJurnal = mysqli_real_escape_string($koneksi, $_GET['jurnal']);
                                                    $jurnalIdQuery = "SELECT id_jurnal FROM jurnal WHERE nama_jurnal = '$selectedJurnal'";
                                                    $jurnalIdResult = mysqli_query($koneksi, $jurnalIdQuery);
                                                    if ($jurnalIdRow = mysqli_fetch_assoc($jurnalIdResult)) {
                                                        $jurnalId = $jurnalIdRow['id_jurnal'];
                                                        $conditions[] = "asal_artikel = $jurnalId";
                                                    }
                                                }

                                                // Keyword search
                                                $keyword = '';
                                                if (isset($_GET['keyword']) && $_GET['keyword'] !== '') {
                                                    $keyword = mysqli_real_escape_string($koneksi, $_GET['keyword']);
                                                    $conditions[] = "(nama_artikel LIKE '%$keyword%' OR penulis_artikel LIKE '%$keyword%')";
                                                }

                                                // Combine conditions
                                                if (!empty($conditions)) {
                                                    $query .= " WHERE " . implode(" AND ", $conditions);
                                                }

                                                // Handle sorting
                                                $sort_by = isset($_GET['sort_by']) ? $_GET['sort_by'] : 'nama'; // Default sort by 'nama'
                                                $sort_order = 'ASC'; // Default order

                                                if ($sort_by === 'tanggal_terbit') {
                                                    $sort_order = 'DESC'; // Sort by 'tanggal_terbit' descending
                                                }

                                                // Add order and limit clause
                                                $query .= " ORDER BY ";
                                                if ($sort_by === 'nama') {
                                                    $query .= "nama_artikel ASC";
                                                } elseif ($sort_by === 'tanggal_terbit') {
                                                    $query .= "tanggal_terbit $sort_order";
                                                }
                                                $query .= " LIMIT $start, $limit";


                                                // Fetch data from database
                                                $result = mysqli_query($koneksi, $query);

                                                // Check if the query was successful
                                                if ($result) {
                                                    // Display fetched data
                                                    $no = $start + 1;
                                                    while ($data = mysqli_fetch_array($result)) {
                                                ?>
                                                        <tr>
                                                            <td><?php echo $no++; ?></td>
                                                            <td><a class="nama_artikel" href="<?php echo $data['link_artikel']; ?>"><?php echo $data['nama_artikel']; ?></a>
                                                                <br>
                                                                <br>
                                                                Penulis: <?php echo $data['penulis_artikel']; ?>
                                                            </td>
                                                            <td><span class="tanggal_terbit"><?php echo $data['tanggal_terbit']; ?></span></td>
                                                            <td>
                                                                <span class="asal_artikel">
                                                                    <?php
                                                                    $idtest = $data['asal_artikel'];
                                                                    $str = strval($idtest);
                                                                    $asal = mysqli_query($koneksi, "SELECT nama_jurnal FROM jurnal WHERE id_jurnal = $str");
                                                                    $asal_artikel = mysqli_fetch_assoc($asal);
                                                                    $asal_final = implode("", $asal_artikel);
                                                                    echo $asal_final;
                                                                    ?>
                                                                </span>
                                                            </td>
                                                        </tr>
                                                <?php
                                                    }
                                                } else {
                                                    echo "<tr><td colspan='4'>No data found</td></tr>";
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div> <!-- /.table-stats -->

                                    <div class="pagination justify-content-center">
                                        <?php
                                        $total_query = "SELECT COUNT(*) as total FROM artikel";
                                        if (!empty($conditions)) {
                                            $total_query .= " WHERE " . implode(" AND ", $conditions);
                                        }
                                        $total_result = mysqli_query($koneksi, $total_query);

                                        // Check if the query was successful
                                        if ($total_result) {
                                            $total_data = mysqli_fetch_assoc($total_result)['total'];
                                            $total_pages = ceil($total_data / $limit);

                                            // Previous page link
                                            if ($page > 1) {
                                                echo '<a class="page-link" href="?page=' . ($page - 1) . '&start_year=' . $selectedStartYear . '&end_year=' . $selectedEndYear . '&jurnal=' . $selectedJurnal . '&keyword=' . $keyword . '">Previous</a>';
                                            }

                                            $start_page = max(1, $page - 2); // Adjust starting page based on current page
                                            $end_page = min($total_pages, $page + 2); // Adjust ending page based on current page and total pages

                                            // Display first 3 page links
                                            for ($i = $start_page; $i < $page; $i++) {
                                                $active_class = ($page == $i) ? ' active' : '';
                                                echo '<a class="page-link' . $active_class . '" href="?page=' . $i . '&start_year=' . $selectedStartYear . '&end_year=' . $selectedEndYear . '&jurnal=' . $selectedJurnal . '&keyword=' . $keyword . '">' . $i . '</a>';
                                            }

                                            // Display current page link
                                            echo '<a class="page-link active" href="?page=' . $page . '&start_year=' . $selectedStartYear . '&end_year=' . $selectedEndYear . '&jurnal=' . $selectedJurnal . '&keyword=' . $keyword . '">' . $page . '</a>';

                                            // Display last 2 page links (if applicable)
                                            if ($end_page > $page) {
                                                for ($i = $page + 1; $i <= $end_page; $i++) {
                                                    $active_class = ($page == $i) ? ' active' : '';
                                                    echo '<a class="page-link' . $active_class . '" href="?page=' . $i . '&start_year=' . $selectedStartYear . '&end_year=' . $selectedEndYear . '&jurnal=' . $selectedJurnal . '&keyword=' . $keyword . '">' . $i . '</a>';
                                                }
                                            }

                                            // Next page link
                                            if ($page < $total_pages) {
                                                echo '<a class="page-link" href="?page=' . ($page + 1) . '&start_year=' . $selectedStartYear . '&end_year=' . $selectedEndYear . '&jurnal=' . $selectedJurnal . '&keyword=' . $keyword . '">Next</a>';
                                            }
                                        }
                                        ?>
                                    </div>

                                    <div id="jump-to-page" style="display: always; margin-top: 5px;">
                                        <form action="" method="get">
                                            <label for="jump_page">Jump to page:</label>
                                            <input type="number" id="jump_page" name="page" min="1" max="<?php echo $total_pages; ?>" value="1">
                                            <input type="hidden" name="start_year" value="<?php echo $selectedStartYear; ?>">
                                            <input type="hidden" name="end_year" value="<?php echo $selectedEndYear; ?>">
                                            <input type="hidden" name="jurnal" value="<?php echo $selectedJurnal; ?>">
                                            <input type="hidden" name="keyword" value="<?php echo $keyword; ?>">
                                            <button type="submit">Go</button>
                                        </form>
                                    </div>

                                    <script>
                                        document.getElementById('startYearFilter').addEventListener('change', function() {
                                            var selectedStartYear = this.value;
                                            var selectedEndYear = document.getElementById('endYearFilter').value;
                                            var selectedJurnal = document.getElementById('jurnalFilter').value;
                                            var keyword = document.getElementById('keywordSearch').value;
                                            var params = new URLSearchParams(window.location.search);
                                            if (selectedStartYear !== 'none') {
                                                params.set('start_year', selectedStartYear);
                                            } else {
                                                params.delete('start_year');
                                            }
                                            if (selectedEndYear !== 'none') {
                                                params.set('end_year', selectedEndYear);
                                            } else {
                                                params.delete('end_year');
                                            }
                                            if (selectedJurnal !== 'none') {
                                                params.set('jurnal', selectedJurnal);
                                            } else {
                                                params.delete('jurnal');
                                            }
                                            if (keyword !== '') {
                                                params.set('keyword', keyword);
                                            } else {
                                                params.delete('keyword');
                                            }
                                            window.location.href = 'Halaman_Artikel.php?' + params.toString();
                                        });

                                        document.getElementById('endYearFilter').addEventListener('change', function() {
                                            var selectedStartYear = document.getElementById('startYearFilter').value;
                                            var selectedEndYear = this.value;
                                            var selectedJurnal = document.getElementById('jurnalFilter').value;
                                            var keyword = document.getElementById('keywordSearch').value;
                                            var params = new URLSearchParams(window.location.search);
                                            if (selectedStartYear !== 'none') {
                                                params.set('start_year', selectedStartYear);
                                            } else {
                                                params.delete('start_year');
                                            }
                                            if (selectedEndYear !== 'none') {
                                                params.set('end_year', selectedEndYear);
                                            } else {
                                                params.delete('end_year');
                                            }
                                            if (selectedJurnal !== 'none') {
                                                params.set('jurnal', selectedJurnal);
                                            } else {
                                                params.delete('jurnal');
                                            }
                                            if (keyword !== '') {
                                                params.set('keyword', keyword);
                                            } else {
                                                params.delete('keyword');
                                            }
                                            window.location.href = 'Halaman_Artikel.php?' + params.toString();
                                        });

                                        document.getElementById('sortFilter').addEventListener('change', function() {
                                            var selectedSort = this.value;
                                            var selectedStartYear = document.getElementById('startYearFilter').value;
                                            var selectedEndYear = document.getElementById('endYearFilter').value;
                                            var selectedJurnal = document.getElementById('jurnalFilter').value;
                                            var keyword = document.getElementById('keywordSearch').value;
                                            var params = new URLSearchParams(window.location.search);
                                            if (selectedSort !== 'none') {
                                                params.set('sort_by', selectedSort);
                                            } else {
                                                params.delete('sort_by');
                                            }
                                            if (selectedStartYear !== 'none') {
                                                params.set('start_year', selectedStartYear);
                                            } else {
                                                params.delete('start_year');
                                            }
                                            if (selectedEndYear !== 'none') {
                                                params.set('end_year', selectedEndYear);
                                            } else {
                                                params.delete('end_year');
                                            }
                                            if (selectedJurnal !== 'none') {
                                                params.set('jurnal', selectedJurnal);
                                            } else {
                                                params.delete('jurnal');
                                            }
                                            if (keyword !== '') {
                                                params.set('keyword', keyword);
                                            } else {
                                                params.delete('keyword');
                                            }
                                            window.location.href = 'Halaman_Artikel.php?' + params.toString();
                                        });


                                        document.getElementById('jurnalFilter').addEventListener('change', function() {
                                            var selectedStartYear = document.getElementById('startYearFilter').value;
                                            var selectedEndYear = document.getElementById('endYearFilter').value;
                                            var selectedJurnal = this.value;
                                            var keyword = document.getElementById('keywordSearch').value;
                                            var params = new URLSearchParams(window.location.search);
                                            if (selectedStartYear !== 'none') {
                                                params.set('start_year', selectedStartYear);
                                            } else {
                                                params.delete('start_year');
                                            }
                                            if (selectedEndYear !== 'none') {
                                                params.set('end_year', selectedEndYear);
                                            } else {
                                                params.delete('end_year');
                                            }
                                            if (selectedJurnal !== 'none') {
                                                params.set('jurnal', selectedJurnal);
                                            } else {
                                                params.delete('jurnal');
                                            }
                                            if (keyword !== '') {
                                                params.set('keyword', keyword);
                                            } else {
                                                params.delete('keyword');
                                            }
                                            window.location.href = 'Halaman_Artikel.php?' + params.toString();
                                        });

                                        document.getElementById('keywordSearch').addEventListener('keypress', function(e) {
                                            if (e.key === 'Enter') {
                                                e.preventDefault();
                                                var selectedStartYear = document.getElementById('startYearFilter').value;
                                                var selectedEndYear = document.getElementById('endYearFilter').value;
                                                var selectedJurnal = document.getElementById('jurnalFilter').value;
                                                var keyword = this.value;
                                                var params = new URLSearchParams(window.location.search);
                                                if (selectedStartYear !== 'none') {
                                                    params.set('start_year', selectedStartYear);
                                                } else {
                                                    params.delete('start_year');
                                                }
                                                if (selectedEndYear !== 'none') {
                                                    params.set('end_year', selectedEndYear);
                                                } else {
                                                    params.delete('end_year');
                                                }
                                                if (selectedJurnal !== 'none') {
                                                    params.set('jurnal', selectedJurnal);
                                                } else {
                                                    params.delete('jurnal');
                                                }
                                                if (keyword !== '') {
                                                    params.set('keyword', keyword);
                                                } else {
                                                    params.delete('keyword');
                                                }
                                                window.location.href = 'Halaman_Artikel.php?' + params.toString();
                                            }
                                        });

                                        document.getElementById('jump_page_form').addEventListener('submit', function(e) {
                                            e.preventDefault();
                                            var jumpPage = document.getElementById('jump_page').value;
                                            var selectedStartYear = document.getElementById('startYearFilter').value;
                                            var selectedEndYear = document.getElementById('endYearFilter').value;
                                            var selectedJurnal = document.getElementById('jurnalFilter').value;
                                            var keyword = document.getElementById('keywordSearch').value;
                                            var params = new URLSearchParams(window.location.search);
                                            params.set('page', jumpPage);
                                            if (selectedStartYear !== 'none') {
                                                params.set('start_year', selectedStartYear);
                                            } else {
                                                params.delete('start_year');
                                            }
                                            if (selectedEndYear !== 'none') {
                                                params.set('end_year', selectedEndYear);
                                            } else {
                                                params.delete('end_year');
                                            }
                                            if (selectedJurnal !== 'none') {
                                                params.set('jurnal', selectedJurnal);
                                            } else {
                                                params.delete('jurnal');
                                            }
                                            if (keyword !== '') {
                                                params.set('keyword', keyword);
                                            } else {
                                                params.delete('keyword');
                                            }
                                            window.location.href = 'Halaman_Artikel.php?' + params.toString();
                                        });

                                        document.getElementById('clear_filters').addEventListener('click', function(e) {
                                            var params = new URLSearchParams(window.location.search);
                                            params.delete('start_year');
                                            params.delete('end_year');
                                            params.delete('jurnal');
                                            params.delete('keyword');
                                            window.location.href = 'Halaman_Artikel.php?' + params.toString();
                                        });
                                    </script>

                                </div>
                            </div> <!-- /.card -->
                        </div> <!-- /.col-lg-12 -->
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