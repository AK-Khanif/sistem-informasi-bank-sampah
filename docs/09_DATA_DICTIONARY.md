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