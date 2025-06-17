<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Account extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'type',
        'description',
        'is_active',
        'category_id'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    public function transactionDetails()
    {
        return $this->hasMany(TransactionDetail::class);
    }

    public function category()
    {
        return $this->belongsTo(AccountCategory::class);
    }

    public function getBalanceAttribute()
    {
        $debit = $this->transactionDetails()->sum('debit_amount');
        $credit = $this->transactionDetails()->sum('credit_amount');

        if (in_array($this->category->code, ['1', '2'])) {
            return $debit - $credit;
        }

        return $credit - $debit;
    }
}
