<?php
require_once '../includes/koneksi.php';
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

if (isset($_POST['tambah'])) {
    $judul = $_POST['judul'];
    $pengarang = $_POST['pengarang'];
    $penerbit = $_POST['penerbit'];
    $tahun_terbit = $_POST['tahun_terbit'];
    $isbn = $_POST['isbn'];
    $stok = $_POST['stok'];
    $lokasi = $_POST['lokasi'];
    $tingkat = $_POST['tingkat'];

    $query = "INSERT INTO buku (judul, pengarang, penerbit, tahun_terbit, isbn, stok, lokasi_rak, tingkat) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssissss", $judul, $pengarang, $penerbit, $tahun_terbit, $isbn, $stok, $lokasi, $tingkat);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Buku berhasil ditambahkan!";
        header("Location: buku.php");
        exit();
    } else {
        $_SESSION['error'] = "Gagal menambahkan buku!";
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
                    <h6 class="m-0 font-weight-bold text-primary">Tambah Buku Baru</h6>
                </div>
                <div class="card-body">
                    <form action="" method="POST">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label>Judul Buku</label>
                                    <input type="text" class="form-control" name="judul" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label>Pengarang</label>
                                    <input type="text" class="form-control" name="pengarang" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label>Penerbit</label>
                                    <input type="text" class="form-control" name="penerbit" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label>ISBN</label>
                                    <input type="text" class="form-control" name="isbn" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label>Tingkat</label>
                                    <select class="form-control" name="tingkat" required>
                                        <option value="X">Kelas X</option>
                                        <option value="XI">Kelas XI</option>
                                        <option value="XII">Kelas XII</option>
                                    </select>
                                </div>
                                <div class="form-group mb-3">
                                    <label>Tahun Terbit</label>
                                    <input type="number" class="form-control" name="tahun_terbit" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label>Stok</label>
                                    <input type="number" class="form-control" name="stok" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label>Lokasi Rak</label>
                                    <input type="text" class="form-control" name="lokasi" required>
                                </div>
                            </div>
                        </div>
                        <div class="text-center mt-4">
                            <a href="buku.php" class="btn btn-secondary">Kembali</a>
                            <button type="submit" name="tambah" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
</div>

<?php include 'template/footer.php'; ?>