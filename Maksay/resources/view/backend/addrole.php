<?php
// memanggil file koneksi.php untuk melakukan koneksi database
include '../../../databases/database.php';

// membuat variabel untuk menampung data dari form
$nama_role   = $_POST['nama_role'];
$query = "INSERT INTO role (nama_role) VALUES ('$nama_role')";
$result = mysqli_query($koneksi, $query);
// periska query apakah ada error
if (!$result) {
  die("Query gagal dijalankan: " . mysqli_errno($koneksi) .
    " - " . mysqli_error($koneksi));
} else {
  //tampil alert dan akan redirect ke halaman index.php
  //silahkan ganti index.php sesuai halaman yang akan dituju
  echo "<script>alert('Data added successfully.');window.location='../../role.php';</script>";
}
