<?php
// admin/footer.php
// Footer untuk semua halaman admin
?>
    </div> <!-- penutup main-content -->
    
    <!-- Footer -->
    <footer style="
        background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
        color: white;
        padding: 30px 20px 20px;
        margin-top: 50px;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    ">
        <div style="max-width: 1400px; margin: 0 auto;">
            <div style="display: flex; flex-wrap: wrap; justify-content: space-between; gap: 30px;">
                
                <!-- Bagian 1: Logo & Deskripsi -->
                <div style="flex: 1; min-width: 200px;">
                    <h3 style="color: #e94560; margin-bottom: 15px;">🐱 Nekoverse</h3>
                    <p style="font-size: 13px; opacity: 0.8; line-height: 1.6;">
                        Portal berita jejepangan terpercaya.<br>
                        Anime, Manga, J-Pop, Game, Idol,<br>
                        Kuliner, dan Budaya Pop Jepang lainnya.
                    </p>
                </div>
                
                <!-- Bagian 2: Link Cepat -->
                <div style="flex: 1; min-width: 150px;">
                    <h4 style="color: #e94560; margin-bottom: 15px; font-size: 16px;">📌 Link Cepat</h4>
                    <ul style="list-style: none; padding: 0;">
                        <li style="margin-bottom: 8px;"><a href="index.php" style="color: white; text-decoration: none; font-size: 13px; opacity: 0.8;">📊 Dashboard</a></li>
                        <li style="margin-bottom: 8px;"><a href="artikel.php" style="color: white; text-decoration: none; font-size: 13px; opacity: 0.8;">📝 Kelola Artikel</a></li>
                        <li style="margin-bottom: 8px;"><a href="kategori.php" style="color: white; text-decoration: none; font-size: 13px; opacity: 0.8;">📁 Kelola Kategori</a></li>
                        <li style="margin-bottom: 8px;"><a href="statistik.php" style="color: white; text-decoration: none; font-size: 13px; opacity: 0.8;">📈 Statistik</a></li>
                    </ul>
                </div>
                
                <!-- Bagian 3: Informasi -->
                <div style="flex: 1; min-width: 180px;">
                    <h4 style="color: #e94560; margin-bottom: 15px; font-size: 16px;">ℹ️ Informasi</h4>
                    <ul style="list-style: none; padding: 0;">
                        <li style="margin-bottom: 8px; font-size: 13px; opacity: 0.8;">📅 <?= date('d F Y') ?></li>
                        <li style="margin-bottom: 8px; font-size: 13px; opacity: 0.8;">👤 Admin: <?= $_SESSION['admin_username'] ?? 'Admin' ?></li>
                        <li style="margin-bottom: 8px; font-size: 13px; opacity: 0.8;">🕒 Versi: 1.0</li>
                    </ul>
                </div>
            </div>
            
            <!-- Copyright -->
            <div style="
                text-align: center; 
                padding-top: 25px; 
                margin-top: 25px; 
                border-top: 1px solid rgba(255,255,255,0.1);
                font-size: 12px;
                opacity: 0.6;
            ">
                <p>&copy; <?= date('Y') ?> Nekoverse - Semesta Kucing untuk Otaku Indonesia 🐱🎌</p>
                <p style="margin-top: 5px;">Admin Panel | Portal Berita Jejepangan</p>
            </div>
        </div>
    </footer>
</body>
</html>