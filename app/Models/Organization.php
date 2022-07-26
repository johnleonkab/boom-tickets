<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'stripe_user_id',
        'name',
        'description',
        'meta_data',
        'visible',
        'contact_information',
        'logo_url',
        'rating',
    ];

    public function venues()
    {
        return $this->hasMany(Venue::class);
    }
    public function events()
    {
        return $this->hasMany(Event::class);
    }
}
