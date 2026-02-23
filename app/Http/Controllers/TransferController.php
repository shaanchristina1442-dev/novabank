<?php

namespace App\Http\Controllers;

use Illuminate\Models\Account;
use Illuminate\Models\Transactions;
use Illuminate\Models\Transfer;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class TransferController extends Controller
{
    public function store(Request $request){
        $request->validate([
            'from_account_id' => ['required', 'integer'],
            'to_account_id' => ['required', 'integer', 'diffferent:from_account_id'],
            'amount' => ['required', 'numeric','min:0.01'],

        ]);

        $amount = round((float)$request->amount, 2);

        DB::transaction(function() use($request, $amount){
            $from = Account::where('id', $request->from_account_id)
                ->where('user_id', auth()->id())
                ->lockForUpdate()
                ->firstOrFail();
            $to = Account::where('id', $request->to_account_id)
                ->where('user_id', auth()->id())
                ->lockForUpdate()
                ->firstOrFail();
            if ($from->balance < $amount){
                abort(422, 'Insufficent funds');
            }

            $from->decrement('balance', $amount);
            $to->increment('balance', $amount);

            Transfer::create([
                'from_account_id' => $from->id,
                'to_account_id' => $to->id,
                'amount' => $amount,
            ]);
            Transactions::create([
                'account_id' => $from->id,
                'type'=> 'transfer_out',
                'amount' => $amount,
                'description' => 'Transfer to' .$to->name,


            ]);
            Transactions::create([
                'account_id' => $to->id,
                'type'=> 'transfer_to',
                'amount' => $amount,
                'description' => 'Transfer from' .$from->name,
            ]);


        });
        return back()->with('sucess', 'Transfer recieved');

    }
}
