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
}
