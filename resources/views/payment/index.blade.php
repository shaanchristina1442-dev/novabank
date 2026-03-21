@extends('layouts.app')
@section('title', 'Payments')

@section('content')
<div class="page">

  <div class="page-head">
    <div>
      <h1 class="h1">Payments</h1>
      <p class="sub">Your outgoing payment history</p>
    </div>
    <a class="btn" href="{{ route('payment.create') }}">New Payment</a>
  </div>

  <div class="card" style="padding:0;">
    @if($payments->isEmpty())
      <div style="padding:40px;text-align:center;" class="muted">No payments found.</div>
    @else
      <div class="table-wrap">
        <table class="table">
          <thead>
            <tr>
              <th>Recipient</th>
              <th>Description</th>
              <th>Status</th>
              <th class="right">Amount</th>
              <th class="right">Date</th>
            </tr>
          </thead>
          <tbody>
            @foreach($payments as $p)
              <tr>
                <td class="bold">{{ $p->recipient }}</td>
                <td class="muted">{{ $p->description ?? '—' }}</td>
                <td>
                  <span class="pill {{ $p->status === 'completed' ? 'pill-green' : ($p->status === 'failed' ? 'pill-red' : 'pill-yellow') }}">
                    {{ ucfirst($p->status) }}
                  </span>
                </td>
                <td class="right bold text-bad">-${{ number_format($p->amount, 2) }}</td>
                <td class="right muted text-sm">{{ $p->created_at->format('M d, Y g:i A') }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    @endif
  </div>

</div>
@endsection
