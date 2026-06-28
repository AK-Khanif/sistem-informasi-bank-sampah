# SIBS — Sistem Informasi Bank Sampah

Aplikasi manajemen Bank Sampah berbasis web. Dibangun dengan Laravel, Livewire, dan Volt.

## Persyaratan Sistem

- PHP 8.3+
- Composer
- Node.js & NPM
- MySQL / MariaDB / PostgreSQL / SQLite

## Instalasi

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
```

Konfigurasi database di `.env`, lalu:

```bash
php artisan migrate:fresh --seed
php artisan serve
```

## Akun Development

| Role | Email | Password |
|------|-------|----------|
| Super Admin | `admin@sibs.test` | `password` |

## Menjalankan Test

```bash
php artisan test
```

## Struktur Menu

- **Dashboard**
- **Master Data**: Nasabah, Kategori Sampah, Jenis Sampah, Harga Sampah, Pengepul
- **Transaksi**: _(Coming soon)_
- **Laporan**: _(Coming soon)_
- **Sistem**: Pengaturan
