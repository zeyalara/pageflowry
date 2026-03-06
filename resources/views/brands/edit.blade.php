<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Edit Brand - PAGEFLOWRY</title>
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
      --white: #ffffff;
    }

    html, body {
      height: 100%; width: 100%;
      font-family: 'Sora', sans-serif;
      background: #f8fafc;
      overflow-x: hidden;
    }

    /* Main Layout */
    .app-container {
      display: flex;
      height: 100vh;
    }

    /* Sidebar */
    .sidebar {
      width: 260px;
      background: var(--white);
      border-right: 1px solid rgba(92,151,245,0.1);
      display: flex;
      flex-direction: column;
      position: fixed;
      height: 100vh;
      z-index: 100;
    }

    .sidebar-header {
      padding: 24px 20px;
      border-bottom: 1px solid rgba(92,151,245,0.08);
    }

    .logo {
      display: flex;
      align-items: center;
      gap: 10px;
      font-size: 1.1rem;
      font-weight: 800;
      color: var(--blue);
      letter-spacing: -0.5px;
      text-decoration: none;
    }

    .logo-box {
      width: 32px;
      height: 32px;
      border-radius: 8px;
      background: linear-gradient(135deg, var(--blue), var(--blue-deep));
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .logo-box svg { 
      width: 15px; 
      height: 15px; 
    }

    .logo em { 
      color: var(--dark); 
      font-style: normal; 
    }

    .sidebar-nav {
      flex: 1;
      padding: 20px 0;
      overflow-y: auto;
    }

    .nav-item {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 12px 20px;
      color: var(--muted);
      text-decoration: none;
      transition: all 0.2s ease;
      font-size: 0.875rem;
      font-weight: 500;
      border-radius: 10px;
      margin: 0 8px;
    }

    .nav-item:hover {
      background: var(--soft);
      transform: translateX(4px);
    }

    .nav-item.active {
      background: var(--soft);
      color: var(--blue);
      border-left: 3px solid var(--blue);
      font-weight: 600;
    }

    .nav-icon {
      width: 20px;
      height: 20px;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .nav-icon svg {
      width: 20px;
      height: 20px;
      stroke-width: 2;
    }

    /* Main Content */
    .main-content {
      flex: 1;
      margin-left: 260px;
      display: flex;
      flex-direction: column;
    }

    /* Navbar */
    .navbar {
      height: 70px;
      background: var(--white);
      border-bottom: 1px solid rgba(92,151,245,0.1);
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 0 32px;
      position: sticky;
      top: 0;
      z-index: 50;
    }

    .navbar-left h1 {
      font-size: 1.5rem;
      font-weight: 700;
      color: var(--dark);
      letter-spacing: -0.5px;
    }

    .navbar-right {
      display: flex;
      align-items: center;
      gap: 20px;
    }

    .user-info {
      display: flex;
      align-items: center;
      gap: 12px;
    }

    .user-avatar {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      background: linear-gradient(135deg, var(--blue), var(--blue-deep));
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      font-weight: 600;
      font-size: 0.9rem;
    }

    .user-details {
      text-align: right;
    }

    .user-name {
      font-size: 0.875rem;
      font-weight: 600;
      color: var(--dark);
      line-height: 1.2;
    }

    .user-role {
      font-size: 0.75rem;
      color: var(--muted);
      font-family: 'DM Sans', sans-serif;
    }

    /* Content Area */
    .content {
      flex: 1;
      padding: 32px;
      overflow-y: auto;
    }

    /* Form Card */
    .form-card {
      background: var(--white);
      border-radius: 16px;
      padding: 32px;
      box-shadow: 0 4px 20px rgba(92,151,245,0.08);
      border: 1px solid rgba(92,151,245,0.08);
      max-width: 800px;
      margin: 0 auto;
    }

    .form-header {
      margin-bottom: 32px;
    }

    .form-title {
      font-size: 1.75rem;
      font-weight: 700;
      color: var(--dark);
      letter-spacing: -0.5px;
      margin-bottom: 8px;
    }

    .form-sub {
      font-family: 'DM Sans', sans-serif;
      color: var(--muted);
      font-size: 1rem;
    }

    /* Form Groups */
    .form-grid {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 24px;
      margin-bottom: 24px;
    }

    .form-group {
      margin-bottom: 24px;
    }

    .form-group.full-width {
      grid-column: 1 / -1;
    }

    .form-label {
      display: block;
      font-size: 0.875rem;
      font-weight: 600;
      color: var(--dark);
      margin-bottom: 8px;
    }

    .form-input,
    .form-textarea,
    .form-select {
      width: 100%;
      padding: 12px 16px;
      border: 1.5px solid rgba(92,151,245,0.18);
      border-radius: 12px;
      font-size: 0.875rem;
      font-family: 'Sora', sans-serif;
      color: var(--dark);
      background: var(--soft);
      transition: all 0.25s ease;
    }

    .form-input:focus,
    .form-textarea:focus,
    .form-select:focus {
      outline: none;
      border-color: var(--blue);
      background: var(--white);
      box-shadow: 0 0 0 4px rgba(92,151,245,0.1);
    }

    .form-textarea {
      resize: vertical;
      min-height: 120px;
    }

    /* Radio Group */
    .radio-group {
      display: flex;
      gap: 16px;
      margin-top: 8px;
    }

    .radio-option {
      display: flex;
      align-items: center;
      gap: 8px;
      cursor: pointer;
    }

    .radio-option input[type="radio"] {
      width: 18px;
      height: 18px;
      accent-color: var(--blue);
    }

    .radio-label {
      font-size: 0.875rem;
      color: var(--dark);
      font-family: 'DM Sans', sans-serif;
    }

    /* Buttons */
    .form-buttons {
      display: flex;
      gap: 16px;
      justify-content: flex-end;
      margin-top: 32px;
      padding-top: 24px;
      border-top: 1px solid rgba(92,151,245,0.08);
    }

    .btn {
      padding: 12px 24px;
      border-radius: 12px;
      font-size: 0.875rem;
      font-weight: 600;
      border: none;
      cursor: pointer;
      transition: all 0.3s ease;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: 8px;
    }

    .btn-primary {
      background: linear-gradient(135deg, var(--blue), var(--blue-deep));
      color: var(--white);
      box-shadow: 0 4px 15px rgba(92,151,245,0.3);
    }

    .btn-primary:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 25px rgba(92,151,245,0.4);
    }

    .btn-secondary {
      background: var(--soft);
      color: var(--muted);
    }

    .btn-secondary:hover {
      background: #E1EDFF;
      color: var(--blue);
    }

    /* Error Messages */
    .error-message {
      color: #DC2626;
      font-size: 0.75rem;
      font-family: 'DM Sans', sans-serif;
      margin-top: 4px;
    }

    /* Mobile Responsive */
    @media (max-width: 768px) {
      .sidebar {
        transform: translateX(-100%);
        transition: transform 0.3s;
      }

      .sidebar.open {
        transform: translateX(0);
      }

      .main-content {
        margin-left: 0;
      }

      .content {
        padding: 20px;
      }

      .navbar {
        padding: 0 20px;
      }

      .form-grid {
        grid-template-columns: 1fr;
        gap: 16px;
      }

      .form-card {
        padding: 20px;
      }

      .form-buttons {
        flex-direction: column;
      }
    }

    /* Mobile Menu Toggle */
    .mobile-menu-toggle {
      display: none;
      background: none;
      border: none;
      font-size: 1.5rem;
      cursor: pointer;
      color: var(--dark);
    }

    @media (max-width: 768px) {
      .mobile-menu-toggle {
        display: block;
      }
    }
  </style>
</head>
<body>

<div class="app-container">
  <!-- Sidebar -->
  <aside class="sidebar" id="sidebar">
    <div class="sidebar-header">
      <a href="{{ route('creator.dashboard') }}" class="logo">
        <div class="logo-box">
          <svg viewBox="0 0 18 18" fill="none">
            <rect x="1" y="1" width="7" height="7" rx="2" fill="white"/>
            <rect x="10" y="1" width="7" height="7" rx="2" fill="white" opacity="0.5"/>
            <rect x="1" y="10" width="7" height="7" rx="2" fill="white" opacity="0.5"/>
            <rect x="10" y="10" width="7" height="7" rx="2" fill="white"/>
          </svg>
        </div>
        <span>PAGE<em>FLOWRY</em></span>
      </a>
    </div>

    <nav class="sidebar-nav">
      <a href="{{ route('creator.dashboard') }}" class="nav-item {{ request()->is('creator/dashboard') ? 'active' : '' }}">
        <span class="nav-icon">
          <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z"/>
          </svg>
        </span>
        <span>Dashboard</span>
      </a>
      <a href="{{ route('brands.index') }}" class="nav-item {{ request()->is('brands*') ? 'active' : '' }}">
        <span class="nav-icon">
          <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
          </svg>
        </span>
        <span>Brand Management</span>
      </a>
      <a href="{{ route('brief.index') }}" class="nav-item {{ request()->is('brief*') ? 'active' : '' }}">
        <span class="nav-icon">
          <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
          </svg>
        </span>
        <span>Content Brief</span>
      </a>
      <a href="#" class="nav-item">
        <span class="nav-icon">
          <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
          </svg>
        </span>
        <span>Production / Upload</span>
      </a>
      <a href="#" class="nav-item">
        <span class="nav-icon">
          <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
          </svg>
        </span>
        <span>Revision</span>
      </a>
      <a href="#" class="nav-item">
        <span class="nav-icon">
          <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
          </svg>
        </span>
        <span>Publishing</span>
      </a>
      <a href="#" class="nav-item">
        <span class="nav-icon">
          <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
          </svg>
        </span>
        <span>Analytics</span>
      </a>
      <a href="{{ route('logout') }}" class="nav-item" style="margin-top: auto; color: #DC2626;" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        <span class="nav-icon">
          <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
          </svg>
        </span>
        <span>Logout</span>
      </a>
    </nav>
    
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
      @csrf
    </form>
  </aside>

  <!-- Main Content -->
  <main class="main-content">
    <!-- Navbar -->
    <header class="navbar">
      <div class="navbar-left">
        <button class="mobile-menu-toggle" onclick="toggleSidebar()">☰</button>
        <h1>Edit Brand</h1>
      </div>
      
      <div class="navbar-right">
        <div class="user-info">
          <div class="user-details">
            <div class="user-name">{{ Auth::user()->name }}</div>
            <div class="user-role">Content Creator</div>
          </div>
          <div class="user-avatar">
            {{ substr(Auth::user()->name, 0, 1) }}
          </div>
        </div>
      </div>
    </header>

    <!-- Content Area -->
    <div class="content">
      <div class="form-card">
        <div class="form-header">
          <h2 class="form-title">Edit Brand</h2>
          <p class="form-sub">Perbarui informasi brand {{ $brand->name }}</p>
        </div>

        <form action="{{ route('brands.update', $brand->id) }}" method="POST">
          @csrf
          @method('PUT')
          
          <div class="form-grid">
            <div class="form-group">
              <label for="name" class="form-label">Nama Brand *</label>
              <input 
                type="text" 
                id="name" 
                name="name" 
                class="form-input" 
                value="{{ old('name', $brand->name) }}"
                placeholder="Masukkan nama brand"
                required
              >
              @error('name')
                <div class="error-message">{{ $message }}</div>
              @enderror
            </div>

            <div class="form-group">
              <label for="pic" class="form-label">PIC / Penanggung Jawab *</label>
              <input 
                type="text" 
                id="pic" 
                name="pic" 
                class="form-input" 
                value="{{ old('pic', $brand->pic) }}"
                placeholder="Nama penanggung jawab"
                required
              >
              @error('pic')
                <div class="error-message">{{ $message }}</div>
              @enderror
            </div>

            <div class="form-group">
              <label for="contact" class="form-label">Kontak *</label>
              <input 
                type="text" 
                id="contact" 
                name="contact" 
                class="form-input" 
                value="{{ old('contact', $brand->contact) }}"
                placeholder="Email atau nomor telepon"
                required
              >
              @error('contact')
                <div class="error-message">{{ $message }}</div>
              @enderror
            </div>

            <div class="form-group">
              <label for="status" class="form-label">Status *</label>
              <select id="status" name="status" class="form-select" required>
                <option value="Active" {{ old('status', $brand->status) == 'Active' ? 'selected' : '' }}>Active</option>
                <option value="Non Active" {{ old('status', $brand->status) == 'Non Active' ? 'selected' : '' }}>Non Active</option>
              </select>
              @error('status')
                <div class="error-message">{{ $message }}</div>
              @enderror
            </div>

            <div class="form-group full-width">
              <label for="target_market" class="form-label">Target Market *</label>
              <textarea 
                id="target_market" 
                name="target_market" 
                class="form-textarea" 
                placeholder="Jelaskan target market dari brand (usia, gender, lokasi, dll)"
                required
              >{{ old('target_market', $brand->target_market) }}</textarea>
              @error('target_market')
                <div class="error-message">{{ $message }}</div>
              @enderror
            </div>

            <div class="form-group full-width">
              <label for="tone" class="form-label">Tone Komunikasi *</label>
              <textarea 
                id="tone" 
                name="tone" 
                class="form-textarea" 
                placeholder="Jelaskan tone komunikasi yang digunakan (formal, casual, friendly, dll)"
                required
              >{{ old('tone', $brand->tone) }}</textarea>
              @error('tone')
                <div class="error-message">{{ $message }}</div>
              @enderror
            </div>
          </div>

          <div class="form-buttons">
            <a href="{{ route('brands.index') }}" class="btn btn-secondary">
              <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
              </svg>
              Batal
            </a>
            <button type="submit" class="btn btn-primary">
              <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
              </svg>
              Update Brand
            </button>
          </div>
        </form>
      </div>
    </div>
  </main>
</div>

<script>
  // Mobile sidebar toggle
  function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    sidebar.classList.toggle('open');
  }

  // Close sidebar when clicking outside on mobile
  document.addEventListener('click', function(event) {
    const sidebar = document.getElementById('sidebar');
    const toggle = document.querySelector('.mobile-menu-toggle');
    
    if (window.innerWidth <= 768 && 
        !sidebar.contains(event.target) && 
        !toggle.contains(event.target) &&
        sidebar.classList.contains('open')) {
      sidebar.classList.remove('open');
    }
  });
</script>

</body>
</html>
