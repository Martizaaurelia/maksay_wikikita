<?php
include '../../../databases/database.php';
session_start();

// Check if id_menu is passed via the query string
if (isset($_GET['id_menu'])) {
    $id_menu = $_GET['id_menu'];

    // Get the current user's id_login from the session
    // $id_login = $_SESSION['id_login'];

    // Optional: Log the deletion with the current user's id_login (logging the action)
    // You could store this in a log table if needed
    // $log_query = "INSERT INTO log (action, id_login, id_menu, timestamp) VALUES ('delete', '$id_login', '$id_menu', NOW())";
    // mysqli_query($koneksi, $log_query);

    // Perform the deletion
    $query = "DELETE FROM submenu WHERE id = '$id_menu'";
    $hasil_query = mysqli_query($koneksi, $query);

    // Periksa query, apakah ada kesalahan
    if (!$hasil_query) {
        die("Gagal menghapus data: " . mysqli_errno($koneksi) . " - " . mysqli_error($koneksi));
    } else {
        echo "<script>alert('Data was successfully deleted.'); window.location='../../submenu.php';</script>";
    }
} else {
    echo "<script>alert('No menu ID specified.'); window.location='../../submenu.php';</script>";
}

// Close the database connection
mysqli_close($koneksi);
