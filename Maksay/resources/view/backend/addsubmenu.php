<?php
// Include the database connection file
include '../../../databases/database.php';

// Get form inputs
$submenu_name = $_POST['submenu_name'] ?? '';
$submenu_code = $_POST['submenu_code'] ?? '';
$menu_id = $_POST['id_menu'] ?? 0;
$user_id = $_POST['user_id'] ?? 17;
$description = $_POST['description'] ?? '';
$modifiedBy = $_POST['modified_by'] ?? '';
$image = $_FILES['image']['name'] ?? ''; // Assuming file upload

// Initialize variables for success or error messages
$success = false;
$error_message = "";

// Function to validate image extension
function isValidImage($extension)
{
    $allowed_extensions = ['png', 'jpg', 'jpeg', 'jfif'];
    return in_array($extension, $allowed_extensions);
}

// Check if there is an image to upload
if ($image) {
    $x = explode('.', $image);
    $extension = strtolower(end($x));
    $file_tmp = $_FILES['image']['tmp_name'];
    $random_number = rand(1, 999);
    $new_image_name = $random_number . '-' . basename($image); // New image name with basename for security

    // Check if the extension is allowed
    if (isValidImage($extension)) {
        // Move the uploaded file
        if (move_uploaded_file($file_tmp, '../../../bootstrap/assets/img/submenu/' . $new_image_name)) {
            // Prepare the INSERT query
            $query = "INSERT INTO submenu(submenu_name, menu_id, user_id, image, description, modified_by, submenu_code) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $koneksi->prepare($query);
            $stmt->bind_param("sssssss", $submenu_name, $menu_id, $user_id, $new_image_name, $description, $modifiedBy, $submenu_code);
        } else {
            $error_message = "Failed to upload image.";
        }
    } else {
        $error_message = "Only JPG, JPEG, PNG & JFIF files are allowed.";
    }
} else {
    // Prepare the INSERT query without an image
    $query = "INSERT INTO submenu(submenu_name, menu_id, user_id, image, description, modified_by, submenu_code) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $koneksi->prepare($query);
    $stmt->bind_param("sssssss", $submenu_name, $menu_id, $user_id, $new_image_name, $description, $modifiedBy, $submenu_code);
}

// Execute the query
if (isset($stmt) && $stmt->execute()) {
    $success = true;
} else {
    $error_message = "Query failed: " . $stmt->error; // Use $stmt->error for error message
}

// Close the statement
$stmt->close();

// Close the database connection
$koneksi->close();

// Provide feedback to the user
if ($success) {
    echo "<script>alert('Data added successfully.'); window.location='../../submenu.php';</script>";
} else {
    echo "<script>alert('$error_message'); window.location='../../submenu.php';</script>";
}
?>