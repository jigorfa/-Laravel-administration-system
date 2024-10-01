<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attest extends Model
{
    use HasFactory;

    // Indicar o nome da tabela
    protected $table = 'attest';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $primaryKey = 'code';

    // Indicar quais colunas podem ser cadastradas
    protected $fillable = [
        'code',
        'name',
        'adjuntancy',
        'start_date',
        'end_date',
        'total_days',
        'cause',
        'annex',
    ];
}
