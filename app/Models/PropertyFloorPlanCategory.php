<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PropertyFloorPlanCategory extends Model
{
    protected $table = 'propertyfloorplancategory';
    protected $primaryKey = 'Id';
    public $timestamps = false;

    protected $fillable = ['Name', 'Status'];

    public function floorPlans()
    {
        return $this->hasMany(PropertyFloorPlanDetail::class, 'CategoryId', 'Id');
    }
}
