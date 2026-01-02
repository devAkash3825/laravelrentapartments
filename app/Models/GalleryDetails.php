<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GalleryDetails extends Model
{
    protected $table = 'gallerydetails';
    protected $primaryKey = 'Id';
    public $timestamps = false;

    protected $fillable = [
        'GalleryId',
        'ImageTitle',
        'Description',
        'ImageName',
        'DefaultImage',
        'display_in_gallery',
        'Status',
        'floorplan_id'
    ];

    public function gallery()
    {
        return $this->belongsTo(GalleryType::class, 'GalleryId', 'Id');
    }

    public function floorPlan()
    {
        return $this->belongsTo(PropertyFloorPlanDetail::class, 'floorplan_id', 'Id');
    }
}
