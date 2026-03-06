<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Buat Content Brief - PAGEFLOWRY</title>
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
      max-width: 1000px;
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

    /* Form Sections */
    .form-section {
      margin-bottom: 32px;
    }

    .section-title {
      font-size: 1.125rem;
      font-weight: 600;
      color: var(--dark);
      margin-bottom: 20px;
      padding-bottom: 12px;
      border-bottom: 2px solid var(--soft);
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .section-icon {
      width: 24px;
      height: 24px;
      background: var(--soft);
      border-radius: 8px;
      display: flex;
      align-items: center;
      justify-content: center;
      color: var(--blue);
    }

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
      min-height: 100px;
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
        <h1>Buat Content Brief</h1>
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
          <h2 class="form-title">Buat Content Brief Baru</h2>
          <p class="form-sub">Rencanakan konten yang akan diproduksi dengan brief yang terstruktur</p>
        </div>

        <form action="{{ route('brief.store') }}" method="POST">
          @csrf
          
          <!-- Informasi Dasar -->
          <div class="form-section">
            <h3 class="section-title">
              <div class="section-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
              </div>
              Informasi Dasar
            </h3>
            
            <div class="form-grid">
              <div class="form-group">
                <label for="title" class="form-label">Judul Konten</label>
                <input 
                  type="text" 
                  id="title" 
                  name="title" 
                  class="form-input" 
                  value="{{ old('title') }}"
                  placeholder="Masukkan judul konten"
                  required
                >
                @error('title')
                  <div class="error-message">{{ $message }}</div>
                @enderror
              </div>

              <div class="form-group">
                <label for="brand_id" class="form-label">Pilih Brand</label>
                <select id="brand_id" name="brand_id" class="form-select" required>
                  <option value="">Pilih Brand</option>
                  @foreach($brands as $brand)
                    <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>
                      {{ $brand->name }}
                    </option>
                  @endforeach
                </select>
                @error('brand_id')
                  <div class="error-message">{{ $message }}</div>
                @enderror
              </div>

              <div class="form-group">
                <label for="creator_id" class="form-label">Assign Creator</label>
                <select id="creator_id" name="creator_id" class="form-select">
                  <option value="">Pilih Creator (Opsional)</option>
                  @foreach($creators as $creator)
                    <option value="{{ $creator->id }}" {{ old('creator_id') == $creator->id ? 'selected' : '' }}>
                      {{ $creator->name }}
                    </option>
                  @endforeach
                </select>
                @error('creator_id')
                  <div class="error-message">{{ $message }}</div>
                @enderror
              </div>

              <div class="form-group">
                <label for="platform" class="form-label">Platform</label>
                <select id="platform" name="platform" class="form-select" required>
                  <option value="Instagram" {{ old('platform') == 'Instagram' ? 'selected' : '' }}>Instagram</option>
                  <option value="TikTok" {{ old('platform') == 'TikTok' ? 'selected' : '' }}>TikTok</option>
                  <option value="YouTube" {{ old('platform') == 'YouTube' ? 'selected' : '' }}>YouTube</option>
                </select>
                @error('platform')
                  <div class="error-message">{{ $message }}</div>
                @enderror
              </div>

              <div class="form-group">
                <label for="content_format" class="form-label">Format Konten</label>
                <input 
                  type="text" 
                  id="content_format" 
                  name="content_format" 
                  class="form-input" 
                  value="{{ old('content_format') }}"
                  placeholder="Contoh: Video Reels, IG Story, YouTube Short"
                  required
                >
                @error('content_format')
                  <div class="error-message">{{ $message }}</div>
                @enderror
              </div>

              <div class="form-group">
                <label for="target_duration" class="form-label">Durasi Target</label>
                <input 
                  type="text" 
                  id="target_duration" 
                  name="target_duration" 
                  class="form-input" 
                  value="{{ old('target_duration') }}"
                  placeholder="Contoh: 30 detik, 1 menit"
                  required
                >
                @error('target_duration')
                  <div class="error-message">{{ $message }}</div>
                @enderror
              </div>

              <div class="form-group">
                <label for="production_deadline" class="form-label">Deadline Produksi</label>
                <input 
                  type="date" 
                  id="production_deadline" 
                  name="production_deadline" 
                  class="form-input" 
                  value="{{ old('production_deadline') }}"
                  required
                >
                @error('production_deadline')
                  <div class="error-message">{{ $message }}</div>
                @enderror
              </div>

              <div class="form-group">
                <label for="publish_deadline" class="form-label">Deadline Publish</label>
                <input 
                  type="date" 
                  id="publish_deadline" 
                  name="publish_deadline" 
                  class="form-input" 
                  value="{{ old('publish_deadline') }}"
                  required
                >
                @error('publish_deadline')
                  <div class="error-message">{{ $message }}</div>
                @enderror
              </div>
            </div>
          </div>

          <!-- Strategi -->
          <div class="form-section">
            <h3 class="section-title">
              <div class="section-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.322.897-.322.897M16.5 12a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0z"/>
                </svg>
              </div>
              Strategi
            </h3>
            
            <div class="form-grid">
              <div class="form-group full-width">
                <label for="objective" class="form-label">Objective</label>
                <textarea 
                  id="objective" 
                  name="objective" 
                  class="form-textarea" 
                  placeholder="Apa tujuan dari konten ini?"
                  required
                >{{ old('objective') }}</textarea>
                @error('objective')
                  <div class="error-message">{{ $message }}</div>
                @enderror
              </div>

              <div class="form-group full-width">
                <label for="target_audience" class="form-label">Target Audience</label>
                <textarea 
                  id="target_audience" 
                  name="target_audience" 
                  class="form-textarea" 
                  placeholder="Siapa target audience dari konten ini?"
                  required
                >{{ old('target_audience') }}</textarea>
                @error('target_audience')
                  <div class="error-message">{{ $message }}</div>
                @enderror
              </div>

              <div class="form-group full-width">
                <label for="key_message" class="form-label">Key Message</label>
                <textarea 
                  id="key_message" 
                  name="key_message" 
                  class="form-textarea" 
                  placeholder="Pesan utama yang ingin disampaikan"
                  required
                >{{ old('key_message') }}</textarea>
                @error('key_message')
                  <div class="error-message">{{ $message }}</div>
                @enderror
              </div>
            </div>
          </div>

          <!-- Creative -->
          <div class="form-section">
            <h3 class="section-title">
              <div class="section-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4 4 0 00-4-4m6 6a2 2 0 100 4 4 0 00-4-4m-6 6V6m6 6V6m6 6V6"/>
                </svg>
              </div>
              Creative
            </h3>
            
            <div class="form-grid">
              <div class="form-group full-width">
                <label for="hook" class="form-label">Hook</label>
                <textarea 
                  id="hook" 
                  name="hook" 
                  class="form-textarea" 
                  placeholder="Opening yang menarik perhatian audience"
                  required
                >{{ old('hook') }}</textarea>
                @error('hook')
                  <div class="error-message">{{ $message }}</div>
                @enderror
              </div>

              <div class="form-group full-width">
                <label for="storyline" class="form-label">Storyline</label>
                <textarea 
                  id="storyline" 
                  name="storyline" 
                  class="form-textarea" 
                  placeholder="Alur cerita yang akan disajikan"
                  required
                >{{ old('storyline') }}</textarea>
                @error('storyline')
                  <div class="error-message">{{ $message }}</div>
                @enderror
              </div>

              <div class="form-group full-width">
                <label for="visual_direction" class="form-label">Visual Direction</label>
                <textarea 
                  id="visual_direction" 
                  name="visual_direction" 
                  class="form-textarea" 
                  placeholder="Arahan untuk visual konten (lighting, angle, props, dll)"
                  required
                >{{ old('visual_direction') }}</textarea>
                @error('visual_direction')
                  <div class="error-message">{{ $message }}</div>
                @enderror
              </div>
            </div>
          </div>

          <!-- Copywriting -->
          <div class="form-section">
            <h3 class="section-title">
              <div class="section-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
              </div>
              Copywriting
            </h3>
            
            <div class="form-grid">
              <div class="form-group full-width">
                <label for="caption" class="form-label">Caption</label>
                <textarea 
                  id="caption" 
                  name="caption" 
                  class="form-textarea" 
                  placeholder="Caption untuk social media"
                  required
                >{{ old('caption') }}</textarea>
                @error('caption')
                  <div class="error-message">{{ $message }}</div>
                @enderror
              </div>

              <div class="form-group full-width">
                <label for="cta" class="form-label">CTA</label>
                <textarea 
                  id="cta" 
                  name="cta" 
                  class="form-textarea" 
                  placeholder="Call to action yang ingin audience lakukan"
                  required
                >{{ old('cta') }}</textarea>
                @error('cta')
                  <div class="error-message">{{ $message }}</div>
                @enderror
              </div>

              <div class="form-group full-width">
                <label for="hashtags" class="form-label">Hashtag</label>
                <textarea 
                  id="hashtags" 
                  name="hashtags" 
                  class="form-textarea" 
                  placeholder="Hashtag yang relevan"
                  required
                >{{ old('hashtags') }}</textarea>
                @error('hashtags')
                  <div class="error-message">{{ $message }}</div>
                @enderror
              </div>
            </div>
          </div>

          <!-- KPI Target -->
          <div class="form-section">
            <h3 class="section-title">
              <div class="section-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm6 0a2 2 0 002 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 002-2h2a2 2 0 002-2z"/>
                </svg>
              </div>
              KPI Target
            </h3>
            
            <div class="form-grid">
              <div class="form-group">
                <label for="target_views" class="form-label">Target Views</label>
                <input 
                  type="text" 
                  id="target_views" 
                  name="target_views" 
                  class="form-input" 
                  value="{{ old('target_views') }}"
                  placeholder="Contoh: 10K views"
                  required
                >
                @error('target_views')
                  <div class="error-message">{{ $message }}</div>
                @enderror
              </div>

              <div class="form-group">
                <label for="target_engagement" class="form-label">Target Engagement</label>
                <input 
                  type="text" 
                  id="target_engagement" 
                  name="target_engagement" 
                  class="form-input" 
                  value="{{ old('target_engagement') }}"
                  placeholder="Contoh: 500 likes, 50 comments"
                  required
                >
                @error('target_engagement')
                  <div class="error-message">{{ $message }}</div>
                @enderror
              </div>
            </div>
          </div>

          <div class="form-buttons">
            <a href="{{ route('brief.index') }}" class="btn btn-secondary">
              <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
              </svg>
              Batal
            </a>
            <button type="submit" class="btn btn-primary">
              <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
              </svg>
              Simpan Brief
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
        sidebar.classList.classList.contains('open')) {
      sidebar.classList.remove('open');
    }
  });
</script>

</body>
</html>
