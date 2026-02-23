<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>@yield('title', 'NovaBank')</title>
  <link rel="stylesheet" href="{{ asset('css/novabank.css') }}">
</head>
<body>

    <header class="topbar">
    <div class="container topbar-inner">
      <a class="brand" href="{{ route('dashboard') }}">
        <div class="logo"></div>
        <div>NovaBank</div>
      </a>

      <nav class="nav">
        <a href="{{ route('dashboard') }}" class="pill">Dashboard</a>
        <a href="{{ route('accounts.index') }}">Accounts</a>

        
      </nav>
    </div>
  </header>

  <main class="main">
    <div class="container">

      @if(session('success'))
        <div class="flash success">{{ session('success') }}</div>
      @endif

      @if(session('error'))
        <div class="flash error">{{ session('error') }}</div>
      @endif

      @yield('content')
    </div>
  </main>

</body>
</html>

     
