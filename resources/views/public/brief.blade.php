<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $brief->title }} - Brief Konten</title>
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
        
        .brand-info {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            color: var(--gray-700);
            font-size: 1rem;
        }
        
        .brand-info i {
            color: var(--blue-500);
        }
        
        .content-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 25px;
            margin-bottom: 30px;
        }
        
        .card {
            background: var(--white);
            border-radius: var(--radius-lg);
            padding: 25px;
            box-shadow: var(--shadow-lg);
            border: 1px solid var(--border);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        
        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        
        .card-header {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid var(--gray-100);
        }
        
        .card-icon {
            width: 50px;
            height: 50px;
            border-radius: var(--radius);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }
        
        .card-title {
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--gray-800);
        }
        
        .info-item {
            display: flex;
            margin-bottom: 15px;
            align-items: flex-start;
        }
        
        .info-label {
            font-weight: 600;
            color: var(--gray-700);
            min-width: 120px;
            margin-right: 10px;
        }
        
        .info-value {
            color: var(--gray-600);
            flex: 1;
        }
        
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
        }
        
        .status-badge.task {
            background: var(--blue-50);
            color: var(--blue-700);
            border: 1px solid var(--blue-200);
        }
        
        .status-badge.in-production {
            background: rgba(251, 146, 60, 0.1);
            color: #fb923c;
            border: 1px solid rgba(251, 146, 60, 0.2);
        }
        
        .status-badge.under-review {
            background: rgba(250, 204, 21, 0.1);
            color: #facc15;
            border: 1px solid rgba(250, 204, 21, 0.2);
        }
        
        .status-badge.need-revision {
            background: rgba(239, 68, 68, 0.1);
            color: #ef4444;
            border: 1px solid rgba(239, 68, 68, 0.2);
        }
        
        .status-badge.ready-to-publish {
            background: rgba(34, 197, 94, 0.1);
            color: #22c55e;
            border: 1px solid rgba(34, 197, 94, 0.2);
        }
        
        .status-badge.published {
            background: rgba(168, 85, 247, 0.1);
            color: #a855f7;
            border: 1px solid rgba(168, 85, 247, 0.2);
        }
        
        .deadline-warning {
            background: rgba(245, 158, 11, 0.1);
            color: #92400e;
            padding: 15px;
            border-radius: var(--radius);
            border: 1px solid rgba(245, 158, 11, 0.2);
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
        }
        
        .deadline-warning i {
            font-size: 1.2rem;
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
            
            .content-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }
            
            .card {
                padding: 20px;
            }
            
            .info-item {
                flex-direction: column;
                gap: 5px;
            }
            
            .info-label {
                min-width: auto;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>{{ $brief->title }}</h1>
            <div class="subtitle">Brief Konten untuk Content Creator</div>
            <div class="brand-info">
                <i class="fas fa-tag"></i>
                <span>{{ optional($brief->brand)->name ?? 'Tidak ada brand' }}</span>
                <span>·</span>
                <i class="fas fa-user"></i>
                <span>{{ optional($brief->user)->name ?? 'Admin' }}</span>
            </div>
        </div>

        <!-- Deadline Warning -->
        @if($brief->production_deadline && \Carbon\Carbon::parse($brief->production_deadline)->isPast())
            <div class="deadline-warning">
                <i class="fas fa-exclamation-triangle"></i>
                <div>
                    <strong>Perhatian:</strong> Deadline produksi telah lewat pada {{ \Carbon\Carbon::parse($brief->production_deadline)->format('d M Y') }}
                </div>
            </div>
        @elseif($brief->production_deadline && \Carbon\Carbon::parse($brief->production_deadline)->diffInDays(\Carbon\Carbon::today()) <= 2)
            <div class="deadline-warning">
                <i class="fas fa-clock"></i>
                <div>
                    <strong>Deadline Mendekati:</strong> {{ \Carbon\Carbon::parse($brief->production_deadline)->format('d M Y') }} ({{ \Carbon\Carbon::parse($brief->production_deadline)->diffInDays(\Carbon\Carbon::today()) }} hari lagi)
                </div>
            </div>
        @endif

        <!-- Content Grid -->
        <div class="content-grid">
            <!-- Informasi Dasar -->
            <div class="card">
                <div class="card-header">
                    <div class="card-icon" style="background: var(--blue-50); color: var(--blue-600);">
                        <i class="fas fa-info-circle"></i>
                    </div>
                    <div class="card-title">Informasi Dasar</div>
                </div>
                
                <div class="info-item">
                    <div class="info-label">Platform:</div>
                    <div class="info-value">
                        <i class="fab {{ $brief->platform === 'Instagram' ? 'fa-instagram' : ($brief->platform === 'TikTok' ? 'fa-tiktok' : 'fa-youtube') }}"></i>
                        {{ $brief->platform }}
                    </div>
                </div>
                
                <div class="info-item">
                    <div class="info-label">Format:</div>
                    <div class="info-value">{{ $brief->content_format ?? '-' }}</div>
                </div>
                
                <div class="info-item">
                    <div class="info-label">Durasi:</div>
                    <div class="info-value">{{ $brief->target_duration ?? '-' }}</div>
                </div>
                
                <div class="info-item">
                    <div class="info-label">Status:</div>
                    <div class="info-value">
                        <span class="status-badge {{ $brief->status }}">
                            <span class="status-dot"></span>
                            {{ ucfirst(str_replace('_', ' ', $brief->status)) }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Deadline -->
            <div class="card">
                <div class="card-header">
                    <div class="card-icon" style="background: var(--yellow-50); color: var(--yellow-600);">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <div class="card-title">Deadline</div>
                </div>
                
                <div class="info-item">
                    <div class="info-label">Produksi:</div>
                    <div class="info-value">
                        @if($brief->production_deadline)
                            {{ \Carbon\Carbon::parse($brief->production_deadline)->format('d M Y') }}
                        @else
                            Tidak ada deadline
                        @endif
                    </div>
                </div>
                
                <div class="info-item">
                    <div class="info-label">Publish:</div>
                    <div class="info-value">
                        @if($brief->publish_deadline)
                            {{ \Carbon\Carbon::parse($brief->publish_deadline)->format('d M Y') }}
                        @else
                            Tidak ada deadline
                        @endif
                    </div>
                </div>
            </div>

            <!-- Strategi Konten -->
            <div class="card">
                <div class="card-header">
                    <div class="card-icon" style="background: var(--green-50); color: var(--green-600);">
                        <i class="fas fa-bullseye"></i>
                    </div>
                    <div class="card-title">Strategi Konten</div>
                </div>
                
                <div class="info-item">
                    <div class="info-label">Objective:</div>
                    <div class="info-value">{{ $brief->objective ?? '-' }}</div>
                </div>
                
                <div class="info-item">
                    <div class="info-label">Target Audience:</div>
                    <div class="info-value">{{ $brief->target_audience ?? '-' }}</div>
                </div>
                
                <div class="info-item">
                    <div class="info-label">Key Message:</div>
                    <div class="info-value">{{ $brief->key_message ?? '-' }}</div>
                </div>
            </div>

            <!-- Brief Kreatif -->
            <div class="card">
                <div class="card-header">
                    <div class="card-icon" style="background: var(--purple-50); color: var(--purple-600);">
                        <i class="fas fa-palette"></i>
                    </div>
                    <div class="card-title">Brief Kreatif</div>
                </div>
                
                <div class="info-item">
                    <div class="info-label">Hook:</div>
                    <div class="info-value">{{ $brief->hook ?? '-' }}</div>
                </div>
                
                <div class="info-item">
                    <div class="info-label">Storyline:</div>
                    <div class="info-value">{{ $brief->storyline ?? '-' }}</div>
                </div>
                
                <div class="info-item">
                    <div class="info-label">Visual Direction:</div>
                    <div class="info-value">{{ $brief->visual_direction ?? '-' }}</div>
                </div>
            </div>

            <!-- Konten & Publishing -->
            <div class="card">
                <div class="card-header">
                    <div class="card-icon" style="background: var(--indigo-50); color: var(--indigo-600);">
                        <i class="fas fa-share-alt"></i>
                    </div>
                    <div class="card-title">Konten & Publishing</div>
                </div>
                
                <div class="info-item">
                    <div class="info-label">Caption:</div>
                    <div class="info-value">{{ $brief->caption ?? '-' }}</div>
                </div>
                
                <div class="info-item">
                    <div class="info-label">Call to Action:</div>
                    <div class="info-value">{{ $brief->cta ?? '-' }}</div>
                </div>
                
                <div class="info-item">
                    <div class="info-label">Hashtags:</div>
                    <div class="info-value">{{ $brief->hashtags ?? '-' }}</div>
                </div>
            </div>

            <!-- Target KPI -->
            <div class="card">
                <div class="card-header">
                    <div class="card-icon" style="background: var(--pink-50); color: var(--pink-600);">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <div class="card-title">Target KPI</div>
                </div>
                
                <div class="info-item">
                    <div class="info-label">Target Views:</div>
                    <div class="info-value">{{ $brief->target_views ? number_format($brief->target_views) : '-' }}</div>
                </div>
                
                <div class="info-item">
                    <div class="info-label">Target Engagement:</div>
                    <div class="info-value">{{ $brief->target_engagement ? $brief->target_engagement . '%' : '-' }}</div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>© {{ date('Y') }} PageFlowry - Sistem Manajemen Konten</p>
            <p><a href="{{ route('public.production', $brief->public_token) }}">Lihat Production</a> · <a href="{{ route('public.all-briefs', $brief->public_token) }}">Lihat Semua Brief</a></p>
        </div>
    </div>
</body>
</html>
