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

    /* =====================
     | Helper Methods
     |=====================*/

    public function getImageUrl()
    {
        if ($this->ImageName) {
            return asset('uploads/galleries/' . $this->ImageName);
        }
        return asset('images/no-image.jpg');
    }

    public function isDefault()
    {
        return $this->DefaultImage == '1';
    }

    public function isDisplayInGallery()
    {
        return $this->display_in_gallery == '1';
    }

    public function getImagePath()
    {
        return public_path('uploads/galleries/' . $this->ImageName);
    }
}
