# Backend Laravel Skill

## Tujuan

Skill ini menjadi standar implementasi backend Laravel untuk seluruh pengembangan Sistem Informasi Bank Sampah (SIBS).

Seluruh kode backend yang dihasilkan AI harus mengikuti dokumen ini.

---

# Kapan Skill Ini Digunakan

Gunakan skill ini ketika:

* Membuat Migration
* Membuat Model
* Membuat Service
* Membuat Form Request
* Membuat Policy
* Membuat Observer
* Membuat Event
* Membuat Queue
* Membuat API Resource
* Membuat Livewire Component yang berinteraksi dengan backend

---

# Prinsip Pengembangan

Backend wajib mengikuti prinsip:

* Clean Architecture
* Clean Code
* SOLID
* DRY
* KISS
* Convention over Configuration

Business Rule tidak boleh ditulis di Controller.

---

# Arsitektur

Alur implementasi wajib:

```text
HTTP Request
      ↓
Form Request
      ↓
Service
      ↓
Model (Eloquent)
      ↓
Database
```

Controller hanya bertugas menerima request dan mengembalikan response.

---

# Struktur Folder

Gunakan struktur berikut.

```text
app/
├── Actions/
├── DTO/
├── Enums/
├── Events/
├── Exceptions/
├── Http/
│   ├── Controllers/
│   ├── Requests/
│   └── Resources/
├── Models/
├── Observers/
├── Policies/
├── Providers/
├── Services/
└── Support/
```

Folder dibuat hanya jika mulai digunakan.

---

# Aturan Controller

Controller harus:

* Tipis (Thin Controller).
* Tidak berisi business logic.
* Tidak menjalankan query kompleks.
* Memanggil Service.

Contoh:

```php
public function store(StoreCustomerRequest $request)
{
    $customer = $this->customerService->store($request->validated());

    return redirect()->route('customers.index');
}
```

---

# Aturan Service

Seluruh business logic ditempatkan pada Service.

Contoh:

* membuat transaksi
* menghitung total
* validasi bisnis
* mengubah status

Service boleh menggunakan:

* DB Transaction
* Event
* Notification

---

# Aturan Model

Model menggunakan Eloquent.

Setiap model wajib:

* HasFactory
* UUID
* Relasi
* Cast
* Fillable

Gunakan relasi Eloquent.

Hindari query mentah jika tidak diperlukan.

---

# UUID

Seluruh model menggunakan UUID sebagai Primary Key.

Contoh:

* User
* Customer
* Deposit
* Sale

---

# Validation

Seluruh validasi menggunakan Form Request.

Controller tidak boleh memanggil Validator secara langsung.

---

# Authorization

Authorization menggunakan Laravel Policy.

Contoh:

* CustomerPolicy
* DepositPolicy
* SalePolicy

Jangan melakukan pengecekan role langsung di Controller.

---

# Database Transaction

Operasi yang mengubah lebih dari satu tabel wajib menggunakan:

```php
DB::transaction(function () {
    // business logic
});
```

---

# Exception Handling

Gunakan Exception jika terjadi pelanggaran business rule.

Contoh:

* stok tidak cukup
* harga tidak ditemukan
* transaksi tidak valid

---

# Logging

Kesalahan penting dicatat menggunakan Log.

Jangan menggunakan `dd()` atau `dump()` pada kode production.

---

# Event

Gunakan Event ketika:

* transaksi selesai
* penjualan selesai
* harga berubah

---

# Observer

Gunakan Observer untuk:

* generate kode otomatis
* generate nomor transaksi
* aktivitas yang berkaitan langsung dengan model

---

# Resource

Jika menggunakan API, gunakan API Resource.

Jangan mengembalikan Model secara langsung.

---

# Query

Gunakan Eloquent.

Gunakan eager loading (`with()`) untuk menghindari N+1 Query.

---

# Pagination

Daftar data menggunakan pagination.

Jangan menggunakan `all()` untuk data yang dapat bertambah besar.

---

# Naming Convention

## Model

Singular.

Contoh:

* Customer
* Deposit
* WasteType

## Service

NamaModel + Service.

Contoh:

* CustomerService
* DepositService

## Request

Action + Model + Request.

Contoh:

* StoreCustomerRequest
* UpdateCustomerRequest

## Policy

NamaModel + Policy.

---

# Definition of Done

Sebuah fitur backend dianggap selesai jika memiliki:

* Migration
* Model
* Factory
* Seeder (jika diperlukan)
* Form Request
* Service
* Policy
* Route
* Controller
* Feature Test

---

# Hal yang Dilarang

AI tidak boleh:

* Menulis business logic di Controller.
* Menulis query SQL mentah tanpa alasan.
* Menggunakan `Model::all()` untuk data besar.
* Menggunakan `DB::table()` jika Eloquent sudah memadai.
* Menonaktifkan Foreign Key tanpa alasan.
* Menghapus transaksi secara permanen.

---

# Checklist Sebelum Menyelesaikan Task

* Requirement sesuai PRD.
* Validasi menggunakan Form Request.
* Authorization menggunakan Policy.
* Business logic berada di Service.
* Relasi menggunakan Eloquent.
* Query telah dioptimalkan.
* Feature Test berhasil.
* Tidak ada debug (`dd`, `dump`, `ray`) yang tertinggal.
