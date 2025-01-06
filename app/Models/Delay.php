<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Delay extends Model
{
    protected $table = 'delay';

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
        return $this->hasMany(DelayDetail::class, 'delay_id', 'id');
    }
}