# 01_PRD.md

# Product Requirements Document (PRD)

## Sistem Informasi Bank Sampah RW 05 Kelurahan Wates

---

## Document Information

| Item        | Value                               |
| ----------- | ----------------------------------- |
| Project     | Sistem Informasi Bank Sampah RW 05  |
| Version     | 2.0                                 |
| Status      | Final Draft                         |
| Client      | RW 05 Kelurahan Wates               |
| Development | KKN Universitas Semarang            |
| Backend     | Laravel 13                          |
| Frontend    | Blade + Livewire 3 + Tailwind CSS 4 |
| Database    | MySQL 8.4 LTS                       |

---

# 1. Vision

Membangun sistem informasi Bank Sampah yang sederhana, aman, mudah digunakan, dan mampu mendukung digitalisasi administrasi Bank Sampah RW 05 sehingga proses pencatatan, pengelolaan transaksi, pelaporan, dan penyimpanan data menjadi lebih efektif, transparan, dan berkelanjutan.

---

# 2. Background

(Berisi ringkasan hasil survei pada `00_SURVEY.md`, bukan salinan penuh.)

Fokus utama sistem adalah menyelesaikan permasalahan administrasi manual Bank Sampah, bukan seluruh permasalahan lingkungan di RW 05.

---

# 3. Business Problem

* Pencatatan manual menggunakan buku tulis.
* Risiko kehilangan data.
* Kesalahan perhitungan transaksi.
* Sulit mencari histori.
* Laporan dibuat manual.
* Rekap bulanan dan tahunan memerlukan waktu lama.

---

# 4. Project Goals

* Digitalisasi administrasi.
* Perhitungan transaksi otomatis.
* Penyimpanan data terpusat.
* Laporan otomatis.
* Dashboard monitoring.
* Transparansi pengelolaan Bank Sampah.

---

# 5. Success Metrics

* Seluruh transaksi tercatat secara digital.
* Pengurus tidak lagi menggunakan buku tulis sebagai pencatatan utama.
* Waktu penyusunan laporan berkurang secara signifikan.
* Pengurus dapat mengoperasikan sistem secara mandiri.
* Tidak terjadi kehilangan data transaksi selama periode penggunaan.

---

# 6. Stakeholder

## Internal

* Ketua RW
* Pengurus RW
* Kader Bank Sampah
* Administrator

## Eksternal

* Warga
* Pengepul

---

# 7. User Roles

## Super Admin

Mengelola seluruh sistem.

## Admin RW

Mengelola operasional Bank Sampah.

## Petugas

Melakukan transaksi harian.

## Ketua RW

Melihat dashboard dan laporan.

---

# 8. Functional Scope

## Authentication

* Login
* Logout
* Reset Password

## Dashboard

* Statistik
* Grafik
* Ringkasan aktivitas

## Master Data

* Nasabah
* Petugas
* Jenis Sampah
* Harga Sampah
* Pengepul

## Operasional

* Transaksi Setor
* Penjualan Sampah
* Pencatatan Kas
* Riwayat

## Reporting

* Harian
* Bulanan
* Tahunan
* PDF
* Excel

## System

* User
* Role
* Permission
* Backup
* Activity Log

---

# 9. Out of Scope

* Mobile App
* QRIS
* Blockchain
* IoT
* Marketplace Sampah
* Multi RW
* Multi Cabang
* AI Analytics (versi awal)

---

# 10. Non Functional Requirements

## Security

* CSRF
* XSS Protection
* SQL Injection Protection
* RBAC
* Password Hashing
* Audit Log

## Performance

* Response < 3 detik
* Optimized Query
* Lazy Loading
* Pagination

## Reliability

* Backup
* Error Logging
* Database Transaction

## Maintainability

* Clean Architecture
* SOLID
* Repository Pattern
* Service Layer

---

# 11. Constraints

* Pengguna utama bukan tenaga IT.
* Antarmuka harus sederhana.
* Sistem dapat dijalankan pada hosting umum.
* Koneksi internet mungkin tidak selalu stabil.

---

# 12. Future Roadmap

* QR Code Nasabah
* Mobile App
* WhatsApp Notification
* QRIS
* IoT Smart Bin
* Multi Bank Sampah
* Dashboard Publik

---

# 13. Definition of Done

Sistem dinyatakan selesai apabila:

* Semua fitur MVP selesai.
* Seluruh pengujian lulus.
* Dokumentasi lengkap.
* Pengurus berhasil menggunakan sistem.
* Sistem siap diimplementasikan pada Bank Sampah RW 05.