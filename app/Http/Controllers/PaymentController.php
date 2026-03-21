<?php

namespace App\Http\Controllers;

use App\Models\Transactions;
use App\Models\Payment;
use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $payments = Payment::where('user_id', auth()->id())->latest()->get();
        return view('payment.index', compact('payments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $accounts = Account::where('user_id', auth()->id())->get();
        return view('payment.create', compact('accounts'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'account_id' => ['required', 'exists:accounts,id'],
            'amount' => ['required', 'numeric', 'min:0.01'],
            'recipient' => ['required', 'string', 'max:255'],
            'description_for_payment' => ['nullable', 'string', 'max:200']
        ]);

        $account = Account::findOrFail($request->account_id);

        if ($account->user_id !== auth()->id()) {
            abort(403);
        }

        $amount = round((float) $request->amount, 2);

        if ($account->balance < $amount) {
            return back()->withErrors(['amount' => 'Insufficient funds.'])->withInput();
        }

        DB::transaction(function () use ($account, $amount, $request) {
            $account->decrement('balance', $amount);

            Transactions::create([
                'account_id' => $account->id,
                'amount' => $amount,
                'type' => 'debit',
                'description' => 'Payment to ' . $request->recipient,
            ]);

            Payment::create([
                'user_id' => auth()->id(),
                'account_id' => $account->id,
                'amount' => $amount,
                'recipient' => $request->recipient,
                'description' => $request->input('description_for_payment', 'Payment to recipient.'),
                'status' => 'completed',
            ]);
        });

        return redirect()->route('payment.index')->with('success', 'Payment completed');
    }

    /**
     * Display the specified resource.
     */
    public function show(Payment $payment)
    {
        if ($payment->user_id !== auth()->id()) {
            abort(403);
        }
        return view('payment.show', compact('payment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Payment $payment)
    {
        if ($payment->user_id !== auth()->id()) {
            abort(403);
        }
        return view('payment.edit', compact('payment'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Payment $payment)
    {
        if ($payment->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'amount' => ['required', 'numeric', 'min:0.01'],
            'recipient' => ['required', 'string', 'max:255'],
            'description_for_payment' => ['nullable', 'string', 'max:200']
        ]);

        $newAmount = round((float) $request->amount, 2);
        $delta = $newAmount - $payment->amount;
        $account = Account::findOrFail($payment->account_id);

        if ($delta > 0 && $account->balance < $delta) {
            return back()->withErrors(['amount' => 'Insufficient funds.'])->withInput();
        }

        DB::transaction(function () use ($payment, $account, $newAmount, $delta, $request) {
            if ($delta !== 0.0) {
                $account->decrement('balance', $delta);
            }

            $payment->update([
                'amount' => $newAmount,
                'recipient' => $request->recipient,
                'description' => $request->input('description_for_payment', $payment->description),
            ]);
        });

        return redirect()->route('payment.index')->with('success', 'Payment updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payment $payment)
    {
        if ($payment->user_id !== auth()->id()) {
            abort(403);
        }
        DB::transaction(function () use ($payment) {
            $account = Account::findOrFail($payment->account_id);
            $account->increment('balance', $payment->amount);
            $payment->delete();
        });

        return redirect()->route('payment.index')->with('success', 'Payment voided');
    }
}
