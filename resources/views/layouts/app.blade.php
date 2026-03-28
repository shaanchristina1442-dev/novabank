<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', 'NovaBank')</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

<div class="shell">

  {{-- ── Sidebar ── --}}
  <aside class="sidebar">
    <div class="sidebar-brand">
      <div class="brand-icon">N</div>
      <div>
        <div class="brand-name">NovaBank</div>
        <div class="brand-tagline">Online Banking</div>
      </div>
    </div>

    <div class="sidebar-section">
      <div class="sidebar-section-label">Main Menu</div>

      <a href="{{ route('dashboard') }}"
         class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
        <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
        </svg>
        Dashboard
      </a>

      <a href="{{ route('accounts.index') }}"
         class="nav-item {{ request()->routeIs('accounts.*') || request()->routeIs('account.*') ? 'active' : '' }}">
        <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
        </svg>
        Accounts
      </a>

      <a href="{{ route('payment.index') }}"
         class="nav-item {{ request()->routeIs('payment.*') ? 'active' : '' }}">
        <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
        </svg>
        Payments
      </a>

      <a href="{{ route('creditCard.index') }}"
         class="nav-item {{ request()->routeIs('creditCard.*') ? 'active' : '' }}">
        <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
        </svg>
        Credit Cards
      </a>
    </div>

    <div class="sidebar-footer">
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="nav-item" style="width:100%;">
          <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
          </svg>
          Sign Out
        </button>
      </form>
    </div>
  </aside>

  {{-- ── Main ── --}}
  <div class="main-wrap">

    <header class="topbar">
      <div class="topbar-inner">
        <div class="topbar-title">@yield('title', 'NovaBank')</div>
        <div class="topbar-user">
          <span>{{ Auth::user()->name }}</span>
          <div class="topbar-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
        </div>
      </div>
    </header>

    <main class="content">

      @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
      @endif

      @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
      @endif

      @if ($errors->any())
        <div class="alert alert-danger">
          <ul style="margin:0;padding-left:18px;">
            @foreach ($errors->all() as $err)
              <li>{{ $err }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      @yield('content')
    </main>

  </div>
</div>

</body>
</html>
