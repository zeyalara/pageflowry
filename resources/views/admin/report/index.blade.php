@extends('layouts.admin')

@section('page-title', 'Report')

{{-- inline style khusus halaman Report (tanpa @push agar kompatibel semua versi) --}}
<style>
    .page-header { margin-bottom: 16px; }
    .page-header h1 {
        font-size: 20px;
        font-weight: 800;
        letter-spacing: -0.4px;
        color: var(--text-900);
        margin-bottom: 4px;
    }
    .page-header p { font-size: 13px; color: var(--text-400); }

    .content-card {
        background: var(--surface);
        border-radius: var(--r);
        border: 1px solid var(--border);
        box-shadow: var(--s1);
        padding: 16px 18px 14px;
    }
    .card-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 12px;
    }
    .card-header h3 {
        font-size: 13px;
        font-weight: 700;
        color: var(--text-700);
        letter-spacing: -.1px;
    }
    .card-body { margin-top: 12px; }

    .report-toolbar {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        align-items: center;
        justify-content: space-between;
    }
    .report-filters {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        align-items: center;
        flex: 1;
        min-width: 280px;
    }
    .rf-item { display: flex; align-items: center; gap: 6px; }
    .rf-item label {
        font-size: 11px;
        color: var(--text-400);
        font-weight: 700;
        white-space: nowrap;
    }
    .report-filters .form-control {
        border-radius: 999px;
        border: 1px solid var(--border);
        padding: 7px 10px;
        font-size: 12px;
        background: #fff;
        min-width: 180px;
        outline: none;
        transition: var(--t);
        white-space: nowrap;
    }
    .report-filters .form-control:focus {
        border-color: var(--blue-200);
        box-shadow: 0 0 0 4px rgba(88,151,254,.12);
    }
    .report-actions {
        display: inline-flex;
        flex-wrap: wrap;
        gap: 6px;
        align-items: center;
        justify-content: flex-end;
        padding: 4px;
        border-radius: 999px;
        border: 1px solid var(--border-light);
        background:
            radial-gradient(600px 160px at 0% 0%, rgba(88,151,254,.16), transparent 55%),
            linear-gradient(180deg, rgba(239,246,255,.85), rgba(255,255,255,0.9));
    }
    .report-actions .btn {
        font-size: 12px;
        padding: 7px 12px;
        border-radius: 999px;
        white-space: nowrap;
    }

    .hint {
        margin-top: 6px;
        font-size: 12px;
        color: var(--text-400);
    }

    /* status badges (laporan) */
    .r-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 10px;
        border-radius: 999px;
        font-size: 11px;
        font-weight: 800;
        white-space: nowrap;
        border: 1px solid transparent;
    }
    .r-dot { width: 7px; height: 7px; border-radius: 50%; }
    .rb-prod { background: rgba(59,130,246,.10); color: #1d4ed8; border-color: rgba(59,130,246,.16); }
    .rb-prod .r-dot { background: #3b82f6; }
    .rb-review { background: rgba(245,158,11,.12); color: #92400e; border-color: rgba(245,158,11,.18); }
    .rb-review .r-dot { background: #f59e0b; }
    .rb-revision { background: rgba(239,68,68,.10); color: #b91c1c; border-color: rgba(239,68,68,.16); }
    .rb-revision .r-dot { background: #ef4444; }
    .rb-ready { background: rgba(16,185,129,.10); color: #065f46; border-color: rgba(16,185,129,.16); }
    .rb-ready .r-dot { background: #10b981; }
    .rb-published { background: rgba(20,83,45,.10); color: #14532d; border-color: rgba(20,83,45,.16); }
    .rb-published .r-dot { background: #14532d; }

    /* table tweaks — khusus halaman report, beda dari workflow */
    .report-table-wrapper table { border-collapse: separate; border-spacing: 0; }
    .report-table-wrapper thead th {
        background: linear-gradient(180deg, #f9fafb, #eef2ff);
        border-bottom: 1px solid #e5e7eb;
    }
    .report-table-wrapper tbody tr:nth-child(odd) td { background-color: rgba(249,250,251,.7); }
    .report-table-wrapper tbody tr:nth-child(even) td { background-color: #ffffff; }
    .report-table-wrapper tbody tr:hover td {
        background: #eef2ff;
    }
    .report-table-wrapper .data-table td { vertical-align: middle; }
    #report-table th:nth-child(1), #report-table td:nth-child(1) { white-space: nowrap; }
    #report-table th:nth-child(3), #report-table td:nth-child(3) { white-space: nowrap; min-width: 92px; } /* Brand A tidak turun baris */
    #report-table th:nth-child(6), #report-table td:nth-child(6) { white-space: nowrap; } /* v1/v2 */
    #report-table { width: 100%; min-width: 1180px; }
    .table-responsive {
        width: 100%;
        overflow-x: auto;
        overflow-y: hidden;
        -webkit-overflow-scrolling: touch;
        border-radius: calc(var(--r) - 6px);
    }
    .table-responsive::-webkit-scrollbar { height: 6px; }
    .table-responsive::-webkit-scrollbar-thumb { background: var(--blue-200); border-radius: 99px; }
    .td-sub {
        margin-top: 3px;
        font-size: 11.5px;
        color: var(--text-400);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 300px;
    }
    .td-date { font-variant-numeric: tabular-nums; white-space: nowrap; }

    /* nicer card gradient for report panel */
    .content-card:first-of-type {
        background:
            radial-gradient(1100px 240px at 10% 0%, rgba(88,151,254,.12), transparent 55%),
            radial-gradient(900px 220px at 85% 15%, rgba(139,92,246,.10), transparent 55%),
            var(--surface);
    }

    @media (max-width: 820px) {
        .report-filters .form-control { min-width: 140px; }
    }
    @media (max-width: 520px) {
        .report-filters { min-width: 100%; }
        .report-actions { width: 100%; justify-content: flex-start; }
    }
</style>
@section('content')
<div class="page-header">
    <h1>Report</h1>
    <p>Menu untuk membuat laporan performa konten berdasarkan brand dan periode waktu.</p>
</div>

{{-- RINGKASAN UTAMA LAPORAN --}}
<div class="stat-row" style="margin-bottom:14px;">
    <div class="stat-card sc-blue" style="--i:0">
        <div class="stat-ic">
            <i class="fa-solid fa-layer-group"></i>
        </div>
        <div class="stat-val" data-target="{{ $stats['total'] ?? 0 }}">{{ $stats['total'] ?? 0 }}</div>
        <div class="stat-lbl">Total Konten</div>
    </div>
    <div class="stat-card sc-vio" style="--i:1">
        <div class="stat-ic">
            <i class="fa-solid fa-eye"></i>
        </div>
        <div class="stat-val" data-target="{{ $stats['published'] ?? 0 }}">{{ $stats['published'] ?? 0 }}</div>
        <div class="stat-lbl">Total Published</div>
    </div>
    <div class="stat-card sc-amb" style="--i:2">
        <div class="stat-ic">
            <i class="fa-solid fa-heart"></i>
        </div>
        <div class="stat-val" data-target="{{ $stats['ready_to_publish'] ?? 0 }}">{{ $stats['ready_to_publish'] ?? 0 }}</div>
        <div class="stat-lbl">Ready to Publish</div>
    </div>
    <div class="stat-card sc-em" style="--i:3">
        <div class="stat-ic">
            <i class="fa-solid fa-chart-line"></i>
        </div>
        <div class="stat-val" data-target="{{ $stats['need_revision'] ?? 0 }}">{{ $stats['need_revision'] ?? 0 }}</div>
        <div class="stat-lbl">Need Revision</div>
    </div>
</div>

<div class="content-card">
    <div class="card-header">
        <div>
            <h3>Filter & Export Laporan</h3>
            <div class="hint">
                Fitur Report memungkinkan admin memilih <strong>Brand</strong> dan <strong>periode waktu</strong>,
                lalu mengekspor laporan performa konten ke format <strong>PDF</strong> atau <strong>Excel</strong>.
            </div>
        </div>
        <div style="font-size:12px;color:var(--text-400);font-weight:700;">
            <span id="report-count">{{ ($tasks ?? collect())->count() }}</span> item
        </div>
    </div>
    <div class="card-body">
        <div class="report-toolbar">
            <form class="report-filters" id="report-filter" onsubmit="return false;">
                <div class="rf-item">
                    <label for="rf-status">Status</label>
                    <select id="rf-status" class="form-control">
                        <option value="">Semua</option>
                        <option value="in_production">in_production</option>
                        <option value="under_review">under_review</option>
                        <option value="need_revision">need_revision</option>
                        <option value="ready_to_publish">ready_to_publish</option>
                        <option value="published">published</option>
                    </select>
                </div>
                <div class="rf-item">
                    <label for="rf-brand">Brand</label>
                    <select id="rf-brand" class="form-control">
                        <option value="">Semua</option>
                        @if(isset($brands) && $brands->count() > 0)
                            @foreach($brands as $brand)
                                <option value="{{ $brand->name }}">{{ $brand->name }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="rf-item">
                    <label for="rf-date">Tanggal</label>
                    <input type="date" id="rf-date" class="form-control">
                </div>
                <div class="rf-item">
                    <label for="rf-creator">Creator</label>
                    <input type="text" id="rf-creator" class="form-control" placeholder="Nama creator">
                </div>
            </form>

            <div class="report-actions">
                <button type="button" class="btn btn-ghost" id="btn-refresh">
                    <i class="fa-solid fa-rotate-right"></i> Refresh
                </button>
                <button type="button" class="btn btn-ghost" id="btn-print">
                    <i class="fa-solid fa-print"></i> Print
                </button>
                <button type="button" class="btn btn-ghost" id="btn-export-excel">
                    <i class="fa-solid fa-file-excel"></i> Export Excel
                </button>
                <button type="button" class="btn btn-primary" id="btn-export-pdf">
                    <i class="fa-solid fa-file-pdf"></i> Export PDF
                </button>
            </div>
        </div>
    </div>
</div>

<div class="content-card">
    <div class="card-header">
        <div>
            <h3>Data Laporan</h3>
            <div class="hint">
                Rekap detail konten per ID, brand, creator, status, versi video, dan timeline produksi.
            </div>
        </div>
        <div style="text-align:right;font-size:11.5px;color:var(--text-400);max-width:220px;">
            Format export: <strong>PDF</strong> &amp; <strong>Excel</strong> •
            Isi: <strong>Total Konten</strong>, <strong>Views</strong>, <strong>Engagement</strong>, <strong>KPI vs Realisasi</strong>.
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive report-table-wrapper">
            <table class="data-table" id="report-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Judul Konten</th>
                        <th>Brand</th>
                        <th>Creator</th>
                        <th>Status</th>
                        <th>Versi Video</th>
                        <th>Deadline</th>
                        <th>Tanggal Upload</th>
                        <th>Tanggal Publish</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse(($tasks ?? []) as $task)
                        @php
                            $production = $task->productions->first();
                            $badgeMap = [
                                'in_production' => 'rb-prod',
                                'under_review' => 'rb-review',
                                'need_revision' => 'rb-revision',
                                'ready_to_publish' => 'rb-ready',
                                'published' => 'rb-published',
                            ];
                            $badgeClass = $badgeMap[$task->status] ?? 'rb-review';
                        @endphp
                        <tr>
                            <td>{{ $task->id }}</td>
                            <td>
                                <span class="td-name">{{ $task->judul_konten }}</span>
                                <div class="td-sub">{{ Str::limit($task->deskripsi ?? '-', 60) }}</div>
                            </td>
                            <td>{{ optional($task->brand)->name ?? '-' }}</td>
                            <td>{{ optional($task->creator)->name ?? '-' }}</td>
                            <td data-status="{{ $task->status }}">
                                <span class="r-badge {{ $badgeClass }}"><span class="r-dot"></span>{{ $task->status }}</span>
                            </td>
                            <td>{{ $production?->versi_video ?? '-' }}</td>
                            <td class="td-date">{{ $task->deadline ? $task->deadline->format('Y-m-d') : '-' }}</td>
                            <td class="td-date">{{ $production?->created_at?->format('Y-m-d') ?? '-' }}</td>
                            <td class="td-date">{{ $task->status === 'published' ? optional($task->updated_at)->format('Y-m-d') : '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" style="text-align:center;padding:28px;color:var(--text-400);">
                                Belum ada data laporan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    // Kept inside content so it always runs (no dependency on stack scripts).
    (function () {
        function byId(id) { return document.getElementById(id); }
        function normalize(s) { return (s || '').toString().replace(/^\s+|\s+$/g, '').toLowerCase(); }
        function bind(el, ev, fn) { if (el) el.addEventListener(ev, fn); }

        var table = byId('report-table');
        if (!table || !table.tBodies || !table.tBodies[0]) return;

        var statusEl = byId('rf-status');
        var brandEl = byId('rf-brand');
        var dateEl = byId('rf-date');
        var creatorEl = byId('rf-creator');
        var countEl = byId('report-count');

        var btnRefresh = byId('btn-refresh');
        var btnPrint = byId('btn-print');
        var btnExcel = byId('btn-export-excel');
        var btnPdf = byId('btn-export-pdf');

        function applyFilters() {
            var statusVal = normalize(statusEl && statusEl.value);
            var brandVal = normalize(brandEl && brandEl.value);
            var dateVal = (dateEl && dateEl.value) ? (dateEl.value + '').replace(/^\s+|\s+$/g, '') : '';
            var creatorVal = normalize(creatorEl && creatorEl.value);

            var visibleCount = 0;
            var rows = table.tBodies[0].rows;

            for (var i = 0; i < rows.length; i++) {
                var row = rows[i];
                var statusCell = row.querySelector('td[data-status]');
                var rowStatus = normalize(statusCell && statusCell.getAttribute('data-status'));
                var rowBrand = normalize(row.cells[2] && row.cells[2].textContent);
                var rowCreator = normalize(row.cells[3] && row.cells[3].textContent);

                var deadline = (row.cells[6] && row.cells[6].textContent) ? (row.cells[6].textContent + '').replace(/^\s+|\s+$/g, '') : '';
                var upload = (row.cells[7] && row.cells[7].textContent) ? (row.cells[7].textContent + '').replace(/^\s+|\s+$/g, '') : '';
                var publish = (row.cells[8] && row.cells[8].textContent) ? (row.cells[8].textContent + '').replace(/^\s+|\s+$/g, '') : '';

                var show = true;
                if (statusVal && rowStatus !== statusVal) show = false;
                if (brandVal && rowBrand.indexOf(brandVal) === -1) show = false;
                if (creatorVal && rowCreator.indexOf(creatorVal) === -1) show = false;
                if (dateVal) {
                    var dateHit = (deadline === dateVal) || (upload === dateVal) || (publish === dateVal);
                    if (!dateHit) show = false;
                }

                row.style.display = show ? '' : 'none';
                if (show) visibleCount++;
            }

            if (countEl) countEl.textContent = visibleCount;
        }

        function getVisibleTableClone() {
            var clone = table.cloneNode(true);
            var bodyRows = clone.tBodies[0].rows;
            for (var i = bodyRows.length - 1; i >= 0; i--) {
                var orig = table.tBodies[0].rows[i];
                if (orig && orig.style.display === 'none') bodyRows[i].parentNode.removeChild(bodyRows[i]);
            }
            var subs = clone.querySelectorAll('.td-sub');
            for (var s = subs.length - 1; s >= 0; s--) subs[s].parentNode.removeChild(subs[s]);
            var dots = clone.querySelectorAll('.r-dot');
            for (var d = dots.length - 1; d >= 0; d--) dots[d].parentNode.removeChild(dots[d]);
            return clone;
        }

        function exportVisibleRowsToExcel(filenameXls) {
            var exportTable = getVisibleTableClone();
            var html =
                '<html xmlns:o="urn:schemas-microsoft-com:office:office" ' +
                'xmlns:x="urn:schemas-microsoft-com:office:excel" ' +
                'xmlns="http://www.w3.org/TR/REC-html40">' +
                '<head><meta charset="utf-8" />' +
                '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head>' +
                '<body>' + exportTable.outerHTML + '</body></html>';

            var blob = new Blob([html], { type: 'application/vnd.ms-excel;charset=utf-8;' });
            var url = URL.createObjectURL(blob);
            var link = document.createElement('a');
            link.href = url;
            link.download = filenameXls;
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
            URL.revokeObjectURL(url);
        }

        function openPrintView(title) {
            var win = window.open('', '_blank');
            if (!win) return;

            var exportTable = getVisibleTableClone();
            var html =
                '<html><head><meta charset="utf-8" />' +
                '<title>' + title + '</title>' +
                '<style>' +
                'body{font-family:Arial,sans-serif;padding:18px;color:#0f172a}' +
                'h1{font-size:16px;margin:0 0 8px}' +
                'p{margin:0 0 14px;font-size:12px;color:#475569}' +
                'table{width:100%;border-collapse:collapse;font-size:11px}' +
                'th,td{border-bottom:1px solid #e2e8f0;padding:8px 6px;text-align:left;vertical-align:top}' +
                'th{font-size:10px;text-transform:uppercase;letter-spacing:.6px;color:#64748b}' +
                '</style>' +
                '</head><body>' +
                '<h1>' + title + '</h1>' +
                '<p>Generated: ' + (new Date()).toLocaleString('id-ID') + '</p>' +
                exportTable.outerHTML +
                '</body></html>';

            win.document.open();
            win.document.write(html);
            win.document.close();
            win.onload = function () {
                try { win.focus(); } catch (e) {}
                win.print();
            };
        }

        bind(statusEl, 'change', applyFilters);
        bind(brandEl, 'change', applyFilters);
        bind(dateEl, 'change', applyFilters);
        bind(creatorEl, 'input', applyFilters);

        bind(btnRefresh, 'click', function () { window.location.reload(); });
        bind(btnPrint, 'click', function () { openPrintView('Report — Print'); });
        bind(btnPdf, 'click', function () { openPrintView('Report — Export PDF'); });
        bind(btnExcel, 'click', function () { exportVisibleRowsToExcel('report-export.xls'); });

        applyFilters();
    })();
</script>
@endsection
