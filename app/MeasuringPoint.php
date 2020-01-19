<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class MeasuringPoint extends Model
{
    protected $fillable = [
        'substation_id',
        'name',
        'description',
        'has_abnormality',
        'system',
        'created_by',
        'updated_by',
    ];
    protected $casts = [
        'has_abnormality' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function substation()
    {
        return $this->belongsTo(Substation::class);
    }

    /**
     * @return Carbon
     */
    public function lastUpdateDate(): Carbon
    {
        return $this->updated_at;
    }
}
