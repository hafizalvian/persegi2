<?php
session_start();
include '../includes/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_SESSION['admin']['id'];
    $nama_lengkap = mysqli_real_escape_string($conn, $_POST['nama_lengkap']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    
    // Handle file upload
    if (!empty($_FILES['foto']['name'])) {
        $foto = $_FILES['foto'];
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        $max_size = 2 * 1024 * 1024; // 2MB
        
        if (!in_array($foto['type'], $allowed_types)) {
            $_SESSION['message'] = "Format file tidak didukung!";
            $_SESSION['message_type'] = "danger";
            header("Location: profile.php");
            exit();
        }
        
        if ($foto['size'] > $max_size) {
            $_SESSION['message'] = "Ukuran file terlalu besar! Max 2MB";
            $_SESSION['message_type'] = "danger";
            header("Location: profile.php");
            exit();
        }
        
        $foto_name = time() . '_' . $foto['name'];
        $upload_path = '../assets/img/profile/' . $foto_name;
        
        if (move_uploaded_file($foto['tmp_name'], $upload_path)) {
            // Delete old photo if exists
            if ($_SESSION['admin']['foto'] != 'default.png') {
                @unlink('../assets/img/profile/' . $_SESSION['admin']['foto']);
            }
            
            $foto_update = ", foto = '$foto_name'";
        }
    } else {
        $foto_update = "";
    }
    
    // Handle password update
    $password_update = "";
    if (!empty($_POST['password'])) {
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $password_update = ", password = '$password'";
    }
    
    $query = "UPDATE admin SET 
              nama_lengkap = '$nama_lengkap',
              username = '$username'
              $password_update
              $foto_update
              WHERE id = $id";
              
    if (mysqli_query($conn, $query)) {
        // Update session data
        $_SESSION['admin']['nama_lengkap'] = $nama_lengkap;
        $_SESSION['admin']['username'] = $username;
        if (!empty($foto_update)) {
            $_SESSION['admin']['foto'] = $foto_name;
        }
        
        $_SESSION['message'] = "Profile berhasil diupdate!";
        $_SESSION['message_type'] = "success";
    } else {
        $_SESSION['message'] = "Gagal mengupdate profile!";
        $_SESSION['message_type'] = "danger";
    }
    
    header("Location: profile.php");
    exit();
}