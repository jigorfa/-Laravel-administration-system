<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Epi extends Model
{
    protected $table = 'epi';

    protected $primaryKey = 'id';
    
    protected $keyType = 'int';

    public $incrementing = true;

    use HasFactory;

    protected $fillable = [
        'employee_code',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_code', 'code');
    }

    public function detail()
    {
        return $this->hasMany(EpiDetail::class, 'epi_id', 'id');
    }
}