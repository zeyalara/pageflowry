<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Brand Management - PAGEFLOWRY</title>
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

    /* Brand Header Section */
    .brand-header-section {
      background: linear-gradient(135deg, var(--soft), rgba(92,151,245,0.05));
      border-radius: 20px;
      padding: 40px;
      margin-bottom: 32px;
      position: relative;
      overflow: hidden;
    }

    .brand-header-section::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 200"><defs><pattern id="grid" width="40" height="40" patternUnits="userSpaceOnUse"><path d="M 40 40.5H.5" stroke="rgba(92,151,245,0.1)" fill="none"/></pattern></defs><rect width="100%" height="100%" fill="url(%23grid)"/></svg>');
      opacity: 0.03;
    }

    .header-content {
      display: grid;
      grid-template-columns: 1fr 1.5fr;
      gap: 40px;
      align-items: center;
    }

    .page-title {
      font-size: 2rem;
      font-weight: 700;
      color: var(--dark);
      margin-bottom: 8px;
      letter-spacing: -0.5px;
    }

    .page-subtitle {
      font-size: 1rem;
      color: var(--muted);
      margin: 0;
      line-height: 1.5;
    }

    .header-illustration {
      display: flex;
      justify-content: center;
    }

    .illustration-small {
      background: var(--white);
      border-radius: 20px;
      padding: 24px;
      box-shadow: 0 20px 40px rgba(92,151,245,0.15);
      position: relative;
      overflow: hidden;
      transition: all 0.3s ease;
    }

    .illustration-small:hover {
      transform: translateY(-4px) scale(1.02);
      box-shadow: 0 30px 60px rgba(92,151,245,0.25);
    }

    /* Header Section */
    .header-section {
      display: flex;
      justify-content: between;
      align-items: center;
      margin-bottom: 32px;
      flex-wrap: wrap;
      gap: 20px;
    }

    .header-title {
      font-size: 1.75rem;
      font-weight: 700;
      color: var(--dark);
      letter-spacing: -0.5px;
    }

    .btn-primary {
      background: linear-gradient(135deg, var(--blue), var(--blue-deep));
      color: var(--white);
      border: none;
      padding: 12px 24px;
      border-radius: 12px;
      font-size: 0.875rem;
      font-weight: 600;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: 8px;
      transition: all 0.3s ease;
      box-shadow: 0 4px 15px rgba(92,151,245,0.3);
    }

    .btn-primary:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 25px rgba(92,151,245,0.4);
    }

    /* Table Card */
    .table-card {
      background: var(--white);
      border-radius: 16px;
      padding: 24px;
      box-shadow: 0 4px 20px rgba(92,151,245,0.08);
      border: 1px solid rgba(92,151,245,0.08);
      overflow: hidden;
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

    /* Status Badge */
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

    .status-badge.active {
      background: #F0FFF4;
      color: #38A169;
    }

    .status-badge.inactive {
      background: #FFF0F0;
      color: #DC2626;
    }

    /* Action Buttons */
    .action-buttons {
      display: flex;
      gap: 8px;
    }

    .btn-action {
      padding: 6px 12px;
      border: none;
      border-radius: 8px;
      font-size: 0.75rem;
      font-weight: 500;
      cursor: pointer;
      transition: all 0.2s ease;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: 4px;
    }

    .btn-detail {
      background: var(--soft);
      color: var(--blue);
    }

    .btn-detail:hover {
      background: var(--blue);
      color: var(--white);
    }

    .btn-edit {
      background: #FFFBEB;
      color: #D97706;
    }

    .btn-edit:hover {
      background: #D97706;
      color: var(--white);
    }

    .btn-delete {
      background: #FFF0F0;
      color: #DC2626;
    }

    .btn-delete:hover {
      background: #DC2626;
      color: var(--white);
    }

    /* Alert Messages */
    .alert {
      padding: 12px 16px;
      border-radius: 12px;
      margin-bottom: 24px;
      display: flex;
      align-items: center;
      gap: 8px;
      font-size: 0.875rem;
      font-weight: 500;
    }

    .alert-success {
      background: #F0FFF4;
      color: #38A169;
      border: 1px solid rgba(56,161,105,0.2);
    }

    /* Empty State */
    .empty-state {
      text-align: center;
      padding: 60px 20px;
      color: var(--muted);
    }

    .empty-state-icon {
      font-size: 3rem;
      margin-bottom: 16px;
      opacity: 0.5;
    }

    .empty-state-text {
      font-size: 1.125rem;
      margin-bottom: 8px;
      color: var(--dark);
    }

    .empty-state-sub {
      font-size: 0.875rem;
      color: var(--muted);
    }

    /* Custom Delete Modal */
    .modal-overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.5);
      display: none;
      align-items: center;
      justify-content: center;
      z-index: 1000;
      backdrop-filter: blur(4px);
    }

    .modal-overlay.show {
      display: flex;
    }

    .modal-card {
      background: var(--white);
      border-radius: 16px;
      padding: 32px;
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
      width: 500px;
      max-width: 90%;
      position: relative;
      animation: modalSlideIn 0.3s ease-out;
    }

    @keyframes modalSlideIn {
      from {
        opacity: 0;
        transform: translateY(-30px) scale(0.95);
      }
      to {
        opacity: 1;
        transform: translateY(0) scale(1);
      }
    }

    .modal-header {
      display: flex;
      align-items: center;
      gap: 16px;
      margin-bottom: 24px;
    }

    .modal-icon {
      width: 48px;
      height: 48px;
      background: #FFF0F0;
      border-radius: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #DC2626;
    }

    .modal-title {
      font-size: 1.5rem;
      font-weight: 700;
      color: var(--dark);
      margin: 0;
    }

    .modal-body {
      margin-bottom: 32px;
    }

    .modal-message {
      font-size: 1rem;
      color: var(--dark);
      margin-bottom: 12px;
      line-height: 1.5;
    }

    .modal-warning {
      font-size: 0.875rem;
      color: var(--muted);
      font-style: italic;
    }

    .modal-footer {
      display: flex;
      gap: 12px;
      justify-content: flex-end;
    }

    .modal-footer .btn {
      padding: 12px 24px;
      border-radius: 12px;
      font-size: 0.875rem;
      font-weight: 600;
      border: none;
      cursor: pointer;
      transition: all 0.3s ease;
      display: inline-flex;
      align-items: center;
      gap: 8px;
    }

    .btn-cancel {
      background: var(--soft);
      color: var(--muted);
    }

    .btn-cancel:hover {
      background: #E1EDFF;
      color: var(--blue);
    }

    .btn-delete {
      background: #FFF0F0;
      color: #DC2626;
    }

    .btn-delete:hover {
      background: #FEE2E2;
      transform: translateY(-1px);
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

      .header-section {
        flex-direction: column;
        align-items: flex-start;
      }

      .table {
        font-size: 0.8rem;
      }

      .table th,
      .table td {
        padding: 8px;
      }

      .action-buttons {
        flex-direction: column;
        gap: 4px;
      }

      .modal-card {
        width: 90%;
        max-width: 400px;
        margin: 5% auto;
      }

      .modal-header {
        gap: 12px;
      }

      .modal-title {
        font-size: 1.25rem;
      }

      .modal-body {
        margin-bottom: 24px;
      }

      .modal-footer {
        flex-direction: column;
        gap: 8px;
      }

      .modal-footer .btn {
        width: 100%;
        justify-content: center;
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
      <a href="/creator/dashboard" class="logo">
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
        <h1>Brand Management</h1>
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
      @if(session('success'))
        <div class="alert alert-success">
          <span>✅</span>
          {{ session('success') }}
        </div>
      @endif

      <!-- Header Section -->
      <div class="brand-header-section">
        <div class="header-content">
          <div class="header-text">
            <h1 class="page-title">Brand Management</h1>
            <p class="page-subtitle">Kelola brand yang terlibat dalam produksi konten.</p>
          </div>
          <div class="header-illustration">
            <div class="illustration-small">
              <svg viewBox="0 0 200 150" fill="none">
                <!-- Brand building blocks -->
                <rect x="20" y="40" width="40" height="40" rx="8" fill="#EAF2FF" stroke="#5C97F5" stroke-width="2"/>
                <rect x="30" y="50" width="40" height="40" rx="8" fill="#EAF2FF" stroke="#5C97F5" stroke-width="2"/>
                <rect x="40" y="60" width="40" height="40" rx="8" fill="#EAF2FF" stroke="#5C97F5" stroke-width="2"/>
                
                <!-- Brand identity elements -->
                <circle cx="90" cy="50" r="20" fill="#FFF0F0" stroke="#DC2626" stroke-width="2"/>
                <rect x="110" y="40" width="60" height="20" rx="4" fill="#ffffff" stroke="#DC2626" stroke-width="2"/>
                <circle cx="140" cy="50" r="4" fill="#DC2626"/>
                <rect x="120" y="55" width="40" height="10" rx="2" fill="#ffffff" stroke="#DC2626" stroke-width="2"/>
                <circle cx="130" cy="60" r="3" fill="#DC2626"/>
                
                <!-- Creative elements -->
                <circle cx="170" cy="80" r="12" fill="#EAF2FF" stroke="#5C97F5" stroke-width="2"/>
                <path d="M160 75 L180 75 M170 70 L170 90" stroke="#5C97F5" stroke-width="2" fill="none"/>
                <circle cx="160" cy="70" r="3" fill="#5C97F5"/>
                <circle cx="180" cy="70" r="3" fill="#5C97F5"/>
              </svg>
            </div>
          </div>
        </div>
      </div>

      <!-- Action Button -->
      <div class="header-section">
        <a href="{{ route('brands.create') }}" class="btn-primary">
          <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
          </svg>
          Tambah Brand Baru
        </a>
      </div>

      <!-- Table Card -->
      <div class="table-card">
        @if($brands->count() > 0)
          <table class="table">
            <thead>
              <tr>
                <th>Nama Brand</th>
                <th>Jumlah Konten</th>
                <th>Creator</th>
                <th>Status</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              @foreach($brands as $brand)
              <tr>
                <td>{{ $brand->name }}</td>
                <td>0</td>
                <td>{{ $brand->pic }}</td>
                <td>
                  <span class="status-badge {{ $brand->status == 'Active' ? 'active' : 'inactive' }}">
                    {{ $brand->status }}
                  </span>
                </td>
                <td>
                  <div class="action-buttons">
                    <a href="{{ route('brands.show', $brand->id) }}" class="btn-action btn-detail">
                      <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                      </svg>
                      Detail
                    </a>
                    <a href="{{ route('brands.edit', $brand->id) }}" class="btn-action btn-edit">
                      <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                      </svg>
                      Edit
                    </a>
                    <a href="#" class="btn-action btn-delete" onclick="openDeleteModal({{ $brand->id }}, '{{ $brand->name }}')">
                      <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                      </svg>
                      Hapus
                    </a>
                  </div>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        @else
          <div class="empty-state">
            <div class="empty-state-icon">🏢</div>
            <div class="empty-state-text">Belum ada brand</div>
            <div class="empty-state-sub">Mulai dengan menambahkan brand pertama Anda</div>
          </div>
        @endif
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

  // Custom Delete Modal Functions
  function openDeleteModal(brandId, brandName) {
    const modal = document.getElementById('deleteModal');
    const brandNameElement = document.getElementById('brandName');
    const deleteForm = document.getElementById('deleteForm');
    
    // Set brand name in modal
    brandNameElement.textContent = brandName;
    
    // Set form action
    deleteForm.action = '/brands/' + brandId;
    
    // Show modal
    modal.classList.add('show');
    
    // Prevent body scroll
    document.body.style.overflow = 'hidden';
  }

  function closeDeleteModal() {
    const modal = document.getElementById('deleteModal');
    
    // Hide modal
    modal.classList.remove('show');
    
    // Restore body scroll
    document.body.style.overflow = 'auto';
  }

  // Close modal when clicking overlay
  document.getElementById('deleteModal').addEventListener('click', function(event) {
    if (event.target === this) {
      closeDeleteModal();
    }
  });

  // Close modal when clicking outside card
  document.querySelector('.modal-card').addEventListener('click', function(event) {
    event.stopPropagation();
  });

  // Close modal with Escape key
  document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
      closeDeleteModal();
    }
  });
</script>

<!-- Custom Delete Modal -->
<div id="deleteModal" class="modal-overlay">
  <div class="modal-card">
    <div class="modal-header">
      <div class="modal-icon">
        <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.196 2.502H8.966c-1.54 0-2.502-1.196-2.502V8.966c0-1.54 1.196-2.502 2.502H4.75c-1.54 0-2.502 1.196-2.502V17.25c0 1.54 1.196 2.502 2.502h6.75z"/>
        </svg>
      </div>
      <h3 class="modal-title">Konfirmasi Hapus</h3>
    </div>
    <div class="modal-body">
      <p class="modal-message">Apakah Anda yakin ingin menghapus brand <strong id="brandName"></strong>?</p>
      <p class="modal-warning">Tindakan ini tidak dapat dibatalkan.</p>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-cancel" onclick="closeDeleteModal()">
        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
        </svg>
        Batal
      </button>
      <form id="deleteForm" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-delete">
          <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
          </svg>
          Hapus
        </button>
      </form>
    </div>
  </div>
</div>

</body>
</html>
