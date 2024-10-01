<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    // Indicar o nome da tabela
    protected $table = 'attendance';

    public $incrementing = false;
    
    protected $keyType = 'string';

    protected $primaryKey = 'code';

    // Indicar quais colunas podem ser cadastradas
    protected $fillable = [
        'code',
        'name',
        'adjuntancy',
        'delay_date',
        'arrival',
        'leave',
        'motive'
    ];
}
