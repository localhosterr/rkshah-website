<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Admin Login — RK Shah CMS</title>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700;800;900&family=Poppins:wght@400;500&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/cms.css') }}">
</head>
<body>

<div class="login-page">
  <div class="login-card">

    <div class="login-card__logo">
      <div class="login-card__logo-icon">RK</div>
      <h1 class="login-card__title">RK Shah CMS</h1>
      <p class="login-card__sub">Sign in to your admin dashboard</p>
    </div>

    @if($errors->any())
    <div style="background:#FEE2E2;border:1px solid #FCA5A5;border-radius:var(--r);padding:12px 14px;margin-bottom:16px;font-size:13px;color:#991B1B;font-family:var(--ff-h)">
      {{ $errors->first() }}
    </div>
    @endif

    @if(session('error'))
    <div style="background:#FEE2E2;border:1px solid #FCA5A5;border-radius:var(--r);padding:12px 14px;margin-bottom:16px;font-size:13px;color:#991B1B;font-family:var(--ff-h)">
      {{ session('error') }}
    </div>
    @endif

    <form action="{{ route('cms.login.post') }}" method="POST">
      @csrf
      <div class="form-group">
        <label class="form-label">Email Address</label>
        <input class="form-input" type="email" name="email"
               value="{{ old('email') }}"
               placeholder="admin@rkshahcarrental.com"
               required autofocus>
      </div>
      <div class="form-group">
        <label class="form-label">Password</label>
        <input class="form-input" type="password" name="password"
               placeholder="Enter your password"
               required>
      </div>
      <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px">
        <label style="display:flex;align-items:center;gap:6px;cursor:pointer;font-size:13px;color:var(--t3)">
          <input type="checkbox" name="remember" style="width:14px;height:14px">
          Remember me
        </label>
      </div>
      <button type="submit" class="btn btn--primary btn--full" style="padding:12px">
        🔐 Sign In to Dashboard
      </button>
    </form>

    <div style="text-align:center;margin-top:24px;font-size:12px;color:var(--t4)">
      RK Shah Car Rental · Soniya Vihar, Delhi
    </div>

  </div>
</div>

</body>
</html>
