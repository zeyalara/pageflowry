<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Dashboard Creator - PAGEFLOWRY</title>
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

    /* Welcome Section */
    .welcome-section {
      margin-bottom: 32px;
      opacity: 0;
      animation: fadeUp 0.5s ease forwards;
    }

    .welcome-text {
      font-size: 1.75rem;
      font-weight: 700;
      color: var(--dark);
      letter-spacing: -0.5px;
      margin-bottom: 8px;
    }

    .welcome-sub {
      font-family: 'DM Sans', sans-serif;
      color: var(--muted);
      font-size: 1rem;
    }

    /* Stats Grid */
    .stats-grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 24px;
      margin-bottom: 32px;
    }

    .stat-card {
      background: var(--white);
      border-radius: 16px;
      padding: 22px;
      box-shadow: 0 8px 20px rgba(0,0,0,0.04);
      transition: all 0.3s ease;
      cursor: pointer;
      opacity: 0;
      animation: fadeUp 0.5s ease forwards;
      animation-delay: calc(var(--index) * 0.1s);
    }

    .stat-card:hover {
      transform: translateY(-8px) scale(1.04);
      box-shadow: 0 25px 45px rgba(0,0,0,0.08);
    }

    .stat-icon {
      background: var(--soft);
      padding: 12px;
      border-radius: 12px;
      display: inline-flex;
      margin-bottom: 16px;
      transition: all 0.3s ease;
    }

    .stat-card:hover .stat-icon {
      transform: scale(1.1);
    }

    .stat-icon svg {
      width: 24px;
      height: 24px;
      color: var(--blue);
    }

    .stat-number {
      font-size: 2.5rem;
      font-weight: 600;
      color: var(--dark);
      line-height: 1;
      margin-bottom: 8px;
    }

    .stat-label {
      font-size: 0.875rem;
      color: var(--muted);
      font-family: 'DM Sans', sans-serif;
    }

    /* Tables */
    .section-card {
      background: var(--white);
      border-radius: 16px;
      padding: 24px;
      box-shadow: 0 4px 20px rgba(92,151,245,0.08);
      border: 1px solid rgba(92,151,245,0.08);
      margin-bottom: 24px;
      opacity: 0;
      animation: fadeUp 0.5s ease forwards;
      animation-delay: 0.8s;
    }

    .section-header {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 20px;
    }

    .section-title {
      font-size: 1.125rem;
      font-weight: 700;
      color: var(--dark);
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .table {
      width: 100%;
      border-collapse: collapse;
    }

    .table th {
      text-align: left;
      padding: 12px 16px;
      font-size: 0.75rem;
      font-weight: 600;
      color: var(--muted);
      font-family: 'DM Sans', sans-serif;
      border-bottom: 1px solid rgba(92,151,245,0.08);
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }

    .table td {
      padding: 16px;
      font-size: 0.875rem;
      color: var(--dark);
      border-bottom: 1px solid rgba(92,151,245,0.05);
    }

    .table tr:hover {
      background: var(--soft);
    }

    .status-badge {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      padding: 4px 12px;
      border-radius: 20px;
      font-size: 0.75rem;
      font-weight: 600;
      font-family: 'DM Sans', sans-serif;
    }

    .status-badge.production {
      background: #FFFBEB;
      color: #D97706;
    }

    .status-badge.review {
      background: var(--soft);
      color: var(--blue);
    }

    .status-badge.revision {
      background: #FFF0F0;
      color: #DC2626;
    }

    /* Activity List */
    .activity-list {
      display: flex;
      flex-direction: column;
      gap: 12px;
    }

    .activity-item {
      display: flex;
      align-items: center;
      gap: 12px;
      background: var(--soft);
      padding: 16px;
      border-radius: 14px;
      margin-bottom: 12px;
      transition: all 0.25s ease;
      opacity: 0;
      animation: fadeUp 0.5s ease forwards;
      animation-delay: calc(var(--index) * 0.1s + 1s);
    }

    .activity-item:hover {
      transform: translateY(-4px) scale(1.01);
      box-shadow: 0 12px 25px rgba(0,0,0,0.06);
    }

    .icon-activity {
      background: var(--soft);
      padding: 10px;
      border-radius: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      color: var(--blue);
      flex-shrink: 0;
      transition: all 0.3s ease;
    }

    .activity-item:hover .icon-activity {
      transform: scale(1.1);
    }

    .icon-activity svg {
      width: 20px;
      height: 20px;
      stroke-width: 2;
    }

    .activity-content {
      flex: 1;
    }

    .activity-message {
      font-size: 0.875rem;
      color: var(--dark);
      margin-bottom: 4px;
      line-height: 1.4;
    }

    .activity-time {
      font-size: 0.75rem;
      color: var(--muted);
      font-family: 'DM Sans', sans-serif;
    }

    /* Animations */
    @keyframes fadeUp {
      from {
        opacity: 0;
        transform: translateY(20px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    /* Mobile Responsive */
    @media (max-width: 1024px) {
      .stats-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
      }
    }

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

      .stats-grid {
        grid-template-columns: 1fr;
        gap: 16px;
      }

      .content {
        padding: 20px;
      }

      .navbar {
        padding: 0 20px;
      }

      .table {
        font-size: 0.8rem;
      }

      .table th,
      .table td {
        padding: 8px;
      }

      .stat-number {
        font-size: 2rem;
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
      <a href="#" class="logo">
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
      <a href="/production" class="nav-item">
        <span class="nav-icon">
          <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
          </svg>
        </span>
        <span>Production / Upload</span>
      </a>
      <a href="/revision" class="nav-item">
        <span class="nav-icon">
          <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
          </svg>
        </span>
        <span>Revision</span>
      </a>
      <a href="/publishing" class="nav-item">
        <span class="nav-icon">
          <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
          </svg>
        </span>
        <span>Publishing</span>
      </a>
      <a href="/analytics" class="nav-item">
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
        <h1>Dashboard Creator</h1>
      </div>
      
      <div class="navbar-right">
        <div class="user-info">
          <div class="user-details">
            <div class="user-name">{{ $user->name }}</div>
            <div class="user-role">Content Creator</div>
          </div>
          <div class="user-avatar">
            {{ substr($user->name, 0, 1) }}
          </div>
        </div>
      </div>
    </header>

    <!-- Content Area -->
    <div class="content">
      <!-- Welcome Section -->
      <div class="welcome-section">
        <h2 class="welcome-text">Selamat datang, {{ $user->name }} 👋</h2>
        <p class="welcome-sub">Ini adalah ringkasan aktivitas konten Anda hari ini</p>
      </div>

      <!-- Stats Grid -->
      <div class="stats-grid">
        <div class="stat-card" style="--index: 0">
          <div class="stat-icon">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
            </svg>
          </div>
          <div class="stat-number">{{ $stats['total_brands'] }}</div>
          <div class="stat-label">Total Brand</div>
        </div>
        
        <div class="stat-card" style="--index: 1">
          <div class="stat-icon">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
          </div>
          <div class="stat-number">{{ $stats['total_contents'] }}</div>
          <div class="stat-label">Total Konten</div>
        </div>
        
        <div class="stat-card" style="--index: 2">
          <div class="stat-icon">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
            </svg>
          </div>
          <div class="stat-number">{{ $stats['in_production'] }}</div>
          <div class="stat-label">In Production</div>
        </div>
        
        <div class="stat-card" style="--index: 3">
          <div class="stat-icon">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
              <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
            </svg>
          </div>
          <div class="stat-number">{{ $stats['under_review'] }}</div>
          <div class="stat-label">Under Review</div>
        </div>
        
        <div class="stat-card" style="--index: 4">
          <div class="stat-icon">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
            </svg>
          </div>
          <div class="stat-number">{{ $stats['need_revision'] }}</div>
          <div class="stat-label">Need Revision</div>
        </div>
        
        <div class="stat-card" style="--index: 5">
          <div class="stat-icon">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
          </div>
          <div class="stat-number">{{ $stats['ready_to_publish'] }}</div>
          <div class="stat-label">Ready to Publish</div>
        </div>
        
        <div class="stat-card" style="--index: 6">
          <div class="stat-icon">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
            </svg>
          </div>
          <div class="stat-number">{{ $stats['published'] }}</div>
          <div class="stat-label">Published</div>
        </div>
      </div>

      <!-- Deadline Table -->
      <div class="section-card">
        <div class="section-header">
          <h3 class="section-title">
            <span>⏰</span>
            Deadline Terdekat
          </h3>
        </div>
        
        <table class="table">
          <thead>
            <tr>
              <th>Judul Konten</th>
              <th>Brand</th>
              <th>Deadline Produksi</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            @foreach($deadlines as $deadline)
            <tr>
              <td>{{ $deadline['title'] }}</td>
              <td>{{ $deadline['brand'] }}</td>
              <td>{{ \Carbon\Carbon::parse($deadline['deadline'])->format('d M Y') }}</td>
              <td>
                <span class="status-badge {{ $deadline['status'] == 'In Production' ? 'production' : ($deadline['status'] == 'Under Review' ? 'review' : 'revision') }}">
                  {{ $deadline['status'] }}
                </span>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>

      <!-- Activity List -->
      <div class="section-card">
        <div class="section-header">
          <h3 class="section-title">
            <span>📋</span>
            Aktivitas Terbaru
          </h3>
        </div>
        
        <div class="activity-list">
          <div class="activity-item" style="--index: 0">
            <div class="icon-activity">
              <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
              </svg>
            </div>
            <div class="activity-content">
              <div class="activity-message">Brief baru diberikan untuk "Summer Campaign"</div>
              <div class="activity-time">2 jam yang lalu</div>
            </div>
          </div>
          
          <div class="activity-item" style="--index: 1">
            <div class="icon-activity">
              <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
              </svg>
            </div>
            <div class="activity-content">
              <div class="activity-message">Upload video untuk "Product Launch" berhasil</div>
              <div class="activity-time">5 jam yang lalu</div>
            </div>
          </div>
          
          <div class="activity-item" style="--index: 2">
            <div class="icon-activity">
              <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
              </svg>
            </div>
            <div class="activity-content">
              <div class="activity-message">Revisi diberikan untuk "Brand Story"</div>
              <div class="activity-time">1 hari yang lalu</div>
            </div>
          </div>
          
          <div class="activity-item" style="--index: 3">
            <div class="icon-activity">
              <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
              </svg>
            </div>
            <div class="activity-content">
              <div class="activity-message">Konten "Tech Review" diapprove</div>
              <div class="activity-time">2 hari yang lalu</div>
            </div>
          </div>
          
          <div class="activity-item" style="--index: 4">
            <div class="icon-activity">
              <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
              </svg>
            </div>
            <div class="activity-content">
              <div class="activity-message">Konten "Food Festival" dipublish</div>
              <div class="activity-time">3 hari yang lalu</div>
            </div>
          </div>
        </div>
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

  // Add interactive hover effects
  document.addEventListener('DOMContentLoaded', function() {
    // Add click feedback to stat cards
    document.querySelectorAll('.stat-card').forEach(card => {
      card.addEventListener('click', function() {
        this.style.transform = 'scale(0.95)';
        setTimeout(() => {
          this.style.transform = '';
        }, 150);
      });
    });

    // Smooth scroll for mobile
    if (window.innerWidth <= 768) {
      document.querySelectorAll('.nav-item').forEach(item => {
        item.addEventListener('click', function() {
          const sidebar = document.getElementById('sidebar');
          sidebar.classList.remove('open');
        });
      });
    }
  });
</script>

</body>
</html>
