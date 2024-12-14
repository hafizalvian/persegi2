<div class="sidebar">
    <div class="sidebar-content">
        <!-- User Profile Section -->
        <div class="user-profile">
            <?php
            $currentPhoto = $_SESSION['admin']['foto'] ?? 'profil.JPG';
            $photoPath = "../assets/img/profile/" . $currentPhoto;
            
            // Get admin ID from session
            $admin_id = isset($_SESSION['admin']['id']) ? $_SESSION['admin']['id'] : 0;
            
            // Fetch admin name from database
            $query = "SELECT nama_lengkap FROM admin WHERE id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $admin_id);
            $stmt->execute();
            $result = $stmt->get_result();
            
            $nama_lengkap = "Administrator"; // Default value
            if ($row = $result->fetch_assoc()) {
                $nama_lengkap = $row['nama_lengkap'];
            }
            ?>

            <div class="profile-image">
                <img src="<?php echo $photoPath; ?>" 
                    class="rounded-circle"
                    onerror="this.src='../assets/img/profile/profil.JPG'">
            </div>
            <div class="profile-info">
                <h6 class="admin-name">
                    <span class="online-indicator">● Online</span>
                </h6>
                <span class="admin-label"><?php echo $nama_lengkap; ?></span>
            </div>
        </div>

        <!-- Navigation Menu -->
        <div class="sidebar-menu">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'index.php') ? 'active' : ''; ?>" href="index.php">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'profile.php') ? 'active' : ''; ?>" href="profile.php">
                        <i class="fas fa-user"></i> Profil
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'buku.php') ? 'active' : ''; ?>" href="buku.php">
                        <i class="fas fa-book"></i> Buku
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'anggota.php') ? 'active' : ''; ?>" href="anggota.php">
                        <i class="fas fa-users"></i> Anggota
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'peminjaman.php') ? 'active' : ''; ?>" href="peminjaman.php">
                        <i class="fas fa-clipboard-list"></i> Peminjaman
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>