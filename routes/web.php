<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Auth\Login;
use App\Livewire\Student\Dashboard as StudentDashboard;
use App\Livewire\Student\Profile as StudentProfile;
use App\Livewire\Admin\Dashboard as AdminDashboard;
use App\Livewire\Admin\ClassManagement;
use App\Livewire\Admin\StudentManagement;
use App\Livewire\Admin\ManagerAccounts;
use App\Livewire\Admin\TransactionManagement;
use App\Livewire\Admin\ProductManagement;
use App\Livewire\Admin\Reports;
use App\Livewire\Admin\AcademicYearManagement;
use App\Livewire\Operator\Dashboard as OperatorDashboard;
use App\Livewire\WaliKelas\Dashboard as WaliKelasDashboard;
use App\Livewire\WaliKelas\Profile as WaliKelasProfile;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/login', Login::class)->name('login');

Route::middleware(['auth'])->group(function () {
    // Student Routes
    Route::get('/student/dashboard', StudentDashboard::class)->name('student.dashboard');
    Route::get('/student/profile', StudentProfile::class)->name('student.profile');
    
    // Admin Routes
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', AdminDashboard::class)->name('dashboard');
        Route::get('/classes', ClassManagement::class)->name('classes');
        Route::get('/students', StudentManagement::class)->name('students');
        Route::get('/managers', ManagerAccounts::class)->name('managers');
        Route::get('/transactions', TransactionManagement::class)->name('transactions');
        Route::get('/transactions/{id}/receipt', \App\Livewire\Admin\TransactionReceipt::class)->name('transaction.receipt');
        Route::get('/classes/{id}/recap', \App\Livewire\Admin\ClassRecap::class)->name('class.recap');
        Route::get('/products', ProductManagement::class)->name('products');
        Route::get('/reports', Reports::class)->name('reports');
        Route::get('/academic-years', AcademicYearManagement::class)->name('academic-years');
        Route::get('/students/{id}/print-account', \App\Livewire\Admin\AccountPrint::class)->name('student.print-account');
        Route::get('/students/bulk-print-account/{ids}', \App\Livewire\Admin\BulkAccountPrint::class)->name('student.bulk-print-account');
        
        // Template Routes
        Route::get('/templates/student', [\App\Http\Controllers\Admin\TemplateController::class, 'downloadStudentTemplate'])->name('template.student');
        Route::get('/templates/transaction', [\App\Http\Controllers\Admin\TemplateController::class, 'downloadTransactionTemplate'])->name('template.transaction');
    });

    // Operator Routes
    Route::prefix('operator')->name('operator.')->group(function () {
        Route::get('/dashboard', OperatorDashboard::class)->name('dashboard');
    });

    // Wali Kelas Routes
    Route::prefix('wali-kelas')->name('wali-kelas.')->group(function () {
        Route::get('/dashboard', WaliKelasDashboard::class)->name('dashboard');
        Route::get('/profile', WaliKelasProfile::class)->name('profile');
    });

    Route::post('/logout', function () {
        Illuminate\Support\Facades\Auth::logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect('/');
    })->name('logout');
});
