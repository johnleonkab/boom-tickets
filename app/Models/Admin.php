<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use Notifiable;

    protected $table = 'admins';
    protected $guarded = array();


    public function organization()
    {
        return $this->hasOne(Organization::class, 'id');
    }

    public function permissions()
    {
        return $this->hasMany(Permission::class, 'admin_id');
    }

    public function analytics_permission()
    {
        return $this->permissions()->where('permission', 'analytics');
    }

    public function events_permission()
    {
        return $this->permissions()->where('permission', 'events');
    }

    public function payments_permission()
    {
        return $this->permissions()->where('permission', 'payments');
    }
}


