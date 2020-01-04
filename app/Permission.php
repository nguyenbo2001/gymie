<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Zizaco\Entrust\EntrustPermission;

class Permission extends EntrustPermission
{
    // protected $table = 'permisisons';

    protected $fillable = [
        'name',
        'display_name',
        'description',
        'group_key',
    ];

    protected $attributes = [
        'display_name' => '',
        'description' => '',
        'group_key' => '',
    ];

    public function Roles()
    {
        return $this->belongsToMany('App\Role');
    }
}
