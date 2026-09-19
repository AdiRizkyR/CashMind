# CashMind v2 — Project & UI/UX Guideline

## 1. Konsep Utama

CashMind adalah aplikasi pencatatan dan pengelolaan keuangan pribadi yang menempatkan **privacy user sebagai prinsip utama**.

Sistem memiliki dua role:

- **Admin**
- **User**

Prinsip paling penting:

> Data keuangan pribadi hanya dapat dilihat dan dikelola oleh pemilik data tersebut.

Admin tidak memiliki akses untuk membuka transaksi, saldo, pemasukan, pengeluaran, budget, rekening, target keuangan, laporan, ataupun rincian finansial user.

---

## 2. Tujuan Sistem

CashMind harus membantu user untuk:

- mencatat pemasukan;
- mencatat pengeluaran;
- mengetahui saldo saat ini;
- mengetahui dari mana uang masuk;
- mengetahui untuk apa uang digunakan;
- memisahkan uang berdasarkan rekening/dompet;
- mengatur budget;
- membuat target keuangan;
- melakukan rekonsiliasi saldo;
- melihat histori dan tren keuangan;
- menghasilkan laporan pribadi.

Sedangkan fungsi admin adalah:

- mengelola akun;
- mengelola konfigurasi aplikasi;
- mengelola master data;
- memantau operasional aplikasi;
- mengelola fitur;
- menangani keamanan akun.

Admin **bukan financial supervisor user**.

---

## 3. Struktur Role

### ROLE 1 — ADMIN

Admin merupakan operator aplikasi.

Admin dapat:

- melihat daftar user;
- melihat nama user;
- melihat email;
- melihat tanggal registrasi;
- melihat status akun;
- melihat waktu login terakhir;
- mengaktifkan/nonaktifkan akun;
- mengirim password reset;
- mengelola master bank;
- mengelola master e-wallet;
- mengelola template kategori;
- mengelola feature toggle;
- mengelola konfigurasi platform;
- melihat security log;
- melihat statistik penggunaan platform yang tidak mengandung informasi finansial.

Admin tidak dapat:

- melihat saldo user;
- melihat rekening milik user;
- melihat nominal transaksi;
- melihat pemasukan;
- melihat pengeluaran;
- melihat kategori pribadi;
- melihat budget;
- melihat financial goals;
- melihat hasil rekonsiliasi;
- melihat laporan keuangan;
- mengekspor laporan user;
- login sebagai user/impersonate user;
- melihat catatan/deskripsi transaksi.

### ROLE 2 — USER

User adalah pemilik seluruh financial workspace.

User dapat:

- mengelola profil;
- mengelola akun keuangan;
- mencatat pemasukan;
- mencatat pengeluaran;
- melakukan transfer antar akun;
- mengatur kategori;
- membuat budget;
- membuat financial goals;
- melakukan rekonsiliasi;
- melihat analytics;
- membuat laporan;
- export PDF;
- mengubah preferensi aplikasi.

Semua informasi tersebut bersifat private.

---

## 4. Permission Matrix

| Modul | User | Admin |
|---|---:|---:|
| Landing Page | View | View |
| Register | Yes | No |
| Login | Yes | Yes |
| User Profile | Own | Limited |
| Accounts / Wallet | CRUD own | No Access |
| Income | CRUD own | No Access |
| Expense | CRUD own | No Access |
| Transfer | CRUD own | No Access |
| Categories | CRUD own | Template only |
| Budget | CRUD own | No Access |
| Financial Goals | CRUD own | No Access |
| Reconciliation | CRUD own | No Access |
| Reports | Own data | No Access |
| User Management | No | Yes |
| Master Bank | No | CRUD |
| Master E-Wallet | No | CRUD |
| Feature Management | No | CRUD |
| Security Logs | Own optional | Platform security |
| System Settings | No | Yes |

Tidak boleh ada kondisi:

```text
if admin
    allow everything
```

terhadap financial resources.

---

## 5. Sitemap Baru

### PUBLIC

```text
/
├── Landing Page
├── Login
├── Register
├── Forgot Password
└── Reset Password
```

### USER WORKSPACE

```text
/app
├── Dashboard
├── Transactions
│   ├── All Transactions
│   ├── Income
│   ├── Expense
│   └── Transfer
│
├── Accounts
│   ├── Cash
│   ├── Bank
│   └── E-Wallet
│
├── Budget
├── Categories
├── Financial Goals
├── Reconciliation
├── Reports
└── Settings
```

### ADMIN

```text
/admin
├── Dashboard
├── Users
├── Master Data
│   ├── Category Templates
│   ├── Banks
│   └── E-Wallets
│
├── Feature Management
├── Security Logs
└── System Settings
```

---

## 6. Landing Page

Landing page sebaiknya tidak terlalu penuh dengan dashboard palsu, gradient berlebihan atau terlalu banyak glassmorphism.

Target desain:

**simple + trustworthy + financial + privacy-oriented.**

### Section 1 — Navbar

```text
CashMind

Beranda
Fitur
Keamanan
Cara Kerja
FAQ

Masuk
[Mulai Gratis]
```

Navbar sticky ketika scroll.

### Section 2 — Hero

Headline:

**Catat Keuanganmu. Pahami Ke mana Uangmu Pergi.**

Subheadline:

Kelola pemasukan, pengeluaran, budget, rekening dan tujuan keuangan dalam satu tempat yang sederhana dan privat.

CTA:

```text
[Mulai Mencatat]
[Lihat Cara Kerja]
```

Tambahkan microcopy:

```text
🔒 Data keuangan hanya dapat diakses oleh Anda.
```

Visual sebelah kanan:

Dashboard CashMind asli dalam bentuk browser/device mockup.

---

## 7. Landing Page — Feature Section

Gunakan maksimal 6 fitur utama.

### Catat Transaksi

Catat pemasukan dan pengeluaran dengan cepat.

### Kelola Banyak Akun

Pisahkan saldo Cash, Bank dan E-Wallet.

### Budget Planning

Tetapkan batas pengeluaran setiap kategori.

### Financial Goals

Pantau tabungan untuk mencapai target tertentu.

### Financial Analytics

Pahami pola keuangan melalui grafik yang mudah dibaca.

### Private by Design

Informasi keuangan hanya dapat diakses oleh pemilik akun.

---

## 8. Landing — How It Works

Gunakan tiga langkah.

```text
01
Buat Akun

02
Catat Keuangan

03
Pantau dan Evaluasi
```

Jangan membuat penjelasan terlalu panjang.

---

## 9. Landing — Privacy Section

Section khusus wajib dibuat karena privacy menjadi value proposition utama.

Judul:

## Keuangan Pribadi Tetap Pribadi

Informasikan secara eksplisit:

```text
✓ Admin tidak dapat melihat transaksi Anda
✓ Admin tidak dapat melihat saldo Anda
✓ Admin tidak dapat melihat laporan keuangan Anda
✓ Data antar pengguna terisolasi
```

Hal ini jauh lebih penting daripada menampilkan nominal “total uang yang dikelola platform”.

---

## 10. Authentication UI

Login dan Register harus sederhana.

Desktop:

```text
┌────────────────────┬──────────────────────┐
│                    │                      │
│     Branding       │       Login          │
│                    │                      │
│   Illustration     │ Email                │
│                    │ Password             │
│   Privacy message  │                      │
│                    │ [Masuk]              │
│                    │                      │
└────────────────────┴──────────────────────┘
```

Mobile:

Hanya form.

### Register User

Field:

```text
Nama
Email
Password
Konfirmasi Password
```

Role jangan ditampilkan.

Semua register publik otomatis:

```text
role = user
```

Admin hanya dibuat oleh sistem atau admin lain yang memiliki authorization khusus.

---

## 11. User Dashboard

Dashboard harus menjawab pertanyaan:

> Bagaimana kondisi keuangan saya sekarang?

Bukan sekadar menampilkan banyak angka.

### Header

```text
Selamat malam, Adi

September 2026 ▼
```

Tambahkan:

```text
[+ Tambah Transaksi]
```

---

## 12. Dashboard Summary

Gunakan empat informasi utama.

```text
Total Saldo
Rp 8.750.000

Pemasukan Bulan Ini
Rp 7.000.000

Pengeluaran Bulan Ini
Rp 4.250.000

Cash Flow
+ Rp 2.750.000
```

Cash Flow:

```text
Income - Expense
```

Gunakan warna:

- Hijau → income / positive
- Merah → expense
- Biru → neutral
- Amber → warning

Jangan membuat semua card berbeda warna.

---

## 13. Financial Overview

Grafik utama:

### Cash Flow

```text
        Income       Expense

Jan
Feb
Mar
Apr
May
...
```

User dapat memilih:

```text
1M
3M
6M
1Y
```

---

## 14. Expense Breakdown

Donut chart:

```text
Food              32%
Transportation    18%
Bills             17%
Shopping          15%
Entertainment     10%
Other              8%
```

Di sebelah chart tampilkan legend dalam bentuk list.

---

## 15. Recent Transactions

Dashboard tampilkan maksimal 5 transaksi.

```text
Starbucks
Food & Drink
- Rp55.000

Salary
Income
+ Rp7.000.000

PLN
Bills
- Rp425.000
```

CTA:

```text
Lihat Semua Transaksi →
```

---

## 16. Accounts / Wallet

Ini merupakan fitur yang disarankan ditambahkan dari sistem sekarang.

User tidak hanya mempunyai:

```text
Income
Expense
```

tetapi mempunyai tempat uang berada.

Contohnya:

```text
Cash
Rp750.000

BCA
Rp4.500.000

Mandiri
Rp2.000.000

GoPay
Rp350.000
```

Total:

```text
Rp7.600.000
```

Jenis account:

```text
Cash
Bank
E-Wallet
Other
```

---

## 17. Transaction Architecture

Sebaiknya income dan expense secara database digabung menjadi:

```text
transactions
```

Transaction type:

```text
income
expense
transfer
adjustment
```

Hal ini jauh lebih scalable daripada mempertahankan dua sistem terpisah.

---

## 18. Add Transaction

Quick Add Transaction:

```text
Jenis

( ) Income
(●) Expense
( ) Transfer
```

Kemudian:

```text
Nominal
Rp __________________

Account
BCA ▼

Category
Food & Drink ▼

Tanggal
19 September 2026

Catatan
____________________
```

CTA:

```text
[Simpan Transaksi]
```

Untuk transfer:

```text
From
BCA

To
GoPay

Amount
Rp500.000
```

Transfer **bukan expense**.

Ini penting agar laporan tidak salah.

---

## 19. Transactions Page

Header:

```text
Transactions                      [+ Transaction]

September 2026 ▼
```

Filter:

```text
Search
Type
Category
Account
Date
```

Table desktop:

| Date | Description | Category | Account | Type | Amount |
|---|---|---|---|---|---:|

Mobile gunakan cards, bukan tabel horizontal besar.

---

## 20. Budget

Budget berbasis periode.

Contoh:

```text
September 2026

Food
Rp1.250.000 / Rp1.500.000
████████░░ 83%

Transport
Rp650.000 / Rp1.000.000
██████░░░░ 65%
```

Status:

```text
Safe
Warning
Exceeded
```

Rule:

```text
< 80%   Safe
80-100% Warning
> 100%  Exceeded
```

Budget sebaiknya nominal.

Percentage dapat digunakan sebagai kalkulator bantuan, bukan sebagai satu-satunya metode budget.

---

## 21. Financial Goals

Contoh:

```text
MacBook Pro

Rp12.500.000 / Rp30.000.000

████████░░░░░░░ 41.7%

Target:
June 2027

Remaining:
Rp17.500.000
```

User dapat melakukan:

```text
+ Tambah Dana
```

Setiap penambahan harus memiliki histori.

Jangan hanya mengubah field:

```text
current_amount
```

tanpa menyimpan history contribution.

---

## 22. Reconciliation

Konsep Missing Cash tetap bagus tetapi diperbaiki menjadi **Account Reconciliation**.

Contoh:

```text
Account
Cash

System Balance
Rp1.250.000

Actual Balance
Rp1.150.000

Difference
- Rp100.000
```

User dapat memilih:

```text
[Investigasi]
[Buat Adjustment]
```

Adjustment harus menghasilkan transaction dengan:

```text
type = adjustment
```

agar audit trail tetap jelas.

---

## 23. Reports

Filter:

```text
Period
Account
Category
Transaction Type
```

Report:

```text
Financial Summary

Opening Balance
Total Income
Total Expense
Net Cash Flow
Closing Balance
```

Kemudian:

```text
Income Breakdown
Expense Breakdown
Account Balance
Budget Performance
Transaction Detail
```

Export:

```text
PDF
CSV
```

Hapus bagian tanda tangan resmi kecuali sistem memang ditujukan untuk accounting formal.

Untuk aplikasi personal finance, tanda tangan justru membuat experience terasa seperti software administrasi kantor.

---

## 24. Admin Dashboard

Dashboard Admin tidak boleh memiliki:

```text
Total uang user
Volume transaksi Rupiah
Total pemasukan user
Total pengeluaran user
Average balance
Financial Inspector
```

Dashboard admin sebaiknya:

```text
Total Users
1,248

Active Users
1,037

New Users This Month
138

Suspended Accounts
12
```

Chart:

```text
User Registration Growth
```

Tambahkan:

```text
System Status
Database Status
Queue Status
Last Backup
```

jika memang dibutuhkan.

---

## 25. User Management

Admin User List:

| User | Email | Registered | Last Login | Status | Action |
|---|---|---|---|---|---|

Action:

```text
View Profile
Suspend
Activate
Send Password Reset
```

### Detail User

Admin hanya boleh melihat:

```text
Name
Email
Account ID
Registration Date
Last Login
Status
Email Verified
```

Jangan tampilkan:

```text
Balance
Income
Expense
Transaction Count
Financial Goals
Banks
Wallet Balance
Budget
Financial Report
```

---

## 26. Feature Management

Tambahkan feature flag.

Contoh:

```text
Financial Goals              ON
Budget                       ON
Reconciliation               ON
PDF Reports                  ON
Registration                 ON
Maintenance Mode             OFF
```

Database:

```text
features
```

Field:

```text
id
key
name
description
enabled
created_at
updated_at
```

---

## 27. Master Data

Admin dapat mengatur template:

```text
Banks
E-Wallets
Default Category Templates
```

Contoh master bank:

```text
BCA
Mandiri
BRI
BNI
BSI
CIMB
```

Tetapi ketika user memilih bank, account tersebut menjadi milik user.

Admin tidak kemudian mendapat hak membaca account user.

---

## 28. Database Guideline

### users

```text
id
name
email
password
role
status
email_verified_at
last_login_at
created_at
updated_at
```

### accounts

```text
id
user_id
name
type
institution_id
initial_balance
is_active
created_at
updated_at
```

### transactions

```text
id
user_id
account_id
category_id
type
amount
transaction_date
description
transfer_reference_id
created_at
updated_at
deleted_at
```

### categories

```text
id
user_id
name
type
icon
is_system
created_at
updated_at
```

### budgets

```text
id
user_id
category_id
period_month
period_year
amount
created_at
updated_at
```

### goals

```text
id
user_id
name
target_amount
target_date
status
created_at
updated_at
```

### goal_contributions

```text
id
goal_id
user_id
amount
contribution_date
note
created_at
```

### reconciliations

```text
id
user_id
account_id
system_balance
actual_balance
difference
reconciled_at
note
created_at
```

### financial_institutions

```text
id
name
type
logo
status
created_at
updated_at
```

Type:

```text
bank
e_wallet
other
```

### feature_flags

```text
id
key
name
description
enabled
created_at
updated_at
```

---

## 29. Data Ownership

Semua financial table wajib memiliki:

```text
user_id
```

langsung atau melalui parent ownership yang dapat diverifikasi.

Contoh:

```text
transactions.user_id
accounts.user_id
categories.user_id
budgets.user_id
goals.user_id
reconciliations.user_id
```

Query user tidak boleh:

```php
Transaction::find($id);
```

tanpa pengecekan owner.

Konsep yang benar:

```text
Authenticated User
        ↓
Financial Resource
        ↓
user_id MUST equal authenticated user id
```

---

## 30. Authorization

Gunakan:

```text
Middleware
Policies
Form Request
Ownership Scope
```

Jangan hanya menyembunyikan menu.

Karena:

```text
Menu hidden ≠ permission
```

User tetap dapat mencoba mengakses URL/API secara manual.

Setiap resource financial harus divalidasi pada backend.

---

## 31. Laravel Security Rule

Jangan membuat:

```php
Gate::before(function ($user) {
    if ($user->role === 'admin') {
        return true;
    }
});
```

untuk seluruh sistem.

Karena itu secara otomatis memungkinkan admin membaca financial resource.

Permission admin dan user harus benar-benar dipisahkan.

---

## 32. Privacy Architecture

Ada dua tingkat privacy yang perlu dibedakan.

### LEVEL 1 — Application Privacy

Admin aplikasi tidak dapat melihat keuangan user.

Dilakukan menggunakan:

```text
RBAC
Policies
Ownership validation
Database query scoping
Route protection
API protection
```

Ini harus menjadi minimum requirement CashMind v2.

### LEVEL 2 — Cryptographic Privacy

Jika requirement:

> Bahkan orang yang memiliki akses database/server tidak boleh dapat membaca data keuangan.

Maka RBAC saja tidak cukup.

Dibutuhkan pendekatan seperti:

```text
Client-side encryption
User-specific encryption keys
Encrypted financial payload
Zero-knowledge architecture
```

Karena:

```text
Database encryption at rest
```

saja tidak membuat database administrator kehilangan kemampuan membaca data melalui aplikasi/server.

Untuk tahap awal CashMind, Level 1 dapat diterapkan dahulu.

Jika CashMind nantinya akan menjadi produk komersial dengan janji:

**“Tidak seorang pun selain Anda dapat membaca data keuangan Anda”**

maka arsitektur Level 2 harus dirancang secara khusus.

---

## 33. Audit Log

Audit log jangan menyimpan:

```text
Expense Rp500.000
Transfer BCA → GoPay Rp1.000.000
Salary Rp7.000.000
```

Cukup simpan event keamanan seperti:

```text
LOGIN_SUCCESS
LOGIN_FAILED
PASSWORD_CHANGED
ACCOUNT_SUSPENDED
EMAIL_CHANGED
```

Financial audit milik user harus terpisah dari admin security log.

---

## 34. Design System

Disarankan meninggalkan heavy glassmorphism.

Gunakan pendekatan:

**Modern Financial SaaS UI**

Background:

```text
#F8FAFC
```

Card:

```text
#FFFFFF
```

Primary:

```text
#4F46E5
```

Text utama:

```text
#0F172A
```

Secondary text:

```text
#64748B
```

Success:

```text
#10B981
```

Danger:

```text
#EF4444
```

Warning:

```text
#F59E0B
```

Border:

```text
#E2E8F0
```

---

## 35. Typography

Gunakan:

```text
Inter
```

atau:

```text
Plus Jakarta Sans
```

Hierarchy:

```text
Page Title       28–32px / Semibold
Section Title    18–20px / Semibold
Card Value       24–28px / Semibold
Body             14–16px
Caption          12–13px
```

Hindari terlalu banyak bold.

---

## 36. Card Design

Card:

```text
Border radius : 12–16px
Border        : 1px solid #E2E8F0
Shadow        : sangat ringan
Padding       : 20–24px
```

Hindari:

```text
gradient pada setiap card
neon border
glass blur berlebihan
shadow berat
```

Kesan yang ingin dibangun adalah:

```text
calm
clean
trustworthy
financial
private
```

---

## 37. Layout User

Desktop:

```text
┌────────────┬───────────────────────────────────┐
│            │                                   │
│ Sidebar    │             Header                │
│            │                                   │
│ Dashboard  ├───────────────────────────────────┤
│ Transaction│                                   │
│ Accounts   │                                   │
│ Budget     │             CONTENT               │
│ Goals      │                                   │
│ Reports    │                                   │
│            │                                   │
└────────────┴───────────────────────────────────┘
```

Sidebar sekitar:

```text
240–260px
```

Content:

```text
max-width: 1440px
```

---

## 38. Sidebar User

Susunan:

```text
Overview
 Dashboard

Finance
 Transactions
 Accounts
 Budget

Planning
 Financial Goals

Tools
 Reconciliation
 Reports

Account
 Settings
```

Jangan mempunyai terlalu banyak menu level pertama.

---

## 39. Mobile Experience

CashMind harus dirancang **mobile-first** karena pencatatan transaksi kemungkinan lebih sering dilakukan dari HP.

Bottom navigation:

```text
Home
Transaction
+
Budget
Profile
```

Tombol `+` membuka:

```text
Income
Expense
Transfer
```

Form transaksi harus dapat selesai dalam sekitar 15–30 detik.

---

## 40. Empty State

Jangan tampilkan tabel kosong.

Contoh:

```text
Belum ada transaksi

Mulai catat pemasukan atau pengeluaran pertama Anda.

[+ Tambah Transaksi]
```

Gunakan illustration/icon ringan.

---

## 41. Confirmation UX

Untuk delete:

```text
Hapus transaksi?

Transaksi sebesar Rp125.000 akan dihapus.

[Batal] [Hapus]
```

Jangan gunakan browser:

```text
confirm()
```

Gunakan modal aplikasi.

---

## 42. Loading State

Gunakan:

```text
Skeleton
Button spinner
Disabled submit
```

Jangan biarkan user menekan:

```text
Simpan
Simpan
Simpan
```

hingga menghasilkan transaksi duplicate.

---

## 43. Notification Pattern

Success:

```text
✓ Transaksi berhasil ditambahkan.
```

Error:

```text
Nominal wajib diisi.
```

Warning:

```text
Budget Food sudah mencapai 90%.
```

Notification tidak boleh terlalu besar atau mengganggu.

---

## 44. Search & Filter

Filter tidak perlu langsung reload setiap kali dipilih.

Gunakan:

```text
Period
Account
Category
Type
```

dan tombol:

```text
Reset Filter
```

Simpan state filter pada query string jika memungkinkan.

Contoh:

```text
/transactions?month=09&year=2026&type=expense
```

---

## 45. Financial Calculation Rules

Definisikan rumus secara konsisten.

### Income

```text
SUM(transaction WHERE type=income)
```

### Expense

```text
SUM(transaction WHERE type=expense)
```

### Net Cash Flow

```text
Income - Expense
```

### Account Balance

```text
Initial Balance
+ Income
- Expense
+ Incoming Transfer
- Outgoing Transfer
± Adjustment
```

Transfer tidak masuk ke income atau expense.

---

## 46. Security Requirements

Minimum:

```text
CSRF protection
XSS protection
SQL Injection protection
Rate limiting
Password hashing
Secure session
Email verification
Password reset
Authorization policy
Ownership validation
Mass-assignment protection
```

Untuk login admin sebaiknya mendukung:

```text
2FA
```

---

## 47. Acceptance Test Privacy

Test berikut wajib lolos sebelum release.

### Test 1

User A mencoba:

```text
/transactions/{transaction-user-B}
```

Expected:

```text
403 / 404
```

### Test 2

User A mencoba update transaction User B melalui API.

Expected:

```text
403 / 404
```

### Test 3

Admin mencoba membuka financial endpoint.

Expected:

```text
403
```

### Test 4

Admin melihat detail user.

Expected:

```text
Tidak ada financial information.
```

### Test 5

Security log admin.

Expected:

```text
Tidak mengandung nominal maupun deskripsi transaksi.
```

---

## 48. User Experience Target

Untuk transaksi sederhana, target flow:

```text
Dashboard
    ↓
+ Transaction
    ↓
Expense
    ↓
Amount
    ↓
Category
    ↓
Account
    ↓
Save
```

Maksimal sekitar:

```text
5–6 interaksi utama
```

Jangan membuat pencatatan sederhana memerlukan form panjang.

---

## 49. Fitur yang Sebaiknya Dipertahankan dari Project Sekarang

Pertahankan konsep:

```text
Income
Expense
Categories
Budget
Financial Goals
Reconciliation
Reports
Charts
```

Tetapi susun ulang menjadi:

```text
Accounts
        ↓
Transactions
        ↓
Categories
        ↓
Budget
        ↓
Goals
        ↓
Reconciliation
        ↓
Reports
```

Dengan demikian seluruh modul saling terhubung.

---

## 50. Fitur yang Sebaiknya Dihapus atau Diubah

### Hapus

```text
Admin Financial Inspector
Admin user income viewer
Admin user expense viewer
Admin user balance viewer
Global financial volume dashboard
Admin impersonation
```

### Ubah

```text
Income + Expense
        ↓
Unified Transactions
```

```text
Missing Cash
        ↓
Account Reconciliation
```

```text
Password reset oleh admin
        ↓
Send password reset link
```

```text
Admin financial audit
        ↓
Security audit
```

---

## 51. Recommended Development Priority

### PHASE 1 — Security & Architecture

Kerjakan terlebih dahulu:

```text
Role separation
Financial ownership
Policies
Admin permission cleanup
Database relationship cleanup
Privacy testing
```

Ini paling penting.

### PHASE 2 — Financial Core

Kerjakan:

```text
Accounts
Unified Transactions
Income
Expense
Transfer
Categories
Dashboard calculation
```

Setelah tahap ini sistem sudah usable.

### PHASE 3 — Financial Planning

Kerjakan:

```text
Budget
Goals
Goal Contributions
Reconciliation
```

### PHASE 4 — Reporting

Kerjakan:

```text
Monthly reports
Annual reports
PDF export
CSV export
Charts
Analytics
```

### PHASE 5 — UI/UX

Refactor:

```text
Landing
Authentication
Dashboard
Sidebar
Cards
Tables
Forms
Responsive UI
Empty states
Loading states
Notifications
```

### PHASE 6 — Admin Console

Kerjakan:

```text
Admin Dashboard
User Management
Master Data
Feature Management
Security Logs
System Settings
```

---

## 52. Final Product Structure

Hasil akhirnya seharusnya bukan sekadar:

> aplikasi pencatatan pemasukan dan pengeluaran.

Tetapi menjadi:

## Personal Finance Workspace

dengan struktur:

```text
                         CASHMIND

                           USER
                            │
           ┌────────────────┼────────────────┐
           │                │                │
        ACCOUNTS       TRANSACTIONS        GOALS
           │                │                │
     ┌─────┼─────┐     ┌────┼────┐           │
   Cash   Bank Wallet Income Expense      Savings
                          │
                       Categories
                          │
                        Budget
                          │
                       Analytics
                          │
                       Reports
```

Sedangkan:

```text
                         ADMIN
                           │
             ┌─────────────┼─────────────┐
             │             │             │
           USERS       MASTER DATA     SYSTEM
             │             │             │
          Status          Banks        Feature
          Account       E-Wallet       Config
          Security      Templates       Logs
```

Tidak ada hubungan Admin → Financial Data.

---

## 53. Prinsip Utama CashMind v2

Setiap keputusan development harus mengikuti lima prinsip:

### 1. Privacy First

Financial data adalah milik user.

### 2. Simple Recording

Mencatat transaksi harus cepat.

### 3. Accurate Balance

Saldo harus dapat ditelusuri berdasarkan account dan transaction.

### 4. Useful Insight

Dashboard harus membantu user memahami kondisi finansial, bukan sekadar menampilkan grafik.

### 5. Clean UI

Interface harus terasa seperti modern financial product, bukan dashboard admin template generik.

---

## Final Direction

CashMind v2 sebaiknya bergerak dari:

```text
Income / Expense Recording App
```

menjadi:

```text
Private Personal Financial Management System
```

dengan tiga pondasi utama:

```text
PRIVACY
    +
ACCURATE FINANCIAL DATA
    +
SIMPLE USER EXPERIENCE
```

Dan boundary sistem harus sangat jelas:

```text
ADMIN
manages the PLATFORM

USER
manages their FINANCES
```

Bukan:

```text
ADMIN
manages the PLATFORM
and can inspect USER FINANCES
```

Itulah perubahan arsitektur terpenting yang harus dilakukan sebelum memperbaiki visual aplikasi.
