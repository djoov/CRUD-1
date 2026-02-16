# Proyek CRUD-1

Implementasi sederhana dari operasi CRUD (Create, Read, Update, Delete) menggunakan PHP dan PostgreSQL. Proyek ini juga menyediakan API sederhana untuk mengelola.

## Fitur

* **Manajemen Aset:**
    * Menambahkan aset baru ke dalam database.
    * Menampilkan daftar semua aset yang ada.
    * Mengedit informasi aset yang sudah ada.
    * Menghapus aset dari database.
* **API Sederhana:**
    * Menyediakan endpoint RESTful untuk berinteraksi dengan data aset secara terprogram.
* **Antarmuka Pengguna:**
    * Antarmuka yang bersih dan responsif menggunakan Bootstrap.

## Teknologi yang Digunakan

* **Backend:** PHP
* **Database:** PostgreSQL
* **Frontend:** HTML, Bootstrap 5

## Penyiapan dan Instalasi

Untuk menjalankan proyek ini di lingkungan lokal Anda, ikuti langkah-langkah berikut:

### 1. **Prasyarat**
Pastikan Anda memiliki server web lokal (seperti Apache atau Nginx) dengan PHP dan server database PostgreSQL yang sudah terpasang dan berjalan.

### 2. **Konfigurasi Database**
1.  Buat database baru di PostgreSQL. Anda bisa menggunakan nama `postgres` atau nama lain sesuai keinginan.
2.  Buka file `config.php` dan sesuaikan detail koneksi database:
    ```php
    $host     = 'localhost';
    $port     = '5432'; // Sesuaikan dengan port PostgreSQL Anda
    $dbname   = 'postgres'; // Sesuaikan dengan nama database Anda
    $user     = 'postgres'; // Sesuaikan dengan username PostgreSQL Anda
    $password = 'your_postgres_password'; // Ganti dengan password Anda
    ```
3.  Buat tabel `aset` di dalam database Anda. Anda bisa menggunakan skema dari file `aset_202506201501.sql` atau menjalankan query SQL berikut untuk membuat struktur tabel dan mengimpor data contoh:
    ```sql
    -- Anda perlu membuat tabel 'aset' terlebih dahulu jika belum ada.
    -- Struktur tabelnya kira-kira seperti ini (berdasarkan file PHP):
    CREATE TABLE public.aset (
        id_aset SERIAL PRIMARY KEY,
        kode_asset VARCHAR(255) UNIQUE NOT NULL,
        nama_asset VARCHAR(255) NOT NULL,
        jenis_asset VARCHAR(255),
        deskripsi_asset TEXT,
        tahun_pengadaan VARCHAR(4)
    );

    -- Impor data contoh dari file aset_202506201501.sql
    INSERT INTO public.aset (nama_asset, jenis_asset, deskripsi_asset, tahun_pengadaan, kode_asset) VALUES
    ('Komputer Dell OptiPlex', 'Elektronik', 'Komputer untuk staff administrasi', '2023', 'PC-001'),
    ('Meja Kerja Olympic', 'Furnitur', 'Meja kerja kayu dengan 3 laci', '2022', 'MJ-001'),
    ('Kursi Direktur Chairman', 'Furnitur', 'Kursi hidrolik kulit warna hitam', '2022', 'CRS-001'),
    ('Proyektor Epson EB-X500', 'Elektronik', 'Proyektor untuk ruang meeting utama', '2024', 'PRJ-001'),
    ('AC Daikin 1 PK', 'Elektronik', 'Pendingin ruangan untuk lobi', '2023', 'AC-001');
    ```

### 3. **Jalankan Aplikasi**
1.  Salin semua file proyek ke direktori root server web Anda (misalnya, `htdocs` untuk XAMPP atau `www` untuk WampServer).
2.  Buka browser Anda dan navigasikan ke `http://localhost/nama_folder_proyek/list.php` untuk melihat daftar aset.

## Endpoint API

API dapat diakses melalui file `api.php`. Berikut adalah endpoint yang tersedia:

| Method | Endpoint | Deskripsi |
| --- | --- | --- |
| `GET` | `/api.php/aset` | Mendapatkan daftar semua aset. |
| `GET` | `/api.php/aset/{id}` | Mendapatkan detail aset berdasarkan ID. |
| `POST` | `/api.php/aset` | Membuat aset baru. Data dikirim dalam format JSON. |
| `PUT` / `PATCH` | `/api.php/aset/{id}` | Memperbarui data aset berdasarkan ID. Data dikirim dalam format JSON. |
| `DELETE` | `/api.php/aset/{id}` | Menghapus aset berdasarkan ID. |

### Contoh Penggunaan API dengan cURL:

* **Mendapatkan semua aset:**
    ```bash
    curl http://localhost/nama_folder_proyek/api.php/aset
    ```

* **Membuat aset baru:**
    ```bash
    curl -X POST -H "Content-Type: application/json" -d '{"kode_asset": "LP-001", "nama_asset": "Laptop Acer", "jenis_asset": "Elektronik"}' http://localhost/nama_folder_proyek/api.php/aset
    ```
