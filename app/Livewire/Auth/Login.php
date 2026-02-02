<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Component;

class Login extends Component
{
    #[Rule('required')]
    public $login = '';

    #[Rule('required')]
    public $password = '';

    public function login()
    {
        $this->validate([
            'login' => 'required',
            'password' => 'required',
        ]);

        // Determine if login is email or student_id
        $fieldType = filter_var($this->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'student_id';

        if (Auth::attempt([$fieldType => $this->login, 'password' => $this->password])) {
            session()->regenerate();

            $user = Auth::user();
            $role = $user->role;
            
            // Check if using default password
            if ($this->password === '12345678') {
                session()->flash('force_password_change', true);
                if ($role === 'student') {
                    return redirect()->route('student.profile');
                }
            }

            // Redirect based on role
            if ($role === 'super_admin' || $role === 'admin') {
                return redirect()->route('admin.dashboard');
            } elseif ($role === 'operator') {
                return redirect()->route('operator.dashboard');
            } elseif ($role === 'wali_kelas') {
                return redirect()->route('wali-kelas.dashboard');
            }

            // Redirect students to student dashboard
            return redirect()->route('student.dashboard');
        }

        $this->addError('login', 'Email/NIS atau password salah.');
    }

    #[Layout('components.layouts.app')] 
    public function render()
    {
        return view('livewire.auth.login');
    }
}
