<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;
    protected $table = 'city';
    protected $guarded = [];
    public $timestamps = false;

    public function state(){
        return $this->belongsTo(State::class,'StateId','Id');
    }

    public function renterinfo(){
        return $this->hasMany(RenterInfo::class,'CityId','Id');
    }
    public function getSelectCities($list){
        $selectedStateCities = City::whereIn('Id',$list)->get();
        return $selectedStateCities;

    }
}
