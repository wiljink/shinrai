<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

   protected $fillable = [
    'project_id',
    'agent_id',
    'name',
    'location',
    'price',
    'status',
    'description',
    'property_type',
    'listing_category',
    'property_details',
    'selling_price',
    'commission_offered',
    'conditions',
    'listing_owner',
    'owner_contact_number',
    'lot_area',
    'floor_area',
    'bedrooms',
    'bathrooms',
    'carport',
    'lot_classification',
    'unit_type',
    'parking',
    'monthly_income',
    'total_units',
    'commercial_type',
];


    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function agent()
    {
        return $this->belongsTo(User::class, 'agent_id');
    }

    public function images()
    {
        return $this->hasMany(PropertyImage::class);
    }

    public function sale()
    {
        return $this->hasOne(Sale::class);
    }
}
