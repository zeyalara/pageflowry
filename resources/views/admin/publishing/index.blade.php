@extends('layouts.admin')

@section('page-title', 'Publishing')

<style>
    .page-header {
        margin-bottom: 16px;
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

    .pub-stat-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 14px;
        margin-bottom: 18px;
    }
    .pub-stat {
        background: var(--surface);
        border-radius: var(--r);
        border: 1px solid var(--border);
        box-shadow: var(--s1);
        padding: 16px 16px 14px;
        display: flex;
        flex-direction: column;
        gap: 8px;
    }
    .pub-stat-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 8px;
    }
    .pub-stat-icon {
        width: 32px;
        height: 32px;
        border-radius: 999px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 15px;
    }
    .pub-stat-meta {
        font-size: 11px;
        color: var(--text-400);
    }
    .pub-stat-label {
        font-size: 12px;
        font-weight: 600;
        color: var(--text-700);
    }
    .pub-stat-value {
        font-size: 26px;
        font-weight: 800;
        letter-spacing: -.4px;
        color: var(--text-900);
    }
    .pub-stat-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 9px;
        border-radius: 999px;
        font-size: 11px;
        font-weight: 600;
    }
    .pub-stat-pill span {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        display: inline-block;
    }
    .pub-stat-wait { background: rgba(245,158,11,.10); color:#92400e; }
    .pub-stat-wait span { background:#f59e0b; }
    .pub-stat-done { background: rgba(16,185,129,.10); color:#065f46; }
    .pub-stat-done span { background:#10b981; }

    .publishing-card {
        background: var(--surface);
        border-radius: var(--r);
        border: 1px solid var(--border);
        box-shadow: var(--s1);
        padding: 16px 18px 16px;
        margin-top: 6px;
    }
    .publishing-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        margin-bottom: 8px;
    }
    .publishing-header-left {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }
    .publishing-subtitle {
        font-size: 12px;
        color: var(--text-400);
    }
    .bulk-actions {
        display: none;
        align-items: center;
        gap: 10px;
    }
    .btn-bulk {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 14px;
        border: none;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: #fff;
        box-shadow: 0 4px 14px rgba(16,185,129,.25);
    }
    .btn-bulk i { font-size: 13px; }

    .publishing-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        margin-top: 8px;
        font-size: 12.5px;
    }
    .publishing-table thead th {
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: .7px;
        color: var(--text-300);
        padding: 8px 10px;
        border-bottom: 1px solid var(--border-light);
        background: linear-gradient(180deg,#f9fafb,#eef2ff);
    }
    .publishing-table tbody td {
        padding: 10px 10px;
        border-bottom: 1px solid var(--border-light);
        vertical-align: middle;
    }
    .publishing-table tbody tr:hover td {
        background: #f5f3ff;
    }

    .publish-status-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 10px;
        border-radius: 999px;
        font-size: 11px;
        font-weight: 600;
        background: rgba(16,185,129,.08);
        color: #047857;
    }
    .publish-status-pill span {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: #10b981;
    }

    .pub-actions {
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .btn-action {
        width: 30px;
        height: 30px;
        border-radius: 999px;
        border: 1px solid var(--border);
        background: var(--white);
        color: var(--text-400);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        cursor: pointer;
        transition: var(--t);
    }
    .btn-action:hover {
        border-color: #10b981;
        background: rgba(16,185,129,.08);
        color: #047857;
        box-shadow: 0 3px 10px rgba(16,185,129,.22);
    }

    .alert {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 14px;
        border-radius: var(--r-sm);
        margin-bottom: 16px;
        font-size: 12.5px;
    }
    .alert-success {
        background: rgba(16,185,129,.08);
        color: #047857;
        border: 1px solid rgba(16,185,129,.20);
    }
    .alert-error {
        background: rgba(239,68,68,.08);
        color: #b91c1c;
        border: 1px solid rgba(239,68,68,.20);
    }

    .modal-overlay {
        position: fixed;
        inset: 0;
        background: rgba(15,23,42,.45);
        backdrop-filter: blur(4px);
        z-index: 9999;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .modal-content {
        background: var(--surface);
        border-radius: var(--r);
        width: 100%;
        max-width: 460px;
        box-shadow: var(--s3);
        overflow: hidden;
    }
    .modal-content.modal-content--wide {
        max-width: min(960px, calc(100vw - 32px));
        max-height: calc(100vh - 40px);
        display: flex;
        flex-direction: column;
    }
    .modal-content.modal-content--wide .modal-body {
        overflow-y: auto;
        flex: 1;
        min-height: 0;
    }
    .modal-header {
        padding: 18px 20px;
        border-bottom: 1px solid var(--border);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .modal-title {
        font-size: 15px;
        font-weight: 700;
        color: var(--text-900);
        display: flex;
        align-items: center;
        gap: 7px;
    }
    .modal-close {
        width: 30px;
        height: 30px;
        border-radius: 999px;
        border: none;
        background: var(--bg);
        color: var(--text-400);
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .modal-body {
        padding: 18px 20px;
        font-size: 13px;
        color: var(--text-700);
    }
    .modal-actions {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 10px;
        padding: 12px 20px 16px;
        border-top: 1px solid var(--border);
        background: #f9fafb;
    }
    .btn-secondary,
    .btn-primary {
        padding: 7px 14px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        border: 1px solid transparent;
    }
    .btn-secondary {
        background: #fff;
        border-color: var(--border);
        color: var(--text-700);
    }
    .btn-primary {
        background: #0ea5e9;
        border-color: #0ea5e9;
        color: #fff;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .pub-toast {
        position: fixed;
        right: 22px;
        bottom: 22px;
        z-index: 9999;
        padding: 9px 14px;
        border-radius: 999px;
        background: #022c22;
        color: #ecfdf5;
        font-size: 12.5px;
        display: flex;
        align-items: center;
        gap: 7px;
        box-shadow: 0 6px 22px rgba(15,23,42,.5);
    }

    .pp-wrap {
        display: grid;
        grid-template-columns: minmax(220px, 1fr) minmax(280px, 1.1fr);
        gap: 20px;
        align-items: start;
    }
    @media (max-width: 820px) {
        .pp-wrap { grid-template-columns: 1fr; }
    }
    .pp-device {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 10px;
    }
    .pp-device-label {
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .06em;
        color: var(--text-400);
    }
    .pp-frame {
        position: relative;
        border-radius: 28px;
        overflow: hidden;
        box-shadow: 0 16px 48px rgba(15,23,42,.28), 0 0 0 1px rgba(0,0,0,.06);
        background: #0f0f0f;
    }
    .pp-frame.pp-aspect-916 {
        width: 100%;
        max-width: 280px;
        aspect-ratio: 9 / 16;
    }
    .pp-frame.pp-aspect-169 {
        width: 100%;
        max-width: 320px;
        aspect-ratio: 16 / 9;
    }
    .pp-frame.pp-aspect-45 {
        width: 100%;
        max-width: 260px;
        aspect-ratio: 4 / 5;
    }
    .pp-frame video, .pp-frame .pp-video-ph {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .pp-video-ph {
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(145deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
        color: rgba(255,255,255,.35);
        font-size: 42px;
    }
    .pp-chrome {
        position: absolute;
        left: 0;
        right: 0;
        z-index: 2;
        pointer-events: none;
    }
    .pp-chrome-top {
        top: 0;
        padding: 10px 12px 24px;
        background: linear-gradient(180deg, rgba(0,0,0,.65) 0%, transparent 100%);
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-size: 11px;
        font-weight: 700;
        color: #fff;
    }
    .pp-chrome-bottom {
        bottom: 0;
        padding: 20px 12px 12px;
        background: linear-gradient(0deg, rgba(0,0,0,.75) 0%, transparent 100%);
        color: #fff;
        font-size: 12px;
        line-height: 1.35;
    }
    .pp-chrome-bottom .pp-user {
        font-weight: 700;
        margin-bottom: 4px;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .pp-chrome-bottom .pp-cap-preview {
        opacity: .92;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .pp-ig-badge {
        font-size: 10px;
        opacity: .85;
        letter-spacing: .1em;
    }
    .pp-tiktok-side {
        position: absolute;
        right: 8px;
        bottom: 80px;
        display: flex;
        flex-direction: column;
        gap: 14px;
        color: #fff;
        font-size: 18px;
        text-align: center;
        text-shadow: 0 1px 4px rgba(0,0,0,.6);
    }
    .pp-tiktok-side span { font-size: 9px; display: block; margin-top: 2px; opacity: .9; }
    .pp-yt-shorts-bar {
        position: absolute;
        bottom: 8px;
        left: 50%;
        transform: translateX(-50%);
        background: rgba(255,255,255,.15);
        padding: 4px 12px;
        border-radius: 999px;
        font-size: 10px;
        font-weight: 700;
        color: #fff;
        letter-spacing: .04em;
    }
    .pp-live-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: #10b981;
        display: inline-block;
        margin-right: 4px;
        animation: pp-pulse 1.5s ease infinite;
    }
    @keyframes pp-pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: .45; }
    }
    .pp-side-panel h4 {
        font-size: 12px;
        font-weight: 700;
        color: var(--text-900);
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .pp-side-panel .pp-meta {
        font-size: 11px;
        color: var(--text-400);
        margin-bottom: 14px;
        line-height: 1.5;
    }
    .pp-box {
        background: var(--bg);
        border: 1px solid var(--border);
        border-radius: 10px;
        padding: 10px 12px;
        font-size: 12.5px;
        color: var(--text-700);
        line-height: 1.45;
        margin-bottom: 10px;
        white-space: pre-wrap;
        word-break: break-word;
        max-height: 120px;
        overflow-y: auto;
    }
    .pp-box.pp-hashtags {
        color: #2563eb;
        max-height: 72px;
    }
    .pp-copy-row {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-bottom: 14px;
    }
    .btn-copy {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 11px;
        border-radius: 999px;
        border: 1px solid var(--border);
        background: var(--white);
        font-size: 11px;
        font-weight: 600;
        color: var(--text-700);
        cursor: pointer;
        transition: var(--t);
    }
    .btn-copy:hover {
        border-color: #0ea5e9;
        color: #0369a1;
        background: rgba(14,165,233,.06);
    }
    .pp-steps {
        background: linear-gradient(135deg, #eff6ff 0%, #f0fdf4 100%);
        border: 1px solid rgba(14,165,233,.2);
        border-radius: 10px;
        padding: 12px 14px;
        font-size: 12px;
        color: var(--text-700);
        line-height: 1.55;
    }
    .pp-steps ol {
        margin: 8px 0 0 18px;
        padding: 0;
    }
    .pp-steps li { margin-bottom: 6px; }
    .pp-picker-wrap {
        margin-bottom: 14px;
    }
    .pp-picker-wrap label {
        font-size: 11px;
        font-weight: 600;
        color: var(--text-500);
        display: block;
        margin-bottom: 4px;
    }
    .pp-picker-wrap select {
        width: 100%;
        padding: 8px 10px;
        border-radius: 8px;
        border: 1px solid var(--border);
        font-size: 12px;
        background: var(--white);
    }
    .pp-multi-note {
        font-size: 11px;
        color: var(--text-400);
        margin-bottom: 12px;
        padding: 8px 10px;
        background: rgba(245,158,11,.08);
        border-radius: 8px;
        border: 1px solid rgba(245,158,11,.2);
    }
</style>

@section('content')

@if(session('success'))
  <div class="alert alert-success">
    <i class="fa-solid fa-check-circle"></i>
    {{ session('success') }}
  </div>
@endif
@if(session('error'))
  <div class="alert alert-error">
    <i class="fa-solid fa-exclamation-circle"></i>
    {{ session('error') }}
  </div>
@endif

<div class="page-header">
    <h1>Publishing</h1>
    <p>Kelola konten yang siap tayang dan jalankan proses publish dengan cepat dan aman.</p>
</div>

<div class="pub-stat-row">
    <div class="pub-stat">
        <div class="pub-stat-header">
            <div>
                <div class="pub-stat-label">Menunggu Publish</div>
                <div class="pub-stat-meta">Status: ready_to_publish</div>
            </div>
            <div class="pub-stat-icon" style="background:rgba(245,158,11,.12);color:#b45309;">
                <i class="fa-solid fa-clock"></i>
            </div>
        </div>
        <div class="pub-stat-value">{{ $contentTasks->count() }}</div>
        <div class="pub-stat-pill pub-stat-wait">
            <span></span> Antrian konten siap tayang
        </div>
    </div>
    <div class="pub-stat">
        <div class="pub-stat-header">
            <div>
                <div class="pub-stat-label">Sudah Dipublish</div>
                <div class="pub-stat-meta">Total historis konten tayang</div>
            </div>
            <div class="pub-stat-icon" style="background:rgba(16,185,129,.12);color:#047857;">
                <i class="fa-solid fa-paper-plane"></i>
            </div>
        </div>
        <div class="pub-stat-value">{{ $publishedCount ?? 0 }}</div>
        <div class="pub-stat-pill pub-stat-done">
            <span></span> Tersimpan sebagai published
        </div>
    </div>
</div>

<div class="publishing-card">
  <div class="publishing-header">
    <div class="publishing-header-left">
      <div class="sec-title" style="font-size:13px;">
        <i class="fa-solid fa-list"></i> Daftar Konten Siap Publish
      </div>
      <div class="publishing-subtitle">
        Pilih satu atau beberapa konten untuk dipublish sekaligus. Aksi ini akan mengubah status menjadi <strong>published</strong>.
      </div>
    </div>
    <div class="bulk-actions" id="bulkActions">
      <button class="btn-bulk" onclick="publishSelected()">
        <i class="fa-solid fa-paper-plane"></i>
        Publish Selected
      </button>
    </div>
  </div>

  <div style="overflow-x: auto; width: 100%;">
  <table class="publishing-table">
    <thead>
      <tr>
        <th style="width: 40px;"><input type="checkbox" id="selectAll" onchange="toggleSelectAll()"></th>
        <th>Judul Konten</th>
        <th>Brand</th>
        <th>Versi Video</th>
        <th>Durasi Final</th>
        <th>Status</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      @forelse($contentTasks as $task)
      @php $production = $task->productions->first(); @endphp
      <tr data-id="{{ $task->id }}">
        <td>
          <input type="checkbox" class="publish-checkbox" value="{{ $task->id }}" onchange="updateBulkActions()">
        </td>
        <td>
            <span class="td-name">{{ $task->judul_konten }}</span>
            <div class="td-sub">{{ optional($task->brand)->name ?? '-' }} • ID: {{ $task->id }}</div>
        </td>
        <td><span class="td-brand">{{ optional($task->brand)->name ?? '-' }}</span></td>
        <td>{{ $production ? $production->versi_video : '-' }}</td>
        <td>{{ $production ? $production->durasi_final : '-' }}</td>
        <td>
          <span class="publish-status-pill">
            <span></span>
            Ready to Publish
          </span>
        </td>
        <td>
          <div class="pub-actions">
            <button class="btn-action" onclick="publishSingle({{ $task->id }})" title="Publish sekarang">
              <i class="fa-solid fa-paper-plane"></i>
            </button>
          </div>
        </td>
      </tr>
      @empty
      <tr>
        <td colspan="7" class="text-center py-4">
          <i class="fa-solid fa-paper-plane text-muted mb-2" style="font-size: 2rem;"></i>
          <div class="text-muted">Tidak ada konten dengan status <strong>ready_to_publish</strong>.</div>
        </td>
      </tr>
      @endforelse
    </tbody>
  </table>
  </div>
</div>

<div id="publishModal" class="modal-overlay" style="display:none;">
  <div class="modal-content modal-content--wide">
    <div class="modal-header">
      <div class="modal-title">
        <i class="fa-solid fa-mobile-screen-button"></i>
        Pratinjau &amp; Publish
      </div>
      <button type="button" class="modal-close" onclick="closePublishModal()" aria-label="Tutup"><i class="fa-solid fa-times"></i></button>
    </div>
    <div class="modal-body">
      <p style="font-size: 13px; color: var(--text-600); margin-bottom: 14px;">
        Pratinjau meniru tampilan di platform tujuan (caption &amp; hashtag dari brief). Setelah benar-benar mengunggah di aplikasi sosial, tandai di bawah agar status di Pageflowry menjadi <strong>published</strong>.
      </p>
      <div id="publishPreviewRoot"></div>
    </div>
    <div class="modal-actions">
      <button type="button" class="btn-secondary" onclick="closePublishModal()">Batal</button>
      <button type="button" class="btn-primary" onclick="confirmPublish()">
        <i class="fa-solid fa-check"></i> Tandai terpublish di Pageflowry
      </button>
    </div>
  </div>
</div>
@endsection
<script>
window.PUBLISH_PREVIEW = @json($publishPreviews);

function toggleSelectAll() {
  var selectAll = document.getElementById('selectAll');
  var checkboxes = document.querySelectorAll('.publish-checkbox');
  checkboxes.forEach(function(cb) { cb.checked = selectAll.checked; });
  updateBulkActions();
}
function updateBulkActions() {
  var checked = document.querySelectorAll('.publish-checkbox:checked');
  document.getElementById('bulkActions').style.display = checked.length ? 'flex' : 'none';
  var all = document.querySelectorAll('.publish-checkbox');
  document.getElementById('selectAll').checked = all.length === checked.length && checked.length > 0;
}
var currentPublishIds = [];
var currentPreviewTaskId = null;

function escapeHtml(s) {
  if (s == null || s === '') return '';
  var d = document.createElement('div');
  d.textContent = s;
  return d.innerHTML;
}
function escapeAttr(s) {
  return String(s || '').replace(/&/g,'&amp;').replace(/"/g,'&quot;').replace(/</g,'&lt;');
}

function previewAspect(platform, format) {
  var f = (format || '').toLowerCase();
  if (f.indexOf('shorts') !== -1 || f.indexOf('reels') !== -1 || f.indexOf('story') !== -1 || f.indexOf('vertikal') !== -1) return '916';
  if (f.indexOf('feed') !== -1 && platform === 'Instagram') return '45';
  if (platform === 'YouTube' && f.indexOf('panjang') !== -1) return '169';
  if (platform === 'YouTube') return '916';
  if (platform === 'TikTok') return '916';
  if (platform === 'Instagram') return '916';
  return '916';
}

function platformInstructions(platform, format) {
  var fmt = format || '—';
  if (platform === 'Instagram') {
    return '<ol><li>Buka <strong>Instagram</strong> → tombol <strong>+</strong> → pilih <strong>Reels</strong>, <strong>Post</strong>, atau <strong>Story</strong> sesuai format brief: <em>' + escapeHtml(fmt) + '</em>.</li><li>Unggah file video dari perangkat Anda (sama seperti pratinjau).</li><li>Tempel <strong>caption</strong> dan <strong>hashtag</strong> memakai tombol salin di samping.</li><li>Setelah tayang di Instagram, kembali ke sini dan klik <strong>Tandai terpublish di Pageflowry</strong>.</li></ol>';
  }
  if (platform === 'TikTok') {
    return '<ol><li>Buka <strong>TikTok</strong> → buat konten baru → unggah video vertikal.</li><li>Isi deskripsi dengan caption &amp; hashtag (salin dari tombol di samping).</li><li>Publikasi, lalu tandai selesai di Pageflowry.</li></ol>';
  }
  if (platform === 'YouTube') {
    return '<ol><li>Buka <strong>YouTube Studio</strong> atau aplikasi YouTube → <strong>Create</strong> → <strong>Upload video</strong> atau <strong>Shorts</strong> sesuai format: <em>' + escapeHtml(fmt) + '</em>.</li><li>Unggah file, tempel judul/deskripsi dari caption &amp; hashtag brief.</li><li>Setelah tayang, klik <strong>Tandai terpublish di Pageflowry</strong>.</li></ol>';
  }
  return '<ol><li>Buka platform yang Anda pilih di brief (<strong>' + escapeHtml(platform) + '</strong>).</li><li>Unggah aset sesuai format: <em>' + escapeHtml(fmt) + '</em>.</li><li>Salin caption &amp; hashtag ke kolom posting.</li><li>Tandai terpublish di Pageflowry setelah konten hidup.</li></ol>';
}

function buildDeviceChrome(platform, data, aspectClass) {
  var user = escapeHtml(data.brand || 'brand_anda');
  var capSnippet = escapeHtml((data.caption || '').slice(0, 140)) + ((data.caption || '').length > 140 ? '…' : '');
  var hashSnippet = escapeHtml((data.hashtags || '').slice(0, 100));
  var vid = '<div class="pp-video-ph"><i class="fa-solid fa-film"></i></div>';
  if (data.videoUrl) {
    var urlLower = data.videoUrl.toLowerCase();
    var isImage = urlLower.includes('.jpg') || urlLower.includes('.jpeg') || urlLower.includes('.png') || urlLower.includes('.gif') || urlLower.includes('.webp');
    if (isImage) {
      vid = '<img src="' + escapeAttr(data.videoUrl) + '" style="width: 100%; height: 100%; object-fit: cover;">';
    } else {
      vid = '<video src="' + escapeAttr(data.videoUrl) + '" muted loop playsinline controls></video>';
    }
  }

  if (platform === 'Instagram') {
    return '<div class="pp-frame ' + aspectClass + '">' + vid +
      '<div class="pp-chrome pp-chrome-top"><span class="pp-ig-badge">REELS</span><span><i class="fa-solid fa-camera"></i></span></div>' +
      '<div class="pp-chrome pp-chrome-bottom"><div class="pp-user"><span class="pp-live-dot"></span>' + user + '</div>' +
      '<div class="pp-cap-preview">' + (capSnippet || '<span style="opacity:.5">Caption dari brief…</span>') +
      (hashSnippet ? '<br><span style="color:#a78bfa">' + hashSnippet + '</span>' : '') + '</div></div></div>';
  }
  if (platform === 'TikTok') {
    var handle = String(data.brand || 'brand').toLowerCase().replace(/\s+/g, '_').replace(/[^a-z0-9_]/g, '') || 'brand';
    return '<div class="pp-frame ' + aspectClass + '">' + vid +
      '<div class="pp-chrome pp-chrome-top" style="justify-content:flex-end"><span>@' + escapeHtml(handle) + '</span></div>' +
      '<div class="pp-tiktok-side"><div><i class="fa-solid fa-heart"></i><span>1.2k</span></div><div><i class="fa-solid fa-comment-dots"></i><span>48</span></div><div><i class="fa-solid fa-share"></i><span>Share</span></div></div>' +
      '<div class="pp-chrome pp-chrome-bottom"><div class="pp-cap-preview">' + (capSnippet || 'Caption…') + '</div></div></div>';
  }
  if (platform === 'YouTube') {
    var shorts = (data.content_format || '').toLowerCase().indexOf('shorts') !== -1;
    return '<div class="pp-frame ' + aspectClass + '">' + vid +
      (shorts ? '<div class="pp-yt-shorts-bar">SHORTS</div>' : '<div class="pp-chrome pp-chrome-top" style="font-weight:800;font-size:10px">YouTube</div>') +
      '<div class="pp-chrome pp-chrome-bottom"><div class="pp-user">' + escapeHtml(data.title || 'Judul video') + '</div>' +
      '<div class="pp-cap-preview" style="font-size:11px;opacity:.85">' + (capSnippet || 'Deskripsi…') + '</div></div></div>';
  }
  return '<div class="pp-frame ' + aspectClass + '">' + vid +
    '<div class="pp-chrome pp-chrome-top"><span>' + escapeHtml(platform) + '</span></div>' +
    '<div class="pp-chrome pp-chrome-bottom"><div class="pp-user">' + user + '</div>' +
    '<div class="pp-cap-preview">' + (capSnippet || 'Caption…') + '</div></div></div>';
}

function renderPublishPreview() {
  var root = document.getElementById('publishPreviewRoot');
  if (!root || !currentPublishIds.length) { root.innerHTML = ''; return; }

  var firstId = String(currentPublishIds[0]);
  if (!currentPreviewTaskId || currentPublishIds.indexOf(String(currentPreviewTaskId)) === -1) {
    currentPreviewTaskId = firstId;
  }

  var data = window.PUBLISH_PREVIEW[String(currentPreviewTaskId)] || window.PUBLISH_PREVIEW[currentPreviewTaskId];
  if (!data) {
    data = { taskId: currentPreviewTaskId, title: '', brand: '', platform: 'Lainnya', content_format: '', caption: '', hashtags: '', cta: '', videoUrl: null };
  }

  var platform = data.platform || 'Lainnya';
  var aspect = previewAspect(platform, data.content_format);
  var aspectClass = 'pp-aspect-' + aspect;
  var platLabel = escapeHtml(platform) + (data.content_format ? ' · ' + escapeHtml(data.content_format) : '');

  var pickerHtml = '';
  if (currentPublishIds.length > 1) {
    pickerHtml = '<div class="pp-picker-wrap"><label for="ppTaskPicker">Pilih konten untuk pratinjau</label><select id="ppTaskPicker" onchange="onPublishPreviewTaskChange(this.value)">';
    currentPublishIds.forEach(function(id) {
      var p = window.PUBLISH_PREVIEW[String(id)];
      var label = p ? ((p.title || 'Tanpa judul').slice(0, 60)) : ('ID ' + id);
      pickerHtml += '<option value="' + escapeAttr(String(id)) + '"' + (String(id) === String(currentPreviewTaskId) ? ' selected' : '') + '>' + escapeHtml(label) + '</option>';
    });
    pickerHtml += '</select></div><div class="pp-multi-note"><i class="fa-solid fa-layer-group"></i> Anda akan menandai <strong>' + currentPublishIds.length + '</strong> konten sekaligus sebagai terpublish. Pratinjau di bawah memuat data brief per konten yang dipilih.</div>';
  }

  var caption = data.caption || '';
  var hashtags = data.hashtags || '';
  var fullPost = [caption, hashtags].filter(Boolean).join('\n\n');
  if (data.cta) { fullPost += (fullPost ? '\n\n' : '') + data.cta; }

  var copyRow = '<div class="pp-copy-row">' +
    '<button type="button" class="btn-copy" onclick="copyPublishField(\'caption\')"><i class="fa-regular fa-copy"></i> Salin caption</button>' +
    '<button type="button" class="btn-copy" onclick="copyPublishField(\'hashtags\')"><i class="fa-regular fa-copy"></i> Salin hashtag</button>' +
    '<button type="button" class="btn-copy" onclick="copyPublishField(\'all\')"><i class="fa-regular fa-copy"></i> Salin caption + hashtag + CTA</button></div>';

  root.innerHTML = pickerHtml +
    '<div class="pp-wrap">' +
    '<div class="pp-device"><div class="pp-device-label">Pratinjau di perangkat · ' + platLabel + '</div>' +
    buildDeviceChrome(platform, data, aspectClass) + '</div>' +
    '<div class="pp-side-panel">' +
    '<h4><i class="fa-solid fa-align-left"></i> Caption</h4><div class="pp-box" id="ppCaptionBox">' + (caption ? escapeHtml(caption) : '<span style="color:var(--text-400)">Belum ada caption di brief.</span>') + '</div>' +
    '<h4><i class="fa-solid fa-hashtag"></i> Hashtag</h4><div class="pp-box pp-hashtags" id="ppHashtagsBox">' + (hashtags ? escapeHtml(hashtags) : '<span style="color:var(--text-400)">Belum ada hashtag di brief.</span>') + '</div>' +
    copyRow +
    '<h4><i class="fa-solid fa-list-ol"></i> Cara menyalin ke platform</h4>' +
    '<div class="pp-steps">' + platformInstructions(platform, data.content_format) + '</div></div></div>';

  root.dataset.caption = caption;
  root.dataset.hashtags = hashtags;
  root.dataset.fullpost = fullPost;
}

function onPublishPreviewTaskChange(val) {
  currentPreviewTaskId = String(val);
  renderPublishPreview();
}

function copyPublishField(which) {
  var root = document.getElementById('publishPreviewRoot');
  if (!root) return;
  var text = '';
  if (which === 'caption') text = root.dataset.caption || '';
  else if (which === 'hashtags') text = root.dataset.hashtags || '';
  else text = root.dataset.fullpost || '';
  if (!text) { showPubToast('Tidak ada teks untuk disalin'); return; }
  if (navigator.clipboard && navigator.clipboard.writeText) {
    navigator.clipboard.writeText(text).then(function() { showPubToast('Disalin ke clipboard'); }).catch(function() { fallbackCopy(text); });
  } else { fallbackCopy(text); }
}
function fallbackCopy(text) {
  var ta = document.createElement('textarea');
  ta.value = text;
  document.body.appendChild(ta);
  ta.select();
  try { document.execCommand('copy'); showPubToast('Disalin ke clipboard'); } catch (e) { alert('Salin manual:\n\n' + text); }
  document.body.removeChild(ta);
}

function openPublishModal(ids) {
  currentPublishIds = ids.map(String);
  currentPreviewTaskId = null;
  document.getElementById('publishModal').style.display = 'flex';
  renderPublishPreview();
}

function publishSelected() {
  var ids = Array.from(document.querySelectorAll('.publish-checkbox:checked')).map(function(c) { return c.value; });
  if (!ids.length) { showPubToast('Pilih minimal 1 konten'); return; }
  openPublishModal(ids);
}
function publishSingle(id) {
  openPublishModal([String(id)]);
}
function closePublishModal() {
  document.getElementById('publishModal').style.display = 'none';
  currentPublishIds = [];
  currentPreviewTaskId = null;
}
function confirmPublish() {
  if (!currentPublishIds.length) return;
  var btn = document.querySelector('#publishModal .btn-primary');
  var orig = btn.innerHTML;
  btn.innerHTML = '<i class="fa-solid fa-circle-notch fa-spin"></i> Memproses...';
  btn.disabled = true;
  fetch('{{ route("publishing.publish") }}', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'), 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
    body: JSON.stringify({ ids: currentPublishIds })
  })
  .then(function(r) { return r.json(); })
  .then(function(data) {
    if (data.success) {
      closePublishModal();
      showPubToast(data.message || 'Konten berhasil dipublish!');
      setTimeout(function() { window.location.reload(); }, 1200);
    } else {
      showPubToast(data.message || 'Gagal');
    }
  })
  .catch(function() { showPubToast('Terjadi kesalahan'); })
  .finally(function() { btn.innerHTML = orig; btn.disabled = false; });
}
function showPubToast(msg) {
  var ex = document.querySelector('.pub-toast');
  if (ex) ex.remove();
  var t = document.createElement('div');
  t.className = 'pub-toast';
  t.innerHTML = '<i class="fa-solid fa-circle-check"></i><span>' + escapeHtml(msg) + '</span>';
  document.body.appendChild(t);
  setTimeout(function() { t.remove(); }, 3000);
}
document.getElementById('publishModal').addEventListener('click', function(e) { if (e.target === this) closePublishModal(); });
</script>
