# TASKS.md

# Development Backlog

Dokumen ini merupakan backlog resmi pengembangan **Sistem Informasi Bank Sampah (SIBS)**.

Seluruh implementasi wajib mengikuti urutan task pada dokumen ini.

---

# Status

| Status | Arti              |
| ------ | ----------------- |
| ⬜      | Belum dikerjakan  |
| 🟨     | Sedang dikerjakan |
| ✅      | Selesai           |
| ⏸      | Ditunda           |

---

# Prioritas

| Prioritas | Keterangan                       |
| --------- | -------------------------------- |
| High      | Harus selesai sebelum modul lain |
| Medium    | Modul utama                      |
| Low       | Dapat dikerjakan belakangan      |

---

# EPIC-001 Foundation

| ID       | Task                      | Priority | Status |
| -------- | ------------------------- | -------- | ------ |
| TASK-101 | Inisialisasi Repository   | High     | ✅      |
| TASK-102 | Dokumentasi Proyek        | High     | ✅      |
| TASK-103 | AI Workspace              | High     | ✅      |
| TASK-104 | Setup Laravel 13          | High     | ✅      |
| TASK-105 | Development Environment   | High     | ✅      |
| TASK-106 | Laravel Breeze + Livewire | High     | ✅      |
| TASK-107 | Spatie Permission         | High     | ✅      |
| TASK-108 | Activity Log Package      | High     | ✅      |

---

# EPIC-002 Authentication

| ID       | Task                     | Priority | Depends On | Status |
| -------- | ------------------------ | -------- | ---------- | ------ |
| TASK-201 | Login                    | High     | TASK-108   | ⬜      |
| TASK-202 | Logout                   | Medium   | TASK-201   | ⬜      |
| TASK-203 | Profil Pengguna          | Medium   | TASK-201   | ⬜      |
| TASK-204 | Ganti Password           | Medium   | TASK-201   | ⬜      |
| TASK-205 | Role & Permission Seeder | High     | TASK-107   | ⬜      |
| TASK-206 | Policy & Authorization   | High     | TASK-205   | ⬜      |

---

# EPIC-003 Master Data

| ID       | Task                 | Priority | Depends On | Status |
| -------- | -------------------- | -------- | ---------- | ------ |
| TASK-301 | CRUD Nasabah         | High     | TASK-205   | ⬜      |
| TASK-302 | CRUD Users           | High     | TASK-205   | ⬜      |
| TASK-303 | CRUD Kategori Sampah | High     | TASK-205   | ⬜      |
| TASK-304 | CRUD Jenis Sampah    | High     | TASK-303   | ⬜      |
| TASK-305 | CRUD Harga Sampah    | High     | TASK-304   | ⬜      |
| TASK-306 | CRUD Pengepul        | Medium   | TASK-205   | ⬜      |

---

# EPIC-004 Operasional

| ID       | Task                       | Priority | Depends On                 | Status |
| -------- | -------------------------- | -------- | -------------------------- | ------ |
| TASK-401 | Transaksi Setor Sampah     | High     | TASK-301,TASK-304,TASK-305 | ⬜      |
| TASK-402 | Transaksi Penjualan Sampah | High     | TASK-304,TASK-305,TASK-306 | ⬜      |
| TASK-403 | Transaksi Kas              | High     | TASK-401,TASK-402          | ⬜      |

---

# EPIC-005 Dashboard

| ID       | Task                  | Priority | Depends On                 | Status |
| -------- | --------------------- | -------- | -------------------------- | ------ |
| TASK-501 | Dashboard Utama       | Medium   | TASK-401,TASK-402,TASK-403 | ⬜      |
| TASK-502 | Statistik Bank Sampah | Medium   | TASK-501                   | ⬜      |
| TASK-503 | Grafik Bulanan        | Low      | TASK-501                   | ⬜      |

---

# EPIC-006 Laporan

| ID       | Task              | Priority | Depends On                 | Status |
| -------- | ----------------- | -------- | -------------------------- | ------ |
| TASK-601 | Laporan Setoran   | Medium   | TASK-401                   | ⬜      |
| TASK-602 | Laporan Penjualan | Medium   | TASK-402                   | ⬜      |
| TASK-603 | Laporan Kas       | Medium   | TASK-403                   | ⬜      |
| TASK-604 | Export PDF        | Low      | TASK-601,TASK-602,TASK-603 | ⬜      |
| TASK-605 | Export Excel      | Low      | TASK-601,TASK-602,TASK-603 | ⬜      |

---

# EPIC-007 Pengaturan

| ID       | Task                      | Priority | Depends On | Status |
| -------- | ------------------------- | -------- | ---------- | ------ |
| TASK-701 | Settings Module           | High     | TASK-108   | ⬜      |
| TASK-702 | Profil Bank Sampah        | Medium   | TASK-701   | ⬜      |
| TASK-703 | Pengaturan Sistem         | Medium   | TASK-701   | ⬜      |
| TASK-704 | Implementasi Activity Log | Medium   | TASK-108   | ⬜      |

---

# Release 1.0

Release dianggap selesai apabila seluruh task berikut telah selesai:

* EPIC-001 Foundation
* EPIC-002 Authentication
* EPIC-003 Master Data
* EPIC-004 Operasional
* EPIC-005 Dashboard
* EPIC-006 Laporan
* EPIC-007 Pengaturan

---

# Release 1.1

Pengembangan lanjutan:

* Chart of Accounts (COA)
* Jurnal Umum
* Buku Besar
* Neraca Saldo
* Laporan Arus Kas
* Laporan Laba Rugi
* Neraca

---

# Workflow Pengembangan

Setiap task wajib mengikuti alur berikut:

1. Review Requirement.
2. Membuat Implementation Plan.
3. Review Implementation Plan.
4. Implementasi.
5. Feature Test & Unit Test.
6. Code Review.
7. Ubah status task.
8. Commit ke Git.

Satu task hanya boleh mengerjakan satu tujuan agar implementasi mudah direview dan dipelihara.