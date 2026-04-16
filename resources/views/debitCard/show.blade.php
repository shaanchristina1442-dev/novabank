@extends('layouts.app')
@section('title', 'Debit Card Details')

@section('content')
<div class="page">

  <div class="page-head">
    <div>
      <h1 class="h1">Debit Card Details</h1>
      <p class="sub">•••• •••• •••• {{ substr($debitCard->card_number, -4) }}</p>
    </div>
    <div style="display:flex;gap:10px;">
      <a class="btn btn-ghost" href="{{ route('debitCard.index') }}">← Back</a>
      <form method="POST" action="{{ route('debitCard.destroy', $debitCard->id) }}"
            onsubmit="return confirm('Remove this debit card?')">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn" style="background:#e53935;color:#fff;border-color:#e53935;">Remove Card</button>
      </form>
    </div>
  </div>

  <div style="max-width:560px;display:flex;flex-direction:column;gap:20px;">

    <div style="background:linear-gradient(135deg,#111827 0%,#1f2937 60%,#374151 100%);border-radius:18px;padding:32px 28px 26px;color:#fff;box-shadow:0 8px 32px rgba(0,0,0,.35);position:relative;overflow:hidden;">
      <div style="position:absolute;top:-30px;right:-30px;width:160px;height:160px;border-radius:50%;background:rgba(249,115,22,.12);"></div>
      <div style="position:absolute;bottom:-50px;right:40px;width:200px;height:200px;border-radius:50%;background:rgba(249,115,22,.06);"></div>

      <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:32px;position:relative;">
        <div style="font-size:1.15rem;font-weight:700;letter-spacing:.5px;">NovaBank</div>
        <span style="background:rgba(249,115,22,.25);border-radius:20px;padding:4px 14px;font-size:.75rem;font-weight:600;letter-spacing:.5px;text-transform:uppercase;color:#fdba74;">
          {{ $debitCard->status }}
        </span>
      </div>

      <div style="font-size:1.5rem;letter-spacing:5px;font-weight:500;margin-bottom:28px;position:relative;">
        •••• •••• •••• {{ substr($debitCard->card_number, -4) }}
      </div>

      <div style="display:flex;justify-content:space-between;align-items:flex-end;position:relative;">
        <div>
          <div style="font-size:.68rem;opacity:.6;text-transform:uppercase;letter-spacing:.8px;margin-bottom:2px;">Cardholder</div>
          <div style="font-size:1rem;font-weight:600;">{{ $debitCard->name }}</div>
        </div>
        <div style="text-align:right;">
          <div style="font-size:.68rem;opacity:.6;text-transform:uppercase;letter-spacing:.8px;margin-bottom:2px;">Balance</div>
          <div style="font-size:1rem;font-weight:600;">${{ number_format($debitCard->debit_balance, 2) }}</div>
        </div>
      </div>
    </div>

    <div class="card">
      <div class="card-head" style="margin-bottom:16px;">
        <h2 class="h2">Card Information</h2>
      </div>
      <div style="display:flex;flex-direction:column;gap:14px;">
        <div style="display:flex;justify-content:space-between;">
          <span class="muted">Card Number</span>
          <span class="bold">•••• •••• •••• {{ substr($debitCard->card_number, -4) }}</span>
        </div>
        <div style="display:flex;justify-content:space-between;">
          <span class="muted">Cardholder</span>
          <span class="bold">{{ $debitCard->name }}</span>
        </div>
        <div style="display:flex;justify-content:space-between;">
          <span class="muted">Available Balance</span>
          <span class="bold text-good">${{ number_format($debitCard->debit_balance, 2) }}</span>
        </div>
        <div style="display:flex;justify-content:space-between;">
          <span class="muted">Status</span>
          <span class="pill {{ $debitCard->status === 'active' ? 'pill-green' : 'pill-red' }}">{{ ucfirst($debitCard->status) }}</span>
        </div>
        <div style="display:flex;justify-content:space-between;">
          <span class="muted">Added</span>
          <span>{{ $debitCard->created_at->format('M d, Y') }}</span>
        </div>
      </div>
    </div>

  </div>

</div>
@endsection
