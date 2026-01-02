<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PropertyAdditionalInfo extends Model
{
    protected $table = 'propertyadditionalinfo';
    protected $primaryKey = 'Id';
    public $timestamps = false;

    protected $fillable = [
        'PropertyId',
        'LeasingTerms',
        'QualifiyingCriteria',
        'Parking',
        'PetPolicy',
        'Pets',
        'Neighborhood',
        'Schools',
        'drivedirection',
        'Status'
    ];

    public function property()
    {
        return $this->belongsTo(PropertyInfo::class, 'PropertyId', 'Id');
    }
}
