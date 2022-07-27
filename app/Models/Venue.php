<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venue extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'name',
        'description',
        'meta_data',
        'visible',
        'longitude',
        'latitude',
        'address',
        'timezone',
        'currency',
        'logo_url',
        'organization_id',
        'rating',
    ];

    public function events()
    {
        return $this->hasMany(Event::class);
    }
    public function tags()
    {
        return $this->hasMany(Tag::class, 'target_id')->where('target_type', 'venue');
    }
    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }
    public function followers(){
        return $this->hasMany(Following::class, 'target_id')->where('target_type', 'venue');
    }
}
