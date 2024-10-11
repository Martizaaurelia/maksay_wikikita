<?php
// Include the database connection file
include '../../../databases/database.php';

// Get form inputs
$menu_code = $_POST['menu_code'] ?? '';
$menu_name = $_POST['menu_name'] ?? '';
$menu_description = $_POST['menu_description'] ?? '';
$menu_image = $_FILES['menu_image']['name'] ?? ''; // Assuming file upload

// Initialize variables for success or error messages
$success = false;
$error_message = "";

// Function to validate image extension
function isValidImage($extension) {
    $allowed_extensions = ['png', 'jpg', 'jpeg', 'jfif'];
    return in_array($extension, $allowed_extensions);
}

// Check if there is an image to upload
if ($menu_image) {
    $x = explode('.', $menu_image);
    $extension = strtolower(end($x));
    $file_tmp = $_FILES['menu_image']['tmp_name'];
    $random_number = rand(1, 999);
    $new_image_name = $random_number . '-' . basename($menu_image); // New image name with basename for security

    // Check if the extension is allowed
    if (isValidImage($extension)) {
        // Move the uploaded file
        if (move_uploaded_file($file_tmp, '../../../bootstrap/assets/img/menu/' . $new_image_name)) {
            // Prepare the INSERT query
            $query = "INSERT INTO menu (menu_code, menu_name, menu_description, menu_image) VALUES (?, ?, ?, ?)";
            $stmt = $koneksi->prepare($query);
            $stmt->bind_param("ssss", $menu_code, $menu_name, $menu_description, $new_image_name);
        } else {
            $error_message = "Failed to upload image.";
        }
    } else {
        $error_message = "Only JPG, JPEG, PNG & JFIF files are allowed.";
    }
} else {
    // Prepare the INSERT query without an image
    $query = "INSERT INTO menu (menu_code, menu_name, menu_description) VALUES (?, ?, ?)";
    $stmt = $koneksi->prepare($query);
    $stmt->bind_param("sss", $menu_code, $menu_name, $menu_description);
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
    echo "<script>alert('Data added successfully.'); window.location='../../menu.php';</script>";
} else {
    echo "<script>alert('$error_message'); window.location='../../menu.php';</script>";
}
?>
