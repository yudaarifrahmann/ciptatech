# 🧪 Quick Testing Guide - Task Management System

## 🎯 Skenario Testing: Workflow Lengkap

Ikuti skenario ini untuk menguji seluruh fitur:

---

## **TEST CASE 1: Supervisor Membuat Tugas**

### Prerequisites:
- Login sebagai **Supervisor** (role: supervisor)
- Pastikan sudah ditambahkan ke divisi tertentu
- Pastikan ada minimal 1 PIC di divisi yang sama

### Test Steps:

1. **Navigasi ke Create Task**
   ```
   URL: http://localhost:8000/supervisor/tasks/create
   atau klik menu "Kelola Tugas" → "Tambah Tugas"
   ```

2. **Isi Form**
   ```
   Judul: "Desain Logo Baru Perusahaan"
   Deskripsi: "Buatkan desain logo baru dengan konsep modern dan minimalis. 
              File format: AI, PSD, atau PNG. Ukuran: 500x500px"
   Deadline: 2026-01-25
   ```

3. **Klik "Buat Tugas"**
   - ✅ Harapkan: Success message "Tugas 'Desain Logo Baru...' berhasil dibuat..."
   - ✅ Redirect ke: `/supervisor/tasks` (index)

4. **Verifikasi di Index**
   ```
   - Lihat tugas baru di daftar
   - Status: "Assigned"
   - Progress: 0/n (dimana n = jumlah PIC di divisi)
   - Card terlihat dengan detail tugas
   ```

---

## **TEST CASE 2: PIC Melihat Tugas**

### Prerequisites:
- Login sebagai **PIC** (role: PIC)
- Pastikan PIC sudah di divisi yang sama dengan supervisor

### Test Steps:

1. **Navigasi ke Task List**
   ```
   URL: http://localhost:8000/pic/tasks
   atau klik menu "Daftar Tugas"
   ```

2. **Verifikasi Statistik**
   ```
   ✅ Harapkan: Progress stats di atas
   - Total Tugas: >= 1
   - Pending: >= 1
   - Selesai: 0 (belum ada)
   - Revisi: 0 (belum ada)
   ```

3. **Verifikasi Task Card**
   ```
   ✅ Harapkan: Tugas "Desain Logo Baru..." terlihat
   - Badge: "Belum Dikerjakan" (warna biru)
   - Nama Supervisor terlihat
   - Deadline terlihat
   - Tombol: "Mulai Kerjakan" (warna biru)
   ```

4. **Klik Tombol "Mulai Kerjakan"**
   ```
   - Redirect ke: /pic/tasks/{task_id}
   ```

---

## **TEST CASE 3: PIC Submit Pekerjaan**

### Prerequisites:
- Sudah di halaman detail task (`/pic/tasks/{id}`)

### Test Steps:

1. **Verifikasi Detail Task**
   ```
   ✅ Harapkan: Semua detail tugas terlihat
   - Judul: "Desain Logo Baru Perusahaan"
   - Supervisor: [Nama Supervisor]
   - Deskripsi: Full text yang Anda tulis
   - Deadline: 25 Jan 2026
   - Status: "Menunggu Review" atau "Belum Dikerjakan"
   ```

2. **Isi Form Submission**
   ```
   Catatan Submission: "Sudah membuat 3 varian logo dengan konsep berbeda.
                       File telah disiapkan dalam format PSD dan PNG.
                       Mohon review dan berikan feedback."
   
   File Upload: [pilih file] - contoh: logo_design.zip
   ```

3. **Klik "Kirim Pekerjaan"**
   - ✅ Harapkan: Success message
   - ✅ Status: "Menunggu Review" (badge kuning)
   - ✅ Tombol berubah: "Menunggu Review" (disabled)

4. **Verifikasi di Timeline**
   ```
   ✅ Harapkan: Riwayat submission terlihat
   - Timestamp submission
   - Catatan yang Anda tulis
   ```

---

## **TEST CASE 4: Supervisor Review & Approve**

### Prerequisites:
- Login sebagai **Supervisor**
- Ada submission dari PIC

### Test Steps:

1. **Lihat Task di Index**
   ```
   URL: http://localhost:8000/supervisor/tasks
   ```

2. **Verifikasi Progress Bar**
   ```
   ✅ Harapkan: Progress bar menunjukkan 0/1 atau yang sesuai
   ```

3. **Klik Tombol "Review"**
   ```
   - Redirect ke: /supervisor/tasks/{task_id}/review
   ```

4. **Lihat Submission dari PIC**
   ```
   ✅ Harapkan: Terlihat
   - Nama & email PIC
   - Badge: "Submitted"
   - Catatan submission: "Sudah membuat 3 varian..."
   - Tombol: "Download File"
   - Tombol: "Setujui" & "Tolak"
   ```

5. **Download File (Optional)**
   ```
   - Klik "Download File"
   - ✅ File download berhasil (logo_design.zip)
   ```

6. **Approve Submission**
   ```
   - Klik "Setujui"
   - ✅ Harapkan: Success message "Submission dari [PIC] berhasil disetujui..."
   - ✅ Status badge berubah: "Approved" (hijau)
   ```

---

## **TEST CASE 5: Verify Approve Status**

### Prerequisites:
- Submission sudah di-approve

### Test Steps:

1. **Supervisor View**
   ```
   - Kembali ke /supervisor/tasks
   - ✅ Progress bar: 1/1 (atau sesuai jumlah PIC)
   - ✅ Card tugas masih terlihat
   ```

2. **PIC View**
   ```
   - Login sebagai PIC
   - Masuk /pic/tasks
   - ✅ Badge tugas: "Selesai" (hijau)
   - ✅ Tombol: "Lihat Detail (Selesai)"
   ```

3. **Buka Detail Tugas PIC**
   ```
   - Klik card tugas
   - ✅ Form submission: DISABLED (tidak bisa edit)
   - ✅ Alert: "Tugas Selesai! Submission Anda telah disetujui..."
   - ✅ Tidak bisa ubah submission lagi
   ```

---

## **TEST CASE 6: Supervisor Review & Reject**

### Prerequisites:
- Login sebagai **Supervisor**
- Ada tugas baru dengan submission dari PIC lain
- (Atau buat flow baru dengan PIC berbeda)

### Test Steps:

1. **Buat Tugas Baru**
   ```
   Judul: "Video Promosi Produk"
   Deskripsi: "Buatkan video promosi singkat (30 detik)..."
   ```

2. **PIC Submit Pekerjaan**
   ```
   - Login sebagai PIC baru
   - Kerjakan & submit
   ```

3. **Supervisor Review & Reject**
   ```
   - Buka /supervisor/tasks/{task_id}/review
   - Lihat submission
   - Klik "Tolak"
   ```

4. **Modal Reject Muncul**
   ```
   ✅ Harapkan: Modal dengan field "Feedback untuk PIC"
   ```

5. **Isi Feedback**
   ```
   Feedback: "Video resolusi terlalu rendah. 
             Mohon gunakan HD (1080p) dan tambahkan subtitle bahasa Indonesia.
             Durasi ideal 30-45 detik."
   ```

6. **Klik "Kirim Feedback"**
   ```
   - ✅ Harapkan: Success message
   - ✅ Status submission: "Rejected"
   - ✅ Feedback terlihat di modal
   ```

---

## **TEST CASE 7: PIC Perbaiki & Submit Ulang**

### Prerequisites:
- Login sebagai **PIC yang di-reject**
- Submission sudah di-reject dengan feedback

### Test Steps:

1. **Lihat Tugas di Daftar**
   ```
   - /pic/tasks
   - ✅ Badge tugas: "Revisi" (merah)
   ```

2. **Buka Detail Tugas**
   ```
   - Klik card tugas
   - ✅ Alert merah: "Feedback Supervisor: Video resolusi..."
   ```

3. **Perbaiki Submission**
   ```
   Catatan: "Sudah diperbaiki dengan resolusi HD 1080p dan subtitle Indonesia.
            Durasi video: 35 detik. Silakan review kembali."
   
   File Upload: video_promosi_v2.mp4
   ```

4. **Kirim Ulang**
   ```
   - Klik "Kirim Pekerjaan"
   - ✅ Status: "Menunggu Review" (kuning)
   - ✅ Feedback sebelumnya hilang
   ```

5. **Supervisor Review Ulang**
   ```
   - Login sebagai Supervisor
   - Buka /supervisor/tasks/{task_id}/review
   - Lihat submission baru dari PIC
   - ✅ Catatan baru: "Sudah diperbaiki..."
   - ✅ File baru: video_promosi_v2.mp4
   - Kali ini "Setujui"
   ```

6. **Verifikasi Status Final**
   ```
   - PIC login & buka /pic/tasks
   - ✅ Badge: "Selesai" (hijau)
   - ✅ Form disabled
   ```

---

## **TEST CASE 8: PIC Lanjut Tugas Lain**

### Prerequisites:
- PIC sudah selesai dengan satu tugas
- Ada tugas lain yang belum dikerjakan

### Test Steps:

1. **Lihat Daftar Tugas**
   ```
   - /pic/tasks
   - ✅ Lihat statistik update:
     - Selesai: 1
     - Pending: 1 (tugas lain)
   ```

2. **Kerjakan Tugas Berikutnya**
   ```
   - Klik tugas kedua yang statusnya "Belum Dikerjakan"
   - Isi form submission
   - Kirim
   ```

3. **Verifikasi Statistik**
   ```
   - ✅ Progress stats update otomatis
   - ✅ Bisa lihat status setiap tugas dengan benar
   ```

---

## **TEST CASE 9: Edit Tugas (Supervisor)**

### Prerequisites:
- Login sebagai **Supervisor**
- Ada tugas yang sudah dibuat

### Test Steps:

1. **Lihat Task Card**
   ```
   - /supervisor/tasks
   ```

2. **Buka Dropdown Menu**
   ```
   - Klik "..." pada card tugas
   - ✅ Options: Edit, Hapus
   ```

3. **Klik Edit**
   ```
   - Redirect ke: /supervisor/tasks/{task_id}/edit
   ```

4. **Edit Detail**
   ```
   Judul (ubah): "Desain Logo Baru Perusahaan 2026"
   Deskripsi (ubah): "...dengan tambahan info baru"
   Deadline (ubah): 2026-02-01
   ```

5. **Klik "Simpan Perubahan"**
   ```
   - ✅ Success message
   - ✅ Redirect ke detail task
   - ✅ Perubahan terlihat
   ```

---

## **TEST CASE 10: Hapus Tugas (Supervisor)**

### Prerequisites:
- Ada tugas yang ingin dihapus (lebih baik tugas tanpa submission)

### Test Steps:

1. **Buka Dropdown Menu**
   ```
   - /supervisor/tasks
   - Klik "..." pada card tugas
   - Klik "Hapus"
   ```

2. **Confirm Dialog**
   ```
   - ✅ Alert: "Apakah Anda yakin..."
   - Klik OK
   ```

3. **Verifikasi**
   ```
   - ✅ Success message: "Tugas 'xxx' telah dihapus"
   - ✅ Task tidak lagi di daftar
   - ✅ Task_submissions otomatis dihapus (cascade delete)
   ```

---

## 📊 Checklist Testing

Tandai setiap test yang sudah dijalankan:

```
BASIC FUNCTIONALITY:
☐ Test 1: Supervisor membuat tugas
☐ Test 2: PIC melihat tugas
☐ Test 3: PIC submit pekerjaan
☐ Test 4: Supervisor approve
☐ Test 5: Verify approve status
☐ Test 6: Supervisor reject
☐ Test 7: PIC perbaiki & submit ulang
☐ Test 8: PIC lanjut tugas lain
☐ Test 9: Edit tugas
☐ Test 10: Hapus tugas

ADDITIONAL:
☐ Multiple PIC testing
☐ File upload testing
☐ Deadline verification
☐ Progress bar accuracy
☐ Statistics calculation
☐ Mobile responsiveness
☐ Permission/Authorization
☐ Error handling
☐ Pagination (if many tasks)
☐ Navigation menu integration
```

---

## 🔍 Hal-Hal yang Harus Diperhatikan

### Database Integrity:
- ✅ Task otomatis di-cascade delete jika division dihapus
- ✅ TaskSubmission otomatis di-cascade delete jika task dihapus
- ✅ TaskSubmission otomatis di-cascade delete jika user (PIC) dihapus

### File Handling:
- ✅ File tersimpan di `storage/app/submissions/`
- ✅ Pastikan folder permission sudah benar
- ✅ Max file size: 10MB

### Status Flow:
```
Task Status:
pending → assigned → submitted → approved (atau rejected → submitted)

TaskSubmission Status:
submitted → approved (atau rejected → submitted)
```

### Timestamps:
- ✅ `submitted_at`: Kapan submission pertama kali dibuat
- ✅ `reviewed_at`: Kapan supervisor me-review (approve atau reject)
- ✅ `created_at/updated_at`: Standard Laravel timestamps

---

## 🐛 Common Issues & Solutions

### Issue: "PIC tidak bisa melihat tugas"
**Solusi:**
- ✅ Pastikan PIC sudah ditambahkan ke divisi (field `division_id`)
- ✅ Pastikan supervisor membuat tugas ke divisi yang benar
- ✅ Refresh halaman browser

### Issue: "File tidak bisa di-upload"
**Solusi:**
- ✅ Cek ukuran file (max 10MB)
- ✅ Cek format file
- ✅ Cek permission folder `storage/app/submissions/`
- Run: `php artisan storage:link` (jika belum ada symlink)

### Issue: "Status tidak update"
**Solusi:**
- ✅ Refresh halaman
- ✅ Clear browser cache
- ✅ Check database query di logs

---

## 📱 Testing di Mobile

Test di berbagai ukuran screen:
- ✅ Desktop (1920px, 1366px)
- ✅ Tablet (768px, 1024px)
- ✅ Mobile (375px, 480px)

### Features to test on mobile:
- ✅ Sidebar responsiveness (should use bottom nav)
- ✅ Card layout (should stack vertically)
- ✅ Forms (should be easy to fill)
- ✅ Modals (should fit screen)
- ✅ File upload (should work smoothly)

---

**Happy Testing! 🎉**

Jika ada issue, check:
1. Browser console (F12) untuk error
2. Laravel logs: `storage/logs/laravel.log`
3. Database untuk verify data
4. Documentation di `TASK_MANAGEMENT_GUIDE.md`
