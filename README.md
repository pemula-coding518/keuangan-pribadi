# 💰 Aplikasi Pencatatan Keuangan Pribadi

Aplikasi pencatatan keuangan pribadi berbasis **Laravel 10** yang digunakan untuk mengelola pemasukan dan pengeluaran sehari-hari secara sederhana, rapi, dan terstruktur.

Project ini dibuat sebagai media pembelajaran Laravel sekaligus implementasi konsep **CRUD (Create, Read, Update, Delete)**, relasi database, validasi form, dan dashboard statistik keuangan.

---

## ✨ Fitur Utama

### 📊 Dashboard Statistik

Menampilkan ringkasan kondisi keuangan pengguna:

* Total Pemasukan
* Total Pengeluaran
* Saldo Akhir

### 📂 Manajemen Kategori

Pengelolaan kategori transaksi meliputi:

* Tambah kategori
* Edit kategori
* Hapus kategori
* Lihat daftar kategori

Contoh kategori:

* Gaji
* Makanan
* Transportasi
* Hiburan
* Belanja

### 💸 Manajemen Transaksi

Pengelolaan data transaksi meliputi:

* Tambah transaksi
* Edit transaksi
* Hapus transaksi
* Lihat daftar transaksi
* Pencarian transaksi

Informasi transaksi yang disimpan:

* Judul Transaksi
* Jenis Transaksi (Pemasukan/Pengeluaran)
* Nominal
* Kategori
* Tanggal Transaksi
* Catatan

### ✅ Validasi Form

Setiap form dilengkapi validasi untuk menjaga integritas data.

### 🔍 Fitur Pencarian

Memudahkan pengguna mencari transaksi berdasarkan kata kunci tertentu.

---

## 🛠️ Teknologi yang Digunakan

* PHP 8.1+
* Laravel 10
* MySQL
* Bootstrap 5
* Composer
* Laragon

---

## 🗄️ Struktur Database

### Tabel Categories

| Field      | Tipe      |
| ---------- | --------- |
| id         | bigint    |
| name       | string    |
| created_at | timestamp |
| updated_at | timestamp |

### Tabel Transactions

| Field            | Tipe      |
| ---------------- | --------- |
| id               | bigint    |
| title            | string    |
| type             | string    |
| amount           | decimal   |
| category_id      | foreignId |
| transaction_date | date      |
| note             | text      |
| created_at       | timestamp |
| updated_at       | timestamp |

---

## 🔗 Relasi Database

### Category Model

Satu kategori dapat memiliki banyak transaksi.

```php
public function transactions()
{
    return $this->hasMany(Transaction::class);
}
```

### Transaction Model

Satu transaksi hanya dimiliki oleh satu kategori.

```php
public function category()
{
    return $this->belongsTo(Category::class);
}
```

---

## 🚀 Instalasi Project

### 1. Clone Repository

```bash
git clone https://github.com/pemula-coding518/keuangan-pribadi
```

### 2. Masuk ke Folder Project

```bash
cd nama-project
```

### 3. Install Dependency

```bash
composer install
```

### 4. Salin File Environment

```bash
cp .env.example .env
```

### 5. Generate Application Key

```bash
php artisan key:generate
```

### 6. Konfigurasi Database

Edit file `.env`

```env
DB_DATABASE=keuangan_pribadi
DB_USERNAME=root
DB_PASSWORD=
```

### 7. Jalankan Migration

```bash
php artisan migrate
```

### 8. (Opsional) Jalankan Seeder

```bash
php artisan db:seed
```

### 9. Jalankan Server

```bash
php artisan serve
```

Aplikasi dapat diakses melalui:

```text
http://127.0.0.1:8000
```

---

## 📁 Struktur Folder

```text
app
├── Http
│   └── Controllers
│       ├── CategoryController.php
│       └── TransactionController.php

app
└── Models
    ├── Category.php
    └── Transaction.php

resources
└── views
    ├── categories
    ├── transactions
    └── layouts
```

---

## 🛣️ Routes

```php
Route::resource('categories', CategoryController::class);
Route::resource('transactions', TransactionController::class);
```

---

## 🖼️ Tampilan Aplikasi

Aplikasi menggunakan komponen Bootstrap 5 seperti:

* Responsive Table
* Card Layout
* Alert Validation
* Badge Status
* Pagination
* Form Validation

---

## 📸 Screenshot

Tambahkan screenshot aplikasi pada bagian berikut:

### Dashboard

![Dashboard](screenshots/dashboard.png)

### Halaman Kategori

![Kategori](screenshots/categories.png)

### Halaman Transaksi

![Transaksi](screenshots/transactions.png)

### Form Tambah Transaksi

![Tambah Transaksi](screenshots/create-transaction.png)

---

## 📚 Pembelajaran yang Diterapkan

Project ini mengimplementasikan beberapa konsep Laravel:

* Routing
* Controller
* Model Eloquent
* Migration
* Seeder
* Validation
* Relationship
* Blade Template Engine
* Pagination
* Query Builder
* Resource Controller

---

## 👨‍💻 Author

**Satria**

Project ini dibuat sebagai bagian dari pembelajaran framework Laravel dan implementasi aplikasi pencatatan keuangan pribadi.

---

## 📄 License

Project ini dibuat untuk tujuan pembelajaran dan pengembangan kemampuan dalam menggunakan Laravel.
