<?php include 'config.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gu-Book KAI - Panduan Kereta Api Indonesia</title>
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
                    <li><a href="index.php" class="active">Beranda</a></li>
                    <li><a href="main.php">Jadwal Kereta</a></li>
                    <li><a href="#routes">Rute</a></li>
                    <li><a href="#facilities">Fasilitas</a></li>
                    <li><a href="#contact">Kontak</a></li>
                </ul>
            </nav>
            
            <div class="nav-buttons">
                <?php if (isLoggedIn()): ?>
                    <a href="edit_profile.php" class="btn btn-outline">Profile</a>
                    <a href="logout.php" class="btn btn-primary">Logout</a>
                <?php else: ?>
                    <a href="login.php" class="btn btn-outline">Login</a>
                    <a href="signup.php" class="btn btn-primary">Sign Up</a>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero">
        <h1>KEMEWAHAN NAN ELEGAN</h1>
        <p>Panduan lengkap perkeretaapian Indonesia - Temukan informasi rute, harga, kelas, dan fasilitas kereta api terlengkap untuk perjalanan yang nyaman dan berkesan.</p>
        
        <div class="hero-buttons">
            <a href="main.php" class="btn btn-primary btn-large">🗺️ Cari Jadwal Kereta</a>
            <a href="#classes" class="btn btn-secondary btn-large">⏰ Lihat Kelas Kereta</a>
        </div>
        
        <div class="hero-image">
            <img src="/placeholder.svg?height=400&width=1000" alt="Kereta Api Indonesia - Luxury Train">
            <div class="hero-overlay">
                <h3>Perjalanan Berkelas Premium</h3>
                <p>Nikmati kenyamanan dan kemewahan dalam setiap perjalanan dengan fasilitas terdepan</p>
            </div>
        </div>
    </section>

    <!-- Train Classes Section -->
    <section class="cards-section" id="classes">
        <div class="section-title">
            <h2>Kelas Perjalanan</h2>
            <p>Pilih kelas yang sesuai dengan kebutuhan dan budget perjalanan Anda</p>
        </div>
        
        <div class="cards-grid">
            <div class="card">
                <div class="card-header">
                    <h3>Imperial Class</h3>
                    <span class="badge badge-premium">Premium</span>
                </div>
                <p>Kelas tertinggi dengan fasilitas mewah dan pelayanan eksklusif untuk pengalaman perjalanan yang tak terlupakan.</p>
                <ul style="margin-top: 15px; padding-left: 20px;">
                    <li>✨ Kursi reclining premium</li>
                    <li>👥 Kapasitas terbatas</li>
                    <li>🛡️ Layanan premium</li>
                    <li>🍽️ Makanan berkualitas tinggi</li>
                </ul>
            </div>
            
            <div class="card">
                <div class="card-header">
                    <h3>Priority Class</h3>
                    <span class="badge badge-popular">Populer</span>
                </div>
                <p>Kenyamanan optimal dengan harga terjangkau, pilihan favorit untuk perjalanan bisnis dan keluarga.</p>
                <ul style="margin-top: 15px; padding-left: 20px;">
                    <li>⭐ Kursi nyaman dengan AC</li>
                    <li>👥 Kapasitas sedang</li>
                    <li>🛡️ Layanan standar</li>
                    <li>📱 WiFi tersedia</li>
                </ul>
            </div>
            
            <div class="card">
                <div class="card-header">
                    <h3>Retro Dine-In</h3>
                    <span class="badge badge-unique">Unik</span>
                </div>
                <p>Pengalaman kuliner dalam perjalanan dengan suasana retro yang menawan dan menu spesial.</p>
                <ul style="margin-top: 15px; padding-left: 20px;">
                    <li>🍽️ Restoran dalam kereta</li>
                    <li>👥 Pengalaman berkuliner</li>
                    <li>🛡️ Menu spesial</li>
                    <li>📸 Suasana instagramable</li>
                </ul>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="cards-section">
        <div class="section-title">
            <h2>Mengapa Memilih Gu-Book KAI?</h2>
            <p>Platform terlengkap untuk informasi perkeretaapian Indonesia</p>
        </div>
        
        <div class="cards-grid">
            <div class="card" style="text-align: center;">
                <div style="background: var(--light-blue); width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; font-size: 24px;">🗺️</div>
                <h3>Rute Lengkap</h3>
                <p>Informasi rute kereta api seluruh Indonesia dengan detail pemberhentian dan jadwal yang akurat.</p>
            </div>
            
            <div class="card" style="text-align: center;">
                <div style="background: var(--light-orange); width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; font-size: 24px;">⏰</div>
                <h3>Jadwal Akurat</h3>
                <p>Jadwal keberangkatan dan kedatangan yang selalu terupdate langsung dari sistem resmi KAI.</p>
            </div>
            
            <div class="card" style="text-align: center;">
                <div style="background: #fef3c7; width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; font-size: 24px;">💰</div>
                <h3>Harga Terbaik</h3>
                <p>Informasi tarif terlengkap dengan harga khusus untuk member terdaftar.</p>
            </div>
            
            <div class="card" style="text-align: center;">
                <div style="background: #e0e7ff; width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; font-size: 24px;">🛡️</div>
                <h3>Terpercaya</h3>
                <p>Data resmi dari PT Kereta Api Indonesia yang selalu terupdate dan dapat diandalkan.</p>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section style="padding: 80px 20px; background: var(--primary-blue); text-align: center; color: var(--white);">
        <div style="max-width: 800px; margin: 0 auto;">
            <h2 style="font-size: 2.5rem; margin-bottom: 20px;">Mulai Perjalanan Anda Sekarang</h2>
            <p style="font-size: 1.2rem; margin-bottom: 40px; opacity: 0.9;">
                Daftar sekarang dan dapatkan akses ke tarif khusus serta fitur premium lainnya
            </p>
            <div style="display: flex; gap: 20px; justify-content: center; flex-wrap: wrap;">
                <a href="signup.php" class="btn btn-secondary btn-large">Daftar Gratis</a>
                <a href="main.php" class="btn btn-outline btn-large" style="border-color: var(--white); color: var(--white);">Lihat Jadwal</a>
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
