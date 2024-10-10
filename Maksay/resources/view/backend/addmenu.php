<?php
include '../../../databases/database.php';
session_start();

// Pastikan method adalah POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $menu_code = mysqli_real_escape_string($koneksi, $_POST['menu_code']);
    $menu_name = mysqli_real_escape_string($koneksi, $_POST['menu_name']);
    $menu_description = mysqli_real_escape_string($koneksi, $_POST['menu_description']);
    
    // Check if the user is logged in
    // if (isset($_SESSION['id_login'])) {
    //     $modified_by = $_SESSION['id_login'];
    // } else {
    //     echo "User not logged in. Please log in first.";
    //     exit();
    // }

    // Proses untuk upload gambar
    $menu_image = $_FILES['menu_image']['name'];
    $target_dir = "uploads/";
    // Ensure target directory exists
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true); // Create directory if it does not exist
    }
    
    $target_file = $target_dir . basename($menu_image);

    // Cek apakah file berhasil di-upload
    if (move_uploaded_file($_FILES['menu_image']['tmp_name'], $target_file)) {
        // Simpan data ke database dengan informasi pengguna yang memodifikasi
        $query = "INSERT INTO menu (menu_code, menu_name, menu_description, menu_image, modified_by) 
                  VALUES ('$menu_code', '$menu_name', '$menu_description', '$target_file', '$modified_by')";

        if (mysqli_query($koneksi, $query)) {
            // Jika berhasil, tampilkan pesan dan redirect
            echo "<script>alert('Data added successfully.'); window.location='../../menu.php';</script>";
            exit(); // Pastikan script berhenti setelah alert
        } else {
            // Jika terjadi error, tampilkan pesan error
            echo "Error: " . $query . "<br>" . mysqli_error($koneksi);
        }
    } else {
        // Jika gambar gagal di-upload
        echo "Error uploading image.";
    }
}

// Tutup koneksi
mysqli_close($koneksi);
?>
