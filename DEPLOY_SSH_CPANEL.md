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
bash scripts/ssh-update.sh
```

Script akan:

- menarik kode terbaru dari branch `main`
- menjalankan `composer install --no-dev`
- membuat `APP_KEY` jika masih kosong
- menjalankan migration MySQL
- membuat cache Laravel
- menyalin isi `public/` ke `~/public_html/web/www.karir`
- mengganti `~/public_html/web/www.karir/index.php` agar menunjuk ke `~/laravel-lokersmaafbs`

## 3. Update Berikutnya Setelah Push

Setelah perubahan sudah di-push ke GitHub, cukup SSH lalu jalankan:

```bash
cd ~/laravel-lokersmaafbs
bash scripts/ssh-update.sh
```

## 4. Catatan Penting

- File `.env` server jangan di-commit ke GitHub.
- Folder upload pelamar tetap berada di `~/laravel-lokersmaafbs/storage/app/private`.
- Document root domain/subdomain di cPanel harus diarahkan ke `public_html/web/www.karir`.
- Jika hosting tidak punya Composer, jalankan `composer install --no-dev --optimize-autoloader` di lokal lalu upload folder `vendor/` secara manual.
