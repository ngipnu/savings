<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements FilamentUser
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // admin, student, super_admin, wali_kelas, operator
        'student_id',
        'class_name', // Legacy string
        'class_room_id', // New relation
        'phone',
        'address',
        'parent_name',
        'parent_phone',
        'parent_email',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function canAccessPanel(Panel $panel): bool
    {
        if ($panel->getId() === 'admin') {
             return in_array($this->role, ['admin', 'super_admin', 'operator', 'wali_kelas']);
        }
        if ($panel->getId() === 'student') {
            return $this->role === 'student';
        }

        return false;
    }

    public function classRoom()
    {
        return $this->belongsTo(ClassRoom::class);
    }

    public function teachingClass()
    {
        return $this->hasOne(ClassRoom::class, 'teacher_id');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }


}
