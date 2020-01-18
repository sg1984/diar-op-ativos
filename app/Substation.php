<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Substation extends Model
{
    protected $fillable = [
        'regional_id',
        'name',
        'description',
        'created_by',
        'updated_by'
    ];
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function regional()
    {
        return $this->belongsTo(Regional::class);
    }

    public function measuringPoints()
    {
        return $this->hasMany(MeasuringPoint::class);
    }
}
