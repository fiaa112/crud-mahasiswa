# Sistem Akademik Mahasiswa

Aplikasi web untuk mengelola data mahasiswa dengan mudah dan efisien. Dibangun menggunakan PHP, MySQL, dan Tailwind CSS dengan tampilan modern dark mode.

## Fitur

- Dashboard statistik (total mahasiswa, jumlah mahasiswa laki-laki & perempuan)
- CRUD data mahasiswa (Create, Read, Update, Delete)
- Responsive design (mobile, tablet, desktop)
- Dark mode interface
- Real-time form validation
- Sweet Alert notifications

## Teknologi yang Digunakan

- PHP 8.0+
- MySQL/MariaDB
- Tailwind CSS
- JavaScript
- SweetAlert2
- PDO Database Connection

## Cara Instalasi

1. Clone repository ini ke folder htdocs XAMPP:
   ```bash
   git clone [https://github.com/username/mahasiswa-project.git](https://github.com/fiaa112/crud-mahasiswa.git)
   ```

2. Import database:
    - Buka phpMyAdmin (http://localhost/phpmyadmin)
    - Buat database baru dengan nama db_mahasiswa
    - Import file db_mahasiswa.sql dari folder database

3. Konfigurasi database:
    - Buka file config/database.php
    - Sesuaikan kredensial database jika berbeda
    ```bash
        $host = "localhost";
        $username = "root";
        $password = "";
        $database = "db_mahasiswa";
    ```

4. Cara Menjalankan
    - Start XAMPP (Apache & MySQL)
    - Buka browser
    - Akses aplikasi di: http://localhost/mahasiswa-project

5. Struktur Folder
    mahasiswa-project/
    ├── config/
    │   └── database.php
    ├── pages/
    │   ├── dashboard/
    │   ├── edit/
    │   └── hapus/
    ├── database/
    │   └── db_mahasiswa.sql
    └── README.md
