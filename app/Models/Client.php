<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'lead_source',
        'assigned_agent_id',
    ];

    /**
     * The agent responsible for this lead/client.
     */
    public function assignedAgent()
    {
        return $this->belongsTo(User::class, 'assigned_agent_id');
    }

    /**
     * A client can have multiple sales recorded.
     */
    public function sales()
    {
        return $this->hasMany(Sale::class, 'buyer_id');
    }
}