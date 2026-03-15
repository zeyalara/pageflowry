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
            <button class="btn-action" onclick="publishSingle({{ $task->id }}, '{{ addslashes($task->judul_konten) }}')" title="Publish sekarang">
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

<div id="publishModal" class="modal-overlay" style="display:none;">
  <div class="modal-content">
    <div class="modal-header">
      <div class="modal-title">
        <i class="fa-solid fa-paper-plane"></i>
        Publish Konten
      </div>
      <button class="modal-close" onclick="closePublishModal()"><i class="fa-solid fa-times"></i></button>
    </div>
    <div class="modal-body">
      <p style="font-size: 14px; color: var(--text-700); margin-bottom: 16px;">
        Apakah Anda yakin ingin mempublish konten ini?
      </p>
      <div id="publishContent" style="font-size: 13px; color: var(--text-600);"></div>
    </div>
    <div class="modal-actions">
      <button type="button" class="btn-secondary" onclick="closePublishModal()">Cancel</button>
      <button type="button" class="btn-primary" onclick="confirmPublish()">
        <i class="fa-solid fa-paper-plane"></i> Publish
      </button>
    </div>
  </div>
</div>
@endsection
<script>
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
function publishSelected() {
  var ids = Array.from(document.querySelectorAll('.publish-checkbox:checked')).map(function(c) { return c.value; });
  if (!ids.length) { showPubToast('Pilih minimal 1 konten'); return; }
  currentPublishIds = ids;
  document.getElementById('publishContent').innerHTML = '<p><strong>' + ids.length + '</strong> konten akan dipublish (status → published).</p>';
  document.getElementById('publishModal').style.display = 'flex';
}
function publishSingle(id, title) {
  currentPublishIds = [id];
  document.getElementById('publishContent').innerHTML = '<p>Konten: <strong>' + (title || '') + '</strong> (ID: ' + id + ')</p>';
  document.getElementById('publishModal').style.display = 'flex';
}
function closePublishModal() {
  document.getElementById('publishModal').style.display = 'none';
  currentPublishIds = [];
}
function confirmPublish() {
  if (!currentPublishIds.length) return;
  var btn = document.querySelector('#publishModal .btn-primary');
  var orig = btn.innerHTML;
  btn.innerHTML = '<i class="fa-solid fa-circle-notch fa-spin"></i> Memproses...';
  btn.disabled = true;
  fetch('{{ route("publishing.publish") }}', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'), 'Accept': 'application/json' },
    body: JSON.stringify({ ids: currentPublishIds })
  })
  .then(function(r) { return r.json(); })
  .then(function(data) {
    if (data.success) { showPubToast(data.message || 'Konten berhasil dipublish!'); setTimeout(function() { window.location.reload(); }, 1200); }
    else { showPubToast(data.message || 'Gagal'); }
  })
  .catch(function() { showPubToast('Terjadi kesalahan'); })
  .finally(function() { btn.innerHTML = orig; btn.disabled = false; closePublishModal(); });
}
function showPubToast(msg) {
  var ex = document.querySelector('.pub-toast');
        if (ex) ex.remove();
  var t = document.createElement('div');
  t.className = 'pub-toast';
  t.innerHTML = '<i class="fa-solid fa-circle-check"></i><span>' + msg + '</span>';
  document.body.appendChild(t);
        setTimeout(function() { t.remove(); }, 3000);
}
document.getElementById('publishModal').addEventListener('click', function(e) { if (e.target === this) closePublishModal(); });
</script>
