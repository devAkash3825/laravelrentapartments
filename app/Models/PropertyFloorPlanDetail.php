<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PropertyFloorPlanDetail extends Model
{
    protected $table = 'propertyfloorplandetails';
    protected $primaryKey = 'Id';
    public $timestamps = false;

    protected $fillable = [
        'PropertyId',
        'CategoryId',
        'PlanType',
        'FloorPlan',
        'PlanName',
        'Footage',
        'Price',
        'Comments',
        'Status',
        'Available_Url',
        'special',
        'expiry_date',
        'avail_date',
        'isavailable',
        'deposit',
        'floorplan_link'
    ];

    public function property()
    {
        return $this->belongsTo(PropertyInfo::class, 'PropertyId', 'Id');
    }

    public function category()
    {
        return $this->belongsTo(PropertyFloorPlanCategory::class, 'CategoryId', 'Id');
    }

    public function images()
    {
        return $this->hasMany(GalleryDetails::class, 'floorplan_id', 'Id');
    }

    /* Short helpers */
    public function isAvailable()
    {
        return $this->isavailable == 1;
    }
}
