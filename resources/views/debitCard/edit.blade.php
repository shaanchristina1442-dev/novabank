@extends('layouts.app')
@section('title', 'Edit Debit Card')

@section('content')
<div class="page">

  <div class="page-head">
    <div>
      <h1 class="h1">Edit Debit Card</h1>
      <p class="sub">•••• •••• •••• {{ substr($debitCard->card_number, -4) }}</p>
    </div>
    <a class="btn btn-ghost" href="{{ route('debitCard.show', $debitCard->id) }}">← Back</a>
  </div>

  <div style="max-width:520px;">
    <div class="card">
      <form method="POST" action="{{ route('debitCard.update', $debitCard->id) }}" class="form">
        @csrf
        @method('PUT')

        <div>
          <label class="label">Cardholder Name</label>
          <input class="input" type="text" name="name"
            value="{{ old('name', $debitCard->name) }}"
            placeholder="Full name on card" required maxlength="100">
        </div>

        <div>
          <label class="label">Balance ($)</label>
          <input class="input" type="number" name="debit_balance"
            value="{{ old('debit_balance', $debitCard->debit_balance) }}"
            step="0.01" min="0" placeholder="e.g. 1000.00" required>
        </div>

        <div>
          <label class="label">Status</label>
          <select class="input" name="status" required>
            <option value="active" {{ old('status', $debitCard->status) === 'active' ? 'selected' : '' }}>Active</option>
            <option value="frozen" {{ old('status', $debitCard->status) === 'frozen' ? 'selected' : '' }}>Frozen</option>
          </select>
        </div>

        <div class="btnrow" style="margin-top:4px;">
          <button class="btn btn-lg btn-primary" type="submit">Save Changes</button>
          <a class="btn btn-ghost" href="{{ route('debitCard.show', $debitCard->id) }}">Cancel</a>
        </div>

      </form>
    </div>
  </div>

</div>
@endsection
