# CashMind UI/UX Guideline
## Version 3.0 — Clean Modern Personal Finance Interface

Dokumen ini menjadi standar utama tampilan dan interaksi seluruh halaman CashMind.

Tujuan guideline ini adalah memastikan CashMind tidak terlihat seperti template admin generik, tetapi seperti aplikasi personal finance modern yang konsisten, profesional, tenang, mudah digunakan, dan memiliki identitas visual yang kuat.

Guideline ini berlaku untuk:
- Landing Page
- Authentication
- User Dashboard
- Transactions
- Accounts / Wallet
- Budget
- Financial Goals
- Reconciliation
- Reports
- Admin Dashboard
- User Management
- Master Data
- Feature Management
- Security Logs
- Settings
- Modal
- Alert
- Toast
- Form
- Validation
- DataTables
- Select2
- Dropdown
- Pagination
- Empty State
- Loading State
- Responsive Layout

Teknologi utama:
- Laravel 12
- Blade
- Tailwind CSS
- Alpine.js
- Chart.js
- DataTables
- Select2
- MySQL

---

# 1. Arah Desain Utama

CashMind menggunakan pendekatan:

```text
Clean
Calm
Structured
Trustworthy
Modern
Private
Financial
Professional
```

CashMind tidak menggunakan pendekatan:

```text
Heavy Glassmorphism
Excessive Gradient
Neon Color
Random Pastel
Too Many Cards
Too Many Badges
Heavy Shadow
Decorative Emoji
Generic Admin Dashboard
```

Target utama:

> UI harus membantu pengguna memahami keuangan, bukan membuat pengguna kagum karena terlalu banyak efek visual.

---

# 2. Prinsip Visual

Urutan prioritas desain:

```text
Information Hierarchy
↓
Readability
↓
Usability
↓
Consistency
↓
Interaction Feedback
↓
Decoration
```

Setiap elemen yang tidak membantu hierarchy, keterbacaan, atau interaksi harus dihapus.

---

# 3. No Emoji Policy

CashMind tidak menggunakan emoji sebagai elemen sistem.

Dilarang menggunakan emoji pada:
- sidebar;
- topbar;
- button;
- card;
- alert;
- toast;
- empty state;
- notification;
- status;
- transaction type;
- account type;
- landing page feature;
- menu;
- modal;
- dashboard metric.

Gunakan:
- SVG;
- typography;
- color;
- spacing;
- iconography konsisten.

Contoh yang salah:

```text
Keuangan Aman [emoji]
Pemasukan [emoji]
Pengeluaran [emoji]
```

Contoh yang benar:

```text
[SVG Lock] Data keuangan hanya dapat diakses oleh Anda.
[SVG ArrowDownCircle] Pemasukan
[SVG ArrowUpCircle] Pengeluaran
```

---

# 4. SVG Icon System

Gunakan satu icon library secara konsisten.

Rekomendasi utama:

```text
Lucide Icons
```

Alternatif:

```text
Heroicons
```

Jangan mencampur banyak icon library.

## 4.1 Ukuran SVG

```text
Sidebar Icon        18px
Button Icon         16px
Input Icon          16px
Table Action Icon   16px
Card Icon           20px
Feature Icon        24px
Empty State Icon    48–64px
```

## 4.2 Standar SVG

```html
<svg
    width="18"
    height="18"
    viewBox="0 0 24 24"
    fill="none"
    stroke="currentColor"
    stroke-width="1.8"
    stroke-linecap="round"
    stroke-linejoin="round"
>
</svg>
```

Gunakan `currentColor`.

## 4.3 SVG Accessibility

Decorative icon:

```html
<svg aria-hidden="true"></svg>
```

Icon button:

```html
<button aria-label="Tutup modal">
    <svg aria-hidden="true"></svg>
</button>
```

---

# 5. Color System

Gunakan design token.

## 5.1 Neutral

```css
--cm-bg: #F7F8FA;
--cm-surface: #FFFFFF;
--cm-surface-soft: #FAFAFA;
--cm-surface-muted: #F4F4F5;

--cm-border: #E4E4E7;
--cm-border-soft: #F0F0F2;

--cm-text-primary: #18181B;
--cm-text-secondary: #52525B;
--cm-text-muted: #71717A;
--cm-text-disabled: #A1A1AA;
```

## 5.2 Primary Brand

```css
--cm-primary: #4F46E5;
--cm-primary-hover: #4338CA;
--cm-primary-active: #3730A3;
--cm-primary-soft: #EEF2FF;
--cm-primary-border: #C7D2FE;
```

Primary digunakan untuk:
- CTA utama;
- selected navigation;
- focus;
- active tab;
- link utama;
- selected filter;
- primary chart series.

## 5.3 Success

```css
--cm-success: #15803D;
--cm-success-hover: #166534;
--cm-success-soft: #F0FDF4;
--cm-success-border: #BBF7D0;
```

## 5.4 Danger

```css
--cm-danger: #DC2626;
--cm-danger-hover: #B91C1C;
--cm-danger-soft: #FEF2F2;
--cm-danger-border: #FECACA;
```

## 5.5 Warning

```css
--cm-warning: #D97706;
--cm-warning-hover: #B45309;
--cm-warning-soft: #FFFBEB;
--cm-warning-border: #FDE68A;
```

## 5.6 Info

```css
--cm-info: #2563EB;
--cm-info-soft: #EFF6FF;
--cm-info-border: #BFDBFE;
```

---

# 6. Warna Finansial

Gunakan semantic color:

```text
Income       Success / Green
Expense      Danger / Red
Transfer     Primary / Indigo
Adjustment   Warning / Amber
Neutral      Slate
```

Jangan mewarnai seluruh card. Cukup elemen penting seperti nominal, indicator, atau icon.

---

# 7. Typography

Gunakan:

```text
Plus Jakarta Sans
```

Fallback:

```css
font-family:
    "Plus Jakarta Sans",
    Inter,
    ui-sans-serif,
    system-ui,
    sans-serif;
```

## 7.1 Typography Scale

```text
Display        36px / 44px / 700
Page Title     28px / 36px / 700
Section Title  20px / 28px / 600
Card Title     16px / 24px / 600
Body           14px / 22px / 400
Body Strong    14px / 22px / 600
Small          13px / 20px / 400
Caption        12px / 18px / 500
```

Financial hero:

```text
32px–40px / 700
```

---

# 8. Financial Number Styling

```css
.financial-number {
    font-variant-numeric: tabular-nums;
    letter-spacing: -0.01em;
}
```

Format:

```text
Rp 125.000
Rp 1.250.000
Rp 12.500.000
- Rp 125.000
+ Rp 7.000.000
```

---

# 9. Spacing System

Gunakan kelipatan 4:

```text
4
8
12
16
20
24
32
40
48
64
```

## 9.1 Desktop Layout

```text
Page horizontal padding   32–40px
Page vertical padding     28–32px
Section gap               32px
Card gap                  20–24px
Form group gap            20px
Input label gap           6px
```

## 9.2 Mobile Layout

```text
Horizontal padding        16px
Vertical padding          20px
Section gap               24px
Card gap                  16px
```

---

# 10. Border Radius

```text
Card            12px
Large Panel     16px
Input           10px
Button          10px
Select          10px
Dropdown        10px
Modal           16px
Badge           6px
Pill            9999px
```

Jangan menggunakan `rounded-3xl` pada semua komponen.

---

# 11. Shadow

Card:

```css
box-shadow:
    0 1px 2px rgba(15, 23, 42, 0.03),
    0 1px 3px rgba(15, 23, 42, 0.04);
```

Dropdown:

```css
box-shadow:
    0 10px 30px rgba(15, 23, 42, 0.10);
```

Modal:

```css
box-shadow:
    0 24px 64px rgba(15, 23, 42, 0.18);
```

---

# 12. App Layout

Desktop:

```text
┌───────────────┬────────────────────────────────────────────┐
│ Sidebar       │ Topbar                                     │
│ 248px         ├────────────────────────────────────────────┤
│               │                                            │
│               │ Content                                    │
│               │                                            │
└───────────────┴────────────────────────────────────────────┘
```

Sidebar:

```text
width: 248px
background: #FFFFFF
border-right: 1px solid #E4E4E7
```

Topbar:

```text
height: 64px
background: #FFFFFF
border-bottom: 1px solid #F0F0F2
```

Content:

```text
max-width: 1480px
```

---

# 13. Sidebar

User sidebar:

```text
CashMind

OVERVIEW
Dashboard

FINANCE
Transactions
Accounts
Budget

PLANNING
Goals

TOOLS
Reconciliation
Reports

ACCOUNT
Settings
```

Selected state:

```text
Background: #EEF2FF
Text: #4338CA
Icon: #4F46E5
Font: 600
```

Hover:

```text
Background: #F8FAFC
```

---

# 14. Page Header

Format:

```text
Title                             Primary Action
Description                       Secondary Action
```

Contoh:

```text
Transactions                      [Tambah Transaksi]
Kelola seluruh aktivitas
keuangan Anda.
```

---

# 15. Button System

## Primary

```text
Height      40px
Padding     0 16px
Radius      10px
Background  #4F46E5
Text        #FFFFFF
Hover       #4338CA
```

## Secondary

```text
Background  #FFFFFF
Border      #D4D4D8
Text        #27272A
```

## Ghost

Gunakan untuk table action, icon action, toolbar, dan secondary contextual action.

## Danger

```text
Background  #DC2626
Hover       #B91C1C
Text        #FFFFFF
```

Gunakan hanya untuk destructive confirmation.

## States

Semua button wajib mempunyai:

```text
Default
Hover
Focus
Active
Disabled
Loading
```

Loading:

```text
[SVG Spinner] Menyimpan...
```

---

# 16. Form Design

Form harus:
- sederhana;
- jelas;
- label selalu terlihat;
- validation dekat field;
- spacing konsisten;
- mobile friendly;
- keyboard accessible.

Form transaksi gunakan single column.

Settings boleh two-column pada desktop dan single column pada mobile.

---

# 17. Label

```text
13px
font-weight: 600
color: #3F3F46
margin-bottom: 6px
```

Required:

```text
Nominal *
```

---

# 18. Text Input

```text
Height       42px
Radius       10px
Border       #D4D4D8
Background   #FFFFFF
Font         14px
Padding      0 12px
```

Focus:

```text
Border       #6366F1
Ring         rgba(99,102,241,.12)
```

Error:

```text
Border       #DC2626
Ring         rgba(220,38,38,.08)
```

Disabled:

```text
Background   #F4F4F5
Text         #A1A1AA
```

---

# 19. Textarea

```text
min-height: 96px
resize: vertical
```

---

# 20. Currency Input

Nominal menjadi input paling menonjol.

```text
Nominal

Rp 1.250.000
```

Font:

```text
24px
700
```

Backend menyimpan:

```text
1250000
```

Frontend menampilkan:

```text
Rp 1.250.000
```

---

# 21. Select2 Usage

Gunakan Select2 bila:
- opsi > 8;
- perlu search;
- remote data;
- daftar rekening;
- daftar kategori;
- daftar bank;
- daftar e-wallet.

Jangan gunakan Select2 untuk:

```text
Ya / Tidak
Aktif / Nonaktif
Income / Expense
```

---

# 22. Select2 Visual Standard

Container:

```text
height: 42px
border: 1px solid #D4D4D8
border-radius: 10px
background: #FFFFFF
```

Focus:

```text
border-color: #6366F1
box-shadow: 0 0 0 3px rgba(99,102,241,.12)
```

Dropdown:

```text
border: 1px solid #E4E4E7
border-radius: 10px
box-shadow: 0 10px 30px rgba(15,23,42,.10)
```

Search:

```text
height: 38px
border-radius: 8px
```

Selected:

```text
background: #EEF2FF
color: #4338CA
```

Hover:

```text
background: #F8FAFC
```

---

# 23. Select2 Placeholder

Gunakan:

```text
Pilih rekening
Pilih kategori
Pilih bank
Pilih periode
```

---

# 24. Select2 in Modal

Wajib menggunakan:

```javascript
dropdownParent: $('#transaction-modal')
```

---

# 25. Segmented Control

Jenis transaksi:

```text
[Pengeluaran] [Pemasukan] [Transfer]
```

Selected:

```text
Background: #EEF2FF
Border: #C7D2FE
Text: #4338CA
```

---

# 26. Checkbox dan Switch

Checkbox:

```text
16–18px
Active: #4F46E5
```

Switch untuk:
- feature flag;
- category visibility;
- preference;
- non-destructive settings.

---

# 27. Form Help Text

```text
Saldo awal
Jumlah saldo rekening saat pertama kali ditambahkan.
```

Style:

```text
12px
#71717A
margin-top: 6px
```

---

# 28. Validation Architecture

Gunakan:

```text
Frontend Validation
+
Laravel Backend Validation
```

Backend tetap source of truth.

---

# 29. Validation Style

```text
Nominal *

[ Rp 0 ]
Nominal harus lebih besar dari 0.
```

Error text:

```text
12px
#DC2626
margin-top: 6px
```

---

# 30. Validation Copy

Gunakan:

```text
Nominal wajib diisi.
Pilih rekening terlebih dahulu.
Kategori wajib dipilih.
Tanggal transaksi tidak valid.
Nominal transfer melebihi saldo rekening.
Rekening asal dan tujuan tidak boleh sama.
```

---

# 31. Validation Accessibility

```html
<input
    aria-invalid="true"
    aria-describedby="amount-error"
/>

<p id="amount-error">
    Nominal wajib diisi.
</p>
```

---

# 32. Form Submit Behavior

```text
User Submit
↓
Button Loading
↓
Button Disabled
↓
Server Validate
↓
Jika Error → inline validation
↓
Jika Success → save
↓
Toast success
↓
Close modal
↓
Refresh relevant section
```

Modal jangan ditutup sebelum server berhasil.

---

# 33. Modal Usage

Gunakan modal untuk:
- add;
- edit;
- detail sederhana;
- confirmation;
- form maksimal 6–8 field.

Jangan gunakan modal untuk:
- reports;
- complex settings;
- multi-step workflow;
- large tables.

---

# 34. Modal Sizes

```text
Small      400px
Default    520px
Medium     640px
Large      800px
XL         960px
```

Transaction:

```text
560–640px
```

---

# 35. Modal Structure

```text
┌──────────────────────────────────────────┐
│ Title                              [X]   │
│ Description                              │
├──────────────────────────────────────────┤
│                                          │
│ Content                                  │
│                                          │
├──────────────────────────────────────────┤
│                      Batal   [Simpan]     │
└──────────────────────────────────────────┘
```

Header:

```text
20px 24px
```

Body:

```text
24px
```

Footer:

```text
16px 24px
border-top
```

---

# 36. Modal Backdrop

```css
background: rgba(15, 23, 42, 0.45);
```

---

# 37. Modal Interaction

Wajib:
- Escape close;
- SVG close;
- focus trap;
- restore focus ke trigger;
- responsive.

Critical destructive modal tidak ditutup dengan accidental backdrop click.

---

# 38. Delete Modal

```text
Hapus transaksi?

Transaksi "Makan Siang" sebesar Rp 125.000
akan dihapus dan tidak dapat dikembalikan.

[Batal] [Hapus Transaksi]
```

---

# 39. Alert System

Gunakan:

```text
Toast
Inline Alert
Confirmation Modal
```

Dilarang menggunakan browser:

```javascript
alert()
confirm()
```

---

# 40. Toast

Untuk:
- save success;
- update success;
- delete success;
- lightweight information.

Desktop:

```text
top-right
```

Mobile:

```text
top-center
```

Duration:

```text
Success  3–4 detik
Info     4 detik
Warning  5 detik
Error    6 detik / persistent
```

---

# 41. Toast Design

```text
[SVG CheckCircle]

Transaksi tersimpan
Data transaksi berhasil ditambahkan.
```

Style:

```text
Background white
Border #E4E4E7
Accent #15803D
```

---

# 42. Inline Alert

Warning:

```text
[SVG AlertTriangle]

Budget kategori Food sudah mencapai 90%.
```

Style:

```text
Background  #FFFBEB
Border      #FDE68A
Text        #92400E
```

---

# 43. Error Alert

Global error:

```text
Terjadi kesalahan saat menyimpan data.
Silakan coba kembali.
```

Field-specific error tetap tampil di field.

---

# 44. SweetAlert2

Jika digunakan, hanya untuk:
- destructive confirmation;
- important acknowledgement.

Success CRUD menggunakan toast.

---

# 45. DataTables Usage

Gunakan pada:
- Transactions
- Admin Users
- Security Logs
- Master Banks
- Master E-Wallet
- Master Categories
- long datasets.

Jangan gunakan untuk:
- dashboard;
- account cards;
- budget;
- goals.

---

# 46. DataTable Container

```text
background: #FFFFFF
border: 1px solid #E4E4E7
border-radius: 12px
overflow: hidden
```

---

# 47. DataTable Header

```text
background: #FAFAFA
color: #52525B
font-size: 12px
font-weight: 600
```

Gunakan sentence case.

---

# 48. DataTable Row

```text
min-height: 56px
border-bottom: #F0F0F2
```

Hover:

```text
#FAFAFA
```

Tidak menggunakan zebra striping kuat.

---

# 49. DataTable Alignment

```text
Text          left
Date          left
Status        left
Nominal       right
Action        right
```

---

# 50. Transaction Table Columns

```text
Tanggal
Transaksi
Kategori
Rekening
Jenis
Nominal
Aksi
```

Transaction cell:

```text
Makan Siang
Meeting dengan client
```

---

# 51. DataTable Action

Gunakan SVG ellipsis.

Menu:

```text
Lihat
Ubah
Duplikasi
Hapus
```

Hapus menggunakan danger text.

---

# 52. DataTable Search

```text
[SVG Search] Cari transaksi...
```

Desktop width:

```text
280px
```

Mobile:

```text
100%
```

Debounce:

```text
300–500ms
```

---

# 53. DataTable Filter Bar

```text
Search | Jenis | Rekening | Kategori | Periode | Reset
```

Gunakan Select2 pada filter dengan opsi banyak.

---

# 54. Pagination

Page size:

```text
10
25
50
100
```

Default:

```text
25
```

---

# 55. DataTable Empty State

```text
[SVG EmptyState]

Belum ada transaksi

Mulai catat aktivitas keuangan pertama Anda.

[Tambah Transaksi]
```

---

# 56. DataTable No Result

```text
Tidak ada transaksi yang sesuai.

Coba ubah kata kunci atau filter pencarian.

[Reset Filter]
```

---

# 57. DataTables Localization

```text
Menampilkan 1–25 dari 125 data
Cari
Tidak ada data
Memuat...
Sebelumnya
Berikutnya
```

---

# 58. DataTables Processing

Dataset besar:

```javascript
serverSide: true,
processing: true,
pageLength: 25
```

---

# 59. Mobile DataTable

Pada mobile ubah menjadi card list.

```text
19 Sep 2026

Makan Siang
Food

BCA                    - Rp 125.000

[SVG More]
```

---

# 60. Badge

Badge hanya untuk status.

```text
Aktif
Ditangguhkan
Selesai
Menunggu
Gagal
```

Style:

```text
height: 24px
padding: 0 8px
font-size: 12px
font-weight: 600
radius: 6px
```

---

# 61. Tabs

Selected:

```text
text: #4338CA
border-bottom: 2px solid #4F46E5
```

---

# 62. Dropdown

```text
min-width: 180px
background: white
border: #E4E4E7
radius: 10px
padding: 6px
```

Item:

```text
height: 36px
padding: 8px 10px
```

---

# 63. User Dashboard

Dashboard menjawab:

> Bagaimana kondisi keuangan saya saat ini?

Layout:

```text
Dashboard                            September 2026
Ringkasan kondisi keuangan Anda      [Tambah Transaksi]

┌─────────────────────────────────┐ ┌────────────────────────────┐
│ TOTAL SALDO                     │ │ BULAN INI                  │
│ Rp 8.750.000                    │ │ Pemasukan   Rp 7.000.000   │
│ +8,4% dari bulan lalu           │ │ Pengeluaran Rp 4.250.000   │
│                                 │ │ Net         Rp 2.750.000   │
└─────────────────────────────────┘ └────────────────────────────┘

┌──────────────────────────────────────────────────────────────┐
│ Cash Flow                                     1M 3M 6M 1Y   │
│                         CHART                                │
└──────────────────────────────────────────────────────────────┘

┌─────────────────────────────┐ ┌──────────────────────────────┐
│ Spending                    │ │ Recent Transactions          │
│ Donut Chart                 │ │ Transaction List             │
└─────────────────────────────┘ └──────────────────────────────┘
```

---

# 64. Dashboard Hierarchy

Prioritas:

```text
1. Total Balance
2. Monthly Cash Flow
3. Chart
4. Spending
5. Recent Transactions
```

---

# 65. Chart Guidelines

Gunakan sedikit warna.

```text
Income    #15803D
Expense   #DC2626
```

Grid soft neutral.

Animation minimal.

---

# 66. Transactions Page

```text
Transactions                         [Tambah Transaksi]
Kelola seluruh aktivitas keuangan.

[Search] [Jenis] [Rekening] [Kategori] [Periode]

┌───────────────────────────────────────────────┐
│ DataTable                                     │
└───────────────────────────────────────────────┘
```

---

# 67. Add Transaction Modal

```text
Tambah Transaksi

[Pengeluaran] [Pemasukan] [Transfer]

Nominal
Rp 125.000

Rekening
BCA

Kategori
Food & Dining

Tanggal
19 September 2026

Uraian
Makan siang

Catatan
Opsional

[Batal] [Simpan Transaksi]
```

---

# 68. Transaction Form Priority

```text
1. Type
2. Amount
3. Account
4. Category
5. Date
6. Description
7. Note
```

---

# 69. Transfer Form

```text
Rekening Asal
Rekening Tujuan
Nominal
Tanggal
Uraian
Catatan
```

Validasi:

```text
asal != tujuan
nominal > 0
nominal <= saldo jika overdraft tidak diizinkan
```

---

# 70. Accounts Page

Gunakan card, bukan DataTable sebagai primary view.

```text
Accounts                              [Tambah Rekening]

Total Saldo
Rp 8.750.000

YOUR ACCOUNTS

BCA
Rp 6.000.000
Bank
```

---

# 71. Budget Page

```text
Budget                              September 2026
Atur batas pengeluaran Anda.        [Tambah Budget]

Food & Dining
Rp 1.250.000 / Rp 1.500.000
[Progress]
83% digunakan
Rp 250.000 tersisa
```

Status:

```text
0–79%      normal
80–99%     warning
100%+      danger
```

---

# 72. Goals Page

```text
MacBook Pro

Rp 12.500.000
dari Rp 30.000.000

41,7%

Target 30 Juni 2027

[Tambah Dana]
```

---

# 73. Reconciliation

```text
Reconciliation

Pastikan saldo sistem sesuai dengan saldo aktual.

Rekening
Saldo Sistem
Saldo Aktual
Selisih
Catatan
```

---

# 74. Reports

Filter:

```text
Periode
Rekening
Kategori
Jenis
```

Action:

```text
Export CSV
Export PDF
```

---

# 75. Admin Dashboard

Metric:

```text
Total User
User Aktif
User Baru Bulan Ini
User Ditangguhkan
```

Tidak ada metric finansial user.

---

# 76. Admin User Table

```text
User
Email
Terdaftar
Login Terakhir
Status
Aksi
```

---

# 77. Master Data

Gunakan DataTable + modal.

```text
Master Bank                           [Tambah Bank]

Search...

Nama
Tipe
Status
Updated
Action
```

---

# 78. Feature Management

Gunakan setting list, bukan table jika hanya toggle.

```text
Financial Goals

Memungkinkan user membuat target keuangan.

                                  [ ON ]
```

---

# 79. Security Logs

```text
Waktu
User
Event
IP
Device
```

Tidak menyimpan data keuangan.

---

# 80. Landing Page

Struktur:

```text
Navbar
Hero
Product Preview
Features
Privacy
How It Works
FAQ
CTA
Footer
```

---

# 81. Landing Hero

```text
Keuangan pribadi,
lebih mudah dipahami.

Catat pemasukan, pengeluaran,
budget, dan tujuan keuangan
dalam satu ruang pribadi.

[Mulai Gratis]
[Lihat Cara Kerja]

[SVG Lock] Data keuangan hanya dapat diakses oleh Anda.
```

Gunakan screenshot aplikasi nyata.

---

# 82. Authentication

Desktop:

```text
┌──────────────────────┬──────────────────────────┐
│ Brand                │ Masuk                    │
│ Product Message      │                          │
│ Privacy Statement    │ Email                    │
│                      │ Password                 │
│                      │                          │
│                      │ [Masuk]                  │
└──────────────────────┴──────────────────────────┘
```

---

# 83. Empty State

Format:

```text
SVG
Title
Description
CTA
```

---

# 84. Loading

```text
Initial Page    Skeleton
Submit          Button Spinner
DataTable       Processing Loader
Modal Fetch     Skeleton
```

---

# 85. Responsive Breakpoints

```text
sm   640
md   768
lg   1024
xl   1280
2xl  1536
```

Mobile first.

---

# 86. Mobile Modal

Form panjang gunakan bottom sheet atau max 90vh.

Sticky footer action diperbolehkan.

---

# 87. Mobile Filter

```text
[SVG Filter] Filter
```

Bottom sheet:

```text
Jenis
Rekening
Kategori
Periode

[Reset] [Terapkan Filter]
```

---

# 88. Accessibility

Minimum:

```text
Keyboard navigation
Visible focus
Semantic HTML
ARIA where needed
Label association
Modal focus trap
Accessible SVG
Sufficient contrast
```

---

# 89. Focus State

```css
box-shadow: 0 0 0 3px rgba(99,102,241,.18);
```

---

# 90. Language Consistency

Gunakan Bahasa Indonesia:

```text
Tambah
Simpan
Ubah
Hapus
Batal
Cari
Filter
Reset
```

---

# 91. Date & Time

Table:

```text
19 Sep 2026
```

Detail:

```text
19 September 2026
```

Time:

```text
14:35
```

---

# 92. Error Pages

403:

```text
Anda tidak memiliki akses ke halaman ini.
```

404:

```text
Halaman tidak ditemukan.
```

419:

```text
Sesi Anda telah berakhir.
Silakan masuk kembali.
```

500:

```text
Terjadi kesalahan pada sistem.
Silakan coba kembali.
```

Gunakan SVG illustration.

---

# 93. Animation

```text
Hover      150ms
Dropdown   150–180ms
Modal      180–220ms
Toast      180ms
```

Tidak menggunakan bounce dan animated gradient.

---

# 94. Blade Component Structure

```text
resources/views/components/
├── alert/
├── badge/
├── button/
├── card/
├── dropdown/
├── empty-state/
├── form/
├── icons/
├── modal/
├── pagination/
├── skeleton/
├── table/
└── toast/
```

---

# 95. SVG Components

```text
components/icons/
├── dashboard.blade.php
├── transactions.blade.php
├── wallet.blade.php
├── budget.blade.php
├── target.blade.php
├── reconcile.blade.php
├── report.blade.php
├── settings.blade.php
├── plus.blade.php
├── search.blade.php
├── filter.blade.php
├── close.blade.php
├── check.blade.php
├── warning.blade.php
├── trash.blade.php
├── edit.blade.php
└── more.blade.php
```

---

# 96. JavaScript Structure

```text
resources/js/
├── app.js
├── components/
│   ├── modal.js
│   ├── currency-input.js
│   ├── select2.js
│   ├── datatable.js
│   ├── toast.js
│   └── filters.js
```

---

# 97. Plugin CSS

```text
resources/css/plugins/
├── datatables.css
└── select2.css
```

---

# 98. Performance

Untuk DataTable besar:

```text
Server-side pagination
Server filtering
Server sorting
Indexed query
```

Untuk submit:

```text
Disable button
Loading state
Prevent duplicate request
```

---

# 99. Privacy UI Rule

Jangan tampilkan sensitive financial data di:

- URL;
- admin log;
- browser notification;
- global JavaScript object;
- analytics payload;
- HTML attributes jika tidak diperlukan.

---

# 100. Visual QA Checklist

```text
[ ] Color token konsisten
[ ] Typography konsisten
[ ] Spacing konsisten
[ ] Tidak ada emoji
[ ] Semua icon SVG
[ ] Primary CTA jelas
[ ] Tidak ada random gradient
[ ] Tidak terlalu banyak card
[ ] Hover tersedia
[ ] Focus tersedia
[ ] Loading tersedia
[ ] Empty state tersedia
[ ] Error state tersedia
[ ] Mobile diuji
[ ] Tablet diuji
[ ] Desktop diuji
```

---

# 101. Form QA Checklist

```text
[ ] Label ada
[ ] Required jelas
[ ] Validation inline
[ ] Backend validation aktif
[ ] Data tidak hilang saat error
[ ] Submit loading
[ ] Duplicate submit dicegah
[ ] Select2 konsisten
[ ] Select2 dalam modal tidak overflow
```

---

# 102. Modal QA Checklist

```text
[ ] Title jelas
[ ] Close SVG
[ ] Escape bekerja
[ ] Focus trap
[ ] Footer action konsisten
[ ] Validation tidak menutup modal
[ ] Loading tersedia
[ ] Mobile usable
```

---

# 103. DataTable QA Checklist

```text
[ ] Search bekerja
[ ] Filter bekerja
[ ] Sorting bekerja
[ ] Pagination bekerja
[ ] Empty state custom
[ ] No-result state custom
[ ] Bahasa Indonesia
[ ] Currency right aligned
[ ] Action dropdown konsisten
[ ] Mobile card view
```

---

# 104. Alert QA Checklist

```text
[ ] Success menggunakan toast
[ ] Field error inline
[ ] Destructive memakai modal
[ ] Tidak menggunakan browser alert
[ ] Tidak ada emoji
[ ] SVG konsisten
```

---

# 105. Recommended Redesign Priority

```text
1. Design Tokens
2. Typography
3. Color System
4. SVG Icon System
5. Base Layout
6. Sidebar
7. Topbar
8. Button
9. Form
10. Validation
11. Select2
12. Modal
13. Alert
14. Toast
15. DataTables
16. Pagination
17. Empty State
18. Loading State
19. Dashboard
20. Transactions
21. Accounts
22. Budget
23. Goals
24. Reconciliation
25. Reports
26. Admin
27. Landing Page
28. Authentication
29. Responsive QA
30. Accessibility QA
```

---

# 106. Component-First Rule

Selesaikan komponen:

```text
Button
Input
Textarea
Select
Select2
Checkbox
Switch
Badge
Card
Modal
Alert
Toast
Table
Pagination
Dropdown
Empty State
Skeleton
```

Baru susun halaman.

---

# 107. Definition of Done UI

Sebuah halaman CashMind dianggap selesai jika:

```text
[ ] Menggunakan design token
[ ] Tidak ada emoji
[ ] Semua icon SVG
[ ] Typography konsisten
[ ] Spacing konsisten
[ ] Form konsisten
[ ] Select2 themed
[ ] DataTable themed
[ ] Modal themed
[ ] Alert themed
[ ] Validation lengkap
[ ] Loading state ada
[ ] Empty state ada
[ ] Error state ada
[ ] Responsive
[ ] Accessible
[ ] Bahasa Indonesia konsisten
[ ] Privacy boundary aman
[ ] Tidak ada random styling
```

---

# 108. Final Design Formula

```text
Strong Hierarchy
+
Neutral Surface
+
Functional Color
+
Consistent Components
+
SVG Iconography
+
Clear Forms
+
Good Validation
+
Themed DataTables
+
Themed Select2
+
Clean Modal
+
Useful Alerts
+
Responsive Layout
=
CashMind UI
```

Dokumen ini menjadi guideline utama implementasi frontend CashMind selanjutnya.
