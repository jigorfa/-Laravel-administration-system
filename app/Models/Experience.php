<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Experience extends Model
    {
    protected $primaryKey = 'code';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $table = 'experience';
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'adjuntancy',
        'admission',
        'contract1',
        'contract2',
        'salary',
        'situation_id'
    ];

    public function situation()
    {
        return $this->belongsTo(Situation::class);
    }
    }
