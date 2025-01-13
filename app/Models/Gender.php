<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gender extends Model
{
    use HasFactory;

    protected $table = 'gender';

    protected $fillable = [
        'name',
    ];

    public function employee()
    {
        return $this->hasMany(Employee::class);
    }
}
