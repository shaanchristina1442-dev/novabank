@extends('layouts.app')
@section('title', 'Accounts')

@section('content')
<div class="page">

  <div class="page-head">
    <div>
      <h1 class="h1">Accounts</h1>
      <p class="sub">Manage your checking and savings accounts</p>
    </div>
  </div>

  <div class="accounts">
    @forelse($accounts as $account)
      <div class="account">
        <div class="account-top">
          <div>
            <div class="h2">{{ $account->name }}</div>
            <div class="account-number">Acct ●●●● {{ str_pad($account->id, 4, '0', STR_PAD_LEFT) }}</div>
          </div>
          <span class="badge">Active</span>
        </div>

        <div class="muted text-xs" style="margin-bottom:4px;">Available Balance</div>
        <div class="money">${{ number_format($account->balance, 2) }}</div>

        <div class="btnrow">
          <a class="btn" href="{{ route('accounts.show', $account->id) }}">Open Account</a>
          <a class="btn btn-ghost btn-sm" href="{{ route('accounts.show', $account->id) }}">Transactions</a>
        </div>
      </div>
    @empty
      <div class="muted" style="padding:24px 0;">No accounts found.</div>
    @endforelse
  </div>

</div>
@endsection
