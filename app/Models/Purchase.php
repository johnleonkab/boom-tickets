<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;
    protected $fillable = [
        'slug_code',
        'ticket_id',
        'user_id',
        'price',
        'rcipient_id_number',
        'recipient_email',
        'recipient_phone',
        'recipient_gender',
        'selling'
    ];

}
