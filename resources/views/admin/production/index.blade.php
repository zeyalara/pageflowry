@extends('layouts.admin')

@section('page-title', 'Production')

@push('styles')
<style>
/* Header & actions */
.page-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 16px;
}
.page-header-title {
  font-size: 22px;
  font-weight: 800;
  letter-spacing: -.5px;
}
.page-subtitle {
  font-size: 13px;
  color: var(--text-400);
  margin-top: 2px;
}
.btn {
  display: inline-flex;
  align-items: center;
  gap: 7px;
  padding: 0 18px;
  height: 40px;
  border-radius: var(--r-sm);
  font-family: 'DM Sans', sans-serif;
  font-size: 13.5px;
  font-weight: 600;
  cursor: pointer;
  transition: var(--t);
  border: none;
  outline: none;
  white-space: nowrap;
}
.btn-primary {
  background: linear-gradient(135deg, var(--blue), var(--blue-600));
  color: #fff;
  box-shadow: 0 3px 12px rgba(88,151,254,.35);
}
.btn-primary:hover {
  transform: translateY(-2px);
  box-shadow: 0 6px 20px rgba(88,151,254,.40);
}
.btn-ghost {
  background: transparent;
  color: var(--text-500);
  border: 1px solid var(--border);
  height: 34px;
  padding: 0 14px;
  font-size: 12px;
}
.btn-ghost:hover {
  background: var(--bg);
  color: var(--text-700);
}

/* Modal */
.overlay {
  position: fixed;
  inset: 0;
  background: rgba(13,21,38,.45);
  backdrop-filter: blur(4px);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 9999;
  padding: 20px;
  opacity: 0;
  pointer-events: none;
  transition: opacity .25s ease;
}
.overlay.open {
  opacity: 1;
  pointer-events: all;
}
.modal {
  background: var(--white);
  border-radius: 20px;
  width: 100%;
  max-width: 600px;
  box-shadow: var(--s3), 0 0 0 1px rgba(88,151,254,.08);
  transform: translateY(20px) scale(.95);
  opacity: 0;
  max-height: 90vh;
  overflow-y: auto;
}
.overlay.open .modal {
  transform: translateY(0) scale(1);
  opacity: 1;
}
.modal-head {
  padding: 24px 28px 0;
  display: flex;
  align-items: flex-start;
  justify-content: space-between;
}
.modal-eyebrow {
  font-size: 11px;
  font-weight: 700;
  letter-spacing: 1px;
  text-transform: uppercase;
  color: var(--blue);
  display: flex;
  align-items: center;
  gap: 6px;
  margin-bottom: 4px;
}
.modal-title {
  font-size: 20px;
  font-weight: 800;
  color: var(--text-900);
  letter-spacing: -.4px;
}
.modal-subtitle {
  font-size: 13px;
  color: var(--text-400);
  margin-top: 3px;
}
.modal-close {
  width: 36px;
  height: 36px;
  border-radius: 10px;
  border: none;
  background: var(--bg);
  cursor: pointer;
  transition: var(--t);
  display: flex;
  align-items: center;
  justify-content: center;
  color: var(--text-400);
  font-size: 15px;
  flex-shrink: 0;
  margin-top: 2px;
}
.modal-close:hover {
  background: rgba(244,63,94,.1);
  color: var(--rose);
}
.modal-body {
  padding: 24px 28px;
}
.modal-divider {
  height: 1px;
  background: var(--border-light);
  margin: 4px 0 20px;
}
.form-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 16px;
}
.form-group {
  display: flex;
  flex-direction: column;
}
.form-group.full {
  grid-column: 1 / -1;
}
.form-label {
  font-size: 12px;
  font-weight: 700;
  color: var(--text-700);
  margin-bottom: 6px;
  display: flex;
  align-items: center;
  gap: 4px;
}
.form-label .required {
  color: var(--rose);
}
.form-input,
.form-select,
.form-textarea {
  padding: 10px 14px;
  border: 1px solid var(--border);
  border-radius: var(--r-sm);
  font-size: 13px;
  font-family: inherit;
  background: var(--white);
  transition: var(--t);
}
.form-input:focus,
.form-select:focus,
.form-textarea:focus {
  outline: none;
  border-color: var(--blue);
  box-shadow: 0 0 0 3px rgba(88,151,254,.1);
}
.form-textarea {
  resize: vertical;
  min-height: 80px;
}
.file-input-wrapper {
  position: relative;
  border: 2px dashed var(--border);
  border-radius: var(--r-sm);
  padding: 20px;
  text-align: center;
  transition: var(--t);
  cursor: pointer;
  background: var(--bg);
}
.file-input-wrapper:hover {
  border-color: var(--blue);
  background: var(--blue-50);
}
.file-input {
  display: none;
}
.file-input-text {
  font-size: 13px;
  color: var(--text-500);
}
.file-input-hint {
  font-size: 11px;
  color: var(--text-400);
  margin-top: 4px;
}
.modal-footer {
  padding: 0 28px 24px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 10px;
}
.mf-left {
  font-size: 11px;
  color: var(--text-400);
}
.mf-right {
  display: flex;
  gap: 8px;
}

/* Status Badge Colors */
.p-in-production {
  background: rgba(251, 146, 60, 0.1);
  color: #fb923c;
  border: 1px solid rgba(251, 146, 60, 0.2);
}
.p-in-production .pill-dot {
  background: #fb923c;
}
.p-under-review {
  background: rgba(250, 204, 21, 0.1);
  color: #facc15;
  border: 1px solid rgba(250, 204, 21, 0.2);
}
.p-under-review .pill-dot {
  background: #facc15;
}
.p-ready-to-publish {
  background: rgba(34, 197, 94, 0.1);
  color: #22c55e;
  border: 1px solid rgba(34, 197, 94, 0.2);
}
.p-ready-to-publish .pill-dot {
  background: #22c55e;
}
.p-published {
  background: rgba(168, 85, 247, 0.1);
  color: #a855f7;
  border: 1px solid rgba(168, 85, 247, 0.2);
}
.p-published .pill-dot {
  background: #a855f7;
}
.p-need-revision {
  background: rgba(239, 68, 68, 0.1);
  color: #ef4444;
  border: 1px solid rgba(239, 68, 68, 0.2);
}
.p-need-revision .pill-dot {
  background: #ef4444;
}

/* Action Buttons */
.btn-action {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  width: 32px;
  height: 32px;
  border-radius: 6px;
  border: 1px solid var(--border);
  background: var(--white);
  color: var(--text-500);
  cursor: pointer;
  transition: var(--t);
  font-size: 12px;
}
.btn-action:hover {
  background: var(--blue);
  color: white;
  border-color: var(--blue);
  transform: translateY(-1px);
}
</style>
@endpush

@section('content')

<div class="page-header">
  <div>
    <div class="page-header-title">Production</div>
    <div class="page-subtitle">Kelola produksi konten dan upload video final</div>
  </div>
  <button class="btn btn-primary" onclick="openUploadModal()">
    <i class="fa-solid fa-plus"></i> Upload Video Produksi
  </button>
</div>

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

<div class="stat-row">
  <div class="stat-card sc-blue" style="--i:0">
    <div class="stat-ic"><i class="fa-solid fa-list"></i></div>
    <div class="stat-val">{{ $stats['total_tasks'] ?? 0 }}</div>
    <div class="stat-lbl">Total Task</div>
  </div>
  <div class="stat-card sc-vio" style="--i:1">
    <div class="stat-ic"><i class="fa-solid fa-cog"></i></div>
    <div class="stat-val">{{ $stats['in_production'] ?? 0 }}</div>
    <div class="stat-lbl">Dalam Produksi</div>
  </div>
  <div class="stat-card sc-amb" style="--i:2">
    <div class="stat-ic"><i class="fa-solid fa-eye"></i></div>
    <div class="stat-val">{{ $stats['under_review'] ?? 0 }}</div>
    <div class="stat-lbl">Dalam Review</div>
  </div>
  <div class="stat-card sc-em" style="--i:3">
    <div class="stat-ic"><i class="fa-solid fa-paper-plane"></i></div>
    <div class="stat-val">{{ $stats['ready_to_publish'] ?? 0 }}</div>
    <div class="stat-lbl">Siap Publish</div>
  </div>
</div>

<div class="card tbl-card">
  <div class="sec-head" style="margin-bottom:0">
    <div class="sec-title">
      <i class="fa-solid fa-list"></i>
      Daftar Tugas Konten
    </div>
    <button class="btn btn-primary" onclick="openUploadModal()">
      <i class="fa-solid fa-plus"></i> Upload Video Produksi
    </button>
  </div>
  <table>
    <thead>
      <tr>
        <th style="width: 5%;">ID</th>
        <th style="width: 25%;">Judul Konten</th>
        <th style="width: 15%;">Brand</th>
        <th style="width: 10%;">Versi Video</th>
        <th style="width: 10%;">Durasi Final</th>
        <th style="width: 20%;">Catatan Produksi</th>
        <th style="width: 8%;">Status</th>
        <th style="width: 7%;">Aksi</th>
      </tr>
    </thead>
    <tbody>
      @forelse($contentTasks as $index => $task)
        @php 
          $production = $task->productions->first();
          $statusMap = [
            'task' => ['label' => 'Task', 'class' => 'p-task'],
            'in_production' => ['label' => 'In Production', 'class' => 'p-in-production'],
            'production' => ['label' => 'Production', 'class' => 'p-production'],
            'under_review' => ['label' => 'Under Review', 'class' => 'p-under-review'],
            'need_revision' => ['label' => 'Need Revision', 'class' => 'p-need-revision'],
            'ready_to_publish' => ['label' => 'Ready to Publish', 'class' => 'p-ready-to-publish'],
            'published' => ['label' => 'Published', 'class' => 'p-published'],
            'completed' => ['label' => 'Completed', 'class' => 'p-completed'],
          ];
          $s = $statusMap[$task->status] ?? ['label' => ucfirst(str_replace('_', ' ', $task->status)), 'class' => 'p-prod'];
          $rowNumber = $index + 1; // Nomor urut dari 1
        @endphp
        <tr>
          <td style="white-space: nowrap; vertical-align: middle;">{{ $rowNumber }}</td>
          <td style="white-space: nowrap; vertical-align: middle;">
            <span class="td-name">{{ $task->judul_konten }}</span>
          </td>
          <td style="white-space: nowrap; vertical-align: middle;">
            <span class="td-brand">{{ optional($task->brand)->name ?? '-' }}</span>
          </td>
          <td style="white-space: nowrap; vertical-align: middle;">{{ $production ? $production->versi_video : '-' }}</td>
          <td style="white-space: nowrap; vertical-align: middle;">{{ $production ? $production->durasi_final : '-' }}</td>
          <td style="white-space: nowrap; vertical-align: middle;">
            @if($production && $production->catatan_produksi)
              <span class="td-notes" title="{{ $production->catatan_produksi }}">
                {{ Str::limit($production->catatan_produksi, 40) }}
              </span>
            @else
              <span class="text-muted">-</span>
            @endif
          </td>
          <td style="white-space: nowrap; vertical-align: middle;">
            <span class="pill {{ $s['class'] }}">
              <span class="pill-dot"></span>
              {{ $s['label'] }}
            </span>
          </td>
          <td style="white-space: nowrap; vertical-align: middle;">
            <div class="action-buttons" style="display:flex;gap:6px;flex-wrap:nowrap;">
              @if($production && $production->file_video)
                <button class="btn-action" onclick="previewVideo({{ $production->id }}, '{{ addslashes($task->judul_konten) }}', '{{ $production->file_video }}')" title="Preview Video">
                  <i class="fa-solid fa-eye"></i>
                </button>
                <a href="{{ route('production.download', $production->id) }}" class="btn-action" title="Download Video">
                  <i class="fa-solid fa-download"></i>
                </a>
              @else
                <button class="btn-action" onclick="showUploadForTask({{ $task->id }}, '{{ addslashes($task->judul_konten) }}')" title="Upload Video">
                  <i class="fa-solid fa-upload"></i>
                </button>
              @endif
            </div>
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="8" style="text-align:center;padding:32px 0;color:var(--text-400);">
            <i class="fa-solid fa-list" style="font-size:32px;margin-bottom:10px;opacity:.3;"></i>
            <div style="font-size:15px;font-weight:600;">Belum ada tugas konten</div>
            <div style="font-size:12.5px;">Buat tugas konten pertama untuk memulai</div>
          </td>
        </tr>
      @endforelse
    </tbody>
  </table>
</div>

<!-- Upload Modal -->
<div class="overlay" id="uploadOverlay" onclick="closeOnOverlay(event, 'uploadOverlay')">
  <div class="modal" onclick="event.stopPropagation()">
    <div class="modal-head">
      <div class="modal-title-wrap">
        <div class="modal-eyebrow"><i class="fa-solid fa-film"></i> Production</div>
        <div class="modal-title">Upload Video Produksi</div>
        <div class="modal-subtitle">Pilih task dan upload video produksi</div>
      </div>
      <button class="modal-close" type="button" onclick="closeModal('uploadOverlay')">
        <i class="fa-solid fa-xmark"></i>
      </button>
    </div>
    <div class="modal-body">
      <div class="modal-divider"></div>
      <form id="uploadForm" onsubmit="submitUpload(event)" novalidate>
        <div class="form-grid">
          <div class="form-group full">
            <label class="form-label">
              Pilih Content Task <span class="required">*</span>
            </label>
            <select name="content_task_id" class="form-select" required>
              <option value="">Pilih Content Task</option>
              {{-- Debug: Check if tasks variable exists and has data --}}
              @if(isset($tasks) && $tasks->count() > 0)
                {{-- Debug: Show task count --}}
                {{-- <option value="" disabled>{{ $tasks->count() }} tasks found</option> --}}
                @foreach ($tasks as $task)
                  <option value="{{ $task->id }}">
                    {{ $task->judul_konten }}
                  </option>
                @endforeach
              @else
                <option value="" disabled>Tidak ada task dengan status 'in_production'</option>
              @endif
            </select>
          </div>

          <div class="form-group">
            <label class="form-label">
              Versi Video <span class="required">*</span>
            </label>
            <input type="text" name="version" class="form-input" placeholder="v1.0" required>
          </div>

          <div class="form-group">
            <label class="form-label">
              Durasi Final <span class="required">*</span>
            </label>
            <input type="text" name="final_duration" class="form-input" placeholder="00:05:30" required>
          </div>

          <div class="form-group full">
            <label class="form-label">
              Upload Video <span class="required">*</span>
            </label>
            <div class="file-input-wrapper" onclick="document.getElementById('video_file').click()">
              <input type="file" id="video_file" name="video_file" class="file-input" accept="video/*" required onchange="updateFileName(this)">
              <div class="file-input-text" id="file-name">
                <i class="fa-solid fa-cloud-arrow-up"></i> Klik untuk upload video
              </div>
              <div class="file-input-hint">Format: MP4, MOV, AVI (Max: 100MB)</div>
            </div>
          </div>

          <div class="form-group full">
            <label class="form-label">Catatan Produksi</label>
            <textarea name="production_notes" class="form-textarea" placeholder="Tambahkan catatan untuk produksi ini..."></textarea>
          </div>
        </div>
      </form>
    </div>
    <div class="modal-footer">
      <div class="mf-left">
        <i class="fa-solid fa-asterisk" style="font-size:8px"></i> Wajib diisi
      </div>
      <div class="mf-right">
        <button class="btn-ghost" type="button" onclick="closeModal('uploadOverlay')">Batal</button>
        <button class="btn btn-primary" type="button" onclick="submitUpload(event)">
          <i class="fa-solid fa-upload"></i> Upload Video
        </button>
      </div>
    </div>
  </div>
</div>

<!-- Preview Video Modal -->
<div class="overlay" id="previewOverlay" onclick="closeOnOverlay(event, 'previewOverlay')">
  <div class="modal" onclick="event.stopPropagation()" style="max-width: 800px;">
    <div class="modal-header">
      <div class="modal-title">Preview Video Produksi</div>
      <button class="modal-close" onclick="closeModal('previewOverlay')">
        <i class="fa-solid fa-times"></i>
      </button>
    </div>
    <div class="modal-body">
      <div class="modal-divider"></div>
      <div id="previewContent">
        <!-- Video preview content will be inserted here -->
      </div>
    </div>
    <div class="modal-footer">
      <button class="btn btn-ghost" onclick="closeModal('previewOverlay')">Tutup</button>
      <button id="previewDownloadBtn" class="btn btn-primary" style="display: none;">
        <i class="fa-solid fa-download"></i> Download Video
      </button>
    </div>
  </div>
</div>

@endsection

@push('scripts')
<script>
function openUploadModal() {
  document.getElementById('uploadOverlay').classList.add('open');
}

function showUploadForTask(taskId, taskTitle) {
  // Set the selected task in the dropdown
  const taskSelect = document.querySelector('select[name="content_task_id"]');
  if (taskSelect) {
    taskSelect.value = taskId;
  }
  
  // Update modal title
  const modalTitle = document.querySelector('.modal-title');
  if (modalTitle) {
    modalTitle.textContent = `Upload Video Produksi - ${taskTitle}`;
  }
  
  // Open modal
  document.getElementById('uploadOverlay').classList.add('open');
}

function closeModal(modalId) {
  document.getElementById(modalId).classList.remove('open');
  resetForm();
}

function closeOnOverlay(event, modalId) {
  if (event.target === event.currentTarget) {
    closeModal(modalId);
  }
}

function updateFileName(input) {
  const fileName = input.files[0]?.name || '<i class="fa-solid fa-cloud-arrow-up"></i> Klik untuk upload video';
  document.getElementById('file-name').innerHTML = fileName;
}

function resetForm() {
  const form = document.getElementById('uploadForm');
  if (form) {
    form.reset();
  }
  const fileNameEl = document.getElementById('file-name');
  if (fileNameEl) {
    fileNameEl.innerHTML = '<i class="fa-solid fa-cloud-arrow-up"></i> Klik untuk upload video';
  }
}

function submitUpload(event) {
  event.preventDefault();

  const form = document.getElementById('uploadForm');
  if (!form) return;

  const formData = new FormData(form);

  const contentTaskId = formData.get('content_task_id');
  const version = formData.get('version');
  const finalDuration = formData.get('final_duration');
  const videoFile = document.getElementById('video_file')?.files[0];

  if (!contentTaskId || !version || !finalDuration || !videoFile) {
    alert('Mohon lengkapi semua field yang wajib diisi');
    return;
  }

  const submitBtn = event.target;
  const originalText = submitBtn.innerHTML;
  submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Mengupload...';
  submitBtn.disabled = true;

  formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));

  fetch('{{ route("production.store") }}', {
    method: 'POST',
    headers: {
      'X-Requested-With': 'XMLHttpRequest',
      'Accept': 'application/json'
    },
    body: formData
  })
    .then(response => {
      console.log('Response status:', response.status);
      console.log('Response headers:', response.headers);
      
      // Check if response is actually JSON
      const contentType = response.headers.get('content-type');
      if (!contentType || !contentType.includes('application/json')) {
        // If not JSON, it's probably an HTML error page
        return response.text().then(html => {
          console.error('Server returned HTML instead of JSON:', html.substring(0, 200));
          throw new Error('Server returned HTML error page instead of JSON. Check server logs for details.');
        });
      }
      
      if (!response.ok) {
        throw new Error(`HTTP error! status: ${response.status}`);
      }
      return response.json();
    })
    .then(data => {
      console.log('Response data:', data);
      if (data.success) {
        closeModal('uploadOverlay');
        window.location.reload();
      } else {
        alert('Upload gagal: ' + (data.message || 'Terjadi kesalahan'));
      }
    })
    .catch(error => {
      console.error('Upload error:', error);
      alert('Terjadi kesalahan saat upload. Silakan coba lagi. Error: ' + error.message);
    })
    .finally(() => {
      submitBtn.innerHTML = originalText;
      submitBtn.disabled = false;
    });
}

function previewVideo(productionId, taskTitle, videoFile) {
  const previewContent = document.getElementById('previewContent');
  const downloadBtn = document.getElementById('previewDownloadBtn');
  
  // Update modal title
  const modalTitle = document.querySelector('#previewOverlay .modal-title');
  if (modalTitle) {
    modalTitle.textContent = `Preview Video - ${taskTitle}`;
  }
  
  // Create video element
  const videoPath = `/storage/${videoFile}`;
  previewContent.innerHTML = `
    <div style="text-align: center;">
      <video controls style="max-width: 100%; height: auto; border-radius: 8px;" preload="metadata">
        <source src="${videoPath}" type="video/mp4">
        <source src="${videoPath}" type="video/mov">
        <source src="${videoPath}" type="video/avi">
        Browser Anda tidak mendukung video player.
      </video>
      <div style="margin-top: 16px; color: var(--text-400); font-size: 14px;">
        <i class="fa-solid fa-info-circle"></i> Video: ${taskTitle}
      </div>
    </div>
  `;
  
  // Setup download button
  downloadBtn.style.display = 'inline-flex';
  downloadBtn.onclick = function() {
    window.location.href = `/production/${productionId}/download`;
  };
  
  // Open modal
  document.getElementById('previewOverlay').classList.add('open');
}

</script>
@endpush
