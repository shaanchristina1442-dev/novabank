<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreditCard extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'card_number',
        'credit_limit',
        'current_balance',
        'status'
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function CreditCards(){
        return $this->hasMany(CreditCards::class);
    }
}
