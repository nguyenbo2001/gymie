<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PermissionRole extends Model
{
    protected $table = 'permission_roles';

    public $timestamps = false;

    protected $fillable = [
        'permission_id',
        'role_id',
    ];
}
