# 09_DATA_DICTIONARY.md

# Data Dictionary

## Sistem Informasi Bank Sampah (SIBS)

Versi : 1.0

Status : Draft

---

# 1. Tujuan

Dokumen ini mendefinisikan struktur setiap tabel yang digunakan pada Sistem Informasi Bank Sampah.

Dokumen ini menjadi acuan resmi untuk:

* Migration Laravel
* Model Eloquent
* Factory
* Seeder
* Validation
* API Resource

---

# 2. Standar Tabel

Semua tabel mengikuti standar berikut.

| Kolom      | Tipe      | Keterangan       |
| ---------- | --------- | ---------------- |
| id         | UUID      | Primary Key      |
| created_at | Timestamp | Waktu dibuat     |
| updated_at | Timestamp | Waktu diperbarui |

Master data menggunakan:

| Kolom      | Keterangan  |
| ---------- | ----------- |
| deleted_at | Soft Delete |

---

# 3. Tabel users

Digunakan untuk menyimpan akun pengguna sistem.

| Kolom             | Tipe         | Null  | Keterangan           |
| ----------------- | ------------ | ----- | -------------------- |
| id                | UUID         | Tidak | Primary Key          |
| name              | varchar(100) | Tidak | Nama pengguna        |
| email             | varchar(150) | Tidak | Email (unik)         |
| email_verified_at | timestamp    | Ya    | Verifikasi email     |
| password          | varchar(255) | Tidak | Password terenkripsi |
| remember_token    | varchar(100) | Ya    | Remember token       |
| created_at        | timestamp    | Tidak | Waktu dibuat         |
| updated_at        | timestamp    | Tidak | Waktu diperbarui     |

### Constraint

* email UNIQUE

---

# 4. Tabel customers

Menyimpan data nasabah Bank Sampah.

| Kolom         | Tipe         | Null  | Keterangan       |
| ------------- | ------------ | ----- | ---------------- |
| id            | UUID         | Tidak | Primary Key      |
| customer_code | varchar(20)  | Tidak | Kode nasabah     |
| full_name     | varchar(150) | Tidak | Nama lengkap     |
| gender        | enum(L,P)    | Ya    | Jenis kelamin    |
| phone         | varchar(20)  | Ya    | Nomor HP         |
| address       | text         | Ya    | Alamat           |
| is_active     | boolean      | Tidak | Status aktif     |
| created_at    | timestamp    | Tidak | Waktu dibuat     |
| updated_at    | timestamp    | Tidak | Waktu diperbarui |
| deleted_at    | timestamp    | Ya    | Soft Delete      |

### Constraint

* customer_code UNIQUE

### Index

* customer_code
* full_name
* phone

---

# 5. Tabel collectors

Menyimpan data pengepul.

| Kolom          | Tipe         | Null  | Keterangan       |
| -------------- | ------------ | ----- | ---------------- |
| id             | UUID         | Tidak | Primary Key      |
| collector_code | varchar(20)  | Tidak | Kode pengepul    |
| name           | varchar(150) | Tidak | Nama pengepul    |
| phone          | varchar(20)  | Ya    | Nomor HP         |
| address        | text         | Ya    | Alamat           |
| contact_person | varchar(100) | Ya    | Nama PIC         |
| is_active      | boolean      | Tidak | Status aktif     |
| created_at     | timestamp    | Tidak | Waktu dibuat     |
| updated_at     | timestamp    | Tidak | Waktu diperbarui |
| deleted_at     | timestamp    | Ya    | Soft Delete      |

### Constraint

* collector_code UNIQUE

### Index

* collector_code
* name
* phone

---

# 6. Catatan

Seluruh Primary Key menggunakan UUID.

Seluruh master data menggunakan Soft Delete.

Seluruh tabel menggunakan timestamp bawaan Laravel.


---


# 7. Tabel settings

Digunakan untuk menyimpan konfigurasi global aplikasi.

## Tujuan

Tabel ini menyimpan identitas dan konfigurasi Bank Sampah sehingga aplikasi dapat digunakan kembali oleh RW atau wilayah lain tanpa mengubah kode.

---

## Struktur Tabel

| Kolom       | Tipe         | Null  | Keterangan               |
| ----------- | ------------ | ----- | ------------------------ |
| id          | UUID         | Tidak | Primary Key              |
| app_name    | varchar(150) | Tidak | Nama aplikasi            |
| bank_name   | varchar(150) | Tidak | Nama Bank Sampah         |
| rw          | varchar(10)  | Ya    | Nomor RW                 |
| village     | varchar(100) | Ya    | Kelurahan                |
| district    | varchar(100) | Ya    | Kecamatan                |
| city        | varchar(100) | Ya    | Kota                     |
| province    | varchar(100) | Ya    | Provinsi                 |
| address     | text         | Ya    | Alamat lengkap           |
| phone       | varchar(20)  | Ya    | Nomor telepon            |
| email       | varchar(150) | Ya    | Email resmi              |
| logo        | varchar(255) | Ya    | Lokasi file logo         |
| description | text         | Ya    | Deskripsi singkat        |
| is_active   | boolean      | Tidak | Status konfigurasi aktif |
| created_at  | timestamp    | Tidak | Waktu dibuat             |
| updated_at  | timestamp    | Tidak | Waktu diperbarui         |

---

## Constraint

* Primary Key menggunakan UUID.
* Hanya boleh terdapat **satu konfigurasi aktif** (`is_active = true`).

---

## Index

* is_active

---

## Business Rules

* Sistem membaca konfigurasi dari record yang aktif.
* Konfigurasi dapat diperbarui tanpa mengubah kode aplikasi.
* Tidak menggunakan Soft Delete.
* Tidak memiliki foreign key ke tabel lain.

---

## Catatan Implementasi

Pada Release 1.0, tabel ini diperlakukan sebagai **singleton configuration** (satu konfigurasi aplikasi). Jika di masa depan sistem mendukung multi-RW atau multi-cabang, struktur ini masih dapat dikembangkan tanpa mengubah modul transaksi.