# 07_DATABASE_DESIGN.md

# Database Design

## Sistem Informasi Bank Sampah (SIBS)

Versi : 1.0

Status : Draft Final

---

# 1. Tujuan

Dokumen ini menjadi acuan utama dalam perancangan database Sistem Informasi Bank Sampah (SIBS).

Seluruh migration, model, relasi database, dan implementasi aplikasi wajib mengikuti dokumen ini.

---

# 2. Tujuan Perancangan Database

Database dirancang agar:

* Mendukung seluruh proses bisnis Bank Sampah.
* Menjamin integritas data.
* Meminimalkan redundansi data.
* Mudah dikembangkan.
* Mendukung audit data.
* Mendukung pengembangan multi Bank Sampah pada versi berikutnya.

---

# 3. Prinsip Perancangan

Database mengikuti prinsip:

* Third Normal Form (3NF)
* Referential Integrity
* Single Source of Truth
* Auditability
* Scalability
* Maintainability

---

# 4. Konvensi Penamaan

## Nama Tabel

* Menggunakan Bahasa Inggris.
* Menggunakan bentuk jamak (plural).
* Menggunakan snake_case.

Contoh:

* users
* customers
* waste_types
* waste_prices

---

## Nama Kolom

Menggunakan snake_case.

Contoh:

* customer_id
* waste_type_id
* total_amount

---

# 5. Primary Key

Seluruh tabel menggunakan:

UUID

Contoh:

id (UUID)

Keuntungan:

* Sulit ditebak.
* Aman untuk publik.
* Siap untuk sistem multi RW.

---

# 6. Timestamp

Semua tabel memiliki:

* created_at
* updated_at

Menggunakan timezone Asia/Jakarta.

---

# 7. Soft Delete

Soft Delete hanya digunakan pada tabel master.

Meliputi:

* customers
* collectors
* waste_categories
* waste_types
* waste_prices

Tabel transaksi tidak menggunakan Soft Delete.

---

# 8. Audit Trail

Seluruh tabel transaksi memiliki:

* created_by
* updated_by

Tujuan:

* Mengetahui petugas yang melakukan transaksi.
* Mendukung audit operasional.

---

# 9. Struktur Entitas

## 9.1 System

### users

Menyimpan akun pengguna.

### roles

Role pengguna.

Menggunakan package Spatie Permission.

### permissions

Permission pengguna.

Menggunakan package Spatie Permission.

---

## 9.2 Master

### customers

Menyimpan data nasabah Bank Sampah.

---

### waste_categories

Kategori sampah.

Contoh:

* Plastik
* Kertas
* Logam
* Kaca

---

### waste_types

Jenis sampah.

Contoh:

Botol PET

berada pada kategori

Plastik.

---

### waste_prices

Riwayat harga beli per jenis sampah.

Harga bersifat historis sehingga dapat berubah tanpa mengubah transaksi sebelumnya.

---

### collectors

Data pengepul.

---

## 9.3 Transaction

### deposits

Header transaksi setor sampah.

Satu transaksi dimiliki oleh satu nasabah.

Satu transaksi memiliki banyak detail.

---

### deposit_items

Detail sampah yang disetorkan.

Menyimpan:

* jenis sampah
* berat
* harga snapshot
* subtotal

---

### sales

Header penjualan kepada pengepul.

---

### sale_items

Detail penjualan.

Menyimpan:

* jenis sampah
* berat
* harga snapshot
* subtotal

---

### cash_transactions

Seluruh transaksi kas.

Meliputi:

* Kas Masuk
* Kas Keluar

---

# 10. Header Detail Pattern

Seluruh transaksi menggunakan pola Header–Detail.

Contoh:

deposits

↓

deposit_items

sales

↓

sale_items

Keuntungan:

* Data lebih terstruktur.
* Mudah dikembangkan.
* Mendukung transaksi dengan banyak item.

---

# 11. Snapshot Harga

Harga disimpan pada tabel detail transaksi.

Contoh:

deposit_items

* price_snapshot

sale_items

* price_snapshot

Tujuan:

Perubahan harga tidak memengaruhi transaksi lama.

---

# 12. Strategi Relasi

Relasi utama:

Customer

1 → N

Deposits

Deposits

1 → N

Deposit Items

Waste Categories

1 → N

Waste Types

Waste Types

1 → N

Waste Prices

Collectors

1 → N

Sales

Sales

1 → N

Sale Items

---

# 13. Strategi Foreign Key

Seluruh relasi menggunakan Foreign Key.

Tidak diperbolehkan menyimpan relasi tanpa constraint.

---

# 14. Strategi Index

Index wajib dibuat pada:

* seluruh foreign key
* kode nasabah
* tanggal transaksi
* nomor transaksi
* jenis sampah

Tujuan:

* mempercepat pencarian
* mempercepat laporan
* mempercepat dashboard

---

# 15. Strategi Penghapusan Data

Master Data

→ Soft Delete

Transaksi

→ Tidak boleh dihapus

Jika terjadi kesalahan transaksi, dilakukan pembatalan atau koreksi sesuai prosedur bisnis, bukan menghapus data.

---

# 16. Strategi Backup

Backup database dilakukan secara berkala.

Minimal:

* Backup Harian
* Backup Mingguan

Backup disimpan pada media yang berbeda dari server aplikasi.

---

# 17. Release 1.0

Tabel yang akan dibangun:

1. users
2. customers
3. waste_categories
4. waste_types
5. waste_prices
6. collectors
7. deposits
8. deposit_items
9. sales
10. sale_items
11. cash_transactions

Tabel roles dan permissions akan disediakan oleh package Spatie Permission.

---

# 18. Ruang Lingkup

Dokumen ini hanya mencakup Release 1.0.

Fitur berikut belum termasuk:

* Chart of Accounts (COA)
* General Journal
* Ledger
* Trial Balance
* Income Statement
* Cash Flow Statement
* Balance Sheet

Seluruh modul akuntansi akan dirancang pada Release 1.1.

---

# 19. Persetujuan Arsitektur

Dokumen ini menjadi acuan resmi sebelum pembuatan:

* Entity Relationship Diagram (ERD)
* Data Dictionary
* Migration Laravel
* Model Eloquent
* Seeder
* Factory
* API
* Feature Test

Perubahan terhadap struktur database harus dilakukan melalui revisi dokumen ini terlebih dahulu sebelum implementasi kode.