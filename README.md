# SiKampus Admin Panel

Proyek ini adalah panel admin untuk sistem informasi akademik SiKampus. Fungsinya mencakup otentikasi admin, navigasi sidebar, dark mode, dan manajemen data mahasiswa serta dosen.

## Struktur Utama

- `dashboard.php` — Halaman dashboard utama.
- `index.php` — Halaman umum / placeholder.
- `templates/` — Layout bersama:
  - `header.php`
  - `sidebar.php`
  - `footer.php`
- `assets/css/` — Style global dan layout.
- `assets/js/app.js` — Logika dark mode dan sidebar toggle.
- `auth/` — Autentikasi:
  - `login.php`
  - `auth-ceck.php`
  - `logout.php`
- `config/` — Koneksi dan middleware.
- `modules/` — Modul data:
  - `mahasiswa/`
  - `dosen/`
- `schema.sql` — Struktur database.
- `seederdosen.php`, `seedermhs.php` — Skrip seed data awal.

## Progres Saat Ini

- Layout header/sidebar sudah dibuat dan terintegrasi.
- Dark mode toggle berfungsi menggunakan `data-bs-theme`.
- Sidebar collapse toggle sudah didukung oleh `assets/js/app.js`.
- Import CSS/JS sudah diperbaiki agar menggunakan `BASE_URL`.
- Modul `modules/mahasiswa/index.php` sudah memiliki:
  - pencarian (`q`)
  - pagination dengan `Previous` / `Next`
  - styling warna aktif menggunakan `var(--prussian-blue)`.
- Authentication flow ada di `auth/` dan middleware dipanggil dari modul.
- Struktur database dan seeders sudah tersedia untuk data awal.

## Catatan `.gitignore`

Jangan masukkan file sumber kode atau aset yang diperlukan ke `.gitignore`, seperti:

- `*.php`
- `assets/`
- `templates/`
- `config/`
- `modules/`
- `schema.sql`
- `seederdosen.php`
- `seedermhs.php`

File-file tersebut harus tetap berada di kontrol versi.

## Rencana Selanjutnya

- Lengkapi CRUD untuk `modules/mahasiswa` dan `modules/dosen`.
- Selesaikan halaman detail dan formulir create/edit.
- Tambahkan validasi input dan proteksi CSRF.
- Perbaiki responsif sidebar untuk perangkat mobile.
- Tambahkan dokumentasi setup untuk database dan `BASE_URL`.
