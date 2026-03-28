<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CreditCard;

class CreditCardController extends Controller
{
    public function index()
    {
        $creditCards = CreditCard::where('user_id', auth()->id())->get();
        return view('creditCard.index', compact('creditCards'));
    }

    public function create()
    {
        return view('creditCard.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'         => ['required', 'string', 'max:100'],
            'card_number'  => ['required', 'digits:16'],
            'credit_limit' => ['required', 'numeric', 'min:100'],
            'status'       => ['required', 'in:active,frozen'],
        ]);

        CreditCard::create([
            'user_id'         => auth()->id(),
            'name'            => $request->name,
            'card_number'     => $request->card_number,
            'credit_limit'    => round((float) $request->credit_limit, 2),
            'current_balance' => 0,
            'status'          => $request->status,
        ]);

        return redirect()->route('creditCard.index')->with('success', 'Credit card added.');
    }

    public function show(CreditCard $creditCard)
    {
        if ($creditCard->user_id !== auth()->id()) {
            abort(403);
        }
        return view('creditCard.show', compact('creditCard'));
    }

    public function update(Request $request, CreditCard $creditCard)
    {
        if ($creditCard->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'name'         => ['required', 'string', 'max:100'],
            'credit_limit' => ['required', 'numeric', 'min:100'],
            'status'       => ['required', 'in:active,frozen'],
        ]);

        $creditCard->update([
            'name'         => $request->name,
            'credit_limit' => round((float) $request->credit_limit, 2),
            'status'       => $request->status,
        ]);

        return redirect()->route('creditCard.index')->with('success', 'Credit card updated.');
    }

    public function destroy(CreditCard $creditCard)
    {
        if ($creditCard->user_id !== auth()->id()) {
            abort(403);
        }
        $creditCard->delete();
        return redirect()->route('creditCard.index')->with('success', 'Credit card removed.');
    }
}
