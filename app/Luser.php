<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Luser extends Model
{
    protected $table = 'staff';

    protected $fillable = [
        'username',
        'password',
        'name',
        'created_by',
        'updated_by'
    ];
}
