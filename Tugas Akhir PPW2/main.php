<?php 
include 'config.php';

// Get search parameters
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'nama_ka';
$order = isset($_GET['order']) ? $_GET['order'] : 'ASC';

// Build query based on user login status
if (isLoggedIn()) {
    // Logged in users see special prices
    $query = "SELECT 
        k.no_kereta,
        k.nama_ka,
        s1.nama_stasiun AS stasiun_awal,
        s2.nama_stasiun AS stasiun_akhir,
        TIME_FORMAT(k.jam_keberangkatan, '%H:%i') AS jam_keberangkatan,
        COALESCE(tk.tarif_khusus, t.tarif) AS tarif,
        CASE WHEN tk.tarif_khusus IS NOT NULL THEN 'special' ELSE 'regular' END AS tarif_type
    FROM Kereta k
    JOIN Stasiun s1 ON k.asal_stasiun_id = s1.id_stasiun
    JOIN Stasiun s2 ON k.tujuan_stasiun_id = s2.id_stasiun
    LEFT JOIN Tarif t ON t.kereta_no = k.no_kereta 
        AND t.asal_stasiun_id = k.asal_stasiun_id 
        AND t.tujuan_stasiun_id = k.tujuan_stasiun_id
    LEFT JOIN Tarif_Khusus tk ON tk.kereta_no = k.no_kereta 
        AND tk.asal_stasiun_id = k.asal_stasiun_id 
        AND tk.tujuan_stasiun_id = k.tujuan_stasiun_id";
} else {
    // Guest users see regular prices only
    $query = "SELECT 
        k.no_kereta,
        k.nama_ka,
        s1.nama_stasiun AS stasiun_awal,
        s2.nama_stasiun AS stasiun_akhir,
        TIME_FORMAT(k.jam_keberangkatan, '%H:%i') AS jam_keberangkatan,
        t.tarif,
        'regular' AS tarif_type
    FROM Kereta k
    JOIN Stasiun s1 ON k.asal_stasiun_id = s1.id_stasiun
    JOIN Stasiun s2 ON k.tujuan_stasiun_id = s2.id_stasiun
    JOIN Tarif t ON t.kereta_no = k.no_kereta 
        AND t.asal_stasiun_id = k.asal_stasiun_id 
        AND t.tujuan_stasiun_id = k.tujuan_stasiun_id";
}

// Add search condition
if (!empty($search)) {
    $query .= " WHERE (k.nama_ka LIKE :search OR s1.nama_stasiun LIKE :search OR s2.nama_stasiun LIKE :search)";
}

// Add sorting
$allowed_sorts = ['nama_ka', 'stasiun_awal', 'stasiun_akhir', 'jam_keberangkatan', 'tarif'];
if (in_array($sort, $allowed_sorts)) {
    $query .= " ORDER BY " . $sort . " " . ($order === 'DESC' ? 'DESC' : 'ASC');
}

try {
    $stmt = $pdo->prepare($query);
    if (!empty($search)) {
        $stmt->bindValue(':search', '%' . $search . '%');
    }
    $stmt->execute();
    $trains = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $trains = [];
    $error = 'Terjadi kesalahan dalam mengambil data';
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Kereta - Gu-Book KAI</title>
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
                    <li><a href="main.php" class="active">Jadwal Kereta</a></li>
                </ul>
            </nav>
            
            <div class="nav-buttons">
                <?php if (isLoggedIn()): ?>
                    <span style="color: var(--dark-gray);">Halo, <?php echo htmlspecialchars($_SESSION['username']); ?></span>
                    <a href="edit_profile.php" class="btn btn-outline">Profile</a>
                    <a href="logout.php" class="btn btn-primary">Logout</a>
                <?php else: ?>
                    <a href="login.php" class="btn btn-outline">Login</a>
                    <a href="signup.php" class="btn btn-primary">Sign Up</a>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <div class="table-container">
        <div class="table-header">
            <div>
                <h1 style="color: var(--dark-gray); margin-bottom: 10px;">Jadwal Kereta Api</h1>
                <?php if (isLoggedIn()): ?>
                    <p style="color: var(--secondary-orange); font-weight: 600;">✨ Anda mendapat akses tarif khusus sebagai member!</p>
                <?php else: ?>
                    <p style="color: #6b7280;">💡 <a href="login.php" style="color: var(--primary-blue);">Login</a> untuk melihat tarif khusus member</p>
                <?php endif; ?>
            </div>
            
            <div class="search-box">
                <form method="GET" action="" style="display: flex; gap: 10px; align-items: center;">
                    <input type="text" name="search" id="searchInput" placeholder="Cari kereta atau stasiun..." 
                           value="<?php echo htmlspecialchars($search); ?>" class="form-control">
                    <button type="submit" class="btn btn-primary">🔍 Cari</button>
                    <?php if (!empty($search)): ?>
                        <a href="main.php" class="btn btn-outline">Clear</a>
                    <?php endif; ?>
                </form>
            </div>
        </div>

        <?php if (isset($error)): ?>
            <div class="error-message" style="text-align: center; margin-bottom: 20px; padding: 15px; background: #fee2e2; border-radius: 8px;">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <div class="data-table">
            <table>
                <thead>
                    <tr>
                        <th>
                            <a href="?search=<?php echo urlencode($search); ?>&sort=nama_ka&order=<?php echo $sort === 'nama_ka' && $order === 'ASC' ? 'DESC' : 'ASC'; ?>" 
                               style="color: var(--white); text-decoration: none;">
                                Nama Kereta <?php if ($sort === 'nama_ka') echo $order === 'ASC' ? '↑' : '↓'; ?>
                            </a>
                        </th>
                        <th>
                            <a href="?search=<?php echo urlencode($search); ?>&sort=stasiun_awal&order=<?php echo $sort === 'stasiun_awal' && $order === 'ASC' ? 'DESC' : 'ASC'; ?>" 
                               style="color: var(--white); text-decoration: none;">
                                Stasiun Awal <?php if ($sort === 'stasiun_awal') echo $order === 'ASC' ? '↑' : '↓'; ?>
                            </a>
                        </th>
                        <th>
                            <a href="?search=<?php echo urlencode($search); ?>&sort=stasiun_akhir&order=<?php echo $sort === 'stasiun_akhir' && $order === 'ASC' ? 'DESC' : 'ASC'; ?>" 
                               style="color: var(--white); text-decoration: none;">
                                Stasiun Akhir <?php if ($sort === 'stasiun_akhir') echo $order === 'ASC' ? '↑' : '↓'; ?>
                            </a>
                        </th>
                        <th>
                            <a href="?search=<?php echo urlencode($search); ?>&sort=jam_keberangkatan&order=<?php echo $sort === 'jam_keberangkatan' && $order === 'ASC' ? 'DESC' : 'ASC'; ?>" 
                               style="color: var(--white); text-decoration: none;">
                                Jam Keberangkatan <?php if ($sort === 'jam_keberangkatan') echo $order === 'ASC' ? '↑' : '↓'; ?>
                            </a>
                        </th>
                        <th>Jam Ketibaan</th>
                        <th>
                            <a href="?search=<?php echo urlencode($search); ?>&sort=tarif&order=<?php echo $sort === 'tarif' && $order === 'ASC' ? 'DESC' : 'ASC'; ?>" 
                               style="color: var(--white); text-decoration: none;">
                                Tarif <?php if ($sort === 'tarif') echo $order === 'ASC' ? '↑' : '↓'; ?>
                            </a>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($trains)): ?>
                        <tr>
                            <td colspan="6" style="text-align: center; padding: 40px; color: #6b7280;">
                                <?php if (!empty($search)): ?>
                                    Tidak ada kereta yang ditemukan untuk pencarian "<?php echo htmlspecialchars($search); ?>"
                                <?php else: ?>
                                    Belum ada data kereta tersedia
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($trains as $train): ?>
                            <tr>
                                <td>
                                    <strong><?php echo htmlspecialchars($train['nama_ka']); ?></strong>
                                    <br><small style="color: #6b7280;">No. <?php echo $train['no_kereta']; ?></small>
                                </td>
                                <td><?php echo htmlspecialchars($train['stasiun_awal']); ?></td>
                                <td><?php echo htmlspecialchars($train['stasiun_akhir']); ?></td>
                                <td>
                                    <strong><?php echo $train['jam_keberangkatan']; ?></strong>
                                </td>
                                <td>
                                    <span style="color: #6b7280;">Estimasi tiba</span>
                                    <br><strong>--:--</strong>
                                </td>
                                <td>
                                    <?php if (isset($train['tarif']) && $train['tarif']): ?>
                                        <span class="price-badge <?php echo $train['tarif_type'] === 'special' ? 'special-price' : ''; ?>">
                                            <?php echo 'Rp ' . number_format($train['tarif'], 0, ',', '.'); ?>
                                            <?php if ($train['tarif_type'] === 'special'): ?>
                                                <br><small>✨ Harga Member</small>
                                            <?php endif; ?>
                                        </span>
                                    <?php else: ?>
                                        <span style="color: #6b7280;">Hubungi CS</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <?php if (!empty($trains)): ?>
            <div style="margin-top: 20px; text-align: center; color: #6b7280;">
                Menampilkan <?php echo count($trains); ?> kereta
                <?php if (!empty($search)): ?>
                    untuk pencarian "<?php echo htmlspecialchars($search); ?>"
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- Info Section -->
    <section style="padding: 60px 20px; background: var(--light-gray);">
        <div style="max-width: 1200px; margin: 0 auto; text-align: center;">
            <h2 style="color: var(--dark-gray); margin-bottom: 30px;">Informasi Penting</h2>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 30px;">
                <div style="background: var(--white); padding: 30px; border-radius: 15px; box-shadow: var(--shadow);">
                    <div style="font-size: 2rem; margin-bottom: 15px;">📋</div>
                    <h3 style="color: var(--dark-gray); margin-bottom: 15px;">Cara Membaca Jadwal</h3>
                    <p style="color: #6b7280;">Jadwal yang ditampilkan adalah waktu keberangkatan dari stasiun asal. Pastikan tiba di stasiun minimal 30 menit sebelum keberangkatan.</p>
                </div>
                
                <div style="background: var(--white); padding: 30px; border-radius: 15px; box-shadow: var(--shadow);">
                    <div style="font-size: 2rem; margin-bottom: 15px;">💰</div>
                    <h3 style="color: var(--dark-gray); margin-bottom: 15px;">Tentang Tarif</h3>
                    <p style="color: #6b7280;">Tarif yang ditampilkan adalah harga dasar. Member terdaftar mendapat akses ke tarif khusus yang lebih hemat.</p>
                </div>
                
                <div style="background: var(--white); padding: 30px; border-radius: 15px; box-shadow: var(--shadow);">
                    <div style="font-size: 2rem; margin-bottom: 15px;">🎫</div>
                    <h3 style="color: var(--dark-gray); margin-bottom: 15px;">Pemesanan Tiket</h3>
                    <p style="color: #6b7280;">Untuk pemesanan tiket resmi, silakan kunjungi aplikasi KAI Access atau stasiun terdekat.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-content">
            <div class="footer-section">
                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 20px;">
                    <div class="logo-icon">🚂</div>
                    <h3>Gu-Book KAI</h3>
                </div>
                <p>Panduan terlengkap perkeretaapian Indonesia untuk perjalanan yang nyaman dan aman.</p>
            </div>
            
            <div class="footer-section">
                <h3>Informasi</h3>
                <ul>
                    <li><a href="#about">Tentang Kami</a></li>
                    <li><a href="#faq">FAQ</a></li>
                    <li><a href="#contact">Kontak</a></li>
                    <li><a href="#terms">Syarat dan Ketentuan</a></li>
                </ul>
            </div>
            
            <div class="footer-section">
                <h3>Layanan</h3>
                <ul>
                    <li><a href="main.php">Jadwal Kereta</a></li>
                    <li><a href="#routes">Pencarian Rute</a></li>
                    <li><a href="#prices">Informasi Tarif</a></li>
                    <li><a href="#facilities">Fasilitas</a></li>
                </ul>
            </div>
            
            <div class="footer-section">
                <h3>Media Sosial</h3>
                <ul>
                    <li><a href="#">Facebook</a></li>
                    <li><a href="#">Instagram</a></li>
                    <li><a href="#">Twitter</a></li>
                    <li><a href="#">YouTube</a></li>
                </ul>
            </div>
        </div>
        
        <div class="footer-bottom">
            <p>&copy; 2024 Gu-Book KAI. Semua hak dilindungi undang-undang.</p>
        </div>
    </footer>

    <script src="assets/script.js"></script>
</body>
</html>
