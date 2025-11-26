# CircleHub - Platform Kursus Daring (LMS) 🎓

**CircleHub** adalah sistem manajemen pembelajaran (*Learning Management System*) modern yang dirancang untuk memfasilitasi proses belajar mengajar secara interaktif. Platform ini menghubungkan admin, pengajar, dan siswa dalam satu ekosistem yang terstruktur, responsif, dan mudah digunakan.

![CircleHub Homepage](public/images/logo-circlehub.png)

---

## ✨ Fitur Unggulan

### 👥 Hak Akses & Peran (RBAC)
Sistem ini memiliki 4 level pengguna dengan hak akses yang berbeda:
1. **Admin:** Mengelola seluruh pengguna, kategori kursus, dan memiliki kontrol penuh atas semua kursus.
2. **Teacher (Pengajar):** Membuat dan mengelola kursus mereka sendiri, menyusun materi pelajaran, serta memantau progres siswa.
3. **Student (Siswa):** Mendaftar kursus, mengakses materi belajar, melacak progres, dan berdiskusi.
4. **Guest (Publik):** Melihat katalog kursus, fitur pencarian, dan detail informasi kursus.

### 📚 Manajemen Pembelajaran
* **Katalog Kursus:** Fitur pencarian dan filter kursus berdasarkan kategori yang dinamis.
* **Manajemen Materi:** Pengajar dapat menyusun materi pelajaran (Bab) secara terurut.
* **Sistem Pendaftaran (Enrollment):** Siswa dapat mendaftar kursus dengan satu klik dan langsung memulai belajar.
* **Pelacakan Progres:** *Progress bar* otomatis yang bergerak seiring siswa menandai materi sebagai "Selesai".

### 🚀 Fitur Lanjutan (Advanced)
* **Sertifikat Otomatis:** Sistem secara otomatis men-generate sertifikat kelulusan (JPG) berisi nama siswa saat progres mencapai 100%.
* **Forum Diskusi:** Fitur tanya jawab interaktif di setiap halaman kursus antara siswa dan pengajar.
* **Upload Gambar Sampul:** Pengajar dapat mengunggah gambar sampul (*cover image*) khusus untuk setiap kursus.
* **Hubungi Kami:** Formulir kontak fungsional yang mengirimkan pesan langsung ke email admin.

---

## 🛠️ Teknologi yang Digunakan

* **Backend:** Laravel 11
* **Frontend:** Blade Templates, Tailwind CSS, Alpine.js
* **Database:** MySQL
* **Autentikasi:** Laravel Breeze
* **Image Processing:** Intervention Image v3 (untuk sertifikat)
* **Asset Bundling:** Vite

---

## ⚙️ Cara Instalasi & Menjalankan Project

Ikuti langkah-langkah berikut untuk menjalankan proyek ini di komputer lokal Anda.

### 1. Clone Repository

```bash
git clone https://github.com/username-anda/circlehub.git
cd circlehub
```

### 2. Install Dependencies

```bash
composer install
npm install
```

### 3. Konfigurasi Environment

```bash
cp .env.example .env
```

Sesuaikan database di file `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=circlehub_db
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Generate Key & Setup Storage

```bash
php artisan key:generate
php artisan storage:link
```

### 5. Migrasi Database & Seeder

```bash
php artisan migrate:fresh --seed
```

### 6. Jalankan Aplikasi

Terminal 1 — Laravel:

```bash
php artisan serve
```

Terminal 2 — Vite:

```bash
npm run dev
```

Akses di browser: **http://127.0.0.1:8000**

---

## 🔑 Akun Demo (Seeder)

| Role | Email | Password |
|------|--------------------------|-----------|
| Admin | admin@circlehub.com | password |
| Teacher 1 | teacher@circlehub.com | password |
| Teacher 2 | angela@circlehub.com | password |
| Student | student@circlehub.com | password |

---

## 📂 Struktur Folder Penting

* `app/Models` — Struktur data (User, Course, Enrollment, dll)
* `app/Http/Controllers` — Logika bisnis
* `resources/views` — Tampilan (Blade)
  * `layouts/`
  * `public/`
  * `student/`
  * `teacher/`
  * `admin/`

---

## 🤝 Kredit

Proyek ini dikembangkan sebagai **Tugas Final Praktikum Pemrograman Web**.

