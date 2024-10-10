<?php
include '../../../databases/database.php';

// membuat variabel untuk menampung data dari form
$id_role           = $_POST['id_role'];
$nama_role       = $_POST['nama_role'];
// query SQL untuk insert data
$query = "UPDATE role SET nama_role='$nama_role' where id_role='$id_role'";
mysqli_query($koneksi, $query);
// mengalihkan ke halaman index.php
echo "<script>alert('Data successfully changed.');window.location='../../role.php';</script>";
