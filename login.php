<?php
session_start();
require_once 'includes/koneksi.php';
require_once 'includes/function.php';

// Redirect if already logged in
if (isset($_SESSION['admin'])) {
    header("Location: admin/index.php");
    exit();
}

// Handle login form submission
if (isset($_POST['login'])) {
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $password = $_POST['password'];
    
    // Query to check credentials
    $sql = "SELECT * FROM admin WHERE username = ? AND password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $admin = $result->fetch_assoc();
        $_SESSION['admin'] = $admin;
        header("Location: admin/index.php");
        exit();
    } else {
        $error = "Username atau password tidak sesuai";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login Admin - Sistem Perpustakaan</title>
    
    <!-- CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="assets/css/login.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container">
        <div class="row justify-content-center align-items-center min-vh-100">
            <div class="col-md-6 col-lg-5">
                <div class="card shadow-lg border-0">
                    <div class="card-header bg-primary text-white text-center py-3">
                        <h4 class="mb-0">
                            <i class="fas fa-book-reader mr-2"></i>
                            Login Admin
                        </h4>
                    </div>
                    <div class="card-body p-4">
                        <?php if(isset($error)): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle mr-2"></i>
                            <?= htmlspecialchars($error) ?>
                            <button type="button" class="close" data-dismiss="alert">
                                <span>&times;</span>
                            </button>
                        </div>
                        <?php endif; ?>
                        
                        <form method="post" action="" autocomplete="off">
                            <div class="form-group">
                                <label for="username">Username</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fas fa-user"></i>
                                        </span>
                                    </div>
                                    <input type="text" 
                                           name="username" 
                                           id="username" 
                                           class="form-control"
                                           value="<?= isset($_POST['username']) ? htmlspecialchars($_POST['username']) : '' ?>"
                                           required 
                                           autofocus>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="password">Password</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fas fa-lock"></i>
                                        </span>
                                    </div>
                                    <input type="password" 
                                           name="password" 
                                           id="password" 
                                           class="form-control" 
                                           required>
                                    <div class="input-group-append">
                                        <span class="input-group-text toggle-password" style="cursor: pointer;">
                                            <i class="fas fa-eye"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            
                            <button type="submit" name="login" class="btn btn-primary btn-block btn-lg">
                                <i class="fas fa-sign-in-alt mr-2"></i>
                                Masuk
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    
    <script>
        // Toggle password visibility
        $('.toggle-password').click(function() {
            const input = $(this).closest('.input-group').find('input');
            const icon = $(this).find('i');
            
            if (input.attr('type') === 'password') {
                input.attr('type', 'text');
                icon.removeClass('fa-eye').addClass('fa-eye-slash');
            } else {
                input.attr('type', 'password');
                icon.removeClass('fa-eye-slash').addClass('fa-eye');
            }
        });
    </script>
</body>
</html>

