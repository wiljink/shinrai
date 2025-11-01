<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ledger extends Model
{
    use HasFactory;

    protected $fillable = ['account_id', 'entry_date', 'description', 'debit', 'credit'];

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }
}
