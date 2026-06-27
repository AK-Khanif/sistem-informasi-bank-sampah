# 04_FUNCTIONAL_REQUIREMENTS.md

# Functional Requirements Specification (FRS)

## Sistem Informasi Bank Sampah RW 05 Kelurahan Wates

Version : 1.0

---

# 1. Purpose

Dokumen ini mendefinisikan seluruh kebutuhan fungsional yang harus dipenuhi oleh Sistem Informasi Bank Sampah RW 05.

Seluruh fitur yang dikembangkan harus mengacu pada dokumen ini.

---

# 2. Functional Modules

## Authentication

Kode : AUTH

Fitur:

* Login
* Logout
* Forgot Password (Future)
* Profile

---

## Dashboard

Kode : DASH

Fitur:

* Ringkasan Data
* Statistik
* Grafik
* Aktivitas Terbaru

---

## User Management

Kode : USER

Fitur:

* Tambah User
* Edit User
* Hapus User
* Role Management
* Permission

---

## Nasabah

Kode : NAS

Fitur:

* Tambah Nasabah
* Edit Nasabah
* Hapus Nasabah
* Detail Nasabah
* Pencarian
* Filter

---

## Petugas

Kode : PET

Fitur:

* CRUD Petugas

---

## Jenis Sampah

Kode : JST

Fitur:

* CRUD Jenis Sampah

---

## Harga Sampah

Kode : HRG

Fitur:

* CRUD Harga
* Riwayat Harga
* Status Aktif

---

## Pengepul

Kode : PNG

Fitur:

* CRUD Pengepul

---

## Transaksi Setor

Kode : TRX

Fitur:

* Buat Transaksi
* Tambah Detail Sampah
* Hitung Otomatis
* Cetak Bukti
* Riwayat

---

## Penjualan Sampah

Kode : SELL

Fitur:

* Input Penjualan
* Pilih Pengepul
* Berat
* Nilai Penjualan
* Riwayat

---

## Kas

Kode : CASH

Fitur:

* Kas Masuk
* Kas Keluar
* Saldo Kas
* Riwayat

---

## Laporan

Kode : REP

Fitur:

* Laporan Harian
* Bulanan
* Tahunan
* Export PDF
* Export Excel

---

## Pengaturan

Kode : SET

Fitur:

* Profil RW
* Backup Database
* Pengaturan Sistem

---

# 3. Functional Requirement Detail

---

## FR-001

Nama

Login

Priority

Critical

Actor

Semua User

Acceptance Criteria

* User berhasil login menggunakan email dan password.
* Password harus terenkripsi.
* Session dibuat setelah login berhasil.

---

## FR-002

Nama

Kelola Nasabah

Priority

Critical

Actor

Petugas

Acceptance Criteria

* CRUD Nasabah berhasil.
* Kode Nasabah unik.
* Data dapat dicari.
* Data dapat difilter.

---

## FR-003

Nama

Kelola Jenis Sampah

Priority

High

Actor

Admin

Acceptance Criteria

* Jenis sampah unik.
* Tidak boleh duplikat.

---

## FR-004

Nama

Kelola Harga Sampah

Priority

Critical

Actor

Admin

Acceptance Criteria

* Harga memiliki tanggal berlaku.
* Riwayat harga tersimpan.
* Perubahan harga tidak memengaruhi transaksi lama.

---

## FR-005

Nama

Transaksi Setor

Priority

Critical

Actor

Petugas

Acceptance Criteria

* Satu transaksi dapat memiliki beberapa jenis sampah.
* Berat lebih besar dari nol.
* Harga otomatis.
* Total otomatis.
* Riwayat tersimpan.

---

## FR-006

Nama

Penjualan Sampah

Priority

High

Actor

Petugas

Acceptance Criteria

* Pilih pengepul.
* Nilai penjualan dihitung.
* Riwayat tersimpan.

---

## FR-007

Nama

Kas

Priority

High

Actor

Admin

Acceptance Criteria

* Kas Masuk.
* Kas Keluar.
* Saldo otomatis.

---

## FR-008

Nama

Dashboard

Priority

Medium

Actor

Ketua RW

Acceptance Criteria

Dashboard menampilkan:

* Total Nasabah
* Total Transaksi
* Total Berat Sampah
* Total Penjualan
* Saldo Kas
* Grafik

---

## FR-009

Nama

Laporan

Priority

Critical

Actor

Admin

Acceptance Criteria

* Filter tanggal.
* PDF.
* Excel.

---

## FR-010

Nama

Role Permission

Priority

Critical

Actor

Super Admin

Acceptance Criteria

* Role dapat dibuat.
* Permission dapat diatur.
* User hanya melihat menu sesuai hak akses.

---

# 4. Future Functional Requirements

Versi berikutnya:

* QR Code Nasabah
* Scan Barcode Sampah
* WhatsApp Notification
* Mobile Application
* QRIS
* COA
* Jurnal Umum
* Buku Besar
* Neraca Saldo
* Laporan Arus Kas
* Laporan Laba Rugi
* Neraca

---

# 5. Definition of Done

Setiap requirement dianggap selesai apabila:

* Implementasi selesai.
* Validasi berhasil.
* Pengujian berhasil.
* Dokumentasi diperbarui.
* Acceptance Criteria terpenuhi.