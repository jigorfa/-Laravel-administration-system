<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DelayDetail extends Model
{
    protected $table = 'delay_detail';

    protected $primaryKey = 'id';
    
    protected $keyType = 'int';

    public $incrementing = false;

    use HasFactory;

    protected $fillable = [
        'delay_id',
        'delay_date',
        'arrival',
        'leave',
        'description',
    ];

    public function delay()
    {
        return $this->belongsTo(Delay::class, 'delay_id', 'id');
    }
}
