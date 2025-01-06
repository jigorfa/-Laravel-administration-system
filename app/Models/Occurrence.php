<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Occurrence extends Model
{
    use HasFactory;

    protected $table = 'occurrence';
    
    protected $primaryKey = 'id';
    
    protected $keyType = 'int';

    public $incrementing = true;
    
    protected $fillable = [
        'employee_code',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_code', 'code');
    }

    public function detail()
    {
        return $this->hasMany(OccurrenceDetail::class, 'occurrence_id', 'id');
    }
}


