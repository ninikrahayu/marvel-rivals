<div align="center">
  <img src="assets/logo/marvel-logo.png" alt="Marvel Rivals Logo" width="300">
  <h1 align="center">Marvel Rivals</h1>

  <p align="center">
    <strong>Game strategi pertarungan turn-based berbasis web yang dibangun dengan PHP Native dan MySQL.</strong>
  </p>
</div>

<br>

## 📝 Deskripsi

**Marvel Rivals** adalah game RPG strategi sederhana berbasis web. Pemain dapat membuat akun, memilih superhero Marvel favorit mereka, dan bertarung melawan musuh bot dalam sistem *turn-based*. Pemain harus mengatur strategi penggunaan *Energy* dan *Health* untuk memenangkan pertarungan dan membuka level selanjutnya yang lebih sulit.

## 📸 Tampilan Aplikasi
[![Watch the video](https://img.youtube.com/vi/80yypVWcjnQ/maxresdefault.jpg)](https://youtu.be/80yypVWcjnQ)
### [Full Video](https://youtu.be/80yypVWcjnQ)

## ✨ Fitur Utama

* **Manajemen Akun**: 
  Pengguna dapat melakukan **Registrasi** akun baru dan **Login** untuk mengakses permainan.
* **Sistem Level**: 
  Terdapat mekanisme pembukaan level. Pemain memulai dari **Level 1**, dan **Level 2** akan terbuka secara otomatis apabila pemain berhasil mengalahkan musuh di level pertama.
* **Pilihan Karakter**: 
  Tersedia 5 karakter Marvel (Captain America, Iron Man, Hawkeye, Hulk, Spider-Man). Setiap karakter memiliki status **Health (HP)** dan **Energy** yang berbeda.
* **Gameplay Turn-Based**:
  * **Sistem Giliran**: Pertarungan dilakukan secara bergantian. Pemain menyerang terlebih dahulu, kemudian diikuti oleh serangan balasan dari musuh.
  * **Manajemen Energi**: Penggunaan skill dibatasi oleh energi. Pemain harus memperhitungkan sisa energi sebelum menyerang.
  * **Kondisi Menang/Kalah**: Permainan berakhir jika HP salah satu pihak mencapai 0.
* **Informasi Karakter**: 
  Halaman khusus yang menampilkan deskripsi dan detail kemampuan (skill) dari setiap karakter.

## Teknologi yang Digunakan

1. HTML
2. CSS
3. JavaScript
4. PHP
5. MySQL
6. Visual Studio Code
7. XAMPP/Laragon

## 📂 Struktur Folder

```bash
marvel-rivals/
├── api/
│   └── game_over.php       # Untuk menangani logika kemenangan & update level
├── assets/
│   ├── backgrounds/        # Background 
│   ├── chars/              # Aset karakter 
│   └── logo/               # Logo Marvel Rivals
├── config/
│   ├── db.php              # Konfigurasi koneksi database
│   └── marvel_rivals_db.sql # File database SQL
├── functions/
│   └── auth.php            # Fungsi helper: Register, Login, Check Session
├── about-character.php     # Halaman detail info & skill karakter
├── battle.php              # Halaman utama permainan (Arena Pertarungan)
├── choose-character.php    # Halaman pemilihan karakter
├── index.php               # Halaman utama (Pemilihan Level)
├── login.php               # Halaman Login
├── register.php            # Halaman Registrasi
└── logout.php              # Script logout
````

## 🚀 Cara Instalasi

Ikuti langkah ini untuk menjalankan project di Localhost (XAMPP):

1.  **Clone Repository**

    ```bash
    git clone https://github.com/ninikrahayu/marvel-rivals
    ```

2.  **Persiapkan Database**

      * Nyalakan modul **Apache** dan **MySQL** di XAMPP.
      * Buka browser dan akses `http://localhost/phpmyadmin`.
      * Buat database baru dengan nama: **`marvel_rivals_db`**.
      * Klik tab **Import**, pilih file `config/marvel_rivals_db.sql` dari folder project, lalu klik **Go**.

3.  **Jalankan Website**

      * Pindahkan folder project `marvel-rivals` ke dalam folder `htdocs`.
      * Buka browser dan akses:

    <!-- end list -->

    ```
    http://localhost/marvel-rivals/login.php
    ```

## 🎮 Cara Bermain

1.  **Register**: Buat akun baru di halaman registrasi.
2.  **Login**: Masuk menggunakan akun yang baru dibuat.
3.  **Pilih Level**: Klik "Level 1" (Level lain terkunci).
4.  **Pilih Hero**: Klik kartu karakter yang ingin dimainkan. Kamu bisa melihat detail skill dengan klik tombol "Learn More".
5.  **Pertarungan (Battle)**:
      * Klik tombol angka **(1 - 4)** di bawah kartu karaktermu untuk menyerang.
      * Perhatikan **Energy Bar** (Biru). Skill yang lebih kuat butuh energi lebih banyak.
      * Jika energi habis, tunggu giliran berikutnya atau gunakan skill dengan *cost* 0.
      * Kalahkan musuh sebelum HP-mu habis\!
6.  **Progress**: Jika menang, kamu akan diarahkan kembali ke menu level dan **Level 2** akan terbuka.
