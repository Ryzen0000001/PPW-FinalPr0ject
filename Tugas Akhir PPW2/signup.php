<?php 
include 'config.php';

$error = '';
$success = '';

if ($_POST) {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $no_telepon = trim($_POST['no_telepon']);
    
    // Validation
    if (empty($username) || empty($email) || empty($password)) {
        $error = 'Username, email, dan password wajib diisi';
    } elseif ($password !== $confirm_password) {
        $error = 'Password dan konfirmasi password tidak cocok';
    } elseif (strlen($password) < 6) {
        $error = 'Password minimal 6 karakter';
    } else {
        try {
            // Check if email already exists
            $stmt = $pdo->prepare("SELECT id_user FROM Users WHERE email = ?");
            $stmt->execute([$email]);
            if ($stmt->fetch()) {
                $error = 'Email sudah terdaftar';
            } else {
                // Check if username already exists
                $stmt = $pdo->prepare("SELECT id_user FROM Users WHERE username = ?");
                $stmt->execute([$username]);
                if ($stmt->fetch()) {
                    $error = 'Username sudah digunakan';
                } else {
                    // Insert new user
                    $password_hash = password_hash($password, PASSWORD_DEFAULT);
                    $stmt = $pdo->prepare("INSERT INTO Users (username, email, password_hash, no_telepon) VALUES (?, ?, ?, ?)");
                    $stmt->execute([$username, $email, $password_hash, $no_telepon]);
                    
                    $success = 'Akun berhasil dibuat! Silakan login.';
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
    <title>Daftar - Gu-Book KAI</title>
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
            
            <div class="nav-buttons">
                <a href="index.php" class="btn btn-outline">Kembali ke Beranda</a>
            </div>
        </div>
    </header>

    <!-- Signup Form -->
    <div class="form-container" style="max-width: 500px; margin-top: 50px;">
        <h2>Buat Akun Baru</h2>
        
        <?php if ($error): ?>
            <div class="error-message" style="text-align: center; margin-bottom: 20px; padding: 10px; background: #fee2e2; border-radius: 8px;">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>
        
        <?php if ($success): ?>
            <div class="success-message" style="text-align: center; margin-bottom: 20px; padding: 10px; background: #dcfce7; border-radius: 8px;">
                <?php echo htmlspecialchars($success); ?>
                <br><a href="login.php" style="color: var(--primary-blue); font-weight: 600;">Login sekarang</a>
            </div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" class="form-control" required 
                       value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>">
            </div>
            
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" class="form-control" required 
                       value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
            </div>
            
            <div class="form-group">
                <label for="no_telepon">No. Telepon (Opsional)</label>
                <input type="tel" id="no_telepon" name="no_telepon" class="form-control" 
                       value="<?php echo isset($_POST['no_telepon']) ? htmlspecialchars($_POST['no_telepon']) : ''; ?>">
            </div>
            
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" class="form-control" required>
                <small style="color: #6b7280;">Minimal 6 karakter</small>
            </div>
            
            <div class="form-group">
                <label for="confirm_password">Konfirmasi Password</label>
                <input type="password" id="confirm_password" name="confirm_password" class="form-control" required>
            </div>
            
            <button type="submit" class="btn btn-primary" style="width: 100%; margin-bottom: 20px;">
                Daftar Sekarang
            </button>
        </form>
        
        <div style="text-align: center;">
            <p>Sudah punya akun? <a href="login.php" style="color: var(--primary-blue); text-decoration: none; font-weight: 600;">Login di sini</a></p>
        </div>
        
        <div style="margin-top: 30px; text-align: center;">
            <div style="border-top: 1px solid #e5e7eb; margin: 20px 0; position: relative;">
                <span style="background: var(--white); padding: 0 15px; color: #6b7280; position: absolute; top: -10px; left: 50%; transform: translateX(-50%);">atau</span>
            </div>
            <button class="btn btn-outline" style="width: 100%; display: flex; align-items: center; justify-content: center; gap: 10px;">
                <span style="font-size: 18px;">🔍</span>
                Daftar dengan Google
            </button>
        </div>
    </div>

    <script src="assets/script.js"></script>
</body>
</html>
