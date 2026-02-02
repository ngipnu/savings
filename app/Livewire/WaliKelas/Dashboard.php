<?php

namespace App\Livewire\WaliKelas;

use App\Models\User;
use App\Models\Transaction;
use App\Models\ClassRoom;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        $user = Auth::user();
        
        // Get teacher's class
        $teacherClass = $user->teachingClass;
        
        if (!$teacherClass) {
            return view('livewire.wali-kelas.dashboard', [
                'hasClass' => false,
                'user' => $user,
                'notifications' => $this->getNotifications(false, null, 0),
            ])->layout('components.layouts.admin', ['title' => 'Dashboard Wali Kelas']);
        }
        
        // Get students in this class
        $students = User::where('role', 'student')
            ->where('class_room_id', $teacherClass->id)
            ->get();
        
        // Calculate class savings statistics
        $studentIds = $students->pluck('id');
        
        $totalDeposits = Transaction::whereIn('user_id', $studentIds)
            ->where('type', 'deposit')
            ->where('status', 'approved')
            ->sum('amount');
            
        $totalWithdrawals = Transaction::whereIn('user_id', $studentIds)
            ->where('type', 'withdrawal')
            ->where('status', 'approved')
            ->sum('amount');
            
        $classBalance = $totalDeposits - $totalWithdrawals;
        
        // Get top savers
        $topSavers = User::where('role', 'student')
            ->where('class_room_id', $teacherClass->id)
            ->withSum(['transactions as total_savings' => function($query) {
                $query->where('status', 'approved');
            }], 'amount')
            ->orderBy('total_savings', 'desc')
            ->take(5)
            ->get();

        return view('livewire.wali-kelas.dashboard', [
            'hasClass' => true,
            'teacherClass' => $teacherClass,
            'students' => $students,
            'totalStudents' => $students->count(),
            'totalDeposits' => $totalDeposits,
            'totalWithdrawals' => $totalWithdrawals,
            'classBalance' => $classBalance,
            'topSavers' => $topSavers,
            'user' => $user,
            'notifications' => $this->getNotifications(true, $teacherClass, $students->count()),
        ])->layout('components.layouts.admin', ['title' => 'Dashboard Wali Kelas']);
    }

    private function getNotifications($hasClass, $teacherClass, $studentsCount)
    {
        if (!$hasClass) {
            return [
                'unread_count' => 0,
                'students_count' => 0,
                'class_name' => '-',
            ];
        }

        return [
            'unread_count' => 0,
            'students_count' => $studentsCount,
            'class_name' => $teacherClass->name,
        ];
    }

    public function logout()
    {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect('/');
    }
}
