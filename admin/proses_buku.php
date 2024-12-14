<?php
require_once '../includes/koneksi.php';
session_start();

// Common function to handle database operations
function handleBookOperation($conn, $query, $params, $types, $successMsg, $errorMsg) {
    $stmt = $conn->prepare($query);
    $stmt->bind_param($types, ...$params);
    
    if ($stmt->execute()) {
        $_SESSION['success'] = $successMsg;
    } else {
        $_SESSION['error'] = $errorMsg;
    }
    
    header("Location: buku.php");
    exit();
}

// Get common form data
function getBookData() {
    return [
        'judul' => $_POST['judul'],
        'pengarang' => $_POST['pengarang'],
        'penerbit' => $_POST['penerbit'],
        'tahun_terbit' => $_POST['tahun_terbit'],
        'isbn' => $_POST['isbn'],
        'stok' => $_POST['stok'],
        'lokasi' => $_POST['lokasi'],
        'kelas' => $_POST['kelas']
    ];
}

// Handle Add Book
if (isset($_POST['tambah'])) {
    $data = getBookData();
    $query = "INSERT INTO buku (judul, pengarang, penerbit, tahun_terbit, isbn, stok, lokasi, kelas) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $params = array_values($data);
    
    handleBookOperation(
        $conn, 
        $query, 
        $params, 
        "ssssssss", 
        "Buku berhasil ditambahkan!", 
        "Gagal menambahkan buku!"
    );
}

// Handle Update Book
if (isset($_POST['update'])) {
    $data = getBookData();
    $data['id'] = $_POST['id'];
    
    $query = "UPDATE buku 
              SET judul=?, pengarang=?, penerbit=?, tahun_terbit=?, isbn=?, stok=?, lokasi=?, kelas=? 
              WHERE id=?";
    $params = array_values($data);
    
    handleBookOperation(
        $conn, 
        $query, 
        $params, 
        "ssssssssi", 
        "Data buku berhasil diupdate!", 
        "Gagal mengupdate data buku!"
    );
}