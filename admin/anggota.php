<?php
session_start();
require_once '../includes/koneksi.php';

// Check authentication
if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
    exit();
}

// Constants
define('ITEMS_PER_PAGE', 5);

// Helper Functions
function getClassLevel($kelas) {
    if (strpos($kelas, 'X ') === 0) return 'X';
    if (strpos($kelas, 'XI ') === 0) return 'XI';
    if (strpos($kelas, 'XII ') === 0) return 'XII';
    return '';
}

// Handle Delete
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM anggota WHERE id_anggota = ?");
    $stmt->bind_param("s", $id);
    if ($stmt->execute()) {
        echo "<script>alert('Data berhasil dihapus!'); window.location='anggota.php';</script>";
    }
    $stmt->close();
}

include 'template/header.php';
include 'template/sidebar.php';
?>
<style>
.wrapper {
    padding: 15px;
    background: #f8f9fc;
}

.page-title {
    color: #4e73df;
    font-size: 1.5rem;
    margin-bottom: 20px;
}

.card {
    border: none;
    border-radius: 10px;
    box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
    margin-bottom: 20px;
}

.card-header {
    background: linear-gradient(to right, #4e73df, #36b9cc);
    padding: 15px 20px;
    border-radius: 10px 10px 0 0;
}

.card-header h6 {
    color: white;
    font-weight: 600;
    margin: 0;
    font-size: 1.1rem;
}

.table-responsive {
    padding: 15px;
    border-radius: 0 0 10px 10px;
}

.table {
    width: 100%;
    margin-bottom: 0;
}

.table thead th {
    background: #4e73df;
    color: white;
    font-weight: 500;
    border: none;
    padding: 12px;
    font-size: 0.9rem;
    text-align: left;
    white-space: nowrap;
}

.table tbody tr:nth-child(even) {
    background-color: #f8f9fc;
}

.table tbody tr:hover {
    background-color: #eaecf4;
}

.table td {
    padding: 12px;
    vertical-align: middle;
    border-top: 1px solid #e3e6f0;
    font-size: 0.9rem;
}

.action-buttons {
    display: flex;
    gap: 5px;
    justify-content: center;
}

.btn-action {
    width: 32px;
    height: 32px;
    padding: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 6px;
    transition: all 0.2s;
}

.btn-edit { background: #4e73df; }
.btn-print { background: #1cc88a; }
.btn-delete { background: #e74a3b; }

.btn-action:hover {
    transform: translateY(-2px);
    box-shadow: 0 2px 5px rgba(0,0,0,0.2);
}

.pagination-container {
    display: flex;
    justify-content: center;
    padding-top: 20px;
    border-top: 1px solid #e3e6f0;
}

.pagination {
    display: flex;
    gap: 5px;
}

.page-link {
    padding: 8px 16px;
    border-radius: 6px;
    color: #4e73df;
    font-weight: 500;
    border: 1px solid #e3e6f0;
}

.page-item.active .page-link {
    background: #4e73df;
    border-color: #4e73df;
}

.page-link:hover {
    background: #4e73df;
    color: white;
    border-color: #4e73df;
}

@media (max-width: 768px) {
    .table-responsive {
        padding: 10px;
    }
    
    .action-buttons {
        flex-direction: row;
    }
    
    .btn-action {
        width: 28px;
        height: 28px;
    }
}
</style>

<div class="wrapper">
    <div class="main-content">
        <div class="content">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="page-title">Data Anggota</h2>
                <a href="tambah_anggota.php" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Tambah Anggota
                </a>
            </div>
        </div>

        <?php
        $kelas_array = ['X', 'XI', 'XII'];
        
        foreach ($kelas_array as $tingkat) {
            // Pagination setup
            $page = isset($_GET["page_$tingkat"]) ? (int)$_GET["page_$tingkat"] : 1;
            $offset = ($page - 1) * ITEMS_PER_PAGE;
            
            // Count total records for this grade
            $count_stmt = $conn->prepare("SELECT COUNT(*) as total FROM anggota WHERE kelas LIKE ?");
            $search_kelas = $tingkat . ' %';
            $count_stmt->bind_param("s", $search_kelas);
            $count_stmt->execute();
            $total_records = $count_stmt->get_result()->fetch_assoc()['total'];
            $total_pages = ceil($total_records / ITEMS_PER_PAGE);
            
            // Get paginated data
            $limit = ITEMS_PER_PAGE;
            $stmt = $conn->prepare("SELECT * FROM anggota WHERE kelas LIKE ? ORDER BY kelas ASC, nama ASC LIMIT ? OFFSET ?");
            $stmt->bind_param("sii", $search_kelas, $limit, $offset);
            $stmt->execute();
            $result = $stmt->get_result();
            ?>
            
            <div class="card shadow">
                <div class="card-header">
                    <h6>Kelas <?php echo $tingkat; ?></h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>ID Anggota</th>
                                    <th>NIS</th>
                                    <th>Nama</th>
                                    <th>Kelas</th>
                                    <th>No. HP</th>
                                    <th>Alamat</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($result->num_rows > 0) {
                                    $no = $offset + 1;
                                    while ($data = $result->fetch_assoc()) {
                                        ?>
                                        <tr>
                                            <td><?php echo $no++; ?></td>
                                            <td><?php echo htmlspecialchars($data['id_anggota']); ?></td>
                                            <td><?php echo htmlspecialchars($data['nis']); ?></td>
                                            <td><?php echo htmlspecialchars($data['nama']); ?></td>
                                            <td><?php echo htmlspecialchars($data['kelas']); ?></td>
                                            <td><?php echo htmlspecialchars($data['no_hp']); ?></td>
                                            <td><?php echo htmlspecialchars($data['alamat']); ?></td>
                                            <td class="action-buttons">
                                                <a href="edit_anggota.php?id=<?php echo $data['id_anggota']; ?>" class="btn btn-action btn-edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="cetak_kartu.php?id=<?php echo $data['id_anggota']; ?>" class="btn btn-action btn-print">
                                                    <i class="fas fa-print"></i>
                                                </a>
                                                <a href="?delete=<?php echo $data['id_anggota']; ?>" class="btn btn-action btn-delete" 
                                                   onclick="return confirm('Yakin ingin menghapus?')">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                } else {
                                    echo "<tr><td colspan='8' class='text-center'>Tidak ada data untuk kelas $tingkat</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>

                        <!-- Pagination -->
                        <?php if ($total_pages > 1): ?>
                        <div class="pagination-container mt-3">
                            <ul class="pagination justify-content-center">
                                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                                    <a class="page-link" href="?page_<?php echo $tingkat; ?>=<?php echo $i; ?>">
                                        <?php echo $i; ?>
                                    </a>
                                </li>
                                <?php endfor; ?>
                            </ul>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php
            $stmt->close();
            $count_stmt->close();
        }
        ?>
    </div>
</div>

<?php include 'template/footer.php'; ?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Confirm delete
    const deleteButtons = document.querySelectorAll('.btn-delete');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            if (!confirm('Yakin ingin menghapus data ini?')) {
                e.preventDefault();
            }
        });
    });

    // Table row hover effect
    const tableRows = document.querySelectorAll('tbody tr');
    tableRows.forEach(row => {
        row.addEventListener('mouseover', function() {
            this.style.cursor = 'pointer';
        });
    });

    // Smooth scroll to top after pagination
    const paginationLinks = document.querySelectorAll('.page-link');
    paginationLinks.forEach(link => {
        link.addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    });
});
</script>