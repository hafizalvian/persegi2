<?php
session_start();
require_once '../includes/koneksi.php';

if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
    exit();
}

$id = $_GET['id'];
$query = mysqli_query($conn, "SELECT * FROM anggota WHERE id_anggota = '$id'");
$data = mysqli_fetch_array($query);

if (!$data) {
    echo "<script>alert('Data tidak ditemukan!'); window.location='anggota.php';</script>";
    exit();
}

if (isset($_POST['submit'])) {
    $nama = $_POST['nama'];
    $nis = $_POST['nis'];
    $kelas = $_POST['kelas'];
    $no_hp = $_POST['no_hp'];
    $alamat = $_POST['alamat'];

    $update = mysqli_query($conn, "UPDATE anggota SET 
        nama = '$nama',
        nis = '$nis',
        kelas = '$kelas',
        no_hp = '$no_hp',
        alamat = '$alamat'
        WHERE id_anggota = '$id'");

    if ($update) {
        echo "<script>alert('Data berhasil diupdate!'); window.location='anggota.php';</script>";
    }
}

include 'template/header.php';
include 'template/sidebar.php';
?>

<div class="wrapper">
    <div class="main-content">
        <div class="content">
            <h2 class="page-title mb-4">Edit Anggota</h2>

            <div class="card shadow mb-4">
                <div class="card-body">
                    <form method="POST" action="">
                        <div class="form-group">
                            <label>ID Anggota</label>
                            <input type="text" class="form-control" value="<?= $data['id_anggota'] ?>" readonly>
                        </div>

                        <div class="form-group">
                            <label>Nama Lengkap</label>
                            <input type="text" class="form-control" name="nama" value="<?= $data['nama'] ?>" required>
                        </div>

                        <div class="form-group">
                            <label>NIS</label>
                            <input type="text" class="form-control" name="nis" value="<?= $data['nis'] ?>" required>
                        </div>

                        <div class="form-group">
                            <label>Kelas</label>
                            <input type="text" class="form-control" name="kelas" value="<?= $data['kelas'] ?>" required>
                        </div>

                        <div class="form-group">
                            <label>No. HP</label>
                            <input type="text" class="form-control" name="no_hp" value="<?= $data['no_hp'] ?>" required>
                        </div>

                        <div class="form-group">
                            <label>Alamat</label>
                            <textarea class="form-control" name="alamat" required><?= $data['alamat'] ?></textarea>
                        </div>

                        <button type="submit" name="submit" class="btn btn-primary">Update</button>
                        <a href="anggota.php" class="btn btn-secondary">Kembali</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'template/footer.php'; ?>