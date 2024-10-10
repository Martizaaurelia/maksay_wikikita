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

//cek dulu jika merubah gambar Guru jalankan coding ini
if ($gambar != "") {
  $ekstensi_diperbolehkan = array('png', 'jpg', 'jpeg', 'jfif'); //ekstensi file gambar yang bisa diupload 
  $x = explode('.', $gambar); //memisahkan nama file dengan ekstensi yang diupload
  $ekstensi = strtolower(end($x));
  $file_tmp = $_FILES['gambar']['tmp_name'];
  $angka_acak     = rand(1, 999);
  $nama_gambar_baru = $angka_acak . '-' . $gambar; //menggabungkan angka acak dengan nama file sebenarnya
  if (in_array($ekstensi, $ekstensi_diperbolehkan) === true) {
    move_uploaded_file($file_tmp, '../../../bootstrap/assets/img/user/' . $nama_gambar_baru); //memindah file gambar ke folder gambarke folder gambar

    // jalankan query UPDATE berdasarkan id_about yang produknya kita edit
    $query  = "UPDATE login SET nama_lengkap = '$nama_lengkap', NIK = '$NIK',password = '$password', id_role = '$id_role', gambar = '$nama_gambar_baru'";
    $query .= "WHERE id_login = '$id_login'";
    $result = mysqli_query($koneksi, $query);
    // periska query apakah ada error
    if (!$result) {
      die("Query gagal dijalankan: " . mysqli_errno($koneksi) .
        " - " . mysqli_error($koneksi));
    } else {
      //tampil alert dan akan redirect ke halaman index.php
      //silahkan ganti index.php sesuai halaman yang akan dituju
      echo "<script>alert('Data successfully changed.');window.location='../../user.php';</script>";
    }
  } else {
    //jika file ekstensi tidak jpg dan png maka alert ini yang tampil
    echo "<script>alert('he only image extensions allowed are jpg or png.');window.location='../../user.php';</script>";
  }
} else {
  // jalankan query UPDATE berdasarkan id_about yang produknya kita edit
  $query  = "UPDATE login SET nama_lengkap = '$nama_lengkap', NIK = '$NIK', id_role = '$id_role',";
  $query .= "WHERE id_login = '$id_login'";
  $result = mysqli_query($koneksi, $query);
  // periska query apakah ada error
  if (!$result) {
    die("Query gagal dijalankan: " . mysqli_errno($koneksi) .
      " - " . mysqli_error($koneksi));
  } else {
    //tampil alert dan akan redirect ke halaman index.php
    //silahkan ganti index.php sesuai halaman yang akan dituju
    echo "<script>alert('Data successfully changed.');window.location='../../user.php';</script>";
  }
}
