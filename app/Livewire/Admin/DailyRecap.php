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
    public $status = 'all'; // all, approved, pending
    public $classes;
    
    public $sortField = 'name'; // name, last_activity
    public $sortDirection = 'asc';
    public $dateDirection = 'asc';

    public function mount()
    {
        $user = auth()->user();
        
        // Scoping for Wali Kelas
        if ($user->role === 'wali_kelas') {
            $this->classId = $user->teachingClass?->id;
        } else {
            $this->classId = request('class_id');
        }

        $this->startDate = now()->subDays(6)->format('Y-m-d');
        $this->endDate = now()->format('Y-m-d');
        $this->classes = ClassRoom::all();
    }

    public function sort($field)
    {
        if ($field === 'date') {
            $this->dateDirection = $this->dateDirection === 'asc' ? 'desc' : 'asc';
        } else {
            if ($this->sortField === $field) {
                $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
            } else {
                $this->sortField = $field;
                $this->sortDirection = 'asc';
            }
        }
    }

    public function setSort($value)
    {
        $parts = explode('-', $value);
        if (count($parts) === 2) {
            $this->sortField = $parts[0];
            $this->sortDirection = $parts[1];
        }
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

        if ($this->dateDirection === 'desc') {
            $dates = array_reverse($dates);
        }

        $transactions = Transaction::with(['user.classRoom'])
            ->whereBetween('date', [$start, $end])
            ->when($this->status !== 'all', function($query) {
                $query->where('status', $this->status);
            })
            ->when($this->status === 'all', function($query) {
                $query->whereIn('status', ['approved', 'pending']);
            })
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
                $lastActivity = $studentTransactions->max('created_at');
                
                foreach ($dates as $date) {
                    $dayTrans = $studentTransactions->filter(function($t) use ($date) {
                        return $t->date->format('Y-m-d') === $date;
                    });
                    $mutation = $dayTrans->where('type', 'deposit')->sum('amount') - $dayTrans->where('type', 'withdrawal')->sum('amount');
                    $dailyData[$date] = $mutation;
                }
                return [
                    'name' => $user->name,
                    'student_id' => $user->student_id,
                    'history' => $dailyData,
                    'last_activity' => $lastActivity,
                ];
            });

            // Sorting Students within Class
            if ($this->sortField === 'name') {
                $students = $this->sortDirection === 'asc' 
                    ? $students->sortBy('name', SORT_NATURAL|SORT_FLAG_CASE) 
                    : $students->sortByDesc('name', SORT_NATURAL|SORT_FLAG_CASE);
            } elseif ($this->sortField === 'last_activity') {
                $students = $this->sortDirection === 'asc' 
                    ? $students->sortBy('last_activity') 
                    : $students->sortByDesc('last_activity');
            }

            return [
                'name' => $className,
                'students' => $students,
                'dates' => $dates
            ];
        });

        // Optional: Sort Classes by Name if needed, currently implicit by groupBy string key sort order? 
        // groupBy returns keys in order of appearance usually. Let's explicit sort classes by name.
        $grouped = $grouped->sortKeys(SORT_NATURAL|SORT_FLAG_CASE);

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
