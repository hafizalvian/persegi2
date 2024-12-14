<?php
require_once '../includes/koneksi.php';
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

if (isset($_POST['delete'])) {
    $id = $_POST['id_buku'];
    $query = "DELETE FROM buku WHERE id_buku = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        $_SESSION['success'] = "Buku berhasil dihapus!";
    } else {
        $_SESSION['error'] = "Gagal menghapus buku!";
    }
    header("Location: buku.php");
    exit();
}

include 'template/header.php';
?>

<style>
:root {
    --primary-color: #4e73df;
    --primary-dark: #3a5cbe;
    --secondary-color: #2c3e50;
    --background-color: #f8f9fc;
    --border-color: #e3e6f0;
    --shadow-color: rgba(149, 157, 165, 0.1);
}

.container-fluid {
    padding: 0;
    overflow-x: hidden;
}

.content {
    padding: 20px;
}

.main-content {
    margin-left: 250px;
    padding: 20px;
    background: var(--background-color);
}

.table-responsive {
    background: white;
    padding: 25px;
    border-radius: 15px;
    box-shadow: 0 8px 24px var(--shadow-color);
    margin: 20px 0;
}

.table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    font-size: 14px;
}

.table thead th {
    background: var(--primary-color);
    color: white;
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.8rem;
    padding: 15px;
    border: none;
}

.table tbody td {
    padding: 12px 15px;
    vertical-align: middle;
    border-bottom: 1px solid var(--border-color);
}

.table tbody tr:hover {
    background-color: var(--background-color);
    transform: translateY(-1px);
    transition: all 0.2s ease;
}

.action-buttons {
    display: flex;
    gap: 8px;
    justify-content: center;
}

.btn-sm {
    padding: 6px 12px;
    border-radius: 6px;
    transition: all 0.2s ease;
    border: none;
}

.btn-info { background: var(--primary-color); }
.btn-success { background: #1cc88a; }
.btn-danger { background: #e74a3b; }

.modal-content {
    border: none;
    border-radius: 12px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}

.modal-header {
    background: var(--primary-color);
    color: white;
    border-radius: 12px 12px 0 0;
    padding: 15px 20px;
}

.form-control {
    border-radius: 6px;
    border: 1px solid var(--border-color);
    padding: 8px 12px;
}

.form-control:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
}

.alert {
    border-radius: 8px;
    padding: 12px 20px;
    margin-bottom: 20px;
}

.page-title {
    color: var(--primary-color);
    font-weight: 600;
    margin: 20px 0;
    font-size: 1.5rem;
}

@media (max-width: 768px) {
    .sidebar { width: 200px; }
    .main-content { margin-left: 200px; }
    .table-responsive { padding: 15px; }
}
</style>

<div class="container-fluid">
    <div class="row">
        <?php include 'template/sidebar.php'; ?>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="content">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="page-title mb-3 mt-3">Manajemen Buku</h2>
                    <a href="tambah_buku.php" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Tambah Buku
                    </a>
                </div>

                <?php if (isset($_SESSION['success'])): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?php 
                        echo $_SESSION['success'];
                        unset($_SESSION['success']);
                        ?>
                        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                    </div>
                <?php endif; ?>

                <?php if (isset($_SESSION['error'])): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?php 
                        echo $_SESSION['error'];
                        unset($_SESSION['error']);
                        ?>
                        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                    </div>
                <?php endif; ?>

                <div class="table-responsive">
                    <?php
                    $kelas = ['X', 'XI', 'XII'];
                    foreach ($kelas as $tingkat):
                        $no = 1;
                    ?>
                    <h3 class="mt-4 mb-3">Buku Kelas <?php echo $tingkat; ?></h3>
                    <table class="table table-striped table-hover mb-5">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Judul</th>
                                <th>Pengarang</th>
                                <th>Penerbit</th>
                                <th>Tahun Terbit</th>
                                <th>ISBN</th>
                                <th>Stok</th>
                                <th>Lokasi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query = "SELECT * FROM buku WHERE tingkat = ? ORDER BY id_buku DESC";
                            $stmt = $conn->prepare($query);
                            $stmt->bind_param("s", $tingkat);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            
                            while ($row = $result->fetch_assoc()):
                            ?>
                            <tr>
                                <td><?php echo $no++; ?></td>
                                <td><?php echo htmlspecialchars($row['judul']); ?></td>
                                <td><?php echo htmlspecialchars($row['pengarang']); ?></td>
                                <td><?php echo htmlspecialchars($row['penerbit']); ?></td>
                                <td><?php echo htmlspecialchars($row['tahun_terbit']); ?></td>
                                <td><?php echo htmlspecialchars($row['isbn']); ?></td>
                                <td><?php echo htmlspecialchars($row['stok']); ?></td>
                                <td><?php echo htmlspecialchars($row['lokasi_rak']); ?></td>
                                <td class="action-buttons">
                                    <a href="edit_buku.php?id=<?php echo $row['id_buku']; ?>" class="btn btn-sm btn-info">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button class="btn btn-sm btn-success print-barcode" 
                                            data-id="<?php echo $row['id_buku']; ?>"
                                            data-isbn="<?php echo $row['isbn']; ?>"
                                            data-stok="<?php echo $row['stok']; ?>">
                                        <i class="fas fa-barcode"></i>
                                    </button>
                                    <form action="" method="POST" class="d-inline">
                                        <input type="hidden" name="id_buku" value="<?php echo $row['id_buku']; ?>">
                                        <button type="submit" name="delete" class="btn btn-sm btn-danger" 
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus buku ini?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                    <?php endforeach; ?>
                </div>
            </main>
        </div>
    </div>

    <!-- Print Modal -->
    <div class="modal fade" id="printModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Print Barcode</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Jumlah Copy</label>
                        <input type="number" class="form-control" id="printQuantity" min="1" value="1">
                        <small class="text-muted">Stok tersedia: <span id="maxStock">0</span></small>
                    </div>
                    <div id="barcodePreview" class="text-center mt-3"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" id="confirmPrint">Print</button>
                </div>
            </div>
        </div>
    </div>

<script>
    $(document).ready(function() {
        $('.print-barcode').click(function() {
            let id = $(this).data('id');
            let isbn = $(this).data('isbn');
            let stok = $(this).data('stok');
            
            $('#maxStock').text(stok);
            $('#printQuantity').attr('max', stok);
            
            $('#barcodePreview').html(`
                <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=${id}" class="img-fluid">
                <p class="mt-2">ID: ${id}<br>ISBN: ${isbn}</p>
            `);
            
            $('#printModal').modal('show');
        });

        $('#confirmPrint').click(function() {
        let quantity = $('#printQuantity').val();
        let content = '<div class="barcode-grid">';
        
        for(let i = 0; i < quantity; i++) {
            content += `
                <div class="barcode-item">
                    ${$('#barcodePreview').html()}
                </div>`;
        }
        content += '</div>';
        
        let printWindow = window.open('', '_blank');
        printWindow.document.write(`
            <html>
            <head>
                <title>Print Barcode</title>
                <style>
                    body { 
                        margin: 0; 
                        padding: 10mm;
                    }
                    .barcode-grid {
                        display: grid;
                        grid-template-columns: repeat(3, 1fr);
                        gap: 10mm;
                    }
                    .barcode-item {
                        text-align: center;
                        padding: 5mm;
                        border: 1px solid #ddd;
                    }
                    .barcode-item img {
                        width: 50mm;
                        height: 50mm;
                    }
                    @media print {
                        @page {
                            size: A4;
                            margin: 10mm;
                        }
                        .barcode-item {
                            break-inside: avoid;
                        }
                    }
                </style>
            </head>
            <body onload="window.print(); window.close();">
                ${content}
            </body>
            </html>
        `);
        printWindow.document.close();
    });
});
</script>

<?php include 'template/footer.php'; ?>