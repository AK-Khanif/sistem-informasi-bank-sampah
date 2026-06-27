# Testing Skill

## Tujuan

Skill ini menjadi standar pengujian (Testing Standard) untuk Sistem Informasi Bank Sampah (SIBS).

Seluruh fitur yang dikembangkan harus memiliki pengujian yang memadai untuk memastikan kualitas, stabilitas, dan konsistensi sistem.

Testing merupakan bagian dari proses pengembangan, bukan pekerjaan setelah implementasi selesai.

---

# Kapan Skill Digunakan

Gunakan skill ini ketika:

* Membuat fitur baru
* Mengubah business rule
* Mengubah database
* Menambahkan Service
* Menambahkan Livewire Component
* Memperbaiki bug

---

# Prinsip Pengujian

Testing mengikuti prinsip:

* Test Early
* Test Continuously
* Business Driven Testing
* Maintainable Test
* Repeatable Test

---

# Framework

Gunakan framework bawaan Laravel.

* PHPUnit
* Laravel Testing
* Factory
* RefreshDatabase

Jangan menambahkan framework testing lain tanpa alasan yang kuat.

---

# Jenis Pengujian

## Feature Test

Digunakan untuk menguji:

* Authentication
* Authorization
* CRUD
* Validasi
* Business Rule
* Route
* Response

Seluruh fitur utama wajib memiliki Feature Test.

---

## Unit Test

Digunakan untuk menguji:

* Service
* Helper
* Utility
* Perhitungan

Business logic yang kompleks wajib memiliki Unit Test.

---

# Struktur Folder

```text
tests/
├── Feature/
│   ├── Auth/
│   ├── Customers/
│   ├── Deposits/
│   ├── Sales/
│   ├── CashTransactions/
│   └── Settings/
└── Unit/
    ├── Services/
    └── Support/
```

---

# Database Testing

Gunakan:

```php
use RefreshDatabase;
```

Setiap test berjalan pada database yang bersih.

Jangan menggunakan database produksi.

---

# Factory

Gunakan Factory untuk membuat data uji.

Jangan membuat data secara manual jika Factory sudah tersedia.

---

# Seeder

Gunakan Seeder hanya jika memang diperlukan.

Sebagian besar test cukup menggunakan Factory.

---

# Authentication Testing

Uji minimal:

* Login berhasil.
* Login gagal.
* Logout.
* Pengguna belum login tidak dapat mengakses halaman yang dilindungi.

---

# Authorization Testing

Pastikan:

* Admin dapat mengakses fitur sesuai haknya.
* Petugas hanya mengakses fitur yang diizinkan.
* Ketua RW hanya melihat laporan sesuai kebijakan.

Gunakan Policy dan Role yang berlaku.

---

# CRUD Testing

Setiap CRUD minimal memiliki test:

* Create
* Read
* Update
* Delete (Soft Delete untuk master data)

Transaksi operasional tidak diuji dengan hard delete.

---

# Business Rule Testing

Seluruh business rule penting wajib diuji.

Contoh:

* Harga transaksi menggunakan snapshot.
* Transaksi tidak boleh dihapus.
* Total transaksi dihitung dengan benar.
* Header–Detail Pattern berjalan sesuai aturan.

---

# Validation Testing

Pastikan:

* Field wajib tidak boleh kosong.
* Format data sesuai.
* Nilai tidak valid ditolak.
* Pesan validasi tampil dengan benar.

---

# Response Testing

Periksa:

* HTTP Status
* Redirect
* Session
* Validation Error

---

# Performance

Gunakan eager loading jika test menemukan N+1 Query.

Hindari query yang tidak efisien.

---

# Naming Convention

## Feature Test

Nama:

```text
CustomerTest.php
DepositTest.php
SaleTest.php
```

## Unit Test

Nama:

```text
CustomerServiceTest.php
DepositServiceTest.php
```

Nama test harus menjelaskan perilaku yang diuji.

Contoh:

```php
it('can create customer');
it('cannot delete deposit');
```

---

# Coverage Minimum

Target minimum:

* Feature utama memiliki Feature Test.
* Business logic penting memiliki Unit Test.

Prioritaskan kualitas skenario dibanding sekadar mengejar persentase coverage.

---

# Hal yang Dilarang

AI tidak boleh:

* Mengabaikan testing untuk fitur baru.
* Menguji menggunakan database produksi.
* Menggunakan data statis yang sulit dipelihara.
* Membuat test yang bergantung pada urutan eksekusi test lain.

---

# Definition of Done

Sebuah fitur dianggap selesai jika:

* Migration berhasil.
* Model selesai.
* Service selesai.
* Livewire selesai.
* Feature Test berhasil.
* Unit Test (jika diperlukan) berhasil.
* Seluruh test terkait tetap lulus.

---

# Checklist

Sebelum menyelesaikan task, pastikan:

* Feature Test tersedia.
* Unit Test tersedia untuk business logic kompleks.
* Factory digunakan.
* RefreshDatabase digunakan.
* Business Rule telah diuji.
* Validasi telah diuji.
* Authorization telah diuji.
* Tidak ada test yang gagal.