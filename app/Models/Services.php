<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Services extends Model
{
    use HasFactory;
    
    protected $fillable = ['name', 'image', 'price', 'description'];

    public function contacts() 
    {
        return $this->belongsTo(User::class, 'users_id');
    }
  

    public function bookingServices()
    {
        return $this->hasMany(BookingService::class);
    }


}
