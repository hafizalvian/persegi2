<?php
require_once 'includes/koneksi.php';

// Get books grouped by tingkat with limit
$query = mysqli_query($conn, "SELECT * FROM buku ORDER BY judul ASC LIMIT 8");

// Get distinct tingkat values
$tingkat_list = mysqli_query($conn, "SELECT DISTINCT tingkat FROM buku ORDER BY tingkat");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perpustakaan Digital</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #ffde59;
            --secondary-color: #ffd700;
            --dark-color: #333;
            --light-color: #fff;
        }

        .hero-section {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            padding: 80px 0;
            color: var(--dark-color);
        }

        .book-card {
            transition: all 0.3s ease;
            border-radius: 15px;
            border: none;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            height: 100%;
            background: white;
        }

        .book-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }

        .tingkat-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            background: var(--primary-color);
            color: var(--dark-color);
            padding: 5px 15px;
            border-radius: 20px;
            font-weight: bold;
        }

        .tingkat-card {
            background: white;
            padding: 20px;
            border-radius: 15px;
            text-align: center;
            transition: all 0.3s ease;
            cursor: pointer;
            margin-bottom: 20px;
        }

        .tingkat-card:hover {
            background: var(--primary-color);
            transform: translateY(-5px);
        }

        .view-more-btn {
            background: var(--primary-color);
            color: var(--dark-color);
            border: none;
            padding: 12px 30px;
            border-radius: 25px;
            font-weight: bold;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .view-more-btn:hover {
            background: var(--secondary-color);
            transform: scale(1.05);
        }
    </style>
</head>
<body>
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="display-4 fw-bold mb-4">📚 Perpustakaan Digital</h1>
                    <p class="lead mb-4">Temukan buku sesuai tingkat pendidikanmu!</p>
                    <div class="search-box">
                        <input type="text" class="form-control form-control-lg" placeholder="Cari judul buku...">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Tingkat Section -->
    <section class="py-5">
        <div class="container">
            <h3 class="text-center mb-4">Pilih Tingkat</h3>
            <div class="row justify-content-center">
                <?php while($tingkat = mysqli_fetch_array($tingkat_list)): ?>
                <div class="col-md-2">
                    <div class="tingkat-card">
                        <h4 class="mb-0">Kelas <?= $tingkat['tingkat'] ?></h4>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>

            <h3 class="text-center mb-4 mt-5">Buku Terbaru</h3>
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

            <div class="text-center mt-4">
                <a href="semua-buku.php" class="view-more-btn">
                    Lihat Semua Buku <i class="fas fa-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

