# Simple POS (Point of Sales)

Simple POS adalah aplikasi Point of Sales berbasis web yang dibangun dengan kerangka kerja **Laravel 12** dan dikelola penuh antarmukanya melalui **Filament v4**. Proyek ini ditujukan untuk mempermudah pencatatan transaksi penjualan, manajemen inventaris, dan pembuatan laporan.

## Teknologi yang Digunakan

- [PHP 8.2+](https://php.net/)
- [Laravel 12.0](https://laravel.com/)
- [Filament 4.0](https://filamentphp.com/) (TALL Stack: Tailwind CSS, Alpine.js, Laravel, Livewire)
- [Maatwebsite Excel](https://laravel-excel.com/) (Ekspor Excel)
- [Laravel DomPDF](https://github.com/barryvdh/laravel-dompdf) (Ekspor PDF)
- Pest PHP (Testing)

## Panduan Instalasi (Development)

Ikuti langkah-langkah di bawah ini untuk menjalankan proyek secara lokal:

1. **Clone repositori ini:**

    ```bash
    git clone <url-repo-kamu>
    cd simple-pos
    ```

2. **Install dependensi PHP via Composer:**

    ```bash
    composer install
    ```

3. **Duplikat file environment dan sesuaikan konfigurasi database (.env):**

    ```bash
    cp .env.example .env
    ```

4. **Generate Application Key:**

    ```bash
    php artisan key:generate
    ```

5. **Lakukan Migrasi & Seeding Database:**

    ```bash
    php artisan migrate --seed
    ```

    _(Catatan: pastikan telah membuat/menyiapkan database sebelum step ini dan mengonfigurasinya di file `.env`)_

6. **Kompilasi Aset Frontend (Filament / Vite):**

    ```bash
    npm install
    npm run build
    ```

    _(Atau `npm run dev` jika kamu sedang melakukan proses development aset)_

7. **Jalankan Local Development Server:**
    ```bash
    php artisan serve
    ```

## Akses Panel Admin

Kamu dapat mengakses sistem dashboard POS (Filament Panel) di rute default aplikasi, biasanya di:

```
http://localhost:8000/admin
```
