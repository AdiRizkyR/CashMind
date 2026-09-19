# CashMind Redesign Guideline
## Version 4.0 — Mobile-First Financial Product Redesign

Dokumen ini adalah **redesign guideline penuh** untuk CashMind.

Versi ini **tidak mempertahankan bahasa visual lama**. Tujuannya bukan memperhalus tampilan sebelumnya, tetapi membangun tampilan baru dari dasar dengan struktur, warna, typography, layout, navigasi, komponen, responsivitas, dan interaksi yang berbeda.

CashMind harus terasa seperti **produk personal finance modern**, bukan admin dashboard yang diberi fitur keuangan.

---

# 1. Prinsip Redesign

Versi lama tidak boleh dijadikan patokan visual.

Hal berikut **harus ditinggalkan**:

- sidebar besar yang mendominasi layar;
- dashboard berupa banyak card kecil dengan bobot visual sama;
- background gradient;
- glassmorphism;
- card transparan;
- terlalu banyak border radius besar;
- warna pastel pada banyak komponen;
- badge pada hampir semua data;
- layout desktop yang hanya "dikecilkan" untuk mobile;
- DataTable desktop dipaksa scroll horizontal pada mobile;
- modal terlalu tinggi;
- form padat;
- font lama jika memberikan kesan template;
- icon emoji;
- icon dengan style campur-campur;
- warna primer yang terlalu dekat dengan warna status;
- terlalu banyak container di dalam container;
- semua informasi dibungkus card.

Redesign baru mengikuti prinsip:

```text
MOBILE FIRST
CONTENT FIRST
FINANCIAL FIRST
LOW VISUAL NOISE
STRONG HIERARCHY
CLEAR ACTION
CONSISTENT COMPONENTS
```

---

# 2. Identitas Visual Baru

Nama gaya:

## CashMind Ledger UI

Karakter:

```text
Structured
Precise
Calm
Modern
Premium
Dense when necessary
Spacious when important
Mobile-native
Financial
```

CashMind Ledger UI bukan:

```text
Glass SaaS
Colorful Dashboard
AdminLTE-style UI
Generic Tailwind Dashboard
Crypto Dashboard
Banking App Clone
```

---

# 3. Font Baru

Gunakan:

## Manrope

Alasan:

- lebih modern;
- lebih bersih untuk angka;
- lebih distinctive dibanding font dashboard umum;
- memiliki karakter profesional tetapi tidak terlalu corporate;
- nyaman untuk mobile;
- heading terlihat lebih premium.

Fallback:

```css
font-family:
    "Manrope",
    Inter,
    ui-sans-serif,
    system-ui,
    sans-serif;
```

---

# 4. Typography System Baru

## Desktop

```text
Hero Display      44px / 52px / 700
Page Title        30px / 38px / 700
Section Title     20px / 28px / 700
Card Title        15px / 22px / 600
Body              14px / 22px / 400
Body Strong       14px / 22px / 600
Meta              12px / 18px / 500
Financial Large   34px / 42px / 700
Financial Medium  22px / 30px / 700
```

## Mobile

```text
Page Title        24px / 32px / 700
Section Title     18px / 26px / 700
Body              14px / 21px / 400
Meta              12px / 18px / 500
Financial Large   28px / 36px / 700
```

---

# 5. Warna Baru

Palet lama tidak digunakan.

CashMind v4 menggunakan kombinasi:

```text
Ink
Warm Neutral
Teal Accent
Functional Green
Functional Red
Amber
```

---

## 5.1 Base

```css
--cm-bg: #F4F6F8;
--cm-bg-soft: #F8FAFB;
--cm-surface: #FFFFFF;
--cm-surface-elevated: #FFFFFF;

--cm-text: #101828;
--cm-text-secondary: #475467;
--cm-text-muted: #667085;
--cm-text-disabled: #98A2B3;

--cm-border: #E4E7EC;
--cm-border-soft: #EAECF0;
```

---

## 5.2 Primary

Primary bukan lagi indigo.

Gunakan:

```css
--cm-primary: #0F172A;
--cm-primary-hover: #1E293B;
--cm-primary-active: #020617;
--cm-primary-soft: #F1F5F9;
```

Primary digunakan pada:

- button utama;
- active navigation;
- headline emphasis;
- important icon;
- selected state tertentu.

---

## 5.3 Accent

Gunakan teal untuk identitas CashMind.

```css
--cm-accent: #0F766E;
--cm-accent-hover: #115E59;
--cm-accent-soft: #F0FDFA;
--cm-accent-border: #99F6E4;
```

Accent digunakan pada:

- financial insight;
- selected date;
- chart utama;
- active chip;
- highlight produk.

Jangan gunakan accent sebagai warna semua button.

---

## 5.4 Semantic

Income:

```css
--cm-income: #15803D;
--cm-income-soft: #F0FDF4;
```

Expense:

```css
--cm-expense: #B42318;
--cm-expense-soft: #FEF3F2;
```

Warning:

```css
--cm-warning: #B54708;
--cm-warning-soft: #FFFAEB;
```

Info:

```css
--cm-info: #175CD3;
--cm-info-soft: #EFF8FF;
```

---

# 6. Warna Tidak Boleh Digunakan Sebagai Dekorasi

Dilarang:

```text
Card 1 biru
Card 2 hijau
Card 3 ungu
Card 4 orange
```

Gunakan warna hanya jika memiliki arti.

Contoh benar:

```text
Income      hijau
Expense     merah
Primary     ink
Accent      teal
Warning     amber
```

---

# 7. Struktur Layout Baru

Desktop tidak lagi menggunakan sidebar besar 248–280px.

Gunakan:

## Compact Navigation Rail + Content Shell

```text
┌──────┬─────────────────────────────────────────────────────┐
│      │                                                     │
│ Rail │                  Top Header                         │
│ 72px │                                                     │
│      ├─────────────────────────────────────────────────────┤
│      │                                                     │
│      │                  Main Content                       │
│      │                                                     │
│      │                                                     │
└──────┴─────────────────────────────────────────────────────┘
```

Navigation rail:

```text
width: 72px
```

Jika user membuka expanded navigation:

```text
width: 232px
```

Expanded state hanya optional.

---

# 8. Navigation Rail

Desktop default:

```text
CashMind Logo

Dashboard
Transactions
Accounts
Budget
Goals
Reports

---

Settings
Profile
```

Gunakan SVG icon.

Tidak tampilkan label pada rail compact.

Tooltip tampil saat hover.

Active:

```text
background: #F1F5F9
icon: #0F172A
```

Tambahkan active indicator:

```text
3px vertical teal line
```

---

# 9. Mobile Navigation Baru

Mobile tidak menggunakan sidebar drawer sebagai navigasi utama.

Gunakan:

## Bottom Navigation

```text
Dashboard
Transaksi
Tambah
Anggaran
Lainnya
```

Visual:

```text
┌─────────────────────────────────┐
│ Home  Transaksi   +   Budget ⋯ │
└─────────────────────────────────┘
```

Height:

```text
64–72px
```

Posisi:

```text
fixed bottom
```

Gunakan safe-area:

```css
padding-bottom: env(safe-area-inset-bottom);
```

---

# 10. Mobile Primary Action

Tombol tengah:

```text
[ + ]
```

Bukan floating besar yang menutupi konten.

Tap membuka bottom sheet:

```text
Tambah Pengeluaran
Tambah Pemasukan
Transfer
```

Gunakan SVG.

Tidak menggunakan emoji.

---

# 11. Top Header Baru

Desktop:

```text
Page context                         Search   Notifications   Profile
```

Height:

```text
68px
```

Tidak perlu page title besar di topbar.

Page title tetap di content.

Mobile:

```text
CashMind / Page title                     Profile
```

Search di mobile menggunakan full-screen search sheet jika dibutuhkan.

---

# 12. Content Width

Desktop:

```text
max-width: 1360px
margin: auto
padding: 32px
```

Large desktop:

```text
max-width: 1440px
```

Mobile:

```text
padding: 16px
padding-bottom: 96px
```

Padding bawah mobile harus memperhitungkan bottom navigation.

---

# 13. Page Structure

Setiap halaman:

```text
Page Header
↓
Primary Content
↓
Secondary Content
↓
Supporting Content
```

Jangan membuat:

```text
Header Card
↓
Filter Card
↓
Table Card
↓
Footer Card
```

Gunakan card hanya jika memang membentuk satu surface.

---

# 14. Page Header Baru

Desktop:

```text
Transactions

Semua aktivitas keuangan Anda.

                                      [Tambah Transaksi]
```

Mobile:

```text
Transactions                 [+]
Semua aktivitas keuangan Anda.
```

Tidak perlu breadcrumb kecuali admin nested page.

---

# 15. Dashboard Struktur Baru

Dashboard lama dengan 4 metric card sederajat harus dihapus.

Gunakan komposisi:

```text
Financial Snapshot
↓
Cash Flow
↓
Recent Activity + Budget Health
↓
Goals
```

---

# 16. Dashboard Desktop

```text
Dashboard                                           September 2026

┌───────────────────────────────────────────────────────────────────┐
│ FINANCIAL SNAPSHOT                                                │
│                                                                   │
│ Rp 8.750.000                                                      │
│ Total saldo                                                       │
│                                                                   │
│ + Rp 7.000.000        - Rp 4.250.000        Rp 2.750.000          │
│ Pemasukan bulan ini   Pengeluaran             Net cash flow       │
└───────────────────────────────────────────────────────────────────┘

┌───────────────────────────────────────────────────────────────────┐
│ Cash Flow                                    3M  6M  1Y           │
│                                                                   │
│                            chart                                  │
└───────────────────────────────────────────────────────────────────┘

┌─────────────────────────────────┐ ┌───────────────────────────────┐
│ Aktivitas Terbaru               │ │ Kesehatan Anggaran           │
│                                 │ │                               │
│ transaction list                │ │ budget progress list          │
└─────────────────────────────────┘ └───────────────────────────────┘

┌───────────────────────────────────────────────────────────────────┐
│ Target Keuangan                                                   │
│ compact horizontal goal list                                      │
└───────────────────────────────────────────────────────────────────┘
```

---

# 17. Dashboard Mobile

Mobile bukan versi desktop yang ditumpuk begitu saja.

Gunakan:

```text
Dashboard
September 2026

TOTAL SALDO
Rp 8.750.000

Pemasukan            Pengeluaran
Rp 7.000.000          Rp 4.250.000

Net Cash Flow
Rp 2.750.000

Cash Flow
[Chart]

Aktivitas Terbaru
[List]

Budget
[List]

Goals
[Horizontal scroll cards]
```

---

# 18. Financial Snapshot

Gunakan satu panel utama, bukan 4 card.

Panel:

```text
background: #FFFFFF
border: 1px solid #E4E7EC
radius: 16px
padding: 24px desktop
padding: 20px mobile
```

Balance menjadi anchor.

Income/expense/net ditempatkan sebagai summary grid.

---

# 19. Dashboard Chart

Chart besar:

```text
min-height desktop: 300px
min-height mobile: 220px
```

Gunakan line chart atau area-line tipis.

Jangan gunakan bar chart berat jika visual terlalu penuh.

Rekomendasi:

```text
Income  line teal
Expense line muted red
```

Background fill sangat tipis.

---

# 20. Transaction List Dashboard

Jangan gunakan DataTable penuh.

Gunakan list:

```text
[SVG icon] Makan Siang
           Food • BCA
                               - Rp 125.000
                               19 Sep
```

Maksimal:

```text
5–7 transaksi
```

---

# 21. Cards Baru

Card tidak menggunakan shadow sebagai default.

Standard:

```css
background: #FFFFFF;
border: 1px solid #E4E7EC;
border-radius: 16px;
```

Shadow hanya pada:

- dropdown;
- modal;
- floating menu.

---

# 22. Surface Hierarchy

Gunakan:

```text
Level 0 = page background
Level 1 = white section
Level 2 = elevated modal/dropdown
```

Jangan membuat banyak nested card.

---

# 23. Button Style Baru

Primary button menggunakan ink, bukan teal.

```text
background: #0F172A
text: #FFFFFF
height: 42px
radius: 10px
```

Hover:

```text
#1E293B
```

---

# 24. Accent Button

Teal hanya untuk konteks tertentu.

Contoh:

```text
Mulai Rekonsiliasi
```

Bukan default semua primary action.

---

# 25. Secondary Button

```text
background: #FFFFFF
border: #D0D5DD
text: #344054
```

Hover:

```text
background: #F9FAFB
```

---

# 26. Ghost Button

Gunakan untuk:

- filter trigger;
- row actions;
- icon actions;
- secondary navigation.

---

# 27. Icon Button

Ukuran:

```text
36px
```

Hit area mobile:

```text
minimum 44px
```

Gunakan tooltip desktop.

---

# 28. Button Responsive

Desktop:

```text
label + icon
```

Mobile:

Primary action tetap mempunyai label jika ruang cukup.

Toolbar secondary action boleh icon only dengan accessible label.

---

# 29. Form Layout Baru

Form transaksi tidak ditempatkan pada modal tengah di mobile.

## Desktop

Gunakan side sheet:

```text
Page
                                     ┌──────────────────────────┐
                                     │ Tambah Transaksi         │
                                     │                          │
                                     │ form                     │
                                     │                          │
                                     └──────────────────────────┘
```

Width:

```text
440–480px
```

## Mobile

Gunakan full-screen sheet.

```text
100vw
100dvh
```

---

# 30. Form Transaction Desktop

Side sheet:

```text
Tambah Transaksi                   [X]

[Pengeluaran] [Pemasukan] [Transfer]

Nominal
Rp 125.000

Rekening
BCA

Kategori
Food & Dining

Tanggal
19 Sep 2026

Uraian
Makan siang

Catatan
Opsional

--------------------------------------
[Batal]              [Simpan Transaksi]
```

---

# 31. Form Transaction Mobile

Full-screen:

```text
← Tambah Transaksi

Pengeluaran | Pemasukan | Transfer

Nominal
Rp 125.000

Rekening
[BCA]

Kategori
[Food & Dining]

Tanggal
[19 Sep 2026]

Uraian
[Makan siang]

Catatan
[Opsional]

----------------------------------
          [Simpan Transaksi]
```

Bottom action sticky.

---

# 32. Form Field Height

Desktop:

```text
44px
```

Mobile:

```text
48px
```

Alasan:

- lebih nyaman disentuh;
- lebih mobile-friendly;
- lebih modern.

---

# 33. Input Style Baru

```css
background: #FFFFFF;
border: 1px solid #D0D5DD;
border-radius: 10px;
color: #101828;
```

Placeholder:

```text
#98A2B3
```

Focus:

```css
border-color: #0F766E;
box-shadow: 0 0 0 3px rgba(15, 118, 110, 0.10);
```

---

# 34. Label Baru

```text
14px
font-weight: 600
color: #344054
```

Required:

```text
*
```

warna:

```text
#B42318
```

---

# 35. Field Description

```text
13px
color: #667085
```

Gunakan hanya jika diperlukan.

---

# 36. Currency Input

Currency input harus terasa seperti financial app.

```text
Nominal

Rp
1.250.000
```

Mobile:

```text
font-size: 30px
font-weight: 700
```

Desktop:

```text
font-size: 26px
```

Gunakan:

```html
inputmode="numeric"
```

---

# 37. Segmented Transaction Type

Gunakan segmented control horizontal.

```text
Pengeluaran | Pemasukan | Transfer
```

Container:

```text
background: #F2F4F7
padding: 4px
radius: 10px
```

Selected:

```text
background: white
text: #101828
shadow: subtle
```

Jangan selected menggunakan merah/hijau penuh.

---

# 38. Select2 Redesign

Select2 harus terlihat seperti field native desain.

Container mobile:

```text
height: 48px
```

Desktop:

```text
height: 44px
```

Border:

```text
#D0D5DD
```

Focus:

```text
#0F766E
```

---

# 39. Select2 Dropdown Mobile

Pada mobile, Select2 dropdown standar sering buruk.

Untuk mobile:

- dropdown search muncul dalam bottom sheet;
- option height minimal 48px;
- search sticky;
- close/back button jelas.

Jika plugin tidak mendukung UX tersebut dengan baik, gunakan custom searchable selector berbasis Alpine.

---

# 40. Select2 Search

```text
[SVG Search] Cari kategori...
```

Search field sticky pada dropdown panjang.

---

# 41. Select Option Structure

Category:

```text
[SVG] Food & Dining
```

Bank:

```text
[Logo/SVG] BCA
```

Jangan emoji.

---

# 42. Validation Baru

Validation harus inline.

Input error:

```text
border: #FDA29B
focus: #D92D20
```

Message:

```text
13px
color: #D92D20
```

Contoh:

```text
Nominal harus lebih besar dari Rp 0.
```

---

# 43. Validation Timing

Jangan menampilkan error sebelum user berinteraksi.

Gunakan:

```text
on blur
atau
setelah submit pertama
```

Setelah submit gagal, validasi boleh realtime.

---

# 44. Form Error Summary

Untuk form panjang:

```text
Terdapat 3 data yang perlu diperbaiki.
```

Tidak perlu jika form pendek.

---

# 45. Modal Redesign

Modal tengah hanya untuk:

- confirmation;
- small settings;
- simple edit;
- short informational dialog.

Form besar tidak lagi menggunakan center modal.

---

# 46. Modal Desktop

```text
width: 420–560px
```

Radius:

```text
18px
```

Backdrop:

```text
rgba(15, 23, 42, .40)
```

---

# 47. Modal Mobile

Confirmation modal:

```text
bottom sheet
```

bukan center tiny modal.

Structure:

```text
──────── drag handle

Hapus transaksi?

Transaksi ini akan dihapus permanen.

[Batal]
[Hapus Transaksi]
```

---

# 48. Alert Strategy

Tidak ada browser alert.

Gunakan:

```text
Toast
Inline Banner
Bottom Sheet Confirmation
```

---

# 49. Toast Baru

Desktop:

```text
bottom-right
```

Mobile:

```text
top-center
```

Toast:

```text
width desktop: 360px
width mobile: calc(100vw - 32px)
```

---

# 50. Toast Visual

Success:

```text
[SVG check]
Transaksi berhasil disimpan
```

Tidak perlu deskripsi panjang jika message cukup.

Background:

```text
#FFFFFF
```

Border:

```text
#EAECF0
```

Icon container:

```text
#ECFDF3
```

---

# 51. Inline Banner

Gunakan untuk masalah yang relevan pada halaman.

Budget warning:

```text
[SVG AlertCircle]
Anggaran Food tersisa Rp 150.000 untuk bulan ini.
```

---

# 52. DataTables Redesign

Desktop tetap menggunakan table.

Mobile **tidak menggunakan table**.

Ini aturan wajib.

---

# 53. DataTable Desktop Structure

Toolbar berada di luar table.

```text
Transactions

Search                               [Filter] [+ Transaction]

Active Filters

┌─────────────────────────────────────────────────────────┐
│ Tanggal | Transaksi | Rekening | Kategori | Nominal | ⋯│
├─────────────────────────────────────────────────────────┤
│                                                         │
└─────────────────────────────────────────────────────────┘

Showing 1–25 of 128                     ‹ 1 2 3 4 ›
```

---

# 54. DataTable Toolbar

Search:

```text
width: 320px
```

Filter menggunakan button yang membuka popover/panel.

Jangan menaruh 5 select berjejer permanen.

Ini membuat layout lebih bersih.

---

# 55. Filter Popover Desktop

```text
Filter Transaksi

Jenis
[Semua]

Rekening
[Semua Rekening]

Kategori
[Semua Kategori]

Periode
[September 2026]

[Reset] [Terapkan]
```

---

# 56. Filter Mobile

Full bottom sheet.

```text
Filter

Jenis
Rekening
Kategori
Periode

[Reset]
[Terapkan Filter]
```

---

# 57. Transaction Table Columns

Desktop:

```text
Tanggal
Transaksi
Rekening
Kategori
Nominal
Aksi
```

Tidak perlu kolom "Jenis" jika jenis bisa dipahami melalui icon/amount style.

Jika dibutuhkan, tambahkan.

---

# 58. Table Row Height

```text
64px
```

Cell padding:

```text
12px 16px
```

---

# 59. Table Header

```text
background: #F9FAFB
font-size: 12px
font-weight: 600
color: #475467
```

Tidak uppercase.

---

# 60. Table Amount

Income:

```text
+ Rp 7.000.000
color: #15803D
```

Expense:

```text
- Rp 125.000
color: #B42318
```

Transfer:

```text
Rp 500.000
color: #344054
```

---

# 61. Row Actions

Gunakan ellipsis SVG.

Menu:

```text
Lihat Detail
Ubah
Duplikasi
Hapus
```

---

# 62. DataTables Pagination

Gunakan custom styling.

Desktop:

```text
Showing 1–25 of 128
```

Pagination:

```text
‹ 1 2 3 4 5 ›
```

Mobile:

```text
[Previous]     Page 2 of 6     [Next]
```

---

# 63. Mobile Transaction List

Card/table hybrid:

```text
Makan Siang                             - Rp 125.000
Food & Dining

BCA                                     19 Sep 2026
```

Separator line antar item.

Tidak perlu card individual dengan border besar.

Gunakan list surface putih.

---

# 64. Mobile List Action

Tap row membuka detail bottom sheet.

Long-press tidak digunakan sebagai primary interaction.

---

# 65. Search Mobile

Search:

```text
full width
height: 46px
```

Dengan SVG search.

---

# 66. Accounts Layout Baru

Desktop:

```text
Accounts                                         [+ Add Account]

Total Balance
Rp 8.750.000

Accounts
┌────────────────────────┐
│ BCA                    │
│ Bank                   │
│                        │
│ Rp 6.000.000           │
│                        │
│ 12 transactions        │
└────────────────────────┘
```

Card maksimal 3 kolom.

---

# 67. Accounts Mobile

Gunakan list besar:

```text
BCA
Bank

Rp 6.000.000                     >
```

Tidak pakai grid kecil dua kolom.

---

# 68. Budget Layout Baru

Desktop:

```text
Budget                                     September 2026

Monthly Spending
Rp 4.250.000 / Rp 6.500.000

[overall progress]

Categories

Food & Dining
Rp 1.250.000 / Rp 1.500.000
[progress]

Transport
Rp 650.000 / Rp 1.000.000
[progress]
```

Lebih seperti report/list daripada banyak card.

---

# 69. Goals Layout Baru

Desktop:

Goals dapat berupa 2-column card.

Mobile:

horizontal progress list / stacked large cards.

Goal card:

```text
MacBook Pro
41%

Rp 12.500.000 dari Rp 30.000.000

[progress]

Target 30 Jun 2027
```

---

# 70. Reports Layout Baru

Reports tidak dibuat seperti dashboard kedua.

Gunakan:

```text
Report Header
Date Range
Summary
Breakdown
Detailed Transactions
Export
```

Desktop:

```text
summary horizontal
```

Mobile:

```text
summary stacked
```

---

# 71. Admin Layout Baru

Admin menggunakan expanded left navigation, bukan compact rail.

Alasan:

- menu admin lebih banyak;
- pekerjaan admin bersifat operational;
- desktop-oriented.

Width:

```text
232px
```

Namun mobile tetap drawer.

---

# 72. Admin Navigation

```text
Overview
Users
Master Data
Features
Security Logs
Settings
```

No emoji.

---

# 73. Admin Dashboard Baru

Tidak memakai visual finansial.

```text
Platform Overview

Users
1,248

Active
1,037

New
138

Suspended
12

--------------------------------

User Growth
[chart]

--------------------------------

System Health
Application      Healthy
Database         Connected
Queue            Running
Backup           Success
```

---

# 74. Admin User Management Mobile

Desktop:

DataTable.

Mobile:

user list.

```text
Adi Rizky
adi@example.com

Active                         >
```

Detail user membuka full page atau bottom sheet.

---

# 75. Landing Page Redesign

Landing tidak mengikuti layout aplikasi.

Gunakan style editorial modern.

---

# 76. Landing Background

Gunakan:

```text
#FCFCFD
```

Hero tidak memakai gradient besar.

Boleh menggunakan subtle grid/noise sangat ringan jika tersedia, tetapi bukan wajib.

---

# 77. Landing Navbar

Desktop:

```text
CashMind       Produk  Keamanan  Cara Kerja       Masuk [Mulai]
```

Mobile:

```text
CashMind                              Menu
```

Menu membuka full-height sheet.

---

# 78. Landing Hero Baru

Desktop:

```text
Keuangan pribadi,
tanpa kerumitan.

Catat transaksi, kelola rekening,
susun anggaran, dan pahami arus uang
dalam satu workspace pribadi.

[Mulai Gratis]   Lihat Produk

[SVG Lock] Data finansial Anda tetap pribadi.


                           [Actual CashMind Dashboard Preview]
```

---

# 79. Hero Typography

Heading:

```text
56px desktop
38px tablet
34px mobile
```

Max width:

```text
680px
```

---

# 80. Landing Feature Section

Jangan membuat 6 card yang sama.

Gunakan alternating sections.

Contoh:

```text
Transactions
[text]                     [product screenshot]

Accounts
[product screenshot]       [text]

Budget
[text]                     [product screenshot]
```

Pada mobile semua menjadi stacked.

---

# 81. Landing Privacy Section

Gunakan dark section.

```text
background: #0F172A
text: white
```

Ini menjadi visual break.

Content:

```text
Private by design

Admin tidak dapat melihat saldo,
transaksi, rekening, anggaran,
target, ataupun laporan Anda.
```

Gunakan SVG shield.

---

# 82. Authentication Redesign

Desktop tidak menggunakan illustration generik.

Gunakan split:

```text
┌─────────────────────────────┬─────────────────────────┐
│ Product Preview             │ Login                   │
│                             │                         │
│ CashMind                    │ Welcome back            │
│ Financial snapshot          │ Email                   │
│ UI preview                  │ Password                │
│                             │                         │
│                             │ [Masuk]                 │
└─────────────────────────────┴─────────────────────────┘
```

---

# 83. Authentication Mobile

Tidak ada split.

```text
CashMind

Masuk ke akun Anda

Email
Password

[Masuk]

Lupa password

Belum punya akun? Daftar
```

---

# 84. Responsive Strategy

CashMind tidak menggunakan prinsip:

```text
Desktop first
↓
shrink
```

Gunakan:

```text
Mobile layout
Tablet layout
Desktop layout
```

Masing-masing boleh memiliki struktur berbeda.

---

# 85. Breakpoints

```text
xs   < 480
sm   640
md   768
lg   1024
xl   1280
2xl  1536
```

---

# 86. Mobile Touch Target

Minimum:

```text
44 x 44px
```

Preferred primary control:

```text
48px height
```

---

# 87. Mobile Safe Area

Gunakan:

```css
padding-bottom: env(safe-area-inset-bottom);
```

untuk bottom navigation dan sheet.

---

# 88. No Horizontal Scroll Rule

User-facing page tidak boleh horizontal scrolling.

Pengecualian:

```text
intentional horizontal carousel
```

Data table mobile harus diubah menjadi list/card.

---

# 89. Responsive Grid

Desktop:

```text
12-column
```

Tablet:

```text
8-column
```

Mobile:

```text
4-column
```

---

# 90. Desktop Dashboard Grid

```text
Financial Snapshot   12 cols
Cash Flow            12 cols
Recent Activity       7 cols
Budget Health         5 cols
Goals                12 cols
```

---

# 91. Tablet Dashboard Grid

```text
Snapshot       8
Cash Flow      8
Recent         8
Budget         8
Goals          8
```

---

# 92. Mobile Dashboard Grid

Semua:

```text
4 cols
```

Tidak menggunakan side-by-side cards kecil kecuali 2 metric summary.

---

# 93. Empty State Baru

Tidak menggunakan ilustrasi kartun.

Gunakan simple SVG line art.

Contoh:

```text
[SVG receipt]

Belum ada transaksi

Transaksi yang Anda catat akan muncul di sini.

[Tambah Transaksi]
```

---

# 94. Loading State

Gunakan skeleton yang mengikuti layout asli.

Jangan spinner besar di tengah halaman.

---

# 95. Skeleton Color

```text
base: #EAECF0
highlight: #F2F4F7
```

---

# 96. Accessibility

Wajib:

- visible focus;
- keyboard support;
- label;
- aria;
- semantic button;
- sufficient contrast;
- modal focus trap;
- SVG accessible name jika actionable;
- responsive zoom.

---

# 97. Focus Ring Baru

Gunakan teal:

```css
box-shadow: 0 0 0 3px rgba(15,118,110,.14);
```

---

# 98. Animation

Gunakan:

```text
120–180ms
```

untuk hover/dropdown.

Modal/sheet:

```text
180–220ms
```

Tidak menggunakan bounce.

Tidak menggunakan parallax pada aplikasi.

---

# 99. Data Density

CashMind harus seimbang.

Dashboard:

```text
spacious
```

Transaction table:

```text
medium density
```

Admin table:

```text
medium-high density
```

Mobile:

```text
comfortable touch density
```

---

# 100. Blade Component Architecture

```text
resources/views/components/
├── app-shell/
├── navigation/
├── button/
├── form/
├── select/
├── modal/
├── sheet/
├── alert/
├── toast/
├── data-list/
├── table/
├── filter/
├── card/
├── metric/
├── chart/
├── empty-state/
├── skeleton/
└── icons/
```

---

# 101. Separate Modal and Sheet

Jangan menggunakan satu modal component untuk semua.

Gunakan:

```text
<x-modal>
<x-sheet>
<x-confirm-dialog>
```

---

# 102. Sheet Component

Variants:

```text
right
bottom
fullscreen-mobile
```

Transaction form:

```text
right desktop
fullscreen mobile
```

Filter:

```text
popover desktop
bottom sheet mobile
```

---

# 103. DataTable Component

Buat shell sendiri di atas DataTables.

```text
<x-data-table>
    <x-slot:toolbar>
    </x-slot>

    table
</x-data-table>
```

Jangan biarkan default DataTables DOM menentukan keseluruhan tampilan.

---

# 104. Select Component Strategy

Gunakan:

```text
Native select
Select2
Custom searchable sheet
```

Pilih berdasarkan complexity.

Jangan Select2 di semua field.

---

# 105. Responsive Data Strategy

Untuk desktop table dan mobile list, gunakan data source sama.

Jangan duplicate business logic.

Blade dapat render dua presentational views jika perlu.

---

# 106. Toast System

Centralized:

```text
window.CashMindToast.success()
window.CashMindToast.error()
window.CashMindToast.warning()
window.CashMindToast.info()
```

atau Alpine event bus.

---

# 107. Color Token in Tailwind

Buat semantic colors:

```javascript
colors: {
    cm: {
        bg: '#F4F6F8',
        ink: '#101828',
        primary: '#0F172A',
        accent: '#0F766E',
        border: '#E4E7EC',
        muted: '#667085',
        income: '#15803D',
        expense: '#B42318',
        warning: '#B54708',
    }
}
```

---

# 108. Responsive Page Header Component

Desktop:

```text
Title/Description + Actions
```

Mobile:

```text
Title + icon action
Description
```

Action labels boleh disingkat hanya jika icon sangat jelas.

---

# 109. Sidebar/Rail Responsive

```text
>= 1280      compact rail
1024–1279    compact rail
768–1023     hidden + temporary drawer
<768         bottom navigation
```

---

# 110. Admin Navigation Responsive

```text
>=1024       expanded sidebar
<1024        drawer
```

Admin tidak perlu bottom nav.

---

# 111. Search Behavior

Global search tidak wajib.

Transaction search:

```text
search transactions only
```

Admin search:

```text
search users/master data per page
```

Jangan membuat search global jika belum ada use case.

---

# 112. Form Mobile Keyboard

Nominal:

```html
inputmode="numeric"
```

Email:

```html
inputmode="email"
```

Telephone jika ada:

```html
inputmode="tel"
```

---

# 113. Date Picker Mobile

Gunakan native date picker bila experience lebih baik.

Desktop boleh custom date picker.

Jangan memaksa plugin desktop berat pada mobile.

---

# 114. Responsive Modal Rule

```text
Desktop short form       modal
Desktop long form        side sheet
Mobile short confirm     bottom sheet
Mobile long form         fullscreen sheet
```

---

# 115. Alert Copy

Gunakan ringkas.

Success:

```text
Transaksi berhasil disimpan.
```

Error:

```text
Transaksi gagal disimpan. Coba kembali.
```

Warning:

```text
Anggaran tersisa Rp 150.000.
```

---

# 116. Destructive Confirmation

Selalu tulis objek dan konsekuensi.

```text
Hapus rekening BCA?

Rekening tidak dapat dihapus jika masih memiliki transaksi.
```

---

# 117. User Dashboard Mobile Priority

Urutan mobile:

```text
1. Balance
2. Income/Expense
3. Add transaction
4. Cash flow
5. Recent transactions
6. Budget
7. Goals
```

Jangan meletakkan chart sebelum saldo.

---

# 118. Desktop Dashboard Priority

```text
Snapshot
Chart
Recent Activity
Budget
Goals
```

---

# 119. Mobile Transaction Priority

Pada mobile, tombol tambah transaksi selalu mudah dijangkau melalui bottom navigation.

Jangan mewajibkan user scroll ke atas untuk menambah transaksi.

---

# 120. Responsive Filter Rule

Desktop:

```text
Search + Filter button
```

Mobile:

```text
Search
Filter button
```

Filter detailed selalu sheet/panel.

---

# 121. Admin User Detail

Desktop:

Gunakan side panel atau full page.

Mobile:

Full page.

Jangan small modal berisi banyak informasi.

---

# 122. Form Grouping

Gunakan section jika form panjang.

Contoh account:

```text
Informasi Rekening

Nama Rekening
Tipe
Bank

Saldo Awal

Nominal
Tanggal

Pengaturan

Aktif
```

---

# 123. Divider

Gunakan border:

```text
#EAECF0
```

Bukan card nested.

---

# 124. Icon Containers

Jangan selalu beri icon lingkaran background.

Gunakan icon container hanya saat:
- feature;
- status;
- empty state.

Sidebar icon tanpa container.

---

# 125. Chart Legend

Gunakan compact legend.

```text
● Pemasukan
● Pengeluaran
```

Bukan card legend.

---

# 126. Financial Insight

Boleh tampilkan insight:

```text
Pengeluaran turun 12% dibanding bulan lalu.
```

Gunakan text, bukan colorful callout besar.

---

# 127. Responsive Chart

Mobile:

- hide excessive labels;
- reduce ticks;
- use tooltip on touch;
- maintain min height 220px.

---

# 128. Report Table Mobile

Jangan memaksa detail report table pada mobile.

Gunakan:

```text
summary list
download report
transaction drilldown
```

---

# 129. Landing Responsive

Desktop hero 2-column.

Tablet hero stacked.

Mobile:

```text
Headline
Description
CTA
Privacy text
Product preview
```

CTA full width atau 2 buttons stack.

---

# 130. Authentication Responsive

Desktop:

2-column.

<900px:

single-column.

Jangan mempertahankan split pada tablet sempit.

---

# 131. Responsive Typography

Gunakan clamp:

```css
font-size: clamp(2rem, 4vw, 3.5rem);
```

untuk landing heading.

Application page title gunakan fixed responsive classes.

---

# 132. No Decorative Background Rule

Aplikasi internal:

```text
no blobs
no radial gradient
no animated gradient
no large background SVG decoration
```

Landing boleh satu subtle visual texture.

---

# 133. Responsive QA Devices

Minimum testing:

```text
360 x 800
390 x 844
430 x 932
768 x 1024
1024 x 768
1280 x 800
1440 x 900
1920 x 1080
```

---

# 134. Browser QA

Test:

```text
Chrome
Edge
Firefox
Safari mobile if possible
```

---

# 135. Mobile QA Checklist

```text
[ ] Tidak ada horizontal scroll
[ ] Bottom navigation tidak menutupi content
[ ] Touch target minimal 44px
[ ] Form field 48px
[ ] Select mudah digunakan
[ ] Modal panjang menjadi fullscreen sheet
[ ] Table menjadi list
[ ] Filter menjadi bottom sheet
[ ] Currency input numeric keyboard
[ ] Sticky actions tidak menutup input
[ ] Safe area diperhitungkan
[ ] Chart readable
```

---

# 136. Desktop QA Checklist

```text
[ ] Content tidak terlalu lebar
[ ] Rail tidak mengambil ruang berlebihan
[ ] Table readable
[ ] Filter tidak memenuhi layar
[ ] Page header clean
[ ] Hierarchy jelas
[ ] Tidak terlalu banyak cards
[ ] Modal tidak terlalu besar
[ ] Side sheet bekerja
```

---

# 137. Visual QA Checklist

```text
[ ] Font Manrope aktif
[ ] Tidak menggunakan palette lama
[ ] Primary Ink
[ ] Accent Teal
[ ] Tidak ada emoji
[ ] SVG konsisten
[ ] Tidak ada heavy gradient
[ ] Tidak ada glassmorphism
[ ] Tidak ada random pastel
[ ] Radius konsisten
[ ] Shadow minimal
[ ] White space cukup
```

---

# 138. Form QA Checklist

```text
[ ] Mobile field 48px
[ ] Desktop field 44px
[ ] Label jelas
[ ] Error inline
[ ] Currency input nyaman
[ ] Select2 themed
[ ] Searchable select mobile friendly
[ ] Submit loading
[ ] Duplicate submit dicegah
[ ] Keyboard sesuai tipe input
```

---

# 139. DataTable QA Checklist

```text
[ ] Desktop table
[ ] Mobile list
[ ] Toolbar clean
[ ] Filter panel/sheet
[ ] Pagination custom
[ ] Amount right aligned
[ ] Row action ellipsis
[ ] No-result state
[ ] Empty state
[ ] Server-side jika data besar
```

---

# 140. Definition of Done

Satu halaman hanya dianggap selesai jika:

```text
[ ] Memakai layout baru
[ ] Mobile layout bukan hanya desktop stacked
[ ] Responsive seluruh breakpoint
[ ] Tidak ada overflow
[ ] Menggunakan font Manrope
[ ] Menggunakan palette baru
[ ] Menggunakan SVG
[ ] Tidak menggunakan emoji
[ ] Form mengikuti guideline
[ ] Alert mengikuti guideline
[ ] Modal/sheet mengikuti guideline
[ ] DataTable/mobile list mengikuti guideline
[ ] Select2 mengikuti guideline
[ ] Loading state tersedia
[ ] Error state tersedia
[ ] Empty state tersedia
[ ] Accessibility dasar terpenuhi
```

---

# 141. Prioritas Implementasi Redesign

## Phase 1 — Reset Design System

```text
Font
Color tokens
Spacing
Radius
Typography
SVG icon system
```

## Phase 2 — App Shell

```text
Desktop navigation rail
Mobile bottom navigation
Top header
Content shell
Page header
```

## Phase 3 — Core Components

```text
Button
Input
Currency input
Select
Select2
Segmented control
Switch
Modal
Sheet
Toast
Alert
Dropdown
```

## Phase 4 — Data Presentation

```text
Desktop DataTable
Mobile transaction list
Filter popover
Filter bottom sheet
Pagination
Empty state
Skeleton
```

## Phase 5 — User Pages

```text
Dashboard
Transactions
Accounts
Budget
Goals
Reconciliation
Reports
Settings
```

## Phase 6 — Admin

```text
Admin shell
Dashboard
Users
Master Data
Features
Logs
Settings
```

## Phase 7 — Public

```text
Landing
Login
Register
Forgot Password
```

## Phase 8 — QA

```text
Mobile QA
Tablet QA
Desktop QA
Accessibility
Visual consistency
Performance
```

---

# 142. Final Design Direction

CashMind v4 harus terasa berbeda sejak layar pertama.

Perubahan utama:

```text
OLD
Large Sidebar
Many Cards
Pastel / Indigo
Glass / Gradient
Desktop-first
Modal-heavy
Table on mobile
Template-like

↓

NEW
Compact Rail
Strong Information Hierarchy
Ink + Teal
Solid Surfaces
Mobile-first
Sheet-based Interaction
Mobile List
Product-like
```

---

# 143. Final Product Standard

CashMind bukan aplikasi yang sekadar terlihat modern.

CashMind harus:

```text
cepat digunakan,
jelas dibaca,
nyaman di mobile,
rapi di desktop,
konsisten,
dan terasa seperti produk finansial yang matang.
```

Formula akhir:

```text
Mobile-First Structure
+
Compact Navigation
+
Manrope Typography
+
Ink & Teal Palette
+
Solid White Surfaces
+
Minimal Cards
+
Side Sheet Desktop Forms
+
Fullscreen Mobile Forms
+
Desktop Tables
+
Mobile Lists
+
Bottom Navigation
+
SVG-Only Icons
+
Clear Validation
+
Semantic Financial Color
=
CashMind Ledger UI v4
```

Dokumen ini menggantikan guideline visual CashMind sebelumnya dan menjadi acuan utama redesign UI selanjutnya.
