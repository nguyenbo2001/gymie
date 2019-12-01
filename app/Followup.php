<?php

namespace App;

use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;

class Followup extends Model
{
    // protected $table = 'enquiry_followups';

    protected $fillable = [
        'enquiry_id',
        'followup_by',
        'due_date',
        'status',
        'outcome',
        'created_by',
        'updated_by'
    ];

    protected $dates = ['created_at', 'updated_at', 'due_date'];

    public function Enquiry() {
        return $this->belongsTo('App\Enquiry', 'enquiry_id');
    }

    public function scopeReminders($query) {
        return $query->leftJoin('enquiries',
                                'enquiry_followups.enquiry_id',
                                '=',
                                'enquiries.id')
                    ->select('enquiry_followups.*', 'enquiries.status')
                    ->where('enquiry_followups.due_date',
                            '<=',
                            Carbon::today())
                    ->where('enquiry_followups.status',
                            '=',
                            \constFollowUpStatus::Pending)
                    ->where('enquiries.status',
                            '=',
                            \constEnquiryStatus::Lead);
    }

    public function createdBy() {
        return $this->belongsTo('App\User', 'created_by');
    }

    public function updatedBy() {
        return $this->belongsTo('App\User', 'updated_by');
    }
}
