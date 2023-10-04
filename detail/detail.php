<?php

session_start();

if ( !isset($_SESSION['login']) ) {
  header('location:login.php');
  exit;
}

require('../backend/function.php');

// dapetin id dari siswa yg dipassing pake link

$idsiswa = $_GET['id'];

// GET informasi barang berdasarakn database
$get   = mysqli_query($conn, "SELECT * FROM siswa WHERE id_siswa = '$idsiswa'");
$fetch = mysqli_fetch_assoc($get);

// set variable
$nis     = $fetch['nis'];
$nama    = $fetch['nama'];
$kelas   = $fetch['kelas'];
$jurusan = $fetch['jurusan'];


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
      color: #345eeb;
      transition: .3s;
    }

    a:hover {
      color: darkblue;
    }

    .row {
      margin-top: 100px;
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
            <a class="nav-link" href="../laporan/laporan.php">
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
          <h1 class="mt-4">Detail Data Siswa</h1>



          <div class="card mb-4">

            <div class="card-body">

              <div class="row mt-0 mb-3">
                <div class="col-md-9 p-2">
                  <h6>
                    NIS =
                    <?= $nis ?>
                  </h6>
                  <h6>
                    NAMA =
                    <?= $nama ?>
                  </h6>
                  <h6>
                    KELAS =
                    <?= $kelas ?>
                  </h6>
                  <h6>
                    JURUSAN =
                    <?= $jurusan ?>
                  </h6>
                </div>
              </div>

              <h3>Tambah Transaksi</h3>
              <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Tambah Transaksi
              </button>

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

                  $datatransaksi = mysqli_query($conn, "SELECT * FROM transaksi WHERE '$idsiswa' = id_siswa");
                  $i             = 1;
                  $rp            = "Rp.";
                  while ( $data = mysqli_fetch_array($datatransaksi) ) {

                    $idt     = $data['id_transaksi'];
                    $ids     = $data['id_siswa'];
                    $tanggal = $data['tanggal'];
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

<!-- Modal create -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLabel">Tambah Transaksi</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="" method="post">
          <input type="hidden" name="idt">
          <input type="hidden" name="idsiswa" value="<?= $idsiswa; ?>" class="form-control">
          <select class="form-select my-3" aria-label="Default select example" name="bulan">
            <option>Pilih Bulan</option>
            <option>Januari</option>
            <option>Februari</option>
            <option>Maret</option>
            <option>April</option>
            <option>Mei</option>
            <option>Juni</option>
            <option>Juli</option>
            <option>Agustus</option>
            <option>September</option>
            <option>Oktober</option>
            <option>November</option>
            <option>Desember</option>
          </select>
          <input type="text" class="form-control my-3" placeholder="Nama Siswa" name="nama" value="<?= $nama ?>">
          <select class="form-select my-3" aria-label="Default select example" name="kelas">
            <option selected>
              <?= $kelas ?>
            </option>
            <option>X</option>
            <option>XI</option>
            <option>XII</option>
          </select>
          <select class="form-select my-3" aria-label="Default select example" name="jurusan" value>
            <option>Rekayasa Perangkat Lunak</option>
            <option>Multimedia</option>
            <option>Bisnis Daring Pemasaran</option>
            <option>Otomatisasi Tatakelola Perkantoran</option>
            <option>Usaha Perjalanan Wisata</option>
            <option>Akuntansi Keuangan Lembaga</option>
            <option>Perbankan Keuangan Mikro</option>
          </select>
          <input type="number" class="form-control my-3" placeholder="Nominal" name="nominal">
          <button type="submit" class="btn btn-primary" name="tambahtransaksi">Tambah</button>
        </form>
      </div>

    </div>
  </div>
</div>
<!-- last create modal -->





</html>