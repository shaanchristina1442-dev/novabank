@extends('layouts.app')

@section('title', $account->name)

@section('content')

  <div class="page-head row">
    <div>
      <h1 class="h1">{{ $account->name }}</h1>
      <div class="muted text-sm">Acct ●●●● {{ str_pad($account->id, 4, '0', STR_PAD_LEFT) }}</div>
    </div>
    <div>
      <div class="muted text-xs" style="margin-bottom:2px;text-align:right;">Available Balance</div>
      <div class="big-number">${{ number_format($account->balance, 2) }}</div>
    </div>
  </div>

  <div class="grid-3" style="margin-bottom:20px;">

    {{-- Deposit --}}
    <div class="card">
      <div class="card-title">Deposit Funds</div>
      <form method="POST" action="{{ route('account.deposit', $account) }}" class="form">
        @csrf
        <div>
          <label class="label">Amount</label>
          <input class="input" type="number" name="amount" step="0.01" min="0.01" required placeholder="0.00">
        </div>
        <div>
          <label class="label">Description <span class="muted text-xs">(optional)</span></label>
          <input class="input" type="text" name="description" placeholder="e.g. Paycheck">
        </div>
        <button class="btn btn-success" type="submit">Deposit</button>
      </form>
    </div>

    {{-- Withdraw --}}
    <div class="card">
      <div class="card-title">Withdraw Funds</div>
      <form method="POST" action="{{ route('account.withdraw', $account) }}" class="form">
        @csrf
        <div>
          <label class="label">Amount</label>
          <input class="input" type="number" name="amount" step="0.01" min="0.01" required placeholder="0.00">
        </div>
        <div>
          <label class="label">Description <span class="muted text-xs">(optional)</span></label>
          <input class="input" type="text" name="description" placeholder="e.g. Groceries">
        </div>
        <button class="btn btn-danger" type="submit">Withdraw</button>
      </form>
    </div>

    {{-- Transfer --}}
    <div class="card">
      <div class="card-title">Transfer Funds</div>
      @if($accounts->isEmpty())
        <p class="muted text-sm">No other accounts available to transfer to.</p>
      @else
        <form method="POST" action="{{ route('account.transfer.store', $account) }}" class="form">
          @csrf
          <div>
            <label class="label">To Account</label>
            <select class="input" name="to_account_id" required>
              @foreach($accounts as $a)
                <option value="{{ $a->id }}">{{ $a->name }}</option>
              @endforeach
            </select>
          </div>
          <div>
            <label class="label">Amount</label>
            <input class="input" type="number" name="amount" step="0.01" min="0.01" required placeholder="0.00">
          </div>
          <div>
            <label class="label">Description <span class="muted text-xs">(optional)</span></label>
            <input class="input" type="text" name="description" placeholder="e.g. Rent">
          </div>
          <button class="btn" type="submit">Transfer</button>
        </form>
      @endif
    </div>

  </div>

  {{-- Transaction History --}}
  <div class="card">
    <div class="card-head">
      <h2 class="h2">Transaction History</h2>
      <span class="pill">{{ $transactions->total() }} total</span>
    </div>

    @if($transactions->isEmpty())
      <p class="muted" style="padding:16px 0;">No transactions yet.</p>
    @else
      <div class="table-wrap">
        <table class="table">
          <thead>
            <tr>
              <th>Type</th>
              <th>Description</th>
              <th class="right">Amount</th>
              <th class="right">Date</th>
            </tr>
          </thead>
          <tbody>
            @foreach($transactions as $t)
              <tr>
                <td>
                  <span class="pill {{ $t->type === 'credit' ? 'pill-green' : 'pill-red' }}">
                    {{ ucfirst($t->type) }}
                  </span>
                </td>
                <td class="muted">{{ $t->description ?? '—' }}</td>
                <td class="right bold {{ $t->type === 'credit' ? 'text-good' : 'text-bad' }}">
                  {{ $t->type === 'credit' ? '+' : '-' }}${{ number_format($t->amount, 2) }}
                </td>
                <td class="right muted text-sm">{{ $t->created_at->format('M d, Y g:i A') }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <div class="mt">{{ $transactions->links() }}</div>
    @endif
  </div>

@endsection
