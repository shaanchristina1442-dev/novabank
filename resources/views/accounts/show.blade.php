@extends('layouts.app')

@section('title', $account->name)

@section('content')
  <h1>{{ $account->name }}</h1>
  <p class="muted">Balance: <strong>${{ number_format($account->balance, 2) }}</strong></p>

  <div class="grid">
    <section class="panel">
      <div class="panel-title">Deposit</div>
      <form method="POST" action="{{ route('account.deposit', $account) }}" class="form">
        @csrf
        <div class="field">
          <label>Amount</label>
          <input type="number" name="amount" step="0.01" min="0.01" required>
        </div>
        <div class="field">
          <label>Description (optional)</label>
          <input type="text" name="description" placeholder="Paycheck...">
        </div>
        <button class="btn primary" type="submit">Deposit</button>
      </form>
      <form method="POST" action="{{ route('account.deposit.store', $account) }}" class="form">
        @csrf
        <input type="number" name="amount" step="0.01" min="0.01" required>
        <button type="submit">Deposit</button>
      </form>
    </section>

    <section class="panel">
      <div class="panel-title">Withdraw</div>
      <form method="POST" action="{{ route('account.withdraw', $account) }}" class="form">
        @csrf
        <div class="field">
          <label>Amount</label>
          <input type="number" name="amount" step="0.01" min="0.01" required>
        </div>
        <div class="field">
          <label>Description (optional)</label>
          <input type="text" name="description" placeholder="Groceries...">
        </div>
        <button class="btn danger" type="submit">Withdraw</button>
      </form>
      <form method="POST" action="{{ route('account.withdraw.store', $account) }}" class="form">
        @csrf
        <input type="number" name="amount" step="0.01" min="0.01" required>
        <button type="submit">Withdraw</button>
      </form>

    </section>
  </div>

  <section class="panel">
    <div class="panel-title">Transactions</div>

    @if($transactions->isEmpty())
      <p>No transactions yet.</p>
    @else
      <ul class="list">
        @foreach($transactions as $t)
          <li class="list-row">
            <div>
              <div class="row-title">{{ ucfirst($t->type) }} — ${{ number_format($t->amount, 2) }}</div>
              <div class="row-sub">
                {{ $t->created_at->format('M d, Y g:i A') }}
                @if($t->description) • {{ $t->description }} @endif
              </div>
            </div>
          </li>
        @endforeach
      </ul>
    @endif
  </section>
@endsection