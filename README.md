# 🎯 Laravel To-Do & Assignment Management System

Sistem manajemen tugas berbasis Laravel dengan fitur:
- Tugas pribadi (To-do List) untuk siswa.
- Tugas dari guru ke siswa.
- Filter dan badge notifikasi untuk tugas yang mendekati deadline (D-3).
- Status prioritas tugas: `Penting Sekali`, `Menengah`, `Tidak Harus`.

## 🧩 Fitur Utama
- Tambah, edit, hapus tugas.
- Deadline dan status untuk setiap tugas.
- Guru dapat memberikan tugas ke siswa.
- Siswa dapat melihat tugas pribadi & tugas dari guru.
- Notifikasi badge untuk tugas yang mendekati deadline.
- Statistik jumlah tugas berdasarkan status & kedekatan deadline.
- 🎛Dashboard terpisah berdasarkan peran (`student` & `teacher`).

## 🛠️ Teknologi yang Digunakan
- Laravel 12+
- Blade Templating
- Auth (Login & Role-based View)
- Carbon (manipulasi tanggal)
