<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;
    protected $fillable = [
        'stripe_price_id',
        'slug',
        'name',
        'conditions',
        'price',
        'quantity',
        'currency',
        'event_id',
        'people_per_ticket',
        'visible',
        'time_limit',
        'max_datetime',
        'id_number_required',
    ];

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
