@extends('layouts.app')
@section('title', 'Credit Cards')

@section('content')
<div class="page">

  <div class="page-head">
    <div>
      <h1 class="h1">Credit Cards</h1>
      <p class="sub">Manage your NovaBank credit cards</p>
    </div>
    <a class="btn btn-primary" href="{{ route('creditCard.create') }}">+ Apply for Card</a>
  </div>

  @if($creditCards->isEmpty())
    <div class="card" style="text-align:center;padding:48px;">
      <div style="font-size:2.5rem;margin-bottom:12px;">💳</div>
      <div class="h2" style="margin-bottom:6px;">No credit cards yet</div>
      <p class="muted" style="margin-bottom:20px;">Apply for a NovaBank credit card to get started.</p>
      <a class="btn btn-primary" href="{{ route('creditCard.create') }}">Apply Now</a>
    </div>
  @else
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(320px,1fr));gap:24px;">
      @foreach($creditCards as $card)

        {{-- Visual card --}}
        <div style="background:linear-gradient(135deg,#1a237e 0%,#1565c0 60%,#0288d1 100%);border-radius:18px;padding:28px 28px 22px;color:#fff;box-shadow:0 8px 32px rgba(21,101,192,.35);position:relative;overflow:hidden;">
          <div style="position:absolute;top:-30px;right:-30px;width:160px;height:160px;border-radius:50%;background:rgba(255,255,255,.07);"></div>
          <div style="position:absolute;bottom:-50px;right:40px;width:200px;height:200px;border-radius:50%;background:rgba(255,255,255,.05);"></div>

          <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:28px;position:relative;">
            <div style="font-size:1.1rem;font-weight:700;letter-spacing:.5px;">NovaBank Resolution</div>
            <span style="background:rgba(255,255,255,.18);border-radius:20px;padding:3px 12px;font-size:.75rem;font-weight:600;letter-spacing:.5px;text-transform:uppercase;">
              {{ $card->status }}
            </span>
          </div>

          <div style="font-size:1.35rem;letter-spacing:4px;font-weight:500;margin-bottom:24px;position:relative;">
            •••• •••• •••• {{ substr($card->card_number, -4) }}
          </div>

          <div style="display:flex;justify-content:space-between;align-items:flex-end;position:relative;">
            <div>
              <div style="font-size:.68rem;opacity:.7;text-transform:uppercase;letter-spacing:.8px;margin-bottom:2px;">Cardholder</div>
              <div style="font-size:.95rem;font-weight:600;">{{ $card->name }}</div>
            </div>
            <div style="text-align:right;">
              <div style="font-size:.68rem;opacity:.7;text-transform:uppercase;letter-spacing:.8px;margin-bottom:2px;">Credit Limit</div>
              <div style="font-size:.95rem;font-weight:600;">${{ number_format($card->credit_limit, 2) }}</div>
            </div>
          </div>
        </div>

        {{-- Info below card --}}
        <div class="card" style="margin-top:-8px;border-top-left-radius:0;border-top-right-radius:0;">
          <div style="display:flex;justify-content:space-between;margin-bottom:10px;">
            <span class="muted text-sm">Current Balance</span>
            <span class="bold text-bad">-${{ number_format($card->current_balance, 2) }}</span>
          </div>
          <div style="display:flex;justify-content:space-between;margin-bottom:14px;">
            <span class="muted text-sm">Available Credit</span>
            <span class="bold text-good">${{ number_format($card->credit_limit - $card->current_balance, 2) }}</span>
          </div>

          {{-- Usage bar --}}
          @php $pct = $card->credit_limit > 0 ? min(100, ($card->current_balance / $card->credit_limit) * 100) : 0; @endphp
          <div style="background:#e9ecef;border-radius:6px;height:6px;margin-bottom:16px;">
            <div style="width:{{ $pct }}%;background:{{ $pct > 80 ? '#e53935' : ($pct > 50 ? '#fb8c00' : '#2e7d32') }};height:6px;border-radius:6px;transition:width .3s;"></div>
          </div>

          <a href="{{ route('creditCard.show', $card->id) }}" class="btn" style="width:100%;text-align:center;">View Details</a>
        </div>

      @endforeach
    </div>
  @endif

</div>
@endsection
