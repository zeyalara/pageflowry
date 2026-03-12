@extends('layouts.admin')

@section('page-title', 'Publishing')

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

<div>
  <div class="sec-head">
    <div class="sec-title">
      <i class="fa-solid fa-paper-plane"></i>
      Publishing
    </div>
  </div>
  <div class="page-subtitle">
    Konten siap dipublish (status: ready_to_publish)
  </div>
</div>

<div>
  <div class="stat-row">
    <div class="stat-card sc-amb" style="--i:0">
      <div class="stat-ic"><i class="fa-solid fa-clock"></i></div>
      <div class="stat-val">{{ $contentTasks->count() }}</div>
      <div class="stat-lbl">Menunggu Publish</div>
      <div class="stat-trend trend-warn"><i class="fa-solid fa-hourglass-half"></i> Ready to publish</div>
    </div>
    <div class="stat-card sc-em" style="--i:1">
      <div class="stat-ic"><i class="fa-solid fa-paper-plane"></i></div>
      <div class="stat-val">{{ $publishedCount ?? 0 }}</div>
      <div class="stat-lbl">Sudah Dipublish</div>
      <div class="stat-trend trend-up"><i class="fa-solid fa-check"></i> Selesai</div>
    </div>
  </div>
</div>

<div class="card tbl-card">
  <div class="sec-head" style="margin-bottom:0">
    <div class="sec-title"><i class="fa-solid fa-list"></i> Publishing List</div>
    <div class="bulk-actions" id="bulkActions" style="display: none;">
      <button class="btn-bulk btn-publish" onclick="publishSelected()">
        <i class="fa-solid fa-paper-plane"></i>
        Publish Selected
      </button>
    </div>
    <a class="sec-link" href="#">Export <i class="fa-solid fa-arrow-right" style="font-size:10px"></i></a>
  </div>
  <table>
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
        <td><span class="td-name">{{ $task->judul_konten }}</span></td>
        <td><span class="td-brand">{{ optional($task->brand)->name ?? '-' }}</span></td>
        <td>{{ $production ? $production->versi_video : '-' }}</td>
        <td>{{ $production ? $production->durasi_final : '-' }}</td>
        <td>
          <span class="pill p-pub">
            <span class="pill-dot"></span>
            Ready to Publish
          </span>
        </td>
        <td>
          <div class="action-buttons">
            <button class="btn-action btn-publish" onclick="publishSingle({{ $task->id }}, '{{ addslashes($task->judul_konten) }}')" title="Publish">
              <i class="fa-solid fa-paper-plane"></i>
            </button>
          </div>
        </td>
      </tr>
      @empty
      <tr>
        <td colspan="7" class="text-center py-4">
          <i class="fa-solid fa-paper-plane text-muted mb-2" style="font-size: 2rem;"></i>
          <div class="text-muted">Tidak ada konten siap dipublish</div>
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

@push('styles')
<style>
.stat-row { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; margin-bottom: 20px; }
.stat-card { background: var(--white); border-radius: var(--r-sm); border: 1px solid var(--border); padding: 20px; box-shadow: var(--s1); }
.stat-ic { width: 40px; height: 40px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 16px; margin-bottom: 12px; }
.stat-val { font-size: 28px; font-weight: 800; color: var(--text-900); }
.stat-lbl { font-size: 13px; font-weight: 600; color: var(--text-700); }
.stat-trend { font-size: 11px; font-weight: 600; margin-top: 8px; }
.sc-amb { border-top: 3px solid var(--amber); } .sc-amb .stat-ic { background: rgba(245,158,11,.1); color: var(--amber); }
.sc-em { border-top: 3px solid var(--emerald); } .sc-em .stat-ic { background: rgba(16,185,129,.1); color: var(--emerald); }
.trend-warn { color: var(--amber); } .trend-up { color: var(--emerald); }
.bulk-actions { display: flex; align-items: center; gap: 12px; margin-left: auto; }
.btn-bulk { display: inline-flex; align-items: center; gap: 8px; padding: 10px 16px; border: none; border-radius: 8px; font-size: 13px; font-weight: 600; cursor: pointer; }
.btn-bulk.btn-publish { background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; }
.pill { display: inline-flex; align-items: center; gap: 6px; padding: 4px 10px; border-radius: 100px; font-size: 11px; font-weight: 600; }
.p-pub { background: rgba(16,185,129,.1); color: #065f46; } .p-pub .pill-dot { background: var(--emerald); }
.btn-action.btn-publish:hover { background: rgba(16,185,129,.1); color: var(--emerald); border-color: var(--emerald); }
.alert { display: flex; align-items: center; gap: 10px; padding: 12px 16px; border-radius: var(--r-sm); margin-bottom: 20px; font-size: 13px; }
.alert-success { background: rgba(16,185,129,.1); color: var(--emerald); border: 1px solid rgba(16,185,129,.2); }
.alert-error { background: rgba(239,68,68,.1); color: #ef4444; border: 1px solid rgba(239,68,68,.2); }
.text-muted { color: var(--text-400); } .text-center { text-align: center; } .py-4 { padding: 16px 0; }
.modal-overlay { position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,.5); backdrop-filter: blur(4px); z-index: 9999; display: flex; align-items: center; justify-content: center; }
.modal-content { background: var(--white); border-radius: var(--r-sm); width: 100%; max-width: 500px; box-shadow: var(--s3); overflow: hidden; }
.modal-header { padding: 20px 24px; border-bottom: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; }
.modal-title { font-size: 16px; font-weight: 700; color: var(--text-900); display: flex; align-items: center; gap: 8px; }
.modal-close { width: 32px; height: 32px; border-radius: var(--r-xs); border: none; background: var(--bg); color: var(--text-500); cursor: pointer; display: flex; align-items: center; justify-content: center; }
.modal-body { padding: 20px 24px; }
.modal-actions { display: flex; align-items: center; gap: 12px; margin-top: 16px; padding-top: 12px; border-top: 1px solid var(--border); }
.btn-secondary { padding: 8px 16px; border: 1px solid var(--border); background: var(--white); color: var(--text-700); border-radius: var(--r-sm); font-size: 12px; font-weight: 600; cursor: pointer; }
.btn-primary { padding: 8px 16px; background: var(--blue); color: white; border: 1px solid var(--blue); border-radius: var(--r-sm); font-size: 12px; font-weight: 600; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; }
.pub-toast { position: fixed; right: 24px; bottom: 24px; z-index: 999; padding: 10px 16px; border-radius: 10px; background: #022c22; color: #ecfdf5; font-size: 13px; display: flex; align-items: center; gap: 8px; }
</style>
@endpush

@push('scripts')
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
@endpush
