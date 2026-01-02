<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    protected $table = 'state';
    protected $primaryKey = 'Id';
    public $timestamps = false;

    protected $fillable = [
        'StateName',
        'StateCode',
        'status',
        'TimeZone'
    ];

    /* =====================
     | Relationships
     |=====================*/

    public function cities()
    {
        return $this->hasMany(City::class, 'StateId', 'Id');
    }

    /* =====================
     | Helpers
     |=====================*/

    public function isActive()
    {
        return $this->status === '1';
    }
}
