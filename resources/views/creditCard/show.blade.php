@extends('layouts.app')
@section('title', 'Card Details')

@section('content')
<div class="page">

  <div class="page-head">
    <div>
      <h1 class="h1">Card Details</h1>
      <p class="sub">•••• •••• •••• {{ substr($creditCard->card_number, -4) }}</p>
    </div>
    <div style="display:flex;gap:10px;">
      <a class="btn btn-ghost" href="{{ route('creditCard.index') }}">← Back</a>
      <form method="POST" action="{{ route('creditCard.destroy', $creditCard->id) }}"
            onsubmit="return confirm('Remove this credit card? This cannot be undone.')">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn" style="background:#e53935;color:#fff;border-color:#e53935;">Remove Card</button>
      </form>
    </div>
  </div>

  <div style="max-width:560px;display:flex;flex-direction:column;gap:20px;">

    {{-- Visual card --}}
    <div style="background:linear-gradient(135deg,#1a237e 0%,#1565c0 60%,#0288d1 100%);border-radius:18px;padding:32px 28px 26px;color:#fff;box-shadow:0 8px 32px rgba(21,101,192,.35);position:relative;overflow:hidden;">
      <div style="position:absolute;top:-30px;right:-30px;width:160px;height:160px;border-radius:50%;background:rgba(255,255,255,.07);"></div>
      <div style="position:absolute;bottom:-50px;right:40px;width:200px;height:200px;border-radius:50%;background:rgba(255,255,255,.05);"></div>

      <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:32px;position:relative;">
        <div style="font-size:1.15rem;font-weight:700;letter-spacing:.5px;">NovaBank</div>
        <span style="background:rgba(255,255,255,.18);border-radius:20px;padding:4px 14px;font-size:.75rem;font-weight:600;letter-spacing:.5px;text-transform:uppercase;">
          {{ $creditCard->status }}
        </span>
      </div>

      <div style="font-size:1.5rem;letter-spacing:5px;font-weight:500;margin-bottom:28px;position:relative;">
        •••• •••• •••• {{ substr($creditCard->card_number, -4) }}
      </div>

      <div style="display:flex;justify-content:space-between;align-items:flex-end;position:relative;">
        <div>
          <div style="font-size:.68rem;opacity:.7;text-transform:uppercase;letter-spacing:.8px;margin-bottom:2px;">Cardholder</div>
          <div style="font-size:1rem;font-weight:600;">{{ $creditCard->name }}</div>
        </div>
        <div style="text-align:right;">
          <div style="font-size:.68rem;opacity:.7;text-transform:uppercase;letter-spacing:.8px;margin-bottom:2px;">Credit Limit</div>
          <div style="font-size:1rem;font-weight:600;">${{ number_format($creditCard->credit_limit, 2) }}</div>
        </div>
      </div>
    </div>

    {{-- Stats --}}
    <div class="card">
      <div class="card-head" style="margin-bottom:16px;">
        <h2 class="h2">Balance Summary</h2>
      </div>

      <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:16px;margin-bottom:20px;">
        <div style="text-align:center;">
          <div class="muted text-sm" style="margin-bottom:4px;">Current Balance</div>
          <div class="bold text-bad" style="font-size:1.1rem;">-${{ number_format($creditCard->current_balance, 2) }}</div>
        </div>
        <div style="text-align:center;">
          <div class="muted text-sm" style="margin-bottom:4px;">Available</div>
          <div class="bold text-good" style="font-size:1.1rem;">${{ number_format($creditCard->credit_limit - $creditCard->current_balance, 2) }}</div>
        </div>
        <div style="text-align:center;">
          <div class="muted text-sm" style="margin-bottom:4px;">Limit</div>
          <div class="bold" style="font-size:1.1rem;">${{ number_format($creditCard->credit_limit, 2) }}</div>
        </div>
      </div>

      @php $pct = $creditCard->credit_limit > 0 ? min(100, ($creditCard->current_balance / $creditCard->credit_limit) * 100) : 0; @endphp
      <div style="margin-bottom:6px;display:flex;justify-content:space-between;">
        <span class="muted text-sm">Credit used</span>
        <span class="text-sm bold">{{ number_format($pct, 1) }}%</span>
      </div>
      <div style="background:#e9ecef;border-radius:6px;height:8px;">
        <div style="width:{{ $pct }}%;background:{{ $pct > 80 ? '#e53935' : ($pct > 50 ? '#fb8c00' : '#2e7d32') }};height:8px;border-radius:6px;transition:width .3s;"></div>
      </div>
    </div>

    {{-- Card info --}}
    <div class="card">
      <div class="card-head" style="margin-bottom:16px;">
        <h2 class="h2">Card Information</h2>
      </div>
      <div style="display:flex;flex-direction:column;gap:12px;">
        <div style="display:flex;justify-content:space-between;">
          <span class="muted">Card Number</span>
          <span class="bold">•••• •••• •••• {{ substr($creditCard->card_number, -4) }}</span>
        </div>
        <div style="display:flex;justify-content:space-between;">
          <span class="muted">Cardholder</span>
          <span class="bold">{{ $creditCard->name }}</span>
        </div>
        <div style="display:flex;justify-content:space-between;">
          <span class="muted">Status</span>
          <span class="pill {{ $creditCard->status === 'active' ? 'pill-green' : 'pill-red' }}">{{ ucfirst($creditCard->status) }}</span>
        </div>
        <div style="display:flex;justify-content:space-between;">
          <span class="muted">Opened</span>
          <span>{{ $creditCard->created_at->format('M d, Y') }}</span>
        </div>
      </div>
    </div>

  </div>

</div>
@endsection
