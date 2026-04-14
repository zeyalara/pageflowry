@extends('layouts.admin')

@section('page-title', 'Analytics')

<style>
    .page-header {
        margin-bottom: 18px;
    }
    .page-header h1 {
        font-size: 20px;
        font-weight: 800;
        letter-spacing: -0.4px;
        color: var(--text-900);
        margin-bottom: 4px;
    }
    .page-header p {
        font-size: 13px;
        color: var(--text-400);
    }

    .content-card {
        background: var(--surface);
        border-radius: var(--r);
        border: 1px solid var(--border);
        box-shadow: var(--s1);
        padding: 16px 16px 14px;
    }
    .card-header h3 {
        font-size: 13px;
        font-weight: 700;
        color: var(--text-700);
        letter-spacing: -.1px;
    }
    .card-body {
        margin-top: 12px;
    }

    /* distribusi list (progress style) */
    .dl-list {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }
    .dl-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-size: 12px;
        color: var(--text-500);
    }

    /* tren konten per bulan */
    .trend-grid {
        display: grid;
        grid-template-columns: repeat(6, minmax(0, 1fr));
        gap: 12px;
        align-items: flex-end;
        min-height: 190px;
        padding: 12px 10px 8px;
        border-radius: calc(var(--r) - 6px);
        background:
            radial-gradient(1200px 260px at 20% 0%, rgba(99,102,241,.10), transparent 55%),
            radial-gradient(900px 240px at 80% 15%, rgba(56,189,248,.10), transparent 50%),
            linear-gradient(180deg, rgba(239,246,255,.55), rgba(255,255,255,0));
        border: 1px solid var(--border-light);
    }
    .trend-col {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 7px;
        position: relative;
    }
    .trend-bar {
        width: 100%;
        border-radius: 14px 14px 10px 10px;
        background: linear-gradient(180deg, #4f46e5 0%, #38bdf8 100%);
        box-shadow:
            0 10px 26px rgba(79,70,229,.16),
            0 4px 14px rgba(56,189,248,.12);
        position: relative;
        overflow: hidden;
        transform-origin: bottom;
        transition: transform var(--t), filter var(--t), box-shadow var(--t);
    }
    .trend-bar::after {
        content: '';
        position: absolute;
        inset: 0;
        background:
            radial-gradient(circle at 25% 0%, rgba(255,255,255,.22), transparent 55%),
            linear-gradient(90deg, rgba(255,255,255,.12), transparent 45%, rgba(255,255,255,.06));
        opacity: .75;
    }
    .trend-bar::before {
        content: '';
        position: absolute;
        left: 10%;
        top: 12%;
        width: 50%;
        height: 60%;
        border-radius: 999px;
        background: rgba(255,255,255,.12);
        filter: blur(10px);
        opacity: .65;
        transform: rotate(-10deg);
    }
    .trend-track {
        width: 100%;
        height: 140px;
        display: flex;
        align-items: flex-end;
        border-radius: 16px;
        padding: 8px;
        background:
            linear-gradient(180deg, rgba(15,23,42,.02), rgba(15,23,42,.00));
        border: 1px dashed rgba(148,163,184,.35);
        position: relative;
    }
    .trend-track::after {
        content: '';
        position: absolute;
        left: 10px;
        right: 10px;
        bottom: 10px;
        height: 1px;
        background: rgba(148,163,184,.35);
        border-radius: 99px;
    }
    .trend-bubble {
        position: absolute;
        top: -10px;
        left: 50%;
        transform: translate(-50%, -100%);
        font-size: 11px;
        font-weight: 700;
        color: var(--text-700);
        background: rgba(255,255,255,.95);
        border: 1px solid var(--border);
        padding: 3px 8px;
        border-radius: 999px;
        box-shadow: var(--s1);
        white-space: nowrap;
        opacity: 0;
        transition: opacity var(--t), transform var(--t);
        pointer-events: none;
    }
    .trend-col:hover .trend-bubble {
        opacity: 1;
        transform: translate(-50%, -112%);
    }
    .trend-col:hover .trend-bar {
        transform: scaleY(1.03);
        filter: saturate(1.12) contrast(1.02);
        box-shadow:
            0 14px 32px rgba(79,70,229,.20),
            0 6px 18px rgba(56,189,248,.16);
    }
    .trend-label {
        font-size: 11px;
        color: var(--text-500);
        font-weight: 700;
        letter-spacing: -.1px;
    }
    .trend-value {
        font-size: 11px;
        color: var(--text-300);
    }

    @media (max-width: 900px) {
        .trend-grid { grid-template-columns: repeat(3, minmax(0, 1fr)); }
        .trend-track { height: 130px; }
    }
    @media (max-width: 520px) {
        .trend-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
    }

    .content-grid {
        margin-top: 20px;
        display: grid;
        grid-template-columns: 2fr 1.5fr;
        gap: 16px;
        align-items: flex-start;
    }
    
    .table-responsive {
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    @media (max-width: 820px) {
        .content-grid { grid-template-columns: 1fr; }
    }

    /* filter & export controls */
    .analytics-toolbar {
        display: flex;
        gap: 10px;
        align-items: center;
        flex-wrap: wrap;
    }
    .analytics-toolbar .form-control {
        border-radius: 999px;
        border: 1px solid var(--border);
        padding: 6px 10px;
        font-size: 12px;
        min-width: 130px;
    }
    .analytics-toolbar label {
        font-size: 11px;
        color: var(--text-400);
        margin-right: 4px;
    }
</style>
@section('content')
<div class="page-header">
    <h1>Analytics</h1>
    <p>Statistik dan laporan konten</p>
</div>

{{-- STAT CARDS: RINGKASAN STATUS KONTEN --}}
<div class="stat-row">
    <div class="stat-card sc-blue" style="--i:0">
        <div class="stat-ic">
            <i class="fa-solid fa-layer-group"></i>
        </div>
        <div class="stat-val" data-target="{{ $stats['total'] ?? 0 }}">{{ $stats['total'] ?? 0 }}</div>
        <div class="stat-lbl">Total Content</div>
        <div class="stat-trend trend-up">
            <i class="fa-solid fa-arrow-trend-up"></i>
            +9.2% vs last month
        </div>
    </div>

    <div class="stat-card sc-org" style="--i:1">
        <div class="stat-ic">
            <i class="fa-solid fa-film"></i>
        </div>
        <div class="stat-val" data-target="{{ $stats['in_production'] ?? 0 }}">{{ $stats['in_production'] ?? 0 }}</div>
        <div class="stat-lbl">In Production</div>
        <div class="stat-trend trend-up">
            <i class="fa-solid fa-circle-dot"></i>
            Aktif dikerjakan
        </div>
    </div>

    <div class="stat-card sc-rose" style="--i:2">
        <div class="stat-ic">
            <i class="fa-solid fa-pen-to-square"></i>
        </div>
        <div class="stat-val" data-target="{{ $stats['need_revision'] ?? 0 }}">{{ $stats['need_revision'] ?? 0 }}</div>
        <div class="stat-lbl">Need Revision</div>
        <div class="stat-trend trend-warn">
            <i class="fa-solid fa-triangle-exclamation"></i>
            Perlu perhatian cepat
        </div>
    </div>

    <div class="stat-card sc-amb" style="--i:3">
        <div class="stat-ic">
            <i class="fa-solid fa-circle-check"></i>
        </div>
        <div class="stat-val" data-target="{{ $stats['ready_to_publish'] ?? 0 }}">{{ $stats['ready_to_publish'] ?? 0 }}</div>
        <div class="stat-lbl">Ready to Publish</div>
        <div class="stat-trend trend-up">
            <i class="fa-solid fa-arrow-up-right-from-square"></i>
            Menunggu jadwal tayang
        </div>
    </div>

    <div class="stat-card sc-em" style="--i:4">
        <div class="stat-ic">
            <i class="fa-solid fa-paper-plane"></i>
        </div>
        <div class="stat-val" data-target="{{ $stats['published'] ?? 0 }}">{{ $stats['published'] ?? 0 }}</div>
        <div class="stat-lbl">Published</div>
        <div class="stat-trend trend-up">
            <i class="fa-solid fa-sparkles"></i>
            Live di berbagai channel
        </div>
    </div>
</div>

{{-- GRID: CHART SEDERHANA --}}
<div class="content-grid">
    {{-- CHART STATUS --}}
    <div class="content-card">
        <div class="card-header">
            <h3>Distribusi Konten per Status</h3>
        </div>
        <div class="card-body">
            @php
                $totalContent = max(($stats['total'] ?? 0), 1);
                $statusRows = [
                    ['label' => 'Total Content', 'value' => $stats['total'] ?? 0, 'color' => '#3b82f6'],
                    ['label' => 'In Production', 'value' => $stats['in_production'] ?? 0, 'color' => '#f97316'],
                    ['label' => 'Need Revision', 'value' => $stats['need_revision'] ?? 0, 'color' => '#ef4444'],
                    ['label' => 'Ready to Publish', 'value' => $stats['ready_to_publish'] ?? 0, 'color' => '#f59e0b'],
                    ['label' => 'Published', 'value' => $stats['published'] ?? 0, 'color' => '#10b981'],
                ];
            @endphp
            <div class="dl-list">
                @foreach($statusRows as $row)
                    @php
                        $width = $row['label'] === 'Total Content' ? 100 : (($row['value'] / $totalContent) * 100);
                    @endphp
                    <div class="dl-item">
                        <div class="dl-left">
                            <span class="dl-dot" style="background:{{ $row['color'] }};"></span>
                            <span>{{ $row['label'] }}</span>
                        </div>
                        <div class="dl-bar-wrap">
                            <div class="dl-bar" style="width:{{ max(2, round($width)) }}%;background:{{ $row['color'] }}cc;"></div>
                        </div>
                        <span class="dl-pct">{{ $row['value'] }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- CHART PER BRAND --}}
    <div class="content-card">
        <div class="card-header">
            <h3>Konten per Brand</h3>
        </div>
        <div class="card-body">
            <div class="dl-list">
                @php $maxBrandCount = max(1, collect($brandStats ?? [])->max('count')); @endphp
                @forelse($brandStats as $index => $brand)
                    @php
                        $palette = ['#6366f1', '#06b6d4', '#a855f7', '#22c55e', '#f97316', '#3b82f6'];
                        $color = $palette[$index % count($palette)];
                        $width = ($brand['count'] / $maxBrandCount) * 100;
                    @endphp
                    <div class="dl-item">
                        <div class="dl-left">
                            <span class="dl-dot" style="background:{{ $color }};"></span>
                            <span>{{ $brand['name'] }}</span>
                        </div>
                        <div class="dl-bar-wrap">
                            <div class="dl-bar" style="width:{{ max(4, round($width)) }}%;background:{{ $color }}cc;"></div>
                        </div>
                        <span class="dl-pct">{{ $brand['count'] }}</span>
                    </div>
                @empty
                    <div class="dl-item">
                        <span>Belum ada data brand</span>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

{{-- CHART PER BULAN --}}
<div class="content-card" style="margin-top:20px;">
    <div class="card-header">
        <h3>Tren Konten per Bulan</h3>
    </div>
    <div class="card-body">
        <div class="trend-grid">
            @php
                $months = $monthlyTrend ?? collect();
                $maxVal = collect($months)->max('value') ?: 1;
            @endphp

            @foreach($months as $m)
                @php $height = ($m['value'] / $maxVal) * 100; @endphp
                <div class="trend-col">
                    <div class="trend-track">
                        <div class="trend-bubble">{{ $m['value'] }} konten</div>
                        <div class="trend-bar" style="height: {{ $height }}%;"></div>
                    </div>
                    <span class="trend-label">{{ $m['label'] }}</span>
                    <span class="trend-value">Total {{ $m['value'] }}</span>
                </div>
            @endforeach
        </div>
    </div>
</div>

{{-- TABEL LAPORAN KONTEN --}}
<div class="content-card" style="margin-top:22px;">
    <div class="card-header" style="display:flex;align-items:center;justify-content:space-between;">
        <div>
            <h3>Ringkasan Konten</h3>
            <p style="font-size:12px;color:var(--text-400);margin-top:4px;">Daftar konten terbaru beserta brand, status, dan jadwal tayang.</p>
        </div>
        <form class="analytics-toolbar" id="analytics-filter">
            <div>
                <label for="filter-brand">Brand</label>
                <select id="filter-brand" class="form-control">
                    <option value="">Semua</option>
                    @foreach(($brandStats ?? []) as $brand)
                        <option value="{{ $brand['name'] }}">{{ $brand['name'] }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="filter-status">Status</label>
                <select id="filter-status" class="form-control">
                    <option value="">Semua</option>
                    <option value="In Production">In Production</option>
                    <option value="Need Revision">Need Revision</option>
                    <option value="Ready to Publish">Ready to Publish</option>
                    <option value="Published">Published</option>
                </select>
            </div>
            <div>
                <label for="filter-deadline">Deadline ≤</label>
                <input type="date" id="filter-deadline" class="form-control">
            </div>
            <div style="display:flex;gap:8px;align-items:center;">
                <button type="button" class="btn btn-ghost" id="btn-reset-filter" style="font-size:12px;padding:6px 10px;border-radius:999px;">
                    <i class="fa-solid fa-rotate-right"></i> Reset
                </button>
                <button type="button" class="btn btn-primary" id="btn-export-csv" style="font-size:12px;padding:6px 12px;border-radius:999px;">
                    <i class="fa-solid fa-download"></i> Export CSV
                </button>
            </div>
        </form>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Judul Konten</th>
                        <th>Brand</th>
                        <th>Status</th>
                        <th>Deadline</th>
                        <th>Tanggal Publish</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse(($tasks ?? []) as $task)
                        @php
                            $production = $task->productions->first();
                            $statusMap = [
                                'in_production' => ['label' => 'In Production', 'class' => 'p-prod'],
                                'under_review' => ['label' => 'Under Review', 'class' => 'p-review'],
                                'need_revision' => ['label' => 'Need Revision', 'class' => 'p-revision'],
                                'ready_to_publish' => ['label' => 'Ready to Publish', 'class' => 'p-ready'],
                                'published' => ['label' => 'Published', 'class' => 'p-pub'],
                            ];
                            $status = $statusMap[$task->status] ?? ['label' => ucfirst(str_replace('_', ' ', $task->status)), 'class' => 'p-review'];
                        @endphp
                        <tr>
                            <td>
                                <span class="td-name">{{ $task->judul_konten }}</span>
                                <div class="td-brand">{{ optional($task->brand)->name ?? '-' }}</div>
                            </td>
                            <td>{{ optional($task->brand)->name ?? '-' }}</td>
                            <td>
                                <span class="pill {{ $status['class'] }}">
                                    <span class="pill-dot"></span>
                                    {{ $status['label'] }}
                                </span>
                            </td>
                            <td class="td-date">
                                <i class="fa-regular fa-calendar"></i>
                                {{ $task->deadline ? $task->deadline->format('d M Y') : '-' }}
                            </td>
                            <td class="td-date">
                                <i class="fa-regular {{ $task->status === 'published' ? 'fa-calendar-check' : 'fa-clock' }}"></i>
                                {{ $task->status === 'published' ? optional($task->updated_at)->format('d M Y') : '-' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align:center;padding:24px;color:var(--text-400);">
                                Belum ada data konten.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    (function() {
        const table = document.querySelector('.data-table tbody');
        if (!table) return;

        const brandSelect = document.getElementById('filter-brand');
        const statusSelect = document.getElementById('filter-status');
        const deadlineInput = document.getElementById('filter-deadline');
        const resetBtn = document.getElementById('btn-reset-filter');
        const exportBtn = document.getElementById('btn-export-csv');

        function parseDateFromCell(cell) {
            if (!cell) return null;
            const text = cell.textContent.replace(/[\n\r]/g,'').trim();
            const parts = text.split(' ').slice(-3); // ex: "18 Mar 2026"
            if (parts.length !== 3) return null;
            const [day, mon, year] = parts;
            const map = {Jan:'01',Feb:'02',Mar:'03',Apr:'04',Mei:'05',Jun:'06',Jul:'07',Agu:'08',Sep:'09',Okt:'10',Nov:'11',Des:'12'};
            const month = map[mon] || '01';
            return new Date(`${year}-${month}-${day.padStart(2,'0')}`);
        }

        function applyFilter() {
            const brandVal = brandSelect.value;
            const statusVal = statusSelect.value;
            const deadlineVal = deadlineInput.value ? new Date(deadlineInput.value) : null;

            Array.from(table.rows).forEach(row => {
                const brandCell = row.cells[1];
                const statusCell = row.cells[2];
                const deadlineCell = row.cells[3];

                const brandText = brandCell ? brandCell.textContent.trim() : '';
                const statusText = statusCell ? statusCell.textContent.trim() : '';
                const rowDate = parseDateFromCell(deadlineCell);

                let visible = true;

                if (brandVal && !brandText.includes(brandVal)) visible = false;
                if (statusVal && !statusText.includes(statusVal)) visible = false;
                if (deadlineVal && rowDate && rowDate > deadlineVal) visible = false;

                row.style.display = visible ? '' : 'none';
            });
        }

        if (brandSelect && statusSelect && deadlineInput) {
            brandSelect.addEventListener('change', applyFilter);
            statusSelect.addEventListener('change', applyFilter);
            deadlineInput.addEventListener('change', applyFilter);
        }

        if (resetBtn) {
            resetBtn.addEventListener('click', function(e) {
                e.preventDefault();
                brandSelect.value = '';
                statusSelect.value = '';
                deadlineInput.value = '';
                applyFilter();
            });
        }

        if (exportBtn) {
            exportBtn.addEventListener('click', function(e) {
                e.preventDefault();
                const rows = Array.from(document.querySelectorAll('.data-table tr'))
                    .filter(r => r.style.display !== 'none');

                if (!rows.length) return;

                const csv = rows.map(row => {
                    return Array.from(row.cells).map(cell => {
                        const text = cell.innerText.replace(/\s+/g,' ').trim();
                        const escaped = text.replace(/"/g,'""');
                        return `"${escaped}"`;
                    }).join(',');
                }).join('\n');

                const blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
                const url = URL.createObjectURL(blob);
                const link = document.createElement('a');
                link.href = url;
                link.download = 'analytics-content-export.csv';
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
                URL.revokeObjectURL(url);
            });
        }
    })();
</script>
@endpush
