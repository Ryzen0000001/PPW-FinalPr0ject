<?php 
include 'config.php';

// Check if user is logged in
if (!isLoggedIn()) {
    header('Location: login.php');
    exit;
}

$user = getUserInfo();
$error = '';
$success = '';

if ($_POST) {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $no_telepon = trim($_POST['no_telepon']);
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    
    // Validation
    if (empty($username) || empty($email)) {
        $error = 'Username dan email wajib diisi';
    } else {
        try {
            // Check if email is taken by another user
            $stmt = $pdo->prepare("SELECT id_user FROM Users WHERE email = ? AND id_user != ?");
            $stmt->execute([$email, $_SESSION['user_id']]);
            if ($stmt->fetch()) {
                $error = 'Email sudah digunakan oleh pengguna lain';
            } else {
                // Check if username is taken by another user
                $stmt = $pdo->prepare("SELECT id_user FROM Users WHERE username = ? AND id_user != ?");
                $stmt->execute([$username, $_SESSION['user_id']]);
                if ($stmt->fetch()) {
                    $error = 'Username sudah digunakan oleh pengguna lain';
                } else {
                    // Update basic info
                    $stmt = $pdo->prepare("UPDATE Users SET username = ?, email = ?, no_telepon = ? WHERE id_user = ?");
                    $stmt->execute([$username, $email, $no_telepon, $_SESSION['user_id']]);
                    
                    // Update password if provided
                    if (!empty($new_password)) {
                        if (empty($current_password)) {
                            $error = 'Password saat ini wajib diisi untuk mengubah password';
                        } elseif (!password_verify($current_password, $user['password_hash'])) {
                            $error = 'Password saat ini salah';
                        } elseif ($new_password !== $confirm_password) {
                            $error = 'Password baru dan konfirmasi tidak cocok';
                        } elseif (strlen($new_password) < 6) {
                            $error = 'Password baru minimal 6 karakter';
                        } else {
                            $new_password_hash = password_hash($new_password, PASSWORD_DEFAULT);
                            $stmt = $pdo->prepare("UPDATE Users SET password_hash = ? WHERE id_user = ?");
                            $stmt->execute([$new_password_hash, $_SESSION['user_id']]);
                        }
                    }
                    
                    if (empty($error)) {
                        $success = 'Profile berhasil diperbarui';
                        $_SESSION['username'] = $username;
                        // Refresh user data
                        $user = getUserInfo();
                    }
                }
            }
        } catch (PDOException $e) {
            $error = 'Terjadi kesalahan sistem';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile - Gu-Book KAI</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="nav-container">
            <a href="index.php" class="logo">
                <div class="logo-icon">🚂</div>
                Gu-Book KAI
            </a>
            
            <nav>
                <ul class="nav-menu">
                    <li><a href="index.php">Beranda</a></li>
                    <li><a href="main.php">Jadwal Kereta</a></li>
                </ul>
            </nav>
            
            <div class="nav-buttons">
                <span style="color: var(--dark-gray);">Halo, <?php echo htmlspecialchars($user['username']); ?></span>
                <a href="logout.php" class="btn btn-primary">Logout</a>
            </div>
        </div>
    </header>

    <!-- Edit Profile Form -->
    <div class="form-container" style="max-width: 600px; margin-top: 50px;">
        <h2>Edit Profile</h2>
        
        <?php if ($error): ?>
            <div class="error-message" style="text-align: center; margin-bottom: 20px; padding: 10px; background: #fee2e2; border-radius: 8px;">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>
        
        <?php if ($success): ?>
            <div class="success-message" style="text-align: center; margin-bottom: 20px; padding: 10px; background: #dcfce7; border-radius: 8px;">
                <?php echo htmlspecialchars($success); ?>
            </div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <div style="background: var(--light-gray); padding: 20px; border-radius: 10px; margin-bottom: 30px;">
                <h3 style="margin-bottom: 15px; color: var(--dark-gray);">Informasi Dasar</h3>
                
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" class="form-control" required 
                           value="<?php echo htmlspecialchars($user['username']); ?>">
                </div>
                
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" class="form-control" required 
                           value="<?php echo htmlspecialchars($user['email']); ?>">
                </div>
                
                <div class="form-group">
                    <label for="no_telepon">No. Telepon</label>
                    <input type="tel" id="no_telepon" name="no_telepon" class="form-control" 
                           value="<?php echo htmlspecialchars($user['no_telepon'] ?? ''); ?>">
                </div>
            </div>
            
            <div style="background: var(--light-blue); padding: 20px; border-radius: 10px; margin-bottom: 30px;">
                <h3 style="margin-bottom: 15px; color: var(--dark-gray);">Ubah Password</h3>
                <p style="color: #6b7280; margin-bottom: 15px; font-size: 14px;">Kosongkan jika tidak ingin mengubah password</p>
                
                <div class="form-group">
                    <label for="current_password">Password Saat Ini</label>
                    <input type="password" id="current_password" name="current_password" class="form-control">
                </div>
                
                <div class="form-group">
                    <label for="new_password">Password Baru</label>
                    <input type="password" id="new_password" name="new_password" class="form-control">
                    <small style="color: #6b7280;">Minimal 6 karakter</small>
                </div>
                
                <div class="form-group">
                    <label for="confirm_password">Konfirmasi Password Baru</label>
                    <input type="password" id="confirm_password" name="confirm_password" class="form-control">
                </div>
            </div>
            
            <div style="display: flex; gap: 15px; justify-content: center;">
                <button type="submit" class="btn btn-primary btn-large">
                    Simpan Perubahan
                </button>
                <a href="main.php" class="btn btn-outline btn-large">
                    Kembali
                </a>
            </div>
        </form>
    </div>

    <script src="assets/script.js"></script>
</body>
</html>
