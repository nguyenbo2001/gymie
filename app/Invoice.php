<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Sofa\Eloquence\Eloquence;

class Invoice extends Model
{
    // protected $table = 'invoice';

    protected $fillable = [
        'total',
        'pending_amount',
        'member_id',
        'note',
        'status',
        'tax',
        'additional_fees',
        'invoice_number',
        'discount_percent',
        'discount_amount',
        'discount_note',
        'created_by',
        'updated_by'
    ];

    protected $dates = ['created_at', 'updated_at'];

    /**
     * Default Values
     */
    protected $attributes = [
        'member_id' => 0,
        'total' => 0,
        'pending_amount' => 0,
        'note' => '',
        'status' => 0,
        'invoice_number' => '',
        'discount_percent' => '',
        'discount_amount' => '',
        'discount_note' => '',
        'tax' => 0,
    ];

    use Eloquence;

    protected $searchableColumns = [
        'invoice_number' => 20,
        'total' => 20,
        'pending_amount' => 20,
        'Member.name' => 15,
        'Member.member_code' => 10
    ];

    public function scopeIndexQuery($query,
                                    $sorting_field,
                                    $sorting_direction,
                                    $drp_start,
                                    $drp_end) {
        $sorting_field = ($sorting_field != null ? $sorting_field : 'created_at');
        $sorting_direction = ($sorting_direction != null ? $sorting_direction : 'desc');

        if ($drp_start == null or $drp_end == null) {
            return $query->leftJoin('members',
                                    'invoices.member_id',
                                    '=',
                                    'members.id')
                        ->select('invoices.*', 'members.name as member_name')
                        ->orderBy('invoices.' .$sorting_field, $sorting_direction);
        }
        return $query->leftJoin('members',
                            'invoices.member_id',
                            '=',
                            'members.id')
                    ->select('invoices.*', 'members.name as member_name')
                    ->whereBetween('invoices.created_at', [$drp_start, $drp_end])
                    ->orderBy('invoices.' .$sorting_field, $sorting_direction);

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

    public function PaymentDetails() {
        return $this->hasMany('App\PaymentDetail');
    }

    public function InvoiceDetails() {
        return $this->hasMany('App\InvoiceDetail');
    }

    public function Subscription() {
        return $this->hasOne('App\Subscription');
    }
}
