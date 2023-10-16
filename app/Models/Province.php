<?php

/*
 * This file is part of the IndoRegion package.
 *
 * (c) Azis Hapidin <azishapidin.com | azishapidin@gmail.com>
 *
 */

namespace App\Models;

use AzisHapidin\IndoRegion\Traits\ProvinceTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Province Model.
 */
class Province extends Model
{
    use ProvinceTrait;
    use SoftDeletes;
    /**
     * Table name.
     *
     * @var string
     */
    protected $table = 'provinces';
    protected $guarded = [];

    public function scopeSearch($query, $search)
    {
        return $query->where(function (Builder $query) use ($search) {
            $query->where('name', 'like', "%$search%");
        });
    }


    /**
     * Province has many regencies.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function regencies()
    {
        return $this->hasMany(Regency::class);
    }
}
