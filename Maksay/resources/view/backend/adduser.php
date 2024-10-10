<?php
// memanggil file koneksi.php untuk melakukan koneksi database
include '../../../databases/database.php';

// membuat variabel untuk menampung data dari form
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
    move_uploaded_file($file_tmp, '../../../bootstrap/assets/img/user/' . $nama_gambar_baru); //memindah file gambar ke folder gambar
    
    // jalankan query INSERT untuk menambah data ke database pastikan sesuai urutan (id tidak perlu karena dibikin otomatis)
    $query = "INSERT INTO login (nama_lengkap, NIK,password, id_role, gambar) VALUES ('$nama_lengkap','$NIK','$password','$id_role','$nama_gambar_baru')";
    $result = mysqli_query($koneksi, $query);
    // periska query apakah ada error
    if (!$result) {
      die("Query gagal dijalankan: " . mysqli_errno($koneksi) .
        " - " . mysqli_error($koneksi));
    } else {
      //tampil alert dan akan redirect ke halaman index.php
      //silahkan ganti index.php sesuai halaman yang akan dituju
      echo "<script>alert('Data added successfully.');window.location='../../user.php';</script>";
    }
  } else {
    //jika file ekstensi tidak jpg dan png maka alert ini yang tampil
    echo "<script>alert('The only image extensions allowed are jpg or png.');window.location='tambahuser.php';</script>";
  }
} else {
  $query = "INSERT INTO login ( nama_lengkap, NIK,password, id_role) VALUES ('$nama_lengkap','$NIK','$password','$id_role')";
  $result = mysqli_query($koneksi, $query);
  // periska query apakah ada error
  if (!$result) {
    die("Query gagal dijalankan: " . mysqli_errno($koneksi) .
      " - " . mysqli_error($koneksi));
  } else {
    //tampil alert dan akan redirect ke halaman index.php
    //silahkan ganti index.php sesuai halaman yang akan dituju
    echo "<script>alert('Data added successfully.');window.location='user.php';</script>";
  }
}
