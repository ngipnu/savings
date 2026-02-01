<?php

namespace App\Livewire\Student;

use Livewire\Component;
use Illuminate\Support\Facades\Hash;

class Profile extends Component
{
    public $name;
    public $email;
    public $phone;
    public $address;
    public $parent_name;
    public $parent_phone;
    
    public $current_password;
    public $new_password;
    public $new_password_confirmation;

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . auth()->id(),
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'parent_name' => 'nullable|string|max:255',
            'parent_phone' => 'nullable|string|max:20',
        ];
    }

    public function mount()
    {
        $user = auth()->user();
        $this->name = $user->name;
        $this->email = $user->email;
        $this->phone = $user->phone;
        $this->address = $user->address;
        $this->parent_name = $user->parent_name;
        $this->parent_phone = $user->parent_phone;
    }

    public function updateProfile()
    {
        $this->validate();

        $user = auth()->user();
        $user->update([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'address' => $this->address,
            'parent_name' => $this->parent_name,
            'parent_phone' => $this->parent_phone,
        ]);

        session()->flash('message', 'Profile berhasil diperbarui!');
    }

    public function updatePassword()
    {
        $this->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $user = auth()->user();

        if (!Hash::check($this->current_password, $user->password)) {
            $this->addError('current_password', 'Password saat ini tidak sesuai.');
            return;
        }

        $user->update([
            'password' => Hash::make($this->new_password),
        ]);

        $this->reset(['current_password', 'new_password', 'new_password_confirmation']);
        session()->flash('password_message', 'Password berhasil diubah!');
    }

    public function render()
    {
        return view('livewire.student.profile')
            ->layout('components.layouts.app', ['title' => 'Profile Saya']);
    }
}
