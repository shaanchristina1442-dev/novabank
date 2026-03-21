@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="page">

  <div class="page-head">
    <div>
      <h1 class="h1">Good morning, {{ Auth::user()->name }}</h1>
      <p class="sub">Here's an overview of your accounts and recent activity.</p>
    </div>
    <div class="head-actions">
      <a class="btn btn-ghost" href="{{ route('accounts.index') }}">View Accounts</a>
      <a class="btn btn-primary" href="{{ route('payment.create') }}">New Payment</a>
    </div>
  </div>

  {{-- Balance Hero --}}
  <div class="balance-hero">
    <div class="balance-hero-label">Total Balance</div>
    <div class="balance-hero-amount">${{ number_format($totalBalance ?? 0, 2) }}</div>
    <div class="balance-hero-sub">Across {{ $accountsCount ?? 0 }} {{ Str::plural('account', $accountsCount ?? 0) }}</div>
  </div>

  {{-- Stat Cards --}}
  <div class="cards">
    <div class="card stat">
      <div class="stat-label">Accounts</div>
      <div class="stat-value">{{ $accountsCount ?? 0 }}</div>
      <div class="stat-meta">Checking &amp; savings</div>
    </div>
    <div class="card stat">
      <div class="stat-label">Recent Activity</div>
      <div class="stat-value">{{ $recentCount ?? 0 }}</div>
      <div class="stat-meta">Latest transactions</div>
    </div>
    <div class="card stat">
      <div class="stat-label">Total Balance</div>
      <div class="stat-value">${{ number_format($totalBalance ?? 0, 2) }}</div>
      <div class="stat-meta">All accounts combined</div>
    </div>
  </div>

  <div class="grid-2">

    {{-- Quick Actions --}}
    <div class="card">
      <div class="card-head">
        <h2 class="h2">Quick Actions</h2>
        <span class="pill pill-orange">Fast access</span>
      </div>
      <div class="quick">
        <a class="quick-item" href="{{ route('accounts.index') }}">
          <div class="quick-title">Deposit</div>
          <div class="quick-sub">Add funds to an account</div>
        </a>
        <a class="quick-item" href="{{ route('accounts.index') }}">
          <div class="quick-title">Withdraw</div>
          <div class="quick-sub">Record a withdrawal</div>
        </a>
        <a class="quick-item" href="{{ route('accounts.index') }}">
          <div class="quick-title">Transfer</div>
          <div class="quick-sub">Move money between accounts</div>
        </a>
        <a class="quick-item" href="{{ route('payment.create') }}">
          <div class="quick-title">Pay Someone</div>
          <div class="quick-sub">Send a new payment</div>
        </a>
      </div>
    </div>

    {{-- Recent Activity --}}
    <div class="card">
      <div class="card-head">
        <h2 class="h2">Recent Activity</h2>
        <a class="link" href="{{ route('accounts.index') }}">See all →</a>
      </div>
      <div class="table-wrap">
        <table class="table">
          <thead>
            <tr>
              <th>Description</th>
              <th>Type</th>
              <th class="right">Amount</th>
              <th class="right">Date</th>
            </tr>
          </thead>
          <tbody>
            @forelse($recentTransactions as $t)
              <tr>
                <td>{{ $t->description ?? '—' }}</td>
                <td>
                  <span class="pill {{ $t->type === 'credit' ? 'pill-green' : 'pill-red' }}">
                    {{ ucfirst($t->type) }}
                  </span>
                </td>
                <td class="right bold {{ $t->type === 'credit' ? 'text-good' : 'text-bad' }}">
                  {{ $t->type === 'credit' ? '+' : '-' }}${{ number_format($t->amount, 2) }}
                </td>
                <td class="right muted text-sm">{{ $t->created_at->format('M d, Y') }}</td>
              </tr>
            @empty
              <tr>
                <td colspan="4" style="text-align:center;padding:28px;" class="muted">No transactions yet.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>

  </div>
</div>
@endsection
