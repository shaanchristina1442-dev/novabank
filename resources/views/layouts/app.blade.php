<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', 'NovaBank')</title>

  {{-- Your CSS in public/css/novabank.css --}}
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

  <div class="topbar">
    <div class="brand">NovaBank</div>
    <div class="nav">
      <a href="{{ route('dashboard') }}">Dashboard</a>
      <a href="{{ route('accounts.index') }}">Accounts</a>

      <form method="POST" action="{{ route('logout') }}" style="display:inline;">
        @csrf
        <button type="submit" class="linklike">Logout</button>
      </form>
    </div>
  </div>

  <main class="container">
    @if (session('success'))
      <div class="alert success">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
      <div class="alert danger">
        <ul>
          @foreach ($errors->all() as $err)
            <li>{{ $err }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    @yield('content')
  </main>

</body>
</html>
