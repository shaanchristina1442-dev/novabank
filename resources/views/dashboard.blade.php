@extends('layouts.app') 

 

@section('title', 'Dashboard') 

 

@section('content') 

<div class="page"> 

  <div class="page-head"> 

    <div> 

      <h1 class="h1">NovaBank Dashboard</h1> 

      <p class="sub">Overview of your accounts and recent activity</p> 

    </div> 

 

    <div class="head-actions"> 

      <a class="btn btn-ghost" href="{{ route('accounts.index') }}">View Accounts</a> 

      <a class="btn btn-primary" href="{{ route('accounts.index') }}">New Transaction</a> 

    </div> 

  </div> 

 

  {{-- STAT CARDS --}} 

  <div class="cards"> 

    <div class="card stat"> 

      <div class="stat-label">Total Balance</div> 

      <div class="stat-value">${{ number_format($totalBalance ?? 0, 2) }}</div> 

      <div class="stat-meta">Across all accounts</div> 

    </div> 

 

    <div class="card stat"> 

      <div class="stat-label">Accounts</div> 

      <div class="stat-value">{{ $accountsCount ?? 0 }}</div> 

      <div class="stat-meta">Checking + Savings</div> 

    </div> 

 

    <div class="card stat"> 

      <div class="stat-label">Recent Transactions</div> 

      <div class="stat-value">{{ $recentCount ?? 0 }}</div> 

      <div class="stat-meta">Last 30 days</div> 

    </div> 

  </div> 

 

  <div class="grid-2"> 

    {{-- QUICK ACTIONS --}} 

    <div class="card"> 

      <div class="card-head"> 

        <h2 class="h2">Quick Actions</h2> 

        <span class="pill">Fast</span> 

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

 

        <a class="quick-item" href="{{ route('accounts.index') }}"> 

          <div class="quick-title">Statements</div> 

          <div class="quick-sub">See recent history</div> 

        </a> 

      </div> 

    </div> 

 

    {{-- RECENT ACTIVITY --}} 

    <div class="card"> 

      <div class="card-head"> 

        <h2 class="h2">Recent Activity</h2> 

        <a class="link" href="{{ route('accounts.index') }}">See all</a> 

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

            @forelse(($recentTransactions ?? []) as $t) 

              <tr> 

                <td class="mono">{{ $t->description }}</td> 

                <td> 

                  <span class="badge {{ $t->type === 'credit' ? 'badge-green' : 'badge-red' }}"> 

                    {{ strtoupper($t->type) }} 

                  </span> 

                </td> 

                <td class="right {{ $t->type === 'credit' ? 'pos' : 'neg' }}"> 

                  {{ $t->type === 'credit' ? '+' : '-' }}${{ number_format(abs($t->amount), 2) }} 

                </td> 

                <td class="right muted">{{ optional($t->created_at)->format('M d') }}</td> 

              </tr> 

            @empty 

              <tr> 

                <td colspan="4" class="muted">No transactions yet.</td> 

              </tr> 

            @endforelse 

          </tbody> 

        </table> 

      </div> 

    </div> 

  </div> 

</div> 

@endsection 