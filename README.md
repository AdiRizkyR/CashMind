# CashMind 💰 - Studio Pencatatan & Pengendalian Keuangan Bulanan

CashMind adalah sistem pencatatan dan pengendalian keuangan berbasis periode bulanan yang dirancang presisi, ringan, dan fokus pada data (*data-first*). Aplikasi ini memberikan kendali mutlak kepada pengguna untuk mengelola arus kas, alokasi anggaran per kategori, pemindahan saldo antar rekening, analisis laporan bulanan, serta pendeteksian selisih saldo finansial.

---

## 🏛️ 5 Menu Utama Sistem

Sistem CashMind V2 dibangun secara terstruktur mengacu pada 5 menu utama utama:

```text
CashMind System Architecture (5 Core Menus)
├── 1. Dashboard Overview        (/app/dashboard)
├── 2. Income & Expenses         (/app/income-expenses)
├── 3. Master Data Referensi     (/app/master-data)
├── 4. Usage Summary Analisis    (/app/usage-summary)
└── 5. Missing Budget Selisih    (/app/missing-budget)
```

### 1. 📊 Dashboard Overview (`/app/dashboard`)
Dashboard berfungsi sebagai ringkasan eksekutif kondisi keuangan pengguna pada bulan dan tahun aktif yang dipilih:
* **Baris KPI Utama**:
  * **Saldo Total**: Akumulasi total saldo saat ini yang bersumber dari pencatatan riil.
  * **Pemasukan Bulan Ini**: Total transaksi pemasukan pada bulan aktif.
  * **Pengeluaran Bulan Ini**: Total transaksi pengeluaran pada bulan aktif.
  * **Sisa Budget & Rasio**: Persentase penggunaan anggaran serta sisa alokasi dana.
* **Breakdown Saldo Media Penyimpanan**: Rincian saldo terpisah untuk **Cash**, **Dompet Digital (E-Wallet)**, dan **Rekening Bank**.
* **Status Budget per Kategori**: Progress bar per kategori pengeluaran lengkap dengan nominal Alokasi, Realisasi, Sisa Budget, dan Badge Status:
  * **Aman** (`<80%`): Penggunaan anggaran masih terkendali.
  * **Waspada** (`80-99%`): Penggunaan anggaran mendekati batas alokasi.
  * **Melebihi Budget** (`≥100%`): Realisasi pengeluaran melampaui batas anggaran.
* **Diagram Visual Arus Kas & Tren**: Donut Chart komposisi pengeluaran per kategori serta Bar Chart perbandingan pemasukan vs pengeluaran.
* **Ringkasan Transfer Dana**: Rekapitulasi aktivitas pemindahan dana internal yang ditampilkan terpisah dari pemasukan/pengeluaran agar nilai laporan tidak terhitung ganda.

---

### 2. 💳 Income & Expenses (`/app/income-expenses`)
Menu ini mengelola seluruh transaksi bulanan dan dibagi menjadi tiga aktivitas utama:

#### A. Tab Income (Pemasukan)
* Pengguna mencatat transaksi pemasukan memilih kategori aktif dari Master Data.
* Mencatat tanggal, nominal rupiah, akun penerima, serta deskripsi transaksi.
* Total pemasukan periode dihitung otomatis dari akumulasi seluruh transaksi *income* bulan aktif.

#### B. Tab Expenses (Pengeluaran & Alokasi Budget)
* Pengguna mengaktifkan kategori pengeluaran dan menetapkan alokasi anggaran menggunakan salah satu dari dua mode:
  * **Mode Nominal**: Total alokasi nominal batas pengeluaran kategori.
  * **Mode Persentase**: Alokasi anggaran dihitung berdasarkan persentase dari basis pemasukan bulan tersebut.
* Setiap transaksi pengeluaran secara otomatis memperbarui realisasi terpakai, sisa alokasi, dan persentase penggunaan kategori.

#### C. Transfer Dana / Pemindahan Saldo
* Digunakan untuk mencatat perpindahan uang antar media penyimpanan milik sendiri (contoh: BCA → Mandiri, BCA → GoPay, Cash → BCA, atau Rekening Utama → Rekening Tabungan).
* **Aturan Ledger**: Transfer internal mengurangi saldo sumber dan menambah saldo tujuan dengan nominal yang sama tanpa mengubah Total Income dan tanpa mengubah Total Expenses pengguna.
* **Biaya Admin Transfer**: Jika terdapat biaya admin (misal Rp6.500 atau Rp2.500), biaya admin secara otomatis dicatat sebagai transaksi Pengeluaran terpisah (*Biaya Admin / Bank Fee*) agar tidak memotong nilai transfer pokok.
* **Aktivitas Menabung**: Nominal pokok setoran tabungan diperlakukan sebagai Transfer Dana ke rekening tabungan.

---

### 3. 🗂️ Master Data Referensi (`/app/master-data`)
Master Data menyimpan seluruh referensi yang dapat digunakan kembali pada periode bulanan:
* **Kategori Income**: Daftar kategori pemasukan (contoh: *Gaji Pokok, Side Job / Freelance, Bonus & THR, Investasi, Saldo Awal*).
* **Kategori Expenses**: Daftar kategori pengeluaran (contoh: *Makanan & Minuman, Transportasi, Tagihan & Utilitas, Belanja Harian, Hiburan, Kesehatan, Biaya Admin*).
* **Dompet Digital (E-Wallet)**: Daftar akun e-wallet pengguna (contoh: *GoPay, OVO, DANA, ShopeePay*).
* **Rekening Bank & Cash**: Daftar rekening bank utama, rekening tabungan, serta kas tunai dompet.
* **Status Aktif/Nonaktif**: Kategori dan akun menggunakan sistem sakelar Aktif/Nonaktif agar histori transaksi periode lampau tidak rusak ketika referensi sudah tidak lagi digunakan.

---

### 4. 📈 Usage Summary (`/app/usage-summary`)
Usage Summary menyajikan laporan analisis keuangan bulanan setelah periode berjalan atau selesai:
* **Ringkasan Evaluasi**: Rekapitulasi pemasukan, pengeluaran, sisa dana, dan tingkat efisiensi penggunaan budget.
* **Poin Positif**: Identifikasi kategori yang paling hemat, alokasi efektif, atau pengeluaran di bawah anggaran.
* **Poin Perhatian**: Peringatan kategori yang mendekati/melebihi budget serta dominasi pengeluaran bulanan.
* **Breakdown Cash vs Transfer**: Tabel pembanding penggunaan media transaksi tunai (Cash) vs nontunai (Bank/QRIS/E-Wallet).
* **Ekspor Laporan**: Fasilitas ekspor data laporan keuangan bulanan ke format CSV / Spreadsheet.

---

### 5. 🔍 Missing Budget (`/app/missing-budget`)
Missing Budget adalah fitur khusus untuk mendeteksi selisih antara saldo yang secara matematis seharusnya tersisa dengan saldo aktual yang dibawa ke periode berikutnya:
* **Rumus Perhitungan**:
  $$\text{Saldo Seharusnya} = \text{Total Pemasukan} - \text{Total Pengeluaran}$$
  $$\text{Selisih / Missing Budget} = \text{Saldo Seharusnya} - \text{Saldo Aktual Pembanding}$$
* **Audit Trail**: Menyimpan tanggal audit, periode pembanding, serta sumber saldo awal aktual agar setiap penyesuaian (*adjustment*) dapat ditelusuri secara transparan.

---

## 🔄 Aturan Periode Bulanan & Konsistensi Data

1. **Konteks Periode Global**: Dropdown Bulan dan Tahun pada topbar menjadi pengontrol konteks utama di seluruh menu. Pengeditan transaksi otomatis terikat pada periode aktif.
2. **Pemicu Otomatis**: Seluruh nominal pada Dashboard dan Usage Summary dihitung otomatis dari transaksi riil, bukan input manual ulang.
3. **Integritas Transfer**: Transfer dana diproses sebagai satu pasangan transaksi tunggal sehingga proses *edit* atau *delete* selalu memperbarui saldo rekening asal dan tujuan secara konsisten.

---

## 🎨 Design System & Antarmuka

CashMind menerapkan panduan visual finansial modern:

| Elemen | Spesifikasi / Rekomendasi | Fungsi & Penggunaan |
| :--- | :--- | :--- |
| **Tipografi Utama** | Inter (Body) & Plus Jakarta Sans (Display) | Keterbacaan teks dan penekanan angka finansial. |
| **Format Angka** | `tabular-nums` | Memastikan posisi digit angka lurus dan mudah dibaca pada tabel. |
| **Warna Primary** | Indigo / Dark Slate (`#0F172A`, `#4F46E5`) | Warna navigasi utama, tombol aksentuasi, dan fokus input. |
| **Warna Success** | Emerald Green (`#059669`, `#10B981`) | Indikator pemasukan dan status budget aman (`<80%`). |
| **Warna Warning** | Amber (`#F59E0B`) | Indikator budget mendekati batas (`80-99%`). |
| **Warna Danger** | Rose Red (`#EF4444`) | Indikator pengeluaran dan status budget melampaui batas (`≥100%`). |
| **Background** | Slate 50 (`#F8FAFC`) | Latar belakang bersih dengan kontras panel putih solid (`#FFFFFF`). |
| **Dropdown Selects** | `select.cm-input` & `select.cm-select` | Memiliki padding kanan luas (`2.75rem`) dan SVG arrow kustom agar teks opsi tidak menimpa ikon panah. |

---

## 🗺️ Pemetaan Route Aplikasi

| No | URI Path | Route Name | Keterangan Modul |
| :-: | :--- | :--- | :--- |
| 1 | `/` | `landing` | Public Landing Page |
| 2 | `/app/dashboard` | `user.dashboard` | **Menu 1**: Dashboard Overview |
| 3 | `/app/income-expenses` | `user.transactions.index` | **Menu 2**: Income & Expenses (Tab Income, Expenses, Transfer) |
| 4 | `/app/master-data` | `user.master-data.index` | **Menu 3**: Master Data (Kategori & Rekening) |
| 5 | `/app/usage-summary` | `user.reports.index` | **Menu 4**: Usage Summary (Analisis & Laporan) |
| 6 | `/app/missing-budget` | `user.reconciliation.index` | **Menu 5**: Missing Budget (Deteksi Selisih Saldo) |
| 7 | `/app/profile` | `user.profile.index` | Profil Finansial & Pengaturan Pengguna |

---

## 📄 Hak Cipta & Lisensi

Dikelola dan dikembangkan oleh **Adi Rizky Ramadhan** © 2026. Hak Cipta Dilindungi.
