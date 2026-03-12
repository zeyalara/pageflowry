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

    .navbar-left {
      display: flex;
      align-items: center;
      gap: 16px;
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

    /* Hero Section */
    .hero-section {
      background: linear-gradient(135deg, var(--soft), rgba(92,151,245,0.08));
      border-radius: 20px;
      padding: 48px;
      margin-bottom: 48px;
      position: relative;
      overflow: hidden;
    }

    .hero-section.enhanced {
      padding: 60px;
      background: linear-gradient(135deg, var(--soft), rgba(92,151,245,0.1));
    }

    .hero-section.saas {
      background: linear-gradient(135deg, var(--soft), rgba(92,151,245,0.05));
      border-radius: 20px;
      padding: 40px;
      height: 240px;
      margin-bottom: 32px;
      position: relative;
      overflow: hidden;
    }

    .hero-section::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 200"><defs><pattern id="grid" width="40" height="40" patternUnits="userSpaceOnUse"><path d="M 40 40.5H.5" stroke="rgba(92,151,245,0.1)" fill="none"/></pattern></defs><rect width="100%" height="100%" fill="url(%23grid)"/></svg>');
      opacity: 0.03;
    }

    .hero-content {
      display: grid;
      grid-template-columns: 1fr 1.5fr;
      gap: 48px;
      align-items: center;
    }

    .hero-section.enhanced .hero-content {
      grid-template-columns: 1fr 1.8fr;
      gap: 60px;
    }

    .hero-section.saas .hero-content {
      grid-template-columns: 1fr 1fr;
      gap: 40px;
      align-items: center;
    }

    .hero-title {
      font-size: 2.5rem;
      font-weight: 800;
      color: var(--dark);
      margin-bottom: 12px;
      letter-spacing: -1px;
      line-height: 1.2;
    }

    .hero-section.saas .hero-title {
      font-size: 1.75rem;
      font-weight: 700;
      color: #1E293B;
      margin-bottom: 8px;
      letter-spacing: -0.025em;
      line-height: 1.2;
      padding-bottom: 2px;
    }

    .hero-subtitle {
      font-size: 1.125rem;
      color: var(--muted);
      margin: 0;
      line-height: 1.5;
    }

    .hero-section.saas .hero-subtitle {
      font-size: 0.875rem;
      color: #64748B;
      margin-bottom: 20px;
      line-height: 1.5;
    }

    .hero-stats {
      display: flex;
      gap: 24px;
      margin-top: 24px;
    }

    .hero-section.saas .hero-stats {
      gap: 16px;
      margin-top: 0;
    }

    .hero-stat {
      text-align: center;
      background: var(--white);
      border-radius: 12px;
      padding: 16px;
      min-width: 80px;
      box-shadow: 0 4px 12px rgba(92,151,245,0.1);
      transition: all 0.3s ease;
    }

    .hero-section.saas .hero-stat {
      background: #ffffff;
      border: 1px solid rgba(148, 163, 184, 0.1);
      border-radius: 8px;
      padding: 12px 16px;
      min-width: 70px;
      box-shadow: none;
      transition: all 0.2s ease;
    }

    .hero-stat:hover {
      transform: translateY(-4px);
      box-shadow: 0 8px 20px rgba(92,151,245,0.2);
    }

    .hero-section.saas .hero-stat:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
      border-color: rgba(92, 151, 245, 0.3);
    }

    .hero-number {
      font-size: 1.5rem;
      font-weight: 700;
      color: var(--blue);
      margin-bottom: 4px;
    }

    .hero-section.saas .hero-number {
      font-size: 1.25rem;
      font-weight: 600;
      color: #1E293B;
      margin-bottom: 2px;
    }

    .hero-label {
      font-size: 0.75rem;
      color: var(--muted);
      font-weight: 500;
    }

    .hero-section.saas .hero-label {
      font-size: 0.75rem;
      color: #64748B;
      font-weight: 500;
    }

    .hero-illustration {
      display: flex;
      justify-content: center;
    }

    .illustration-card {
      background: var(--white);
      border-radius: 20px;
      padding: 32px;
      box-shadow: 0 20px 40px rgba(92,151,245,0.15);
      position: relative;
      overflow: hidden;
      transition: all 0.3s ease;
    }

    .illustration-large {
      background: var(--white);
      border-radius: 24px;
      padding: 40px;
      box-shadow: 0 30px 60px rgba(92,151,245,0.2);
      position: relative;
      overflow: hidden;
      transition: all 0.4s ease;
    }

    .illustration-clean {
      background: #ffffff;
      border-radius: 12px;
      padding: 24px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
      position: relative;
      overflow: hidden;
      transition: all 0.3s ease;
    }

    .illustration-card:hover {
      transform: translateY(-8px) scale(1.02);
      box-shadow: 0 30px 60px rgba(92,151,245,0.25);
    }

    .illustration-large:hover {
      transform: translateY(-12px) scale(1.03);
      box-shadow: 0 40px 80px rgba(92,151,245,0.3);
    }

    .illustration-clean:hover {
      transform: translateY(-4px);
      box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
    }

    .illustration-image {
      width: 100%;
      max-width: 400px;
      height: auto;
    }

    /* Enhanced Stats Section */
    .enhanced-stats-section {
      margin-bottom: 48px;
    }

    .enhanced-stats-section.saas {
      margin-bottom: 24px;
    }

    .stats-header {
      text-align: center;
      margin-bottom: 32px;
    }

    .enhanced-stats-section.saas .stats-header {
      text-align: left;
      margin-bottom: 24px;
    }

    .stats-title {
      font-size: 1.75rem;
      font-weight: 700;
      color: var(--dark);
      margin-bottom: 8px;
    }

    .enhanced-stats-section.saas .stats-title {
      font-size: 1.25rem;
      font-weight: 600;
      color: #1E293B;
      margin-bottom: 4px;
    }

    .stats-subtitle {
      font-size: 1rem;
      color: var(--muted);
      margin: 0;
    }

    .enhanced-stats-section.saas .stats-subtitle {
      font-size: 0.875rem;
      color: #64748B;
      margin: 0;
    }

    .stat-card.enhanced {
      background: var(--white);
      border-radius: 16px;
      padding: 24px;
      box-shadow: 0 4px 20px rgba(92,151,245,0.08);
      transition: all 0.3s ease;
      position: relative;
      overflow: hidden;
    }

    .stat-card.enhanced::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 4px;
      background: linear-gradient(90deg, var(--blue), var(--blue-dark));
      opacity: 0;
      transition: opacity 0.3s ease;
    }

    .stat-card.enhanced:hover {
      transform: translateY(-6px) scale(1.03);
      box-shadow: 0 12px 30px rgba(92,151,245,0.2);
    }

    .stat-card.enhanced:hover::before {
      opacity: 1;
    }

    .stat-card.saas {
      background: #ffffff;
      border: 1px solid rgba(148, 163, 184, 0.1);
      border-radius: 12px;
      padding: 20px;
      transition: all 0.2s ease;
      position: relative;
      overflow: hidden;
    }

    .stat-card.saas::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 3px;
      background: linear-gradient(90deg, #5C97F5, #4A84E0);
      opacity: 0;
      transition: opacity 0.2s ease;
    }

    .stat-card.saas:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
      border-color: rgba(92, 151, 245, 0.3);
    }

    .stat-card.saas:hover::before {
      opacity: 1;
    }

    .stat-content {
      text-align: center;
    }

    .stat-card.enhanced .stat-number {
      font-size: 2rem;
      font-weight: 700;
      color: var(--dark);
      margin-bottom: 4px;
    }

    .stat-card.enhanced .stat-label {
      font-size: 0.875rem;
      color: var(--muted);
      font-weight: 500;
    }

    .stat-card.saas .stat-number {
      font-size: 1.5rem;
      font-weight: 600;
      color: #1E293B;
      margin-bottom: 4px;
    }

    .stat-card.saas .stat-label {
      font-size: 0.75rem;
      color: #64748B;
      font-weight: 500;
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

      .content {
        padding: 20px;
      }

      .navbar {
        padding: 0 20px;
      }

      .hero-content {
        grid-template-columns: 1fr;
        gap: 24px;
      }

      .hero-section.enhanced .hero-content {
        grid-template-columns: 1fr;
        gap: 32px;
      }

      .hero-section.saas .hero-title {
        font-size: 1.5rem;
        line-height: 1.3;
        margin-bottom: 10px;
      }

      .hero-section.saas .hero-subtitle {
        font-size: 0.875rem;
        margin-bottom: 16px;
      }

      .hero-stats {
        flex-direction: column;
        gap: 12px;
        margin-top: 16px;
      }

      .hero-stat {
        padding: 12px;
        min-width: 100%;
      }

      .hero-number {
        font-size: 1.25rem;
      }

      .illustration-card {
        padding: 20px;
      }

      .illustration-large {
        padding: 24px;
      }

      .stats-grid {
        grid-template-columns: 1fr;
        gap: 16px;
      }

      .stat-card.enhanced {
        padding: 16px;
      }

      .stat-card.enhanced .stat-number {
        font-size: 1.5rem;
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
      <a href="<?php echo e(route('creator.dashboard')); ?>" class="nav-item <?php echo e(request()->is('creator/dashboard') ? 'active' : ''); ?>">
        <span class="nav-icon">
          <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z"/>
          </svg>
        </span>
        <span>Dashboard</span>
      </a>
      <a href="<?php echo e(route('brands.index')); ?>" class="nav-item <?php echo e(request()->is('brands*') ? 'active' : ''); ?>">
        <span class="nav-icon">
          <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
          </svg>
        </span>
        <span>Brand Management</span>
      </a>
      <a href="<?php echo e(route('brief.index')); ?>" class="nav-item <?php echo e(request()->is('brief*') ? 'active' : ''); ?>">
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
      <a href="<?php echo e(route('logout')); ?>" class="nav-item" style="margin-top: auto; color: #DC2626;" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        <span class="nav-icon">
          <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
          </svg>
        </span>
        <span>Logout</span>
      </a>
    </nav>
    
    <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
      <?php echo csrf_field(); ?>
    </form>
  </aside>

  <!-- Main Content -->
  <main class="main-content">
    <!-- Navbar -->
    <header class="navbar">
      <div class="navbar-left">
        <h1>Dashboard Creator</h1>
      </div>
      
      <div class="navbar-right">
        <div class="user-info">
          <div class="user-details">
            <div class="user-name"><?php echo e($user->name); ?></div>
            <div class="user-role">Content Creator</div>
          </div>
          <div class="user-avatar">
            <?php echo e(substr($user->name, 0, 1)); ?>

          </div>
        </div>
      </div>
    </header>

    <!-- Content Area -->
    <div class="content">
      <!-- Hero Section -->
      <div class="hero-section saas">
        <div class="hero-content">
          <div class="hero-text">
            <h1 class="hero-title">Selamat datang, <?php echo e($user->name); ?></h1>
            <p class="hero-subtitle">Ini adalah ringkasan aktivitas konten Anda hari ini</p>
            <div class="hero-stats">
              <div class="hero-stat">
                <div class="hero-number"><?php echo e($stats['total_brands']); ?></div>
                <div class="hero-label">Brands</div>
              </div>
              <div class="hero-stat">
                <div class="hero-number"><?php echo e($stats['total_contents']); ?></div>
                <div class="hero-label">Konten</div>
              </div>
              <div class="hero-stat">
                <div class="hero-number"><?php echo e($stats['published'] ?? 0); ?></div>
                <div class="hero-label">Published</div>
              </div>
            </div>
          </div>
          <div class="hero-illustration">
            <div class="illustration-clean">
              <svg viewBox="0 0 300 200" fill="none">
                <!-- Clean workflow illustration -->
                <rect x="20" y="60" width="80" height="50" rx="8" fill="#F8FAFC" stroke="#E2E8F0" stroke-width="1"/>
                <rect x="25" y="65" width="70" height="40" rx="4" fill="#ffffff" stroke="#E2E8F0" stroke-width="1"/>
                <circle cx="100" cy="85" r="4" fill="#5C97F5"/>
                <rect x="35" y="75" width="50" height="3" rx="1.5" fill="#E2E8F0"/>
                <circle cx="45" cy="76.5" r="2" fill="#5C97F5"/>
                
                <!-- Connection lines -->
                <path d="M100 85 L130 85" stroke="#E2E8F0" stroke-width="2" stroke-dasharray="4 4"/>
                <circle cx="115" cy="85" r="2" fill="#5C97F5"/>
                
                <!-- Second element -->
                <rect x="130" y="60" width="80" height="50" rx="8" fill="#F8FAFC" stroke="#E2E8F0" stroke-width="1"/>
                <rect x="135" y="65" width="70" height="40" rx="4" fill="#ffffff" stroke="#E2E8F0" stroke-width="1"/>
                <circle cx="210" cy="85" r="4" fill="#10B981"/>
                <rect x="145" y="75" width="50" height="3" rx="1.5" fill="#E2E8F0"/>
                <circle cx="155" cy="76.5" r="2" fill="#10B981"/>
                
                <!-- Connection lines -->
                <path d="M210 85 L240 85" stroke="#E2E8F0" stroke-width="2" stroke-dasharray="4 4"/>
                <circle cx="225" cy="85" r="2" fill="#10B981"/>
                
                <!-- Third element -->
                <rect x="240" y="60" width="80" height="50" rx="8" fill="#F8FAFC" stroke="#E2E8F0" stroke-width="1"/>
                <rect x="245" y="65" width="70" height="40" rx="4" fill="#ffffff" stroke="#E2E8F0" stroke-width="1"/>
                <circle cx="320" cy="85" r="4" fill="#F59E0B"/>
                <rect x="255" y="75" width="50" height="3" rx="1.5" fill="#E2E8F0"/>
                <circle cx="265" cy="76.5" r="2" fill="#F59E0B"/>
                
                <!-- Success indicator -->
                <circle cx="170" cy="140" r="20" fill="#10B981" opacity="0.1"/>
                <circle cx="170" cy="140" r="12" fill="#10B981"/>
                <path d="M160 140 L165 145 L180 130" stroke="#ffffff" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </div>
          </div>
        </div>
      </div>

      <!-- Enhanced Stats Section -->
      <div class="enhanced-stats-section saas">
        <div class="stats-header">
          <h2 class="stats-title">Workflow Overview</h2>
          <p class="stats-subtitle">Monitor progress kontenmu secara real-time</p>
        </div>
        
        <div class="stats-grid">
          <div class="stat-card saas" style="--index: 0">
            <div class="stat-icon">
              <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
              </svg>
            </div>
            <div class="stat-content">
              <div class="stat-number"><?php echo e($stats['total_brands']); ?></div>
              <div class="stat-label">Total Brand</div>
            </div>
          </div>
          
          <div class="stat-card saas" style="--index: 1">
            <div class="stat-icon">
              <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
              </svg>
            </div>
            <div class="stat-content">
              <div class="stat-number"><?php echo e($stats['total_contents']); ?></div>
              <div class="stat-label">Total Konten</div>
            </div>
          </div>
          
          <div class="stat-card saas" style="--index: 2">
            <div class="stat-icon">
              <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
              </svg>
            </div>
            <div class="stat-content">
              <div class="stat-number"><?php echo e($stats['in_production'] ?? 0); ?></div>
              <div class="stat-label">In Production</div>
            </div>
          </div>
          
          <div class="stat-card saas" style="--index: 3">
            <div class="stat-icon">
              <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
              </svg>
            </div>
            <div class="stat-content">
              <div class="stat-number"><?php echo e($stats['under_review'] ?? 0); ?></div>
              <div class="stat-label">Under Review</div>
            </div>
          </div>
          
          <div class="stat-card saas" style="--index: 4">
            <div class="stat-icon">
              <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
              </svg>
            </div>
            <div class="stat-content">
              <div class="stat-number"><?php echo e($stats['need_revision'] ?? 0); ?></div>
              <div class="stat-label">Need Revision</div>
            </div>
          </div>
          
          <div class="stat-card saas" style="--index: 5">
            <div class="stat-icon">
              <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
              </svg>
            </div>
            <div class="stat-content">
              <div class="stat-number"><?php echo e($stats['ready_to_publish'] ?? 0); ?></div>
              <div class="stat-label">Ready to Publish</div>
            </div>
          </div>
          
          <div class="stat-card saas" style="--index: 6">
            <div class="stat-icon">
              <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
              </svg>
            </div>
            <div class="stat-content">
              <div class="stat-number"><?php echo e($stats['published'] ?? 0); ?></div>
              <div class="stat-label">Published</div>
            </div>
          </div>
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
            <?php $__currentLoopData = $deadlines; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $deadline): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
              <td><?php echo e($deadline['title']); ?></td>
              <td><?php echo e($deadline['brand']); ?></td>
              <td><?php echo e(\Carbon\Carbon::parse($deadline['deadline'])->format('d M Y')); ?></td>
              <td>
                <span class="status-badge <?php echo e($deadline['status'] == 'In Production' ? 'production' : ($deadline['status'] == 'Under Review' ? 'review' : 'revision')); ?>">
                  <?php echo e($deadline['status']); ?>

                </span>
              </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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

    // Add hover effects to buttons
    document.querySelectorAll('.btn-primary, .btn-secondary').forEach(btn => {
      btn.addEventListener('mouseenter', function() {
        this.style.transform = 'translateY(-2px)';
      });
      btn.addEventListener('mouseleave', function() {
        this.style.transform = '';
      });
    });
  });
</script>

</body>
</html><?php /**PATH C:\xampp444\htdocs\laravel\pageflowry\resources\views/dashboard/creator.blade.php ENDPATH**/ ?>