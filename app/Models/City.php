<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $table = 'city';
    protected $primaryKey = 'Id';
    public $timestamps = false;

    protected $fillable = [
        'StateId',
        'CityName',
        'status',
        'cityrent',
        'map',
        'shortName'
    ];

    /* =====================
     | Relationships
     |=====================*/

    public function state()
    {
        return $this->belongsTo(State::class, 'StateId', 'Id');
    }


    public function properties()
    {
        return $this->hasMany(PropertyInfo::class, 'CityId', 'Id');
    }

    /* =====================
     | Helpers
     |=====================*/

    public function isActive()
    {
        return $this->status === '1';
    }

    public function fullName()
    {
        return $this->CityName . ', ' . ($this->state->StateCode ?? '');
    }
}
