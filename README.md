# 📦 LabShare (Classroom Asset Repository)

![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel)
![TailwindCSS](https://img.shields.io/badge/Tailwind_CSS-3.0-38B2AC?style=for-the-badge&logo=tailwind-css)
![Status](https://img.shields.io/badge/Status-Under_Development-yellow?style=for-the-badge)

**LabShare** adalah platform manajemen aset kelas berbasis web yang dirancang untuk memudahkan distribusi materi praktikum (gambar, teks, link, PDF) di laboratorium komputer.

Proyek ini dibuat untuk menyelesaikan masalah login WhatsApp Web di PC publik (Lab) yang berisiko keamanan dan tidak efisien. Dengan LabShare, perwakilan cukup upload materi sekali, dan mahasiswa dapat mengaksesnya langsung via browser tanpa login pribadi.

---

## ✨ Fitur Utama

### 🛡️ Role Management (via Laravel Spatie)
1.  **Superadmin**:
    * Kontrol penuh atas sistem, pengguna, dan semua file.
    * Manajemen Mata Kuliah (Subjects).
2.  **Admin (Komti/Asisten)**:
    * Upload, Edit, dan Hapus materi praktikum (CRUD Files).
    * Mendukung berbagai tipe: File (ZIP/PDF), Gambar, Link, dan Text.
3.  **User (Mahasiswa)**:
    * Akses cepat ke materi.
    * Download file dan preview materi.

### 🚀 Teknologi yang Digunakan
* **Framework**: [Laravel 12](https://laravel.com)
* **Authentication**: [Laravel Breeze](https://laravel.com/docs/starter-kits#laravel-breeze)
* **Authorization**: [Spatie Laravel Permission](https://spatie.be/docs/laravel-permission/v6/introduction)
* **Icons**: [Laravel Blade Icons](https://github.com/blade-ui-kit/blade-icons)
* **Styling**: Tailwind CSS

---

## 🛠️ Instalasi & Menjalankan Project

Ikuti langkah berikut untuk menjalankan project ini di komputer lokal (Localhost).

### Prasyarat
* PHP >= 8.2
* Composer
* Node.js & NPM
* MySQL

### Langkah-langkah

1.  **Clone Repositori**
    ```bash
    git clone [https://github.com/ahmadrido/labshare.git](https://github.com/ahmadrido/labshare.git)
    cd labshare
    ```

2.  **Install Dependensi PHP & JavaScript**
    ```bash
    composer install
    npm install
    ```

3.  **Setup Environment**
    Duplikat file `.env.example` menjadi `.env`:
    ```bash
    cp .env.example .env
    ```
    Buka file `.env` dan sesuaikan konfigurasi database:
    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=labshare_db
    DB_USERNAME=root
    DB_PASSWORD=
    ```

4.  **Generate App Key**
    ```bash
    php artisan key:generate
    ```

5.  **Migrasi Database & Seeder**
    Jalankan migrasi dan isi data awal (Role & Akun Default):
    ```bash
    php artisan migrate --seed
    ```

6.  **Jalankan Server**
    Buka dua terminal terpisah:
    ```bash
    # Terminal 1 (Backend)
    php artisan serve

    # Terminal 2 (Frontend Assets)
    npm run dev
    ```

7.  **Akses Aplikasi**
    Buka browser dan kunjungi: `http://localhost:8000`

---

## 👤 Akun Demo (Seeder)

Jika Anda menjalankan `php artisan migrate --seed`, akun berikut tersedia:

| Role | Email | Password |
| :--- | :--- | :--- |
| **Superadmin** | `superadmin@lab.com` | `password` |
| **Admin** | `admin@lab.com` | `password` |
| **User** | `user@lab.com` | `password` |

---

## 📂 Struktur Database

* `users`: Data pengguna.
* `roles` & `permissions`: Hak akses (Spatie).
* `subjects`: Kategori mata kuliah (contoh: Web Prog, Jarkom).
* `materials`: Menyimpan path file, link, atau text yang diupload.

---

## 📝 Todo / Roadmap
- [ ] Fitur Preview PDF langsung di browser.
- [ ] Fitur "Bulk Download" (Download semua materi dalam satu folder).
- [ ] Expired Link (Materi otomatis hilang setelah waktu tertentu).

---

### Credits
Dibuat untuk Projek UTS Mata Kuliah Pemrograman FRONTEND oleh Ahmad Rido Kamaludin ( 1003240019 ).
