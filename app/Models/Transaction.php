<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_date',
        'reference_number',
        'description',
        'total_amount',
        'type'
    ];

    protected $casts = [
        'transaction_date' => 'date',
        'total_amount' => 'decimal:2'
    ];

    public function details()
    {
        return $this->hasMany(TransactionDetail::class);
    }

    public function validateBalance()
    {
        $totalDebit = $this->details()->sum('debit_amount');
        $totalCredit = $this->details()->sum('credit_amount');

        return $totalDebit === $totalCredit;
    }
}
