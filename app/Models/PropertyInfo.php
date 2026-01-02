<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyInfo extends Model
{
    use HasFactory;
    protected $table = 'propertyinfo';
    public $timestamps = false;
    protected $fillable = [
        'UserId',
        'PropertyName',
        'Company',
        'PropertyContact',
        'Units',
        'Year',
        'YearRemodel',
        'Email',
        'Address',
        'CityId',
        'ContactNo',
        'Area',
        'Zone',
        'Zip',
        'WebSite',
        'BillTo',
        'BillAddress',
        'BillCity',
        'BillZip',
        'BillEmail',
        'BillContact',
        'BillPhone',
        'Fax',
        'BillFax',
        'PictureName',
        'Featured',
        'PropertyFeatures',
        'CommunityFeatures',
        'ActiveOnSearch',
        'Status',
        'Keyword',
        'latitude',
        'longitude',
        'officehour',
        'link_title',
        'link',
        'acc_to_craiglist'
    ];

    protected $casts = [
        'CreatedOn' => 'datetime',
        'ModifiedOn' => 'datetime',
    ];


    public function login()
    {
        return $this->belongsTo(Login::class, 'UserId', 'Id');
    }

    public function additionalInfo()
    {
        return $this->hasOne(PropertyAdditionalInfo::class, 'PropertyId', 'Id');
    }

    public function floorPlans()
    {
        return $this->hasMany(PropertyFloorPlanDetail::class, 'PropertyId', 'Id');
    }

    public function galleries()
    {
        return $this->hasMany(GalleryType::class, 'PropertyId', 'Id');
    }

    public function activeFloorPlans()
    {
        return $this->floorPlans()->where('Status', '1');
    }

    public function featured()
    {
        return $this->Featured == '1';
    }

    public function isActive()
    {
        return $this->Status == '1';
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'CityId', 'Id');
    }

    public function state()
    {
        return $this->belongsTo(State::class, 'state_id');
    }

    public function user()
    {
        return $this->login(); // Alias for better readability
    }

    public function billCity()
    {
        return $this->belongsTo(City::class, 'BillCity', 'Id');
    }

    /* =====================
     | Scopes
     |=====================*/

    public function scopeActive($query)
    {
        return $query->where('Status', '1');
    }

    public function scopeFeatured($query)
    {
        return $query->where('Featured', '1');
    }

    public function scopeActiveOnSearch($query)
    {
        return $query->where('ActiveOnSearch', '1');
    }

    /* =====================
     | Helper Methods
     |=====================*/

    public function getFullAddress()
    {
        $parts = array_filter([
            $this->Address,
            $this->Area,
            $this->city?->CityName,
            $this->state?->StateName,
            $this->Zip
        ]);
        
        return implode(', ', $parts);
    }

    public function getCoordinates()
    {
        if ($this->latitude && $this->longitude) {
            return [
                'lat' => $this->latitude,
                'lng' => $this->longitude
            ];
        }
        return null;
    }

    public function hasFloorPlans()
    {
        return $this->floorPlans()->where('Status', '1')->exists();
    }

    public function hasGallery()
    {
        return $this->galleries()->where('Status', '1')->exists();
    }

    public function getPropertyImage()
    {
        if ($this->PictureName) {
            return asset('uploads/properties/' . $this->PictureName);
        }
        
        // Fallback to first gallery image
        $galleryImage = $this->galleries()
            ->with('images')
            ->first()?->defaultImage();
        
        return $galleryImage?->ImageName 
            ? asset('uploads/galleries/' . $galleryImage->ImageName)
            : asset('images/no-property-image.jpg');
    }

    public function getOfficeHoursFormatted()
    {
        return $this->officehour ? nl2br(e($this->officehour)) : 'Not specified';
    }

    public function activeGalleries()
    {
        return $this->galleries()->where('Status', '1');
    }

    public function availableFloorPlans()
    {
        return $this->floorPlans()
            ->where('Status', '1')
            ->where('isavailable', 1);
    }
}
