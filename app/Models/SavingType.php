<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SavingType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'minimum_deposit',
    ];

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
