<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CivilState extends Model
{
    use HasFactory;

    protected $table = 'civil_state';

    protected $fillable = [
        'name',
    ];

    public function employee()
    {
        return $this->hasMany(Employee::class);
    }
}
