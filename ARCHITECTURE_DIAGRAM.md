# 📊 Task Management System - Visual Architecture

## 🏗️ System Architecture

```
┌─────────────────────────────────────────────────────────────────┐
│                      TASK MANAGEMENT SYSTEM                      │
├─────────────────────────────────────────────────────────────────┤
│                                                                  │
│  ┌──────────────────────┐         ┌──────────────────────┐      │
│  │   SUPERVISOR         │         │       PIC            │      │
│  │   (supervisor role)  │         │   (PIC role)         │      │
│  └──────────────────────┘         └──────────────────────┘      │
│           │                                    │                 │
│           │ CREATE TASK                       │ VIEW TASKS       │
│           ↓                                    ↓                 │
│  ┌──────────────────────────────────────────────────────┐       │
│  │            TASK MANAGEMENT MODULE                    │       │
│  └──────────────────────────────────────────────────────┘       │
│           │              │              │                       │
│           ├─ ASSIGN      ├─ REVIEW      └─ SUBMIT              │
│           ↓              ↓                  ↓                   │
│      ┌─────────┐   ┌─────────┐      ┌─────────────┐            │
│      │ TASK    │   │FEEDBACK │      │ SUBMISSION  │            │
│      │ TABLE   │   │ SYSTEM  │      │ TABLE       │            │
│      └─────────┘   └─────────┘      └─────────────┘            │
│                                                                  │
└─────────────────────────────────────────────────────────────────┘
                              ↓
                         DATABASE
                    (MySQL Tables)
```

---

## 📋 Data Flow Diagram

```
START: Supervisor membuat tugas
│
├─ Input: Judul, Deskripsi, Deadline
│  │
│  └─→ store() method
│      │
│      ├─ Create Task record
│      │  (status: pending → assigned)
│      │
│      └─ Auto-create TaskSubmission untuk setiap PIC di divisi
│         └─ (status: submitted)
│
END: Tugas ditugaskan ke semua PIC
│
├─────────────────────────────────────────────────────────────┐
│  PIC RECEIVES TASK                                          │
│  ├─ /pic/tasks endpoint                                    │
│  ├─ Filter: task.division_id == user.division_id           │
│  └─ Display: Semua tugas dengan status badge               │
│                                                              │
│  PIC WORKS & SUBMIT                                         │
│  ├─ Input: Catatan + Upload File                           │
│  ├─ POST /pic/tasks/{id}/submit                            │
│  ├─ Update: submission_notes, submission_file              │
│  ├─ Update: status = submitted, submitted_at = now()       │
│  └─ Update: Task status = submitted                        │
│                                                              │
│  SUPERVISOR REVIEWS                                         │
│  ├─ GET /supervisor/tasks/{id}/review                      │
│  ├─ View: Semua submission dari PIC                        │
│  ├─ Option A: APPROVE                                      │
│  │   └─ Status: approved, reviewed_at = now()              │
│  │   └─ Task: status = approved (SELESAI)                  │
│  │   └─ PIC: tidak bisa edit lagi                          │
│  │                                                           │
│  └─ Option B: REJECT                                       │
│      ├─ Status: rejected, reviewed_at = now()              │
│      ├─ reviewer_feedback: [masukkan feedback]             │
│      ├─ Task: status = submitted                           │
│      └─ PIC: bisa perbaiki & submit ulang                  │
│                                                              │
│  IF REJECTED:                                               │
│  ├─ PIC lihat feedback                                     │
│  ├─ PIC perbaiki pekerjaan                                 │
│  ├─ PIC upload file baru                                   │
│  ├─ POST /pic/tasks/{id}/submit (dengan data baru)        │
│  ├─ Update: submission sebelumnya (overwrite)              │
│  └─ SUPERVISOR REVIEW LAGI                                 │
│     ├─ Approve: Tugas selesai ✓                            │
│     └─ Reject: Ulang perbaikan                             │
└─────────────────────────────────────────────────────────────┘
│
└─→ END: Task selesai atau reject cycle
```

---

## 🗂️ Database Relationship Diagram

```
┌─────────────────┐         ┌──────────────────┐
│    Division     │         │      User        │
├─────────────────┤         ├──────────────────┤
│ id (PK)         │◄────────│ id (PK)          │
│ name            │ 1:M     │ name             │
│ description     │         │ email            │
│ is_active       │         │ role             │
│ timestamps      │         │ division_id (FK) │
└─────────────────┘         │ is_active        │
        │                   │ timestamps       │
        │ 1:M               └──────────────────┘
        │                          ▲
        │                     1:M  │
        ▼                          │ (Supervisor)
┌─────────────────┐                │
│      Task       │                │
├─────────────────┤          ┌──────────────────┐
│ id (PK)         │◄─────────│ supervisor_id    │
│ division_id(FK)─┼──────────► (User FK)        │
│ title           │ 1:M      └──────────────────┘
│ description     │
│ deadline        │         ┌──────────────────┐
│ status          │         │    User (PIC)    │
│ timestamps      │         ├──────────────────┤
└─────────────────┘         │ id (PK)          │
        │                   │ name, email, role│
        │ 1:M               │ division_id      │
        ▼                   └──────────────────┘
┌──────────────────────┐            ▲
│  TaskSubmission      │            │ 1:M (pic_id)
├──────────────────────┤            │
│ id (PK)              │            │
│ task_id (FK)     ────┤            │
│ pic_id (FK)      ────┼────────────┘
│ submission_notes      │
│ submission_file       │
│ status                │
│ reviewer_feedback     │
│ submitted_at          │
│ reviewed_at           │
│ timestamps            │
└──────────────────────┘

RELATIONSHIPS:
- Division 1:M Task
- Task M:1 Division
- Task M:1 User (supervisor_id)
- TaskSubmission M:1 Task
- TaskSubmission M:1 User (pic_id)
- User M:1 Division
```

---

## 🔄 Status Flow Diagram

### TASK STATUS FLOW

```
           Create Task
                │
                ▼
            PENDING
                │
                │ (auto-assign to PIC)
                ▼
            ASSIGNED ◄─────────┐
                │              │
                │ PIC submits  │
                ▼              │
            SUBMITTED          │ Reject
                │      ┌───────┘
                │      │
                ├──────┤
                │      │
                ▼ Approve
            APPROVED (✓ FINAL STATE)
            (cannot change)
```

### TASK SUBMISSION STATUS FLOW

```
        PIC submits work
              │
              ▼
          SUBMITTED ◄─────────┐
              │               │
              ├─ Approve ─────┤
              │               │ Reject
              ▼               │
           APPROVED ◄─────────┘
         (✓ FINAL APPROVED)
```

---

## 📱 UI Component Layout

### SUPERVISOR DASHBOARD - Task Management

```
┌─────────────────────────────────────────────────────────┐
│  HEADER: Kelola Tugas                                   │
│  [+ Tambah Tugas Button]                                │
├─────────────────────────────────────────────────────────┤
│                                                          │
│  ┌──────────────┐  ┌──────────────┐  ┌──────────────┐  │
│  │  TASK CARD 1 │  │  TASK CARD 2 │  │  TASK CARD 3 │  │
│  ├──────────────┤  ├──────────────┤  ├──────────────┤  │
│  │ Title        │  │ Title        │  │ Title        │  │
│  │ [Badge]      │  │ [Badge]      │  │ [Badge]      │  │
│  ├──────────────┤  ├──────────────┤  ├──────────────┤  │
│  │ Divisi: XX   │  │ Divisi: YY   │  │ Divisi: ZZ   │  │
│  │ Deadline: XX │  │ Deadline: XX │  │ Deadline: XX │  │
│  ├──────────────┤  ├──────────────┤  ├──────────────┤  │
│  │ Progress:    │  │ Progress:    │  │ Progress:    │  │
│  │ [==== ] 4/5  │  │ [=  ] 1/3    │  │ [======] 0/2 │  │
│  ├──────────────┤  ├──────────────┤  ├──────────────┤  │
│  │ [Detail]     │  │ [Detail]     │  │ [Detail]     │  │
│  │ [Review]     │  │ [Review]     │  │ [Review]     │  │
│  │ [Menu ...]   │  │ [Menu ...]   │  │ [Menu ...]   │  │
│  └──────────────┘  └──────────────┘  └──────────────┘  │
│                                                          │
└─────────────────────────────────────────────────────────┘
```

### PIC DASHBOARD - Task List

```
┌──────────────────────────────────────────────────────────┐
│  HEADER: Daftar Tugas Saya                               │
├──────────────────────────────────────────────────────────┤
│                                                           │
│  ┌─────────────┐  ┌─────────────┐  ┌─────────────┐      │
│  │ Total: 5    │  │ Pending: 2  │  │ Selesai: 2  │      │
│  └─────────────┘  └─────────────┘  └─────────────┘      │
│                                                           │
├──────────────────────────────────────────────────────────┤
│                                                           │
│  ┌──────────────┐  ┌──────────────┐  ┌──────────────┐    │
│  │  TASK 1      │  │  TASK 2      │  │  TASK 3      │    │
│  ├──────────────┤  ├──────────────┤  ├──────────────┤    │
│  │ Title        │  │ Title        │  │ Title        │    │
│  │ [🔴 Revisi]  │  │ [🟢 Selesai] │  │ [🟡 Dikirim] │    │
│  │ Supervisor   │  │ Supervisor   │  │ Supervisor   │    │
│  │ Deadline: XX │  │ Deadline: XX │  │ Deadline: XX │    │
│  │              │  │              │  │              │    │
│  │ [Perbaiki]   │  │[Lihat Detail]│  │[Menunggu...] │    │
│  └──────────────┘  └──────────────┘  └──────────────┘    │
│                                                           │
└──────────────────────────────────────────────────────────┘
```

### SUPERVISOR - Review Submissions

```
┌──────────────────────────────────────────────────────────┐
│  Review Submissions: [Task Title]                         │
├──────────────────────────────────────────────────────────┤
│                                                           │
│  ┌────────────────────────────────────────────────────┐  │
│  │ Submission 1: [Andi] - Status: [Submitted]        │  │
│  ├────────────────────────────────────────────────────┤  │
│  │ Catatan: ...                                       │  │
│  │ File: [Download]                                  │  │
│  │ [Setujui] [Tolak]                                 │  │
│  └────────────────────────────────────────────────────┘  │
│                                                           │
│  ┌────────────────────────────────────────────────────┐  │
│  │ Submission 2: [Budi] - Status: [Approved] ✓       │  │
│  ├────────────────────────────────────────────────────┤  │
│  │ Catatan: ...                                       │  │
│  │ File: [Download]                                  │  │
│  │ Disetujui pada: XX Jan 2026                       │  │
│  └────────────────────────────────────────────────────┘  │
│                                                           │
│  ┌────────────────────────────────────────────────────┐  │
│  │ Submission 3: [Citra] - Status: [Rejected]        │  │
│  ├────────────────────────────────────────────────────┤  │
│  │ Catatan: ...                                       │  │
│  │ File: [Download]                                  │  │
│  │ Feedback: "Perlu ditingkatkan..."                 │  │
│  │ Ditolak pada: XX Jan 2026                         │  │
│  └────────────────────────────────────────────────────┘  │
│                                                           │
└──────────────────────────────────────────────────────────┘
```

---

## 🔐 Permission Matrix

```
┌─────────────────────┬──────────────┬─────────────┬────────────┐
│ Action              │ Supervisor   │ PIC         │ SuperAdmin │
├─────────────────────┼──────────────┼─────────────┼────────────┤
│ Create Task         │ ✅ Own Div  │ ❌          │ ❌         │
│ View Task           │ ✅ Own Div  │ ✅ Own Div │ ❌         │
│ Edit Task           │ ✅ Own Div  │ ❌          │ ❌         │
│ Delete Task         │ ✅ Own Div  │ ❌          │ ❌         │
│ View Submissions    │ ✅ Own Div  │ ❌          │ ❌         │
│ Submit Work         │ ❌          │ ✅ Own Div │ ❌         │
│ Edit Submission     │ ❌          │ ✅ if not approved │ ❌  │
│ Approve/Reject      │ ✅ Own Task │ ❌          │ ❌         │
│ View All Tasks      │ ❌          │ ❌          │ ✅         │
│ View All Divisions  │ ❌          │ ❌          │ ✅         │
└─────────────────────┴──────────────┴─────────────┴────────────┘
```

---

## 📊 Entity Relationship Diagram

```
┌──────────────┐           ┌────────────┐
│ Divisions    │           │   Users    │
│              │           │            │
│ id (PK)      │           │ id (PK)    │
│ name         │           │ name       │
│ description  │───1:M────▶│ email      │
│ is_active    │           │ role       │
│              │           │ division_id│
└──────────────┘           └────────────┘
       ▲                           │
       │                           │
       │ 1:M                       │ M:1
       │                           ▼
       │                    ┌──────────────┐
       └─────────────────── │ TaskSubmission│
                            │              │
┌──────────────┐           │ id (PK)      │
│ Tasks        │           │ task_id (FK) │
│              │           │ pic_id (FK)  │
│ id (PK)      │           │ submission.. │
│ division_id  │─1:M──────▶│ status       │
│ supervisor_id│           │ feedback     │
│ title        │           │              │
│ description  │           └──────────────┘
│ deadline     │
│ status       │
│ timestamps   │
└──────────────┘
```

---

## 🎬 Sequence Diagram

```
Supervisor          System                PIC
    │                  │                   │
    │─ Create Task ───▶│                   │
    │                  │─ Save Task ──────▶│
    │                  │                   │ [Receives Task]
    │◀─ Success ────────│                   │
    │                  │                   │
    │─ Review Menu ───▶│                   │
    │                  │                   │
    │                  │◀── View Tasks ────│
    │                  │                   │
    │                  │                   │ [Opens Task]
    │                  │                   │
    │                  │◀── Submit Work ───│
    │                  │                   │
    │─ Review Sub ────▶│                   │
    │ mittions         │                   │
    │                  │                   │
    │─ Approve / ─────▶│                   │
    │  Reject          │─ Update Status ──▶│
    │                  │                   │ [Task Complete]
    │◀─ Success ────────│                   │
    │                  │                   │
```

---

## 📈 Metrics & Statistics

```
SUPERVISOR DASHBOARD:
├─ Total Tasks: Count(tasks)
├─ Assigned: Count(tasks where status = 'assigned')
├─ Pending Review: Count(tasks where status = 'submitted')
├─ Approved: Count(tasks where status = 'approved')
└─ Rejected: Count(tasks where status = 'rejected')

PIC DASHBOARD:
├─ Total Tasks: Count(tasks where division_id = user.division_id)
├─ Completed: Count(submissions where status = 'approved')
├─ Pending: Count(submissions where status = 'submitted')
├─ Revision: Count(submissions where status = 'rejected')
└─ Completion Rate: (Completed / Total) * 100%
```

---

## 🎯 Key Files Location

```
📁 Controllers:
   └─ app/Http/Controllers/
      ├─ Supervisor/TaskController.php ⭐
      └─ PIC/TaskController.php ⭐

📁 Models:
   └─ app/Models/
      ├─ Task.php ⭐
      ├─ TaskSubmission.php ⭐
      ├─ User.php (updated)
      └─ Division.php (updated)

📁 Views:
   └─ resources/views/
      ├─ supervisor/tasks/ ⭐
      └─ pic/tasks/ ⭐

📁 Migrations:
   └─ database/migrations/
      ├─ 2026_01_19_000001_create_tasks_table.php ⭐
      └─ 2026_01_19_000002_create_task_submissions_table.php ⭐

📁 Routes:
   └─ routes/web.php (updated) ⭐

📁 Storage:
   └─ storage/app/submissions/ 📁 (File uploads)
```

---

Diagram ini membantu visualisasi komprehensif dari Task Management System! 🎨
