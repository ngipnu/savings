<?php

namespace App\Livewire\Admin;

use App\Models\User;
use App\Models\ClassRoom;
use App\Imports\StudentsImport;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

class StudentManagement extends Component
{
    use WithPagination, WithFileUploads;

    public $showModal = false;
    public $showImportModal = false;
    public $editMode = false;
    public $studentId;
    public $name;
    public $email;
    public $password;
    public $student_id;
    public $class_room_id;
    public $phone;
    public $address;
    public $parent_name;
    public $parent_phone;
    public $parent_email;
    public $search = '';
    public $filterClass = '';
    public $importFile;

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', \Illuminate\Validation\Rule::unique('users', 'email')->ignore($this->studentId)],
            'password' => $this->editMode ? 'nullable|min:6' : 'required|min:6',
            'student_id' => ['required', 'string', \Illuminate\Validation\Rule::unique('users', 'student_id')->ignore($this->studentId)],
            'class_room_id' => 'required|exists:class_rooms,id',
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
            'parent_name' => 'nullable|string',
            'parent_phone' => 'nullable|string',
            'parent_email' => 'nullable|email',
        ];
    }

    public function render()
    {
        $user = auth()->user();
        
        $students = User::where('role', 'student')
            ->with('classRoom')
            ->when($this->search, function($query) {
                $query->where(function($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('student_id', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->filterClass, function($query) {
                $query->where('class_room_id', $this->filterClass);
            })
            ->when($user->role === 'wali_kelas', function($query) use ($user) {
                $query->where('class_room_id', $user->teachingClass->id ?? 0);
            })
            ->paginate(10);

        if ($user->role === 'wali_kelas') {
            $classes = ClassRoom::where('id', $user->teachingClass->id ?? 0)->get();
        } else {
            $classes = ClassRoom::all();
        }

        return view('livewire.admin.student-management', [
            'students' => $students,
            'classes' => $classes,
        ])->layout('components.layouts.admin', ['title' => 'Manajemen Siswa']);
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

    public function openImportModal()
    {
        $this->showImportModal = true;
        $this->importFile = null;
    }

    public function closeImportModal()
    {
        $this->showImportModal = false;
        $this->importFile = null;
    }

    public function resetForm()
    {
        $this->editMode = false;
        $this->studentId = null;
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->student_id = '';
        $this->phone = '';
        $this->address = '';
        $this->parent_name = '';
        $this->parent_phone = '';
        $this->parent_email = '';
        
        $user = auth()->user();
        if ($user->role === 'wali_kelas') {
            $this->class_room_id = $user->teachingClass->id ?? null;
        } else {
            $this->class_room_id = null;
        }

        $this->resetErrorBag();
    }

    public function save()
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'student_id' => $this->student_id,
            'class_room_id' => $this->class_room_id,
            'phone' => $this->phone,
            'address' => $this->address,
            'parent_name' => $this->parent_name,
            'parent_phone' => $this->parent_phone,
            'parent_email' => $this->parent_email,
            'role' => 'student',
        ];

        if ($this->password) {
            $data['password'] = Hash::make($this->password);
        }

        if ($this->editMode) {
            $student = User::findOrFail($this->studentId);
            $student->update($data);
            session()->flash('message', 'Data siswa berhasil diperbarui!');
        } else {
            User::create($data);
            session()->flash('message', 'Siswa berhasil ditambahkan!');
        }

        $this->closeModal();
    }

    public function import()
    {
        $this->validate([
            'importFile' => 'required|mimes:xlsx,xls,csv|max:2048',
        ]);

        try {
            Excel::import(new StudentsImport, $this->importFile->getRealPath());
            session()->flash('message', 'Data siswa berhasil diimport!');
            $this->closeImportModal();
        } catch (\Exception $e) {
            session()->flash('error', 'Gagal import data: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $student = User::findOrFail($id);
        $this->editMode = true;
        $this->studentId = $student->id;
        $this->name = $student->name;
        $this->email = $student->email;
        $this->student_id = $student->student_id;
        $this->class_room_id = $student->class_room_id;
        $this->phone = $student->phone;
        $this->address = $student->address;
        $this->parent_name = $student->parent_name;
        $this->parent_phone = $student->parent_phone;
        $this->parent_email = $student->parent_email;
        $this->showModal = true;
    }

    public function delete($id)
    {
        User::findOrFail($id)->delete();
        session()->flash('message', 'Siswa berhasil dihapus!');
    }

    public function logout()
    {
        auth()->logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect('/');
    }
}
