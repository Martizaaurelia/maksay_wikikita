<?php
include '../databases/database.php';

// Get the user ID from the URL parameter
$id_login = $_GET["id_login"];

// Check if the user ID is used in any other relevant tables
// Add other tables as needed
$checkQuery = "SELECT COUNT(*) AS count FROM login WHERE id_role = '$id_role'";
$checkResult = mysqli_query($koneksi, $checkQuery);

// Handle potential query error
if (!$checkResult) {
    die("Query failed: " . mysqli_error($koneksi));
}

$row = mysqli_fetch_assoc($checkResult);

// Check if the user ID is found in any of the specified tables
if ($row['activity_count'] > 0 || $row['roles_count'] > 0) {
    // If id_login is found in another table, show an alert and stop the deletion process
    echo "<script>alert('Failed to delete data. This user ID is in use in another table.');window.location='user.php';</script>";
} else {
    // If not used, proceed to delete the user
    $query = "DELETE FROM login WHERE id_login = '$id_login'";
    $hasil_query = mysqli_query($koneksi, $query);

    // Check the query for any errors
    if (!$hasil_query) {
        die("Failed to delete data: " . mysqli_errno($koneksi) . " - " . mysqli_error($koneksi));
    } else {
        echo "<script>alert('Data was successfully deleted.');window.location='user.php';</script>";
    }
}
