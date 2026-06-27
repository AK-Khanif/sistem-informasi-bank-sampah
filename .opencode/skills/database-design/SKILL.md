# Database Design Skill

## Tujuan

Skill ini menjadi standar perancangan dan implementasi database untuk Sistem Informasi Bank Sampah (SIBS).

Seluruh migration, relasi Eloquent, foreign key, index, dan struktur tabel harus mengikuti skill ini.

---

# Kapan Skill Ini Digunakan

Gunakan skill ini ketika:

* Membuat migration baru
* Memodifikasi tabel
* Menambahkan relasi
* Menambahkan index
* Membuat foreign key
* Mendesain tabel baru
* Membuat model yang berhubungan dengan database

---

# Sumber Kebenaran (Source of Truth)

Sebelum membuat migration, AI wajib membaca dokumen berikut:

1. docs/09_DATA_DICTIONARY.md
2. docs/07_DATABASE_DESIGN.md
3. docs/08_ERD.md

Migration tidak boleh dibuat berdasarkan asumsi.

---

# Prinsip Database

Database mengikuti prinsip:

* Third Normal Form (3NF)
* Referential Integrity
* Single Source of Truth
* Auditability
* Scalability
* Maintainability

---

# Struktur Migration

Kelompokkan migration berdasarkan domain.

```text
database/
└── migrations/
    ├── system/
    ├── master/
    └── transaction/
```

Jangan mencampur migration tanpa kategori.

---

# Primary Key

Seluruh tabel menggunakan UUID.

Contoh:

```php
$table->uuid('id')->primary();
```

Model wajib menggunakan UUID sebagai primary key.

---

# Foreign Key

Seluruh relasi menggunakan foreign key.

Contoh:

```php
$table->foreignUuid('customer_id')
      ->constrained()
      ->cascadeOnUpdate()
      ->restrictOnDelete();
```

Jangan menyimpan relasi tanpa constraint.

---

# Soft Delete

Gunakan Soft Delete hanya pada tabel master.

Contoh:

* customers
* collectors
* waste_categories
* waste_types
* waste_prices

Jangan menggunakan Soft Delete pada tabel transaksi.

---

# Timestamp

Seluruh tabel wajib menggunakan:

```php
$table->timestamps();
```

---

# Index

Buat index pada:

* seluruh foreign key
* kode unik (customer_code, collector_code)
* nomor transaksi
* tanggal transaksi
* kolom yang sering digunakan untuk pencarian

Hindari membuat index yang tidak digunakan.

---

# Penamaan Tabel

Gunakan:

* Bahasa Inggris
* snake_case
* plural

Contoh:

* customers
* waste_types
* cash_transactions

---

# Penamaan Kolom

Gunakan:

* snake_case
* deskriptif
* konsisten

Contoh:

* customer_id
* waste_type_id
* total_amount
* price_snapshot

Hindari singkatan yang tidak jelas.

---

# Snapshot Data

Jika suatu nilai dapat berubah di masa depan tetapi harus tetap sama pada histori transaksi, simpan sebagai snapshot.

Contoh:

* price_snapshot
* unit_name_snapshot (jika suatu saat dibutuhkan)

Jangan mengambil harga lama dari tabel master ketika menampilkan histori.

---

# Header–Detail Pattern

Gunakan pola Header–Detail untuk transaksi.

Contoh:

* deposits → deposit_items
* sales → sale_items

Jangan menyimpan beberapa item transaksi dalam satu kolom.

---

# Constraint

Gunakan:

* UNIQUE untuk kode unik
* FOREIGN KEY untuk relasi
* NOT NULL jika kolom wajib diisi

Gunakan CHECK constraint jika didukung dan benar-benar diperlukan.

---

# Enum

Gunakan enum hanya untuk nilai yang stabil.

Contoh:

* gender
* cash_type

Jika daftar nilai dapat berubah oleh pengguna, gunakan tabel master.

---

# Decimal

Untuk berat dan nilai uang:

```php
decimal(15,2)
```

Hindari penggunaan float untuk data keuangan.

---

# Audit Trail

Tabel transaksi yang memerlukan jejak pengguna dapat memiliki:

* created_by
* updated_by

Keduanya mengacu ke tabel `users`.

---

# Strategi Penghapusan

Master Data:

* Soft Delete

Transaksi:

* Tidak boleh dihapus
* Koreksi dilakukan melalui transaksi pembatalan atau mekanisme bisnis yang disepakati

---

# Relasi Eloquent

Gunakan relasi Eloquent.

Contoh:

* belongsTo
* hasMany
* hasOne

Hindari query join manual jika relasi Eloquent sudah memadai.

---

# Migration Order

Urutan migration harus memperhatikan dependency.

Contoh:

1. users
2. customers
3. collectors
4. waste_categories
5. waste_types
6. waste_prices
7. deposits
8. deposit_items
9. sales
10. sale_items
11. cash_transactions
12. settings

Foreign key tidak boleh mengacu ke tabel yang belum dibuat.

---

# Hal yang Dilarang

AI tidak boleh:

* Menggunakan auto increment sebagai primary key.
* Menghapus foreign key tanpa alasan.
* Menyimpan data yang dapat dihitung ulang (misalnya saldo berjalan).
* Menyimpan JSON jika struktur datanya relasional.
* Menggunakan nama tabel atau kolom yang tidak konsisten dengan Data Dictionary.

---

# Checklist Sebelum Menyelesaikan Migration

* Sudah mengacu pada Data Dictionary.
* UUID digunakan sebagai primary key.
* Foreign key sudah dibuat.
* Index sudah ditambahkan.
* Soft Delete hanya pada tabel master.
* Header–Detail Pattern diterapkan bila diperlukan.
* Snapshot diterapkan pada histori transaksi.
* Migration dapat dijalankan tanpa error.