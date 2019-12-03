<?php

namespace App;

use Sofa\Eloquence\Eloquence;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    // protected $table = 'services';

    protected $fillable = [
        'name',
        'description',
        'created_by',
        'updated_by'
    ];

    use Eloquence;

    protected $searchableColumns = [
        'name' => 20,
        'descriptioin' => 10,
    ];

    public function createdBy() {
        return $this->belongsTo('App\User', 'created_by');
    }

    public function updatedBy() {
        return $this->belongsTo('App\User', 'updated_by');
    }

    public function Plans() {
        return $this->hasMany('App\Plan', 'service_id');
    }
}
