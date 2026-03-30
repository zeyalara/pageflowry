<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $contentBrief->title }} - Content Brief</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #5897fe;
            --primary-dark: #3b82f6;
            --text: #1f2937;
            --text-light: #6b7280;
            --border: #e5e7eb;
            --bg-light: #f8fafc;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
        }
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }
        .container {
            max-width: 900px;
            margin: 0 auto;
            background: white;
            border-radius: 16px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .header {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            font-size: 24px;
            font-weight: 700;
            margin: 0 0 10px 0;
        }
        .header p {
            font-size: 14px;
            opacity: 0.9;
            margin: 0;
        }
        .content {
            padding: 40px 30px;
        }
        .section {
            margin-bottom: 40px;
        }
        .section-title {
            font-size: 18px;
            font-weight: 700;
            color: var(--text);
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid var(--border);
        }
        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        .info-card {
            background: var(--bg-light);
            padding: 20px;
            border-radius: 12px;
            border: 1px solid var(--border);
        }
        .info-label {
            font-size: 12px;
            font-weight: 600;
            color: var(--text-light);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
        }
        .info-value {
            font-size: 16px;
            font-weight: 600;
            color: var(--text);
        }
        .platform-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 16px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
            margin-top: 10px;
        }
        .platform-instagram { background: #fce7f3; color: #9d174d; }
        .platform-tiktok { background: #f0fdf4; color: #14532d; }
        .platform-youtube { background: #fef2f2; color: #991b1b; }
        .deadline-box {
            background: linear-gradient(135deg, #fef3c7, #fbbf24);
            border: 1px solid #f59e0b;
            padding: 25px;
            border-radius: 12px;
            text-align: center;
        }
        .deadline-box h3 {
            color: #92400e;
            font-size: 20px;
            margin: 0 0 10px 0;
        }
        .deadline-box .date {
            font-size: 24px;
            font-weight: 700;
            color: #92400e;
        }
        .description-box {
            background: #f0f9ff;
            border-left: 4px solid var(--primary);
            padding: 25px;
            border-radius: 0 12px 12px 0;
        }
        .instructions {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            padding: 25px;
            border-radius: 12px;
        }
        .instructions h3 {
            font-size: 18px;
            margin: 0 0 15px 0;
        }
        .instructions ol {
            margin: 0;
            padding-left: 20px;
        }
        .instructions li {
            margin-bottom: 10px;
            line-height: 1.6;
        }
        .footer {
            background: #f8fafc;
            padding: 20px 30px;
            text-align: center;
            border-top: 1px solid var(--border);
            color: var(--text-light);
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>📝 Content Brief</h1>
            <p>Halaman khusus untuk Content Creator</p>
        </div>
        
        <!-- Content -->
        <div class="content">
            <!-- Basic Information -->
            <div class="section">
                <h2 class="section-title">📋 Informasi Dasar</h2>
                <div class="info-grid">
                    <div class="info-card">
                        <div class="info-label">Judul Konten</div>
                        <div class="info-value">{{ $contentBrief->title }}</div>
                    </div>
                    <div class="info-card">
                        <div class="info-label">Brand</div>
                        <div class="info-value">{{ $contentBrief->brand->name }}</div>
                    </div>
                    <div class="info-card">
                        <div class="info-label">Platform</div>
                        <div class="info-value">
                            {{ $contentBrief->platform }}
                            <div class="platform-badge platform-{{ strtolower($contentBrief->platform) }}">
                                @if($contentBrief->platform === 'Instagram')
                                    <i class="fa-brands fa-instagram"></i>
                                @elseif($contentBrief->platform === 'TikTok')
                                    <i class="fa-brands fa-tiktok"></i>
                                @elseif($contentBrief->platform === 'YouTube')
                                    <i class="fa-brands fa-youtube"></i>
                                @endif
                                {{ $contentBrief->platform }}
                            </div>
                        </div>
                    </div>
                    <div class="info-card">
                        <div class="info-label">Format Konten</div>
                        <div class="info-value">{{ $contentBrief->content_format }}</div>
                    </div>
                </div>
            </div>
            
            <!-- Deadline -->
            <div class="section">
                <h2 class="section-title">⏰ Deadline</h2>
                <div class="deadline-box">
                    <h3>Deadline Produksi</h3>
                    <div class="date">
                        @if($contentBrief->production_deadline)
                            {{ \Carbon\Carbon::parse($contentBrief->production_deadline)->format('d F Y') }}
                        @else
                            Tidak ditentukan
                        @endif
                    </div>
                </div>
            </div>
            
            <!-- Description -->
            <div class="section">
                <h2 class="section-title">📄 Deskripsi Tugas</h2>
                <div class="description-box">
                    <p>{{ $contentBrief->description ?? 'Tidak ada deskripsi' }}</p>
                </div>
            </div>
            
            <!-- Content Strategy -->
            @if($contentBrief->objective || $contentBrief->target_audience || $contentBrief->key_message)
            <div class="section">
                <h2 class="section-title">🎯 Strategi Konten</h2>
                <div class="info-grid">
                    @if($contentBrief->objective)
                    <div class="info-card">
                        <div class="info-label">Objective</div>
                        <div class="info-value">{{ $contentBrief->objective }}</div>
                    </div>
                    @endif
                    @if($contentBrief->target_audience)
                    <div class="info-card">
                        <div class="info-label">Target Audience</div>
                        <div class="info-value">{{ $contentBrief->target_audience }}</div>
                    </div>
                    @endif
                    @if($contentBrief->key_message)
                    <div class="info-card">
                        <div class="info-label">Key Message</div>
                        <div class="info-value">{{ $contentBrief->key_message }}</div>
                    </div>
                    @endif
                </div>
            </div>
            @endif
            
            <!-- Creative Direction -->
            @if($contentBrief->hook || $contentBrief->storyline || $contentBrief->visual_direction)
            <div class="section">
                <h2 class="section-title">🎨 Brief Kreatif</h2>
                <div class="info-grid">
                    @if($contentBrief->hook)
                    <div class="info-card">
                        <div class="info-label">Hook</div>
                        <div class="info-value">{{ $contentBrief->hook }}</div>
                    </div>
                    @endif
                    @if($contentBrief->storyline)
                    <div class="info-card">
                        <div class="info-label">Storyline</div>
                        <div class="info-value">{{ $contentBrief->storyline }}</div>
                    </div>
                    @endif
                    @if($contentBrief->visual_direction)
                    <div class="info-card">
                        <div class="info-label">Visual Direction</div>
                        <div class="info-value">{{ $contentBrief->visual_direction }}</div>
                    </div>
                    @endif
                </div>
            </div>
            @endif
            
            <!-- Content & Publishing -->
            @if($contentBrief->caption || $contentBrief->cta || $contentBrief->hashtags)
            <div class="section">
                <h2 class="section-title">📝 Konten & Publishing</h2>
                <div class="info-grid">
                    @if($contentBrief->caption)
                    <div class="info-card">
                        <div class="info-label">Caption</div>
                        <div class="info-value">{{ $contentBrief->caption }}</div>
                    </div>
                    @endif
                    @if($contentBrief->cta)
                    <div class="info-card">
                        <div class="info-label">Call to Action</div>
                        <div class="info-value">{{ $contentBrief->cta }}</div>
                    </div>
                    @endif
                    @if($contentBrief->hashtags)
                    <div class="info-card">
                        <div class="info-label">Hashtags</div>
                        <div class="info-value">{{ $contentBrief->hashtags }}</div>
                    </div>
                    @endif
                </div>
            </div>
            @endif
            
            <!-- Target KPI -->
            @if($contentBrief->target_views || $contentBrief->target_engagement)
            <div class="section">
                <h2 class="section-title">📊 Target KPI</h2>
                <div class="info-grid">
                    @if($contentBrief->target_views)
                    <div class="info-card">
                        <div class="info-label">Target Views</div>
                        <div class="info-value">{{ $contentBrief->target_views }}</div>
                    </div>
                    @endif
                    @if($contentBrief->target_engagement)
                    <div class="info-card">
                        <div class="info-label">Target Engagement</div>
                        <div class="info-value">{{ $contentBrief->target_engagement }}</div>
                    </div>
                    @endif
                </div>
            </div>
            @endif
            
            <!-- Instructions -->
            <div class="section">
                <div class="instructions">
                    <h3>📋 Instruksi untuk Creator</h3>
                    <ol>
                        <li>Baca dan pahami semua informasi brief di atas</li>
                        <li>Kembangkan ide kreatif sesuai dengan objective dan target audience</li>
                        <li>Buat konten sesuai dengan platform dan format yang ditentukan</li>
                        <li>Perhatikan deadline produksi yang telah ditentukan</li>
                        <li>Upload hasil konten sesuai dengan brief</li>
                        <li>Jika ada pertanyaan, segera hubungi admin</li>
                    </ol>
                </div>
            </div>
        </div>
        
        <!-- Footer -->
        <div class="footer">
            <p>📧 Email ini dikirim secara otomatis oleh sistem Pageflowry</p>
            <p>Halaman ini dapat diakses tanpa login menggunakan token unik</p>
        </div>
    </div>
</body>
</html>
