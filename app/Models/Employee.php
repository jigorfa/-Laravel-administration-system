<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model 
{
    protected $table = 'employee';
    
    protected $primaryKey = 'code';
    
    protected $dates = ['birth_date'];
    protected $keyType = 'int';
    
    public $incrementing = false;
    
    use HasFactory;

    protected $fillable = [
        'name',
        'birth_date',
        'nationality',
        'naturalness',
        'color_id',
        'gender_id',  
        'cpf_code',
        'ctps_code',
        'pis_code',
        'vote_code',
        'cnh_code',
        'telephone',
        'instruction_id',
        'civil_state_id',
        'postal_code',
        'address',
        'enterprise_id',
        'situation_id',
        'code',
        'adjuntancy',
        'admission',
        'contract1',
        'contract2',
        'salary',
        'demission',
    ];

    public function color()
    {
        return $this->belongsTo(Color::class);
    }

    public function gender()
    {
        return $this->belongsTo(Gender::class);
    }

    public function instruction()
    {
        return $this->belongsTo(Instruction::class);
    }

    public function civilState()
    {
        return $this->belongsTo(CivilState::class);
    }

    public function enterprise()
    {
        return $this->belongsTo(Enterprise::class);
    }

    public function situation()
    {
        return $this->belongsTo(Situation::class);
    }
}
