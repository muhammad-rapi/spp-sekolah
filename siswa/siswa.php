<?php

session_start();

if ( !isset($_SESSION['login']) ) {
  header('location:login.php');
  exit;
}

require('../backend/function.php');

$data_s  = mysqli_query($conn, "SELECT * FROM siswa");
$hitungs = mysqli_num_rows($data_s)

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
            <a class="nav-link" href="siswa.php">
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
          <h1 class="mt-4 ">Data Siswa</h1>
          <div class="row mt-3">
            <div class="col-xl-3 col-md-6">
              <div class="card bg-primary text-white mb-4">
                <div class="card-body">
                  <h6>Jumlah Data Siswa =
                    <?= $hitungs; ?>
                  </h6>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-center">
                  <div class="sb-nav-link-icon"><i class="fa-solid fa-users-rectangle fa-4x"></i></div>
                </div>
              </div>
            </div>
            <div class="card mb-4">
              <div class="card-header">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                  Tambah Data Siswa
                </button>

              </div>
              <div class="card-body">




                <table id="datatablesSimple">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>NIS</th>
                      <th>Nama</th>
                      <th>Kelas</th>
                      <th>Jurusan</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>

                    <?php

                    $ambildata = mysqli_query($conn, "SELECT * FROM siswa");
                    $i         = 1;
                    while ( $data = mysqli_fetch_array($ambildata) ) {

                      $ids       = $data['id_siswa'];
                      $nis       = $data['nis'];
                      $namasiswa = $data['nama'];
                      $kelas     = $data['kelas'];
                      $jurusan   = $data['jurusan'];

                      // if ( $tambahsiswa ) {
                    
                      // }
                    
                      ?>

                      <tr>
                        <td>
                          <?= $i++; ?>
                        </td>
                        <td>
                          <?= $nis; ?>
                        </td>
                        <td>
                          <strong> <a href="../detail/detail.php?id=<?= $ids; ?>"><?= $namasiswa; ?></a></strong>
                        </td>
                        <td>
                          <?= $kelas; ?>
                        </td>
                        <td>
                          <?= $jurusan; ?>
                        </td>
                        <td>
                          <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                            data-bs-target="#edit<?= $ids; ?>">
                            Edit
                          </button>

                          <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                            data-bs-target="#delete<?= $ids; ?>">
                            Delete
                          </button>



                        </td>
                      </tr>

                      <!-- update modal -->
                      <div class="modal fade" id="edit<?= $ids; ?>" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h4 class="modal-title" id="exampleModalLabel">Edit Data Siswa</h4>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                              <form action="" method="post">
                                <input type="hidden" name="ids" value="<?= $ids; ?>">
                                <input type="number" class="form-control my-3" placeholder="NIS" name="nis"
                                  value="<?= $nis ?>">
                                <input type="text" class="form-control my-3" placeholder="Nama Siswa" name="nama"
                                  value="<?= $namasiswa; ?>">
                                <select class="form-select my-3" aria-label="Default select example" name="kelas">
                                  <option>
                                    <?= $kelas; ?>
                                  </option>
                                  <option>X</option>
                                  <option>XI</option>
                                  <option>XII</option>
                                </select>
                                <select class="form-control my-3" aria-label="Default select example" name="jurusan">
                                  <option>
                                    <?= $jurusan; ?>
                                  </option>
                                  <option>Rekayasa Perangkat Lunak</option>
                                  <option>Multimedia</option>
                                  <option>Bisnis Daring Pemasaran</option>
                                  <option>Otomatisasi Tatakelola Perkantoran</option>
                                  <option>Usaha Perjalanan Wisata</option>
                                  <option>Akuntansi Keuangan Lembaga</option>
                                  <option>Perbankan Keuangan Mikro</option>
                                </select>
                                <button type="submit" class="btn btn-primary" name="editsiswa">Submit</button>
                              </form>
                            </div>

                          </div>
                        </div>
                      </div>
                      <!-- last update modal -->

                      <!-- delete modal -->
                      <div class="modal fade" id="delete<?= $ids; ?>" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h4 class="modal-title" id="exampleModalLabel">Hapus Data Siswa</h4>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body my-3">
                              Apakah anda yakin ingin menghapus
                              <b>
                                <?= $namasiswa; ?>
                              </b> dari Data Siswa?
                              <br>
                              <form method="post">
                                <input type="hidden" name="ids" value="<?= $ids ?>">
                                <br>
                                <button type="submit" class="btn btn-danger" name="hapussiswa">Submit</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                              </form>
                            </div>

                          </div>
                        </div>
                      </div>
                      <!-- last delete modal -->

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
        <h4 class="modal-title" id="exampleModalLabel">Tambah Data Siswa</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="" method="post">
          <input type="hidden" name="ids">
          <input type="number" class="form-control my-3" placeholder="NIS" name="nis">
          <input type="text" class="form-control my-3" placeholder="Nama Siswa" name="nama">
          <select class="form-select my-3" aria-label="Default select example" name="kelas">
            <option selected>Kelas</option>
            <option>X</option>
            <option>XI</option>
            <option>XII</option>
          </select>
          <select class="form-select my-3" aria-label="Default select example" name="jurusan">
            <option selected>Jurusan</option>
            <option>Rekayasa Perangkat Lunak</option>
            <option>Multimedia</option>
            <option>Bisnis Daring Pemasaran</option>
            <option>Otomatisasi Tatakelola Perkantoran</option>
            <option>Usaha Perjalanan Wisata</option>
            <option>Akuntansi Keuangan Lembaga</option>
            <option>Perbankan Keuangan Mikro</option>
          </select>
          <button type="submit" class="btn btn-primary" name="tambahsiswa">Tambah</button>
        </form>
      </div>

    </div>
  </div>
</div>
<!-- last create modal -->





</html>