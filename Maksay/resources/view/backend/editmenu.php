<?php
include '../../../databases/database.php';
session_start();

// Get form inputs
$id_menu = $_POST['id_menu'];
$menu_code = $_POST['menu_code'];
$menu_name = $_POST['menu_name'];
$menu_description = $_POST['menu_description'];
$menu_image = $_FILES['menu_image']['name']; // Assuming file upload

// Get the current user's ID from the session
$id_login = $_SESSION['id_login']; // Current user

// SQL query to update the menu
$query = "UPDATE menu 
          SET menu_code = '$menu_code', 
              menu_name = '$menu_name', 
              menu_description = '$menu_description', 
              menu_image = '$menu_image', 
              modified_by = '$id_login' 
          WHERE id_menu = '$id_menu'";

if (mysqli_query($koneksi, $query)) {
    // Success - show alert and redirect to menu.php
    echo "<script>alert('Data successfully changed.'); window.location='../../menu.php';</script>";
    exit(); // Ensure no further code is executed after the alert
} else {
    // Error occurred - display error message
    echo "Error: " . $query . "<br>" . mysqli_error($koneksi);
}

mysqli_close($koneksi);
