# SITIKA — Sistem Tiket Dukungan TI

SITIKA adalah sistem tiket dukungan TI berbasis Laravel yang membantu pelapor membuat dan memantau tiket, serta membantu teknisi mengelola proses penanganan hingga penyelesaian. Sistem dilengkapi REST API, AJAX, analisis data, dan informasi jaringan.

## Fitur Utama

### PELAPOR
- Login dan logout.
- Melihat dashboard tiket milik sendiri.
- Membuat tiket dukungan TI.
- Melihat daftar dan detail tiket milik sendiri.
- Melihat riwayat perubahan status tiket.
- Mencari dan memfilter tiket berdasarkan kode, judul, kategori, urgensi, dan status.
- Tidak dapat melihat tiket milik pelapor lain.
- Tidak dapat mengubah status tiket.

### TEKNISI
- Login dan logout.
- Melihat seluruh tiket.
- Mencari dan memfilter tiket.
- Melihat detail dan riwayat tiket.
- Mengubah status tiket sesuai alur:
  - `OPEN`
  - `IN_PROGRESS`
  - `RESOLVED`
- Mengisi catatan penyelesaian saat tiket diselesaikan.
- Mengubah status melalui Fetch/AJAX tanpa reload halaman.
- Melihat analisis data tiket.
- Melihat informasi diagnostik jaringan.

## Alur Status Tiket

Status tiket hanya dapat berubah dengan urutan:

```text
OPEN -> IN_PROGRESS -> RESOLVED
```

Perubahan status di luar alur tersebut akan ditolak oleh server.

Saat tiket diubah menjadi `RESOLVED`, teknisi wajib mengisi catatan penyelesaian minimal **10 karakter**.

## Format Kode Tiket

Kode tiket dibuat otomatis oleh server dengan format:

```text
TKT-YYYYMMDD-NNNN
```

Contoh:

```text
TKT-20260826-0001
```

## Teknologi

- PHP 8.2+
- Laravel 12
- MySQL / MariaDB
- Blade
- HTML
- CSS
- JavaScript
- Fetch API / AJAX
- Laravel Sanctum
- REST API
- Git

## Instalasi

### 1. Clone repository

```bash
git clone https://github.com/apreldiovanobrianwalmaputra/sitika.git
cd sitika
```

### 2. Install dependency

```bash
composer install
```

### 3. Buat file `.env`

PowerShell:

```powershell
Copy-Item .env.example .env
```

### 4. Generate application key

```bash
php artisan key:generate
```

### 5. Buat database

Buat database MySQL/MariaDB dengan nama:

```text
sitika
```

Contoh konfigurasi database pada `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sitika
DB_USERNAME=root
DB_PASSWORD=
```

### 6. Jalankan migration dan seeder

```bash
php artisan migrate:fresh --seed
```

### 7. Jalankan aplikasi

```bash
php artisan serve
```

Buka:

```text
http://127.0.0.1:8000
```

## Akun Demo

### Pelapor Satu

```text
Email    : pelapor1@demo.local
Password : Magang123!
Role     : PELAPOR
```

### Pelapor Dua

```text
Email    : pelapor2@demo.local
Password : Magang123!
Role     : PELAPOR
```

### Teknisi TI

```text
Email    : teknisi@demo.local
Password : Magang123!
Role     : TEKNISI
```

Password tersimpan dalam bentuk hash di database.

## Analisis Data

Dashboard teknisi memiliki fitur analisis data berupa:

- Tingkat penyelesaian tiket.
- Rata-rata waktu penyelesaian.
- Jumlah lokasi berbeda yang tercatat.
- Grafik tiket berdasarkan kategori.
- Grafik tiket berdasarkan urgensi.

Fitur analisis hanya dapat dilihat oleh **TEKNISI**.

## Informasi Jaringan

Teknisi dapat membuka:

```text
/network-info
```

Halaman ini menampilkan informasi diagnostik jaringan, seperti:

- IP client.
- Jenis IP client.
- IP server.
- Jenis IP server.
- Host.
- Port.
- Protokol.
- Skema HTTP/HTTPS.
- User Agent.

Pelapor tidak memiliki akses ke halaman ini.

## Keamanan dan Hak Akses

- Password disimpan dalam bentuk hash.
- Halaman aplikasi dilindungi autentikasi.
- Pelapor hanya dapat melihat tiket miliknya sendiri.
- Teknisi tidak dapat membuat tiket sebagai pelapor.
- Pelapor tidak dapat mengubah status tiket.
- Validasi dilakukan di sisi server.
- REST API menggunakan Laravel Sanctum.
- `.env` tidak disimpan di repository.
- Error 403 dan 404 memiliki halaman khusus.

## Developer

**Apreldiovano Brian Walmaputra**

Project: **SITIKA — Sistem Tiket Dukungan TI**
