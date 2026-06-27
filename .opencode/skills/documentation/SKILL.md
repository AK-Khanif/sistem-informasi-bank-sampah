# Documentation Skill

## Tujuan

Skill ini menjadi standar pengelolaan dokumentasi untuk Sistem Informasi Bank Sampah (SIBS).

AI wajib menjaga agar dokumentasi selalu selaras dengan implementasi kode.

Dokumentasi adalah bagian dari produk, bukan pekerjaan tambahan.

---

# Kapan Skill Digunakan

Gunakan skill ini ketika:

* Menambah fitur baru
* Mengubah business rule
* Mengubah struktur database
* Menambah package
* Mengubah arsitektur
* Mengubah alur bisnis
* Menyelesaikan task besar

---

# Prinsip Dokumentasi

Dokumentasi mengikuti prinsip:

* Single Source of Truth
* Documentation as Code
* Versioned
* Consistent
* Maintainable

---

# Prioritas Dokumen

Jika terjadi perubahan, AI harus memperbarui dokumen berikut sesuai urutan:

1. PROJECT_CONSTITUTION.md
2. 01_PRD.md
3. 05_BUSINESS_RULES.md
4. 04_FUNCTIONAL_REQUIREMENTS.md
5. 07_DATABASE_DESIGN.md
6. 08_ERD.md
7. 09_DATA_DICTIONARY.md
8. 02_TECH_STACK.md
9. README.md
10. TASKS.md

Tidak semua dokumen harus diperbarui setiap saat. Hanya dokumen yang terdampak oleh perubahan.

---

# Struktur Dokumentasi

```text id="1x9k3l"
docs/
├── PROJECT_CONSTITUTION.md
├── 00_SURVEY.md
├── 01_PRD.md
├── 02_TECH_STACK.md
├── 03_BUSINESS_DOMAIN.md
├── 04_FUNCTIONAL_REQUIREMENTS.md
├── 05_BUSINESS_RULES.md
├── 06_NON_FUNCTIONAL_REQUIREMENTS.md
├── 07_DATABASE_DESIGN.md
├── 08_ERD.md
├── 09_DATA_DICTIONARY.md
├── 10_CODING_STANDARD.md
├── 11_API_SPECIFICATION.md
└── 12_DEPLOYMENT.md
```

---

# Aturan Penulisan

Dokumentasi harus:

* Menggunakan Bahasa Indonesia.
* Menggunakan istilah teknis yang konsisten.
* Menggunakan heading Markdown yang jelas.
* Menghindari duplikasi informasi.
* Mengacu pada dokumen lain jika diperlukan.

---

# Dokumentasi Fitur

Setiap fitur baru minimal memiliki:

* Tujuan fitur.
* Ruang lingkup.
* Dampak terhadap sistem.
* Dampak terhadap database (jika ada).
* Dampak terhadap business rule (jika ada).

---

# Dokumentasi Database

Jika struktur database berubah:

* Perbarui 07_DATABASE_DESIGN.md.
* Perbarui 08_ERD.md jika relasi berubah.
* Perbarui 09_DATA_DICTIONARY.md.

Migration tidak boleh menjadi satu-satunya sumber informasi struktur database.

---

# Dokumentasi API

Jika endpoint baru ditambahkan:

* Perbarui 11_API_SPECIFICATION.md.
* Sertakan request, response, dan status code.

---

# Dokumentasi Deployment

Jika proses instalasi atau deployment berubah:

* Perbarui 12_DEPLOYMENT.md.

---

# Dokumentasi README

README hanya berisi gambaran umum proyek.

README tidak boleh menduplikasi isi dokumen teknis secara rinci.

---

# TASKS.md

Setelah task selesai:

* Ubah status task.
* Tambahkan task baru jika memang diperlukan.
* Jangan menghapus riwayat task tanpa alasan.

---

# AGENTS.md

Jika standar kerja AI berubah secara permanen:

* Perbarui AGENTS.md.

---

# Commit

Gunakan pesan commit yang deskriptif.

Contoh:

```text id="j5bn1m"
docs: update data dictionary
docs: revise business rules
docs: add deployment guide
```

---

# Hal yang Dilarang

AI tidak boleh:

* Membiarkan dokumentasi tidak sinkron dengan kode.
* Menghapus dokumentasi tanpa persetujuan.
* Menyalin isi dokumen ke dokumen lain sehingga terjadi duplikasi.
* Mengubah istilah domain yang telah disepakati.

---

# Definition of Done

Sebuah perubahan dianggap selesai jika:

* Implementasi selesai.
* Dokumentasi yang terdampak telah diperbarui.
* TASKS.md telah diperbarui.
* Tidak ada inkonsistensi antara kode dan dokumentasi.

---

# Checklist

Sebelum menyelesaikan task, pastikan:

* Dokumentasi yang terdampak telah diperbarui.
* Tidak ada informasi yang saling bertentangan.
* README tetap ringkas.
* Data Dictionary tetap sesuai migration.
* ERD tetap sesuai relasi.
* Business Rule tetap sesuai implementasi.