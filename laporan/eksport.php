<?php

session_start();

if ( !isset($_SESSION['login']) ) {
  header('location:login.php');
  exit;
}

require('../backend/function.php');

$get   = mysqli_query($conn, "SELECT * FROM siswa");
$fetch = mysqli_fetch_assoc($get);

// set variable
$nis     = $fetch['nis'];
$nama    = $fetch['nama'];
$kelas   = $fetch['kelas'];
$jurusan = $fetch['jurusan']



  ?>
<html>

<head>
  <title>Export Data Laporan Harian</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.5/css/buttons.dataTables.min.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
  <script type="text/javascript" charset="utf8"
    src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
</head>

<body>
  <div class="container">
    <h2>Eksport Data</h2>
    <h4>(Laporan Harian)</h4>
    <div class="row ">
      <div class="col">
        <form action="" method="post" class=" mt-4 d-flex gap-3">
          <input type="date" name="tgl-mulai" class="form-control w-25">
          <input type="date" name="tgl-selesai" class="form-control ml-3 w-25">
          <button type="submit" name="filter-tgl" class="btn btn-dark ml-3">Filter Tanggal</button>
        </form>
      </div>
    </div>
    <div class="data-tables datatable-dark">

      <!-- Masukkan table nya disini, dimulai dari tag TABLE -->

      <table id="maueksport" class="table-bordered">
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

  <script>
    $(document).ready(function () {
      $('#maueksport').DataTable({
        dom: 'Bfrtip',
        buttons: [
          'copy', 'csv', 'excel', 'pdf', 'print'
        ]
      });
    });
  </script>

  <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
  <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.flash.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.print.min.js"></script>



</body>

</html>