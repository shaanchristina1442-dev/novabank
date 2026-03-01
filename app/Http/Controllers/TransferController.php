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
            'from_account_id' => 'required|exists:accounts,id',
            'to_account_id' => 'required|exists:accounts,id',
            'amount' => 'required|numeric|min:0.01',
        ]);
        
        $user = auth()->user();
        $fromAccount = Account::where('id', $request->from_account_id)
            ->where('user_id', $user->id)   
            ->firstOrFail();
        $toAccount = Account::where('id', $request->to_account_id)
            ->where('user_id', $user->id)
            ->firstOrFail();
        
        if ($fromAccount->balance < $request->amount) {
            return back()->withErrors(['amount' => 'Insufficient funds in the source account.']);
        }

        DB::transaction(function () use ($fromAccount, $toAccount, $request){
            $fromAccount->decrement('balance', $request->amount);
            $toAccount->increment('balance', $request->amount);

            Transactions::create([
                'user_id' => auth()->id(),
                'account_id' => $fromAccount->id,
                'amount' => $request->amount,
                'type' => 'debit',
                'description' => 'Transfer to account #' . $toAccount->id,
            ]);
            Transactions::create([
                'user_id' => auth()->id(),
                'account_id' => $toAccount->id,
                'amount' => $request->amount,
                'type' => 'credit',
                'description' => 'Transfer from account #' . $fromAccount->id,
            ]);
        });


        
    

        
        return redirect()->route('dashboard')->with('success', 'Transfer completed successfully.');
    }

}
