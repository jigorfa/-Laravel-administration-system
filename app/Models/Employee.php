<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model 
{
    protected $table = 'employee';
    
    protected $primaryKey = 'code';
    
    protected $keyType = 'int';
    
    public $incrementing = false;
    
    use HasFactory;

    protected $fillable = [
        'code',
        'ctps_code',
        'pis_code',
        'personal_code',
        'vote_code',
        'birth_date',
        'telephone',
        'name',
        'adjuntancy',
        'state',
        'city',
        'neighborhood',
        'number',
        'postal_code',
        'street',
        'admission',
        'contract1',
        'contract2',
        'salary',
        'instruction_id',
        'situation_id',
    ];

    public function situation()
    {
        return $this->belongsTo(Situation::class);
    }

    public function instruction()
    {
        return $this->belongsTo(Instruction::class);
    }

    public function occurrences()
    {
        return $this->hasMany(Occurrence::class);
    }
}
