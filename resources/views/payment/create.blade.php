@extends('layouts.app')
@section('title', 'New Payment')

@section('content')
<div class="page">

  <div class="page-head">
    <div>
      <h1 class="h1">New Payment</h1>
      <p class="sub">Send a payment from an account or credit card</p>
    </div>
    <a class="btn btn-ghost" href="{{ route('payment.index') }}">← Back</a>
  </div>

  <div style="max-width:520px;">
    <div class="card">
      <form method="POST" action="{{ route('payment.store') }}" class="form">
        @csrf

        {{-- Payment source toggle --}}
        <div>
          <label class="label">Pay With</label>
          <div style="display:flex;gap:12px;">
            <label style="flex:1;display:flex;align-items:center;gap:8px;cursor:pointer;padding:10px 14px;border:1px solid #dee2e6;border-radius:8px;">
              <input type="radio" name="payment_source" value="account"
                {{ old('payment_source', 'account') === 'account' ? 'checked' : '' }}
                onchange="document.getElementById('account-section').style.display='block';document.getElementById('card-section').style.display='none';">
              Bank Account
            </label>
            <label style="flex:1;display:flex;align-items:center;gap:8px;cursor:pointer;padding:10px 14px;border:1px solid #dee2e6;border-radius:8px;">
              <input type="radio" name="payment_source" value="credit_card"
                {{ old('payment_source') === 'credit_card' ? 'checked' : '' }}
                onchange="document.getElementById('account-section').style.display='none';document.getElementById('card-section').style.display='block';">
              Credit Card
            </label>
          </div>
        </div>

        {{-- Bank account selector --}}
        <div id="account-section" style="{{ old('payment_source') === 'credit_card' ? 'display:none' : '' }}">
          <label class="label">From Account</label>
          <select class="input" name="account_id">
            <option value="" disabled selected>Select an account…</option>
            @foreach($accounts as $account)
              <option value="{{ $account->id }}" {{ old('account_id') == $account->id ? 'selected' : '' }}>
                {{ $account->name }} — ${{ number_format($account->balance, 2) }}
              </option>
            @endforeach
          </select>
        </div>

        {{-- Credit card selector --}}
        <div id="card-section" style="{{ old('payment_source') === 'credit_card' ? '' : 'display:none' }}">
          <label class="label">Credit Card</label>
          <select class="input" name="credit_card_id">
            <option value="" disabled selected>Select a card…</option>
            @foreach($creditCards as $card)
              <option value="{{ $card->id }}" {{ old('credit_card_id') == $card->id ? 'selected' : '' }}>
                •••• {{ substr($card->card_number, -4) }} — ${{ number_format($card->credit_limit - $card->current_balance, 2) }} available
              </option>
            @endforeach
          </select>
        </div>

        <div>
          <label class="label">Recipient Name</label>
          <input class="input" type="text" name="recipient"
            value="{{ old('recipient') }}"
            placeholder="e.g. John Smith" required>
        </div>

        <div>
          <label class="label">Amount</label>
          <input class="input" type="number" name="amount"
            value="{{ old('amount') }}"
            step="0.01" min="0.01" placeholder="0.00" required>
        </div>

        <div>
          <label class="label">Description <span class="muted text-xs">(optional)</span></label>
          <input class="input" type="text" name="description_for_payment"
            value="{{ old('description_for_payment') }}"
            placeholder="e.g. Rent, invoice #123…">
        </div>

        <div class="btnrow" style="margin-top:4px;">
          <button class="btn btn-lg btn-primary" type="submit">Send Payment</button>
          <a class="btn btn-ghost" href="{{ route('payment.index') }}">Cancel</a>
        </div>

      </form>
    </div>
  </div>

</div>
@endsection
