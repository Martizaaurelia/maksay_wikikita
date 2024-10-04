<?php
include '../databases/database.php';
session_start();

// Get the current user's ID from the session
$id_menu = $_POST['id_menu'];

// Get form inputs
$menu_code = $_POST['menu_code'];
$menu_name = $_POST['menu_name'];
$menu_description = $_POST['menu_description'];
$menu_image = $_FILES['menu_image']['name']; // Assuming file upload
$modified_by = $_SESSION['id_login']; // ID pengguna yang sedang login

// SQL query to insert menu data with the current user's id as the modified_by
$query = "INSERT INTO menu (menu_code, menu_name, menu_description, menu_image, modified_by) 
          VALUES ('$menu_code', '$menu_name', '$menu_description', '$menu_image', '$id_login')";

if (mysqli_query($koneksi, $query)) {
    // Success - show alert and redirect to menu.php
    echo "<script>alert('Data added successfully.'); window.location='resources\view_admin\frontend\menu.php';</script>";
    exit(); // Ensure script execution stops after the alert
} else {
    // Error occurred - display error message
    echo "Error: " . $query . "<br>" . mysqli_error($koneksi);
}

mysqli_close($koneksi);
