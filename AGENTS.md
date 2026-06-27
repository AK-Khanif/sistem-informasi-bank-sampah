# AGENTS.md

# Panduan Kerja AI

Dokumen ini berisi aturan kerja yang wajib diikuti oleh AI Coding Agent selama mengembangkan proyek **Sistem Informasi Bank Sampah (SIBS)**.

## Tujuan

AI bertugas membantu mengembangkan aplikasi dengan menghasilkan kode yang:

* Benar
* Konsisten
* Mudah dipelihara
* Mengikuti standar Laravel
* Mengikuti kebutuhan bisnis yang telah didokumentasikan

AI bukan pengambil keputusan bisnis. Seluruh keputusan bisnis mengacu pada dokumentasi proyek.

---

# Prioritas Dokumen

Sebelum mengimplementasikan fitur, AI wajib membaca dokumen berikut sesuai urutan prioritas:

1. `docs/PROJECT_CONSTITUTION.md`
2. `docs/01_PRD.md`
3. `docs/05_BUSINESS_RULES.md`
4. `docs/04_FUNCTIONAL_REQUIREMENTS.md`
5. `docs/06_NON_FUNCTIONAL_REQUIREMENTS.md`
6. `README.md`

Jika terjadi konflik informasi, gunakan urutan di atas.

---

# Ruang Lingkup

AI hanya boleh mengerjakan fitur yang termasuk dalam **Release 1.0**.

Fitur di luar Release 1.0 tidak boleh dibuat tanpa instruksi baru.

---

# Cara Kerja AI

Sebelum membuat atau mengubah kode, AI harus:

1. Memahami kebutuhan bisnis.
2. Membaca dokumentasi yang relevan.
3. Menyusun rencana implementasi.
4. Mengimplementasikan fitur secara bertahap.
5. Melakukan validasi.
6. Memastikan kode mengikuti standar proyek.

---

# Aturan Implementasi

AI wajib:

* Mengikuti standar Laravel.
* Mengikuti struktur folder proyek.
* Menggunakan Service Layer untuk logika bisnis.
* Menggunakan Form Request untuk validasi.
* Menggunakan Policy untuk otorisasi.
* Menggunakan Eloquent ORM.
* Menulis kode yang sederhana dan mudah dipahami.

---

# Hal yang Dilarang

AI tidak boleh:

* Mengubah Business Rules tanpa persetujuan.
* Membuat fitur yang tidak ada pada PRD.
* Menaruh logika bisnis di Controller.
* Menambahkan package tanpa alasan yang jelas.
* Menghapus fitur yang sudah ada tanpa instruksi.

---

# Definition of Done

Sebuah task dianggap selesai apabila:

* Requirement telah terpenuhi.
* Validasi telah dibuat.
* Otorisasi telah diterapkan.
* Kode mengikuti standar proyek.
* Dokumentasi diperbarui jika diperlukan.

---

# Workflow

Setiap pekerjaan mengikuti alur berikut:

1. Membaca dokumentasi.
2. Memahami requirement.
3. Mengimplementasikan.
4. Menguji hasil implementasi.
5. Memperbarui dokumentasi bila diperlukan.
6. Menandai task selesai.

---

# Struktur Dokumentasi

* `README.md` → Gambaran umum proyek.
* `docs/` → Sumber kebenaran (business & technical documentation).
* `TASKS.md` → Daftar pekerjaan.
* `.opencode/skills/` → Standar implementasi teknis.

---

# Prinsip Pengembangan

* Business First
* Clean Code
* SOLID
* DRY
* KISS
* Convention over Configuration

Selalu utamakan kualitas, konsistensi, dan kemudahan pemeliharaan dibanding kecepatan implementasi.