<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <style>
        * { box-sizing: border-box; }
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 10px;
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
            padding: 8px 6px;
            font-size: 9px;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            border: 1px solid #3a7bfe;
        }
        tbody td {
            padding: 7px 6px;
            border: 1px solid #e8eef9;
            vertical-align: top;
            font-size: 9px;
        }
        tbody tr:nth-child(even) { background: #f8fbff; }
        .num { width: 28px; text-align: center; font-weight: bold; color: #5897fe; }
        .status-active {
            background: #d1f2eb;
            color: #065f46;
            padding: 2px 6px;
            border-radius: 4px;
            font-weight: bold;
            font-size: 8px;
        }
        .status-inactive {
            background: #fee2e2;
            color: #991b1b;
            padding: 2px 6px;
            border-radius: 4px;
            font-weight: bold;
            font-size: 8px;
        }
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
        <div class="title">Daftar Brand</div>
        <div class="meta">
            Diekspor oleh: <strong>{{ $user->name ?? '—' }}</strong> ({{ $user->email ?? '—' }})<br>
            Tanggal: {{ $exportedAt->format('d M Y, H:i') }} · Total: {{ $brands->count() }} brand
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th class="num">#</th>
                <th>Nama Brand</th>
                <th>PIC</th>
                <th>Kontak</th>
                <th>Target Market</th>
                <th>Tone</th>
                <th style="text-align:center;">Jml. Konten</th>
                <th>Status</th>
                <th>Dibuat</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($brands as $i => $brand)
                <tr>
                    <td class="num">{{ $i + 1 }}</td>
                    <td><strong>{{ $brand->name ?: '—' }}</strong></td>
                    <td>{{ $brand->pic ?: '—' }}</td>
                    <td>{{ $brand->contact ?: '—' }}</td>
                    <td>{{ \Illuminate\Support\Str::limit(strip_tags($brand->target_market ?? ''), 80) }}</td>
                    <td>{{ \Illuminate\Support\Str::limit($brand->tone ?? '—', 40) }}</td>
                    <td style="text-align:center;font-weight:bold;">{{ (int) ($brand->contents_count ?? 0) }}</td>
                    <td>
                        @if (($brand->status ?? '') === 'Active')
                            <span class="status-active">Active</span>
                        @else
                            <span class="status-inactive">{{ $brand->status ?: '—' }}</span>
                        @endif
                    </td>
                    <td>{{ optional($brand->created_at)->format('d M Y') ?? '—' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" style="text-align:center;padding:20px;color:#8fa3c4;">Belum ada data brand.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Pageflowry — Laporan ini dibuat otomatis dari data akun Anda.
    </div>
</body>
</html>
