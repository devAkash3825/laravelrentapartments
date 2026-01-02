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
}
