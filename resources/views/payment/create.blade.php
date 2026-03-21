@extends('layouts.app')
@section('title', 'New Payment')

@section('content')
<div class="page">

  <div class="page-head">
    <div>
      <h1 class="h1">New Payment</h1>
      <p class="sub">Send a payment from one of your accounts</p>
    </div>
    <a class="btn btn-ghost" href="{{ route('payment.index') }}">← Back</a>
  </div>

  <div style="max-width:520px;">
    <div class="card">
      <form method="POST" action="{{ route('payment.store') }}" class="form">
        @csrf

        <div>
          <label class="label">From Account</label>
          <select class="input" name="account_id" required>
            <option value="" disabled selected>Select an account…</option>
            @foreach($accounts as $account)
              <option value="{{ $account->id }}" {{ old('account_id') == $account->id ? 'selected' : '' }}>
                {{ $account->name }} — ${{ number_format($account->balance, 2) }}
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
          <button class="btn btn-lg" type="submit">Send Payment</button>
          <a class="btn btn-secondary" href="{{ route('payment.index') }}">Cancel</a>
        </div>
      </form>
    </div>
  </div>

</div>
@endsection
