@extends('layouts.admin')

@section('page-title', 'Dashboard')

@section('content')
<div style="display:flex;align-items:center;justify-content:space-between;gap:14px;flex-wrap:wrap;">
  <div>
    <div style="font-size:18px;font-weight:800;color:var(--text-900);letter-spacing:-.3px;">Dashboard</div>
    <div style="font-size:12px;color:var(--text-400);margin-top:4px;">
      Data real dari database · Akun: <span style="color:var(--blue);font-weight:600;">{{ $user->email }}</span>
    </div>
  </div>
  <div style="display:flex;gap:10px;flex-wrap:wrap;">
    <a href="{{ route('content-tasks.create') }}" class="qa-btn" style="width:auto;text-decoration:none;color:inherit;">
      <div class="qa-ic" style="background:linear-gradient(135deg,var(--blue),var(--blue-600));color:#fff;"><i class="fa-solid fa-plus"></i></div>
      <div class="qa-text">
        <div class="qa-label">Buat Tugas Konten</div>
        <div class="qa-sub">Daftar Tugas Konten</div>
      </div>
      <i class="fa-solid fa-chevron-right qa-arr"></i>
    </a>
    <a href="{{ route('brands.index') }}" class="qa-btn" style="width:auto;text-decoration:none;color:inherit;">
      <div class="qa-ic" style="background:linear-gradient(135deg,var(--emerald),#059669);color:#fff;"><i class="fa-solid fa-tag"></i></div>
      <div class="qa-text">
        <div class="qa-label">Brand</div>
        <div class="qa-sub">Kelola brand</div>
      </div>
      <i class="fa-solid fa-chevron-right qa-arr"></i>
    </a>
    <a href="{{ route('publishing.index') }}" class="qa-btn" style="width:auto;text-decoration:none;color:inherit;">
      <div class="qa-ic" style="background:linear-gradient(135deg,var(--amber),#d97706);color:#fff;"><i class="fa-solid fa-paper-plane"></i></div>
      <div class="qa-text">
        <div class="qa-label">Published</div>
        <div class="qa-sub">Lihat konten yang sudah publish</div>
      </div>
      <i class="fa-solid fa-chevron-right qa-arr"></i>
    </a>
  </div>
</div>

<div class="stat-row" style="grid-template-columns:repeat(auto-fit,minmax(200px,1fr));">
  <a class="stat-card sc-blue" style="text-decoration:none;color:inherit;" href="{{ route('content-tasks.index') }}">
    <div class="stat-ic"><i class="fa-solid fa-list-check"></i></div>
    <div class="stat-val">{{ $stats['total_briefs'] ?? 0 }}</div>
    <div class="stat-lbl">Total Tugas (Daftar Tugas Konten)</div>
  </a>
  <a class="stat-card sc-vio" style="text-decoration:none;color:inherit;" href="{{ route('brands.index') }}">
    <div class="stat-ic"><i class="fa-solid fa-tag"></i></div>
    <div class="stat-val">{{ $stats['total_brands'] ?? 0 }}</div>
    <div class="stat-lbl">Total Brand</div>
  </a>
  <a class="stat-card sc-org" style="text-decoration:none;color:inherit;" href="{{ route('production.index') }}">
    <div class="stat-ic"><i class="fa-solid fa-film"></i></div>
    <div class="stat-val">{{ $stats['in_production'] ?? 0 }}</div>
    <div class="stat-lbl">In Production</div>
  </a>
  <a class="stat-card sc-vio" style="text-decoration:none;color:inherit;" href="{{ route('revision.index') }}">
    <div class="stat-ic"><i class="fa-solid fa-eye"></i></div>
    <div class="stat-val">{{ $stats['under_review'] ?? 0 }}</div>
    <div class="stat-lbl">Under Review</div>
  </a>
  <a class="stat-card sc-red" style="text-decoration:none;color:inherit;" href="{{ route('revision.index') }}">
    <div class="stat-ic"><i class="fa-solid fa-triangle-exclamation"></i></div>
    <div class="stat-val">{{ $stats['need_revision'] ?? 0 }}</div>
    <div class="stat-lbl">Need Revision</div>
  </a>
  <a class="stat-card sc-amb" style="text-decoration:none;color:inherit;" href="{{ route('publishing.index') }}">
    <div class="stat-ic"><i class="fa-solid fa-paper-plane"></i></div>
    <div class="stat-val">{{ $stats['ready_to_publish'] ?? 0 }}</div>
    <div class="stat-lbl">Ready to Publish</div>
  </a>
  <a class="stat-card sc-em" style="text-decoration:none;color:inherit;" href="{{ route('publishing.index') }}">
    <div class="stat-ic"><i class="fa-solid fa-circle-check"></i></div>
    <div class="stat-val">{{ $stats['published'] ?? 0 }}</div>
    <div class="stat-lbl">Published</div>
  </a>
      </div>

<div class="table-row" style="grid-template-columns:repeat(auto-fit,minmax(340px,1fr));">
      <div class="card tbl-card">
        <div class="sec-head" style="margin-bottom:0">
          <div class="sec-title"><i class="fa-solid fa-calendar-xmark"></i> Deadline Produksi Terdekat</div>
      <a class="sec-link" href="{{ route('content-tasks.index') }}">Semua <i class="fa-solid fa-arrow-right" style="font-size:10px"></i></a>
        </div>
        <table>
          <thead>
            <tr>
              <th>Judul Konten</th>
              <th>Deadline</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
        @forelse ($upcomingProduction as $row)
          <tr>
            <td>
              <span class="td-name">{{ $row->title }}</span>
              <span class="td-brand">{{ $row->brand->name ?? 'No Brand' }}</span>
            </td>
            <td class="td-date">
              <i class="fa-regular fa-calendar"></i>
              {{ optional($row->production_deadline)->format('d M Y') }}
            </td>
            <td>
              @php
                $s = $row->status ?? '';
                $pill = match ($s) {
                  'In Production' => 'p-prod',
                  'Under Review' => 'p-review',
                  'Need Revision' => 'p-revision',
                  'Ready to Publish' => 'p-ready',
                  'Published' => 'p-pub',
                  default => 'p-prod',
                };
              @endphp
              <span class="pill {{ $pill }}"><span class="pill-dot"></span>{{ $s ?: '-' }}</span>
            </td>
            </tr>
        @empty
          <tr><td colspan="3" style="color:var(--text-400);padding:14px 10px;">Belum ada data.</td></tr>
        @endforelse
          </tbody>
        </table>
      </div>

      <div class="card tbl-card">
        <div class="sec-head" style="margin-bottom:0">
          <div class="sec-title"><i class="fa-solid fa-paper-plane"></i> Jadwal Publish Terdekat</div>
      <a class="sec-link" href="{{ route('publishing.index') }}">Semua <i class="fa-solid fa-arrow-right" style="font-size:10px"></i></a>
        </div>
        <table>
          <thead>
            <tr>
              <th>Judul Konten</th>
              <th>Tanggal</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
        @forelse ($upcomingPublish as $row)
          <tr>
            <td>
              <span class="td-name">{{ $row->title }}</span>
              <span class="td-brand">{{ $row->brand->name ?? 'No Brand' }}</span>
            </td>
            <td class="td-date">
              <i class="fa-regular fa-calendar"></i>
              {{ optional($row->publish_deadline)->format('d M Y') }}
            </td>
            <td>
              @php
                $s = $row->status ?? '';
                $pill = match ($s) {
                  'Ready to Publish' => 'p-ready',
                  'Published' => 'p-pub',
                  'Need Revision' => 'p-revision',
                  'Under Review' => 'p-review',
                  'In Production' => 'p-prod',
                  default => 'p-ready',
                };
              @endphp
              <span class="pill {{ $pill }}"><span class="pill-dot"></span>{{ $s ?: '-' }}</span>
            </td>
            </tr>
        @empty
          <tr><td colspan="3" style="color:var(--text-400);padding:14px 10px;">Belum ada data.</td></tr>
        @endforelse
          </tbody>
        </table>
      </div>
    </div>

<div class="bottom-row" style="grid-template-columns:repeat(auto-fit,minmax(340px,1fr));">
      <div class="card act-card">
        <div class="sec-head" style="margin-bottom:0">
      <div class="sec-title"><i class="fa-solid fa-clock-rotate-left"></i> Aktivitas Terbaru (DB)</div>
      <a class="sec-link" href="{{ route('content-tasks.index') }}">Semua <i class="fa-solid fa-arrow-right" style="font-size:10px"></i></a>
        </div>
        <div class="act-list">
      @forelse ($recentUploads as $p)
          <div class="act-item">
            <div class="act-dot ad-blue"><i class="fa-solid fa-cloud-arrow-up"></i></div>
            <div class="act-body">
            <div class="act-name">Upload video</div>
            <div class="act-detail">
              {{ $p->contentTask->judul_konten ?? '-' }}
              · {{ $p->contentTask->brand->name ?? 'No Brand' }}
              @if($p->versi_video) · v{{ $p->versi_video }} @endif
            </div>
          </div>
          <div class="act-time">{{ optional($p->created_at)->diffForHumans() }}</div>
            </div>
      @empty
        @forelse ($recentBriefs as $b)
          <div class="act-item">
            <div class="act-dot ad-vio"><i class="fa-solid fa-file-circle-plus"></i></div>
            <div class="act-body">
              <div class="act-name">Brief dibuat</div>
              <div class="act-detail">{{ $b->title }} · {{ $b->brand->name ?? 'No Brand' }}</div>
            </div>
            <div class="act-time">{{ optional($b->created_at)->diffForHumans() }}</div>
          </div>
        @empty
          <div style="color:var(--text-400);padding:12px 8px;">Belum ada aktivitas.</div>
        @endforelse
      @endforelse
        </div>
      </div>

      <div class="card qa-card">
    <div class="sec-title"><i class="fa-solid fa-bolt"></i> Quick Links</div>
        <div class="qa-list">
      <a class="qa-btn qa-1" href="{{ route('content-tasks.index') }}" style="text-decoration:none;color:inherit;">
            <div class="qa-ic"><i class="fa-solid fa-plus"></i></div>
            <div class="qa-text">
              <div class="qa-label">Konten</div>
          <div class="qa-sub">Daftar Tugas Konten</div>
            </div>
            <i class="fa-solid fa-chevron-right qa-arr"></i>
      </a>
      <a class="qa-btn qa-2" href="{{ route('brands.index') }}" style="text-decoration:none;color:inherit;">
            <div class="qa-ic"><i class="fa-solid fa-tag"></i></div>
            <div class="qa-text">
          <div class="qa-label">Brand Management</div>
          <div class="qa-sub">Tambah & kelola brand</div>
            </div>
            <i class="fa-solid fa-chevron-right qa-arr"></i>
      </a>
      <a class="qa-btn qa-3" href="{{ route('publishing.index') }}" style="text-decoration:none;color:inherit;">
        <div class="qa-ic"><i class="fa-solid fa-paper-plane"></i></div>
            <div class="qa-text">
          <div class="qa-label">Publishing</div>
          <div class="qa-sub">Konten siap publish</div>
            </div>
            <i class="fa-solid fa-chevron-right qa-arr"></i>
      </a>
        </div>
              </div>
            </div>
@endsection

