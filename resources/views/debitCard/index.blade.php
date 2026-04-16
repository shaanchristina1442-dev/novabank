@extends('layouts.app')
@section('title', 'Debit Cards')

@section('content')
<div class="page">

  <div class="page-head">
    <div>
      <h1 class="h1">Debit Cards</h1>
      <p class="sub">Manage your NovaBank debit cards</p>
    </div>
    <a class="btn btn-primary" href="{{ route('debitCard.create') }}">+ Add Debit Card</a>
  </div>

  @if($debitCards->isEmpty())
    <div class="card" style="text-align:center;padding:48px;">
      <div style="font-size:2.5rem;margin-bottom:12px;">💳</div>
      <div class="h2" style="margin-bottom:6px;">No debit cards yet</div>
      <p class="muted" style="margin-bottom:20px;">Add a NovaBank debit card to get started.</p>
      <a class="btn btn-primary" href="{{ route('debitCard.create') }}">Add Card</a>
    </div>
  @else
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(320px,1fr));gap:24px;">
      @foreach($debitCards as $card)

        {{-- Visual card --}}
        <div style="background:linear-gradient(135deg,#111827 0%,#1f2937 60%,#374151 100%);border-radius:18px;padding:28px 28px 22px;color:#fff;box-shadow:0 8px 32px rgba(0,0,0,.35);position:relative;overflow:hidden;">
          <div style="position:absolute;top:-30px;right:-30px;width:160px;height:160px;border-radius:50%;background:rgba(249,115,22,.12);"></div>
          <div style="position:absolute;bottom:-50px;right:40px;width:200px;height:200px;border-radius:50%;background:rgba(249,115,22,.06);"></div>

          <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:28px;position:relative;">
            <div style="font-size:1.1rem;font-weight:700;letter-spacing:.5px;">NovaBank</div>
            <span style="background:rgba(249,115,22,.25);border-radius:20px;padding:3px 12px;font-size:.75rem;font-weight:600;letter-spacing:.5px;text-transform:uppercase;color:#fdba74;">
              {{ $card->status }}
            </span>
          </div>

          <div style="font-size:1.35rem;letter-spacing:4px;font-weight:500;margin-bottom:24px;position:relative;">
            •••• •••• •••• {{ substr($card->card_number, -4) }}
          </div>

          <div style="display:flex;justify-content:space-between;align-items:flex-end;position:relative;">
            <div>
              <div style="font-size:.68rem;opacity:.6;text-transform:uppercase;letter-spacing:.8px;margin-bottom:2px;">Cardholder</div>
              <div style="font-size:.95rem;font-weight:600;">{{ $card->name }}</div>
            </div>
            <div style="text-align:right;">
              <div style="font-size:.68rem;opacity:.6;text-transform:uppercase;letter-spacing:.8px;margin-bottom:2px;">Balance</div>
              <div style="font-size:.95rem;font-weight:600;">${{ number_format($card->debit_balance, 2) }}</div>
            </div>
          </div>
        </div>

        {{-- Info below card --}}
        <div class="card" style="margin-top:-8px;">
          <div style="display:flex;justify-content:space-between;margin-bottom:14px;">
            <span class="muted text-sm">Available Balance</span>
            <span class="bold text-good">${{ number_format($card->debit_balance, 2) }}</span>
          </div>
          <div style="display:flex;justify-content:space-between;margin-bottom:16px;">
            <span class="muted text-sm">Status</span>
            <span class="pill {{ $card->status === 'active' ? 'pill-green' : 'pill-red' }}">{{ ucfirst($card->status) }}</span>
          </div>
          <a href="{{ route('debitCard.show', $card->id) }}" class="btn" style="width:100%;text-align:center;">View Details</a>
        </div>

      @endforeach
    </div>
  @endif

</div>
@endsection
