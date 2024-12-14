<?php
require_once '../includes/koneksi.php';

if(isset($_POST['id'])) {
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $query = mysqli_query($conn, "SELECT * FROM anggota WHERE id_anggota = '$id'");
    
    if(mysqli_num_rows($query) > 0) {
        $data = mysqli_fetch_assoc($query);
        echo json_encode([
            'status' => 'success',
            'nama' => $data['nama']
        ]);
    } else {
        echo json_encode(['status' => 'error']);
    }
}