<?php
include '../databases/database.php';

$id_role = $_GET["id_role"];

// Cek apakah id_role digunakan dalam tabel lain
$checkQuery = "SELECT COUNT(*) AS count FROM login WHERE id_role = '$id_role'";
$checkResult = mysqli_query($koneksi, $checkQuery);
$row = mysqli_fetch_assoc($checkResult);

if ($row['count'] > 0) {
    // Jika id_role ditemukan di tabel lain, tampilkan pesan dan hentikan proses penghapusan
    echo "<script>alert('Failed to delete data. This role ID is in use in another table.');window.location='role.php';</script>";
} else {
    // Jika tidak ada yang menggunakan, lanjutkan dengan penghapusan
    $query = "DELETE FROM role WHERE id_role = '$id_role'";
    $hasil_query = mysqli_query($koneksi, $query);

    // Periksa query, apakah ada kesalahan
    if (!$hasil_query) {
        die("Gagal menghapus data: " . mysqli_errno($koneksi) . " - " . mysqli_error($koneksi));
    } else {
        echo "<script>alert('Data was successfully deleted.');window.location='role.php';</script>";
    }
}
