@extends('layouts.app')
@section('title', 'NovaBank — Accounts')

@section('content')
  <div class="card">
    <div class="card-header">
      <div>
        <h1 class="h1">Accounts</h1>
        <div class="muted">Create accounts and manage balances</div>
      </div>

      {{-- If you later add "create account" form, link it here --}}
      {{-- <a class="btn btn-primary" href="{{ route('accounts.create') }}">New Account</a> --}}
    </div>

    <div class="accounts">
      @forelse($accounts as $account)
        <div class="account">
          <div class="account-top">
            <div>
              <div class="h2">{{ $account->name }}</div>
              <div class="muted">Account #{{ $account->id }}</div>
            </div>
            <span class="badge">Balance</span>
          </div>

          <div class="money">${{ number_format($account->balance, 2) }}</div>

          <div class="btnrow">
            <a class="btn" href="{{ route('accounts.show', $account->id) }}">Open</a>
          </div>
        </div>
      @empty
        <div class="muted">No accounts found.</div>
      @endforelse
    </div>
  </div>
@endsection