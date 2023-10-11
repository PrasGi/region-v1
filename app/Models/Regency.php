<?php

/*
 * This file is part of the IndoRegion package.
 *
 * (c) Azis Hapidin <azishapidin.com | azishapidin@gmail.com>
 *
 */

namespace App\Models;

use AzisHapidin\IndoRegion\Traits\RegencyTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Regency Model.
 */
class Regency extends Model
{
    use RegencyTrait;
    use SoftDeletes;

    /**
     * Table name.
     *
     * @var string
     */
    protected $table = 'regencies';
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'province_id'
    ];

    public function scopeSearch($query, $search)
    {
        return $query->where(function (Builder $query) use ($search) {
            $query->where('name', 'like', "%$search%")
                ->orWhereHas('province', function (Builder $query) use ($search) {
                    $query->where('id', $search);
                });
        });
    }

    /**
     * Regency belongs to Province.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    /**
     * Regency has many districts.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function districts()
    {
        return $this->hasMany(District::class);
    }
}