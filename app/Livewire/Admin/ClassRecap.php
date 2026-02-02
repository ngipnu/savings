<?php

namespace App\Livewire\Admin;

use Livewire\Component;

class ClassRecap extends Component
{
    public $classRoom;
    public $students;

    public function mount($id)
    {
        $user = auth()->user();
        
        // Restriction for Wali Kelas
        if ($user->role === 'wali_kelas' && $user->teachingClass->id != $id) {
            abort(403, 'Unauthorized access to this class recap.');
        }

        $this->classRoom = \App\Models\ClassRoom::with('teacher')->findOrFail($id);

        $this->students = \App\Models\User::where('class_room_id', $id)
            ->where('role', 'student')
            ->withSum(['transactions as total_deposit' => function ($query) {
                $query->where('type', 'deposit')->where('status', 'approved');
            }], 'amount')
            ->withSum(['transactions as total_withdrawal' => function ($query) {
                $query->where('type', 'withdrawal')->where('status', 'approved');
            }], 'amount')
            ->orderBy('name')
            ->get();
    }

    public function render()
    {
        return view('livewire.admin.class-recap')
            ->layout('components.layouts.app', ['title' => 'Rekapan Kelas ' . $this->classRoom->name]);
    }
}
