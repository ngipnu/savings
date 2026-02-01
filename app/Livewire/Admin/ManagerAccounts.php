<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Hash;

class ManagerAccounts extends Component
{
    use WithPagination;

    public $showModal = false;
    public $editMode = false;
    public $managerId;
    public $name;
    public $email;
    public $password;
    public $role;
    public $phone;
    public $search = '';
    public $filterRole = '';

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . ($this->managerId ?? 'NULL'),
            'password' => $this->editMode ? 'nullable|min:6' : 'required|min:6',
            'role' => 'required|in:super_admin,wali_kelas,operator',
            'phone' => 'nullable|string',
        ];
    }

    public function render()
    {
        $managers = User::whereIn('role', ['super_admin', 'wali_kelas', 'operator'])
            ->when($this->search, function($query) {
                $query->where(function($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->filterRole, function($query) {
                $query->where('role', $this->filterRole);
            })
            ->paginate(10);

        return view('livewire.admin.manager-accounts', [
            'managers' => $managers,
        ])->layout('components.layouts.admin', ['title' => 'Akun Pengelola']);
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
        $this->managerId = null;
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->role = '';
        $this->phone = '';
        $this->resetErrorBag();
    }

    public function save()
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role,
            'phone' => $this->phone,
        ];

        if ($this->password) {
            $data['password'] = Hash::make($this->password);
        }

        if ($this->editMode) {
            $manager = User::findOrFail($this->managerId);
            $manager->update($data);
            session()->flash('message', 'Akun pengelola berhasil diperbarui!');
        } else {
            User::create($data);
            session()->flash('message', 'Akun pengelola berhasil ditambahkan!');
        }

        $this->closeModal();
    }

    public function edit($id)
    {
        $manager = User::findOrFail($id);
        $this->editMode = true;
        $this->managerId = $manager->id;
        $this->name = $manager->name;
        $this->email = $manager->email;
        $this->role = $manager->role;
        $this->phone = $manager->phone;
        $this->showModal = true;
    }

    public function delete($id)
    {
        User::findOrFail($id)->delete();
        session()->flash('message', 'Akun pengelola berhasil dihapus!');
    }

    public function logout()
    {
        auth()->logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect('/');
    }
}
