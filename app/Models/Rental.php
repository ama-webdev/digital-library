<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rental extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function rental_details()
    {
        return $this->hasMany(RentalDetail::class, 'rental_id', 'id');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}