<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'property_id',
        'agent_id',
        'buyer_name',
        'sale_date',
        'amount',
        'status'
    ];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public function agent()
    {
        return $this->belongsTo(User::class, 'agent_id');
    }

    public function collections()
    {
        return $this->hasMany(Collection::class);
    }

    public function commissions()
    {
        return $this->hasMany(Commission::class);
    }
}
