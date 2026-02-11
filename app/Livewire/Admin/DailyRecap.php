<?php

namespace App\Livewire\Admin;

use App\Models\Transaction;
use App\Models\ClassRoom;
use Livewire\Component;
use Livewire\Attributes\Computed;

class DailyRecap extends Component
{
    public $startDate;
    public $endDate;
    public $classId;
    public $classes;

    public function mount()
    {
        $this->startDate = now()->subDays(6)->format('Y-m-d');
        $this->endDate = now()->format('Y-m-d');
        $this->classId = request('class_id');
        $this->classes = ClassRoom::all();
    }

    #[Computed]
    public function recapData()
    {
        $start = $this->startDate;
        $end = $this->endDate;
        
        $dates = [];
        $current = \Carbon\Carbon::parse($start);
        $last = \Carbon\Carbon::parse($end);
        while ($current <= $last) {
            $dates[] = $current->format('Y-m-d');
            $current->addDay();
        }

        $transactions = Transaction::with(['user.classRoom'])
            ->whereBetween('date', [$start, $end])
            ->where('status', 'approved')
            ->when($this->classId, function($query) {
                $query->whereHas('user', function($q) {
                    $q->where('class_room_id', $this->classId);
                });
            })
            ->get();

        $grouped = $transactions->groupBy(function($t) {
            return $t->user->classRoom ? $t->user->classRoom->name : 'Tanpa Kelas';
        })->map(function($group, $className) use ($dates) {
            $students = $group->groupBy('user_id')->map(function($studentTransactions) use ($dates) {
                $user = $studentTransactions->first()->user;
                $dailyData = [];
                foreach ($dates as $date) {
                    $dayTrans = $studentTransactions->where('date', $date);
                    $mutation = $dayTrans->where('type', 'deposit')->sum('amount') - $dayTrans->where('type', 'withdrawal')->sum('amount');
                    $dailyData[$date] = $mutation;
                }
                return [
                    'name' => $user->name,
                    'student_id' => $user->student_id,
                    'history' => $dailyData,
                ];
            });

            return [
                'name' => $className,
                'students' => $students,
                'dates' => $dates
            ];
        });

        return [
            'dates' => $dates,
            'classes' => $grouped
        ];
    }

    public function render()
    {
        return view('livewire.admin.daily-recap', [
            'recap' => $this->recapData
        ])->layout('components.layouts.admin', ['title' => 'Neraca Mutasi Harian']);
    }
}
