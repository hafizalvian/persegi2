<?php
// Inisialisasi sesi dan koneksi database
session_start();
require_once '../includes/koneksi.php';

// Cek autentikasi admin
if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
    exit();
}

// Konfigurasi pagination
$limit = 5; // Jumlah data per halaman
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$start = ($page - 1) * $limit;

// Hitung total data dan halaman
$total_records_query = "SELECT COUNT(*) as total FROM peminjaman";
$total_result = mysqli_query($conn, $total_records_query);
$total_records = mysqli_fetch_assoc($total_result)['total'];
$total_pages = ceil($total_records / $limit);

include 'template/header.php';
?>

<!-- CSS Styling -->
<style>
/* Variabel warna */
:root {
    --primary-color: #4e73df;
    --border-color: #e3e6f0;
    --hover-color: #f8f9fc;
    --success-color: #28a745;
    --warning-color: #ffa000;
}

/* Layout utama */
.wrapper {
    display: flex;
    min-height: 100vh;
}

.main-content {
    flex: 1;
    padding: 25px;
}

/* Styling tabel */
.table-container {
    background: white;
    border-radius: 12px;
    box-shadow: 0 3px 20px rgba(0, 0, 0, 0.08);
    padding: 25px;
    margin: 20px 0;
}

.table {
    width: 100%;
    margin-bottom: 0;
    border-collapse: separate;
    border-spacing: 0;
    font-size: 14px;
}

/* Header tabel */
.table thead th {
    background: var(--primary-color);
    color: white;
    font-weight: 600;
    padding: 15px 20px;
    border: none;
    text-align: left;
    font-size: 0.9rem;
    white-space: nowrap;
}

/* Styling status peminjaman */
.status-pill {
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 0.85rem;
    font-weight: 500;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}

.status-borrowed {
    background-color: #fff3e0;
    color: var(--warning-color);
}

.status-returned {
    background-color: #e8f5e9;
    color: var(--success-color);
}

/* Tombol aksi */
.btn-action {
    width: 32px;
    height: 32px;
    padding: 0;
    border-radius: 6px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    margin: 0 3px;
    transition: transform 0.2s ease;
}

/* Header halaman */
.page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 25px;
    padding: 0 10px;
}
</style>

<!-- Konten Utama -->
<div class="wrapper">
    <?php include 'template/sidebar.php'; ?>
    
    <div class="main-content">
        <!-- Header dan Tombol Aksi -->
        <div class="page-header">
            <h2>Data Peminjaman Buku</h2>
            <div class="action-buttons">
                <button onclick="hapusSemuaData()" class="btn btn-danger me-2">
                    <i class="fas fa-trash-alt me-2"></i>Hapus Semua
                </button>
                <button onclick="exportToExcel()" class="btn btn-export">
                    <i class="fas fa-file-excel me-2"></i>Export Excel
                </button>
                <a href="tambah_peminjaman.php" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Tambah Peminjaman
                </a>
            </div>
        </div>

        <!-- Tabel Data Peminjaman -->
        <div class="table-container">
            <table id="dataTable" class="table table-hover">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th width="20%">Nama Peminjam</th>
                        <th width="10%">Kelas</th>
                        <th width="25%">Judul Buku</th>
                        <th width="12%">Tanggal Pinjam</th>
                        <th width="12%">Tanggal Kembali</th>
                        <th width="8%">Status</th>
                        <th width="8%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Query untuk mengambil data peminjaman
                    $query = "SELECT p.*, a.nama as nama_anggota, 
                             a.kelas as kelas_anggota, b.judul as judul_buku
                             FROM peminjaman p
                             JOIN anggota a ON p.id_anggota = a.id_anggota
                             JOIN buku b ON p.id_buku = b.id_buku
                             ORDER BY p.tanggal_pinjam DESC
                             LIMIT $start, $limit";
                    
                    $result = mysqli_query($conn, $query);
                    $no = $start + 1;
                    
                    while ($data = mysqli_fetch_array($result)) {
                        echo "<tr>";
                        echo "<td class='text-center'>" . $no++ . "</td>";
                        echo "<td>" . htmlspecialchars($data['nama_anggota']) . "</td>";
                        echo "<td class='text-center'>" . htmlspecialchars($data['kelas_anggota']) . "</td>";
                        echo "<td>" . htmlspecialchars($data['judul_buku']) . "</td>";
                        echo "<td class='text-center'>" . date('d/m/Y', strtotime($data['tanggal_pinjam'])) . "</td>";
                        echo "<td class='text-center'>" . date('d/m/Y', strtotime($data['tanggal_kembali'])) . "</td>";
                        echo "<td class='text-center'>";
                        echo "<div class='status-pill " . ($data['status'] == 'dipinjam' ? 'status-borrowed' : 'status-returned') . "'>";
                        echo "<i class='fas fa-" . ($data['status'] == 'dipinjam' ? 'clock' : 'check-circle') . "'></i>";
                        echo "<span>" . ucfirst($data['status']) . "</span>";
                        echo "</div>";
                        echo "</td>";
                        echo "<td class='text-center'>";
                        if ($data['status'] == 'dipinjam') {
                            echo "<button onclick='kembalikanBuku(" . $data['id'] . ")' class='btn btn-success btn-action' title='Kembalikan'>";
                            echo "<i class='fas fa-check'></i>";
                            echo "</button>";
                        }
                        echo "<button onclick='hapusPeminjaman(" . $data['id'] . ")' class='btn btn-danger btn-action' title='Hapus'>";
                        echo "<i class='fas fa-trash'></i>";
                        echo "</button>";
                        echo "</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="pagination-container mt-4">
                <nav aria-label="Page navigation">
                    <ul class="pagination justify-content-end">
                        <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                            <a class="page-link" href="?page=<?= $page-1 ?>">Previous</a>
                        </li>
                        <?php for($i = 1; $i <= $total_pages; $i++): ?>
                            <li class="page-item <?= ($page == $i) ? 'active' : '' ?>">
                                <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                            </li>
                        <?php endfor; ?>
                        <li class="page-item <?= ($page >= $total_pages) ? 'disabled' : '' ?>">
                            <a class="page-link" href="?page=<?= $page+1 ?>">Next</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>

<?php include 'template/footer.php'; ?>

<!-- JavaScript untuk fungsi-fungsi interaktif -->
<script>
// Fungsi untuk mengembalikan buku
function kembalikanBuku(id) {
    const currentPage = new URLSearchParams(window.location.search).get('page') || 1;
    
    Swal.fire({
        title: 'Konfirmasi Pengembalian',
        text: 'Apakah Anda yakin ingin mengembalikan buku ini?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#28a745',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Kembalikan',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = `proses_peminjaman.php?action=kembali&id=${id}&page=${currentPage}`;
        }
    });
}

// Fungsi untuk menghapus data peminjaman
function hapusPeminjaman(id) {
    const currentPage = new URLSearchParams(window.location.search).get('page') || 1;
    
    Swal.fire({
        title: 'Konfirmasi Hapus',
        text: 'Apakah Anda yakin ingin menghapus data ini?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Hapus',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = `proses_peminjaman.php?action=hapus&id=${id}&page=${currentPage}`;
        }
    });
}

// Fungsi untuk export data ke Excel
function exportToExcel() {
    let date = new Date().toISOString().slice(0,10);
    let filename = `Data_Peminjaman_${date}.xls`;
    
    let table = document.querySelector('#dataTable').cloneNode(true);
    let rows = table.rows;
    
    // Hapus kolom aksi
    for(let i = 0; i < rows.length; i++) {
        rows[i].deleteCell(-1);
    }

    let html = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel">';
    html += '<head><meta charset="UTF-8"></head><body>';
    html += '<table border="1">' + table.innerHTML + '</table>';
    html += '</body></html>';

    let a = document.createElement('a');
    a.href = 'data:application/vnd.ms-excel,' + encodeURIComponent(html);
    a.download = filename;
    a.click();
}
</script>