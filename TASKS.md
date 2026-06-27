# TASKS.md

# Development Backlog

Dokumen ini merupakan daftar pekerjaan resmi (backlog) untuk pengembangan Sistem Informasi Bank Sampah (SIBS).

Seluruh implementasi harus mengacu pada task yang terdapat di dokumen ini.

---

# Status Task

| Status | Keterangan        |
| ------ | ----------------- |
| ⬜      | Belum Dikerjakan  |
| 🟨     | Sedang Dikerjakan |
| ✅      | Selesai           |
| ⏸️     | Ditunda           |

---

# EPIC-001 Project Foundation

| ID       | Task                                | Status |
| -------- | ----------------------------------- | ------ |
| TASK-001 | Inisialisasi Repository             | ✅      |
| TASK-002 | Dokumentasi Proyek                  | ✅      |
| TASK-003 | AI Workspace                        | 🟨     |
| TASK-004 | Setup Laravel                       | ⬜      |
| TASK-005 | Konfigurasi Development Environment | ⬜      |

---

# EPIC-002 Authentication

| ID       | Task              | Status |
| -------- | ----------------- | ------ |
| TASK-101 | Login             | ⬜      |
| TASK-102 | Logout            | ⬜      |
| TASK-103 | Profil Pengguna   | ⬜      |
| TASK-104 | Ganti Password    | ⬜      |
| TASK-105 | Role & Permission | ⬜      |

---

# EPIC-003 Dashboard

| ID       | Task                  | Status |
| -------- | --------------------- | ------ |
| TASK-201 | Dashboard Utama       | ⬜      |
| TASK-202 | Statistik Bank Sampah | ⬜      |
| TASK-203 | Grafik Bulanan        | ⬜      |

---

# EPIC-004 Master Data

| ID       | Task              | Status |
| -------- | ----------------- | ------ |
| TASK-301 | CRUD Nasabah      | ⬜      |
| TASK-302 | CRUD Petugas      | ⬜      |
| TASK-303 | CRUD Jenis Sampah | ⬜      |
| TASK-304 | CRUD Harga Sampah | ⬜      |
| TASK-305 | CRUD Pengepul     | ⬜      |

---

# EPIC-005 Operasional

| ID       | Task                   | Status |
| -------- | ---------------------- | ------ |
| TASK-401 | Transaksi Setor Sampah | ⬜      |
| TASK-402 | Detail Transaksi       | ⬜      |
| TASK-403 | Penjualan Sampah       | ⬜      |
| TASK-404 | Detail Penjualan       | ⬜      |
| TASK-405 | Kas Masuk              | ⬜      |
| TASK-406 | Kas Keluar             | ⬜      |

---

# EPIC-006 Laporan

| ID       | Task              | Status |
| -------- | ----------------- | ------ |
| TASK-501 | Laporan Transaksi | ⬜      |
| TASK-502 | Laporan Penjualan | ⬜      |
| TASK-503 | Laporan Kas       | ⬜      |
| TASK-504 | Export PDF        | ⬜      |
| TASK-505 | Export Excel      | ⬜      |

---

# EPIC-007 Pengaturan

| ID       | Task               | Status |
| -------- | ------------------ | ------ |
| TASK-601 | Profil Bank Sampah | ⬜      |
| TASK-602 | Pengaturan Sistem  | ⬜      |
| TASK-603 | Activity Log       | ⬜      |

---

# Release 1.0

Task yang harus selesai sebelum sistem digunakan:

* EPIC-001
* EPIC-002
* EPIC-003
* EPIC-004
* EPIC-005
* EPIC-006
* EPIC-007

---

# Release 1.1

Fitur yang belum dikerjakan:

* Chart of Accounts (COA)
* Jurnal Umum
* Buku Besar
* Neraca Saldo
* Laporan Arus Kas
* Laporan Laba Rugi
* Neraca

---

# Cara Kerja

Setiap implementasi harus mengikuti urutan berikut:

1. Pilih satu task.
2. Implementasikan task tersebut.
3. Lakukan pengujian.
4. Review hasil implementasi.
5. Ubah status task menjadi selesai.
6. Commit perubahan.

Satu task hanya boleh mengerjakan satu tujuan agar mudah ditinjau dan dipelihara.