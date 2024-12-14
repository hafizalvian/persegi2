<?php
require_once '../includes/koneksi.php';
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM buku WHERE id_buku = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $buku = $result->fetch_assoc();
}

if (isset($_POST['update'])) {
    $id = $_POST['id_buku'];
    $judul = $_POST['judul'];
    $pengarang = $_POST['pengarang'];
    $penerbit = $_POST['penerbit'];
    $tahun_terbit = $_POST['tahun_terbit'];
    $isbn = $_POST['isbn'];
    $stok = $_POST['stok'];
    $lokasi = $_POST['lokasi'];
    $tingkat = $_POST['tingkat'];

    $query = "UPDATE buku SET judul=?, pengarang=?, penerbit=?, tahun_terbit=?, 
              isbn=?, stok=?, lokasi_rak=?, tingkat=? WHERE id_buku=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssissssi", $judul, $pengarang, $penerbit, $tahun_terbit, 
                      $isbn, $stok, $lokasi, $tingkat, $id);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Data buku berhasil diupdate!";
        header("Location: buku.php");
        exit();
    } else {
        $_SESSION['error'] = "Gagal mengupdate data buku!";
    }
}

include 'template/header.php';
?>

<div class="container-fluid">
    <div class="row">
        <?php include 'template/sidebar.php'; ?>
        
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="card shadow mb-4 mt-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Edit Buku</h6>
                </div>
                <div class="card-body">
                    <form action="" method="POST">
                        <input type="hidden" name="id_buku" value="<?php echo $buku['id_buku']; ?>">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label>Judul Buku</label>
                                    <input type="text" class="form-control" name="judul" 
                                           value="<?php echo $buku['judul']; ?>" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label>Pengarang</label>
                                    <input type="text" class="form-control" name="pengarang" 
                                           value="<?php echo $buku['pengarang']; ?>" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label>Penerbit</label>
                                    <input type="text" class="form-control" name="penerbit" 
                                           value="<?php echo $buku['penerbit']; ?>" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label>ISBN</label>
                                    <input type="text" class="form-control" name="isbn" 
                                           value="<?php echo $buku['isbn']; ?>" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label>Tingkat</label>
                                    <select class="form-control" name="tingkat" required>
                                        <option value="X" <?php echo ($buku['tingkat'] == 'X') ? 'selected' : ''; ?>>Kelas X</option>
                                        <option value="XI" <?php echo ($buku['tingkat'] == 'XI') ? 'selected' : ''; ?>>Kelas XI</option>
                                        <option value="XII" <?php echo ($buku['tingkat'] == 'XII') ? 'selected' : ''; ?>>Kelas XII</option>
                                    </select>
                                </div>
                                <div class="form-group mb-3">
                                    <label>Tahun Terbit</label>
                                    <input type="number" class="form-control" name="tahun_terbit" 
                                           value="<?php echo $buku['tahun_terbit']; ?>" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label>Stok</label>
                                    <input type="number" class="form-control" name="stok" 
                                           value="<?php echo $buku['stok']; ?>" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label>Lokasi Rak</label>
                                    <input type="text" class="form-control" name="lokasi" 
                                           value="<?php echo $buku['lokasi_rak']; ?>" required>
                                </div>
                            </div>
                        </div>
                        <div class="text-center mt-4">
                            <a href="buku.php" class="btn btn-secondary">Kembali</a>
                            <button type="submit" name="update" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
</div>

<?php include 'template/footer.php'; ?>