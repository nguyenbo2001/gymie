<?php

namespace App;

use Lubus\Constants\Status;
use Sofa\Eloquence\Eloquence;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    // protected $table = 'plans';

    protected $fillable = [
        'plan_code',
        'plan_name',
        'service_id',
        'plan_details',
        'days',
        'amount',
        'status',
        'created_by',
        'updated_by',
    ];

    /**
     * Default Values
     */
    protected $attributes = [
        'plan_code' => '',
        'service_id' => 0,
        'plan_name' => '',
        'plan_details' => '',
        'days' => 0,
        'amount' => 0,
        'status' => 0,
    ];

    use Eloquence;

    protected $searchableColumns = [
        'plan_code' => 20,
        'plan_name' => 10,
        'plan_details' => 5,
    ];

    public function getPlanDisplayAttribute()
    {
        return $this->plan_code . ' @ ' . $this->amount . ' For ' . $this->days . ' Days';
    }

    public function scopeExcludeArchive($query)
    {
        return $query->where('status', '!=', \constStatus::Archive);
    }

    public function scopeOnlyActive($query)
    {
        return $query->where('status', '=', \constStatus::Active);
    }

    public function createdBy()
    {
        return $this->belongsTo('App\User', 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo('App\User', 'updated_by');
    }

    public function Subscriptions()
    {
        return $this->hasMany('App\Subscription', 'plan_id');
    }

    public function Service()
    {
        return $this->belongsTo('App\Service', 'service_id');
    }
}
