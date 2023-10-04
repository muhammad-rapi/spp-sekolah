<?php

session_start();

if ( !isset($_SESSION['login']) ) {
  header('location:login.php');
  exit;
}

require('../backend/function.php');

$data_l  = mysqli_query($conn, "SELECT * FROM transaksi");
$hitungl = mysqli_num_rows($data_l);


?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  <title>Data Siswa</title>
  <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
  <link href="../css/styles.css" rel="stylesheet" />
  <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
  <style>
    a {
      text-decoration: none;
      color: black;
      transition: .3s;
    }
  </style>
</head>

<body class="sb-nav-fixed">
  <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <!-- Navbar Brand-->
    <a class="navbar-brand ps-3" href="home.php">Pembayaran SPP</a>
    <!-- Sidebar Toggle-->
    <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i
        class="fas fa-bars"></i></button>
    <!-- Navbar Search-->
  </nav>
  <div id="layoutSidenav">
    <div id="layoutSidenav_nav">
      <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
          <div class="nav">
            <a class="nav-link" href="../siswa/siswa.php">
              <div class="sb-nav-link-icon"><i class="fa-solid fa-users-rectangle fa-bounce"></i></div>
              Cek Data Siswa
            </a>
            <a class="nav-link" href="laporan.php">
              <div class="sb-nav-link-icon"><i class="fa-solid fa-file-circle-exclamation fa-bounce"></i>
              </div>
              Laporan Harian
            </a>
            <a class="nav-link" href="../logout.php">
              Logout
            </a>
          </div>
        </div>
      </nav>
    </div>
    <div id="layoutSidenav_content">
      <main>
        <div class="container-fluid px-4">
          <h1 class="mt-4">Laporan Harian</h1>

          <div class="row mt-3">
            <div class="col-xl-3 col-md-6">
              <div class="card bg-primary text-white mb-4">
                <div class="card-body">
                  <h6>Jumlah Data Transaksi =
                    <?= $hitungl ?>
                  </h6>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-center">
                  <div class="sb-nav-link-icon"><i class="fa-sharp fa-light fa-money-bills fa-4x"></i></div>
                </div>
              </div>
            </div>

            <div class="card mb-4">
              <div class="card-header">

                <button type="button" class="btn btn-warning mt-2">
                  <a href="eksport.php">Cetak Laporan</a>
                </button>



                <div class="row ">
                  <div class="col">
                    <form action="" method="post" class=" mt-4 d-flex gap-3">
                      <input type="date" name="tgl-mulai" class="form-control w-25">
                      <input type="date" name="tgl-selesai" class="form-control ml-3 w-25">
                      <button type="submit" name="filter-tgl" class="btn btn-info ml-3">Filter Tanggal</button>
                    </form>
                  </div>


                </div>
                <div class="card-body">

                  <h3>Laporan Transaksi</h3>

                  <table id="datatablesSimple">
                    <thead>
                      <tr>
                        <th>Hari</th>
                        <th>Tanggal</th>
                        <th>Bulan</th>
                        <th>Nama</th>
                        <th>Kelas</th>
                        <th>Jurusan</th>
                        <th>Nominal</th>
                      </tr>
                    </thead>
                    <tbody>

                      <?php

                      if ( isset($_POST['filter-tgl']) ) {

                        $mulai   = $_POST['tgl-mulai'];
                        $selesai = $_POST['tgl-selesai'];

                        if ( $mulai != null || $selesai != null ) {
                          $datatransaksi = mysqli_query($conn, "SELECT * FROM transaksi t, siswa s WHERE s.id_siswa = t.id_siswa AND tanggal BETWEEN '$mulai' AND DATE_ADD('$selesai', INTERVAL 1 DAY)");
                        } else {
                          $datatransaksi = mysqli_query($conn, "SELECT * FROM transaksi t, siswa s WHERE s.id_siswa = t.id_siswa");
                        }

                      } else {
                        $datatransaksi = mysqli_query($conn, "SELECT * FROM transaksi t, siswa s WHERE s.id_siswa = t.id_siswa");
                      }

                      $i = 1;
                      while ( $data = mysqli_fetch_array($datatransaksi) ) {

                        $idt     = $data['id_transaksi'];
                        $ids     = $data['id_siswa'];
                        $tanggal = $data['tanggal'];
                        $nama    = $data['nama'];
                        $kelas   = $data['kelas'];
                        $jurusan = $data['jurusan'];
                        $bulan   = $data['bulan'];
                        $nominal = $data['nominal'];


                        // merubah tanggal menjadi hari
                        $days = date('D', strtotime($tanggal));

                        switch ($days) {
                          case 'Sun':
                            $day = 'Minggu';
                            break;
                          case 'Mon':
                            $day = 'Senin';
                            break;
                          case 'Tue':
                            $day = 'Selasa';
                            break;
                          case 'Wed':
                            $day = 'Rabu';
                            break;
                          case 'Thu':
                            $day = 'Kamis';
                            break;
                          case 'Fri':
                            $day = "Jum'at";
                            break;
                          case 'Sat':
                            $day = 'Sabtu';
                            break;
                        }

                        ?>

                        <tr>
                          <td>
                            <?= $day; ?>
                          </td>
                          <td>
                            <?= $tanggal; ?>
                          </td>
                          <td>
                            <?= $bulan; ?>
                          </td>
                          <td>
                            <?= $nama; ?>
                          </td>
                          <td>
                            <?= $kelas; ?>
                          </td>
                          <td>
                            <?= $jurusan; ?>
                          </td>
                          <td>
                            <?= $nominal; ?>
                          </td>
                        </tr>



                        <?php
                      }

                      ?>
                    </tbody>

                  </table>

                </div>
              </div>
            </div>



      </main>
      <footer class="py-4 bg-light mt-auto">
        <div class="container-fluid px-4">
          <div class="d-flex align-items-center justify-content-between small">
            <div class="text-muted">Copyright &copy; Muhammad Rafi 2023</div>
          </div>
        </div>
      </footer>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
    crossorigin="anonymous"></script>
  <script src="../js/scripts.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
  <script src="assets/demo/chart-area-demo.js"></script>
  <script src="assets/demo/chart-bar-demo.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
    crossorigin="anonymous"></script>
  <script src="../js/datatables-simple-demo.js"></script>
  <script src="https://kit.fontawesome.com/fb74548cd7.js" crossorigin="anonymous"></script>
</body>

</html>