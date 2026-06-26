# Keuangan Pribadi

Aplikasi manajemen keuangan pribadi berbasis web yang dibangun menggunakan Laravel. Dirancang dengan antarmuka premium dark navy untuk memudahkan pencatatan, pemantauan, dan analisis keuangan sehari-hari secara efisien.

---

## Daftar Isi

- [Tentang Aplikasi](#tentang-aplikasi)
- [Fitur](#fitur)
- [Teknologi yang Digunakan](#teknologi-yang-digunakan)
- [Sistem Desain](#sistem-desain)
- [Persyaratan Sistem](#persyaratan-sistem)
- [Instalasi](#instalasi)
- [Konfigurasi](#konfigurasi)
- [Menjalankan Aplikasi](#menjalankan-aplikasi)
- [Penggunaan](#penggunaan)
- [Struktur Proyek](#struktur-proyek)
- [Lisensi](#lisensi)

---

## Tentang Aplikasi

Keuangan Pribadi adalah aplikasi web full-stack yang membantu pengguna mencatat pemasukan dan pengeluaran, mengelola kategori transaksi, serta memantau kondisi keuangan melalui dashboard interaktif. Aplikasi ini dikembangkan secara lokal menggunakan Laragon dan dirancang dengan pendekatan premium UI yang bersih dan modern.

---

## Fitur

### Dashboard
- Ringkasan saldo total, total pemasukan, dan total pengeluaran
- Grafik pemasukan vs pengeluaran bulanan (line chart)
- Grafik distribusi pengeluaran per kategori (pie/doughnut chart)
- Layout grafik menggunakan CSS Grid (`.charts-row`) agar responsif dan simetris

### Manajemen Transaksi
- Tambah, lihat, edit, dan hapus transaksi (CRUD penuh)
- Tipe transaksi: Pemasukan dan Pengeluaran
- Field transaksi: tanggal, jumlah, kategori, deskripsi
- Riwayat transaksi dengan filter dan pengurutan

### Manajemen Kategori
- Tambah, edit, dan hapus kategori transaksi
- Kategori dapat dibuat otomatis saat proses import CSV apabila kategori belum tersedia

### Import CSV
- Upload file CSV untuk impor transaksi secara massal
- Pemetaan header fleksibel dengan sinonim (mendukung berbagai format header CSV)
- Konversi tipe transaksi otomatis: mendukung label bahasa Indonesia (`pemasukan`, `pengeluaran`) maupun bahasa Inggris (`income`, `expense`)
- Validasi data per baris sebelum disimpan
- Proses import bersifat atomik menggunakan transaksi database — jika ada satu baris gagal, seluruh import dibatalkan
- Opsi auto-create kategori baru apabila nama kategori pada CSV belum terdaftar

### Ekspor CSV
- Ekspor seluruh riwayat transaksi ke format CSV
- Kolom ekspor mencakup: tanggal, jumlah, tipe, kategori, dan deskripsi

### Autentikasi
- Sistem login dan logout pengguna
- Proteksi halaman menggunakan middleware autentikasi Laravel

### Navigasi
- Sidebar tetap di sisi kiri layar
- Akses cepat ke semua modul: Dashboard, Transaksi, Kategori, Import, Ekspor

---

## Teknologi yang Digunakan

| Komponen        | Teknologi                          |
|-----------------|------------------------------------|
| Framework       | Laravel (PHP)                      |
| Templating      | Blade                              |
| Database        | MySQL                              |
| Manajemen DB    | phpMyAdmin (via Laragon)           |
| Build Tool      | Vite                               |
| CSS Framework   | Bootstrap 5 (CDN)                  |
| Ikon            | Tabler Icons                       |
| Tipografi       | Fraunces (heading), Inter (body)   |
| Lingkungan Dev  | Laragon                            |

---

## Sistem Desain

Aplikasi ini menggunakan sistem desain premium dengan palet warna dark navy sebagai berikut:

```css
--color-bg-primary:    #0a0f1e;   /* Latar halaman utama */
--color-bg-secondary:  #0d1526;   /* Latar sidebar */
--color-bg-card:       #111827;   /* Latar kartu */
--color-bg-card-hover: #1a2235;   /* Kartu saat hover */
--color-accent:        #4f8ef7;   /* Aksen biru premium */
--color-accent-hover:  #3a7ae8;
--color-income:        #22c55e;   /* Hijau pemasukan */
--color-expense:       #ef4444;   /* Merah pengeluaran */
--color-text-primary:  #f1f5f9;
--color-text-secondary:#94a3b8;
--color-text-muted:    #64748b;
--color-border:        #1e293b;
```

Kartu menggunakan efek glassmorphism dengan `backdrop-filter: blur()` dan `border` transparan untuk kesan kedalaman visual. Seluruh variabel warna didefinisikan menggunakan CSS Custom Properties agar mudah dikustomisasi.

---

## Persyaratan Sistem

- PHP >= 8.1
- Composer
- Node.js >= 18 dan npm
- MySQL >= 5.7
- Laragon (untuk lingkungan pengembangan lokal)

---

## Instalasi

### 1. Clone Repository

```bash
git clone https://github.com/pemula-coding518/keuangan-pribadi.git
cd keuangan-pribadi
```

### 2. Install Dependensi PHP

```bash
composer install
```

### 3. Install Dependensi Node

```bash
npm install
```

### 4. Salin File Environment

```bash
cp .env.example .env
```

### 5. Generate Application Key

```bash
php artisan key:generate
```

---

## Konfigurasi

Buka file `.env` dan sesuaikan konfigurasi database:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=keuangan_pribadi
DB_USERNAME=root
DB_PASSWORD=
```

Buat database baru bernama `keuangan_pribadi` melalui phpMyAdmin atau MySQL CLI sebelum menjalankan migrasi.

---

## Menjalankan Aplikasi

### 1. Jalankan Migrasi Database

```bash
php artisan migrate
```

### 2. (Opsional) Jalankan Seeder

```bash
php artisan db:seed
```

### 3. Kompilasi Aset Frontend

Untuk pengembangan dengan hot-reload:

```bash
npm run dev
```

Untuk build produksi:

```bash
npm run build
```

> Catatan: Jika perubahan CSS atau JS tidak langsung terlihat di browser, lakukan hard refresh (`Ctrl + Shift + R`) setelah Vite selesai melakukan recompile.

### 4. Jalankan Server

Laragon secara otomatis melayani aplikasi melalui virtual host. Akses aplikasi di:

```
http://keuangan-pribadi.test
```

Atau menggunakan server bawaan Laravel:

```bash
php artisan serve
```

---

## Penggunaan

### Import CSV

Format CSV yang didukung untuk import transaksi:

```
tanggal,jumlah,tipe,kategori,deskripsi
2025-01-15,150000,pengeluaran,Makan,Makan siang
2025-01-15,3000000,pemasukan,Gaji,Gaji bulanan
```

Kolom yang didukung (sinonim header):

| Kolom    | Sinonim yang Diterima                        |
|----------|----------------------------------------------|
| Tanggal  | `tanggal`, `date`, `tgl`                     |
| Jumlah   | `jumlah`, `amount`, `nominal`                |
| Tipe     | `tipe`, `type`, `jenis`                      |
| Kategori | `kategori`, `category`, `kat`                |
| Deskripsi| `deskripsi`, `description`, `keterangan`, `catatan` |

Nilai kolom `tipe` yang diterima: `pemasukan`, `income`, `pengeluaran`, `expense` (tidak peka huruf besar/kecil).

### Ekspor CSV

Klik tombol ekspor pada halaman Transaksi untuk mengunduh seluruh data transaksi dalam format CSV siap pakai.

---

## Struktur Proyek

```
keuangan-pribadi/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── TransactionController.php   # CRUD, import, ekspor CSV
│   │   │   ├── CategoryController.php
│   │   │   └── DashboardController.php
│   │   └── Middleware/
│   └── Models/
│       ├── Transaction.php
│       └── Category.php
├── database/
│   └── migrations/
├── resources/
│   ├── css/
│   │   └── app.css                         # Sistem desain & CSS custom properties
│   ├── js/
│   │   └── app.js
│   └── views/
│       ├── layouts/
│       │   └── app.blade.php               # Layout utama dengan sidebar
│       ├── dashboard/
│       ├── transactions/
│       └── categories/
├── routes/
│   └── web.php
├── public/
├── vite.config.js
└── .env
```

---

## Catatan Pengembangan

Beberapa isu yang telah diselesaikan selama proses pengembangan:

- Field `description` ditambahkan ke array `$fillable` pada model `Transaction` agar dapat disimpan melalui mass assignment.
- Referensi kolom pada fungsi ekspor CSV diperbaiki agar merujuk ke nama kolom database yang benar (`type` dan `date`).
- Layout grafik dashboard diperbaiki menggunakan CSS Grid untuk memastikan kedua grafik tampil sejajar dan responsif.
- Masalah Vite yang tidak me-recompile perubahan CSS secara otomatis diatasi dengan melakukan hard refresh browser setelah proses build selesai.
- Proses import CSV dibuat atomik menggunakan `DB::transaction()` untuk menjaga konsistensi data.

---

## Lisensi

Proyek ini dibuat untuk keperluan pembelajaran dan pengembangan pribadi.