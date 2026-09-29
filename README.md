# Company Profile & API Backend

## Prasyarat

Pastikan sudah terinstall di komputer Anda:

- PHP **8.3** atau lebih baru 
- [Composer](https://getcomposer.org)
- Node.js **18+** dan npm
- Database **MySQL**

## Instalasi

### 1. Clone project & masuk ke folder

```bash
git clone https://github.com/mas-yan/comprof
cd be
```

### 2. Install dependency

```bash
composer install
npm install
```

### 3. Salin file environment & generate application key

```bash
cp .env.example .env
php artisan key:generate
```

### 4. Konfigurasi database

Buka file `.env`, lalu sesuaikan koneksi database. Ada dua opsi:

**Opsi A — MySQL (disarankan untuk data yang lebih permanen)**

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=backend
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Jalankan migrasi

```bash
php artisan migrate
```

### 6. Buat symbolic link storage

Wajib dijalankan agar gambar yang diupload (logo, galeri, produk, dsb.) bisa diakses lewat browser di `/storage/...`.

```bash
php artisan storage:link
```

### 7. Jalankan seeder

```bash
php artisan db:seed
```

### 8. Jalankan aplikasi

```bash
php artisan serve
```

Atau jalankan server + queue worker + Vite sekaligus dalam satu perintah:

```bash
composer run dev
```

Buka:
- **Halaman utama**: http://localhost:8000
- **Panel admin**: http://localhost:8000/admin

## Mengelola Konten lewat Admin

Setelah login ke `/admin`, konten halaman utama dikelola lewat menu di grup **Website**:

| Menu | Keterangan |
|---|---|
| Profil Perusahaan | Data utama perusahaan (nama, logo, gambar hero, deskripsi, kontak, sosial media). **Hanya bisa 1 data** — tombol "New" otomatis hilang kalau sudah ada satu. |
| Produk & Layanan | Ditampilkan sebagai slider auto-play di halaman utama |
| Galeri | Ditampilkan sebagai carousel auto-play |
| Kenapa Memilih Kami | Kartu keunggulan dengan pilihan ikon |
| Pelanggan/Klien | Logo klien, ditampilkan sebagai marquee berjalan |
| Testimoni | Ulasan pelanggan dengan rating bintang |
| FAQ | Ditampilkan sebagai accordion |

Semua resource di atas punya kolom **aktif/nonaktif** dan bisa diurutkan (drag & drop) — hanya data yang aktif yang tampil di halaman utama.

