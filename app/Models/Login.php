<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Login extends Model
{
    use HasFactory;
    protected $table = 'login';
    protected $primaryKey = 'Id';
    public $timestamps = false;
    protected $guarded = [];


    protected $casts = [
        'CreatedOn' => 'datetime',
        'ModifiedOn' => 'datetime',
    ];


    public function renterinfo()
    {
        return $this->hasOne(RenterInfo::class, 'Login_ID', 'Id');
    }

    public function propertyInfo()
    {
        return $this->hasMany(PropertyInfo::class, 'UserId', 'Id');
    }
}
