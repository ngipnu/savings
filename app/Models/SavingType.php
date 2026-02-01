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
        'min_amount',
    ];

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
