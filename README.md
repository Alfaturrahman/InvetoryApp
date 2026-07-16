# InventoryApp

Aplikasi manajemen inventaris peralatan fiber optic berbasis Laravel.

## Fitur

- Login role `admin` dan `teknisi`
- Kelola data alat, teknisi, peminjaman, maintenance
- Dashboard ringkasan stok
- Laporan + export PDF / Excel
- UI responsive + SweetAlert2

## Local Setup

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve
```

## Deploy ke Railway

Repository sudah disiapkan untuk Railway via:

- `railway.json`
- `Procfile`
- `nixpacks.toml`

Catatan: build Railway dikonfigurasi fokus ke PHP/Composer agar tidak gagal pada requirement Node Vite.

### 1) Buat project Railway dari GitHub

- Login Railway
- `New Project` -> `Deploy from GitHub Repo`
- Pilih repo `Alfaturrahman/InvetoryApp`

### 2) Tambahkan database

- Di project Railway, klik `New` -> `Database` -> pilih MySQL/PostgreSQL

### 3) Set environment variables (wajib)

- `APP_NAME=InventoryApp`
- `APP_ENV=production`
- `APP_DEBUG=false`
- `APP_URL=<url-railway-anda>`
- `APP_KEY=<generate_dengan_php_artisan_key_generate_show>`

Jika pakai MySQL di Railway:

- `DB_CONNECTION=mysql`
- `DB_HOST`
- `DB_PORT`
- `DB_DATABASE`
- `DB_USERNAME`
- `DB_PASSWORD`

Nilai DB biasanya otomatis terisi dari service database Railway.

### 4) Jalankan migrate di Railway

Setelah deploy pertama sukses, jalankan command ini di Railway shell / command:

```bash
php artisan migrate --force
php artisan db:seed --force
```

### 5) Verifikasi

- Buka URL app Railway
- Cek login
- Cek halaman admin dan export laporan

### Troubleshooting build error Node/Vite di Railway

Jika sebelumnya muncul error Node 18 saat `npm run build`, gunakan konfigurasi yang sudah ada di repo ini (`nixpacks.toml`) lalu lakukan redeploy ulang. Konfigurasi ini tidak menjalankan build frontend Vite di Railway.

Jika muncul error Nix `undefined variable 'composer'`, pastikan menggunakan versi `nixpacks.toml` terbaru di repo ini (tanpa deklarasi paket `composer` pada phase setup), lalu trigger deploy ulang.

## Akun Demo Seed

- Admin: `admin@multitech.test` / `password`
- Teknisi: `teknisi1@multitech.test` / `password`
