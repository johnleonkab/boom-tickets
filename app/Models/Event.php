<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    protected $fillable = [
        'stripe_product_id',
        'slug',
        'name',
        'description',
        'tags',
        'start_datetime',
        'end_datetime',
        'max_capacity',
        'visible',
        'recurrente',
        'patron_recurrencia',
        'organization_id',
        'venue_id',
        'color',
        'poster_url',
        'meta_event',
        'original_event_id',
        'minimum_age',
    ];

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function venue()
    {
        return $this->belongsTo(Venue::class);
    }
}
