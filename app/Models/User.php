<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_approved',
        'branch_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_approved' => 'boolean',
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function properties()
    {
        return $this->hasMany(Property::class, 'agent_id');
    }

    public function sales()
    {
        return $this->hasMany(Sale::class, 'agent_id');
    }

    public function commissions()
    {
        return $this->hasMany(Commission::class, 'agent_id');
    }

    public function incentives()
    {
        return $this->hasMany(Incentive::class, 'agent_id');
    }

    public function accounts()
    {
        return $this->hasMany(Account::class);
    }

    public function reports()
    {
        return $this->hasMany(Report::class, 'generated_by');
    }
}
