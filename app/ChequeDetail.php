<?php

namespace App;

use Sofa\Eloquence\Eloquence;

use Illuminate\Database\Eloquent\Model;

class ChequeDetail extends Model
{
    // protected $table = 'cheque_details';

    protected $fillable = [
        'payment_id',
        'number',
        'date',
        'status',
        'created_by',
        'updated_by'
    ];

    // Eloquence Search Mapping
    use Eloquence;

    protected $searchableColumns = [
        'number' => 20,
    ];

    public function createdBy() {
        return $this->belongsTo('App\User', 'created_by');
    }

    public function updatedBy() {
        return $this->belongsTo('App\User', 'updated_by');
    }

    public function Payment() {
        return $this->belongsTo('App\PaymentDetail', 'payment_id');
    }
}
