<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'role',
        'is_approved',
        'branch_id',
        'birthday',
        'gender',
        // 🔑 NEW: For commission calculation (60%/70%/80%/90%)
        'commission_rate', 
        // 🔑 NEW: For Sales Manager/Director Override hierarchy
        'manager_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_approved' => 'boolean',
        // Casting commission_rate as float ensures it's treated as a number
        'commission_rate' => 'float', 
    ];

    // ✅ Safe password mutator (from your original file)
    public function setPasswordAttribute($value)
    {
        if (!empty($value)) {
            if (!str_starts_with($value, '$2y$')) {
                $value = Hash::make($value);
            }
            $this->attributes['password'] = $value;
        }
    }

    // --- Relationships (Existing) ---
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

    public function collections()
    {
        return $this->hasMany(Collection::class, 'agent_id');
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
    
    // --- Relationships (New for Hierarchy) ---
    
    /**
     * An agent reports to a manager, who is another User.
     */
    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

    /**
     * A manager/director has many reports (agents) under them.
     */
    public function reportsTo()
    {
        return $this->hasMany(User::class, 'manager_id');
    }
}