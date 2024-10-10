<?php
include '../../../databases/database.php';

if (isset($_GET["id_role"]) && is_numeric($_GET["id_role"])) {
    $id_role = $_GET["id_role"];
    
    // Pertama, hapus semua entri terkait di tabel lain
    $query_delete_users = "DELETE FROM login WHERE id_role = ?";
    
    if ($stmt_users = mysqli_prepare($koneksi, $query_delete_users)) {
        mysqli_stmt_bind_param($stmt_users, 'i', $id_role);
        mysqli_stmt_execute($stmt_users);
        mysqli_stmt_close($stmt_users);
    } else {
        die("Gagal mempersiapkan query untuk menghapus pengguna: " . mysqli_error($koneksi));
    }

    // Sekarang hapus role
    $query = "DELETE FROM role WHERE id_role = ?";
    
    if ($stmt_role = mysqli_prepare($koneksi, $query)) {
        mysqli_stmt_bind_param($stmt_role, 'i', $id_role);
        
        if (mysqli_stmt_execute($stmt_role)) {
            header("Location: ../../role.php?message=Data berhasil dihapus.");
            
            exit();
        } else {
            die("Gagal menghapus data role: " . mysqli_errno($koneksi) . " - " . mysqli_error($koneksi));
        }
        
        mysqli_stmt_close($stmt_role);
    } else {
        die("Gagal mempersiapkan query untuk menghapus role: " . mysqli_error($koneksi));
    }
} else {
    die("ID role tidak valid.");
}

mysqli_close($koneksi);
?>
