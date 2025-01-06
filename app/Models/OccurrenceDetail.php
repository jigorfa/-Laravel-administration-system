<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OccurrenceDetail extends Model
{
    protected $table = 'occurrence_detail';

    protected $primaryKey = 'id';
    
    protected $keyType = 'int';

    public $incrementing = false;

    use HasFactory;

    protected $fillable = [
        'occurrence_id',
        'occasion_id',
        'occurrence_date',
        'description',
    ];

    public function occurrence()
    {
        return $this->belongsTo(Occurrence::class, 'occurrence_id', 'id');
    }

    public function occasion()
    {
        return $this->belongsTo(Occasion::class, 'occasion_id');
    }
}
