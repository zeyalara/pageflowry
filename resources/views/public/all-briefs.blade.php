<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Semua Brief - {{ optional($admin)->name ?? 'Admin' }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --blue: #5897fe;
            --blue-50: #f0f7ff;
            --blue-100: #e1eeff;
            --blue-200: #c3ddff;
            --blue-300: #a4c9ff;
            --blue-400: #85b5ff;
            --blue-500: #66a0ff;
            --blue-600: #4788ff;
            --blue-700: #2e70e2;
            --blue-800: #1e5ad4;
            --blue-900: #0f4ab8;
            
            --green: #22c55e;
            --yellow: #f59e0b;
            --red: #ef4444;
            
            --white: #ffffff;
            --gray-50: #f9fafb;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-300: #d1d5db;
            --gray-400: #9ca3af;
            --gray-500: #6b7280;
            --gray-600: #4b5563;
            --gray-700: #374151;
            --gray-800: #1f2937;
            --gray-900: #111827;
            
            --border: #e5e7eb;
            --shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            
            --radius: 8px;
            --radius-lg: 12px;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            color: var(--gray-800);
            line-height: 1.6;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .header {
            background: var(--white);
            border-radius: var(--radius-lg);
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: var(--shadow-lg);
            text-align: center;
        }
        
        .header h1 {
            color: var(--blue-900);
            font-size: 2.5rem;
            margin-bottom: 10px;
            font-weight: 800;
        }
        
        .header .subtitle {
            color: var(--gray-600);
            font-size: 1.1rem;
            margin-bottom: 20px;
        }
        
        .admin-info {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            color: var(--gray-700);
            font-size: 1rem;
        }
        
        .admin-info i {
            color: var(--blue-500);
        }
        
        .briefs-section {
            background: var(--white);
            border-radius: var(--radius-lg);
            padding: 30px;
            box-shadow: var(--shadow-lg);
            margin-bottom: 30px;
        }
        
        .section-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 2px solid var(--gray-100);
        }
        
        .section-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--gray-800);
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .section-title i {
            color: var(--blue-500);
        }
        
        .brief-count {
            background: var(--blue-50);
            color: var(--blue-700);
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.9rem;
        }
        
        .briefs-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 20px;
        }
        
        .brief-card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 20px;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            cursor: pointer;
        }
        
        .brief-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }
        
        .brief-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            margin-bottom: 15px;
        }
        
        .brief-title {
            font-weight: 600;
            color: var(--gray-800);
            font-size: 1.1rem;
            line-height: 1.4;
            flex: 1;
            margin-right: 10px;
        }
        
        .brief-status {
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 0.8rem;
            font-weight: 600;
            white-space: nowrap;
        }
        
        .brief-status.task {
            background: var(--blue-50);
            color: var(--blue-700);
        }
        
        .brief-status.in-production {
            background: rgba(251, 146, 60, 0.1);
            color: #fb923c;
        }
        
        .brief-status.under-review {
            background: rgba(250, 204, 21, 0.1);
            color: #facc15;
        }
        
        .brief-status.need-revision {
            background: rgba(239, 68, 68, 0.1);
            color: #ef4444;
        }
        
        .brief-status.ready-to-publish {
            background: rgba(34, 197, 94, 0.1);
            color: #22c55e;
        }
        
        .brief-status.published {
            background: rgba(168, 85, 247, 0.1);
            color: #a855f7;
        }
        
        .brief-details {
            display: grid;
            gap: 12px;
        }
        
        .detail-item {
            display: flex;
            align-items: flex-start;
            gap: 10px;
        }
        
        .detail-item i {
            color: var(--blue-500);
            width: 20px;
            text-align: center;
            margin-top: 2px;
            font-size: 0.9rem;
        }
        
        .detail-content {
            flex: 1;
        }
        
        .detail-label {
            font-weight: 600;
            color: var(--gray-700);
            font-size: 0.9rem;
        }
        
        .detail-value {
            color: var(--gray-600);
            font-size: 0.95rem;
        }
        
        .brief-meta {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px solid var(--gray-100);
            font-size: 0.85rem;
            color: var(--gray-500);
        }
        
        .brief-meta span {
            display: flex;
            align-items: center;
            gap: 5px;
        }
        
        .deadline-warning {
            background: rgba(245, 158, 11, 0.1);
            color: #92400e;
            padding: 8px 12px;
            border-radius: var(--radius);
            border: 1px solid rgba(245, 158, 11, 0.2);
            display: flex;
            align-items: center;
            gap: 8px;
            margin-top: 10px;
            font-size: 0.85rem;
        }
        
        .deadline-warning i {
            font-size: 1rem;
        }
        
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: var(--gray-600);
        }
        
        .empty-state i {
            font-size: 4rem;
            color: var(--gray-400);
            margin-bottom: 20px;
        }
        
        .empty-state h3 {
            font-size: 1.5rem;
            margin-bottom: 10px;
            color: var(--gray-700);
        }
        
        .empty-state p {
            font-size: 1rem;
        }
        
        .footer {
            text-align: center;
            padding: 30px;
            color: var(--white);
            margin-top: 40px;
        }
        
        .footer a {
            color: var(--white);
            text-decoration: none;
            font-weight: 600;
        }
        
        .footer a:hover {
            text-decoration: underline;
        }
        
        @media (max-width: 768px) {
            .container {
                padding: 15px;
            }
            
            .header {
                padding: 20px;
            }
            
            .header h1 {
                font-size: 2rem;
            }
            
            .briefs-grid {
                grid-template-columns: 1fr;
            }
            
            .section-header {
                flex-direction: column;
                gap: 15px;
                align-items: flex-start;
            }
            
            .brief-header {
                flex-direction: column;
                gap: 10px;
            }
            
            .brief-title {
                margin-right: 0;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>Semua Brief Konten</h1>
            <div class="subtitle">Daftar lengkap brief dari admin</div>
            <div class="admin-info">
                <i class="fas fa-user"></i>
                <span>{{ optional($admin)->name ?? 'Admin' }}</span>
            </div>
        </div>

        <!-- Briefs Section -->
        <div class="briefs-section">
            <div class="section-header">
                <div class="section-title">
                    <i class="fas fa-list"></i>
                    Daftar Brief
                </div>
                <div class="brief-count">
                    {{ $allBriefs->count() }} Brief
                </div>
            </div>

            @if($allBriefs->count() > 0)
                <div class="briefs-grid">
                    @foreach($allBriefs as $brief)
                        <a href="{{ route('public.brief', $brief->share_token) }}" class="brief-card" style="text-decoration: none; color: inherit;">
                            <div class="brief-header">
                                <div class="brief-title">{{ $brief->title }}</div>
                                <div class="brief-status {{ $brief->status }}">
                                    {{ ucfirst(str_replace('_', ' ', $brief->status)) }}
                                </div>
                            </div>

                            <div class="brief-details">
                                <div class="detail-item">
                                    <i class="fas fa-tag"></i>
                                    <div class="detail-content">
                                        <div class="detail-label">Brand</div>
                                        <div class="detail-value">{{ optional($brief->brand)->name ?? 'Tidak ada brand' }}</div>
                                    </div>
                                </div>

                                <div class="detail-item">
                                    <i class="fab fa-instagram"></i>
                                    <div class="detail-content">
                                        <div class="detail-label">Platform</div>
                                        <div class="detail-value">{{ $brief->platform }}</div>
                                    </div>
                                </div>

                                <div class="detail-item">
                                    <i class="fas fa-clock"></i>
                                    <div class="detail-content">
                                        <div class="detail-label">Deadline Produksi</div>
                                        <div class="detail-value">
                                            @if($brief->production_deadline)
                                                {{ \Carbon\Carbon::parse($brief->production_deadline)->format('d M Y') }}
                                            @else
                                                Tidak ada deadline
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                @if($brief->production_deadline && \Carbon\Carbon::parse($brief->production_deadline)->isPast())
                                    <div class="deadline-warning">
                                        <i class="fas fa-exclamation-triangle"></i>
                                        <div>Deadline lewat {{ \Carbon\Carbon::parse($brief->production_deadline)->diffInDays(\Carbon\Carbon::today()) }} hari</div>
                                    </div>
                                @elseif($brief->production_deadline && \Carbon\Carbon::parse($brief->production_deadline)->diffInDays(\Carbon\Carbon::today()) <= 2)
                                    <div class="deadline-warning">
                                        <i class="fas fa-clock"></i>
                                        <div>Deadline {{ \Carbon\Carbon::parse($brief->production_deadline)->diffInDays(\Carbon\Carbon::today()) }} hari lagi</div>
                                    </div>
                                @endif
                            </div>

                            <div class="brief-meta">
                                <span>
                                    <i class="fas fa-calendar"></i>
                                    {{ $brief->created_at->format('d M Y') }}
                                </span>
                                <span>
                                    <i class="fas fa-film"></i>
                                    {{ $brief->productions->count() }} Production
                                </span>
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <div class="empty-state">
                    <i class="fas fa-list"></i>
                    <h3>Belum Ada Brief</h3>
                    <p>Admin belum membuat brief konten apapun</p>
                </div>
            @endif
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>© {{ date('Y') }} PageFlowry - Sistem Manajemen Konten</p>
            <p><a href="{{ route('public.production', $allBriefs->first()->share_token ?? '') }}">Lihat Production</a></p>
        </div>
    </div>
</body>
</html>
