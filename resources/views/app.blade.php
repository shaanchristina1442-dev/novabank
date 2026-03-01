<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>@yield('title', 'NovaBank')</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
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

  <main class="container">
    @yield('content')
    
  </main>

</body>
</html>

     
