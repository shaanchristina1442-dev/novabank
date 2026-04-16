<?php

namespace App\Http\Controllers;

use App\Models\Transactions;
use App\Models\Payment;
use App\Models\Account;
use App\Models\CreditCard;
use App\Models\DebitCard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::where('user_id', auth()->id())->latest()->get();
        return view('payment.index', compact('payments'));
    }

    public function create()
    {
        $accounts    = Account::where('user_id', auth()->id())->get();
        $creditCards = CreditCard::where('user_id', auth()->id())->where('status', 'active')->get();
        $debitCards  = DebitCard::where('user_id', auth()->id())->where('status', 'active')->get();
        return view('payment.create', compact('accounts', 'creditCards', 'debitCards'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'payment_source'          => ['required', 'in:account,credit_card,debit_card'],
            'account_id'              => ['required_if:payment_source,account', 'nullable', 'exists:accounts,id'],
            'credit_card_id'          => ['required_if:payment_source,credit_card', 'nullable', 'exists:credit_cards,id'],
            'debit_card_id'           => ['required_if:payment_source,debit_card', 'nullable', 'exists:debit_cards,id'],
            'amount'                  => ['required', 'numeric', 'min:0.01'],
            'recipient'               => ['required', 'string', 'max:255'],
            'description_for_payment' => ['nullable', 'string', 'max:200'],
        ]);

        $amount = round((float) $request->amount, 2);

        if ($request->payment_source === 'account') {
            $account = Account::findOrFail($request->account_id);
            if ($account->user_id !== auth()->id()) abort(403);
            if ($account->balance < $amount) {
                return back()->withErrors(['amount' => 'Insufficient funds.'])->withInput();
            }
            DB::transaction(function () use ($account, $amount, $request) {
                $account->decrement('balance', $amount);
                Transactions::create([
                    'user_id'     => auth()->id(),
                    'account_id'  => $account->id,
                    'amount'      => $amount,
                    'type'        => 'debit',
                    'description' => 'Payment to ' . $request->recipient,
                ]);
                Payment::create([
                    'user_id'        => auth()->id(),
                    'account_id'     => $account->id,
                    'payment_source' => 'account',
                    'amount'         => $amount,
                    'recipient'      => $request->recipient,
                    'description'    => $request->input('description_for_payment', 'Payment to recipient.'),
                    'status'         => 'completed',
                ]);
            });

        } elseif ($request->payment_source === 'credit_card') {
            $card = CreditCard::findOrFail($request->credit_card_id);
            if ($card->user_id !== auth()->id()) abort(403);
            $available = $card->credit_limit - $card->current_balance;
            if ($available < $amount) {
                return back()->withErrors(['amount' => 'Insufficient credit. Available: $' . number_format($available, 2)])->withInput();
            }
            DB::transaction(function () use ($card, $amount, $request) {
                $card->increment('current_balance', $amount);
                Payment::create([
                    'user_id'        => auth()->id(),
                    'credit_card_id' => $card->id,
                    'payment_source' => 'credit_card',
                    'amount'         => $amount,
                    'recipient'      => $request->recipient,
                    'description'    => $request->input('description_for_payment', 'Payment to recipient.'),
                    'status'         => 'completed',
                ]);
            });

        } else {
            $card = DebitCard::findOrFail($request->debit_card_id);
            if ($card->user_id !== auth()->id()) abort(403);
            if ($card->debit_balance < $amount) {
                return back()->withErrors(['amount' => 'Insufficient debit balance. Available: $' . number_format($card->debit_balance, 2)])->withInput();
            }
            DB::transaction(function () use ($card, $amount, $request) {
                $card->decrement('debit_balance', $amount);
                Payment::create([
                    'user_id'        => auth()->id(),
                    'debit_card_id'  => $card->id,
                    'payment_source' => 'debit_card',
                    'amount'         => $amount,
                    'recipient'      => $request->recipient,
                    'description'    => $request->input('description_for_payment', 'Payment to recipient.'),
                    'status'         => 'completed',
                ]);
            });
        }

        return redirect()->route('payment.index')->with('success', 'Payment completed.');
    }

    public function show(Payment $payment)
    {
        if ($payment->user_id !== auth()->id()) abort(403);
        return view('payment.show', compact('payment'));
    }

    public function edit(Payment $payment)
    {
        if ($payment->user_id !== auth()->id()) abort(403);
        return view('payment.edit', compact('payment'));
    }

    public function update(Request $request, Payment $payment)
    {
        if ($payment->user_id !== auth()->id()) abort(403);

        $request->validate([
            'amount'                  => ['required', 'numeric', 'min:0.01'],
            'recipient'               => ['required', 'string', 'max:255'],
            'description_for_payment' => ['nullable', 'string', 'max:200'],
        ]);

        $newAmount = round((float) $request->amount, 2);
        $delta     = $newAmount - $payment->amount;

        if ($payment->payment_source === 'account') {
            $account = Account::findOrFail($payment->account_id);
            if ($delta > 0 && $account->balance < $delta) {
                return back()->withErrors(['amount' => 'Insufficient funds.'])->withInput();
            }
            DB::transaction(function () use ($payment, $account, $newAmount, $delta, $request) {
                if ($delta != 0) $account->decrement('balance', $delta);
                $payment->update([
                    'amount'      => $newAmount,
                    'recipient'   => $request->recipient,
                    'description' => $request->input('description_for_payment', $payment->description),
                ]);
            });

        } elseif ($payment->payment_source === 'credit_card') {
            $card      = CreditCard::findOrFail($payment->credit_card_id);
            $available = ($card->credit_limit - $card->current_balance) + $payment->amount;
            if ($delta > 0 && $available < $delta) {
                return back()->withErrors(['amount' => 'Insufficient credit.'])->withInput();
            }
            DB::transaction(function () use ($payment, $card, $newAmount, $delta, $request) {
                if ($delta != 0) $card->increment('current_balance', $delta);
                $payment->update([
                    'amount'      => $newAmount,
                    'recipient'   => $request->recipient,
                    'description' => $request->input('description_for_payment', $payment->description),
                ]);
            });

        } else {
            $card      = DebitCard::findOrFail($payment->debit_card_id);
            $available = $card->debit_balance + $payment->amount;
            if ($delta > 0 && $available < $delta) {
                return back()->withErrors(['amount' => 'Insufficient debit balance.'])->withInput();
            }
            DB::transaction(function () use ($payment, $card, $newAmount, $delta, $request) {
                if ($delta != 0) $card->decrement('debit_balance', $delta);
                $payment->update([
                    'amount'      => $newAmount,
                    'recipient'   => $request->recipient,
                    'description' => $request->input('description_for_payment', $payment->description),
                ]);
            });
        }

        return redirect()->route('payment.index')->with('success', 'Payment updated.');
    }

    public function destroy(Payment $payment)
    {
        if ($payment->user_id !== auth()->id()) abort(403);

        DB::transaction(function () use ($payment) {
            if ($payment->payment_source === 'account') {
                Account::findOrFail($payment->account_id)->increment('balance', $payment->amount);
            } elseif ($payment->payment_source === 'credit_card') {
                CreditCard::findOrFail($payment->credit_card_id)->decrement('current_balance', $payment->amount);
            } else {
                DebitCard::findOrFail($payment->debit_card_id)->increment('debit_balance', $payment->amount);
            }
            $payment->delete();
        });

        return redirect()->route('payment.index')->with('success', 'Payment voided.');
    }
}
