<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttestDetail extends Model
{
    protected $table = 'attest_detail';

    protected $primaryKey = 'id';
    
    protected $keyType = 'int';

    public $incrementing = false;

    use HasFactory;

    protected $fillable = [
        'attest_id',
        'start_attest',
        'end_attest',
        'cause',
        'annex',
    ];

    public function attest()
    {
        return $this->belongsTo(Attest::class, 'attest_id', 'id');
    }
}
