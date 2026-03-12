@extends('layouts.admin')

@section('page-title', 'Brand Management Test')

@section('content')
<div style="padding: 20px;">
    <h1>Brand Management - Debug Sidebar</h1>
    
    <h3>Test Sidebar Links:</h3>
    <ul style="list-style: none; padding: 0;">
        <li style="margin: 10px 0;">
            <a href="{{ route('admin.dashboard') }}" style="display: inline-block; padding: 10px 20px; background: blue; color: white; text-decoration: none;">
                🏠 Dashboard Test
            </a>
        </li>
        <li style="margin: 10px 0;">
            <a href="{{ route('content-tasks.index') }}" style="display: inline-block; padding: 10px 20px; background: green; color: white; text-decoration: none;">
            📋 Daftar Tugas Konten Test
            </a>
        </li>
        <li style="margin: 10px 0;">
            <a href="{{ route('production.index') }}" style="display: inline-block; padding: 10px 20px; background: orange; color: white; text-decoration: none;">
            🎬 Production Test
            </a>
        </li>
        <li style="margin: 10px 0;">
            <a href="{{ route('analytics.index') }}" style="display: inline-block; padding: 10px 20px; background: purple; color: white; text-decoration: none;">
            📊 Analytics Test
            </a>
        </li>
        <li style="margin: 10px 0;">
            <a href="{{ route('settings.index') }}" style="display: inline-block; padding: 10px 20px; background: red; color: white; text-decoration: none;">
            ⚙️ Settings Test
            </a>
        </li>
    </ul>
    
    <h3>Current Route Info:</h3>
    <p>Current route name: {{ request()->route()->getName() }}</p>
    <p>Current URL: {{ request()->url() }}</p>
    
    <h3>Sidebar Debug:</h3>
    <p>Jika link di atas berfungsi, tapi sidebar tidak berfungsi, berarti ada masalah dengan CSS atau JavaScript pada sidebar.</p>
    
    <h3>Manual Sidebar Test:</h3>
    <div style="background: #f5f5f5; padding: 15px; border-radius: 8px;">
        <h4>Manual Sidebar (Copy of Layout Sidebar):</h4>
        <div class="sb-nav" style="display: flex; flex-direction: column;">
            <div style="font-size: 10px; font-weight: 700; color: #666; margin: 10px 0;">Overview</div>
            <a href="{{ route('admin.dashboard') }}" style="display: flex; align-items: center; gap: 10px; padding: 10px; text-decoration: none; color: #333; background: white; margin: 2px 0; border-radius: 6px;">
                <span>🏠</span> Dashboard
            </a>
            
            <div style="font-size: 10px; font-weight: 700; color: #666; margin: 10px 0;">Manajemen</div>
            <a href="{{ route('brands.index') }}" style="display: flex; align-items: center; gap: 10px; padding: 10px; text-decoration: none; color: #333; background: #e3f2fd; margin: 2px 0; border-radius: 6px;">
                <span>🏷️</span> Brand Management
            </a>
            <a href="{{ route('content-tasks.index') }}" style="display: flex; align-items: center; gap: 10px; padding: 10px; text-decoration: none; color: #333; background: white; margin: 2px 0; border-radius: 6px;">
                <span>📋</span> Daftar Tugas Konten
            </a>
            
            <div style="font-size: 10px; font-weight: 700; color: #666; margin: 10px 0;">Workflow</div>
            <a href="{{ route('production.index') }}" style="display: flex; align-items: center; gap: 10px; padding: 10px; text-decoration: none; color: #333; background: white; margin: 2px 0; border-radius: 6px;">
                <span>🎬</span> Production
            </a>
            <a href="{{ route('analytics.index') }}" style="display: flex; align-items: center; gap: 10px; padding: 10px; text-decoration: none; color: #333; background: white; margin: 2px 0; border-radius: 6px;">
                <span>📊</span> Analytics
            </a>
            <a href="{{ route('settings.index') }}" style="display: flex; align-items: center; gap: 10px; padding: 10px; text-decoration: none; color: #333; background: white; margin: 2px 0; border-radius: 6px;">
                <span>⚙️</span> Settings
            </a>
        </div>
    </div>
</div>
@endsection
