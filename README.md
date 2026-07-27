# CashMind 💰 - Financial Management & Cash Reconciliation System

CashMind adalah aplikasi web pengelolaan dan pencatatan keuangan modern berbasis **Laravel 12**, **Tailwind CSS**, dan **Alpine.js**. Didesain khusus untuk pencatatan kas presisi, pengalokasian anggaran mandiri, dan rekonsiliasi selisih dana (Missing Cash Tracker) berdasarkan struktur data *Catatan Keuangan 2026*.

---

## 🌟 Fitur Utama Aplikasi

### 👤 Role USER (Pencatatan Keuangan Mandiri)
- 📊 **Dashboard Rekap & Diagram Visual**: Ringkasan Pemasukan, Pengeluaran, Saldo Seharusnya, dan Selisih (Missing Cash) dilengkapi **Chart.js Diagram Batang (Income vs Expense)** dan **Chart.js Diagram Donut (Distribusi Budget Kategori)**.
- 📥 **Pencatatan Pemasukan (Income Tracker)**: Catat tanggal penerimaan, nominal, dan sumber pendapatan (Gaji Pokok, Side Job, Penarikan Tabungan, Bonus/THR) dengan **Kategori Pemasukan Mandiri**.
- 📤 **Pencatatan Pengeluaran (Expense Tracker)**: Catat transaksi pengeluaran harian (Cash & Transfer Bank/E-Wallet) dengan tanggal, uraian, dan rincian transaksi.
- 🏷️ **Pengaturan Kategori & Persentase Budget**: Kelola kategori pemasukan & pengeluaran kustom serta atur persentase target spending dengan kalkulator nominal (Rp) otomatis.
- 📄 **Cetak Laporan PDF / Print**: Ekspor Laporan Pendapatan & Pengeluaran Bulanan dan Rekapitulasi 12 Bulan (Tahun 2026) dengan layout resmi dan kolom tanda tangan.
- ✏️ **Full Edit Modals**: Dilengkapi modal ubah (edit) data untuk Pemasukan, Pengeluaran, dan Kategori.

### 👑 Role ADMIN (Trafik & Analytics Platform)
- 📈 **Trafik & Analytics System**: Monitoring grafik statistik aktivitas harian user, puncak trafik harian, total transaksi system, dan volume arus kas terproses (Rp 4.28 Milyar).
- 👥 **Direktori & Detail User Viewer**: Monitoring seluruh akun pengguna terdaftar dengan **Modal Detail User** untuk menginspeksi ringkasan income, expense, missing cash, serta manajemen status akun (Active/Suspended) & role.
- 📜 **Aktivitas & Audit Log Realtime**: Log audit trail realtime mencatat setiap aksi transaksi & pengaksesan pengguna beserta IP Address.

---

## 🛠️ Teknologi & Fitur Teknis

- **Framework**: Laravel 12 (PHP 8.2+)
- **Styling**: Tailwind CSS (CDN - tanpa perlu running Vite/npm)
- **Reaktivitas**: Alpine.js & Chart.js
- **Database**: MySQL (`cashmind`)
- **Desain UI**: Dark Theme Sleek UI (`#0b0f19` & `#0f172a`) dengan **Sidebar Left Navigation Layout**

---

## 🔐 Akun Demo (Seeder)

Aplikasi telah dilengkapi seeder akun bawaan untuk pengujian:

| Role | Email | Password | Hak Akses |
|---|---|---|---|
| **Super Admin** | `admin@cashmind.id` | `password` | Monitoring Trafik, Detail Users, Audit Logs |
| **Personal User** | `user@cashmind.id` | `password` | Pencatatan Income, Expense, Kategori Mandiri, Laporan |

---

## 🚀 Cara Menjalankan Aplikasi

1. **Clone repositori**:
   ```bash
   git clone https://github.com/AdiRizkyR/CashMind.git
   cd CashMind
   ```

2. **Install dependensi Composer**:
   ```bash
   composer install
   ```

3. **Konfigurasi Lingkungan (`.env`)**:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   Pastikan konfigurasi database di `.env` sudah sesuai (misal: `DB_DATABASE=cashmind`).

4. **Jalankan Migrasi & Seeder Database**:
   ```bash
   php artisan migrate:fresh --seed
   ```

5. **Jalankan Server Lokal**:
   ```bash
   php artisan serve
   ```
   Buka browser dan akses `http://127.0.0.1:8000`.

---

## 📄 Lisensi
[MIT License](LICENSE) - Dibuat oleh **Aditya Personal / CashMind Team 2026**.
