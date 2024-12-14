<?php
require_once 'includes/koneksi.php';

$tingkat = isset($_GET['tingkat']) ? $_GET['tingkat'] : '';
$where = $tingkat ? "WHERE tingkat = '$tingkat'" : '';

$query = mysqli_query($conn, "SELECT * FROM buku $where ORDER BY judul ASC");
$tingkat_list = mysqli_query($conn, "SELECT DISTINCT tingkat FROM buku ORDER BY tingkat");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Semua Buku - Perpustakaan Digital</title>
    <!-- [Same CSS as index.php] -->
</head>
<body>
    <section class="py-5">
        <div class="container">
            <h2 class="text-center mb-5">Katalog Buku</h2>
            
            <!-- Tingkat Filter -->
            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="d-flex justify-content-center gap-3">
                        <a href="semua-buku.php" class="btn <?= !$tingkat ? 'btn-warning' : 'btn-outline-warning' ?>">
                            Semua
                        </a>
                        <?php while($t = mysqli_fetch_array($tingkat_list)): ?>
                        <a href="?tingkat=<?= urlencode($t['tingkat']) ?>" 
                           class="btn <?= $tingkat == $t['tingkat'] ? 'btn-warning' : 'btn-outline-warning' ?>">
                            Kelas <?= $t['tingkat'] ?>
                        </a>
                        <?php endwhile; ?>
                    </div>
                </div>
            </div>

            <!-- Books Grid -->
            <div class="row g-4">
                <?php while($buku = mysqli_fetch_array($query)): ?>
                <div class="col-md-3 mb-4">
                    <div class="book-card">
                        <span class="tingkat-badge">Kelas <?= $buku['tingkat'] ?></span>
                        <div class="card-body">
                            <h5 class="card-title"><?= $buku['judul'] ?></h5>
                            <p class="card-text">
                                <small class="text-muted">
                                    <i class="fas fa-user me-2"></i><?= $buku['pengarang'] ?><br>
                                    <i class="fas fa-building me-2"></i><?= $buku['penerbit'] ?><br>
                                    <i class="fas fa-calendar me-2"></i><?= $buku['tahun_terbit'] ?><br>
                                    <i class="fas fa-bookmark me-2"></i>ISBN: <?= $buku['isbn'] ?>
                                </small>
                            </p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="badge bg-primary">Stok: <?= $buku['stok'] ?></span>
                                <span class="badge bg-secondary">Rak: <?= $buku['lokasi_rak'] ?></span>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>