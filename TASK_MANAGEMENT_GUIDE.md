# Dokumentasi Task Management System

## 📋 Daftar Isi
1. [Alur Kerja Umum](#alur-kerja-umum)
2. [Panduan Supervisor](#panduan-supervisor)
3. [Panduan PIC](#panduan-pic)
4. [Fitur-Fitur](#fitur-fitur)
5. [Database Schema](#database-schema)
6. [Routes](#routes)

---

## 🔄 Alur Kerja Umum

### Workflow Lengkap:

```
1. SUPERVISOR MEMBUAT TUGAS
   └─ Akses: /supervisor/tasks/create
   └─ Input: Judul, Deskripsi, Deadline
   └─ Otomatis: Ditugaskan ke semua PIC di divisi

2. PIC MENERIMA TUGAS
   └─ Lihat: /pic/tasks
   └─ Filter: Hanya tugas dari divisi yang sama
   └─ Status: Belum Dikerjakan → Mulai Kerjakan

3. PIC MENGERJAKAN DAN SUBMIT
   └─ Akses: /pic/tasks/{id}
   └─ Input: Catatan Submission + Upload File
   └─ Status berubah: Menunggu Review

4. SUPERVISOR REVIEW
   └─ Akses: /supervisor/tasks/{id}/review
   └─ Opsi: Approve ✓ atau Reject ✗

5. HASIL REVIEW:
   ├─ APPROVE: Status → Selesai (PIC tidak bisa edit lagi)
   └─ REJECT: Status → Revisi (PIC harus perbaiki & submit ulang)

6. PIC LANJUT TUGAS LAIN
   └─ Kerjakan tugas berikutnya yang masih available
```

---

## 👨‍💼 Panduan Supervisor

### 1. Melihat Daftar Tugas Saya
**URL:** `http://localhost:8000/supervisor/tasks`

- Lihat semua tugas yang telah dibuat
- Lihat progress submission dari setiap PIC
- Lihat status tugas (Pending, Assigned, Submitted, Approved)

### 2. Membuat Tugas Baru
**URL:** `http://localhost:8000/supervisor/tasks/create`

**Langkah:**
1. Klik tombol "Tambah Tugas"
2. Isi Judul Tugas (wajib)
3. Isi Deskripsi Tugas (jelaskan detail apa yang harus dikerjakan)
4. Tentukan Deadline (opsional tapi recommended)
5. Klik "Buat Tugas"

**Hasil:** 
- Tugas otomatis ditugaskan ke SEMUA PIC di divisi Anda
- PIC akan melihat tugas di dashboard mereka
- Jumlah submission akan ditampilkan di progress bar

### 3. Melihat Detail Tugas
**URL:** `http://localhost:8000/supervisor/tasks/{id}`

- Lihat deskripsi lengkap tugas
- Lihat list PIC yang ditugaskan
- Lihat progress submission (Approved vs Pending vs Revisi)
- Lihat status setiap PIC

### 4. Me-Review Submission dari PIC
**URL:** `http://localhost:8000/supervisor/tasks/{id}/review`

**Langkah:**
1. Lihat submission dari setiap PIC
2. Baca catatan PIC dan lihat file yang di-upload
3. Pilih: Setujui ✓ atau Tolak ✗

**Jika Setujui (Approve):**
- Status submission: Approved
- Status tugas: Selesai
- PIC tidak bisa lagi mengubah submission

**Jika Tolak (Reject):**
- Status submission: Rejected
- PIC harus melihat feedback Anda
- PIC dapat memperbaiki dan submit ulang
- Anda akan bisa review submission yang baru

### 5. Edit atau Hapus Tugas
**URL:** `http://localhost:8000/supervisor/tasks/{id}`

- Klik dropdown menu "..." 
- Pilih "Edit" untuk mengubah judul/deskripsi/deadline
- Pilih "Hapus" untuk menghapus tugas (jika sudah jadi)

---

## 👤 Panduan PIC

### 1. Melihat Daftar Tugas
**URL:** `http://localhost:8000/pic/tasks`

- Lihat semua tugas dari Supervisor divisi Anda
- Status setiap tugas terlihat dengan badge warna
- Progress stats di atas (Total, Pending, Selesai, Revisi)

**Status Badge:**
- 🔵 **Belum Dikerjakan** = Tugas baru, belum ada submission
- 🟡 **Dikirim** = Sudah kirim submission, menunggu review supervisor
- 🔴 **Revisi** = Supervisor tolak, perlu diperbaiki
- 🟢 **Selesai** = Supervisor approve, tugas selesai

### 2. Mengerjakan Tugas
**URL:** `http://localhost:8000/pic/tasks/{id}`

**Langkah:**
1. Klik tugas yang ingin dikerjakan
2. Baca detail tugas dari supervisor
3. Baca deadline
4. Isi "Catatan Submission" (jelaskan hasil pekerjaan Anda)
5. Upload file hasil kerja (opsional, format: PDF/DOC/IMG/ZIP max 10MB)
6. Klik "Kirim Pekerjaan"

**Penting:**
- Anda dapat mengubah submission berkali-kali sebelum supervisor approve
- Setelah supervisor approve, Anda tidak bisa mengubah lagi
- Riwayat submission ditampilkan di bagian bawah

### 3. Melihat Feedback Supervisor
Jika submission di-reject:
- Badge berubah merah dengan label "Revisi"
- Feedback dari supervisor ditampilkan dalam alert box merah
- Anda dapat melihat apa yang perlu diperbaiki
- Kerjakan ulang dan submit kembali

### 4. Tugas Selesai
Setelah supervisor approve:
- Badge berubah hijau dengan label "Selesai"
- Tombol berubah menjadi "Lihat Detail (Selesai)"
- Form submission tidak lagi tersedia
- Anda dapat melanjutkan ke tugas lain

---

## ✨ Fitur-Fitur

### Untuk Supervisor:
✅ Membuat tugas dengan judul, deskripsi, deadline
✅ Otomatis assign ke semua PIC di divisi
✅ Melihat progress submission (progress bar)
✅ Melihat detail setiap submission dari PIC
✅ Approve atau Reject submission dengan feedback
✅ Edit detail tugas
✅ Hapus tugas
✅ Lihat list PIC dan status submission mereka

### Untuk PIC:
✅ Melihat daftar tugas dari supervisor divisi
✅ Melihat detail, deskripsi, deadline tugas
✅ Submit pekerjaan dengan catatan dan file
✅ Ubah submission sebelum supervisor approve
✅ Melihat feedback dari supervisor jika di-reject
✅ Perbaiki dan submit ulang jika di-reject
✅ Lihat progress/statistik tugas (Total, Pending, Selesai, Revisi)

---

## 📊 Database Schema

### Table: `tasks`
```sql
- id (Primary Key)
- division_id (Foreign Key → divisions)
- supervisor_id (Foreign Key → users)
- title (String)
- description (Text)
- deadline (Date)
- status (Enum: pending, assigned, in_progress, submitted, approved, rejected)
- created_at
- updated_at
```

### Table: `task_submissions`
```sql
- id (Primary Key)
- task_id (Foreign Key → tasks)
- pic_id (Foreign Key → users)
- submission_notes (Text)
- submission_file (String - path)
- status (Enum: submitted, approved, rejected)
- reviewer_feedback (Text)
- submitted_at (Timestamp)
- reviewed_at (Timestamp)
- created_at
- updated_at
```

### Relationships:
- `Division` has many `Tasks`
- `Task` belongs to `Division` & `Supervisor` (User)
- `Task` has many `TaskSubmissions`
- `TaskSubmission` belongs to `Task` & `PIC` (User)
- `User` has many `supervisedTasks` (as Supervisor)
- `User` has many `picSubmissions` (as PIC)

---

## 🔗 Routes

### Supervisor Routes:
```
GET    /supervisor/tasks                    → Lihat daftar tugas
GET    /supervisor/tasks/create             → Form buat tugas
POST   /supervisor/tasks                    → Simpan tugas baru
GET    /supervisor/tasks/{task}             → Lihat detail tugas
GET    /supervisor/tasks/{task}/edit        → Form edit tugas
PUT    /supervisor/tasks/{task}             → Simpan edit tugas
DELETE /supervisor/tasks/{task}             → Hapus tugas
GET    /supervisor/tasks/{task}/review      → Review submissions dari PIC
POST   /supervisor/submissions/{id}/approve → Approve submission
POST   /supervisor/submissions/{id}/reject  → Reject submission
```

### PIC Routes:
```
GET    /pic/tasks                           → Lihat daftar tugas
GET    /pic/tasks/{task}                    → Lihat detail & form submit
POST   /pic/tasks/{task}/submit             → Submit pekerjaan
GET    /pic/tasks/progress/stats            → API untuk statistik
```

---

## 💾 File Submission

### Lokasi File:
- Files disimpan di: `storage/app/submissions/`
- Akses public: `storage/submissions/`

### Tipe File Support:
✅ PDF, DOC, DOCX, XLS, XLSX
✅ JPG, PNG, GIF, BMP
✅ ZIP, RAR

### Maximum File Size:
- **10 MB per file**

---

## 🎯 Contoh Workflow Lengkap

### Scenario: Supervisor Multimedia Membuat 3 Tugas

**Step 1: Supervisor Buat Tugas**
```
Supervisor Multimedia login → /supervisor/tasks/create
- Judul: "Desain Banner Iklan"
- Deskripsi: "Buat design banner 1920x500 untuk kampanye Q1 2026..."
- Deadline: 2026-01-25
- Klik "Buat Tugas"

Result: Tugas otomatis ditugaskan ke semua PIC Multimedia (misal: Andi, Budi, Citra)
```

**Step 2: Setiap PIC Menerima Tugas**
```
PIC Andi login → /pic/tasks
- Lihat "Desain Banner Iklan" dengan badge "Belum Dikerjakan"
- Baca deadline: 25 Jan 2026
- Klik untuk buka detail & form
```

**Step 3: PIC Andi Mengerjakan & Submit**
```
PIC Andi → /pic/tasks/1
- Baca detail tugas
- Input: "Saya telah membuat 3 desain variansi sesuai permintaan..."
- Upload file: banner_design_v1.psd
- Klik "Kirim Pekerjaan"

Result: 
- Status berubah menjadi "Dikirim" (badge kuning)
- Supervisor akan melihat submission Andi
```

**Step 4: Supervisor Review**
```
Supervisor Multimedia → /supervisor/tasks/1/review
- Lihat submission dari Andi
- Lihat catatan: "Saya telah membuat 3 desain..."
- Download file: banner_design_v1.psd
- Check kualitas design

Opsi A - Approve:
  - Klik "Setujui"
  - Status Andi → "Selesai" (badge hijau)
  - Andi tidak bisa edit lagi

Opsi B - Reject:
  - Klik "Tolak"
  - Input feedback: "Warna kurang vibrant, coba naikkan saturation..."
  - Klik "Kirim Feedback"
  - Status Andi → "Revisi" (badge merah)
```

**Step 5: Jika Reject, PIC Perbaiki**
```
PIC Andi → /pic/tasks/1
- Lihat feedback: "Warna kurang vibrant..."
- Buka file design yang sebelumnya
- Edit & tingkatkan saturation
- Update catatan: "Sudah diperbaiki, warna lebih vibrant..."
- Upload file baru: banner_design_v2.psd
- Klik "Kirim Pekerjaan"

Result: Supervisor bisa review lagi
```

**Step 6: PIC Lanjut Tugas Lain**
```
Setelah Andi selesai dengan tugas "Desain Banner Iklan":
- Badge berubah hijau "Selesai"
- Andi bisa melihat & mengerjakan tugas lain dari Supervisor
- Misal: "Edit Video Promosi", "Buat Infografis", dll
```

---

## 🐛 Troubleshooting

### PIC tidak bisa melihat tugas
- ✅ Pastikan PIC sudah ditambahkan ke divisi (role: PIC)
- ✅ Pastikan supervisor sudah membuat tugas untuk divisi itu
- ✅ Refresh halaman

### File tidak bisa di-upload
- ✅ Cek ukuran file (max 10MB)
- ✅ Cek format file (hanya PDF, DOC, IMG, ZIP)
- ✅ Cek permission folder storage/app/submissions

### Submission tidak bisa di-submit
- ✅ Isi catatan submission (minimal 10 karakter)
- ✅ Jika tugas sudah approved, tidak bisa submit lagi
- ✅ Cek internet connection

---

## 📱 API Endpoints

### GET /pic/tasks/progress/stats
Response:
```json
{
    "total_tasks": 5,
    "completed_tasks": 2,
    "pending_tasks": 2,
    "rejected_tasks": 1
}
```

---

## ✅ Testing Checklist

- [ ] Supervisor bisa membuat tugas baru
- [ ] Tugas otomatis ditugaskan ke semua PIC di divisi
- [ ] PIC bisa melihat daftar tugas di divisinya
- [ ] PIC bisa submit pekerjaan dengan file
- [ ] Supervisor bisa review & approve submission
- [ ] Setelah approve, PIC tidak bisa edit lagi
- [ ] Supervisor bisa reject dengan feedback
- [ ] PIC bisa melihat feedback & perbaiki
- [ ] Progress bar menunjukkan status submission
- [ ] Statistics menampilkan jumlah tugas dengan benar

---

Selamat menggunakan Task Management System! 🎉
