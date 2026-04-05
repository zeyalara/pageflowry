<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <style>
        * { box-sizing: border-box; }
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 9px;
            color: #0d1526;
            margin: 0;
            padding: 12px 16px 24px;
        }
        .header {
            border-bottom: 3px solid #5897fe;
            padding-bottom: 10px;
            margin-bottom: 14px;
        }
        .brand-mark {
            font-size: 18px;
            font-weight: bold;
            color: #5897fe;
            letter-spacing: -0.5px;
        }
        .brand-mark em { color: #0d1526; font-style: normal; }
        .title {
            font-size: 15px;
            font-weight: bold;
            margin-top: 6px;
            color: #2d3f5e;
        }
        .meta {
            font-size: 9px;
            color: #5c7099;
            margin-top: 6px;
            line-height: 1.5;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
        }
        thead th {
            background: #5897fe;
            color: #fff;
            font-weight: bold;
            text-align: left;
            padding: 7px 5px;
            font-size: 8px;
            text-transform: uppercase;
            letter-spacing: 0.2px;
            border: 1px solid #3a7bfe;
        }
        tbody td {
            padding: 6px 5px;
            border: 1px solid #e8eef9;
            vertical-align: top;
            font-size: 8px;
        }
        tbody tr:nth-child(even) { background: #f8fbff; }
        .num { width: 22px; text-align: center; font-weight: bold; color: #5897fe; }
        .pill {
            display: inline-block;
            padding: 2px 5px;
            border-radius: 4px;
            font-size: 7px;
            font-weight: bold;
        }
        .p-prod { background: #ffedd5; color: #c2410c; }
        .p-review { background: #ede9fe; color: #5b21b6; }
        .p-revision { background: #ffe4e6; color: #9f1239; }
        .p-ready { background: #fef3c7; color: #92400e; }
        .p-pub { background: #d1fae5; color: #065f46; }
        .footer {
            margin-top: 14px;
            font-size: 8px;
            color: #8fa3c4;
            text-align: center;
            border-top: 1px solid #e8eef9;
            padding-top: 8px;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="brand-mark">Page<em>flowry</em></div>
        <div class="title">Daftar Tugas Konten</div>
        <div class="meta">
            Diekspor oleh: <strong>{{ $user->name ?? '—' }}</strong> ({{ $user->email ?? '—' }})<br>
            Tanggal: {{ $exportedAt->format('d M Y, H:i') }} · Total: {{ $contentBriefs->count() }} tugas
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th class="num">#</th>
                <th>Judul Konten</th>
                <th>Brand</th>
                <th>Platform</th>
                <th>Format</th>
                <th>Deadline Produksi</th>
                <th>Deadline Publish</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($contentBriefs as $i => $brief)
                @php
                    $s = $brief->status ?? '';
                    $pill = match ($s) {
                        'In Production' => 'p-prod',
                        'Under Review' => 'p-review',
                        'Need Revision' => 'p-revision',
                        'Ready to Publish' => 'p-ready',
                        'Published' => 'p-pub',
                        default => 'p-review',
                    };
                @endphp
                <tr>
                    <td class="num">{{ $i + 1 }}</td>
                    <td><strong>{{ \Illuminate\Support\Str::limit($brief->title ?? '—', 45) }}</strong></td>
                    <td>{{ $brief->brand->name ?? '—' }}</td>
                    <td>{{ $brief->platform ?? '—' }}</td>
                    <td>{{ \Illuminate\Support\Str::limit($brief->content_format ?? '—', 22) }}</td>
                    <td>{{ optional($brief->production_deadline)->format('d M Y') ?? '—' }}</td>
                    <td>{{ optional($brief->publish_deadline)->format('d M Y') ?? '—' }}</td>
                    <td><span class="pill {{ $pill }}">{{ $s ?: '—' }}</span></td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="text-align:center;padding:20px;color:#8fa3c4;">Belum ada tugas konten.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Pageflowry — Laporan ini dibuat otomatis dari data akun Anda.
    </div>
</body>
</html>
