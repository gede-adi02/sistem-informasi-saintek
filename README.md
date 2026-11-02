# Documentasi & Panduan Pengujian Proyek SIAKAD Fakultas Saintek

Dokumentasi ini berisi panduan langkah demi langkah untuk mengunggah, mengimpor database, mengkonfigurasi file koneksi, dan menjalankan Sistem Informasi Akademik & Kepegawaian Fakultas Sains dan Teknologi di lingkungan *server* lokal **Laragon**.

---

## Prasyarat Sistem

Sebelum memulai instalasi, pastikan komputer/laptop telah terpasang perangkat lunak berikut:

* **Laragon** (disarankan versi terbaru dengan **PHP >= 8.0** dan **MySQL/MariaDB**).
* Web Browser (Google Chrome, Mozilla Firefox, atau Microsoft Edge).

---

## 1. Menempatkan Source Code di Laragon

1. Unduh atau ekstrak *source code* proyek ini.
2. Salin (*copy*) seluruh folder proyek ke direktori *root* web Laragon yang berlokasi di:
```text
C:\laragon\www\sistem-informasi-saintek

```


3. Pastikan struktur folder utama di dalam `C:\laragon\www\sistem-informasi-saintek` tampak seperti berikut:
```text
sistem-informasi-saintek/
├── app/
│   ├── config/
│   ├── controllers/
│   ├── models/
│   └── views/
├── assets/
├── index.php
└── db_saintek.sql

```



---

## 2. Mengimpor Database MySQL (`db_saintek.sql`)

1. Buka aplikasi **Laragon**, lalu klik tombol **Start All** untuk menjalankan service **Apache** dan **MySQL**.
2. Buka **phpMyAdmin** melalui browser pada alamat `http://localhost/phpmyadmin` (atau gunakan menu **Database / HeidiSQL** bawaan Laragon).
3. Buat basis data (*database*) baru:
* Klik menu **New / Baru** pada panel kiri phpMyAdmin.
* Masukkan nama database: `db_saintek`
* Klik **Create / Buat**.


4. Impor berkas tabel dan data:
* Pilih database `db_saintek` yang baru dibuat.
* Klik tab **Import** di bagian atas.
* Klik **Choose File** / **Pilih Berkas** dan arahkan ke file `db_saintek.sql` yang berada di folder proyek.
* Scroll ke bawah lalu klik tombol **Import** / **Kirim**.
* Pastikan muncul pesan sukses bahwa seluruh tabel (`tb_user`, `tb_mahasiswa`, `tb_dosen`, `tb_pegawai`, `tb_pengumuman`) berhasil diimpor.



---

## 3. Mengonfigurasi Koneksi Database (`Database.php`)

1. Buka folder proyek di `app/config/`.
2. Temukan file bernama `Database.php.example`.
3. Buat salinan atau ubah nama file (*rename*) tersebut menjadi **`Database.php`**.
4. Buka file `app/config/Database.php` menggunakan kode editor (VS Code/Notepad++) dan sesuaikan variabel koneksi PDO seperti di bawah ini:

```php
<?php 

class Database {
    private $host   = 'localhost';
    private $user   = 'root';      // User default MySQL Laragon
    private $pass   = '';          // Password default MySQL Laragon (kosong)
    private $dbname = 'db_saintek';

    protected $conn;

    public function __construct() {
        try {
            $this->conn = new PDO("mysql:host={$this->host};dbname={$this->dbname}", $this->user, $this->pass);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Koneksi database gagal: " . $e->getMessage());
        }
    }
}

```

---

## 4. Menjalankan Aplikasi di Browser

Setelah *service* Laragon berjalan, database terimpor, dan koneksi terpasang, akses aplikasi melalui *browser* menggunakan salah satu tautan berikut:

* **Tautan Standar Localhost:**
`http://localhost/sistem-informasi-saintek`
* **Tautan Virtual Host Laragon (Jika fitur Auto-Virtual Host aktif):**
`[http://sistem-informasi-saintek.test](http://sistem-informasi-saintek.test)`

---

## 5. Akun Pengujian Sistem (Dummy Login)

Gunakan daftar akun di bawah ini untuk menguji fitur *Role-Based Access Control* (RBAC) pada masing-masing tingkatan *user*:

| Role / Level | Username | Password | Hak Akses Utama |
| --- | --- | --- | --- |
| **Admin** | `admin2` | `admin321` | Akses Penuh (CRUD User, Mahasiswa, Dosen, Pegawai, Pengumuman) |
| **Dosen** | `dosen2` | `dosen321` | Lihat Data Mahasiswa, Dosen, Pengumuman, Ekspor Data |
| **Pegawai** | `pegawai2` | `pegawai321` | Olah Data Mahasiswa, Dosen, Pegawai, Buat Pengumuman |
| **Mahasiswa** | `mahasiswa2` | `mahasiswa321` | Lihat Dashboard, Pengumuman, & Data Mahasiswa (Read-Only) |

---

## Fitur Utama Sistem

* **Autentikasi & RBAC (Matrix Role Access):** Keamanan hak akses bertingkat untuk Admin, Dosen, Pegawai, dan Mahasiswa.
* **Manajemen Data Akademik:** Kelola data Mahasiswa, Dosen, dan Pegawai secara dinamis.
* **Fitur Laporan:** Ekspor data ke format **Excel (`.xls`)** dan fitur **Cetak / PDF**.
* **Pusat Pengumuman:** Publikasi informasi akademik & kemahasiswaan berbasis kategori.
* **Proteksi Keamanan:** Validasi input sanitasi sisi *server*, enkripsi password `Bcrypt`, serta perlindungan terhadap SQL Injection menggunakan PDO Prepared Statement.