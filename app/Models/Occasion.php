<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Occasion extends Model
{
    use HasFactory;

    protected $table = 'occasion';

    protected $fillable = [
        'name',
    ];

    public function occurrenceDetail()
    {
        return $this->hasMany(OccurrenceDetail::class);
    }
}