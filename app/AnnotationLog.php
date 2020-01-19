<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class AnnotationLog extends Model
{
    protected $fillable = [
        'measuring_point_id',
        'annotation',
        'created_by',
    ];
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function measuringPoint()
    {
        return $this->belongsTo(MeasuringPoint::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    /**
     * @return Carbon
     */
    public function lastUpdateDate(): Carbon
    {
        return $this->updated_at;
    }
}
