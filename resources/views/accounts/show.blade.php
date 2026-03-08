@extends('layouts.app')

@section('title', $account->name)

@section('content')
  <div class="page-head row">
    <div>
      <h1>{{ $account->name }}</h1>
      <p class="muted">Current balance</p>
    </div>
    <div class="big-number">${{ number_format($account->balance, 2) }}</div>
  </div>

  <div class="grid-3">

    {{-- Deposit --}}
    <div class="card">
      <div class="card-title">Deposit</div>
      <form method="POST" action="{{ route('account.deposit', $account) }}" class="form">
        @csrf
        <div>
          <label class="label">Amount</label>
          <input class="input" type="number" name="amount" step="0.01" min="0.01" required placeholder="0.00">
        </div>
        <div>
          <label class="label">Description (optional)</label>
          <input class="input" type="text" name="description" placeholder="Paycheck...">
        </div>
        <button class="btn btn-success" type="submit">Deposit</button>
      </form>
    </div>

    {{-- Withdraw --}}
    <div class="card">
      <div class="card-title">Withdraw</div>
      <form method="POST" action="{{ route('account.withdraw', $account) }}" class="form">
        @csrf
        <div>
          <label class="label">Amount</label>
          <input class="input" type="number" name="amount" step="0.01" min="0.01" required placeholder="0.00">
        </div>
        <div>
          <label class="label">Description (optional)</label>
          <input class="input" type="text" name="description" placeholder="Groceries...">
        </div>
        <button class="btn btn-danger" type="submit">Withdraw</button>
      </form>
    </div>

    {{-- Transfer --}}
    <div class="card">
      <div class="card-title">Transfer</div>
      @if($accounts->isEmpty())
        <p class="muted text-sm">No other accounts to transfer to.</p>
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
            <label class="label">Description (optional)</label>
            <input class="input" type="text" name="description" placeholder="Rent...">
          </div>
          <button class="btn" type="submit">Transfer</button>
        </form>
      @endif
    </div>

  </div>

  {{-- Transactions --}}
  <div class="card mt">
    <div class="card-title">Transaction History</div>

    @if($transactions->isEmpty())
      <p class="muted">No transactions yet.</p>
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
                <td class="right {{ $t->type === 'credit' ? 'text-good' : 'text-bad' }} bold">
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
