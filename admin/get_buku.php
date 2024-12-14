<?php
require_once '../includes/koneksi.php';

if(isset($_POST['id'])) {
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    
    $query = "SELECT id_buku, judul, stok FROM buku WHERE id_buku = '$id'";
    $result = mysqli_query($conn, $query);
    
    if(mysqli_num_rows($result) > 0) {
        $buku = mysqli_fetch_assoc($result);
        $status = ($buku['stok'] > 0) ? 'tersedia' : 'kosong';
        
        echo json_encode([
            'judul' => $buku['judul'],
            'status' => $status,
            'stok' => $buku['stok']
        ]);
    } else {
        echo json_encode(['error' => true]);
    }
}