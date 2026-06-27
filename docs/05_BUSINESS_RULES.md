# 05_BUSINESS_RULES.md

# Business Rules

## Sistem Informasi Bank Sampah RW 05 Kelurahan Wates

Version : 1.0

---

# 1. Purpose

Dokumen ini mendefinisikan seluruh aturan bisnis yang wajib dipatuhi oleh sistem.

Business Rules menjadi acuan utama pada implementasi backend, validasi, database, dan pengujian.

---

# 2. General Rules

BR-001

Setiap pengguna wajib login sebelum menggunakan sistem.

---

BR-002

Setiap aktivitas penting harus tercatat pada Activity Log.

---

BR-003

Setiap transaksi memiliki petugas yang bertanggung jawab.

---

BR-004

Data yang sudah digunakan dalam transaksi tidak boleh dihapus secara permanen.

Gunakan Soft Delete apabila diperlukan.

---

# 3. Master Data Rules

## Nasabah

BR-NAS-001

Kode nasabah harus unik.

---

BR-NAS-002

Nomor telepon bersifat opsional tetapi harus unik apabila diisi.

---

BR-NAS-003

Status nasabah terdiri dari:

* Aktif
* Tidak Aktif

---

## Jenis Sampah

BR-JNS-001

Nama jenis sampah harus unik.

---

BR-JNS-002

Jenis sampah yang telah digunakan pada transaksi tidak boleh dihapus.

---

## Harga Sampah

BR-HRG-001

Harga mempunyai tanggal mulai berlaku.

---

BR-HRG-002

Perubahan harga tidak mengubah transaksi yang telah terjadi.

---

BR-HRG-003

Dalam satu waktu hanya boleh ada satu harga aktif untuk setiap jenis sampah.

---

## Pengepul

BR-PNG-001

Nama pengepul harus unik.

---

# 4. Transaction Rules

## Transaksi Setor

BR-TRX-001

Satu transaksi hanya dimiliki oleh satu nasabah.

---

BR-TRX-002

Satu transaksi dapat memiliki lebih dari satu jenis sampah.

---

BR-TRX-003

Berat sampah harus lebih besar dari nol.

---

BR-TRX-004

Harga transaksi mengikuti harga yang aktif pada saat transaksi dibuat.

---

BR-TRX-005

Total transaksi dihitung otomatis.

---

BR-TRX-006

Transaksi yang sudah selesai tidak dapat dihapus.

---

BR-TRX-007

Perubahan harga di masa depan tidak boleh mengubah nilai transaksi lama.

---

# 5. Penjualan Sampah

BR-SLS-001

Penjualan dilakukan kepada satu pengepul.

---

BR-SLS-002

Nilai penjualan dihitung berdasarkan berat dan harga jual.

---

BR-SLS-003

Setiap penjualan menghasilkan pemasukan kas.

---

# 6. Kas

BR-CASH-001

Kas Masuk menambah saldo.

---

BR-CASH-002

Kas Keluar mengurangi saldo.

---

BR-CASH-003

Saldo kas tidak boleh menjadi negatif tanpa otorisasi administrator.

---

# 7. Reporting

BR-REP-001

Laporan dihasilkan langsung dari data transaksi.

---

BR-REP-002

Laporan tidak boleh diubah secara manual.

---

BR-REP-003

Laporan dapat difilter berdasarkan periode.

---

# 8. Security Rules

BR-SEC-001

Password wajib dienkripsi.

---

BR-SEC-002

Hak akses menggunakan Role Based Access Control (RBAC).

---

BR-SEC-003

Setiap request harus divalidasi menggunakan Form Request.

---

BR-SEC-004

Akses terhadap modul dibatasi berdasarkan Permission.

---

# 9. Audit Rules

Semua aktivitas berikut wajib tercatat:

* Login
* Logout
* Tambah Data
* Edit Data
* Hapus Data
* Transaksi
* Penjualan
* Pengaturan

---

# 10. Future Rules

Business Rules baru dapat ditambahkan tanpa mengubah aturan yang telah berlaku.