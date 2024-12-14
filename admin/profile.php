<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
    exit();
}

$currentPhoto = $_SESSION['admin']['foto'] ?? 'profil.JPG';

include '../includes/koneksi.php';
include 'template/header.php';
?>

<style>
     .wrapper {
        display: flex;
        background: #f8f9fc;
        min-height: 100vh;
    }

    .main-content {
        flex: 1;
        padding: 10px;
        background: linear-gradient(to bottom, #f8f9fc, #ffffff);
    }

    .profile-content {
        background: #fff;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(78, 115, 223, 0.08);
        padding: 20px;
        margin-bottom: 100px; /* Added space for better scroll visibility */
    }


    .profile-content h2 {
        color: #2c3e50;
        font-size: 24px;
        font-weight: 700;
        margin-bottom: 30px;
        border-bottom: 2px solid #4e73df;
        padding-bottom: 10px;
    }

    .current-profile-image {
        text-align: center;
        margin: 20px 0 40px;
    }

    .current-profile-image img {
        width: 180px;
        height: 180px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid #fff;
        box-shadow: 0 0 25px rgba(78, 115, 223, 0.2);
        transition: transform 0.3s ease;
    }

    .current-profile-image img:hover {
        transform: scale(1.05);
    }

    .form-group {
        margin-bottom: 25px;
    }

    .form-group label {
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 8px;
        display: block;
        font-size: 14px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .form-control {
        border: 2px solid #e3e6f0;
        border-radius: 8px;
        padding: 12px 15px;
        font-size: 15px;
        transition: all 0.3s ease;
        background: #f8f9fc;
    }

    .form-control:focus {
        border-color: #4e73df;
        box-shadow: 0 0 0 3px rgba(78, 115, 223, 0.15);
        background: #fff;
    }

    .file-input-wrapper {
        display: flex;
        align-items: center;
        gap: 15px;
        margin: 15px 0;
    }

    .custom-file-upload {
        background: #4e73df;
        color: white;
        padding: 12px 25px;
        border-radius: 8px;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        transition: all 0.3s ease;
        font-weight: 500;
    }

    .custom-file-upload:hover {
        background: #3a5cbe;
    }

    .selected-file-name {
        color: #4e73df;
        font-size: 14px;
        font-weight: 500;
    }

    .btn-primary {
        background: #4e73df;
        border: none;
        padding: 12px 30px;
        color: white;
        border-radius: 8px;
        font-weight: 600;
        letter-spacing: 0.5px;
        transition: all 0.3s ease;
        margin-top: 20px; /* Added top spacing */
    }

    .btn-primary:hover {
        background: #3a5cbe;
    }

    .alert {
        padding: 15px 20px;
        border-radius: 10px;
        margin: 20px 0;
        border: none;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .alert-success {
        background: #d4edda;
        color: #155724;
    }

    .alert-danger {
        background: #f8d7da;
        color: #721c24;
    }

    .text-muted {
        color: #6e7687;
        font-size: 13px;
        margin-top: 5px;
    }

    @media (max-width: 768px) {
        .main-content {
            padding: 10px;
        }

        .profile-content {
            padding: 15px;
        }

        .current-profile-image img {
            width: 150px;
            height: 150px;
        }
    }
</style>

<div class="wrapper">
    <div class="sidebar">
        <?php include 'template/sidebar.php'; ?>
    </div>
    
    <div class="main-content">
        <div class="profile-content">
            <h2>Update Profile</h2>
            
            <div class="current-profile-image">
                <?php
                $currentPhoto = $_SESSION['admin']['foto'] ?? 'profil.JPG';
                $photoPath = "../assets/img/profile/" . $currentPhoto;
                ?>
                <img src="<?php echo $photoPath; ?>" 
                    alt="Profile Photo" 
                    onerror="this.src='../assets/img/profile/profil.JPG'">
            </div>

            <?php if(isset($_SESSION['message'])): ?>
                <div class="alert alert-<?= $_SESSION['message_type'] ?>">
                    <?= $_SESSION['message'] ?>
                </div>
                <?php 
                unset($_SESSION['message']);
                unset($_SESSION['message_type']);
                ?>
            <?php endif; ?>

            <div class="card mt-4">
                <div class="card-body">
                    <form action="update_profile.php" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label>Foto Profile</label>
                            <div class="file-input-wrapper">
                                <label class="custom-file-upload">
                                    <input type="file" name="foto" accept="image/*" id="profilePhotoInput">
                                    <i class="fas fa-upload"></i> Choose File
                                </label>
                                <span class="selected-file-name">No file chosen</span>
                            </div>
                            <small class="text-muted">Format: JPG, PNG, GIF (Max 2MB)</small>
                        </div>
                        <div class="form-group">
                            <label>Nama Lengkap</label>
                            <input type="text" class="form-control" name="nama_lengkap" value="<?php echo $_SESSION['admin']['nama_lengkap']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" class="form-control" name="username" value="<?php echo $_SESSION['admin']['username']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Password Baru</label>
                            <input type="password" class="form-control" name="password" placeholder="Kosongkan jika tidak ingin mengubah password">
                        </div>
                        <button type="submit" class="btn btn-primary">Update Profile</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('profilePhotoInput').addEventListener('change', function() {
    const fileName = this.files[0]?.name || 'No file chosen';
    this.closest('.file-input-wrapper').querySelector('.selected-file-name').textContent = fileName;
});
</script>

<?php include 'template/footer.php'; ?>