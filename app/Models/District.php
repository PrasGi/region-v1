<?php

/*
 * This file is part of the IndoRegion package.
 *
 * (c) Azis Hapidin <azishapidin.com | azishapidin@gmail.com>
 *
 */

namespace App\Models;

use AzisHapidin\IndoRegion\Traits\DistrictTrait;
use Illuminate\Database\Eloquent\Model;
use App\Models\Regency;
use App\Models\Village;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * District Model.
 */
class District extends Model
{
    use DistrictTrait;
    use SoftDeletes;

    /**
     * Table name.
     *
     * @var string
     */
    protected $table = 'districts';
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'regency_id'
    ];

    public function scopeSearch($query, $search)
    {
        return $query->where(function (Builder $query) use ($search) {
            $query->where('name', 'like', "%$search%")
                ->orWhereHas('regency', function (Builder $query) use ($search) {
                    if (is_numeric($search)) {
                        $query->where('id', $search);
                    }
                });
        });
    }

    /**
     * District belongs to Regency.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function regency()
    {
        return $this->belongsTo(Regency::class);
    }

    /**
     * District has many villages.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function villages()
    {
        return $this->hasMany(Village::class);
    }
}
