# 03_BUSINESS_DOMAIN.md

# Business Domain

## Sistem Informasi Bank Sampah RW 05 Kelurahan Wates

Version : 1.0

---

# 1. Purpose

Dokumen ini menjelaskan pengetahuan bisnis (Business Knowledge) mengenai operasional Bank Sampah RW 05 Kelurahan Wates.

Dokumen ini menjadi referensi utama bagi seluruh proses analisis, desain sistem, implementasi, pengujian, serta pengembangan aplikasi.

Semua keputusan teknis harus mengikuti aturan bisnis yang dijelaskan pada dokumen ini.

---

# 2. Business Overview

Bank Sampah RW 05 merupakan kegiatan pengelolaan sampah berbasis masyarakat yang bertujuan mengurangi volume sampah melalui proses pemilahan, penimbangan, pencatatan, dan penjualan sampah kepada pengepul.

Kegiatan dilaksanakan secara rutin satu kali setiap bulan di Balai RW 05.

---

# 3. Business Objectives

Tujuan utama kegiatan Bank Sampah:

* Mengurangi praktik Open Dumping.
* Meningkatkan kepedulian masyarakat terhadap lingkungan.
* Mengelola sampah secara bernilai ekonomis.
* Mendukung administrasi Bank Sampah yang tertib.
* Meningkatkan transparansi pengelolaan keuangan.

---

# 4. Stakeholders

## Ketua RW

Pengambil keputusan.

Menyetujui laporan.

---

## Kader Bank Sampah

Operator utama sistem.

Melaksanakan seluruh kegiatan operasional.

---

## Petugas Administrasi

Menginput data.

Mengelola transaksi.

Mengelola laporan.

---

## Warga (Nasabah)

Menyetorkan sampah.

---

## Pengepul

Membeli sampah hasil pemilahan.

---

# 5. Core Business Objects

Objek utama dalam sistem:

* Nasabah
* Petugas
* Jenis Sampah
* Harga Sampah
* Transaksi Setor
* Detail Transaksi
* Penjualan Sampah
* Pengepul
* Kas
* Laporan

---

# 6. Business Terminology

## Nasabah

Warga RW 05 yang terdaftar sebagai peserta Bank Sampah dan melakukan penyetoran sampah.

---

## Setor Sampah

Kegiatan penyerahan sampah dari nasabah kepada petugas Bank Sampah.

---

## Jenis Sampah

Kategori sampah yang memiliki harga beli atau nilai ekonomi berbeda.

Contoh:

* Plastik
* Kertas
* Kardus
* Logam
* Botol

---

## Harga Sampah

Nilai rupiah per satuan berat untuk setiap jenis sampah yang berlaku pada periode tertentu.

---

## Penimbangan

Proses mengukur berat sampah menggunakan timbangan.

---

## Penjualan Sampah

Proses penjualan sampah yang telah dipilah kepada pengepul.

---

## Kas

Pencatatan pemasukan dan pengeluaran dana operasional Bank Sampah.

---

# 7. Business Workflow

Alur operasional saat ini:

1. Warga mengumpulkan sampah.
2. Warga datang ke Balai RW.
3. Petugas menerima sampah.
4. Sampah dipilah.
5. Sampah ditimbang.
6. Data transaksi dicatat.
7. Sampah dikumpulkan.
8. Sampah dijual ke pengepul.
9. Hasil penjualan dicatat.
10. Dana digunakan sesuai kebijakan RW.

---

# 8. Business Events

Peristiwa utama yang terjadi dalam sistem:

* Nasabah didaftarkan.
* Harga sampah diperbarui.
* Transaksi setor dibuat.
* Penjualan sampah dilakukan.
* Kas bertambah.
* Kas berkurang.
* Laporan dibuat.

---

# 9. Business Constraints

* Kegiatan Bank Sampah dilaksanakan satu kali setiap bulan.
* Harga sampah dapat berubah sewaktu-waktu.
* Pengguna utama bukan tenaga IT.
* Sistem harus mudah dipelajari.
* Sistem harus tetap dapat digunakan meskipun jumlah transaksi bertambah.

---

# 10. Future Business

Pengembangan di masa depan dapat mencakup:

* Tabungan nasabah.
* Modul akuntansi (COA, Jurnal, Buku Besar, Arus Kas, Laba Rugi).
* QR Code anggota.
* Integrasi pembayaran digital.
* Dashboard publik.
* Multi RW.
* Multi Bank Sampah.