<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Situation extends Model
{
    use HasFactory;

    // Indicar o nome da tabela
    protected $table = 'situation';

    // Indicar quais colunas podem ser cadastradas
    protected $fillable = [
        'name',
        'color'
    ];

    public function experience()
    {
        return $this->hasMany(Experience::class);
    }
}
