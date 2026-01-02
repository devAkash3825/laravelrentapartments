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

    /* =====================
     | Scopes
     |=====================*/

    public function scopeActive($query)
    {
        return $query->where('Status', '1');
    }

    public function scopeAvailable($query)
    {
        return $query->where('isavailable', 1);
    }

    /* =====================
     | Helper Methods
     |=====================*/

    public function isAvailable()
    {
        return $this->isavailable == 1;
    }

    public function getFormattedPrice()
    {
        return $this->Price ? '$' . number_format($this->Price) : 'N/A';
    }

    public function getFormattedFootage()
    {
        return $this->Footage ? number_format($this->Footage) . ' sq ft' : 'N/A';
    }

    public function isExpired()
    {
        if (!$this->expiry_date) {
            return false;
        }
        
        try {
            return \Carbon\Carbon::parse($this->expiry_date)->isPast();
        } catch (\Exception $e) {
            return false;
        }
    }

    public function getFloorPlanImage()
    {
        if ($this->FloorPlan) {
            return asset('uploads/floorplans/' . $this->FloorPlan);
        }
        
        return asset('images/no-floorplan.jpg');
    }

    public function hasSpecial()
    {
        return !empty($this->special) && !$this->isExpired();
    }
}
