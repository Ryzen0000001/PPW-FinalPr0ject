<?php 
include 'config.php';

$error = '';
$success = '';

if ($_POST) {
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    
    if (empty($email) || empty($password)) {
        $error = 'Email dan password wajib diisi';
    } else {
        try {
            $stmt = $pdo->prepare("SELECT * FROM Users WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($user && password_verify($password, $user['password_hash'])) {
                $_SESSION['user_id'] = $user['id_user'];
                $_SESSION['username'] = $user['username'];
                header('Location: main.php');
                exit;
            } else {
                $error = 'Email atau password salah';
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
    <title>Login - Gu-Book KAI</title>
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

    <!-- Login Form -->
    <div class="form-container">
        <h2>Masuk ke Akun Anda</h2>
        
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
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" class="form-control" required 
                       value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
            </div>
            
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>
            
            <button type="submit" class="btn btn-primary" style="width: 100%; margin-bottom: 20px;">
                Masuk
            </button>
        </form>
        
        <div style="text-align: center;">
            <p>Belum punya akun? <a href="signup.php" style="color: var(--primary-blue); text-decoration: none; font-weight: 600;">Daftar di sini</a></p>
            <p><a href="#" style="color: var(--secondary-orange); text-decoration: none;">Lupa password?</a></p>
        </div>
        
        <div style="margin-top: 30px; text-align: center;">
            <div style="border-top: 1px solid #e5e7eb; margin: 20px 0; position: relative;">
                <span style="background: var(--white); padding: 0 15px; color: #6b7280; position: absolute; top: -10px; left: 50%; transform: translateX(-50%);">atau</span>
            </div>
            <button class="btn btn-outline" style="width: 100%; display: flex; align-items: center; justify-content: center; gap: 10px;">
                <span style="font-size: 18px;">🔍</span>
                Masuk dengan Google
            </button>
        </div>
    </div>

    <script src="assets/script.js"></script>
</body>
</html>
