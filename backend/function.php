<?php


$conn = mysqli_connect("localhost", "root", "", "spp-sekolah");

// function registrasi
function registrasi($data)
{
  global $conn;

  $username  = strtolower(stripslashes($data['username']));
  $password  = mysqli_real_escape_string($conn, $data['password']);
  $password2 = mysqli_real_escape_string($conn, $data['password2']);

  // mengecek apakah username sudah ada atau belum
  $result = mysqli_query($conn, "SELECT username FROM admin WHERE username = '$username'");

  if ( mysqli_fetch_assoc($result) ) {
    echo "<script>
            alert('Username sudah terdaftar!');
        </script>";
    return false;
  }

  // cek konfirmasi password

  if ( $password2 != $password ) {
    echo "<script>
            alert('Konfirmasi password tidak sesuai!')
          </script>";
    return false;
  }


  // mengenskripsi password
  $password = password_hash($password, PASSWORD_DEFAULT);

  // menambah user baru ke db
  mysqli_query($conn, "INSERT INTO admin VALUES (NULL, '$username', '$password') ");

  return mysqli_affected_rows($conn);


}
// last registrasi

// tambah data siswa

if ( isset($_POST['tambahsiswa']) ) {

  $nis     = $_POST['nis'];
  $nama    = $_POST['nama'];
  $kelas   = $_POST['kelas'];
  $jurusan = $_POST['jurusan'];

  $tambahsiswa = mysqli_query($conn, "INSERT INTO siswa (id_siswa, nis, nama, kelas, jurusan) VALUES ( NULL, '$nis', '$nama', '$kelas', '$jurusan') ");

  if ( $tambahsiswa ) {
    echo "<script>
                alert('Berhasil Menambah Data Siswa');
                window.location.href = 'siswa.php'
            </script>";
  } else {
    echo "<script>
                alert('Gagal Menambah Data Siswa');
                window.location.href = 'siswa.php'
            </script>";
  }

}
// last tambah data siswa

// update data siswa
if ( isset($_POST['editsiswa']) ) {

  $ids     = $_POST['ids'];
  $nis     = $_POST['nis'];
  $nama    = $_POST['nama'];
  $kelas   = $_POST['kelas'];
  $jurusan = $_POST['jurusan'];

  $editsiswa = mysqli_query($conn, "UPDATE siswa SET nis = '$nis', nama = '$nama', kelas = '$kelas', jurusan = '$jurusan ' WHERE id_siswa = '$ids'");

  if ( $editsiswa ) {
    echo "<script>
                alert('Berhasil Mengedit Data Siswa');
                window.location.href = 'siswa.php'
            </script>";
  } else {
    echo "<script>
                alert('Gagal Mengedit Data Siswa');
                window.location.href = 'siswa.php'
            </script>";
  }

}
// last update data siswa


// delete data siswa
if ( isset($_POST['hapussiswa']) ) {

  $ids     = $_POST['ids'];
  $nis     = $_POST['nis'];
  $nama    = $_POST['nama'];
  $kelas   = $_POST['kelas'];
  $jurusan = $_POST['jurusan'];

  $hapussiswa = mysqli_query($conn, "DELETE FROM siswa WHERE id_siswa = '$ids'");

  if ( $hapussiswa ) {
    echo "<script>
                alert('Berhasil Menghapus Data Siswa');
                window.location.href = 'siswa.php'
            </script>";
  } else {
    echo "<script>
                alert('Gagal Menghapus Data Siswa');
                window.location.href = 'siswa.php'
            </script>";
  }

}
// last delete data siswa

// menambah data transaksi
if ( isset($_POST['tambahtransaksi']) ) {

  $bulan   = $_POST['bulan'];
  $nominal = $_POST['nominal'];
  $ids     = $_POST['idsiswa'];

  $tmbhtransaksi = mysqli_query($conn, "INSERT INTO transaksi (id_transaksi, id_siswa, bulan, nominal) VALUES (NULL,'$ids', '$bulan', '$nominal') ");

  if ( $tmbhtransaksi ) {

  } else {
    echo "<script>
                alert('Gagal Menambah Transaksi');
                window.location.href ='detail.php'
            </script>";
  }

}


?>