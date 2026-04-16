@extends('layouts.app')
@section('title', 'Add Debit Card')

@section('content')
<div class="page">

  <div class="page-head">
    <div>
      <h1 class="h1">Add Debit Card</h1>
      <p class="sub">Link a new debit card to your account</p>
    </div>
    <a class="btn btn-ghost" href="{{ route('debitCard.index') }}">← Back</a>
  </div>

  <div style="max-width:520px;">
    <div class="card">
      <form method="POST" action="{{ route('debitCard.store') }}" class="form">
        @csrf

        <div>
          <label class="label">Cardholder Name</label>
          <input class="input" type="text" name="name"
            value="{{ old('name', Auth::user()->name) }}"
            placeholder="Full name on card" required maxlength="100">
        </div>

        <div>
          <label class="label">Card Number <span class="muted text-xs">(16 digits)</span></label>
          <input class="input" type="text" name="card_number"
            value="{{ old('card_number') }}"
            placeholder="e.g. 4111111111111111"
            maxlength="16" pattern="\d{16}" required>
        </div>

        <div>
          <label class="label">Initial Balance ($)</label>
          <input class="input" type="number" name="debit_balance"
            value="{{ old('debit_balance') }}"
            step="0.01" min="0" placeholder="e.g. 1000.00" required>
        </div>

        <div>
          <label class="label">Status</label>
          <select class="input" name="status" required>
            <option value="active" {{ old('status') === 'active' ? 'selected' : '' }}>Active</option>
            <option value="frozen" {{ old('status') === 'frozen' ? 'selected' : '' }}>Frozen</option>
          </select>
        </div>

        <div class="btnrow" style="margin-top:4px;">
          <button class="btn btn-lg btn-primary" type="submit">Add Card</button>
          <a class="btn btn-ghost" href="{{ route('debitCard.index') }}">Cancel</a>
        </div>

      </form>
    </div>
  </div>

</div>
@endsection
