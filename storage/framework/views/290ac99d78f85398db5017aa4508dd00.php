<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Tambah Brand - PAGEFLOWRY</title>
  <link href="https://fonts.googleapis.com/css2?family=Sora:wght@300;400;500;600;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    :root {
      --blue:      #5C97F5;
      --blue-dark: #4A84E0;
      --blue-deep: #2E5DB3;
      --soft:      #EAF2FF;
      --dark:      #1A2740;
      --muted:     #6B7E95;
      --white:     #ffffff;
      --bg:        #F4F7FF;
      --border:    rgba(92,151,245,0.12);
      --text:      #2C3E50;
      --green:     #22c55e;
      --red:       #ef4444;
      --yellow:    #f59e0b;
      --sidebar:   240px;
      --topbar:    66px;
      --r:         16px;
      --r-sm:      10px;
    }

    html, body { height:100%; font-family:'Sora',sans-serif; background:var(--bg); color:var(--text); overflow-x:hidden; }

    #cg {
      width:320px; height:320px; border-radius:50%;
      background:radial-gradient(circle,rgba(92,151,245,0.07) 0%,transparent 70%);
      position:fixed; pointer-events:none; transform:translate(-50%,-50%); z-index:0;
    }

    .shell { display:flex; height:100vh; position:relative; z-index:1; }

    /* ═════════════════════════════════════════════
       SIDEBAR
    ══════════════════════════════════════════════ */
    .sidebar {
      width: var(--sidebar); min-width: var(--sidebar);
      height: 100vh; background: var(--white);
      border-right: 1px solid var(--border);
      display: flex; flex-direction: column;
      position: fixed; z-index: 100;
      box-shadow: 4px 0 20px rgba(92,151,245,0.07);
    }
    .sb-logo {
      padding: 20px 18px 16px; border-bottom: 1px solid var(--border);
      display: flex; align-items: center; gap: 10px;
    }
    .sb-logo-mark {
      width: 34px; height: 34px; border-radius: 9px;
      background: linear-gradient(135deg,var(--blue),var(--blue-deep));
      display: flex; align-items: center; justify-content: center;
      box-shadow: 0 4px 12px rgba(92,151,245,0.3);
    }
    .sb-logo-mark svg { width: 15px; height: 15px; }
    .sb-logo-name { font-size: 0.95rem; font-weight: 800; color: var(--blue); letter-spacing: -0.3px; }
    .sb-logo-name em { color: var(--dark); font-style: normal; }

    .sb-nav { flex: 1; padding: 10px 0; overflow-y: auto; }
    .sb-nav::-webkit-scrollbar { display: none; }
    .sb-group-label {
      font-size: 0.58rem; font-weight: 700; letter-spacing: 1.5px;
      text-transform: uppercase; color: #B8C4D0; padding: 10px 18px 4px;
    }
    .sb-item {
      display: flex; align-items: center; gap: 10px;
      padding: 9px 14px; margin: 1px 8px;
      color: var(--muted); text-decoration: none;
      font-size: 0.82rem; font-weight: 500;
      border-radius: 10px; transition: all 0.2s ease;
    }
    .sb-item:hover { background: var(--soft); color: var(--blue); transform: translateX(3px); }
    .sb-item.active {
      background: linear-gradient(135deg,var(--blue),var(--blue-deep));
      color: white; box-shadow: 0 5px 16px rgba(92,151,245,0.3);
    }
    .sb-icon { font-size: 0.95rem; width: 17px; text-align: center; flex-shrink: 0; }
    .sb-badge {
      margin-left: auto; background: var(--red); color: white;
      font-size: 0.6rem; font-weight: 700; padding: 2px 6px;
      border-radius: 100px;
    }

    /* ═════════════════════════════════════════════
       MAIN
    ════════════════════════════════════════════ */
    .main {
      flex: 1; margin-left: var(--sidebar);
      display: flex; flex-direction: column; min-height: 100vh;
    }

    /* TOPBAR */
    .topbar {
      background: var(--white); padding: 12px 24px;
      border-bottom: 1px solid var(--border);
      display: flex; align-items: center; justify-content: space-between;
      position: sticky; top: 0; z-index: 50;
      box-shadow: 0 2px 12px rgba(92,151,245,0.06);
    }
    .page-title { font-size: 1.1rem; font-weight: 800; color: var(--dark); letter-spacing: -0.4px; }
    .page-sub   { font-size: 0.7rem; color: var(--muted); font-family: 'DM Sans',sans-serif; margin-top: 1px; }
    .topbar-right { display: flex; align-items: center; gap: 10px; }
    .icon-btn {
      width: 36px; height: 36px; border-radius: 9px; background: var(--soft);
      border: none; cursor: pointer; display: flex; align-items: center; justify-content: center;
      font-size: 0.95rem; color: var(--muted); transition: all 0.2s; position: relative;
    }
    .icon-btn:hover { background: rgba(92,151,245,0.15); color: var(--blue); }
    .notif-badge {
      position: absolute; top: -2px; right: -2px; background: #ef4444; color: white;
      font-size: 0.58rem; font-weight: 700; padding: 2px 4px; border-radius: 7px; border: 2px solid white;
    }
    .avatar-pill {
      display: flex; align-items: center; gap: 8px;
      padding: 5px 12px 5px 6px; background: var(--soft);
      border-radius: 100px; cursor: pointer; transition: all 0.2s; border: 1px solid var(--border);
    }
    .avatar-pill:hover { border-color: var(--blue); }
    .avatar {
      width: 28px; height: 28px; border-radius: 50%;
      background: linear-gradient(135deg,var(--blue),var(--blue-deep));
      display: flex; align-items: center; justify-content: center;
      color: white; font-weight: 700; font-size: 0.75rem;
    }
    .avatar-name { font-size: 0.78rem; font-weight: 600; color: var(--dark); }
    .role-pill {
      font-size: 0.6rem; font-weight: 700;
      background: linear-gradient(135deg,var(--blue),var(--blue-deep));
      color: white; padding: 2px 7px; border-radius: 100px;
    }

    /* ═════════════════════════════════════════════
       CONTENT
    ══════════════════════════════════════════════ */
    .content { flex: 1; padding: 20px 24px; overflow-y: auto; }

    /* Form Card */
    .form-card {
      background: var(--white); border-radius: 16px;
      padding: 32px; box-shadow: 0 4px 20px rgba(92,151,245,0.08);
      border: 1px solid var(--border); max-width: 800px; margin: 0 auto;
    }

    .form-header {
      margin-bottom: 32px;
    }
    .form-title {
      font-size: 1.75rem; font-weight: 700; color: var(--dark);
      letter-spacing: -0.5px; margin-bottom: 8px;
    }
    .form-sub {
      font-family: 'DM Sans', sans-serif; color: var(--muted);
      font-size: 1rem;
    }

    /* Form Groups */
    .form-grid {
      display: grid; grid-template-columns: repeat(2, 1fr);
      gap: 24px; margin-bottom: 24px;
    }
    .form-group {
      margin-bottom: 24px;
    }
    .form-group.full-width {
      grid-column: 1 / -1;
    }
    .form-label {
      display: block; font-size: 0.875rem; font-weight: 600;
      color: var(--dark); margin-bottom: 8px;
    }
    .form-input,
    .form-textarea,
    .form-select {
      width: 100%; padding: 12px 16px;
      border: 1.5px solid rgba(92,151,245,0.18); border-radius: 12px;
      font-size: 0.875rem; font-family: 'Sora', sans-serif;
      color: var(--dark); background: var(--soft); transition: all 0.25s ease;
    }
    .form-input:focus,
    .form-textarea:focus,
    .form-select:focus {
      outline: none; border-color: var(--blue); background: var(--white);
      box-shadow: 0 0 0 4px rgba(92,151,245,0.1);
    }
    .form-textarea {
      resize: vertical; min-height: 120px;
    }

    /* Radio Group */
    .radio-group {
      display: flex; gap: 16px; margin-top: 8px;
    }
    .radio-option {
      display: flex; align-items: center; gap: 8px; cursor: pointer;
    }
    .radio-option input[type="radio"] {
      width: 18px; height: 18px; accent-color: var(--blue);
    }
    .radio-label {
      font-size: 0.875rem; color: var(--dark); font-family: 'DM Sans', sans-serif;
    }

    /* Buttons */
    .form-buttons {
      display: flex; gap: 16px; justify-content: flex-end;
      margin-top: 32px; padding-top: 24px; border-top: 1px solid var(--border);
    }
    .btn {
      padding: 12px 24px; border-radius: 12px; font-size: 0.875rem;
      font-weight: 600; border: none; cursor: pointer; transition: all 0.3s ease;
      text-decoration: none; display: inline-flex; align-items: center; gap: 8px;
    }
    .btn-primary {
      background: linear-gradient(135deg, var(--blue), var(--blue-deep));
      color: var(--white); box-shadow: 0 4px 15px rgba(92,151,245,0.3);
    }
    .btn-primary:hover {
      transform: translateY(-2px); box-shadow: 0 8px 25px rgba(92,151,245,0.4);
    }
    .btn-secondary {
      background: var(--soft); color: var(--muted);
    }
    .btn-secondary:hover {
      background: #E1EDFF; color: var(--blue);
    }

    /* Error Messages */
    .error-message {
      color: #DC2626; font-size: 0.75rem; font-family: 'DM Sans', sans-serif;
      margin-top: 4px;
    }

    @media(max-width:768px) {
      .sidebar { transform: translateX(-100%); transition: transform 0.3s; }
      .sidebar.open { transform: translateX(0); }
      .main { margin-left: 0; }
      .content { padding: 16px; }
      .form-grid { grid-template-columns: 1fr; gap: 16px; }
      .form-card { padding: 20px; }
      .form-buttons { flex-direction: column; }
    }
  </style>
</head>
<body>

<div class="shell">
  <!-- ════════════════ SIDEBAR ════════════════ -->
  <aside class="sidebar">
    <div class="sb-logo">
      <div class="sb-logo-mark">
        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M13 2L4.5 13.5H11L10 22L20.5 9.5H14L13 2Z" fill="white" stroke="white" stroke-width="1.5" stroke-linejoin="round"/>
        </svg>
      </div>
      <div class="sb-logo-name">Page<em>flowry</em></div>
    </div>

    <nav class="sb-nav">
      <div class="sb-group-label">Overview</div>
      <a class="sb-item" href="<?php echo e(route('admin.dashboard')); ?>">
        <span class="sb-icon"><i class="fa-solid fa-house"></i></span>
        Dashboard
      </a>

      <div class="sb-group-label">Manajemen</div>
      <a class="sb-item active" href="<?php echo e(route('brands.index')); ?>">
        <span class="sb-icon"><i class="fa-solid fa-tag"></i></span>
        Brand Management
      </a>
      <a class="sb-item" href="#">
        <span class="sb-icon"><i class="fa-solid fa-list-check"></i></span>
        Daftar Tugas Konten
      </a>

      <div class="sb-group-label">Workflow</div>
      <a class="sb-item" href="#">
        <span class="sb-icon"><i class="fa-solid fa-film"></i></span>
        Production
      </a>
      <a class="sb-item" href="#">
        <span class="sb-icon"><i class="fa-solid fa-rotate-left"></i></span>
        Revision
        <span class="sb-badge">4</span>
      </a>
      <a class="sb-item" href="#">
        <span class="sb-icon"><i class="fa-solid fa-circle-check"></i></span>
        Approval
      </a>
      <a class="sb-item" href="#">
        <span class="sb-icon"><i class="fa-solid fa-paper-plane"></i></span>
        Publishing
      </a>

      <div class="sb-group-label">Laporan</div>
      <a class="sb-item" href="#">
        <span class="sb-icon"><i class="fa-solid fa-chart-line"></i></span>
        Analytics
      </a>
      <a class="sb-item" href="#">
        <span class="sb-icon"><i class="fa-solid fa-users"></i></span>
        Team
      </a>

      <div class="sb-group-label">Sistem</div>
      <a class="sb-item" href="#">
        <span class="sb-icon"><i class="fa-solid fa-gear"></i></span>
        Settings
      </a>
      <a class="sb-item" href="<?php echo e(route('logout')); ?>" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" style="color: var(--red);">
        <span class="sb-icon"><i class="fa-solid fa-right-from-bracket"></i></span>
        Logout
      </a>
    </nav>
    
    <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
      <?php echo csrf_field(); ?>
    </form>
  </aside>

  <!-- ════════════════ MAIN ════════════════ -->
  <main class="main">
    <!-- TOPBAR -->
    <div class="topbar">
      <div>
        <div class="page-title">🏢 Tambah Brand Baru</div>
        <div class="page-sub">Isi informasi brand yang akan dikelola</div>
      </div>
      <div class="topbar-right">
        <button class="icon-btn" onclick="toggleSidebar()">
          <span>☰</span>
        </button>
        <button class="icon-btn" id="notifBtn">
          <span>🔔</span>
          <span class="notif-badge" style="display: none;">3</span>
        </button>
        <div class="avatar-pill">
          <div class="avatar"><?php echo e(auth()->user()->name[0] ?? 'A'); ?></div>
          <div>
            <div class="avatar-name"><?php echo e(auth()->user()->name); ?></div>
            <div class="role-pill">Admin</div>
          </div>
        </div>
      </div>
    </div>

    <!-- ════════════════ CONTENT ════════════════ -->
    <div class="content">
      <div class="form-card">
        <div class="form-header">
          <h2 class="form-title">Tambah Brand Baru</h2>
          <p class="form-sub">Isi informasi brand yang akan dikelola</p>
        </div>

        <form action="<?php echo e(route('brands.store')); ?>" method="POST">
          <?php echo csrf_field(); ?>
          
          <div class="form-grid">
            <div class="form-group">
              <label for="name" class="form-label">Nama Brand *</label>
              <input 
                type="text" 
                id="name" 
                name="name" 
                class="form-input" 
                value="<?php echo e(old('name')); ?>"
                placeholder="Masukkan nama brand"
                required
              >
              <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div class="error-message"><?php echo e($message); ?></div>
              <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="form-group">
              <label for="pic" class="form-label">PIC / Penanggung Jawab *</label>
              <input 
                type="text" 
                id="pic" 
                name="pic" 
                class="form-input" 
                value="<?php echo e(old('pic')); ?>"
                placeholder="Nama penanggung jawab"
                required
              >
              <?php $__errorArgs = ['pic'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div class="error-message"><?php echo e($message); ?></div>
              <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="form-group">
              <label for="contact" class="form-label">Kontak *</label>
              <input 
                type="text" 
                id="contact" 
                name="contact" 
                class="form-input" 
                value="<?php echo e(old('contact')); ?>"
                placeholder="Email atau nomor telepon"
                required
              >
              <?php $__errorArgs = ['contact'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div class="error-message"><?php echo e($message); ?></div>
              <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="form-group">
              <label for="status" class="form-label">Status *</label>
              <select id="status" name="status" class="form-select" required>
                <option value="Active" <?php echo e(old('status') == 'Active' ? 'selected' : ''); ?>>Active</option>
                <option value="Non Active" <?php echo e(old('status') == 'Non Active' ? 'selected' : ''); ?>>Non Active</option>
              </select>
              <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div class="error-message"><?php echo e($message); ?></div>
              <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="form-group full-width">
              <label for="target_market" class="form-label">Target Market *</label>
              <textarea 
                id="target_market" 
                name="target_market" 
                class="form-textarea" 
                placeholder="Jelaskan target market dari brand (usia, gender, lokasi, dll)"
                required
              ><?php echo e(old('target_market')); ?></textarea>
              <?php $__errorArgs = ['target_market'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div class="error-message"><?php echo e($message); ?></div>
              <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="form-group full-width">
              <label for="tone" class="form-label">Tone Komunikasi *</label>
              <textarea 
                id="tone" 
                name="tone" 
                class="form-textarea" 
                placeholder="Jelaskan tone komunikasi yang digunakan (formal, casual, friendly, dll)"
                required
              ><?php echo e(old('tone')); ?></textarea>
              <?php $__errorArgs = ['tone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div class="error-message"><?php echo e($message); ?></div>
              <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
          </div>

          <div class="form-buttons">
            <a href="<?php echo e(route('brands.index')); ?>" class="btn btn-secondary">
              <i class="fa-solid fa-arrow-left"></i>
              Batal
            </a>
            <button type="submit" class="btn btn-primary">
              <i class="fa-solid fa-save"></i>
              Simpan Brand
            </button>
          </div>
        </form>
      </div>
    </div>
  </main>
</div>

<script>
  // Cursor glow
  const cg = document.getElementById('cg');
  document.addEventListener('mousemove', e => {
    cg.style.left = e.clientX + 'px';
    cg.style.top  = e.clientY + 'px';
  });

  // Toggle sidebar
  function toggleSidebar() {
    document.querySelector('.sidebar').classList.toggle('open');
  }

  // Navigation active state
  document.querySelectorAll('.sb-item').forEach(item => {
    item.addEventListener('click', function() {
      document.querySelectorAll('.sb-item').forEach(n=>n.classList.remove('active'));
      this.classList.add('active');
    });
  });

  // Notif
  document.getElementById('notifBtn')?.addEventListener('click',()=>{
    const b=document.querySelector('.notif-badge'); if(b) b.style.display='none';
  });
</script>

</body>
</html>
<?php /**PATH C:\xampp444\htdocs\laravel\pageflowry\resources\views/brands/create.blade.php ENDPATH**/ ?>