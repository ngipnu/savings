<?php

namespace App\Livewire\Admin;

use App\Models\ClassRoom;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class ClassManagement extends Component
{
    use WithPagination;

    public $showModal = false;
    public $editMode = false;
    public $classId;
    public $name;
    public $teacher_id;
    public $search = '';

    protected $rules = [
        'name' => 'required|string|max:255',
        'teacher_id' => 'nullable|exists:users,id',
    ];

    public function render()
    {
        $classes = ClassRoom::with('teacher', 'students')
            ->when($this->search, function($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->paginate(10);

        $teachers = User::where('role', 'wali_kelas')->get();

        return view('livewire.admin.class-management', [
            'classes' => $classes,
            'teachers' => $teachers,
        ])->layout('components.layouts.admin', ['title' => 'Manajemen Kelas']);
    }

    public function openModal()
    {
        $this->resetForm();
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->editMode = false;
        $this->classId = null;
        $this->name = '';
        $this->teacher_id = null;
        $this->resetErrorBag();
    }

    public function save()
    {
        $this->validate();

        if ($this->editMode) {
            $class = ClassRoom::findOrFail($this->classId);
            $class->update([
                'name' => $this->name,
                'teacher_id' => $this->teacher_id,
            ]);
            session()->flash('message', 'Kelas berhasil diperbarui!');
        } else {
            ClassRoom::create([
                'name' => $this->name,
                'teacher_id' => $this->teacher_id,
            ]);
            session()->flash('message', 'Kelas berhasil ditambahkan!');
        }

        $this->closeModal();
    }

    public function edit($id)
    {
        $class = ClassRoom::findOrFail($id);
        $this->editMode = true;
        $this->classId = $class->id;
        $this->name = $class->name;
        $this->teacher_id = $class->teacher_id;
        $this->showModal = true;
    }

    public function delete($id)
    {
        ClassRoom::findOrFail($id)->delete();
        session()->flash('message', 'Kelas berhasil dihapus!');
    }

    public function logout()
    {
        auth()->logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect('/');
    }
}
