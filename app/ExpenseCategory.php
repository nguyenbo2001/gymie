<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Lubus\Constants\Status;

class ExpenseCategory extends Model
{
    protected $table = 'expenses_categories';

    protected $fillable = [
        'name',
        'total_expense',
        'status',
        'created_by',
        'updated_by'
    ];

    public function scopeExcludeArchive($query) {
        return $query->where('status',
                            '!=',
                            \constStatus::Archive);
    }

    public function Expenses() {
        return $this->hasMany('App\Expense', 'category_id');
    }

    public function createdBy() {
        return $this->belongsTo('App\User', 'created_by');
    }

    public function updatedBy() {
        return $this->belongsTo('App\User', 'updated_by');
    }
}
