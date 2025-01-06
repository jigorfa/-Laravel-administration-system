<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attest extends Model
{
    protected $table = 'attest';

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
        return $this->hasMany(AttestDetail::class, 'attest_id', 'id');
    }
}