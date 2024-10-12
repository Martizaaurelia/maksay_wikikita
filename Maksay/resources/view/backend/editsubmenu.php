<?php
include '../../../databases/database.php';
session_start();

// Get form inputs
$submenu_name = $_POST['submenu_name_'] ?? '';
$submenu_code = $_POST['submenu_code_'] ?? '';
$menu_id = $_POST['id_menu_'] ?? 0;
$user_id = $_POST['user_id_'] ?? 17;
$description = $_POST['description_'] ?? '';
$modifiedBy = $_POST['modified_by_'] ?? '';
$image = $_FILES['image']['name'] ?? ''; // Assuming file upload

// Get the current user's ID from the session
$id_login = $_SESSION['id_login']; // Current user

// SQL query to update the menu
$query = "UPDATE submenu 
          SET menu_id = '$menu_id',
              submenu_code = '$submenu_code', 
              submenu_name = '$submenu_name', 
              description = '$description', 
              image = '$image'
          WHERE id = '$id_menu'";

if (mysqli_query($koneksi, $query)) {
    // Success - show alert and redirect to menu.php
    echo "<script>alert('Data successfully changed.'); window.location='../../submenu.php';</script>";
    exit(); // Ensure no further code is executed after the alert
} else {
    // Error occurred - display error message
    echo "Error: " . $query . "<br>" . mysqli_error($koneksi);
}

mysqli_close($koneksi);
