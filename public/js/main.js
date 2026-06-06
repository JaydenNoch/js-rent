document.addEventListener('DOMContentLoaded', function() {
    
    // =========================================================================================
    // *** KONFIGURASI API ***
    const MOTOR_API_URL = 'https://script.google.com/macros/s/AKfycbxW7o6OJbo3YRmL1d9xelMpe1Ky_REfyShjleAYttGDvg4ZzfE-_-f5LCph81lnbvKJcw/exec'; 
    const WEB_APP_URL = 'https://script.google.com/macros/s/AKfycbxXIcA8vhDr50_FwBFuY2CDPL2AQO5qOX0RdMrqs-Y/exec';
    // =========================================================================================

    // --- State & Cache ---
    let motors = [];
    let currentMotorName = ''; 

    const motorList = document.getElementById('motorList');
    const filterButtons = document.querySelectorAll('.filter-btn');
    const motorSearchInput = document.getElementById('motorSearchInput');
    const noResultsMessage = document.getElementById('noResults');
    
    const modal = document.getElementById('paymentModal');
    const closeBtn = document.querySelector('.close-btn');
    const rentalDuration = document.getElementById('rentalDuration');
    const totalPriceDisplay = document.getElementById('totalPriceDisplay');
    const pricePerDayDisplay = document.getElementById('pricePerDayDisplay');
    const paymentMethodsContainer = document.getElementById('paymentMethods');
    const instructionArea = document.getElementById('instructionArea');
    const rentalPaymentForm = document.getElementById('rentalPaymentForm');
    
    const formMotorName = document.getElementById('formMotorName');
    const formTotalPrice = document.getElementById('formTotalPrice');
    const formPaymentMethod = document.getElementById('formPaymentMethod');

    // --- 1. FUNGSI AMBIL DATA DARI GOOGLE SHEETS ---
    async function initializeMotors() {
        motorList.innerHTML = '<p style="text-align: center; width: 100%; color: var(--gray);"><i class="fas fa-spinner fa-spin"></i> Memuat database motor...</p>';
        
        try {
            const response = await fetch(`${MOTOR_API_URL}?action=getMotor`);
            const data = await response.json();

            if (data && data.length > 0) {
                motors = data.map(m => {
                    // --- BERSIHKAN LINK GOOGLE DRIVE (VERSI ANTI-BLOKIR) ---
                    let cleanImage = m.Link_Gambar || "https://via.placeholder.com/300x200";
                    
                    if (cleanImage.includes('drive.google.com')) {
                        // Ambil ID File
                        const matches = cleanImage.match(/\/d\/([^/?]+)/);
                        if (matches && matches[1]) {
                            // Menggunakan endpoint thumbnail + ukuran maksimal (w1000) agar gambar tetap tajam
                            cleanImage = `https://drive.google.com/thumbnail?id=${matches[1]}&sz=w1000`;
                        }
                    }

                    return {
                        id: m.ID_Motor,
                        name: m.Nama_Motor,
                        brand: m.Nama_Motor.toLowerCase().includes('honda') ? 'honda' : 
                               m.Nama_Motor.toLowerCase().includes('yamaha') ? 'yamaha' : 
                               m.Nama_Motor.toLowerCase().includes('kawasaki') ? 'kawasaki' : 'other',
                        type: m.Type.toLowerCase(),
                        description: m.Deskripsi,
                        image: cleanImage, 
                        currentPrice: parseInt(m.Harga),
                        currentStock: parseInt(m.Stock),
                        status: m.Status
                    };
                });
                renderMotorCards(motors);
            } else {
                throw new Error("Data kosong");
            }
        } catch (error) {
            console.error("Gagal muat data:", error);
            motorList.innerHTML = '<p style="text-align: center; color: #D32F2F;"><i class="fas fa-exclamation-triangle"></i> Gagal memuat database motor.</p>';
        }
    }

    // --- 2. FUNGSI RENDER KARTU MOTOR (WA & MODAL TETAP ADA) ---
    function renderMotorCards(motorArray) {
        motorList.innerHTML = ''; 
        const motorsToShow = motorArray.filter(motor => motor.currentPrice > 0);

        if (motorsToShow.length === 0) {
            noResultsMessage.style.display = 'block';
            motorList.appendChild(noResultsMessage);
            return;
        }
        noResultsMessage.style.display = 'none';

        motorsToShow.forEach(motor => {
            const isAvailable = motor.currentStock > 0 && (motor.status.toLowerCase() === 'tersedia');
            const card = document.createElement('div');
            card.classList.add('motor-card');

            const typeTags = motor.type.split(' ').map(tag => `<span class="tag ${tag.includes('big-cc') ? 'big-cc' : tag}">${tag.toUpperCase()}</span>`).join('');
            
            const priceDisplay = isAvailable ? 
                `Rp ${motor.currentPrice.toLocaleString('id-ID')}<small>/ Hari</small>` : 
                `<span style="color: #D32F2F; font-size: 20px; font-weight: 700;">${motor.status === 'Habis' ? 'Habis' : 'Tidak Tersedia'}</span>`;
            
            const cardButtons = isAvailable ? 
                `<button class="btn btn-payment open-modal-btn" data-motor-id="${motor.id}" type="button"><i class="fas fa-credit-card"></i> Payment</button>
                 <a href="https://wa.me/6281214025894?text=Halo%20JS%20Rental,%20saya%20tertarik%20sewa%20motor%20${motor.name}" target="_blank" class="btn btn-whatsapp-card"><i class="fab fa-whatsapp"></i> Sewa</a>` : 
                `<a href="https://wa.me/6281214025894?text=Halo%20JS%20Rental,%20apakah%20motor%20${motor.name}%20segera%20tersedia?" target="_blank" class="btn" style="background-color: #D32F2F !important; width: 100%; justify-content: center;"><i class="fab fa-whatsapp"></i> Cek Ketersediaan</a>`;

            card.innerHTML = `
                <div class="motor-image"><img src="${motor.image}" alt="${motor.name}"></div>
                <div class="motor-info">
                    <h3>${motor.name}</h3>
                    <div class="tags">
                        <span class="tag brand-tag">${motor.brand.toUpperCase()}</span>
                        ${typeTags}
                        <span class="tag" style="background-color: ${isAvailable ? '#388E3C' : '#D32F2F'};">${isAvailable ? `STOK: ${motor.currentStock}` : motor.status.toUpperCase()}</span>
                    </div>
                    <p class="description">${motor.description}</p>
                    <div class="price-row">
                        <div class="price">${priceDisplay}</div>
                        <div class="card-buttons-container">${cardButtons}</div>
                    </div>
                </div>`;
            motorList.appendChild(card);
        });
        
        document.querySelectorAll('.open-modal-btn').forEach(btn => btn.addEventListener('click', openPaymentModal));
    }

    // --- 3. LOGIKA PAYMENT MODAL ---
    function updateTotalPrice() {
        if (currentMotorPrice === 0) return; 
        const duration = parseInt(rentalDuration.value) || 1;
        const total = duration * currentMotorPrice;
        
        pricePerDayDisplay.textContent = `Rp ${currentMotorPrice.toLocaleString('id-ID')}`;
        totalPriceDisplay.textContent = `Rp ${total.toLocaleString('id-ID')}`;
        formTotalPrice.value = total;

        const activeMethodBtn = document.querySelector('.method-btn.active-method');
        if (activeMethodBtn) displayPaymentInstruction(activeMethodBtn.getAttribute('data-method'), total);
    }

    function openPaymentModal(event) {
        const motorId = event.currentTarget.getAttribute('data-motor-id');
        const selectedMotor = motors.find(m => m.id == motorId);

        if (!selectedMotor || selectedMotor.currentStock <= 0) return;

        currentMotorName = selectedMotor.name;
        currentMotorPrice = selectedMotor.currentPrice;

        document.getElementById('modalMotorName').textContent = `(${currentMotorName})`;
        formMotorName.value = currentMotorName;
        rentalPaymentForm.reset();
        rentalDuration.value = '1';
        
        updateTotalPrice();
        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden'; 
    }

    function closeModal() {
        modal.style.display = 'none';
        document.body.style.overflow = 'auto'; 
    }

    // --- 4. EVENT LISTENERS ---
    closeBtn.addEventListener('click', closeModal);
    window.addEventListener('click', (e) => { if (e.target === modal) closeModal(); });
    rentalDuration.addEventListener('change', updateTotalPrice);

    /*paymentMethodsContainer.querySelectorAll('.method-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            paymentMethodsContainer.querySelectorAll('.method-btn').forEach(b => b.classList.remove('active-method'));
            this.classList.add('active-method');
            formPaymentMethod.value = this.getAttribute('data-method'); 
            updateTotalPrice();
        });
    }); */

    // --- 5. SUBMIT FORM ---
    if (rentalPaymentForm) {
        rentalPaymentForm.onsubmit = async function(e) {
            e.preventDefault();
            
            // Ambil data dan BERSIHKAN (Trim)
            const nameValue = document.getElementById('fullName').value.trim();
            
            // Ganti baris emailValue lo pakai ini:
// Cara paling brutal untuk dapet isinya, gak peduli ID-nya apa
const allInputs = document.querySelectorAll('input');
let emailValue = "";

allInputs.forEach(input => {
    // Cari input yang ada karakter '@' atau tipenya email
    if (input.type === 'email' || input.name === 'email' || input.id === 'email') {
        if (input.value.includes('@')) {
            emailValue = input.value.trim();
        }
    }
});

console.log("HASIL TANGKAPAN EMAIL:", emailValue);

if (!emailValue) {
    alert("Sistem tetap tidak bisa menemukan email kamu. Coba ketik ulang emailnya.");
    return;
}
            const phoneValue = document.getElementById('phoneNumber').value.trim();
            const motorNameValue = document.getElementById('formMotorName').value;
            const priceValue = parseInt(document.getElementById('formTotalPrice').value);
            const durationValue = document.getElementById('rentalDuration').value;
            // LOG UNTUK DEBUG (Cek di F12 -> Console)
            console.log("Data yang dikirim:", { nameValue, emailValue, priceValue });

            const payload = {
                name: nameValue,
                email: emailValue,
                phone: phoneValue,
                motorName: motorNameValue,
                price: priceValue,
                duration: durationValue
            };

            const submitBtn = this.querySelector('button[type="submit"]');
            submitBtn.disabled = true;
            submitBtn.innerHTML = 'Memproses...';

            try {
                const response = await fetch('/api/checkout', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(payload)
                });

                const result = await response.json();

                if (result.token) {
                    window.snap.pay(result.token, {
                        onSuccess: function(res) { alert("Sukses!"); location.reload(); },
                        onPending: function(res) { alert("Menunggu pembayaran..."); },
                        onError: function(res) { alert("Gagal!"); submitBtn.disabled = false; }
                    });
                } else {
                    // Kalau gagal, munculkan pesan error dari Midtrans di sini
                    alert("Error Midtrans: " + result.error);
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = "Bayar Sekarang";
                }
            } catch (err) {
                alert("Koneksi Error!");
                submitBtn.disabled = false;
            }
        };
    }
    // --- FITUR SEARCH REAL-TIME ---
    motorSearchInput.addEventListener('input', function () {
        const searchTerm = this.value.toLowerCase().trim();

        // Reset tombol filter ke 'All' saat mengetik di search
        filterButtons.forEach(btn => btn.classList.remove('active'));
        if (searchTerm === "") {
            document.querySelector('[data-filter="all"]').classList.add('active');
        }

        // Filter data dari array 'motors' yang sudah diambil dari API
        const filteredMotors = motors.filter(motor => {
            const nameMatch = motor.name.toLowerCase().includes(searchTerm);
            const brandMatch = motor.brand.toLowerCase().includes(searchTerm);
            const typeMatch = motor.type.toLowerCase().includes(searchTerm);
            
            // Cari yang cocok di nama, brand, atau tipe
            return nameMatch || brandMatch || typeMatch;
        });

        // Render ulang kartu berdasarkan hasil pencarian
        renderMotorCards(filteredMotors);

        // Tampilkan pesan "Tidak Ditemukan" jika hasil kosong
        if (filteredMotors.length === 0) {
            noResultsMessage.style.display = 'block';
        } else {
            noResultsMessage.style.display = 'none';
        }
    });

    // AUTO SCROLL SAAT TEKAN ENTER DI SEARCH
    motorSearchInput.addEventListener('keydown', function (e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            const firstCard = document.querySelector('.motor-card');
            if (firstCard) {
                firstCard.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        }
    });

    // --- 6. NAVIGASI & FILTER (PENTING) ---
    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            filterButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
            const filter = this.getAttribute('data-filter');
            const filtered = filter === 'all' ? motors : motors.filter(m => m.brand === filter || m.type.includes(filter));
            renderMotorCards(filtered);
        });
    });


    function displayPaymentInstruction(method, total) {
        const area = document.getElementById('instructionArea'); // pastikan ID ini ada di HTML
        if (area) {
            area.innerHTML = `Metode: ${method} - Total: Rp ${total.toLocaleString()}`;
        }
    }

    // Jalankan Inisialisasi
    initializeMotors();
});