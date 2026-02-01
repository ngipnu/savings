# Aplikasi Tabungan Siswa

Built with Laravel 11 + FilamentPHP v3.

## Credentials

- **Admin**: `admin@admin.com` / `password`
- **Student**: `student@student.com` / `password`

## Panels

- **Admin Panel**: `/admin`
    - Manage Students (Users)
    - Manage Saving Types (Jenis Tabungan)
    - Manage Transactions (Deposit/Withdrawal)
- **Student Panel**: `/student`
    - View Transaction History
    - Check Total Balance (Dashboard)

## Features

- **Powerful Admin Panel**: Built with Filament resources, supports filtering, searching, and exports.
- **Mobile-Friendly**: Fully responsive interface for students.
- **Rich Aesthetics**: Modern UI with TailwindCSS (via Filament).

## Setup (Already Completed)

1. `composer install`
2. `php artisan migrate --seed`
3. `php artisan serve`
