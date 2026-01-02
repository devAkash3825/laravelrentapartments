<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GalleryType extends Model
{
    protected $table = 'gallerytype';
    protected $primaryKey = 'Id';
    public $timestamps = false;

    protected $fillable = [
        'PropertyId',
        'Title',
        'Description',
        'Status'
    ];

    public function property()
    {
        return $this->belongsTo(PropertyInfo::class, 'PropertyId', 'Id');
    }

    public function images()
    {
        return $this->hasMany(GalleryDetails::class, 'GalleryId', 'Id');
    }

    public function defaultImage()
    {
        return $this->images()->where('DefaultImage', '1')->first();
    }

    /* =====================
     | Scopes & Helper Methods
     |=====================*/

    public function activeImages()
    {
        return $this->images()->where('Status', '1');
    }

    public function galleryImages()
    {
        return $this->images()
            ->where('Status', '1')
            ->where('display_in_gallery', '1');
    }

    public function getImagesCount()
    {
        return $this->images()->where('Status', '1')->count();
    }

    public function hasImages()
    {
        return $this->getImagesCount() > 0;
    }
}
