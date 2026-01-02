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

    /* =====================
     | Helper Methods
     |=====================*/

    public function hasLeasingTerms()
    {
        return !empty($this->LeasingTerms);
    }

    public function hasPetPolicy()
    {
        return !empty($this->PetPolicy);
    }

    public function hasParking()
    {
        return !empty($this->Parking);
    }

    public function hasNeighborhood()
    {
        return !empty($this->Neighborhood);
    }

    public function hasDrivingDirections()
    {
        return !empty($this->drivedirection);
    }
}
