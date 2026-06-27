# Frontend Livewire Skill

## Tujuan

Skill ini menjadi standar resmi pengembangan Frontend menggunakan Laravel Livewire 3 pada Sistem Informasi Bank Sampah (SIBS).

AI wajib menghasilkan antarmuka yang:

* Konsisten
* Responsif
* Mudah digunakan
* Mengikuti standar Laravel
* Mengikuti Business Rules Bank Sampah

---

# Kapan Skill Digunakan

Gunakan skill ini ketika membuat:

* Dashboard
* CRUD Master Data
* Transaksi
* Laporan
* Pengaturan
* Widget Dashboard
* Livewire Component
* Blade View

---

# Prinsip Pengembangan

Frontend wajib mengikuti prinsip:

* Simplicity First
* Mobile Friendly
* Accessibility
* Consistency
* Reusable Component
* Business Driven UI

Pengguna utama adalah kader Bank Sampah, sehingga tampilan harus sederhana dan mudah dipahami.

---

# Arsitektur

Alur implementasi:

```text
Blade Layout
      ↓
Livewire Component
      ↓
Service
      ↓
Model
```

Business logic tidak boleh berada di Blade maupun Livewire Component.

---

# Struktur Folder

```text
app/
└── Livewire/
    ├── Dashboard/
    ├── Customers/
    ├── WasteCategories/
    ├── WasteTypes/
    ├── WastePrices/
    ├── Collectors/
    ├── Deposits/
    ├── Sales/
    ├── CashTransactions/
    └── Settings/

resources/
└── views/
    ├── layouts/
    ├── components/
    └── livewire/
```

---

# Layout

Gunakan satu layout utama:

```
resources/views/layouts/app.blade.php
```

Semua halaman menggunakan layout yang sama.

---

# Pola Halaman

Setiap modul memiliki halaman:

* Index
* Create
* Edit
* Show (jika diperlukan)

Contoh:

```text
Customers/

Index

Create

Edit

Show
```

Jangan menggabungkan banyak fungsi dalam satu komponen.

---

# Form

Form wajib:

* Menggunakan Livewire Validation.
* Menampilkan pesan validasi dalam Bahasa Indonesia.
* Menandai field wajib.
* Memiliki tombol Simpan dan Batal.
* Menggunakan loading state saat proses berlangsung.

Form Create/Edit menggunakan halaman penuh, bukan modal.

---

# Tabel

Semua tabel wajib mendukung:

* Pagination
* Pencarian
* Sorting
* Filter (jika diperlukan)

Gunakan eager loading untuk menghindari N+1 Query.

---

# Dashboard

Dashboard minimal menampilkan:

* Total Nasabah
* Total Setoran
* Berat Sampah
* Total Penjualan
* Kas Masuk
* Kas Keluar

Gunakan kartu statistik yang ringkas.

---

# Navigasi

Menu utama:

* Dashboard
* Nasabah
* Jenis Sampah
* Harga Sampah
* Pengepul
* Setoran
* Penjualan
* Kas
* Laporan
* Pengaturan

Menu disesuaikan dengan hak akses pengguna.

---

# UI/UX

Gunakan antarmuka yang bersih.

Standar warna:

* Hijau → Berhasil / Simpan
* Biru → Informasi
* Kuning → Peringatan
* Merah → Kesalahan / Hapus
* Abu-abu → Sekunder

Gunakan ikon yang konsisten untuk setiap aksi.

---

# Bahasa Antarmuka

Seluruh tampilan menggunakan Bahasa Indonesia.

Contoh:

* Simpan
* Batal
* Tambah Data
* Edit
* Hapus
* Detail
* Cari
* Tidak ada data

Jangan menggunakan label bahasa Inggris pada UI.

---

# Format Data

## Tanggal

Gunakan format:

```
11 Juli 2026
```

## Waktu

```
11 Juli 2026 08:30
```

## Berat

```
12,50 kg
```

## Mata Uang

```
Rp 25.000
```

Gunakan format Indonesia pada seluruh tampilan.

---

# Loading State

Gunakan `wire:loading` pada:

* Simpan
* Perbarui
* Hapus
* Filter
* Pencarian

Tampilkan indikator yang jelas selama proses berlangsung.

---

# Notifikasi

Gunakan notifikasi setelah setiap aksi.

Contoh:

* Data berhasil disimpan.
* Data berhasil diperbarui.
* Data berhasil dihapus.
* Data tidak dapat dihapus karena masih digunakan.

---

# Konfirmasi

Konfirmasi diperlukan untuk:

* Soft Delete master data.
* Reset data.
* Logout.

Transaksi operasional tidak boleh dihapus.

---

# Responsif

Aplikasi harus dapat digunakan dengan baik pada:

* Desktop
* Laptop
* Tablet
* Ponsel

Minimal seluruh fungsi utama dapat diakses melalui perangkat seluler.

---

# Naming Convention

## Livewire Component

PascalCase.

Contoh:

* CustomerIndex
* CustomerCreate
* DepositCreate

## Blade View

snake_case.

Contoh:

* customer-index.blade.php
* deposit-create.blade.php

---

# Hal yang Dilarang

AI tidak boleh:

* Menulis query database di Blade.
* Menulis business logic di Livewire Component.
* Menggunakan JavaScript jika fitur sudah tersedia di Livewire.
* Menampilkan seluruh data tanpa pagination.
* Menggunakan modal untuk form transaksi utama.
* Menghapus transaksi operasional.

---

# Definition of Done

Sebuah halaman dianggap selesai jika memiliki:

* Livewire Component
* Blade View
* Validasi
* Loading State
* Notifikasi
* Pagination
* Pencarian
* Responsive Layout
* Menggunakan Service Layer

---

# Checklist

Sebelum menyelesaikan fitur, pastikan:

* Menggunakan layout utama.
* Mengikuti backend-laravel/SKILL.md.
* Mengikuti database-design/SKILL.md.
* Mengikuti bank-sampah-domain/SKILL.md.
* Seluruh teks menggunakan Bahasa Indonesia.
* Format tanggal, angka, dan mata uang menggunakan standar Indonesia.
* Tidak ada business logic di Blade maupun Livewire Component.
* Antarmuka mudah digunakan oleh kader Bank Sampah.