<?php
// memanggil file koneksi.php untuk melakukan koneksi database
include '../../../databases/database.php';

// membuat variabel untuk menampung data dari form
$id_login = $_POST['id_login'];
$nama_lengkap   = $_POST['nama_lengkap'];
$NIK     = $_POST['NIK'];
$password = md5($_POST['password']);
$id_role     = $_POST['id_role'];
$gambar = $_FILES['gambar']['name'];

//cek dulu jika merubah gambar jalankan coding ini
if ($gambar != "") {
  $ekstensi_diperbolehkan = array('png', 'jpg', 'jpeg', 'jfif'); //ekstensi file gambar yang bisa diupload 
  $x = explode('.', $gambar); //memisahkan nama file dengan ekstensi yang diupload
  $ekstensi = strtolower(end($x));
  $file_tmp = $_FILES['gambar']['tmp_name'];
  $angka_acak     = rand(1, 999);
  $nama_gambar_baru = $angka_acak . '-' . $gambar; //menggabungkan angka acak dengan nama file sebenarnya
  if (in_array($ekstensi, $ekstensi_diperbolehkan) === true) {
    move_uploaded_file($file_tmp, '../../../bootstrap/assets/img/user/' . $nama_gambar_baru); //memindahkan file gambar ke folder gambar

    // jalankan query UPDATE dengan gambar baru
    $query  = "UPDATE login SET nama_lengkap = '$nama_lengkap', NIK = '$NIK', password = '$password', id_role = '$id_role', gambar = '$nama_gambar_baru' ";
    $query .= "WHERE id_login = '$id_login'";
    $result = mysqli_query($koneksi, $query);

    // periksa query apakah ada error
    if (!$result) {
      die("Query gagal dijalankan: " . mysqli_errno($koneksi) . " - " . mysqli_error($koneksi));
    } else {
      //tampil alert dan redirect ke halaman user
      echo "<script>alert('Data successfully changed.');window.location='../../user.php';</script>";
    }
  } else {
    //jika ekstensi file tidak diperbolehkan
    echo "<script>alert('Only image extensions allowed are jpg, jpeg, or png.');window.location='../../user.php';</script>";
  }
} else {
  // jalankan query UPDATE tanpa gambar baru
  $query  = "UPDATE login SET nama_lengkap = '$nama_lengkap', NIK = '$NIK', id_role = '$id_role' ";
  $query .= "WHERE id_login = '$id_login'";
  $result = mysqli_query($koneksi, $query);

  // periksa query apakah ada error
  if (!$result) {
    die("Query gagal dijalankan: " . mysqli_errno($koneksi) . " - " . mysqli_error($koneksi));
  } else {
    //tampil alert dan redirect ke halaman user
    echo "<script>alert('Data successfully changed.');window.location='../../user.php';</script>";
  }
}
?>
