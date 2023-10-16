<?php

/*
 * This file is part of the IndoRegion package.
 *
 * (c) Azis Hapidin <azishapidin.com | azishapidin@gmail.com>
 *
 */

namespace App\Models;

use AzisHapidin\IndoRegion\Traits\VillageTrait;
use Illuminate\Database\Eloquent\Model;
use App\Models\District;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Village Model.
 */
class Village extends Model
{
    use VillageTrait;
    use SoftDeletes;

    /**
     * Table name.
     *
     * @var string
     */
    protected $table = 'villages';
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'district_id'
    ];

    public function scopeSearch($query, $search)
    {
        return $query->where(function (Builder $query) use ($search) {
            $query->where('name', 'like', "%$search%")
                ->orWhereHas('district', function (Builder $query) use ($search) {
                    if (is_numeric($search)) {
                        $query->where('id', $search);
                    }
                });
        });
    }

    /**
     * Village belongs to District.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function district()
    {
        return $this->belongsTo(District::class);
    }
}
