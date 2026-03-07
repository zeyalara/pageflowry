<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>PAGEFLOWRY – Login</title>
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
      background-size: 28px 28px; pointer-events: none;
      mask-image: radial-gradient(ellipse 80% 80% at 50% 50%, black 30%, transparent 100%);
    }

    /* MAIN CARD — full width layout */
    .card {
      position: relative; z-index: 10;
      width: min(1040px, 96vw);
      height: min(620px, 94vh);
      background: #fff;
      border-radius: 32px;
      display: flex; overflow: hidden;
      box-shadow: 0 32px 80px rgba(92,151,245,0.16), 0 8px 24px rgba(0,0,0,0.05);
      animation: slideUp 0.65s cubic-bezier(0.34,1.56,0.64,1) forwards;
      opacity: 0; transform: translateY(40px);
    }
    @keyframes slideUp { to { opacity:1; transform:translateY(0); } }

    /* ══════════════════════════
       LEFT — FORM PANEL
    ══════════════════════════ */
    .form-panel {
      flex: 0 0 400px;
      padding: 36px 40px;
      display: flex; flex-direction: column;
      overflow-y: auto;
    }
    .form-panel::-webkit-scrollbar { display: none; }

    /* Logo */
    .logo-row {
      display: flex; align-items: center; gap: 10px;
      margin-bottom: 24px; flex-shrink: 0;
    }
    .logo-box {
      width: 32px; height: 32px; border-radius: 8px;
      background: linear-gradient(135deg, var(--blue), var(--blue-deep));
      display: flex; align-items: center; justify-content: center;
    }
    .logo-box svg { width: 15px; height: 15px; }
    .logo-text { font-size: 1rem; font-weight: 800; color: var(--blue); letter-spacing: -0.5px; }
    .logo-text em { color: var(--dark); font-style: normal; }

    /* Tabs */
    .tabs {
      display: flex; background: var(--soft);
      border-radius: 11px; padding: 4px;
      margin-bottom: 22px; flex-shrink: 0;
    }
    .tab {
      flex: 1; text-align: center; padding: 9px;
      border-radius: 8px; font-size: 0.85rem; font-weight: 600;
      cursor: pointer; transition: all 0.25s;
      color: var(--muted); border: none; background: none;
      font-family: 'Sora', sans-serif;
    }
    .tab.active {
      background: #fff; color: var(--dark);
      box-shadow: 0 2px 12px rgba(92,151,245,0.14);
    }

    /* Form sections */
    .form-section { display: none; flex-direction: column; gap: 0; }
    .form-section.active { display: flex; }

    .form-title { font-size: 1.45rem; font-weight: 800; color: var(--dark); letter-spacing: -0.8px; margin-bottom: 4px; }
    .form-sub { font-family: 'DM Sans', sans-serif; font-size: 0.83rem; color: var(--muted); margin-bottom: 20px; }

    /* Fields */
    .field { margin-bottom: 13px; }

    .field label {
      display: flex;
      align-items: center;
      font-size: 0.81rem; font-weight: 600; color: var(--dark);
      margin-bottom: 6px;
    }
    .field-row { display: flex; justify-content: space-between; align-items: center; margin-bottom: 5px; }
    .field-row label { margin-bottom: 0; }
    .input-wrap { position: relative; }
    .input-ico { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); font-size: 0.9rem; pointer-events: none; }
    .field input {
      width: 100%; padding: 10px 12px 10px 38px;
      border: 1.5px solid rgba(92,151,245,0.18);
      border-radius: 11px; font-size: 0.85rem;
      font-family: 'Sora', sans-serif; color: var(--dark);
      background: var(--soft); transition: all 0.25s; outline: none;
    }
    .field input:focus {
      border-color: var(--blue); background: #fff;
      box-shadow: 0 0 0 4px rgba(92,151,245,0.1);
    }
    .field input::placeholder { color: #b8cef0; }

    .forgot { font-size: 0.73rem; color: var(--blue); font-weight: 600; text-decoration: none; transition: opacity 0.2s; white-space: nowrap; }
    .forgot:hover { opacity: 0.7; }

    /* Role selector */
    .role-row { display: flex; gap: 8px; margin-bottom: 13px; }
    .role-opt {
      flex: 1; display: flex; align-items: center; gap: 7px;
      padding: 9px 12px;
      border: 1.5px solid rgba(92,151,245,0.18);
      border-radius: 11px; cursor: pointer;
      transition: all 0.2s; background: var(--soft);
    }
    .role-opt input[type="radio"] { display: none; }
    .role-opt.selected { border-color: var(--blue); background: #fff; box-shadow: 0 0 0 3px rgba(92,151,245,0.1); }
    .role-ico { font-size: 1rem; }
    .role-name { font-size: 0.78rem; font-weight: 600; color: var(--dark); }

    /* Submit */
    .btn-submit {
      width: 100%; padding: 12px;
      background: linear-gradient(135deg, var(--blue), var(--blue-deep));
      color: #fff; border: none; border-radius: 12px;
      font-family: 'Sora', sans-serif; font-size: 0.88rem; font-weight: 700;
      cursor: pointer; transition: all 0.3s;
      box-shadow: 0 8px 24px rgba(92,151,245,0.32);
      margin-top: 4px;
      display: flex; align-items: center; justify-content: center; gap: 8px;
    }
    .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 14px 32px rgba(92,151,245,0.42); }
    .btn-submit:active { transform: translateY(0); }
    .btn-submit:disabled { opacity: 0.7; cursor: not-allowed; transform: none; }

    .spinner { width: 15px; height: 15px; border: 2px solid rgba(255,255,255,0.35); border-top-color: #fff; border-radius: 50%; animation: spin 0.7s linear infinite; display: none; }
    @keyframes spin { to { transform: rotate(360deg); } }

    .msg { display: none; padding: 9px 12px; border-radius: 10px; font-size: 0.76rem; font-weight: 600; margin-bottom: 12px; align-items: center; gap: 8px; }
    .msg.error { background: #FFF0F0; color: #E53E3E; border: 1px solid rgba(229,62,62,0.18); }
    .msg.success { background: #F0FFF4; color: #38A169; border: 1px solid rgba(56,161,105,0.18); }

    .pass-note { font-family: 'DM Sans', sans-serif; font-size: 0.7rem; color: var(--muted); margin-top: 3px; padding-left: 2px; }

    /* ══════════════════════════
       RIGHT — VISUAL PANEL
    ══════════════════════════ */
    .visual-panel {
      flex: 1;
      background: var(--soft);
      display: flex; flex-direction: column;
      align-items: center; justify-content: space-between;
      position: relative; overflow: hidden;
      padding: 28px 28px 24px;
    }

    /* Subtle bg circles */
    .vc { position: absolute; border-radius: 50%; background: rgba(92,151,245,0.06); pointer-events: none; }
    .vc1 { width: 280px; height: 280px; top: -80px; right: -70px; }
    .vc2 { width: 200px; height: 200px; bottom: -60px; left: -50px; }

    /* Top: title + desc */
    .vis-top { text-align: center; flex-shrink: 0; position: relative; z-index: 1; }
    .vis-title { font-size: 1.2rem; font-weight: 800; color: var(--dark); letter-spacing: -0.5px; margin-bottom: 6px; transition: all 0.3s ease; }
    .vis-desc { font-family: 'DM Sans', sans-serif; font-size: 0.8rem; color: var(--muted); line-height: 1.65; max-width: 320px; margin: 0 auto; transition: all 0.3s ease; }

    /* Middle: photo — fills available space */
    .vis-photo-wrap {
      flex: 1; display: flex; align-items: center; justify-content: center;
      position: relative; z-index: 1; width: 100%;
      min-height: 0;
    }
    .vis-photo {
      max-height: 220px; max-width: 100%;
      object-fit: contain;
      animation: imgFloat 4s ease-in-out infinite alternate;
      filter: drop-shadow(0 16px 32px rgba(92,151,245,0.18));
    }
    @keyframes imgFloat {
      0%   { transform: translateY(0) scale(1); }
      100% { transform: translateY(-12px) scale(1.04); }
    }
    .vis-fallback {
      font-size: 5rem;
      animation: imgFloat 4s ease-in-out infinite alternate;
      display: none;
    }

    /* Bottom: status grid — 2x2 */
    .vis-bottom { flex-shrink: 0; width: 100%; position: relative; z-index: 1; }
    .status-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 8px;
    }
    .sc {
      background: #fff;
      border: 1px solid rgba(92,151,245,0.12);
      border-radius: 14px; padding: 10px 12px;
      display: flex; align-items: center; gap: 10px;
      box-shadow: 0 2px 10px rgba(92,151,245,0.07);
      cursor: default;
      transition: transform 0.22s cubic-bezier(0.34,1.56,0.64,1),
                  box-shadow 0.22s ease,
                  border-color 0.22s ease;
      animation: scIn 0.5s ease both;
      animation-delay: var(--d);
    }
    .sc:hover {
      transform: translateY(-4px) scale(1.02);
      box-shadow: 0 10px 28px rgba(92,151,245,0.18);
      border-color: rgba(92,151,245,0.3);
    }
    @keyframes scIn {
      from { opacity: 0; transform: translateY(14px); }
      to   { opacity: 1; transform: translateY(0); }
    }
    .sc-icon { font-size: 1.4rem; flex-shrink: 0; line-height: 1; }
    .sc-title { font-size: 0.76rem; font-weight: 700; color: var(--dark); margin-bottom: 1px; }
    .sc-sub { font-size: 0.66rem; color: var(--muted); font-family: 'DM Sans', sans-serif; line-height: 1.3; }

    /* Active/pulse on hover per card */
    .sc:nth-child(1):hover { background: #FFFBEB; border-color: #F6C90E44; }
    .sc:nth-child(2):hover { background: #EFF6FF; border-color: rgba(92,151,245,0.3); }
    .sc:nth-child(3):hover { background: #F0FFF4; border-color: #38A16944; }
    .sc:nth-child(4):hover { background: #FAF5FF; border-color: #9F7AEA44; }

    @media (max-width: 820px) {
      .visual-panel { display: none; }
      .form-panel { flex: 1; }
      html, body { overflow: auto; }
      .card { height: auto; min-height: 100vh; border-radius: 0; }
    }
  </style>
</head>
<body>

<div class="cursor-glow" id="cg"></div>

<div class="page">
  <div class="blob blob1"></div>
  <div class="blob blob2"></div>

  <div class="card">

    <!-- ── LEFT: FORM ── -->
    <div class="form-panel">

      <div class="logo-row">
        <div class="logo-box">
          <svg viewBox="0 0 18 18" fill="none">
            <rect x="1" y="1" width="7" height="7" rx="2" fill="white"/>
            <rect x="10" y="1" width="7" height="7" rx="2" fill="white" opacity="0.5"/>
            <rect x="1" y="10" width="7" height="7" rx="2" fill="white" opacity="0.5"/>
            <rect x="10" y="10" width="7" height="7" rx="2" fill="white"/>
          </svg>
        </div>
        <span class="logo-text">PAGE<em>FLOWRY</em></span>
      </div>

      <div class="tabs">
        <button class="tab active" id="tab-login" onclick="switchTab('login')">🔐 Masuk</button>
        <button class="tab" id="tab-register" onclick="switchTab('register')">✨ Daftar</button>
      </div>

      <!-- MASUK -->
      <div class="form-section active" id="form-login">
        <div class="form-title">Selamat datang</div>
        <div class="form-sub">Masuk ke sistem PAGEFLOWRY</div>
        <div class="msg" id="msg-login"></div>
        <form method="POST" action="{{ route('login') }}" id="fLogin">
          @csrf
          <div class="field">
            <label>📧 Email</label>
            <div class="input-wrap">
              <span class="input-ico">✉️</span>
              <input type="email" name="email" placeholder="email@pageflowry.com" value="{{ old('email') }}" required autocomplete="email"/>
            </div>
          </div>
          <div class="field">
            <div class="field-row">
              <label>🔒 Password</label>
              <a href="{{ route('password.request') }}" class="forgot">Lupa password?</a>
            </div>
            <div class="input-wrap">
              <span class="input-ico">🔑</span>
              <input type="password" name="password" placeholder="••••••••" required autocomplete="current-password"/>
            </div>
          </div>
          <button type="submit" class="btn-submit" id="btnLogin">
            <div class="spinner" id="spLogin"></div>
            <span id="txtLogin">🚀 Masuk ke Sistem</span>
          </button>
        </form>
      </div>

      <!-- DAFTAR -->
      <div class="form-section" id="form-register">
        <div class="form-title">Buat akun baru ✨</div>
        <div class="form-sub">Daftar dan mulai kelola sistem PAGEFLOWRY</div>
        <div class="msg" id="msg-register"></div>
        <form method="POST" action="{{ route('register') }}" id="fRegister">
          @csrf
          <div class="field">
            <label>👤 Nama Lengkap</label>
            <div class="input-wrap">
              <span class="input-ico">🙍</span>
              <input type="text" name="name" placeholder="Nama lengkap kamu" value="{{ old('name') }}" required maxlength="100"/>
            </div>
          </div>
          <div class="field">
            <label>📧 Email</label>
            <div class="input-wrap">
              <span class="input-ico">✉️</span>
              <input type="email" name="email" placeholder="email@pageflowry.com" value="{{ old('email') }}" required/>
            </div>
          </div>
          <div class="field">
            <label>🔒 Password</label>
            <div class="input-wrap">
              <span class="input-ico">🔑</span>
              <input type="password" name="password" placeholder="Minimal 8 karakter" required minlength="8"/>
            </div>
            <div class="pass-note">💡 Kombinasi huruf dan angka</div>
          </div>
          <div class="field">
            <label>🛡️ Konfirmasi Password</label>
            <div class="input-wrap">
              <span class="input-ico">🛡️</span>
              <input type="password" name="password_confirmation" placeholder="Ulangi password kamu" required minlength="8"/>
            </div>
          </div>
          <div class="field">
            <label>👑 Role</label>
            <div class="role-row">
              <label class="role-opt selected" id="r-admin">
                <input type="radio" name="role" value="admin" checked/>
                <span class="role-ico">👑</span>
                <span class="role-name">Admin</span>
              </label>
            </div>
          </div>
          <button type="submit" class="btn-submit" id="btnReg">
            <div class="spinner" id="spReg"></div>
            <span id="txtReg">✨ Buat Akun Sekarang</span>
          </button>
        </form>
      </div>

    </div><!-- /form-panel -->

    <!-- ── RIGHT: VISUAL ── -->
    <div class="visual-panel">
      <div class="vc vc1"></div>
      <div class="vc vc2"></div>

      <!-- TOP: title + desc -->
      <div class="vis-top">
        <div class="vis-title" id="vTitle">Workflow Profesional</div>
        <div class="vis-desc" id="vDesc">Kelola seluruh proses konten dari ide hingga publish dalam satu sistem yang terstruktur dan terintegrasi.</div>
      </div>

      <!-- MIDDLE: photo -->
      <div class="vis-photo-wrap">
        {{-- Taruh di: public/images/login1.jpg --}}
        <img
          class="vis-photo"
          id="visPhoto"
          src="{{ asset('images/login1.png') }}"
          alt="PAGEFLOWRY"
          onerror="this.style.display='none'; document.getElementById('visFallback').style.display='block';"
        />
        <div class="vis-fallback" id="visFallback">📋</div>
      </div>

      <!-- BOTTOM: 2x2 status grid -->
      <div class="vis-bottom">
        <div class="status-grid" id="statusGrid">
          <div class="sc" style="--d:0s">
            <span class="sc-icon">🟡</span>
            <div>
              <div class="sc-title">In Production</div>
              <div class="sc-sub">Konten sedang diproduksi</div>
            </div>
          </div>
          <div class="sc" style="--d:0.1s">
            <span class="sc-icon">🔄</span>
            <div>
              <div class="sc-title">Revision</div>
              <div class="sc-sub">Admin beri catatan revisi</div>
            </div>
          </div>
          <div class="sc" style="--d:0.2s">
            <span class="sc-icon">✅</span>
            <div>
              <div class="sc-title">Approved</div>
              <div class="sc-sub">Konten siap dipublish</div>
            </div>
          </div>
          <div class="sc" style="--d:0.3s">
            <span class="sc-icon">🚀</span>
            <div>
              <div class="sc-title">Published</div>
              <div class="sc-sub">Konten sudah tayang</div>
            </div>
          </div>
        </div>
      </div>

    </div><!-- /visual-panel -->

  </div><!-- /card -->
</div><!-- /page -->

<script>
  // Cursor glow
  const cg = document.getElementById('cg');
  document.addEventListener('mousemove', e => {
    cg.style.left = e.clientX + 'px';
    cg.style.top  = e.clientY + 'px';
  });

  // Tab switch
  function switchTab(tab) {
    document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
    document.querySelectorAll('.form-section').forEach(f => f.classList.remove('active'));

    if (tab === 'login') {
      document.getElementById('tab-login').classList.add('active');
      document.getElementById('form-login').classList.add('active');
      document.getElementById('vTitle').textContent = 'Workflow Profesional';
      document.getElementById('vDesc').textContent  = 'Kelola seluruh proses konten dari ide hingga publish dalam satu sistem yang terstruktur dan terintegrasi.';
    } else {
      document.getElementById('tab-register').classList.add('active');
      document.getElementById('form-register').classList.add('active');
      document.getElementById('vTitle').textContent = 'Bergabung Sekarang';
      document.getElementById('vDesc').textContent  = 'Buat akun dan mulai kelola sistem PAGEFLOWRY secara profesional.';
    }

    // Re-animate status cards
    document.querySelectorAll('.sc').forEach(c => {
      c.style.animation = 'none';
      void c.offsetHeight;
      c.style.animation = '';
    });
  }

  // Loading on submit
  function setLoading(btnId, spId, txtId, text) {
    document.getElementById(spId).style.display = 'block';
    document.getElementById(txtId).textContent  = text;
    document.getElementById(btnId).disabled     = true;
  }
  document.getElementById('fLogin').addEventListener('submit', () => setLoading('btnLogin','spLogin','txtLogin','Masuk...'));
  document.getElementById('fRegister').addEventListener('submit', () => setLoading('btnReg','spReg','txtReg','Membuat akun...'));

  // Laravel errors
  @if ($errors->any())
    @if ($errors->has('name') || $errors->has('role') || old('name'))
      switchTab('register');
      const mR = document.getElementById('msg-register');
      mR.className = 'msg error'; mR.innerHTML = '⚠️ {{ $errors->first() }}'; mR.style.display = 'flex';
    @else
      const mL = document.getElementById('msg-login');
      mL.className = 'msg error'; mL.innerHTML = '⚠️ {{ $errors->first() }}'; mL.style.display = 'flex';
    @endif
  @endif
  @if (session('status'))
    const sE = document.getElementById('msg-login');
    sE.className = 'msg success'; sE.innerHTML = '✅ {{ session("status") }}'; sE.style.display = 'flex';
  @endif
</script>
</body>
</html>