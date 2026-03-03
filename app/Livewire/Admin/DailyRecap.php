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
    
    // Modal properties
    public $showInputModal = false;
    public $inputUserId;
    public $inputUserName;
    public $inputDate;
    public $inputAmount;
    public $inputType = 'deposit';
    public $inputDescription;
    public $savingTypeId;
    public $savingTypes = [];
    
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
        $this->savingTypes = \App\Models\SavingType::all();
        if ($this->savingTypes->isNotEmpty()) {
            $this->savingTypeId = $this->savingTypes->first()->id;
        }
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

    public function openInputModal($userId, $userName, $date)
    {
        $this->inputUserId = $userId;
        $this->inputUserName = $userName;
        $this->inputDate = $date;
        $this->inputAmount = '';
        $this->inputType = 'deposit';
        $this->inputDescription = '';
        $this->savingTypeId = $this->savingTypes->first()->id ?? null;
        $this->showInputModal = true;
    }

    public function closeInputModal()
    {
        $this->showInputModal = false;
        $this->resetErrorBag();
        $this->reset(['inputUserId', 'inputUserName', 'inputDate', 'inputAmount', 'inputType', 'inputDescription']);
    }

    public function saveTransaction()
    {
        $this->validate([
            'inputUserId' => 'required|exists:users,id',
            'savingTypeId' => 'required|exists:saving_types,id',
            'inputType' => 'required|in:deposit,withdrawal',
            'inputAmount' => 'required|numeric|min:1',
            'inputDate' => 'required|date',
            'inputDescription' => 'nullable|string'
        ], [
            'inputAmount.required' => 'Jumlah wajib diisi',
            'inputAmount.numeric' => 'Jumlah harus berupa angka',
            'inputAmount.min' => 'Jumlah minimal 1',
            'savingTypeId.required' => 'Produk tabungan wajib dipilih'
        ]);

        $status = in_array(auth()->user()->role, ['operator', 'wali_kelas']) ? 'pending' : 'approved';

        Transaction::create([
            'user_id' => $this->inputUserId,
            'saving_type_id' => $this->savingTypeId,
            'type' => $this->inputType,
            'amount' => $this->inputAmount,
            'date' => $this->inputDate,
            'description' => $this->inputDescription,
            'status' => $status,
        ]);

        $this->closeInputModal();
        session()->flash('message', 'Transaksi berhasil ditambahkan pada tanggal ' . \Carbon\Carbon::parse($this->inputDate)->format('d M Y') . '!');
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
                    'id' => $user->id,
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
