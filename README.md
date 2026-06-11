# Aplikasi Pencatatan Keuangan Pribadi Laravel

## Deskripsi Project

Project ini adalah aplikasi pencatatan keuangan pribadi berbasis Laravel yang digunakan untuk mencatat pemasukan dan pengeluaran.

Aplikasi ini dibuat untuk memenuhi tugas CRUD Laravel dan sudah mendukung:

- CRUD kategori
- CRUD transaksi
- Validasi form
- Dashboard statistik keuangan
- Pencarian data transaksi
- Relasi antar tabel
- Migrasi database
- Tampilan Bootstrap
- Sistem tipe transaksi (Pemasukan & Pengeluaran)

---

# Teknologi yang Digunakan

- PHP 8.1+
- Laravel 10
- MySQL
- Bootstrap 5
- Laragon
- Composer

---

# Fitur Aplikasi

## 1. Dashboard Statistik

Menampilkan:

- Total pemasukan
- Total pengeluaran
- Saldo akhir

---

## 2. Manajemen Kategori

User dapat:

- Menambah kategori
- Mengedit kategori
- Menghapus kategori
- Melihat daftar kategori

Contoh kategori:

- Makanan
- Transportasi
- Gaji
- Hiburan

---

## 3. Manajemen Transaksi

User dapat:

- Menambah transaksi
- Mengedit transaksi
- Menghapus transaksi
- Melihat seluruh transaksi
- Mencari transaksi

Data transaksi meliputi:

- Judul transaksi
- Tipe transaksi
- Nominal
- Kategori
- Tanggal
- Catatan

---

# Struktur Database

## Tabel Categories

| Field      | Type      |
| ---------- | --------- |
| id         | bigint    |
| name       | string    |
| created_at | timestamp |
| updated_at | timestamp |

---

## Tabel Transactions

| Field            | Type      |
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

# Relasi Database

## Category Model

Satu kategori memiliki banyak transaksi.

```php
public function transactions()
{
    return $this->hasMany(Transaction::class);
}
```

---

## Transaction Model

Satu transaksi dimiliki satu kategori.

```php
public function category()
{
    return $this->belongsTo(Category::class);
}
```

---

# Instalasi Project

## 1. Clone Repository

```bash
git clone https://github.com/username/nama-project.git
```

---

## 2. Masuk ke Folder Project

```bash
cd nama-project
```

---

## 3. Install Dependency

```bash
composer install
```

---

## 4. Copy File Environment

```bash
cp .env.example .env
```

---

## 5. Generate Application Key

```bash
php artisan key:generate
```

---

## 6. Atur Database

Edit file `.env`

```env
DB_DATABASE=keuangan_pribadi
DB_USERNAME=root
DB_PASSWORD=
```

---

## 7. Jalankan Migration

```bash
php artisan migrate
```

---

## 8. Jalankan Server Laravel

```bash
php artisan serve
```

---

# Struktur Folder Penting

## Controller

```text
app/Http/Controllers
```

Berisi:

- CategoryController
- TransactionController

---

## Model

```text
app/Models
```

Berisi:

- Category.php
- Transaction.php

---

## View

```text
resources/views
```

Berisi:

- categories
- transactions
- layouts

---

# Route yang Digunakan

```php
Route::resource('categories', CategoryController::class);
Route::resource('transactions', TransactionController::class);
```

---

# Validasi Form

## Contoh Validasi Transaksi

```php
$request->validate([
    'title' => 'required',
    'type' => 'required',
    'amount' => 'required|numeric',
    'category_id' => 'required',
    'transaction_date' => 'required|date'
]);
```

---

# Tampilan Aplikasi

Aplikasi menggunakan:

- Bootstrap Card
- Table Responsive
- Alert Validation
- Form Input Bootstrap
- Badge Status

---

# Progress Project Saat Ini

## Yang Sudah Selesai

✅ Setup Laravel

✅ Koneksi database MySQL

✅ Migration categories

✅ Migration transactions

✅ CRUD kategori

✅ CRUD transaksi

✅ Relasi model

✅ Validasi form

✅ Dashboard statistik

✅ Search transaksi

✅ Penambahan field type pada transaksi

✅ Tampilan Bootstrap

✅ Perbaikan error blade

✅ Perbaikan error controller

✅ Perbaikan error migration

---

# Kendala yang Pernah Diperbaiki

Beberapa error yang sudah diperbaiki:

- Error HTTP 500
- Error undefined variable
- Error validation form
- Error relasi kategori
- Error selected option edit transaksi
- Error migration field baru
- Error syntax Blade
- Error route resource

---

# Cara Penggunaan Aplikasi

## Menambah Kategori

1. Buka menu kategori
2. Klik tambah kategori
3. Isi nama kategori
4. Klik simpan

---

## Menambah Transaksi

1. Buka menu transaksi
2. Klik tambah transaksi
3. Isi data transaksi
4. Pilih tipe transaksi
5. Pilih kategori
6. Klik simpan

---

# Screenshot Fitur

Tambahkan screenshot project di bagian ini.

Contoh:

- Dashboard
- Halaman kategori
- Halaman transaksi
- Form tambah transaksi
- Form edit transaksi

---

# Author

Dibuat menggunakan Laravel untuk tugas CRUD dan pembelajaran framework Laravel.

---

# Lisensi

Project ini SATRIA
