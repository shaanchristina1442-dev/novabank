<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DebitCard extends Model
{
    //
    protected $fillable = [
        'user_id',
        'name',
        'card_number',
        'debit_balance',
        'status'
    ];

    public function user(){

        return $this->belongsTo(User::class);
        
    }

}
