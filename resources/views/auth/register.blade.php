<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>PAGEFLOWRY – Register</title>
  <link href="https://fonts.googleapis.com/css2?family=Sora:wght@300;400;500;600;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet"/>
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    :root {
      --blue: #5C97F5;
      --blue-dark: #4A84E0;
      --blue-deep: #2E5DB3;
      --soft: #EAF2FF;
      --dark: #1A2740;
      --muted: #6B7E95;
    }

    html, body {
      height: 100%; width: 100%;
      font-family: 'Sora', sans-serif;
      background: #f0f6ff;
      overflow: hidden;
    }

    /* CURSOR GLOW */
    .cursor-glow {
      width: 300px; height: 300px; border-radius: 50%;
      background: radial-gradient(circle, rgba(92,151,245,0.1) 0%, transparent 70%);
      position: fixed; pointer-events: none;
      transform: translate(-50%,-50%); z-index: 9999;
    }

    /* PAGE */
    .page {
      width: 100vw; height: 100vh;
      display: flex; align-items: center; justify-content: center;
      position: relative; overflow: hidden;
    }

    /* BG BLOBS */
    .blob { position: absolute; border-radius: 50%; pointer-events: none; }
    .blob1 { width: 600px; height: 600px; top: -180px; right: -140px; background: radial-gradient(circle, rgba(92,151,245,0.13) 0%, transparent 70%); }
    .blob2 { width: 450px; height: 450px; bottom: -140px; left: -100px; background: radial-gradient(circle, rgba(74,132,224,0.09) 0%, transparent 70%); }

    /* DOT GRID */
    .page::before {
      content: ''; position: absolute; inset: 0;
      background-image: radial-gradient(circle, rgba(92,151,245,0.12) 1px, transparent 1px);
      background-size: 30px 30px;
      opacity: 0.4;
    }

    /* CONTAINER */
    .container {
      width: 100%; max-width: 460px;
      background: rgba(255,255,255,0.95);
      backdrop-filter: blur(20px);
      border-radius: 24px;
      border: 1px solid rgba(92,151,245,0.2);
      box-shadow: 0 20px 60px rgba(92,151,245,0.15);
      padding: 40px 32px;
      position: relative; z-index: 10;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .container:hover {
      transform: translateY(-2px);
      box-shadow: 0 24px 70px rgba(92,151,245,0.18);
    }

    /* PIXAR ICON */
    .pixar-icon {
      width: 80px; height: 80px;
      margin: 0 auto 16px;
      position: relative;
      animation: float 3s ease-in-out infinite;
    }

    .pixar-icon .lamp-base {
      position: absolute; bottom: 0; left: 50%;
      transform: translateX(-50%);
      width: 60px; height: 12px;
      background: linear-gradient(135deg, #4A5568 0%, #2D3748 100%);
      border-radius: 6px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    }

    .pixar-icon .lamp-arm {
      position: absolute; bottom: 12px; left: 50%;
      transform: translateX(-50%);
      width: 8px; height: 40px;
      background: linear-gradient(135deg, #718096 0%, #4A5568 100%);
      border-radius: 4px;
    }

    .pixar-icon .lamp-head {
      position: absolute; bottom: 48px; left: 50%;
      transform: translateX(-50%);
      width: 32px; height: 32px;
      background: linear-gradient(135deg, var(--blue) 0%, var(--blue-dark) 100%);
      border-radius: 50% 50% 50% 50% / 60% 60% 40% 40%;
      box-shadow: 0 0 20px rgba(92,151,245,0.4);
      animation: glow 2s ease-in-out infinite alternate;
    }

    .pixar-icon .lamp-light {
      position: absolute; top: -8px; left: 50%;
      transform: translateX(-50%);
      width: 40px; height: 20px;
      background: radial-gradient(ellipse at center, rgba(255,255,255,0.8) 0%, transparent 70%);
      border-radius: 50%;
      animation: light-pulse 2s ease-in-out infinite alternate;
    }

    @keyframes float {
      0%, 100% { transform: translateY(0px); }
      50% { transform: translateY(-10px); }
    }

    @keyframes glow {
      0% { box-shadow: 0 0 20px rgba(92,151,245,0.4); }
      100% { box-shadow: 0 0 30px rgba(92,151,245,0.6); }
    }

    @keyframes light-pulse {
      0% { opacity: 0.6; transform: translateX(-50%) scale(1); }
      100% { opacity: 1; transform: translateX(-50%) scale(1.1); }
    }

    /* HEADER */
    .header {
      text-align: center; margin-bottom: 32px;
    }

    .logo {
      font-size: 28px; font-weight: 800;
      background: linear-gradient(135deg, var(--blue) 0%, var(--blue-deep) 100%);
      -webkit-background-clip: text; -webkit-text-fill-color: transparent;
      margin-bottom: 8px;
    }

    .subtitle {
      color: var(--muted); font-size: 15px;
      font-family: 'DM Sans', sans-serif;
    }

    /* FORM */
    .form { display: flex; flex-direction: column; gap: 20px; }

    .group {
      display: flex; flex-direction: column; gap: 8px;
    }

    input, select {
      padding: 12px 16px; border-radius: 12px;
      border: 1px solid rgba(92,151,245,0.2);
      background: rgba(255,255,255,0.8);
      font-size: 15px; font-family: 'DM Sans', sans-serif;
      transition: all 0.3s ease;
    }

    input:focus, select:focus {
      outline: none; border-color: var(--blue);
      background: white; box-shadow: 0 0 0 4px rgba(92,151,245,0.1);
    }

    /* CHECKBOX GROUP */
    .checkbox-group {
      display: flex; align-items: center; gap: 12px;
      padding: 12px 16px; border-radius: 12px;
      border: 1px solid rgba(92,151,245,0.2);
      background: rgba(255,255,255,0.8);
    }

    .checkbox-group input[type="checkbox"] {
      width: 18px; height: 18px; accent-color: var(--blue);
      margin: 0; padding: 0; border: none;
    }

    .checkbox-group label {
      margin: 0; font-size: 14px; cursor: pointer;
    }

    /* BUTTON */
    .btn {
      padding: 14px 24px; border-radius: 12px;
      border: none; font-size: 16px; font-weight: 600;
      cursor: pointer; transition: all 0.3s ease;
      font-family: 'Sora', sans-serif;
      position: relative; overflow: hidden;
    }

    .btn-primary {
      background: linear-gradient(135deg, var(--blue) 0%, var(--blue-dark) 100%);
      color: white; box-shadow: 0 4px 14px rgba(92,151,245,0.3);
    }

    .btn-primary:hover {
      transform: translateY(-1px);
      box-shadow: 0 6px 20px rgba(92,151,245,0.4);
    }

    .btn-primary:active {
      transform: translateY(0);
    }

    /* FOOTER */
    .footer {
      text-align: center; margin-top: 24px;
      font-size: 14px; color: var(--muted);
      font-family: 'DM Sans', sans-serif;
    }

    .footer a {
      color: var(--blue); text-decoration: none;
      font-weight: 500;
    }

    .footer a:hover {
      text-decoration: underline;
    }

    /* ERROR */
    .error {
      background: rgba(239, 68, 68, 0.1);
      border: 1px solid rgba(239, 68, 68, 0.2);
      color: #dc2626; padding: 12px; border-radius: 8px;
      font-size: 14px; margin-bottom: 16px;
      font-family: 'DM Sans', sans-serif;
    }

    /* RESPONSIVE */
    @media (max-width: 480px) {
      .container {
        margin: 16px; padding: 32px 24px;
      }
    }
  </style>
</head>
<body>
  <div class="page">
    <div class="blob blob1"></div>
    <div class="blob blob2"></div>
    <div class="cursor-glow"></div>

    <div class="container">
      <div class="header">
        <div class="logo-box">
          <svg viewBox="0 0 18 18" fill="none">
            <rect x="1" y="1" width="7" height="7" rx="2" fill="white"/>
            <rect x="10" y="1" width="7" height="7" rx="2" fill="white" opacity="0.5"/>
            <rect x="1" y="10" width="7" height="7" rx="2" fill="white" opacity="0.5"/>
            <rect x="10" y="10" width="7" height="7" rx="2" fill="white"/>
          </svg>
        </div>
        <div class="logo">PAGEFLOWRY</div>
        <div class="subtitle">Buat akun baru untuk memulai</div>
      </div>

      @if ($errors->any())
        <div class="error">
          @foreach ($errors->all() as $error)
            {{ $error }}<br>
          @endforeach
        </div>
      @endif

      <form class="form" method="POST" action="{{ route('register') }}">
        @csrf

        <div class="group">
          <label for="name">👤 Nama Lengkap</label>
          <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus>
        </div>

        <div class="group">
          <label for="email">📧 Email</label>
          <input type="email" id="email" name="email" value="{{ old('email') }}" required>
        </div>

        <div class="group">
          <label for="role">🎭 Role</label>
          <select id="role" name="role" required>
            <option value="">Pilih role...</option>
            <option value="creator" {{ old('role') == 'creator' ? 'selected' : '' }}>Creator</option>
            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
          </select>
        </div>

        <div class="group">
          <label for="password">🔒 Password</label>
          <input type="password" id="password" name="password" required>
        </div>

        <div class="group">
          <label for="password_confirmation">🛡️ Konfirmasi Password</label>
          <input type="password" id="password_confirmation" name="password_confirmation" required>
        </div>

        <button type="submit" class="btn btn-primary">✨ Daftar Sekarang</button>
      </form>

      <div class="footer">
        Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a>
      </div>
    </div>
  </div>

  <script>
    // Cursor glow effect
    const glow = document.querySelector('.cursor-glow');
    document.addEventListener('mousemove', (e) => {
      glow.style.left = e.clientX + 'px';
      glow.style.top = e.clientY + 'px';
    });
  </script>
</body>
</html>
