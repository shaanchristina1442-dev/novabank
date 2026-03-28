@extends('layouts.app')
@section('title', 'Apply for a Credit Card')

@section('content')
<div class="page">

  <div class="page-head">
    <div>
      <h1 class="h1">Apply for a Credit Card</h1>
      <p class="sub">Fill in the details below to open a new credit card</p>
    </div>
    <a class="btn btn-ghost" href="{{ route('creditCard.index') }}">← Back</a>
  </div>

  <div style="max-width:520px;">
    <div class="card">
      <form method="POST" action="{{ route('creditCard.store') }}" class="form">
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
          <label class="label">Credit Limit ($)</label>
          <input class="input" type="number" name="credit_limit"
            value="{{ old('credit_limit') }}"
            step="0.01" min="100" placeholder="e.g. 5000.00" required>
        </div>

        <div>
          <label class="label">Status</label>
          <select class="input" name="status" required>
            <option value="active" {{ old('status') === 'active' ? 'selected' : '' }}>Active</option>
            <option value="frozen" {{ old('status') === 'frozen' ? 'selected' : '' }}>Frozen</option>
          </select>
        </div>

        <div class="btnrow" style="margin-top:4px;">
          <button class="btn btn-lg btn-primary" type="submit">Submit Application</button>
          <a class="btn btn-ghost" href="{{ route('creditCard.index') }}">Cancel</a>
        </div>

      </form>
    </div>
  </div>

</div>
@endsection
