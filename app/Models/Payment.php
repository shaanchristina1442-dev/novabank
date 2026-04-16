<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'user_id',
        'account_id',
        'credit_card_id',
        'debit_card_id',
        'payment_source',
        'amount',
        'recipient',
        'description',
        'status',
        'payment_date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function creditCard()
    {
        return $this->belongsTo(CreditCard::class);
    }

    public function debitCard()
    {
        return $this->belongsTo(DebitCard::class);
    }
}
