<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Component;

class Login extends Component
{
    #[Rule('required', as: 'Email / NIS')]
    public $login = '';

    #[Rule('required', as: 'Password')]
    public $password = '';

    public function login()
    {
        $this->validate();

        // Determine if login is email or student_id (NIS)
        $fieldType = filter_var($this->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'student_id';

        if (Auth::attempt([$fieldType => $this->login, 'password' => $this->password])) {
            session()->regenerate();

            $user = Auth::user();
            
            // Check if using default password
            if ($this->password === '12345678') {
                session()->flash('force_password_change', true);
                if ($user->role === 'student') {
                    return redirect()->route('student.profile');
                }
            }

            // Redirect based on role
            return match ($user->role) {
                'super_admin', 'admin' => redirect()->route('admin.dashboard'),
                'operator' => redirect()->route('operator.dashboard'),
                'wali_kelas' => redirect()->route('wali-kelas.dashboard'),
                default => redirect()->route('student.dashboard'),
            };
        }

        $this->addError('login', 'Email/NIS atau password yang Anda masukkan salah.');
    }

    #[Layout('components.layouts.app')] 
    public function render()
    {
        return view('livewire.auth.login');
    }
}
