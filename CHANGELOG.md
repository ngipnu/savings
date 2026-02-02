# Changelog

All notable changes to TASIA will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

### Planned

- Export data to Excel/PDF
- Email notifications
- SMS notifications
- Dark mode support
- Mobile app API
- Bulk import students from Excel
- Advanced reporting with interactive charts
- Parent portal
- Payment gateway integration
- Multi-language support

## [1.0.0] - 2026-02-02

### Added

- Initial release of TASIA
- Multi-role authentication system (Admin, Operator, Wali Kelas, Siswa)
- Dashboard for all user roles with modern gradient design
- Transaction management (Deposit & Withdrawal)
- Transaction approval workflow (Pending → Approved/Rejected)
- Real-time balance calculation
- Interactive notification system with dropdown
- Search functionality with auto-scroll and highlight
- Student profile management with photo upload
- Wali Kelas profile management
- Class management (ClassRooms)
- Saving products management (SavingTypes)
- User management (CRUD for all roles)
- Transaction history with filters
- Top savers leaderboard
- Class statistics and monitoring
- Responsive design for mobile and desktop
- Smooth animations with Alpine.js
- Modern UI with Tailwind CSS
- Real-time statistics on dashboards

### Features by Role

#### Admin Dashboard

- Comprehensive dashboard with statistics cards
- Cashflow visualization
- Pending transactions sidebar
- Transaction search with real-time filtering
- Notification bell with clickable dropdown
- User management (Create, Read, Update, Delete)
- Class management
- Saving products management
- Transaction approval/rejection
- Complete transaction history

#### Operator Dashboard

- Today's transaction count
- Pending transactions overview
- Income and expense summary
- Recent transactions list
- Notification system
- Transaction entry interface

#### Wali Kelas Dashboard

- Class overview with student count
- Class total balance
- Total deposits and withdrawals
- Top 5 savers in class
- Student list with individual balances
- Profile management
- Notification bell (prepared for future)

#### Student Dashboard

- Personal savings overview
- Multiple saving accounts (by product type)
- Recent transaction history
- Profile management with photo
- Notification system for pending transactions
- Class and teacher information
- Mobile-optimized interface

### Technical

- Laravel 12.x framework
- Livewire 3.x for reactive components
- Tailwind CSS 3.x for styling
- Alpine.js 3.x for interactions
- PHP 8.5+ with modern features
- SQLite database (development)
- MySQL/PostgreSQL support (production)
- Vite for asset bundling
- Blade templating engine
- PSR-12 coding standards

### Security

- Secure authentication with bcrypt password hashing
- CSRF protection
- Role-based access control
- Input validation and sanitization
- Secure file upload handling

## [0.1.0] - Development Phase

### Added

- Project initialization
- Basic authentication system
- Database schema design
- Initial models and migrations
- Basic CRUD operations

---

## Version Format

- MAJOR version for incompatible API changes
- MINOR version for new functionality in a backwards compatible manner
- PATCH version for backwards compatible bug fixes

## Links

- [Repository](https://github.com/yourusername/tasia)
- [Issues](https://github.com/yourusername/tasia/issues)
- [Pull Requests](https://github.com/yourusername/tasia/pulls)
