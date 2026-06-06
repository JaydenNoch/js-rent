<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=yes">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="format-detection" content="telephone=no">
        <meta http-equiv="Content-Security-Policy" content="script-src 'self' https://app.sandbox.midtrans.com 'unsafe-inline' 'unsafe-eval';">
        <title>JS Rent – Rental Motor Terpercaya</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <link rel="stylesheet" href="css/style.css">
        <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-Y8qQRUExSUOpT1p2"></script>
        <script src="js/main.js"></script>
    </head>
    <body>

        <header class="header" id="header">
            <div class="container">
                <nav class="navbar">
                    <div class="logo">
                    <a>
                        <img src="assets/pp2.png" alt="JS Rent Logo" class="logo-img">
                        JS Rent
                    </a>
                </div>

                    <ul class="nav-links" id="navLinks">
                        <li><a href="#home" class="nav-link active">Home</a></li>
                        <li><a href="#motor" class="nav-link">Pilihan Motor</a></li>
                        <li><a href="#about" class="nav-link">Tentang Kami</a></li>
                        <li><a href="#contact" class="nav-link">Kontak</a></li>
                    </ul>
                    <div class="hamburger" id="hamburger">
                        <i class="fas fa-bars"></i>
                    </div>
                </nav>
            </div>
        </header>

        <div id="topSearchWrapper">
            <div class="container">
                <div class="search-bar">
                    <i class="fas fa-search"></i>
                    <input type="text" id="motorSearchInput" placeholder="Cari motor Anda (contoh: Beat, Vario, NMAX)..." aria-label="Cari Motor">
                </div>
            </div>
        </div>

        <section class="visual-hero">
            <div class="hero-image-overlay">
                <div class="container hero-content-container">
                    <div class="hero-text-box fade-in">
                        <h1 class="hero-title">JS Rent – Rental Motor Terpercaya</h1>
                        <p class="hero-subtitle">Pilihan motor lengkap, harga terjangkau, dan pelayanan cepat di Yogyakarta.</p>

                        <div class="hero-location-badge">
                            <a href="https://maps.google.com" target="_blank" rel="noopener">
                                <i class="fas fa-map-marker-alt"></i> Ngampilan, Yogyakarta
                            </a>
                        </div>

                        <div class="hero-buttons">
                            <a href="#motor" class="btn"><i class="fas fa-motorcycle"></i> Lihat Pilihan Motor</a>
                            <a href="https://wa.me/6281214025894?text=Halo%20JS%20Rental,%20saya%20ingin%20menanyakan%20ketersediaan%20motor%20sewa" class="btn btn-whatsapp" target="_blank" rel="noopener"><i class="fab fa-whatsapp"></i> Sewa Sekarang</a>
                        </div>
                    </div>
                </div>
            </div>
            <img src="assets/ppp.png" alt="Ruko JS Rental Motor Yogyakarta" class="hero-main-image" onerror="this.onerror=null; this.src='https://via.placeholder.com/1200x600?text=JS+RENT+YOGYAKARTA';" loading="lazy">
        </section>
        
        <main>
            <section class="section" id="home">
                <div class="container">
                    <div class="section-title">
                        <h2>Mengapa Memilih JS Rental?</h2>
                    </div>
                    <div class="stats-container">
                        <div class="stat-card">
                            <i class="fas fa-handshake stat-icon"></i>
                            <h3>Terpercaya</h3>
                            <p>Ribuan pelanggan puas dengan layanan kami.</p>
                        </div>
                        <div class="stat-card">
                            <i class="fas fa-tachometer-alt stat-icon"></i>
                            <h3>Motor Terbaru</h3>
                            <p>Unit motor tahun muda, terawat, dan prima.</p>
                        </div>
                        <div class="stat-card">
                            <i class="fas fa-wallet stat-icon"></i>
                            <h3>Harga Murah</h3>
                            <p>Mulai dari Rp 70.000/hari, terbaik di Jogja.</p>
                        </div>
                        <div class="stat-card">
                            <i class="fas fa-headset stat-icon"></i>
                            <h3>Layanan 24 Jam</h3>
                            <p>Customer Service siap melayani kapan pun.</p>
                        </div>
                    </div>
                </div>
            </section>

            <section class="section" id="motor">
                <div class="container">
                    <div class="section-title">
                        <h2>Pilihan Motor Kami</h2>
                    </div>
                    
                    <div class="filter-buttons">
                        <button class="btn filter-btn active" data-filter="all">Semua Motor</button>
                        <button class="btn filter-btn" data-filter="matic">Matic</button>
                        <button class="btn filter-btn" data-filter="manual">Manual</button>
                        <button class="btn filter-btn" data-filter="honda">Honda</button>
                        <button class="btn filter-btn" data-filter="yamaha">Yamaha</button>
                        <button class="btn filter-btn" data-filter="big-cc">150cc+</button>
                    </div>

                    <div class="motor-list" id="motorList">
                        <p id="noResults" style="text-align: center; width: 100%; display: none; color: var(--gray);">
                            Motor yang Anda cari tidak ditemukan. Coba kata kunci lain!
                        </p>
                    </div>
                </div>
            </section>

            <section class="section" id="about">
                <div class="container">
                    <div class="section-title">
                        <h2>Tentang JS Rent</h2>
                    </div>
                    <div style="max-width: 800px; margin: 0 auto; text-align: center; color: var(--gray);">
                        <p style="margin-bottom: 20px;">JS Rent adalah penyedia layanan rental motor terpercaya yang berlokasi strategis di Yogyakarta. Kami berkomitmen menyediakan pengalaman menyewa motor yang mudah, aman, dan menyenangkan bagi para wisatawan maupun penduduk lokal.</p>
                        <p style="margin-bottom: 20px;">Kami hanya menyediakan unit motor terbaru dan selalu terawat dengan baik. Setiap motor menjalani pemeriksaan rutin sebelum disewakan untuk memastikan kenyamanan dan keselamatan Anda selama perjalanan di kota Jogja yang istimewa.</p>
                        <p style="font-weight: 600;">Kepuasan dan keamanan Anda adalah prioritas kami!</p>
                    </div>
                </div>
            </section>

            <section id="contact">
                <div class="container">
                    <div class="section-title">
                        <h2>Hubungi Kami</h2>
                    </div>
                    
                    <div class="contact-content">
                        <div class="contact-info">
                            <h3>Informasi Kontak</h3>
                            <div class="info-item">
                                <i class="fas fa-map-marker-alt"></i>
                                <a href="https://maps.app.goo.gl/pCjRE9RYuWHwYhDu5">Ngampilan, Kota Yogyakarta, Daerah Istimewa Yogyakarta 55261</a >
                            </div>
                            <div class="info-item">
                                <i class="fas fa-phone-alt"></i>
                                <a href="tel:+6281214025894">+62 812-1402-5894</a>
                            </div>
                            <div class="info-item">
                                <i class="fab fa-whatsapp"></i>
                                <a href="https://wa.me/6281214025894" target="_blank" rel="noopener">WhatsApp Chat</a>
                            </div>
                            <div class="info-item">
                                <i class="fas fa-envelope"></i>
                                <a href="mailto:jsr_rent@mail.com">jsr_rent@mail.com</a>
                            </div>
                            
                            <div class="social-links">
                                <a href="#" target="_blank"><i class="fab fa-facebook-f"></i></a>
                                <a href="#" target="_blank"><i class="fab fa-instagram"></i></a>
                                <a href="#" target="_blank"><i class="fab fa-twitter"></i></a>
                            </div>
                        </div>
                        
                        <div class="contact-form-container">
                            <div class="contact-form">
                                <h3>Kirim Pesan Cepat</h3>
                                <form id="contactForm">
                                    <div class="form-group">
                                        <label for="name">Nama</label>
                                        <input type="text" id="name" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="email" id="email" name="email" class="form-control" placeholder="contoh@gmail.com" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="message">Pesan / Pertanyaan</label>
                                        <textarea id="message" rows="4" required></textarea>
                                    </div>
                                    <button type="submit" class="btn"><i class="fas fa-paper-plane"></i> Kirim Pesan</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>

        <footer class="footer">
            <div class="container">
                <p>&copy; 2025 JS Rent. All rights reserved. | Code by Jayden Noch</p>
            </div>
        </footer>

        <a href="https://wa.me/6281214025894?text=Halo%20JS%20Rental,%20saya%20mau%20sewa%20motor." class="wa-btn" target="_blank" rel="noopener">
            <i class="fab fa-whatsapp"></i> Chat WhatsApp
        </a>

        <a href="#header" class="back-to-top" id="backToTop">
            <i class="fas fa-arrow-up"></i>
        </a>

        <div id="paymentModal" class="modal">
            <div class="modal-content">
                <span class="close-btn">&times;</span>
                <div class="modal-header">
                    <h3>Formulir Sewa & Pembayaran <span id="modalMotorName"></span></h3>
                </div>
                
                <form id="rentalPaymentForm">
                    <input type="hidden" id="formMotorName" name="Motor">
                    <input type="hidden" id="formMotorPrice" name="Harga Motor Per Hari">

                    <div class="form-group">
                        <label for="fullName">Nama Lengkap</label>
                        <input type="text" id="fullName" name="Nama" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="Email" required>
                    </div>
                    <div class="form-group">
                        <label for="phoneNumber">Nomor HP (WhatsApp)</label>
                        <input type="tel" id="phoneNumber" name="No HP" required>
                    </div>
                    <div class="form-group">
                        <label for="cityOrigin">Asal Kota</label>
                        <input type="text" id="cityOrigin" name="Asal Kota" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="rentalDuration">Durasi Sewa (Hari)</label>
                        <select id="rentalDuration" name="Durasi Sewa" required>
                            <option value="1">1 Hari</option>
                            <option value="2">2 Hari</option>
                            <option value="3">3 Hari</option>
                            <option value="4">4 Hari</option>
                            <option value="5">5 Hari</option>
                            <option value="6">6 Hari</option>
                            <option value="7">7 Hari</option>
                        </select>
                    </div>
                    
                    <div id="paymentDetails">
                        <h4>Rincian Pembayaran</h4>
                        <p>Harga Motor/Hari: <span id="pricePerDayDisplay">Rp 85.000</span></p>
                        <p>Total Harga: <span class="total-price-display" id="totalPriceDisplay">Rp 85.000</span></p>
                        <input type="hidden" id="formTotalPrice" name="Total Harga">
                        <input type="hidden" id="formPaymentMethod" name="Metode Pembayaran">

                        <hr style="margin: 15px 0; border-color: var(--border-color);">
                        
                    

                        <p style="margin-top: 15px; font-size: 14px; text-align: center; color: #D32F2F;">*Pembayaran ini bersifat simulasi/demo.</p>
                    </div>
                    
                    <button type="submit" class="btn" style="margin-top: 20px;"><i class="fas fa-check-circle"></i> Selesaikan Pemesanan</button>
                </form>
            </div>
        </div>

    </body>
</html>