## 1. Pembagian Peran & Komitmen

| Anggota | NIM | Peran Utama | Tanggung Jawab Spesifik | Target Commit Mingguan |
| :--- | :--- | :--- | :--- | :--- |
| **Anggota 1** | [Isi NIM] | **Backend Lead** | Migration, Model, Controller, Auth, Middleware, Seeder, Database, API/Logic | Min 3 commit |
| **Anggota 2** | [Isi NIM] | **Frontend & Integrasi Lead** | Blade Template, Tailwind CSS, JS, Layout, Responsif, Integrasi ke Controller, Testing UI | Min 3 commit |

**Catatan:** Kedua anggota **wajib** bisa `git add`, `commit`, `push`, `pull`, dan membuat **Pull Request** (meski di repo sendiri). Jangan hanya satu orang yang push.
## 2. Matriks Fitur & Hak Akses (Role)

**Role Pengguna:**
1.  **Admin** (Akses penuh: Kelola User, Berita, Guru, Siswa, Setting Sekolah)
2.  **Guru** (Kelola Jadwal Mengajar, Input Nilai, Lihat Data Siswa Kelasnya)
3.  **Siswa** (Lihat Jadwal, Lihat Nilai, Baca Berita, Profil)
4.  **Guest/Tamu** (Hanya halaman publik: Home, Profil Sekolah, Berita, Kontak)

**Fitur yang Dikerjakan (MVP - Minimum Viable Product):**

| No | Fitur | Deskripsi Singkat | Akses (Role) | Prioritas |
| :--- | :--- | :--- | :--- | :--- |
| 1 | **Autentikasi** | Login, Logout, Register (hanya Admin yg bisa buat user baru), Lupa Password | Guest, All | **WAJIB** |
| 2 | **Dashboard Role** | Redirect otomatis ke halaman berbeda tiap role setelah login | All | **WAJIB** |
| 3 | **Manajemen Berita** | CRUD Berita (Judul, Isi, Gambar, Tanggal, Status Publish/Draft) | Admin, Guru (create), Siswa (read) | **WAJIB** |
| 4 | **Profil Sekolah** | Halaman statis: Visi Misi, Sejarah, Struktur Organisasi, Kontak | Guest, All | **WAJIB** |
| 5 | **Data Guru/Staf** | CRUD Data Guru (NIP, Nama, Mapel, Foto, Kontak) | Admin | **UTAMA** |
| 6 | *Opsional: Jadwal Pelajaran* | CRUD Jadwal per Kelas/Hari | Admin, Guru (read), Siswa (read) | *Bonus* |
| 7 | *Opsional: Galeri Foto* | Upload multiple foto kegiatan | Admin | *Bonus* |

**Keputusan Final Fitur (Centang yang dikerjakan):**
- [x] Auth & Role Dashboard
- [x] Manajemen Berita
- [x] Profil Sekolah (Statis/Dinamis sederhana)
- [x] Data Guru
- [ ] Jadwal Pelajaran
- [ ] Galeri Foto
## 3. Rancangan Database (Tabel Utama)

### A. users (Sudah ada dari Breeze, kita tambah kolom)
- id, name, email, password, **role** (enum: admin,guru,siswa), **nip_nis** (unique, nullable), **kelas_id** (FK, nullable), **foto** (nullable), timestamps

### B. beritas
- id, judul, slug (unique), ringkasan, isi (longtext), gambar (path), tanggal_publish, status (enum: draft,published), **user_id** (FK -> users), timestamps

### C. gurus (Data Guru/Staf)
- id, nip (unique), nama, jenis_kelamin, alamat, no_hp, **mapel_id** (FK -> mapels, nullable), **user_id** (FK -> users, nullable - untuk login guru), foto, timestamps

### D. mapels (Mata Pelajaran - referensi)
- id, nama_mapel, kode_mapel, timestamps

### E. kelas (Referensi)
- id, nama_kelas (contoh: X RPL 1, XI TKJ 2), **wali_kelas_id** (FK -> gurus, nullable), timestamps

### F. siswas (Data Siswa - opsional jika butuh detail lebih dari users)
- id, nis (unique), nama, **kelas_id** (FK), **user_id** (FK -> users, nullable), alamat, no_ortu, timestamps

**Relasi Penting:**
- `User` hasOne `Guru` / `Siswa` (via `user_id` di tabel guru/siswa)
- `Berita` belongsTo `User` (penulis)
- `Guru` belongsTo `Mapel`
- `Siswa` belongsTo `Kelas`
- `Kelas` belongsTo `Guru` (sebagai Wali Kelas)
## 4. Git Workflow Agreement

1.  **Branch Utama:** `main` (protected, hanya untuk kode yang stabil & sudah di-test).
2.  **Branch Fitur:** Setiap fitur baru buat branch dari `main`.
    - Format: `feat/nama-fitur-singkat` (contoh: `feat/crud-berita`, `feat/auth-role`).
    - Format fix: `fix/nama-bug` (contoh: `fix/login-redirect`).
3.  **Commit Message Convention (Wajib):**
    - `feat: tambah migration tabel berita`
    - `feat: buat controller BeritaController resource`
    - `fix: perbaiki middleware role redirect`
    - `style: rapikan tampilan dashboard admin tailwind`
    - `docs: update perencanaan.md`
4.  **Pull Request (PR):**
    - Setiap selesai fitur di branch, buat PR ke `main`.
    - **Reviewer:** Pasangan tim (wajib approve).
    - Tidak boleh merge sendiri tanpa review (kecuali urgensi & sudah diskusikan).
5.  **Sinkronisasi:**
    - Sebelum coding baru: `git checkout main` -> `git pull origin main` -> `git checkout -b feat/baru`.
    - Sering-sering `git pull origin main` ke branch fitur jika lama dikerjakan.
6.  **Laravel Specific:**
    - **JANGAN PERNAH** commit file `.env`, `vendor/`, `node_modules/`, `public/storage` (symlink), `public/hot`, `storage/*.key`.
    - File `database/database.sqlite` (kalau pakai SQLite) jangan di-commit.
    