<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\Boolean;

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

    /**
     * @var bool
     */
    private $hasAbnormality = null;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function regional()
    {
        return $this->belongsTo(Regional::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function measuringPoints()
    {
        return $this->hasMany(MeasuringPoint::class);
    }

    /**
     * @return bool
     */
    public function hasAnyAbnormality(): bool
    {
        if (is_null($this->hasAbnormality)){
            foreach ($this->measuringPoints as $measuringPoint){
                if($measuringPoint->has_abnormality){
                    $this->hasAbnormality = true;
                    break;
                }
                $this->hasAbnormality = false;
            }
        }

        return $this->hasAbnormality;
    }

    /**
     * @return Carbon
     */
    public function lastUpdateDate(): Carbon
    {
        return $this->updated_at;
    }
}
