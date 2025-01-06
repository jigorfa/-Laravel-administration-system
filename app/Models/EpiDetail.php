<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EpiDetail extends Model
{
    protected $table = 'epi_detail';

    protected $primaryKey = 'id';
    
    protected $keyType = 'int';

    public $incrementing = true;

    use HasFactory;

    protected $fillable = [
        'epi_id',
        'expedition_date',
        'name',
        'quantity',
        'description',
    ];

    public function epi()
    {
        return $this->belongsTo(Epi::class, 'epi_id', 'id');
    }
}
