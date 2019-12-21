<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Sofa\Eloquence\Eloquence;

class PaymentDetail extends Model
{
    // protected $table = 'payment_details';

    protected $fillable = [
        'payment_amount',
        'note',
        'mode',
        'invoice_id',
        'created_by',
        'updated_by',
    ];

    use Eloquence;

    protected $searchableColumns = [
        'payment_amount' => 20,
        'Invoice.invoice_number' => 20,
        'Invoice.member.name' => 20,
    ];

    public function scopeIndexQuery($query, $sorting_field, $sorting_direction, $drp_start, $drp_end) {
        $sorting_field = ($sorting_field != null ? $sorting_field : 'created_by');
        $sorting_direction = ($sorting_direction != null ? $sorting_direction : 'desc');

        if ($drp_start == null or $drp_end == null) {
            return $query->leftJoin('invoices',
                                    'payment_details.invoice_id',
                                    '=',
                                    'invoices.id')
                        ->leftJoin('members',
                                    'invoices.member_id',
                                    '=',
                                    'members.id')
                        ->select('payment_details.id',
                                'payment_details.created_at',
                                'payment_details.payment_amount',
                                'payment_details.mode',
                                'payment_details.invoice_id',
                                'invoices.invoice_number',
                                'members.id as member_id',
                                'members.name as member_name',
                                'members.member_code')
                        ->orderBy($sorting_field, $sorting_direction);
        }

        return $query->leftJoin('invoices',
                                'payment_details.invoice_id',
                                '=',
                                'invoices.id')
                    ->leftJoin('members',
                                'invoices.member_id',
                                '=',
                                'members.id')
                    ->select('payment_details.id',
                            'payment_details.created_at',
                            'payment_details.payment_amount',
                            'payment_details.mode',
                            'payment_details.invoice_id',
                            'invoices.invoice_number',
                            'members.id as member_id',
                            'members.name as member_name',
                            'members.member_code')
                    ->whereBetween('payment_details.created_at', [$drp_start, $drp_end])
                    ->orderBy($sorting_field, $sorting_direction);
    }

    public function createdBy() {
        return $this->belongsTo('App\User', 'created_by');
    }

    public function updatedBy() {
        return $this->belongsTo('App\User', 'updated_by');
    }

    public function Invoice() {
        return $this->belongsTo('App\Invoice', 'invoice_id');
    }

    public function Cheque() {
        return $this->hasOne('App\ChequeDetail', 'payment_id');
    }
}
