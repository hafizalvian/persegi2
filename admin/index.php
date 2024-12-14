<?php
session_start();
require_once '../includes/koneksi.php';

// Check if user is logged in
if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
    exit();
}

include 'template/header.php';
?>

<div class="wrapper">
    <!-- Sidebar -->
    <?php include 'template/sidebar.php'; ?>

    <!-- Main Content -->
    <div class="main-content">
        <div class="content">
            <h2 class="page-title mb-4">Dashboard Overview</h2>
            
            <div class="row">
                <!-- Total Buku Card -->
                <div class="col-xl-3 col-md-6">
                    <div class="card-stats">
                        <div class="card border-left-primary shadow">
                            <div class="card-body">
                                <div class="stat-content">
                                    <div class="stat-text">
                                        <h6 class="card-title">Total Buku</h6>
                                        <h3 class="card-value">
                                            <?php
                                            $query = mysqli_query($conn, "SELECT COUNT(*) as total FROM buku");
                                            $data = mysqli_fetch_array($query);
                                            echo number_format($data['total']);
                                            ?>
                                        </h3>
                                    </div>
                                    <div class="stat-icon">
                                        <i class="fas fa-book"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Anggota Card -->
                <div class="col-xl-3 col-md-6">
                    <div class="card-stats">
                        <div class="card border-left-success shadow">
                            <div class="card-body">
                                <div class="stat-content">
                                    <div class="stat-text">
                                        <h6 class="card-title">Total Anggota</h6>
                                        <h3 class="card-value">
                                            <?php
                                            $query = mysqli_query($conn, "SELECT COUNT(*) as total FROM anggota");
                                            $data = mysqli_fetch_array($query);
                                            echo number_format($data['total']);
                                            ?>
                                        </h3>
                                    </div>
                                    <div class="stat-icon">
                                        <i class="fas fa-users"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Peminjaman Aktif Card -->
                <div class="col-xl-3 col-md-6">
                    <div class="card-stats">
                        <div class="card border-left-warning shadow">
                            <div class="card-body">
                                <div class="stat-content">
                                    <div class="stat-text">
                                        <h6 class="card-title">Peminjaman Aktif</h6>
                                        <h3 class="card-value">
                                            <?php
                                            $query = mysqli_query($conn, "SELECT COUNT(*) as total FROM peminjaman WHERE status='dipinjam'");
                                            $data = mysqli_fetch_array($query);
                                            echo number_format($data['total']);
                                            ?>
                                        </h3>
                                    </div>
                                    <div class="stat-icon">
                                        <i class="fas fa-bookmark"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total E-Book Card -->
                <div class="col-xl-3 col-md-6">
                    <div class="card-stats">
                        <div class="card border-left-info shadow">
                            <div class="card-body">
                                <div class="stat-content">
                                    <div class="stat-text">
                                        <h6 class="card-title">Total E-Book</h6>
                                        <h3 class="card-value">
                                            <?php
                                            $query = mysqli_query($conn, "SELECT COUNT(*) as total FROM ebook");
                                            $data = mysqli_fetch_array($query);
                                            echo number_format($data['total']);
                                            ?>
                                        </h3>
                                    </div>
                                    <div class="stat-icon">
                                        <i class="fas fa-file-pdf"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'template/footer.php'; ?>