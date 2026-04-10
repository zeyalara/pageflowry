<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Production - {{ $brief->title }}</title>
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
        
        .brief-info {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 20px;
            color: var(--gray-700);
            font-size: 1rem;
            flex-wrap: wrap;
        }
        
        .brief-info span {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .brief-info i {
            color: var(--blue-500);
        }
        
        .productions-section {
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
        
        .production-count {
            background: var(--blue-50);
            color: var(--blue-700);
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.9rem;
        }
        
        .productions-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 20px;
        }
        
        .production-card {
            background: var(--gray-50);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 20px;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        
        .production-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }
        
        .production-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 15px;
        }
        
        .production-title {
            font-weight: 600;
            color: var(--gray-800);
            font-size: 1.1rem;
        }
        
        .production-status {
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 0.8rem;
            font-weight: 600;
        }
        
        .production-status.completed {
            background: var(--green-50);
            color: var(--green-700);
        }
        
        .production-status.pending {
            background: var(--yellow-50);
            color: var(--yellow-700);
        }
        
        .production-details {
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
        
        .video-preview {
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px solid var(--border);
        }
        
        .video-preview h4 {
            font-size: 1rem;
            color: var(--gray-700);
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .video-preview h4 i {
            color: var(--blue-500);
        }
        
        .video-player {
            background: var(--gray-100);
            border-radius: var(--radius);
            padding: 40px;
            text-align: center;
            color: var(--gray-600);
        }
        
        .video-player i {
            font-size: 3rem;
            color: var(--gray-400);
            margin-bottom: 10px;
        }
        
        .download-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--blue-500);
            color: var(--white);
            padding: 10px 20px;
            border-radius: var(--radius);
            text-decoration: none;
            font-weight: 600;
            transition: background 0.2s ease;
            margin-top: 10px;
        }
        
        .download-btn:hover {
            background: var(--blue-600);
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
            margin-bottom: 20px;
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
            
            .brief-info {
                flex-direction: column;
                gap: 10px;
            }
            
            .productions-grid {
                grid-template-columns: 1fr;
            }
            
            .section-header {
                flex-direction: column;
                gap: 15px;
                align-items: flex-start;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>Production</h1>
            <div class="subtitle">Video Production untuk Brief Konten</div>
            <div class="brief-info">
                <span>
                    <i class="fas fa-file-alt"></i>
                    {{ $brief->title }}
                </span>
                <span>
                    <i class="fas fa-tag"></i>
                    {{ optional($brief->brand)->name ?? 'Tidak ada brand' }}
                </span>
                <span>
                    <i class="fas fa-user"></i>
                    {{ optional($brief->user)->name ?? 'Admin' }}
                </span>
            </div>
        </div>

        <!-- Productions Section -->
        <div class="productions-section">
            <div class="section-header">
                <div class="section-title">
                    <i class="fas fa-film"></i>
                    Daftar Production
                </div>
                <div class="production-count">
                    {{ $productions->count() }} Video
                </div>
            </div>

            @if($productions->count() > 0)
                <div class="productions-grid">
                    @foreach($productions as $production)
                        <div class="production-card">
                            <div class="production-header">
                                <div class="production-title">
                                    {{ $production->versi_video ?? 'Video #' . $production->id }}
                                </div>
                                <div class="production-status {{ $production->file_video ? 'completed' : 'pending' }}">
                                    {{ $production->file_video ? 'Selesai' : 'Dalam Proses' }}
                                </div>
                            </div>

                            <div class="production-details">
                                <div class="detail-item">
                                    <i class="fas fa-clock"></i>
                                    <div class="detail-content">
                                        <div class="detail-label">Durasi Final</div>
                                        <div class="detail-value">{{ $production->durasi_final ?? '-' }}</div>
                                    </div>
                                </div>

                                <div class="detail-item">
                                    <i class="fas fa-sticky-note"></i>
                                    <div class="detail-content">
                                        <div class="detail-label">Catatan Produksi</div>
                                        <div class="detail-value">{{ $production->catatan_produksi ?? '-' }}</div>
                                    </div>
                                </div>

                                <div class="detail-item">
                                    <i class="fas fa-calendar"></i>
                                    <div class="detail-content">
                                        <div class="detail-label">Tanggal Upload</div>
                                        <div class="detail-value">
                                            {{ $production->created_at->format('d M Y H:i') }}
                                        </div>
                                    </div>
                                </div>

                                @if($production->file_video)
                                    <div class="video-preview">
                                        <h4>
                                            <i class="fas fa-video"></i>
                                            Video Preview
                                        </h4>
                                        <div class="video-player">
                                            <i class="fas fa-play-circle"></i>
                                            <p>Video tersedia untuk preview</p>
                                            <a href="#" class="download-btn" onclick="window.open('/storage/{{ $production->file_video }}', '_blank')">
                                                <i class="fas fa-download"></i>
                                                Download Video
                                            </a>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="empty-state">
                    <i class="fas fa-film"></i>
                    <h3>Belum Ada Production</h3>
                    <p>Video production untuk brief ini belum dibuat</p>
                    <p>Hubungi admin untuk informasi lebih lanjut</p>
                </div>
            @endif
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>© {{ date('Y') }} PageFlowry - Sistem Manajemen Konten</p>
            <p><a href="{{ route('public.brief', $brief->share_token) }}">Kembali ke Brief</a> · <a href="{{ route('public.all-briefs', $brief->share_token) }}">Lihat Semua Brief</a></p>
        </div>
    </div>
</body>
</html>
