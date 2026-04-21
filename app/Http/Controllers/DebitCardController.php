<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\DebitCard;

class DebitCardController extends Controller
{
    public function index()
    {
        $debitCards = DebitCard::where('user_id', Auth::id())->get();
        return view('debitCard.index', compact('debitCards'));
    }

    public function create()
    {
        return view('debitCard.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'          => ['required', 'string', 'max:100'],
            'card_number'   => ['required', 'digits:16'],
            'debit_balance' => ['required', 'numeric', 'min:0'],
            'status'        => ['required', 'in:active,frozen'],
        ]);

        DebitCard::create([
            'user_id'       => Auth::id(),
            'name'          => $request->name,
            'card_number'   => $request->card_number,
            'debit_balance' => round((float) $request->debit_balance, 2),
            'status'        => $request->status,
        ]);

        return redirect()->route('debitCard.index')->with('success', 'Debit card added.');
    }

    public function show(DebitCard $debitCard)
    {
        if ($debitCard->user_id != Auth::id()) abort(403);
        return view('debitCard.show', compact('debitCard'));
    }

    public function edit(DebitCard $debitCard)
    {
        if ($debitCard->user_id != Auth::id()) abort(403);
        return view('debitCard.edit', compact('debitCard'));
    }

    public function update(Request $request, DebitCard $debitCard)
    {
        if ($debitCard->user_id != Auth::id()) abort(403);

        $request->validate([
            'name'          => ['required', 'string', 'max:100'],
            'debit_balance' => ['required', 'numeric', 'min:0'],
            'status'        => ['required', 'in:active,frozen'],
        ]);

        $debitCard->update([
            'name'          => $request->name,
            'debit_balance' => round((float) $request->debit_balance, 2),
            'status'        => $request->status,
        ]);

        return redirect()->route('debitCard.index')->with('success', 'Debit card updated.');
    }

    public function destroy(DebitCard $debitCard)
    {
        if ($debitCard->user_id != Auth::id()) abort(403);
        $debitCard->delete();
        return redirect()->route('debitCard.index')->with('success', 'Debit card deleted.');
    }
}
