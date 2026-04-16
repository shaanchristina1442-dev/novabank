@extends('layouts.app')
@section('title', 'Edit Credit Card')

@section('content')
<div class="page">

  <div class="page-head">
    <div>
      <h1 class="h1">Edit Credit Card</h1>
      <p class="sub">•••• •••• •••• {{ substr($creditCard->card_number, -4) }}</p>
    </div>
    <a class="btn btn-ghost" href="{{ route('creditCard.show', $creditCard->id) }}">← Back</a>
  </div>

  <div style="max-width:520px;">
    <div class="card">
      <form method="POST" action="{{ route('creditCard.update', $creditCard->id) }}" class="form">
        @csrf
        @method('PUT')

        <div>
          <label class="label">Cardholder Name</label>
          <input class="input" type="text" name="name"
            value="{{ old('name', $creditCard->name) }}"
            placeholder="Full name on card" required maxlength="100">
        </div>

        <div>
          <label class="label">Credit Limit ($)</label>
          <input class="input" type="number" name="credit_limit"
            value="{{ old('credit_limit', $creditCard->credit_limit) }}"
            step="0.01" min="100" placeholder="e.g. 5000.00" required>
        </div>

        <div>
          <label class="label">Status</label>
          <select class="input" name="status" required>
            <option value="active" {{ old('status', $creditCard->status) === 'active' ? 'selected' : '' }}>Active</option>
            <option value="frozen" {{ old('status', $creditCard->status) === 'frozen' ? 'selected' : '' }}>Frozen</option>
          </select>
        </div>

        <div class="btnrow" style="margin-top:4px;">
          <button class="btn btn-lg btn-primary" type="submit">Save Changes</button>
          <a class="btn btn-ghost" href="{{ route('creditCard.show', $creditCard->id) }}">Cancel</a>
        </div>

      </form>
    </div>
  </div>

</div>
@endsection
