🔗 Deskripsi API PAMSIMAS

API ini merupakan backend dari sistem PAMSIMAS (Pengelolaan Air Minum dan Sanitasi Masyarakat) yang menyediakan layanan untuk mengelola data pelanggan, pencatatan meter air, pembuatan tagihan, pembayaran, serta manajemen kas secara terintegrasi.

API dibangun menggunakan Laravel dan menerapkan konsep RESTful API, sehingga dapat digunakan oleh berbagai frontend seperti React, mobile app, atau sistem lainnya.

⚙️ Fitur API
👥 Pelanggan
CRUD data pelanggan
Digunakan sebagai relasi utama dalam sistem
💧 Meter Air
Input meter air per bulan (periode otomatis)
Validasi:
Tidak bisa input ganda di bulan yang sama
Ambil meter terakhir untuk auto isi meter awal
📄 Tagihan
Generate otomatis dari input meter
Perhitungan:
Pemakaian air
Tarif air
Biaya listrik
Biaya kebersihan
Status:
belum_bayar
lunas
💳 Pembayaran
Update status tagihan menjadi lunas
Otomatis:
Menyimpan ke kas (pemasukan)
Siap untuk cetak struk
💰 Kas
Menyimpan:
Pemasukan (dari pembayaran)
Pengeluaran (manual)
Digunakan untuk laporan keuangan