# Deploy SSH cPanel

Target layout:

- Laravel root: `~/laravel-lokersmaafbs`
- Public web root: `~/public_html/web/www.karir`
- Repository: `https://github.com/Mubaleghjoss/loker-smaafbs.git`
- Database: MySQL

## 1. Buat Database MySQL

Di cPanel, buat database dan user MySQL, lalu berikan `ALL PRIVILEGES`.

Contoh nama:

- Database: `cpaneluser_lokersmaafbs`
- User: `cpaneluser_lokersmaafbs`

## 2. Deploy Pertama Lewat SSH

Masuk SSH ke hosting, lalu jalankan:

```bash
cd ~
git clone https://github.com/Mubaleghjoss/loker-smaafbs.git laravel-lokersmaafbs
cd laravel-lokersmaafbs
cp .env.production.example .env
```

Pastikan terminal memakai PHP 8.2 cPanel:

```bash
/opt/cpanel/ea-php82/root/usr/bin/php -v
```

Jika perintah itu ada dan menampilkan PHP 8.2, jalankan deploy dengan `PHP_BIN`:

Edit `.env` server:

```bash
nano .env
```

Minimal ubah nilai berikut:

```env
APP_URL=https://domain-karir-anda
DB_DATABASE=nama_database_mysql
DB_USERNAME=user_database_mysql
DB_PASSWORD=password_database_mysql
AFBS_ADMIN_EMAIL=email_admin_awal
AFBS_ADMIN_PASSWORD=password_admin_awal
AFBS_ADMIN_NAME="Admin AFBS"
```

Lalu jalankan:

```bash
PHP_BIN=/opt/cpanel/ea-php82/root/usr/bin/php bash scripts/ssh-update.sh
```

Script akan:

- menarik kode terbaru dari branch `main`
- memastikan PHP CLI yang dipakai adalah PHP 8.2
- menjalankan `composer install --no-dev`
- otomatis memakai `composer install --no-scripts` jika `proc_open` mati di hosting, lalu menjalankan `php artisan package:discover` manual
- membuat `APP_KEY` jika masih kosong
- menjalankan migration MySQL
- menjalankan seeder awal agar akun admin dari `AFBS_ADMIN_*` dan setting dasar dibuat
- membuat cache Laravel
- menyalin isi `public/` ke `~/public_html/web/www.karir`
- mengganti `~/public_html/web/www.karir/index.php` agar menunjuk ke `~/laravel-lokersmaafbs`
- mengirim `.htaccess` dengan handler cPanel `application/x-httpd-ea-php82`

## 3. Update Berikutnya Setelah Push

Setelah perubahan sudah di-push ke GitHub, cukup SSH lalu jalankan:

```bash
cd ~/laravel-lokersmaafbs
PHP_BIN=/opt/cpanel/ea-php82/root/usr/bin/php bash scripts/ssh-update.sh
```

Jika hosting tidak punya path `/opt/cpanel/ea-php82/root/usr/bin/php`, cari binary PHP 8.2 dengan:

```bash
ls -l /opt/cpanel/ea-php82/root/usr/bin/php /usr/local/bin/ea-php82 /usr/bin/ea-php82 /opt/alt/php82/usr/bin/php 2>/dev/null
```

Lalu ganti nilai `PHP_BIN=...` dengan path yang tersedia.

## 4. Catatan Penting

- File `.env` server jangan di-commit ke GitHub.
- Akun admin awal dibuat dari `AFBS_ADMIN_EMAIL`, `AFBS_ADMIN_PASSWORD`, dan `AFBS_ADMIN_NAME` saat seeder berjalan.
- Jika database server sudah terlanjur kosong dan login gagal, jalankan:

```bash
cd ~/laravel-lokersmaafbs
PHP_BIN=/opt/cpanel/ea-php82/root/usr/bin/php bash scripts/ssh-update.sh
```

- Folder upload pelamar tetap berada di `~/laravel-lokersmaafbs/storage/app/private`.
- Document root domain/subdomain di cPanel harus diarahkan ke `public_html/web/www.karir`.
- Jika hosting tidak punya Composer, jalankan `composer install --no-dev --optimize-autoloader` di lokal lalu upload folder `vendor/` secara manual.
