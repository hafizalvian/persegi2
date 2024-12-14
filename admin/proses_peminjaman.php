<?php
session_start();
require_once '../includes/koneksi.php';

// Set header for JSON response
header('Content-Type: application/json');

// Get form data
$id_anggota = $_POST['id_anggota'];
$id_buku = $_POST['id_buku'];
$tanggal_pinjam = $_POST['tanggal_pinjam'];
$tanggal_kembali = $_POST['tanggal_kembali'];

// Insert into peminjaman table
$query = "INSERT INTO peminjaman (id_anggota, id_buku, tanggal_pinjam, tanggal_kembali, status) 
          VALUES ('$id_anggota', '$id_buku', '$tanggal_pinjam', '$tanggal_kembali', 'dipinjam')";

if(mysqli_query($conn, $query)) {
    // Update book stock
    $update_stok = "UPDATE buku SET stok = stok - 1 WHERE id = '$id_buku'";
    mysqli_query($conn, $update_stok);
    
    echo json_encode([
        'status' => 'success',
        'message' => 'Peminjaman berhasil disimpan'
    ]);
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Gagal menyimpan peminjaman'
    ]);
}

mysqli_close($conn);

header("Location: peminjaman.php");
exit();
?>