<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $brief->title }} - Brief Konten</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #2563eb;
            --primary-dark: #1d4ed8;
            --primary-light: #3b82f6;
            --primary-soft: #60a5fa;
            --blue-50: #eff6ff;
            --blue-100: #dbeafe;
            --blue-200: #bfdbfe;
            --blue-500: #3b82f6;
            --blue-600: #2563eb;
            --blue-700: #1d4ed8;
            --blue-900: #1e3a8a;
            --green: #22c55e;
            --green-50: #f0fdf4;
            --green-100: #dcfce7;
            --green-600: #16a34a;
            --yellow: #f59e0b;
            --yellow-50: #fffbeb;
            --yellow-600: #d97706;
            --red: #ef4444;
            --red-50: #fef2f2;
            --red-600: #dc2626;
            --white: #ffffff;
            --slate-50: #f8fafc;
            --slate-100: #f1f5f9;
            --slate-200: #e2e8f0;
            --slate-300: #cbd5e1;
            --slate-400: #94a3b8;
            --slate-500: #64748b;
            --slate-600: #475569;
            --slate-700: #334155;
            --slate-800: #1e293b;
            --slate-900: #0f172a;
            --border: #e2e8f0;
            --shadow-soft: 0 1px 3px rgba(0, 0, 0, 0.05), 0 1px 2px rgba(0, 0, 0, 0.03);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.05), 0 4px 6px -2px rgba(0, 0, 0, 0.025);
            --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.05), 0 10px 10px -5px rgba(0, 0, 0, 0.02);
            --radius: 12px;
            --radius-lg: 16px;
            --radius-xl: 20px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(180deg, #f0f9ff 0%, #ffffff 50%, #f8fafc 100%);
            min-height: 100vh;
            color: var(--slate-800);
            line-height: 1.6;
            padding-bottom: 40px;
        }

        .container {
            max-width: 1100px;
            margin: 0 auto;
            padding: 32px 24px;
        }

        /* Header */
        .header {
            background: var(--white);
            border-radius: var(--radius-xl);
            padding: 48px 40px;
            margin-bottom: 40px;
            box-shadow: var(--shadow-xl);
            text-align: center;
            border: 1px solid var(--slate-200);
        }

        .header h1 {
            color: var(--slate-900);
            font-size: 2rem;
            margin-bottom: 12px;
            font-weight: 700;
            letter-spacing: -0.025em;
        }

        .header .subtitle {
            color: var(--slate-500);
            font-size: 1.1rem;
            margin-bottom: 20px;
        }

        .brand-info {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 16px;
            color: var(--slate-500);
            font-size: 0.95rem;
            flex-wrap: wrap;
        }

        .brand-info i {
            color: var(--primary);
        }

        .brand-info .separator {
            color: var(--slate-300);
        }

        /* Alerts */
        .alert {
            padding: 16px 20px;
            border-radius: var(--radius);
            margin-bottom: 32px;
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 500;
            font-size: 0.95rem;
        }

        .alert-success {
            background: var(--green-50);
            color: var(--green-600);
            border: 1px solid var(--green-100);
        }

        .alert-error {
            background: var(--red-50);
            color: var(--red-600);
            border: 1px solid var(--red-100);
        }

        .alert i {
            font-size: 1.25rem;
        }

        /* Deadline Warning */
        .deadline-warning {
            background: var(--yellow-50);
            color: var(--yellow-600);
            padding: 16px 20px;
            border-radius: var(--radius);
            border: 1px solid #fef3c7;
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 32px;
            font-weight: 500;
        }

        .deadline-warning i {
            font-size: 1.25rem;
        }

        /* Tab Navigation */
        .tab-nav {
            display: flex;
            gap: 12px;
            margin-bottom: 40px;
            background: var(--white);
            padding: 16px;
            border-radius: var(--radius-xl);
            box-shadow: var(--shadow-lg);
            border: 1px solid var(--slate-200);
        }

        .tab-btn {
            flex: 1;
            padding: 16px 24px;
            border: none;
            background: transparent;
            color: var(--slate-500);
            font-size: 0.95rem;
            font-weight: 600;
            cursor: pointer;
            border-radius: var(--radius);
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .tab-btn:hover {
            background: var(--slate-100);
            color: var(--slate-700);
        }

        .tab-btn.active {
            background: var(--primary);
            color: var(--white);
            box-shadow: var(--shadow-md);
        }

        .tab-btn i {
            font-size: 1.1rem;
        }

        /* Tab Content */
        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(8px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Cards Grid */
        .content-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 24px;
            margin-bottom: 40px;
        }

        .card {
            background: var(--white);
            border-radius: var(--radius-xl);
            padding: 32px;
            box-shadow: var(--shadow-lg);
            border: 1px solid var(--slate-200);
            transition: all 0.2s ease;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-xl);
            border-color: var(--slate-300);
        }

        .card-header {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-bottom: 24px;
            padding-bottom: 16px;
            border-bottom: 1px solid var(--slate-100);
        }

        .card-icon {
            width: 48px;
            height: 48px;
            border-radius: var(--radius);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            flex-shrink: 0;
        }

        .card-title {
            font-size: 1.125rem;
            font-weight: 700;
            color: var(--slate-800);
        }

        .info-item {
            display: flex;
            margin-bottom: 14px;
            align-items: flex-start;
        }

        .info-label {
            font-weight: 600;
            color: var(--slate-600);
            min-width: 120px;
            margin-right: 12px;
            flex-shrink: 0;
            font-size: 0.9rem;
        }

        .info-value {
            color: var(--slate-700);
            flex: 1;
            font-size: 0.95rem;
        }

        /* Status Badges */
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .status-badge.submitted {
            background: var(--blue-50);
            color: var(--blue-700);
        }

        .status-badge.in-production {
            background: #fff7ed;
            color: #c2410c;
        }

        .status-badge.under-review {
            background: #fefce8;
            color: #a16207;
        }

        .status-badge.need-revision {
            background: var(--red-50);
            color: var(--red-600);
        }

        .status-badge.ready-to-publish {
            background: var(--green-50);
            color: var(--green-600);
        }

        .status-badge.published {
            background: #f3e8ff;
            color: #7c3aed;
        }

        /* Upload Section */
        .upload-section {
            max-width: 720px;
            margin: 0 auto;
        }

        .upload-card {
            background: var(--white);
            border-radius: var(--radius-xl);
            padding: 48px;
            box-shadow: var(--shadow-xl);
            border: 1px solid var(--slate-200);
        }

        .upload-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .upload-header h2 {
            color: var(--slate-900);
            font-size: 1.5rem;
            margin-bottom: 8px;
            font-weight: 700;
        }

        .upload-header p {
            color: var(--slate-500);
            font-size: 0.95rem;
        }

        /* Form Styles */
        .form-group {
            margin-bottom: 28px;
        }

        .form-label {
            display: block;
            font-weight: 600;
            color: var(--slate-700);
            margin-bottom: 10px;
            font-size: 0.9rem;
        }

        .form-label .required {
            color: var(--red);
            margin-left: 4px;
        }

        .form-control {
            width: 100%;
            padding: 14px 18px;
            border: 1px solid var(--slate-300);
            border-radius: var(--radius);
            font-size: 0.95rem;
            transition: all 0.2s ease;
            background: var(--white);
            color: var(--slate-800);
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.08);
        }

        select.form-control {
            cursor: pointer;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%2364748b' d='M6 8L1 3h10z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 16px center;
            padding-right: 42px;
        }

        textarea.form-control {
            resize: vertical;
            min-height: 100px;
        }

        /* Dropzone File Upload */
        .file-upload {
            position: relative;
        }

        .file-upload-input {
            position: absolute;
            opacity: 0;
            width: 100%;
            height: 100%;
            cursor: pointer;
            z-index: 10;
        }

        .file-upload-box {
            border: 2px dashed var(--slate-300);
            border-radius: var(--radius-lg);
            padding: 48px 32px;
            text-align: center;
            transition: all 0.2s ease;
            background: var(--slate-50);
        }

        .file-upload-box:hover {
            border-color: var(--primary-light);
            background: var(--blue-50);
        }

        .file-upload-box.has-file {
            border-color: var(--green);
            background: var(--green-50);
            border-style: solid;
        }

        .file-upload-box.dragover {
            border-color: var(--primary);
            background: var(--blue-100);
        }

        .file-upload-icon {
            font-size: 2.5rem;
            color: var(--slate-400);
            margin-bottom: 16px;
        }

        .file-upload-box.has-file .file-upload-icon {
            color: var(--green);
        }

        .file-upload-text {
            color: var(--slate-600);
            font-weight: 500;
            font-size: 1rem;
        }

        .file-upload-box.has-file .file-upload-text {
            color: var(--green-600);
        }

        .file-name {
            margin-top: 12px;
            font-weight: 600;
            color: var(--slate-800);
            font-size: 0.95rem;
        }

        .file-hint {
            font-size: 0.85rem;
            color: var(--slate-400);
            margin-top: 8px;
        }

        /* Submit Button */
        .btn-submit {
            width: 100%;
            padding: 16px 32px;
            background: var(--primary);
            color: var(--white);
            border: none;
            border-radius: var(--radius);
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-top: 8px;
        }

        .btn-submit:hover:not(:disabled) {
            background: var(--primary-dark);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);
        }

        .btn-submit:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        /* Productions List */
        .productions-list {
            margin-top: 40px;
        }

        .productions-title {
            font-size: 1.125rem;
            font-weight: 700;
            color: var(--slate-800);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .production-item {
            background: var(--white);
            border-radius: var(--radius);
            padding: 20px 24px;
            margin-bottom: 12px;
            border: 1px solid var(--slate-200);
            transition: all 0.2s ease;
        }

        .production-item:hover {
            border-color: var(--primary-light);
            box-shadow: var(--shadow-md);
        }

        .production-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 8px;
        }

        .production-title {
            font-weight: 600;
            color: var(--slate-800);
            font-size: 0.95rem;
        }

        .production-meta {
            display: flex;
            gap: 20px;
            color: var(--slate-500);
            font-size: 0.85rem;
        }

        .production-meta span {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        /* Footer */
        .footer {
            text-align: center;
            padding: 48px 24px;
            color: var(--slate-500);
            margin-top: 60px;
        }

        .footer p {
            margin-bottom: 8px;
            font-size: 0.9rem;
        }

        .footer a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
            transition: color 0.2s;
        }

        .footer a:hover {
            color: var(--primary-dark);
            text-decoration: underline;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .container {
                padding: 20px 16px;
            }

            .header {
                padding: 32px 24px;
            }

            .header h1 {
                font-size: 1.5rem;
            }

            .tab-nav {
                flex-direction: column;
                gap: 8px;
            }

            .tab-btn {
                padding: 14px 16px;
            }

            .content-grid {
                grid-template-columns: 1fr;
                gap: 16px;
            }

            .card {
                padding: 24px;
            }

            .info-item {
                flex-direction: column;
                gap: 4px;
            }

            .info-label {
                min-width: auto;
                margin-right: 0;
            }

            .upload-card {
                padding: 32px 24px;
            }

            .production-header {
                flex-direction: column;
                gap: 10px;
                align-items: flex-start;
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
                <span class="separator">·</span>
                <i class="fas fa-user"></i>
                <span>{{ optional($admin)->name ?? 'Admin' }}</span>
            </div>
        </div>

        <!-- Success/Error Messages -->
        @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-error">
                <i class="fas fa-exclamation-circle"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <!-- Deadline Warning -->
        @if($brief->production_deadline && \Carbon\Carbon::parse($brief->production_deadline)->isPast())
            <div class="deadline-warning">
                <i class="fas fa-exclamation-triangle"></i>
                <div><strong>Perhatian:</strong> Deadline produksi telah lewat pada {{ \Carbon\Carbon::parse($brief->production_deadline)->format('d M Y') }}</div>
            </div>
        @elseif($brief->production_deadline && \Carbon\Carbon::parse($brief->production_deadline)->diffInDays(\Carbon\Carbon::today()) <= 2)
            <div class="deadline-warning">
                <i class="fas fa-clock"></i>
                <div><strong>Deadline Mendekati:</strong> {{ \Carbon\Carbon::parse($brief->production_deadline)->format('d M Y') }} ({{ \Carbon\Carbon::parse($brief->production_deadline)->diffInDays(\Carbon\Carbon::today()) }} hari lagi)</div>
            </div>
        @endif

        <!-- Tab Navigation -->
        <div class="tab-nav">
            <button class="tab-btn {{ $activeTab === 'brief' ? 'active' : '' }}" onclick="switchTab('brief')">
                <i class="fas fa-file-alt"></i>
                <span>Lihat Brief</span>
            </button>
            <button class="tab-btn {{ $activeTab === 'upload' ? 'active' : '' }}" onclick="switchTab('upload')">
                <i class="fas fa-cloud-upload-alt"></i>
                <span>Upload Production</span>
            </button>
        </div>

        <!-- Tab: Lihat Brief -->
        <div id="tab-brief" class="tab-content {{ $activeTab === 'brief' ? 'active' : '' }}">
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
                            <i class="fab {{ $brief->platform === 'Instagram' ? 'fa-instagram' : ($brief->platform === 'TikTok' ? 'fa-tiktok' : 'fa-youtube') }}"></i> {{ $brief->platform }}
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Deskripsi:</div>
                        <div class="info-value">{{ $brief->description ?? '-' }}</div>
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
                            <span class="status-badge {{ $brief->status }}">{{ ucfirst(str_replace('_', ' ', $brief->status)) }}</span>
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
                        <div class="info-value">{{ $brief->production_deadline ? \Carbon\Carbon::parse($brief->production_deadline)->format('d M Y') : '-' }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Publish:</div>
                        <div class="info-value">{{ $brief->publish_deadline ? \Carbon\Carbon::parse($brief->publish_deadline)->format('d M Y') : '-' }}</div>
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
                        <div class="card-icon" style="background: var(--blue-50); color: var(--blue-600);">
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
                        <div class="info-label">Visual:</div>
                        <div class="info-value">{{ $brief->visual_direction ?? '-' }}</div>
                    </div>
                </div>

                <!-- Konten & Publishing -->
                <div class="card">
                    <div class="card-header">
                        <div class="card-icon" style="background: var(--blue-50); color: var(--blue-600);">
                            <i class="fas fa-share-alt"></i>
                        </div>
                        <div class="card-title">Konten & Publishing</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Caption:</div>
                        <div class="info-value">{{ $brief->caption ?? '-' }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">CTA:</div>
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
                        <div class="card-icon" style="background: #fdf2f8; color: #db2777;">
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
        </div>

        <!-- Tab: Upload Production -->
        <div id="tab-upload" class="tab-content {{ $activeTab === 'upload' ? 'active' : '' }}">
            <div class="upload-section">
                <div class="upload-card">
                    <div class="upload-header">
                        <h2><i class="fas fa-cloud-upload-alt" style="color: var(--primary); margin-right: 10px;"></i>Upload Production</h2>
                        <p>Kirim video hasil produksi Anda untuk direview oleh admin</p>
                    </div>

                    <form id="uploadForm" action="{{ route('production.store.public', $brief->token) }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Content Task Dropdown -->
                        <div class="form-group">
                            <label class="form-label">Pilih Content Task <span class="required">*</span></label>
                            <select name="task_id" class="form-control" required>
                                @if($brief->tasks->count() > 0)
                                    <option value="">-- Pilih Task --</option>
                                    @foreach($brief->tasks as $task)
                                        <option value="task_{{ $task->id }}">{{ $task->title ?? 'Task #' . $task->id }}</option>
                                    @endforeach
                                @endif
                                {{-- Selalu sertakan brief utama sebagai pilihan --}}
                                <option value="brief_{{ $brief->id }}" {{ $brief->tasks->count() == 0 ? 'selected' : '' }}>
                                    [Brief] {{ $brief->title }}
                                </option>
                            </select>
                            @error('task_id')
                                <small style="color: var(--red);">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- File Upload -->
                        <div class="form-group">
                            <label class="form-label">Upload Video <span class="required">*</span></label>
                            <div class="file-upload">
                                <input type="file" name="video_file" id="file_video" class="file-upload-input" accept="video/*" required>
                                <div class="file-upload-box" id="fileUploadBox">
                                    <div class="file-upload-icon">
                                        <i class="fas fa-cloud-upload-alt"></i>
                                    </div>
                                    <div class="file-upload-text">Klik atau drag file video di sini</div>
                                    <div class="file-name" id="fileName"></div>
                                    <div class="file-hint">MP4, MOV, AVI, MKV (Maks. 500MB)</div>
                                </div>
                            </div>
                            @error('video_file')
                                <small style="color: var(--red);">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Caption -->
                        <div class="form-group">
                            <label class="form-label">Caption <span class="required">*</span></label>
                            <textarea name="caption" class="form-control" placeholder="Tulis caption untuk konten ini..." required>{{ old('caption') }}</textarea>
                            @error('caption')
                                <small style="color: var(--red);">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Notes -->
                        <div class="form-group">
                            <label class="form-label">Catatan Tambahan <span style="color: var(--gray-400); font-weight: 400;">(Optional)</span></label>
                            <textarea name="notes" class="form-control" placeholder="Tambahkan catatan jika diperlukan...">{{ old('notes') }}</textarea>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn-submit" id="btnSubmit" disabled>
                            <i class="fas fa-paper-plane"></i>
                            <span>Kirim Production</span>
                        </button>
                    </form>
                </div>

                <!-- Existing Productions -->
                @if(isset($productions) && $productions->count() > 0)
                    <div class="productions-list">
                        <div class="productions-title">
                            <i class="fas fa-history" style="color: var(--primary);"></i>
                            Production Terkirim
                        </div>
                        @foreach($productions as $production)
                            <div class="production-item">
                                <div class="production-header">
                                    <div class="production-title">{{ $production->judul_konten ?? 'Production #' . $production->id }}</div>
                                    <span class="status-badge {{ strtolower(str_replace(' ', '-', $production->status)) }}">
                                        {{ ucfirst($production->status) }}
                                    </span>
                                </div>
                                <div class="production-meta">
                                    <span><i class="fas fa-calendar"></i> {{ $production->created_at->format('d M Y') }}</span>
                                    @if($production->file_video)
                                        <span><i class="fas fa-video"></i> Video tersedia</span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>© {{ date('Y') }} PageFlowry - Sistem Manajemen Konten</p>
        </div>
    </div>

    <script>
        // Tab Switching
        function switchTab(tab) {
            document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
            document.querySelectorAll('.tab-content').forEach(content => content.classList.remove('active'));

            document.querySelector(`.tab-btn[onclick="switchTab('${tab}')"]`).classList.add('active');
            document.getElementById(`tab-${tab}`).classList.add('active');

            // Update URL without reload
            const url = new URL(window.location);
            url.searchParams.set('tab', tab);
            window.history.pushState({}, '', url);
        }

        // File Upload Handler
        const fileInput = document.getElementById('file_video');
        const fileUploadBox = document.getElementById('fileUploadBox');
        const fileName = document.getElementById('fileName');
        const btnSubmit = document.getElementById('btnSubmit');

        fileInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const file = this.files[0];
                fileName.textContent = file.name;
                fileUploadBox.classList.add('has-file');
                btnSubmit.disabled = false;
            } else {
                fileName.textContent = '';
                fileUploadBox.classList.remove('has-file');
                btnSubmit.disabled = true;
            }
        });

        // Drag and Drop
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            fileUploadBox.addEventListener(eventName, (e) => {
                e.preventDefault();
                e.stopPropagation();
            });
        });

        fileUploadBox.addEventListener('dragenter', () => {
            fileUploadBox.classList.add('dragover');
        });

        fileUploadBox.addEventListener('dragover', () => {
            fileUploadBox.classList.add('dragover');
        });

        fileUploadBox.addEventListener('dragleave', () => {
            fileUploadBox.classList.remove('dragover');
        });

        fileUploadBox.addEventListener('drop', (e) => {
            fileUploadBox.classList.remove('dragover');
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                fileInput.files = files;
                fileName.textContent = files[0].name;
                fileUploadBox.classList.add('has-file');
                btnSubmit.disabled = false;
            }
        });
    </script>
</body>
</html>
