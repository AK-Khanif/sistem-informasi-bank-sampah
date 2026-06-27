# Bank Sampah Domain Skill

## Tujuan

Skill ini memberikan pemahaman domain bisnis Bank Sampah kepada AI.

Seluruh implementasi sistem harus mengikuti proses bisnis Bank Sampah RW 05 Kelurahan Wates.

Dokumen ini melengkapi PRD, Business Rules, dan Database Design.

---

# Konteks Sistem

Nama Sistem:

**Sistem Informasi Bank Sampah (SIBS)**

Lokasi Implementasi:

RW 05 Kelurahan Wates

Kecamatan Ngaliyan

Kota Semarang

---

# Tujuan Sistem

Sistem dibangun untuk:

* Digitalisasi pencatatan Bank Sampah.
* Mengurangi pencatatan manual.
* Mempermudah pelaporan.
* Menjaga integritas data.
* Mendukung transparansi pengelolaan Bank Sampah.

---

# Istilah Domain

## Nasabah (Customer)

Warga yang menyetorkan sampah ke Bank Sampah.

Nasabah memiliki identitas unik berupa:

* customer_code
* full_name

Nasabah dapat melakukan banyak transaksi setor.

---

## Petugas (User)

Pengguna yang mengoperasikan sistem.

Contoh:

* Admin
* Petugas Bank Sampah
* Ketua RW (hanya melihat laporan)

---

## Kategori Sampah (Waste Category)

Kelompok besar jenis sampah.

Contoh:

* Plastik
* Kertas
* Logam
* Kaca

---

## Jenis Sampah (Waste Type)

Jenis spesifik dalam suatu kategori.

Contoh:

Kategori Plastik:

* Botol PET
* Gelas Plastik
* HDPE

---

## Harga Sampah (Waste Price)

Harga beli per kilogram.

Harga dapat berubah sewaktu-waktu.

Harga lama tidak boleh mengubah histori transaksi.

---

## Setor Sampah (Deposit)

Proses nasabah menyerahkan sampah ke Bank Sampah.

Satu transaksi dapat berisi banyak jenis sampah.

---

## Detail Setoran (Deposit Item)

Item sampah dalam satu transaksi.

Menyimpan:

* jenis sampah
* berat
* harga saat transaksi (price_snapshot)
* subtotal

---

## Penjualan Sampah (Sale)

Proses menjual hasil sampah kepada pengepul.

Satu penjualan dapat terdiri dari banyak jenis sampah.

---

## Pengepul (Collector)

Mitra yang membeli sampah dari Bank Sampah.

---

## Kas

Pencatatan arus kas Bank Sampah.

Meliputi:

* Kas Masuk
* Kas Keluar

Kas digunakan untuk pelaporan operasional, bukan sebagai modul akuntansi penuh pada Release 1.0.

---

# Alur Bisnis

## Alur Setor Sampah

1. Nasabah datang membawa sampah.
2. Petugas memilih atau mencari data nasabah.
3. Petugas membuat transaksi setor.
4. Petugas memasukkan satu atau lebih jenis sampah.
5. Sistem mengambil harga aktif.
6. Sistem menyimpan harga sebagai snapshot.
7. Sistem menghitung subtotal setiap item.
8. Sistem menghitung total transaksi.
9. Transaksi disimpan.

---

## Alur Penjualan Sampah

1. Petugas memilih pengepul.
2. Petugas membuat transaksi penjualan.
3. Petugas memasukkan jenis sampah yang dijual.
4. Sistem menghitung total penjualan.
5. Kas masuk dicatat.

---

# Business Rules

AI wajib mematuhi aturan berikut.

## Rule 1

Transaksi yang sudah disimpan **tidak boleh dihapus**.

Jika terjadi kesalahan, gunakan mekanisme koreksi atau pembatalan sesuai prosedur bisnis.

---

## Rule 2

Harga transaksi menggunakan **price_snapshot**.

Harga histori tidak boleh berubah ketika harga master diperbarui.

---

## Rule 3

Satu transaksi setor dapat memiliki banyak item.

Jangan membatasi hanya satu jenis sampah per transaksi.

---

## Rule 4

Satu transaksi penjualan dapat memiliki banyak item.

Gunakan pola Header–Detail.

---

## Rule 5

Saldo kas dihitung dari transaksi kas.

Jangan menyimpan saldo berjalan sebagai kolom di database.

---

## Rule 6

Master data yang sudah digunakan transaksi tidak boleh dihapus permanen.

Gunakan Soft Delete.

---

## Rule 7

Kode transaksi harus dibuat otomatis.

Contoh:

* DEP-202607-00001
* SAL-202607-00001

---

## Rule 8

Kode nasabah dibuat otomatis.

Contoh:

NSB-000001

---

# Aturan Implementasi

AI harus:

* Menggunakan Header–Detail Pattern.
* Menggunakan UUID.
* Menggunakan Eloquent Relationship.
* Menggunakan DB Transaction untuk proses yang melibatkan lebih dari satu tabel.

---

# Hal yang Dilarang

AI tidak boleh:

* Menghapus transaksi.
* Mengubah histori harga.
* Menyimpan saldo berjalan.
* Mengambil harga lama dari tabel master saat menampilkan histori.
* Menggunakan hard delete pada master data yang telah digunakan transaksi.
* Menulis business rule di Controller.

---

# Checklist Sebelum Menyelesaikan Fitur

Pastikan:

* Alur bisnis sesuai dengan hasil survei RW 05.
* Tidak ada business rule yang dilanggar.
* Histori transaksi tetap konsisten.
* Laporan dapat direproduksi dari data transaksi.
* Kode mengikuti standar backend-laravel/SKILL.md dan database-design/SKILL.md.
