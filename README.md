# TASIA - Tabungan Siswa An Nadzir

![Laravel](https://img.shields.io/badge/Laravel-12.x-red.svg)
![Livewire](https://img.shields.io/badge/Livewire-3.x-pink.svg)
![Tailwind CSS](https://img.shields.io/badge/TailwindCSS-3.x-blue.svg)
![Alpine.js](https://img.shields.io/badge/Alpine.js-3.x-teal.svg)
![PHP](https://img.shields.io/badge/PHP-8.5+-purple.svg)

**TASIA** (Tabungan Siswa An Nadzir) adalah sistem manajemen tabungan siswa berbasis web yang dirancang khusus untuk sekolah. Aplikasi ini memudahkan pengelolaan tabungan siswa dengan fitur lengkap mulai dari pencatatan transaksi, persetujuan, hingga pelaporan yang komprehensif.

## 📋 Daftar Isi

- [Fitur Utama](#-fitur-utama)
- [Tech Stack](#-tech-stack)
- [User Roles](#-user-roles)
- [Screenshots](#-screenshots)
- [Instalasi](#-instalasi)
- [Konfigurasi](#-konfigurasi)
- [Default Credentials](#-default-credentials)
- [Struktur Database](#-struktur-database)
- [Penggunaan](#-penggunaan)
- [Kontribusi](#-kontribusi)
- [Lisensi](#-lisensi)

## ✨ Fitur Utama

### 🎯 Dashboard Interaktif

- **Gradient Background** - Desain modern dengan gradasi warna yang elegan
- **Real-time Statistics** - Statistik langsung update
- **Responsive Design** - Optimal di semua perangkat (desktop, tablet, mobile)
- **Search Functionality** - Pencarian real-time dengan auto-scroll dan highlight
- **Interactive Notifications** - System notifikasi clickable dengan dropdown

### 👤 Multi-Role Management

#### 1️⃣ **Super Admin / Admin**

- Dashboard komprehensif dengan visualisasi data
- Manajemen user (CRUD untuk semua role)
- Manajemen kelas dan produk tabungan
- Approval/reject transaksi pending
- Real-time search untuk transaksi
- Notification bell dengan dropdown
- Laporan lengkap dengan filter dan export
- Multi-currency support (Rupiah)

#### 2️⃣ **Operator**

- Entry transaksi setoran & penarikan
- Monitoring transaksi hari ini
- Notifikasi transaksi pending
- Quick access ke pending approvals
- Dashboard statistik operasional

#### 3️⃣ **Wali Kelas**

- Dashboard kelas dengan statistik siswa
- Monitoring tabungan per siswa
- Top savers leaderboard
- Profil management
- Class balance overview
- Notifikasi sistem (prepared)

#### 4️⃣ **Siswa**

- Dashboard personal dengan saldo tabungan
- Multiple saving accounts (berdasarkan produk)
- Riwayat transaksi lengkap
- Notifikasi transaksi pending pribadi
- Profile management dengan foto
- Mobile-friendly interface

### 💳 Manajemen Transaksi

- **Deposit (Setoran)** - Pencatatan setoran dengan approval workflow
- **Withdrawal (Penarikan)** - Penarikan dengan validasi saldo
- **Transaction Status** - Pending, Approved, Rejected
- **Transaction History** - Riwayat lengkap dengan filter
- **Real-time Balance** - Update saldo otomatis
- **Search & Filter** - Pencarian berdasarkan nama, NIS, produk

### 🔔 Notification System

- **Badge Counter** - Visual badge dengan jumlah notifikasi
- **Dropdown Preview** - Preview 5 notifikasi terbaru
- **Click to Action** - Klik notifikasi langsung ke halaman terkait
- **Real-time Updates** - Update otomatis saat ada transaksi baru
- **Role-based Notifications** - Notifikasi disesuaikan per role

### 📊 Reporting & Analytics

- **Dashboard Statistics** - Overview lengkap dengan cards
- **Chart Visualization** - Grafik cashflow bulanan
- **Top Savers** - Leaderboard penabung terbaik
- **Class Performance** - Performa per kelas
- **Export Data** - Export ke Excel/PDF (future feature)

### 🎨 UI/UX Features

- **Modern Design** - Interface premium dengan Tailwind CSS
- **Smooth Animations** - Alpine.js untuk transisi halus
- **Loading States** - Feedback visual saat loading
- **Empty States** - Pesan informatif saat tidak ada data
- **Hover Effects** - Interactive hover states
- **Mobile Optimized** - Touch-friendly untuk mobile devices
- **Dark Mode Ready** - Prepared untuk dark mode (future)

## 🛠 Tech Stack

### Backend

- **Laravel 12.x** - PHP Framework
- **Livewire 3.x** - Full-stack framework untuk Laravel
- **PHP 8.5+** - Modern PHP with typed properties

### Frontend

- **Tailwind CSS 3.x** - Utility-first CSS framework
- **Alpine.js 3.x** - Lightweight JavaScript framework
- **Blade Templates** - Laravel's templating engine
- **Google Fonts (Outfit)** - Modern typography

### Database

- **SQLite** - Default untuk development
- **MySQL/PostgreSQL** - Production ready

### Additional Tools

- **Vite** - Frontend build tool
- **NPM** - Package manager
- **Composer** - PHP dependency manager

## 👥 User Roles

| Role            | Akses Level | Fitur Utama                     |
| --------------- | ----------- | ------------------------------- |
| **Super Admin** | Full Access | Semua fitur + User Management   |
| **Admin**       | Full Access | Dashboard, Reports, Approvals   |
| **Operator**    | Limited     | Entry Transaksi, View Reports   |
| **Wali Kelas**  | Class Scope | Monitoring Kelas, Class Reports |
| **Siswa**       | Personal    | View Saldo, History Transaksi   |

## 📸 Screenshots

> _Screenshots akan ditambahkan di sini_

```
[Dashboard Admin]  [Transaction Page]  [Student Dashboard]
```

## 🚀 Instalasi

### Prerequisites

- PHP >= 8.5
- Composer
- Node.js & NPM
- SQLite Extension (untuk development)

### Langkah Instalasi

1. **Clone Repository**

```bash
git clone https://github.com/ngipnu/savings.git
cd savings
```

2. **Install Dependencies**

```bash
composer install
npm install
```

3. **Environment Setup**

```bash
cp .env.example .env
php artisan key:generate
```

4. **Database Setup**

```bash
# Untuk SQLite (default)
touch database/database.sqlite

# Jalankan migrasi
php artisan migrate

# Seed data (opsional)
php artisan db:seed
```

5. **Build Assets**

```bash
npm run build
# atau untuk development
npm run dev
```

6. **Run Application**

```bash
php artisan serve
```

Aplikasi akan berjalan di `http://localhost:8000`

## ⚙️ Konfigurasi

### Database Configuration (.env)

**SQLite (Default - Development):**

```env
DB_CONNECTION=sqlite
DB_DATABASE=/absolute/path/to/database.sqlite
```

**MySQL (Production):**

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=tasia
DB_USERNAME=root
DB_PASSWORD=
```

### App Configuration

```env
APP_NAME=TASIA
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

## 📄 Lisensi

This project is open-sourced software licensed under the [MIT license](LICENSE).

## 👨‍💻 Developer

Developed with ❤️ by **An Nadzir Islamic School**

## 📞 Kontak & Support

- **Email**: support@annadzir.sch.id
- **Website**: https://annadzir.sch.id

---

**TASIA** - Simplifying School Savings Management 🎓💰

Made with Laravel, Livewire, and Tailwind CSS
```
