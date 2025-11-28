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
        'name',
        'first_name',
        'last_name',
        'middle_initial',
        'email',
        'password',
        'role',
        'branch_id',
        'birthday',
        'address', // ✅ add this
        'contact_number',
        'emergency_person',
        'emergency_contact',
        'accreditation',
        'accreditation_number',
        'project_commission',
        'brokerage_commission',
        'is_approved',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_approved' => 'boolean',
        'commission_rate' => 'float',
    ];

    /**
     * Automatically hash password unless it is already hashed.
     */
    public function setPasswordAttribute($value)
    {
        if (!empty($value)) {
            if (!str_starts_with($value, '$2y$')) {
                $value = Hash::make($value);
            }
            $this->attributes['password'] = $value;
        }
    }

    // 🔥 RELATIONSHIPS ----------------------------------------------------------

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

    // 🔥 HIERARCHY RELATIONSHIPS ------------------------------------------------

    /**
     * The manager this user reports to.
     */
    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

    /**
     * All users (agents) reporting under this manager.
     */
    public function reportsTo()
    {
        return $this->hasMany(User::class, 'manager_id');
    }
}
