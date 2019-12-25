<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvoiceDetail extends Model
{
    // protected $table = 'invoice_details';

    protected $fillable = [
        'item_name',
        'plan_id',
        'item_description',
        'invoice_id',
        'item_amount',
        'created_by',
        'updated_by'
    ];

    /**
     * Default Values
     */
    protected $attributes = [
        'invoice_id' => 0,
        'item_amount' => 0,
        'plan_id' => 0,
    ];

    public function createdBy() {
        return $this->belongsTo('App\User', 'created_by');
    }

    public function updatedBy() {
        return $this->belongsTo('App\User', 'updated_by');
    }

    public function Invoice() {
        return $this->belongsTo('App\Invoice', 'invoice_id');
    }

    public function Plan() {
        return $this->belongsTo('App\Plan', 'plan_id');
    }
}
