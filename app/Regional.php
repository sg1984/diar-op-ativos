<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Regional extends Model
{
    /**
     * @var bool
     */
    private $hasAbnormality = null;

    protected $fillable = [
        'name',
        'description',
        'created_by',
        'updated_by',
    ];
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function substations()
    {
        return $this->hasMany(Substation::class);
    }

    /**
     * @return bool
     */
    public function hasAnyAbnormality(): bool
    {
        if (is_null($this->hasAbnormality)){
            foreach ($this->substations as $substation){
                if($substation->hasAnyAbnormality()) {
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
