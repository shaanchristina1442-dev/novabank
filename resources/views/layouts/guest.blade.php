<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ config('app.name', 'NovaBank') }}</title>
  <link rel="preconnect" href="https://fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body style="margin:0;min-height:100vh;display:flex;background:var(--bg);">

  {{-- Left panel --}}
  <div id="left-panel" style="display:none;flex:1;background:#111827;padding:56px 52px;flex-direction:column;justify-content:space-between;position:relative;overflow:hidden;">
    {{-- Glow orbs --}}
    <div style="position:absolute;top:-100px;right:-100px;width:420px;height:420px;border-radius:50%;background:radial-gradient(circle,rgba(249,115,22,.18) 0%,transparent 70%);pointer-events:none;"></div>
    <div style="position:absolute;bottom:-120px;left:-80px;width:480px;height:480px;border-radius:50%;background:radial-gradient(circle,rgba(249,115,22,.08) 0%,transparent 70%);pointer-events:none;"></div>

    {{-- Brand --}}
    <div style="position:relative;display:flex;align-items:center;gap:13px;">
      <div class="brand-icon">N</div>
      <div>
        <div class="brand-name">NovaBank</div>
        <div class="brand-tagline">Online Banking</div>
      </div>
    </div>

    {{-- Hero text --}}
    <div style="position:relative;">
      <div style="font-size:2.5rem;font-weight:800;color:#fff;line-height:1.15;letter-spacing:-.5px;margin-bottom:16px;">
        Your money,<br>your control.
      </div>
      <p style="color:rgba(255,255,255,.5);font-size:.95rem;line-height:1.7;max-width:340px;">
        Manage accounts, send payments, and track every transaction — all in one secure place.
      </p>

      {{-- Mock card --}}
      <div style="margin-top:40px;background:linear-gradient(135deg,#f97316 0%,#ea6c0a 100%);border-radius:16px;padding:24px 26px;max-width:320px;box-shadow:0 8px 32px rgba(249,115,22,.4);">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:28px;">
          <div style="color:#fff;font-weight:700;font-size:.95rem;opacity:.9;">NovaBank</div>
          <div style="width:36px;height:24px;border-radius:4px;background:rgba(255,255,255,.25);"></div>
        </div>
        <div style="color:#fff;font-size:1.2rem;letter-spacing:4px;font-weight:500;margin-bottom:22px;">•••• •••• •••• 4821</div>
        <div style="display:flex;justify-content:space-between;">
          <div>
            <div style="color:rgba(255,255,255,.6);font-size:.65rem;text-transform:uppercase;letter-spacing:.8px;margin-bottom:2px;">Total Balance</div>
            <div style="color:#fff;font-weight:700;font-size:1rem;">$24,381.00</div>
          </div>
          <div style="text-align:right;">
            <div style="color:rgba(255,255,255,.6);font-size:.65rem;text-transform:uppercase;letter-spacing:.8px;margin-bottom:2px;">Cardholder</div>
            <div style="color:#fff;font-weight:600;font-size:.9rem;">John Smith</div>
          </div>
        </div>
      </div>
    </div>

    <div style="position:relative;color:rgba(255,255,255,.3);font-size:.78rem;">
      © {{ date('Y') }} NovaBank. All rights reserved.
    </div>
  </div>

  {{-- Right panel --}}
  <div style="flex:1;display:flex;align-items:center;justify-content:center;padding:40px 24px;">
    <div style="width:100%;max-width:420px;">

      {{-- Mobile brand --}}
      <div style="display:flex;align-items:center;gap:12px;margin-bottom:40px;" id="mobile-brand">
        <div class="brand-icon">N</div>
        <div>
          <div class="brand-name" style="color:var(--text);">NovaBank</div>
          <div class="brand-tagline" style="color:var(--muted);">Online Banking</div>
        </div>
      </div>

      {{ $slot }}

    </div>
  </div>

  <style>
    @media(min-width:900px){
      #left-panel   { display:flex !important; }
      #mobile-brand { display:none !important; }
    }
  </style>

</body>
</html>
