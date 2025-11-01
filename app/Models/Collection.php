<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    use HasFactory;

    protected $fillable = ['sale_id', 'amount', 'date', 'payment_method', 'remarks'];

    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }
}
