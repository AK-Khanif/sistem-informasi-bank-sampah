# 06_NON_FUNCTIONAL_REQUIREMENTS.md

# Non-Functional Requirements Specification (NFR)

## Sistem Informasi Bank Sampah RW 05 Kelurahan Wates

Version: 1.0

Status: Final Draft

---

# 1. Purpose

Dokumen ini mendefinisikan kebutuhan non-fungsional yang harus dipenuhi oleh Sistem Informasi Bank Sampah RW 05.

Kebutuhan non-fungsional menjadi acuan dalam pengembangan backend, frontend, database, keamanan, pengujian, deployment, dan pemeliharaan sistem.

---

# 2. Performance

## NFR-PERF-001

Waktu respon halaman maksimal **3 detik** pada kondisi penggunaan normal.

Priority:

Critical

---

## NFR-PERF-002

Sistem mampu menangani minimal:

* 20 pengguna aktif secara bersamaan.
* 10.000 transaksi tersimpan tanpa penurunan performa yang signifikan.

Priority:

High

---

## NFR-PERF-003

Daftar data wajib menggunakan pagination.

Priority:

Critical

---

## NFR-PERF-004

Relasi database harus menggunakan Eager Loading untuk menghindari N+1 Query.

Priority:

Critical

---

# 3. Security

## NFR-SEC-001

Seluruh pengguna wajib melakukan autentikasi sebelum mengakses sistem.

---

## NFR-SEC-002

Password disimpan menggunakan algoritma hashing Laravel (Argon2id atau bcrypt).

---

## NFR-SEC-003

Semua form wajib menggunakan validasi Form Request.

---

## NFR-SEC-004

Seluruh request wajib dilindungi CSRF Protection.

---

## NFR-SEC-005

Hak akses menggunakan Role Based Access Control (RBAC).

---

## NFR-SEC-006

Semua aktivitas penting dicatat pada Activity Log.

---

## NFR-SEC-007

Soft Delete digunakan untuk data penting agar tidak terjadi kehilangan data akibat penghapusan yang tidak disengaja.

---

# 4. Reliability

## NFR-REL-001

Sistem harus tetap berjalan apabila terjadi kesalahan pada salah satu proses, dengan menampilkan pesan kesalahan yang ramah pengguna.

---

## NFR-REL-002

Seluruh transaksi database yang melibatkan lebih dari satu tabel harus menggunakan Database Transaction.

---

## NFR-REL-003

Backup database dapat dilakukan melalui sistem.

---

# 5. Maintainability

## NFR-MNT-001

Business Logic harus berada pada Service Layer.

---

## NFR-MNT-002

Controller hanya bertugas menerima request dan mengembalikan response.

---

## NFR-MNT-003

Kode mengikuti standar PSR-12.

---

## NFR-MNT-004

Seluruh fitur utama harus memiliki Feature Test.

---

## NFR-MNT-005

Dokumentasi proyek harus selalu diperbarui setiap kali terdapat perubahan fitur.

---

# 6. Usability

## NFR-USA-001

Antarmuka menggunakan Bahasa Indonesia.

---

## NFR-USA-002

Sistem dapat digunakan oleh pengguna yang tidak memiliki latar belakang teknologi informasi.

---

## NFR-USA-003

Navigasi dibuat sederhana dan konsisten.

---

## NFR-USA-004

Pengguna dapat menyelesaikan proses transaksi dengan langkah sesedikit mungkin.

Target:

Maksimal 5 langkah untuk transaksi setor sampah.

---

## NFR-USA-005

Ukuran tombol dan teks harus nyaman digunakan oleh kader dan pengurus RW.

---

# 7. Compatibility

## NFR-COM-001

Sistem mendukung browser modern:

* Google Chrome
* Microsoft Edge
* Mozilla Firefox
* Safari

---

## NFR-COM-002

Sistem responsif pada:

* Desktop
* Laptop
* Tablet
* Smartphone

---

# 8. Scalability

## NFR-SCL-001

Struktur database harus memungkinkan penambahan modul baru tanpa perubahan besar.

---

## NFR-SCL-002

Sistem harus siap dikembangkan menjadi:

* Multi RW
* Multi Kelurahan
* Multi Bank Sampah

---

## NFR-SCL-003

Arsitektur mendukung penambahan modul:

* COA
* Jurnal Umum
* Buku Besar
* Neraca Saldo
* Arus Kas
* Laba Rugi
* Neraca

tanpa perubahan mendasar pada modul operasional.

---

# 9. Availability

## NFR-AVL-001

Sistem dapat digunakan selama jam operasional Bank Sampah.

---

## NFR-AVL-002

Apabila terjadi kegagalan sistem, data transaksi yang telah berhasil disimpan tidak boleh hilang.

---

# 10. Logging & Monitoring

## NFR-LOG-001

Seluruh error aplikasi dicatat pada Laravel Log.

---

## NFR-LOG-002

Activity Log mencatat:

* Login
* Logout
* Tambah Data
* Edit Data
* Hapus Data
* Transaksi
* Penjualan
* Pengaturan

---

# 11. Backup & Recovery

## NFR-BKP-001

Backup database dapat dilakukan secara manual oleh Administrator.

---

## NFR-BKP-002

Backup otomatis dapat ditambahkan pada versi berikutnya menggunakan Laravel Scheduler.

---

# 12. Coding Quality

Seluruh kode harus memenuhi prinsip:

* SOLID
* DRY
* KISS
* Convention over Configuration

---

# 13. Definition of Done

Kebutuhan non-fungsional dianggap terpenuhi apabila:

* Seluruh target keamanan diterapkan.
* Seluruh target performa terpenuhi.
* Seluruh pengujian berhasil.
* Struktur kode sesuai Coding Standards.
* Dokumentasi diperbarui.