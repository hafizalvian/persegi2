<?php
// Memulai sesi dan koneksi database
session_start();
require_once '../includes/koneksi.php';

// Cek status login admin
if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
    exit();
}

// Memasukkan template header
include 'template/header.php';
?>

<!-- CSS Kustom untuk Halaman Peminjaman -->
<style>
    .form-card {
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 0 15px rgba(0,0,0,0.1);
    }
    
    .info-card {
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 0 15px rgba(0,0,0,0.1);
    }
    
    .info-item {
        padding: 15px;
        border-bottom: 1px solid #eee;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .btn-action {
        min-width: 120px;
    }
</style>

<!-- Struktur Halaman -->
<div class="wrapper">
    <?php include 'template/sidebar.php'; ?>
    
    <div class="main-content">
        <div class="container">
            <!-- Form Peminjaman -->
            <form id="formPeminjaman" method="POST" class="form-horizontal">
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-card card">
                            <div class="card-header">
                                <h4><i class="fas fa-book-reader mr-2"></i>Tambah Peminjaman Baru</h4>
                            </div>
                            
                            <div class="card-body">
                                <!-- Input ID Anggota -->
                                <div class="form-group">
                                    <label>ID Anggota</label>
                                    <input type="text" class="form-control" name="id_anggota" id="id_anggota" required>
                                    <small id="anggota_info" class="text-info"></small>
                                </div>

                                <!-- Input ID Buku -->
                                <div class="form-group">
                                    <label>ID Buku</label>
                                    <input type="number" class="form-control" name="id_buku" id="id_buku" required>
                                    <small id="buku_info" class="text-info"></small>
                                </div>

                                <!-- Tanggal Pinjam -->
                                <div class="form-group">
                                    <label>Tanggal Pinjam</label>
                                    <input type="date" class="form-control" name="tanggal_pinjam" 
                                           value="<?php echo date('Y-m-d'); ?>" readonly>
                                </div>

                                <!-- Tanggal Kembali -->
                                <div class="form-group">
                                    <label>Tanggal Kembali</label>
                                    <input type="date" class="form-control" name="tanggal_kembali" required>
                                </div>

                                <!-- Tombol Aksi -->
                                <div class="text-center mt-4">
                                    <button type="submit" class="btn btn-primary btn-action">
                                        <i class="fas fa-save mr-2"></i>Simpan
                                    </button>
                                    <a href="peminjaman.php" class="btn btn-secondary btn-action ml-2">
                                        <i class="fas fa-arrow-left mr-2"></i>Kembali
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Panel Informasi -->
                    <div class="col-md-4">
                        <div class="info-card card">
                            <div class="card-header bg-info text-white">
                                <h5><i class="fas fa-info-circle mr-2"></i>Informasi Peminjaman</h5>
                            </div>
                            <div class="card-body">
                                <div class="info-item">
                                    <i class="fas fa-clock text-info"></i>
                                    <span>Maksimal peminjaman 7 hari</span>
                                </div>
                                <div class="info-item">
                                    <i class="fas fa-exclamation-triangle text-warning"></i>
                                    <span>Denda keterlambatan Rp 1.000/hari</span>
                                </div>
                                <div class="info-item">
                                    <i class="fas fa-book text-primary"></i>
                                    <span>Maksimal 2 buku per anggota</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include 'template/footer.php'; ?>

<!-- Script JavaScript -->
<script>
$(document).ready(function() {
    $('#formPeminjaman').submit(function(e) {
        e.preventDefault();
        
        $.ajax({
            url: 'proses_peminjaman.php',
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                if(response.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: response.message,
                        showConfirmButton: false,
                        timer: 1500
                    }).then(function() {
                        window.location.href = 'peminjaman.php';
                    });
                } else {
                    Swal.fire('Error', response.message, 'error');
                }
            },
            error: function(xhr, status, error) {
                Swal.fire('Error', 'Terjadi kesalahan sistem', 'error');
            }
        });
    });

    // Validasi ID Anggota
    $('#id_anggota').on('change', function() {
        let id = $(this).val();
        $.ajax({
            url: 'get_anggota.php',
            type: 'POST',
            data: {id: id},
            success: function(response) {
                let data = JSON.parse(response);
                if(data.nama) {
                    $('#anggota_info').html(`<i class="fas fa-check-circle text-success"></i> ${data.nama}`);
                } else {
                    $('#anggota_info').html('<i class="fas fa-times-circle text-danger"></i> Anggota tidak ditemukan');
                }
            }
        });
    });

    // Validasi ID Buku
    $('#id_buku').on('change', function() {
        let id = $(this).val();
        $.ajax({
            url: 'get_buku.php',
            type: 'POST',
            data: {id: id},
            success: function(response) {
                let data = JSON.parse(response);
                if(data.judul) {
                    if(data.stok > 0) {
                        $('#buku_info').html(`<i class="fas fa-check-circle text-success"></i> ${data.judul}`);
                    } else {
                        $('#buku_info').html(`<i class="fas fa-times-circle text-danger"></i> Stok habis`);
                    }
                } else {
                    $('#buku_info').html('<i class="fas fa-times-circle text-danger"></i> Buku tidak ditemukan');
                }
            }
        });
    });
});
</script>