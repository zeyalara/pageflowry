@extends('layouts.admin')

@section('page-title', 'Dashboard')

@section('content')
<div class="page-header">
    <div class="page-title">
        <i class="fa-solid fa-home"></i>
        Dashboard Creator
    </div>
    <div class="page-actions">
        <button class="btn btn-primary" onclick="window.location.href='{{ route('content-tasks.create') }}'">
            <i class="fa-solid fa-plus"></i>
            Buat Content Brief
        </button>
    </div>
</div>

<div class="quick-links-grid">
    <a class="quick-link-item" href="{{ route('content-tasks.create') }}">
        <i class="fa-solid fa-plus"></i>
        <span>Buat Tugas Konten</span>
    </a>
    <a class="quick-link-item" href="{{ route('content-tasks.index') }}">
        <i class="fa-solid fa-list-check"></i>
        <span>Daftar Tugas Konten</span>
    </a>
    <a class="quick-link-item" href="{{ route('brands.index') }}">
        <i class="fa-solid fa-tag"></i>
        <span>Brand</span>
    </a>
    <a class="quick-link-item" href="{{ route('publishing.index') }}">
        <i class="fa-solid fa-paper-plane"></i>
        <span>Published</span>
    </a>
</div>

<!-- Stats Cards -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon">
            <i class="fa-solid fa-briefcase"></i>
        </div>
        <div class="stat-content">
            <div class="stat-number">{{ $stats['total_brands'] ?? 0 }}</div>
            <div class="stat-label">Total Brands</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon">
            <i class="fa-solid fa-file-alt"></i>
        </div>
        <div class="stat-content">
            <div class="stat-number">{{ $stats['total_contents'] ?? 0 }}</div>
            <div class="stat-label">Total Konten</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon">
            <i class="fa-solid fa-clock"></i>
        </div>
        <div class="stat-content">
            <div class="stat-number">{{ $stats['in_production'] ?? 0 }}</div>
            <div class="stat-label">In Production</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon">
            <i class="fa-solid fa-eye"></i>
        </div>
        <div class="stat-content">
            <div class="stat-number">{{ $stats['published'] ?? 0 }}</div>
            <div class="stat-label">Published</div>
        </div>
    </div>
</div>

<!-- Recent Activity -->
<div class="card">
    <div class="card-header">
        <h3>Konten Terbaru</h3>
    </div>
    <div class="card-body">
        <div class="activity-list">
            @forelse ($recentContent as $content)
                <div class="activity-item">
                    <div class="activity-icon">
                        <i class="fa-solid fa-file-alt text-info"></i>
                    </div>
                    <div class="activity-content">
                        <div class="activity-title">{{ $content->title }}</div>
                        <div class="activity-meta">
                            <span class="brand-name">{{ $content->brand->name ?? 'No Brand' }}</span>
                            <span class="status-badge status-{{ str_replace(' ', '-', strtolower($content->status)) }}">
                                {{ $content->status }}
                            </span>
                        </div>
                        <div class="activity-time">{{ $content->created_at->diffForHumans() }}</div>
                    </div>
                </div>
            @empty
                <div class="empty-state">
                    <i class="fa-solid fa-inbox fa-3x"></i>
                    <p>Belum ada konten yang dibuat</p>
                    <a href="{{ route('content-tasks.create') }}" class="btn btn-primary">
                        <i class="fa-solid fa-plus"></i>
                        Buat Content Brief Pertama
                    </a>
                </div>
            @endforelse
        </div>
    </div>
</div>

<style>
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
    margin-bottom: 30px;
}

.quick-links-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 12px;
    margin-bottom: 20px;
}

.quick-link-item {
    display: flex;
    align-items: center;
    gap: 10px;
    background: #ffffff;
    border: 1px solid #e5e7eb;
    border-radius: 10px;
    padding: 12px 14px;
    text-decoration: none;
    color: #1A2740;
    font-weight: 600;
    transition: all 0.2s ease;
}

.quick-link-item:hover {
    border-color: #5C97F5;
    background: #f8fbff;
    transform: translateY(-1px);
}

.stat-card {
    background: white;
    border-radius: 12px;
    padding: 20px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    display: flex;
    align-items: center;
    gap: 15px;
}

.stat-icon {
    width: 50px;
    height: 50px;
    border-radius: 10px;
    background: #f0f6ff;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #5C97F5;
    font-size: 20px;
}

.stat-number {
    font-size: 24px;
    font-weight: bold;
    color: #1A2740;
    margin-bottom: 5px;
}

.stat-label {
    font-size: 14px;
    color: #6B7E95;
}

.activity-list {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.activity-item {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 15px;
    border-radius: 8px;
    background: #f8f9fa;
}

.activity-icon {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: white;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.activity-content {
    flex: 1;
}

.activity-title {
    font-weight: 600;
    color: #1A2740;
    margin-bottom: 5px;
}

.activity-time {
    font-size: 12px;
    color: #6B7E95;
}

.activity-meta {
    display: flex;
    gap: 10px;
    align-items: center;
    margin-bottom: 5px;
}

.brand-name {
    font-size: 12px;
    color: #6B7E95;
    background: #f0f6ff;
    padding: 2px 8px;
    border-radius: 12px;
}

.status-badge {
    font-size: 11px;
    font-weight: 600;
    padding: 2px 8px;
    border-radius: 12px;
    text-transform: uppercase;
}

.status-in-production {
    background: #fff3cd;
    color: #856404;
}

.status-under-review {
    background: #d1ecf1;
    color: #0c5460;
}

.status-need-revision {
    background: #f8d7da;
    color: #721c24;
}

.status-ready-to-publish {
    background: #d4edda;
    color: #155724;
}

.status-published {
    background: #d1f2eb;
    color: #1f2937;
}

.empty-state {
    text-align: center;
    padding: 40px 20px;
    color: #6B7E95;
}

.empty-state i {
    color: #d1d5db;
    margin-bottom: 20px;
}

.empty-state p {
    font-size: 16px;
    margin-bottom: 20px;
}

.page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
}

.page-title {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 24px;
    font-weight: bold;
    color: #1A2740;
}

.page-actions {
    display: flex;
    gap: 10px;
}

.btn {
    padding: 10px 20px;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s;
}

.btn-primary {
    background: #5C97F5;
    color: white;
}

.btn-primary:hover {
    background: #4A84E0;
}

.card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    overflow: hidden;
}

.card-header {
    padding: 20px;
    border-bottom: 1px solid #e5e7eb;
}

.card-header h3 {
    margin: 0;
    font-size: 18px;
    font-weight: bold;
    color: #1A2740;
}

.card-body {
    padding: 20px;
}
</style>
@endsection
