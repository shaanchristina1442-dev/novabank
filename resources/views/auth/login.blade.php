<x-guest-layout>

  <x-auth-session-status class="mb-4" :status="session('status')" />

  <div style="margin-bottom:28px;">
    <h1 style="font-size:1.7rem;font-weight:800;color:var(--text);margin:0 0 6px;letter-spacing:-.4px;">Welcome back</h1>
    <p style="color:var(--muted);font-size:.9rem;margin:0;">Sign in to your NovaBank account</p>
  </div>

  @if($errors->any())
    <div class="alert alert-danger" style="margin-bottom:20px;">
      @foreach($errors->all() as $error)
        <div>{{ $error }}</div>
      @endforeach
    </div>
  @endif

  <form method="POST" action="{{ route('login') }}" class="form">
    @csrf

    <div>
      <label class="label" for="email">Email Address</label>
      <input class="input" id="email" type="email" name="email"
        value="{{ old('email') }}" required autofocus autocomplete="username"
        placeholder="you@example.com">
    </div>

    <div>
      <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:6px;">
        <label class="label" for="password" style="margin:0;">Password</label>
        @if (Route::has('password.request'))
          <a href="{{ route('password.request') }}" class="link" style="font-size:.8rem;">Forgot password?</a>
        @endif
      </div>
      <input class="input" id="password" type="password" name="password"
        required autocomplete="current-password" placeholder="••••••••">
    </div>

    <div style="display:flex;align-items:center;gap:8px;">
      <input id="remember_me" type="checkbox" name="remember"
        style="width:15px;height:15px;accent-color:var(--brand);cursor:pointer;">
      <label for="remember_me" style="font-size:.875rem;color:var(--muted);cursor:pointer;">Remember me for 30 days</label>
    </div>

    <button type="submit" class="btn btn-lg" style="width:100%;margin-top:4px;">
      Sign In to NovaBank
    </button>

  </form>

  <p style="text-align:center;margin-top:24px;font-size:.875rem;color:var(--muted);">
    Don't have an account?
    <a href="{{ route('register') }}" class="link" style="font-weight:600;">Create one</a>
  </p>

</x-guest-layout>
