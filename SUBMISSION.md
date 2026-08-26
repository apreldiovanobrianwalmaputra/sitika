# SUBMISSION.md

## Identitas

**Nama:** Apreldiovano Brian Walmaputra  
**NIM:** 2330305030089  
**Project:** SITIKA - Sistem Tiket Dukungan TI

---

## Ringkasan Pengerjaan

SITIKA merupakan aplikasi web berbasis Laravel untuk mencatat dan mengelola tiket dukungan TI. Sistem memiliki dua role utama, yaitu **PELAPOR** dan **TEKNISI**, dengan pembatasan akses sesuai hak masing-masing pengguna.

Project dikembangkan menggunakan Laravel, MySQL/MariaDB, Blade, JavaScript, Fetch API/AJAX, serta Laravel Sanctum untuk REST API.

---

## Status Requirement R1-R9

| Requirement | Status | Keterangan |
|---|---|---|
| R1 - Setup & Database | ✅ Selesai | Migration, model, relationship, seeder, dan data demo tersedia serta dapat dijalankan ulang dari database kosong. |
| R2 - Login & Logout | ✅ Selesai | Login berdasarkan akun demo, password tersimpan dalam bentuk hash, session diregenerasi, dan logout mengakhiri session. |
| R3 - Dashboard | ✅ Selesai | Dashboard menampilkan Total, OPEN, IN_PROGRESS, RESOLVED, dan 5 tiket terbaru sesuai hak akses pengguna. |
| R4 - Pembuatan Tiket | ✅ Selesai | Pelapor dapat membuat tiket dengan kategori, judul, lokasi, deskripsi, dan urgensi. Kode tiket serta status dibuat oleh server. |
| R5 - Daftar, Detail & Riwayat | ✅ Selesai | Pelapor hanya dapat melihat tiket miliknya sendiri, Teknisi dapat melihat seluruh tiket, detail menampilkan riwayat aktivitas. |
| R6 - Pencarian & Filter | ✅ Selesai | Mendukung pencarian kode/judul serta filter kategori, urgensi, dan status secara bersamaan. |
| R7 - Workflow Status | ✅ Selesai | Teknisi dapat mengubah status sesuai alur OPEN → IN_PROGRESS → RESOLVED. Catatan penyelesaian wajib minimal 10 karakter. |
| R8 - AJAX | ✅ Selesai | Perubahan status tiket menggunakan Fetch API/AJAX tanpa reload, dilengkapi loading, success, dan error state. |
| R9 - UI/UX | ✅ Selesai | Tampilan responsif desktop/mobile, navigasi jelas, form dan tabel responsif, empty state, serta halaman error 403 dan 404. |

---

## Nilai Tambah

### 1. REST API

**Status:** ✅ Selesai

Endpoint yang tersedia:

- `POST /api/v1/login`
- `POST /api/v1/logout`
- `GET /api/v1/tickets`
- `GET /api/v1/tickets/{code}`
- `POST /api/v1/tickets`
- `PATCH /api/v1/tickets/{code}/status`

REST API menggunakan **Laravel Sanctum** untuk autentikasi Bearer Token.

Hak akses API mengikuti role pengguna:
- PELAPOR hanya dapat melihat tiket miliknya sendiri.
- PELAPOR dapat membuat tiket.
- PELAPOR tidak dapat mengubah status tiket.
- TEKNISI dapat melihat seluruh tiket dan mengubah status tiket.

Response API menggunakan HTTP status yang sesuai seperti:
- `200 OK`
- `201 Created`
- `401 Unauthorized`
- `403 Forbidden`
- `404 Not Found`
- `422 Unprocessable Content`

### 2. Analisis Data

**Status:** ✅ Selesai

Analisis data tersedia pada dashboard TEKNISI dan menampilkan:

- Tingkat penyelesaian tiket.
- Rata-rata waktu penyelesaian tiket.
- Jumlah lokasi berbeda yang tercatat.
- Grafik tiket berdasarkan kategori.
- Grafik tiket berdasarkan urgensi.

Analisis tidak ditampilkan kepada PELAPOR.

### 3. Jaringan Komputer

**Status:** ✅ Selesai

Halaman informasi jaringan tersedia di:

```text
/network-info
```

Informasi yang ditampilkan meliputi:

- IP Client.
- Jenis IP Client.
- IP Server.
- Jenis IP Server.
- Host.
- Port.
- Protokol.
- Skema HTTP/HTTPS.
- User Agent.

Halaman hanya dapat diakses oleh TEKNISI. PELAPOR akan mendapatkan halaman **403 Akses Ditolak**.

---

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

---

## Data Demo

Seeder menyediakan:

- 3 pengguna.
- 3 kategori: Perangkat, Jaringan, Aplikasi.
- 6 tiket demo.

Ringkasan tiket awal:

```text
Total       : 6
OPEN        : 3
IN_PROGRESS : 1
RESOLVED    : 2
```

Database dapat dibangun kembali dari kondisi kosong menggunakan:

```bash
php artisan migrate:fresh --seed
```

---

## Keputusan Desain

1. Role disimpan pada tabel `users` untuk membedakan hak akses PELAPOR dan TEKNISI.
2. Kode tiket dibuat di sisi server agar pengguna tidak dapat memanipulasi kode.
3. Route model binding menggunakan field `code` agar detail tiket dapat diakses melalui kode tiket.
4. Hak akses tetap divalidasi di server, bukan hanya disembunyikan dari tampilan.
5. Perubahan status dibatasi ke alur OPEN → IN_PROGRESS → RESOLVED.
6. Setiap aktivitas penting dicatat ke `ticket_logs`.
7. Fetch API/AJAX digunakan untuk perubahan status agar halaman tidak perlu reload.
8. Laravel Sanctum digunakan untuk autentikasi REST API.
9. Analisis data hanya ditampilkan kepada Teknisi.
10. Informasi jaringan dibatasi untuk Teknisi.

---

## Validasi dan Keamanan

Sistem menerapkan:

- Validasi server-side.
- Password hashing.
- Middleware autentikasi.
- Pembatasan akses berdasarkan role.
- Pencegahan akses tiket milik pengguna lain melalui manipulasi URL.
- Validasi alur perubahan status.
- Catatan penyelesaian minimal 10 karakter.
- CSRF protection pada form web.
- Bearer Token Laravel Sanctum pada REST API.
- Custom error page 403 dan 404.
- File `.env` tidak disertakan dalam repository.

---

## Pengujian

Pengujian utama yang dilakukan:

- Login dan logout ketiga akun demo.
- Dashboard Pelapor Satu, Pelapor Dua, dan Teknisi.
- Pembatasan akses tiket milik pelapor lain.
- Pembuatan tiket baru.
- Pencarian dan filter tiket.
- Workflow OPEN → IN_PROGRESS → RESOLVED.
- Penolakan perubahan status tidak valid.
- Validasi catatan penyelesaian minimal 10 karakter.
- AJAX tanpa reload dan data tetap tersimpan setelah refresh.
- Halaman 403 dan 404.
- Responsive desktop dan mobile.
- REST API dengan dan tanpa token.
- Pembatasan role pada REST API.
- Analisis data pada dashboard Teknisi.
- Informasi jaringan khusus Teknisi.

---

---

## Dokumentasi Tambahan

Project dilengkapi dengan:

- `README.md`
- `SUBMISSION.md`
- `BUILD_LOG.txt`
- Riwayat Git asli pada folder `.git`
- Folder `evidence`

Riwayat commit dapat dilihat menggunakan:

```bash
git log --oneline --all
```

---

## Keterbatasan Sistem

- Aplikasi dijalankan pada lingkungan lokal menggunakan Laravel development server.
- Deployment production tidak termasuk dalam ruang lingkup project.
- Email notification belum diimplementasikan.
- Upload attachment belum diimplementasikan.
- Realtime notification belum diimplementasikan.

---

## Waktu Pengerjaan

Project dikerjakan secara bertahap dengan commit terpisah untuk fitur utama, mulai dari setup Laravel, database, autentikasi, dashboard, pengelolaan tiket, AJAX, REST API, analisis data, hingga informasi jaringan. Project SITIKA dikerjakan pada **26 Agustus 2026**, mulai pukul **09.00 hingga 15.00 WIB**, bertempat di **Laboratorium AP-1 Teknik Informatika Universitas Palangka Raya (UPR)**.

---

## Kesimpulan

Seluruh requirement wajib **R1-R9 telah diselesaikan**. Selain fitur wajib, project juga dilengkapi dengan **REST API**, **Analisis Data**, dan **Informasi Jaringan** sebagai nilai tambah.
