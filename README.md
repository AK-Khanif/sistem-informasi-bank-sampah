# Sistem Informasi Bank Sampah (SIBS)

> Digitalisasi Pengelolaan dan Pencatatan Bank Sampah Berbasis Website

![Status](https://img.shields.io/badge/Status-Development-blue)
![Version](https://img.shields.io/badge/Version-v1.0-green)
![License](https://img.shields.io/badge/License-MIT-yellow)

---

# Tentang Proyek

Sistem Informasi Bank Sampah (SIBS) merupakan aplikasi berbasis web yang dikembangkan untuk mendukung digitalisasi administrasi dan operasional Bank Sampah.

Proyek ini pertama kali diimplementasikan pada Bank Sampah RW 05 Kelurahan Wates, Kecamatan Ngaliyan, Kota Semarang sebagai bagian dari Program Kuliah Kerja Nyata (KKN).

Arsitektur sistem dirancang bersifat **generik**, sehingga dapat digunakan kembali oleh Bank Sampah lain hanya melalui konfigurasi tanpa perlu mengubah source code.

---

# Tujuan

Pengembangan sistem ini bertujuan untuk:

* Menggantikan proses pencatatan manual.
* Mempermudah pengelolaan data Bank Sampah.
* Mempercepat proses transaksi.
* Mengurangi kesalahan pencatatan.
* Menghasilkan laporan operasional secara otomatis.
* Menjadi fondasi pengembangan sistem akuntansi pada versi berikutnya.

---

# Ruang Lingkup Release 1.0

Fitur yang termasuk pada Release 1.0:

## Autentikasi

* Login
* Logout
* Profil Pengguna
* Ganti Password

## Dashboard

* Ringkasan Data
* Statistik
* Grafik

## Master Data

* Nasabah
* Petugas
* Jenis Sampah
* Harga Sampah
* Pengepul

## Operasional

* Transaksi Setor Sampah
* Penjualan Sampah
* Kas
* Activity Log

## Laporan

* Laporan Transaksi
* Laporan Penjualan
* Laporan Kas
* Export PDF
* Export Excel

---

# Teknologi

## Backend

* Laravel (versi stabil yang digunakan proyek)
* PHP 8.4+

## Frontend

* Blade
* Livewire 3
* Tailwind CSS
* Alpine.js

## Database

* MySQL 8+

## Development Tools

* Composer
* Node.js
* NPM
* Git
* OpenCode

---

# Struktur Repository

```text
.
├── docs/                  # Dokumentasi proyek
├── .opencode/             # Konfigurasi OpenCode
├── laravel/               # Source code aplikasi
├── README.md
├── AGENTS.md
├── TASKS.md
├── LICENSE
├── .editorconfig
└── .gitignore
```

---

# Dokumentasi

Seluruh dokumentasi proyek berada pada folder **docs/**.

| Dokumen                        | Deskripsi                    |
| ------------------------------ | ---------------------------- |
| PROJECT_CONSTITUTION           | Prinsip dan aturan proyek    |
| 00_SURVEY                      | Hasil survei lapangan        |
| 01_PRD                         | Product Requirement Document |
| 02_TECH_STACK                  | Teknologi yang digunakan     |
| 03_BUSINESS_DOMAIN             | Domain bisnis                |
| 04_FUNCTIONAL_REQUIREMENTS     | Kebutuhan fungsional         |
| 05_BUSINESS_RULES              | Aturan bisnis                |
| 06_NON_FUNCTIONAL_REQUIREMENTS | Kebutuhan nonfungsional      |

---

# Prinsip Pengembangan

Proyek dikembangkan dengan prinsip:

* Business First
* Clean Architecture
* Clean Code
* SOLID
* DRY
* KISS
* Convention over Configuration
* Documentation Driven Development

---

# Arsitektur

* MVC
* Service Layer
* Form Request Validation
* Policy Authorization
* UUID
* Soft Delete
* Activity Log

---

# Roadmap

## Release 1.0

Digitalisasi operasional Bank Sampah.

## Release 1.1

Integrasi Modul Akuntansi:

* Chart of Accounts (COA)
* Jurnal Umum
* Buku Besar
* Neraca Saldo
* Laporan Laba Rugi
* Laporan Arus Kas
* Neraca

## Release 2.0

* Multi Bank Sampah
* QR Code
* Mobile Application
* Dashboard Analitik

---

# Tim Pengembang

## Project Lead

**Awwalul Khorul Khanif**

Program Studi Teknik Informatika

Universitas Semarang

## Business Analyst

**Revi**

Program Studi Akuntansi

Universitas Semarang

---

# Lisensi

Proyek ini menggunakan lisensi **MIT License**.

---

# Status Proyek

🚧 Dalam Tahap Pengembangan (Development)

---

# Kontribusi

Selama fase KKN, seluruh pengembangan mengikuti standar proyek yang ditetapkan pada:

* AGENTS.md
* TASKS.md
* Folder docs/
* Folder .opencode/skills/

---

# Visi Jangka Panjang

Sistem ini dikembangkan bukan hanya untuk Bank Sampah RW 05 Kelurahan Wates, tetapi sebagai fondasi **platform Sistem Informasi Bank Sampah** yang dapat digunakan oleh berbagai RW, kelurahan, maupun komunitas pengelola sampah di Indonesia.