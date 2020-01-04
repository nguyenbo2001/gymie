<?php

namespace App;

use Sofa\Eloquence\Eloquence;
use Illuminate\Database\Eloquent\Model;

class SmsTrigger extends Model
{
    // protected $table = 'sms_triggers';

    protected $fillable = [
        'name',
        'alias',
        'message',
        'status',
        'updated_by'
    ];

    /**
     * Default Values
     */
    protected $attributes = [
        'name' => '',
        'alias' => '',
        'message' => '',
        'status' => 0,
    ];

    const CREATED_AT = null;

    use Eloquence;

    protected $searchableColumns = [
        'name' => 20,
        'message' => 10,
    ];

    public function createdBy()
    {
        return $this->belongsTo('App\User', 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo('App\User', 'updated_by');
    }
}
