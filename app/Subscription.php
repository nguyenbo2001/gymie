<?php

namespace App;

use Carbon\Carbon;
use Sofa\Eloquence\Eloquence;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    // protected $table = 'subscriptions';

    protected $fillable = [
        'member_id',
        'invoice_id',
        'plan_id',
        'status',
        'is_renewal',
        'start_date',
        'end_date',
        'created_by',
        'updated_by'
    ];

    protected $dates = ['created_at', 'updated_at', 'start_date', 'end_date'];

    use Eloquence;

    protected $searchableColumns = [
        'Member.member_code' => 20,
        'start_date' => 20,
        'end_date' => 20,
        'Member.name' => 20,
        'Plan.plan_name' => 20,
        'Invoice.invoice_number' => 20,
    ];

    public function scopeDashboardExpiring() {
        return $query->where('end_date', '<', Carbon::today()->allDays(7))->where('status', '=', \constSubscription::onGoing);
    }

    public function DashboardExpired($query) {
        return $query->where('status', '=', \constSubscription::Expired);
    }

    public function scopeIndexQuery($query, $sorting_field, $sorting_direction, $drp_start, $drp_end) {
        $sorting_field = ($sorting_field != null ? $sorting_field : 'created_by');
        $sorting_direction = ($sorting_direction != null ? $sorting_direction : 'desc');

        if ($drp_start == null or $drp_end == null) {
            return $query->leftJoin('plans',
                                    'subscriptions.plan_id',
                                    '=',
                                    'plans.id')
                        ->select('subscriptions.*',
                                'plans.plan_name')
                        ->orderBy($sorting_field, $sorting_direction);
        }

        return $query->leftJoin('plans',
                                'subscriptions.plan_id',
                                '=',
                                'plans.id')
                    ->select('subscriptions.*',
                            'plans.plan_name')
                    ->whereBetween('subscriptions.created_at', [$drp_start, $drp_end])
                    ->orderBy($sorting_field, $sorting_direction);
    }

    public function scopeExpiring($query, $sorting_field, $sorting_direction, $drp_start, $drp_end) {
        $sorting_field = ($sorting_field != null ? $sorting_field : 'created_at');
        $sorting_direction = ($sorting_direction != null ? $sorting_direction : 'desc');

        if ($drp_start == null or $drp_end == null) {
            return $query->leftJoin('plans',
                                    'subscriptions.plan_id',
                                    '=',
                                    'plans.id')
                        ->select('subscriptions.*', 'plans.plan_name')
                        ->where('subscriptions.end_date', '<', Carbon::today()->addDays(7))
                        ->where('subscriptions.status', '=', \constSubscription::onGoing)
                        ->orderBy($sorting_field, $sorting_direction);
        }

        return $query->leftJoin('plans',
                                'subscriptions.plan_id',
                                '=',
                                'plans.id')
                    ->select('subscriptions.*', 'plans.plan_name')
                    ->where('subscriptions.end_date', '<', Carbon::today()->addDays(7))
                    ->where('subscriptions.status', '=', \constSubscription::onGoing)
                    ->whereBetween('subscriptions.created_at', [$drp_start, $drp_end])
                    ->orderBy($sorting_field, $sorting_direction);
    }

    public function scopeExpired($query, $sorting_field, $sorting_direction, $drp_start, $drp_end) {
        $sorting_field = ($sorting_field != null ? $sorting_field : 'created_at');
        $sorting_direction = ($sorting_direction != null ? $sorting_direction : 'desc');

        if ($drp_start == null or $drp_end == null) {
            return $query->leftJoin('plans',
                                    'subscriptions.plan_id',
                                    '=',
                                    'plans.id')
                        ->select('subscriptions.*', 'plans.plan_name')
                        ->where('subscriptions.status', '=', \constSubscription::Expired)
                        ->where('subscriptions.status', '!=', \constSubscription::renewed)
                        ->orderBy($sorting_field, $sorting_direction);
        }

        return $query->leftJoin('plans',
                                'subscriptions.plan_id',
                                '=',
                                'plans.id')
                    ->select('subscriptions.*', 'plans.plan_name')
                    ->where('subscriptions.status', '=', \constSubscription::Expired)
                    ->where('subscriptions.status', '!=', \constSubscription::renewed)
                    ->whereBetween('subscriptions.created_at', [$drp_start, $drp_end])
                    ->orderBy($sorting_field, $sorting_direction);
    }

    public function createdBy() {
        return $this->belongsTo('App\User', 'created_by');
    }

    public function updatedBy() {
        return $this->belongsTo('App\User', 'updated_by');
    }

    public function Member() {
        return $this->belongsTo('App\Member', 'member_id');
    }

    public function Plan() {
        return $this->belongsTo('App\Plan', 'plan_id');
    }

    public function Invoice() {
        return $this->belongsTo('App\Invoice', 'invoice_id');
    }
}
