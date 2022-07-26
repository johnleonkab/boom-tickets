<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    protected $table = 'admins_permissions';

    protected $fillable = [
        'admin_id',
        'permission',
        'permission_id'
    ];
}
