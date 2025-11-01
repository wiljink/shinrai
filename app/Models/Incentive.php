<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Incentive extends Model
{
    use HasFactory;

    protected $fillable = ['agent_id', 'amount', 'description', 'date_given'];

    public function agent()
    {
        return $this->belongsTo(User::class, 'agent_id');
    }
}
