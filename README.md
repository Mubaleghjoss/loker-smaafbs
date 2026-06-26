# Rekrutmen Guru SMA AFBS

Aplikasi web ringan untuk rekrutmen (guru/staf) berbasis **Laravel 11 + Blade + Tailwind**.
Target deploy: **cPanel shared hosting (Rumahweb)** dengan **PHP 8.2+** dan **MySQL** (tanpa Node runtime di server).

## Fitur

- Landing page rekrutmen + daftar posisi dibuka
- Form pendaftaran (rapi, responsif)
  - Upload berkas: CV (PDF) + Ijazah (PDF/JPG/PNG)
  - Redirect ke WhatsApp admin setelah submit (nomor bisa diubah di pengaturan admin)
- Cek status lamaran via kode pendaftaran
  - Status: `Diproses`, `Diterima`, `Ditolak`, `Butuh berkas`
- Admin panel
  - Login admin + rate limit login
  - Dashboard statistik (total, per posisi, per status)
  - CRUD posisi
  - List pelamar + filter (posisi/status/tanggal/cari)
  - Detail pelamar + download berkas
  - Update status + catatan internal + catatan ke pelamar
  - Export CSV
  - Pengaturan: no WhatsApp admin, toggle email konfirmasi
  - Pengguna admin (khusus super admin)

## Keamanan (ringkas)

- CSRF protection bawaan Laravel
- Password admin hashed (bcrypt/argon2 via `Hash::make`)
- Rate limit login admin (`throttle:5,1`)
- Upload tervalidasi (MIME/ekstensi + batas ukuran), nama file random
- Berkas disimpan di `storage/app/private/...` (non-public)

## Kebutuhan Server

- PHP 8.2+
- MySQL
- Ekstensi PHP umum Laravel (OpenSSL, PDO, Mbstring, Tokenizer, XML, Ctype, JSON, Fileinfo)

## Setup Lokal (opsional)

1. Install dependencies:
   - `composer install`
2. Generate key:
   - `php artisan key:generate`
3. Jalankan migration + seed:
   - `php artisan migrate --seed`
4. (UI) Build asset Tailwind (lokal):
   - `npm install`
   - `npm run build`

## Deploy ke cPanel Rumahweb (tanpa Node runtime)

Target deploy SSH saat ini:

- Laravel root: `~/laravel-lokersmaafbs`
- Public web root: `~/public_html/web/www.karir`
- Repository: `https://github.com/Mubaleghjoss/loker-smaafbs.git`
- Database: MySQL (`DB_CONNECTION=mysql`)

Deploy pertama:

```bash
cd ~
git clone https://github.com/Mubaleghjoss/loker-smaafbs.git laravel-lokersmaafbs
cd laravel-lokersmaafbs
cp .env.production.example .env
nano .env
bash scripts/ssh-update.sh
```

Update berikutnya setelah push ke GitHub:

```bash
cd ~/laravel-lokersmaafbs
bash scripts/ssh-update.sh
```

Detail lengkap ada di `DEPLOY_SSH_CPANEL.md`.

> Prinsip utama: **build semua di lokal**, lalu upload hasilnya.

### 1) Buat Database MySQL

- cPanel → **MySQL Databases**
- Buat database + user + password
- Assign user ke database (ALL PRIVILEGES)

### 2) Upload Project

Upload via File Manager / FTP.

Direkomendasikan struktur aman:

- `public_html` (document root) berisi isi folder `public/`
- Source Laravel di folder terpisah: `laravel-lokersmaafbs/`

Opsi A (paling aman di shared hosting):

1. Upload semua source Laravel ke `~/laravel-lokersmaafbs/` (kecuali `public/`)
2. Upload isi folder `public/` ke `~/public_html/web/www.karir/`
3. Gunakan `deploy/public-index.php` sebagai `~/public_html/web/www.karir/index.php`

Opsi B (paling mudah jika bisa set document root):

- Buat subdomain / addon domain, set **Document Root** langsung ke folder `public/`.

### 3) Pastikan `vendor/` dan `public/build/` ikut ter-upload

Karena server **tidak menjalankan Node**, maka:

- Jalankan `npm run build` di lokal
- Upload folder `public/build/`

Jika cPanel tidak menyediakan Composer:
- Jalankan `composer install` di lokal
- Upload folder `vendor/`

### 4) Buat File `.env`

Di server, buat `.env` (ambil dari `.env.example`). Isi minimal:

- `APP_ENV=production`
- `APP_KEY=...` (jalankan `php artisan key:generate` di lokal lalu copy)
- `APP_DEBUG=false`
- `APP_URL=https://domain-anda`

Database:

- `DB_CONNECTION=mysql`
- `DB_HOST=localhost`
- `DB_PORT=3306`
- `DB_DATABASE=nama_db`
- `DB_USERNAME=user_db`
- `DB_PASSWORD=password_db`

Email (opsional, via SMTP cPanel):

- `MAIL_MAILER=smtp`
- `MAIL_HOST=...`
- `MAIL_PORT=...`
- `MAIL_USERNAME=...`
- `MAIL_PASSWORD=...`
- `MAIL_ENCRYPTION=tls` (atau sesuai)
- `MAIL_FROM_ADDRESS=...`
- `MAIL_FROM_NAME="Rekrutmen SMA AFBS"`

### 5) Permission Folder

Pastikan folder ini writable:

- `storage/`
- `bootstrap/cache/`

### 6) Jalankan Migration + Seeder

Jika cPanel punya Terminal:

- `php artisan migrate --seed`

Seeder akan membuat:

- Setting default `admin_whatsapp`
- 1 akun super admin jika belum ada (lihat env `AFBS_ADMIN_*`)
- Contoh posisi (bisa dihapus/edit dari admin panel)

Jika tidak ada terminal, jalankan migrasi di lokal lalu import SQL MySQL (lebih manual). Cara termudah tetap memakai Terminal cPanel.

### 7) Login Admin

- URL: `/admin/login`
- Akun awal diambil dari env:
  - `AFBS_ADMIN_EMAIL`
  - `AFBS_ADMIN_PASSWORD`
  - `AFBS_ADMIN_NAME`

Setelah login:
- Ubah nomor WhatsApp admin di menu **Pengaturan**.

## Catatan Upload Berkas

- Berkas pelamar tersimpan di `storage/app/private/applications/{KODE}/...`
- Hanya bisa di-download melalui admin panel (tidak ada URL publik langsung)
