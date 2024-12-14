<?php
session_start();
require_once '../includes/koneksi.php';

// Authentication check
if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
    exit();
}

// Generate auto ID with proper formatting
$query_id = mysqli_query($conn, "SELECT MAX(CAST(SUBSTRING(id_anggota, 2) AS SIGNED)) as max_id FROM anggota");
$data_id = mysqli_fetch_array($query_id);
$last_number = $data_id['max_id'];
$next_number = $last_number + 1;
$new_id = 'A' . sprintf('%03d', $next_number);

// Form submission handling
if (isset($_POST['submit'])) {
    $id_anggota = $new_id;
    $nama = htmlspecialchars($_POST['nama']);
    $nis = htmlspecialchars($_POST['nis']);
    $kelas = $_POST['kelas'] . ' ' . $_POST['jurusan'] . ' ' . $_POST['nomor_kelas'];
    $no_hp = htmlspecialchars($_POST['no_hp']);
    $alamat = htmlspecialchars($_POST['alamat']);

    $stmt = $conn->prepare("INSERT INTO anggota (id_anggota, nama, nis, kelas, no_hp, alamat) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $id_anggota, $nama, $nis, $kelas, $no_hp, $alamat);

    if ($stmt->execute()) {
        echo "<script>
                alert('Data berhasil ditambahkan!');
                window.location='anggota.php';
              </script>";
    } else {
        echo "<script>alert('Gagal menambahkan data!');</script>";
    }
    $stmt->close();
}

include 'template/header.php';
include 'template/sidebar.php';
?>

<link rel="stylesheet" href="../assets/css/tambah_anggota.css">

<div class="content-wrapper">
    <div class="page-header">
        <h1 class="page-title">Tambah Anggota Baru</h1>
    </div>

    <div class="card">
        <div class="card-header">
            <h6><i class="fas fa-user-plus"></i>Form Tambah Anggota</h6>
        </div>
        <div class="card-body">
            <form method="POST" action="" class="needs-validation" novalidate>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>ID Anggota</label>
                            <input type="text" class="form-control" value="<?php echo $new_id; ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label>Nama Lengkap</label>
                            <input type="text" class="form-control" name="nama" required>
                            <div class="invalid-feedback">Nama lengkap harus diisi</div>
                        </div>
                        <div class="form-group">
                            <label>NIS</label>
                            <input type="text" class="form-control" name="nis" required>
                            <div class="invalid-feedback">NIS harus diisi</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Kelas</label>
                            <select class="form-control" name="kelas" required>
                                <option value="">Pilih Tingkat</option>
                                <option value="X">X</option>
                                <option value="XI">XI</option>
                                <option value="XII">XII</option>
                            </select>
                            <div class="invalid-feedback">Pilih tingkat kelas</div>
                        </div>
                        <div class="form-group">
                            <label>Jurusan</label>
                            <select class="form-control" name="jurusan" required>
                                <option value="">Pilih Jurusan</option>
                                <option value="IPA">IPA</option>
                                <option value="IPS">IPS</option>
                            </select>
                            <div class="invalid-feedback">Pilih jurusan</div>
                        </div>
                        <div class="form-group">
                            <label>Nomor Kelas</label>
                            <select class="form-control" name="nomor_kelas" required>
                                <option value="">Pilih Nomor</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                            </select>
                            <div class="invalid-feedback">Pilih nomor kelas</div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>No. HP</label>
                            <input type="tel" class="form-control" name="no_hp" pattern="[0-9]{10,13}" required>
                            <div class="invalid-feedback">Masukkan nomor HP yang valid (10-13 digit)</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Alamat</label>
                            <textarea class="form-control" name="alamat" rows="3" required></textarea>
                            <div class="invalid-feedback">Alamat harus diisi</div>
                        </div>
                    </div>
                </div>
                <div class="actions">
                    <button type="submit" name="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i>Simpan
                    </button>
                    <a href="anggota.php" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i>Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include 'template/footer.php'; ?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('.needs-validation');
    const saveButton = document.getElementById('saveButton');

    form.addEventListener('submit', function(event) {
        if (!form.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
        }
        
        form.classList.add('was-validated');
        
        if (form.checkValidity()) {
            saveButton.disabled = true;
            saveButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan...';
        }
    });

    // Reset button state when form is reset
    form.addEventListener('reset', function() {
        saveButton.disabled = false;
        saveButton.innerHTML = '<i class="fas fa-save"></i> Simpan';
        form.classList.remove('was-validated');
    });
});
</script>