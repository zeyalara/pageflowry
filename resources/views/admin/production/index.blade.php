@extends('layouts.admin')

@section('page-title','Production')

@section('content')

<!-- Session Messages -->
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

<!-- ── 1. HEADER SECTION ── -->
<div>
  <div class="sec-head">
    <div class="sec-title">
      <i class="fa-solid fa-film"></i>
      Production
    </div>
    <button class="btn-primary" onclick="openUploadModal()">
      <i class="fa-solid fa-upload"></i>
      Upload Production
    </button>
  </div>
  <div class="page-subtitle">
    Manajemen hasil produksi konten
  </div>
</div>

<!-- ── 2. STATISTICS CARDS ── -->
<div>
  <div class="stat-row">
    <div class="stat-card sc-blue" style="--i:0">
      <div class="stat-ic"><i class="fa-solid fa-video"></i></div>
      <div class="stat-val" data-target="{{ $stats['total_production'] }}">{{ $stats['total_production'] }}</div>
      <div class="stat-lbl">Total Video Production</div>
      <div class="stat-trend trend-up"><i class="fa-solid fa-arrow-trend-up"></i> +2 bulan ini</div>
    </div>
    <div class="stat-card sc-vio" style="--i:1">
      <div class="stat-ic"><i class="fa-solid fa-magnifying-glass"></i></div>
      <div class="stat-val" data-target="{{ $stats['under_review'] }}">{{ $stats['under_review'] }}</div>
      <div class="stat-lbl">Under Review</div>
      <div class="stat-trend trend-warn"><i class="fa-solid fa-hourglass-half"></i> Menunggu</div>
    </div>
    <div class="stat-card sc-red" style="--i:2">
      <div class="stat-ic"><i class="fa-solid fa-triangle-exclamation"></i></div>
      <div class="stat-val" data-target="{{ $stats['need_revision'] }}">{{ $stats['need_revision'] }}</div>
      <div class="stat-lbl">Need Revision</div>
      <div class="stat-trend trend-down"><i class="fa-solid fa-triangle-exclamation"></i> Perlu aksi</div>
    </div>
  </div>
</div>

<!-- ── 3. PRODUCTION TABLE ── -->
<div class="card tbl-card">
  <div class="sec-head" style="margin-bottom:0">
    <div class="sec-title"><i class="fa-solid fa-list"></i> Production List</div>
    <div class="bulk-actions" id="bulkActions" style="display: none;">
      <button class="btn-bulk btn-revision" onclick="bulkAction('revision')">
        <i class="fa-solid fa-clock-rotate-left"></i>
        Request Revision
      </button>
      <button class="btn-bulk btn-approve" onclick="bulkAction('approve')">
        <i class="fa-solid fa-check-circle"></i>
        Approve Selected
      </button>
    </div>
    <a class="sec-link" href="#">Export <i class="fa-solid fa-arrow-right" style="font-size:10px"></i></a>
  </div>
  <table>
    <thead>
      <tr>
        <th style="width: 40px;">
          <input type="checkbox" id="selectAll" onchange="toggleSelectAll()">
        </th>
        <th>Judul Konten</th>
        <th>Brand</th>
        <th>Versi Video</th>
        <th>Durasi Final</th>
        <th>Catatan Produksi</th>
        <th>Video</th>
        <th>Status</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      @forelse($productions as $production)
      <tr data-id="{{ $production['id'] }}">
        <td>
          <input type="checkbox" class="row-checkbox" value="{{ $production['id'] }}" onchange="updateBulkActions()">
        </td>
        <td>
          <span class="td-name">{{ $production['judul_konten'] }}</span>
        </td>
        <td>
          <span class="td-brand">{{ $production['nama_brand'] }}</span>
        </td>
        <td>{{ $production['versi_video'] }}</td>
        <td>{{ $production['durasi_final'] }}</td>
        <td>{{ $production['catatan_produksi'] ?? '-' }}</td>
        <td>
          @if($production['file_video'])
            <button class="btn-preview" onclick="previewVideo('{{ $production['id'] }}', '{{ $production['judul_konten'] }}', '{{ $production['versi_video'] }}', '{{ $production['durasi_final'] }}', '{{ $production['file_video'] }}')">
              <i class="fa-solid fa-play"></i>
            </button>
          @else
            <span class="text-muted">-</span>
          @endif
        </td>
        <td>
          <span class="pill {{ $statusClasses[$production['status']] ?? 'p-prod' }}">
            <span class="pill-dot"></span>
            {{ $statusLabels[$production['status']] ?? $production['status'] }}
          </span>
        </td>
        <td>
          <div class="action-buttons">
            <button class="btn-action btn-preview-sm" onclick="previewVideo('{{ $production['id'] }}', '{{ $production['judul_konten'] }}', '{{ $production['versi_video'] }}', '{{ $production['durasi_final'] }}', '{{ $production['file_video'] }}')" title="Preview Video">
              <i class="fa-solid fa-eye"></i>
            </button>
            @if($production['file_video'])
              <a href="{{ route('production.download', $production['id']) }}" class="btn-action btn-download" title="Download Video">
                <i class="fa-solid fa-download"></i>
              </a>
            @endif
            <a href="{{ route('revision.index', $production['content_task_id']) }}" class="btn-action btn-review" title="Review Konten">
              <i class="fa-solid fa-comment"></i>
            </a>
          </div>
        </td>
      </tr>
      @empty
      <tr>
        <td colspan="8" class="text-center py-4">
          <i class="fa-solid fa-film text-muted mb-2" style="font-size: 2rem;"></i>
          <div class="text-muted">Belum ada data production</div>
        </td>
      </tr>
      @endforelse
    </tbody>
  </table>
</div>

<!-- ── 4. VIDEO PREVIEW MODAL ── -->
<div id="videoModal" class="modal-overlay" style="display: none;">
  <div class="modal-content">
    <div class="modal-header">
      <div class="modal-title">
        <i class="fa-solid fa-video"></i>
        Preview Video
      </div>
      <button class="modal-close" onclick="closeVideoModal()">
        <i class="fa-solid fa-times"></i>
      </button>
    </div>
    <div class="modal-body">
      <div class="video-info">
        <div class="video-meta">
          <div class="meta-item">
            <label>Judul Konten</label>
            <span id="modalTitle">-</span>
          </div>
          <div class="meta-item">
            <label>Versi Video</label>
            <span id="modalVersion">-</span>
          </div>
          <div class="meta-item">
            <label>Durasi Final</label>
            <span id="modalDuration">-</span>
          </div>
        </div>
      </div>
      <div class="video-player">
        <video id="videoPlayer" controls class="w-full rounded-lg">
          <source src="" type="video/mp4">
          Browser Anda tidak mendukung video player.
        </video>
      </div>
    </div>
  </div>
</div>

<!-- ════════════ MODAL: UPLOAD PRODUCTION ════════════ -->
<style>
/* Modal Styles - Modern SaaS Dashboard */
.overlay {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(13,21,38,.45);
  backdrop-filter: blur(4px);
  z-index: 9999;
  display: flex;
  align-items: center;
  justify-content: center;
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
  transform: translateY(24px) scale(.97);
  transition: transform .3s cubic-bezier(.34,1.56,.64,1), opacity .25s ease;
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

.modal-title-wrap {}

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

.form-grid .full {
  grid-column: 1 / -1;
}

.form-group {
  display: flex;
  flex-direction: column;
  gap: 6px;
}

.form-label {
  font-size: 12.5px;
  font-weight: 700;
  color: var(--text-700);
  display: flex;
  align-items: center;
  gap: 5px;
}

.form-label .req {
  color: var(--rose);
  font-size: 13px;
}

.form-label .hint {
  font-size: 11px;
  font-weight: 400;
  color: var(--text-300);
  margin-left: 2px;
}

.input-wrap {
  position: relative;
}

.input-wrap i {
  position: absolute;
  left: 13px;
  top: 50%;
  transform: translateY(-50%);
  color: var(--text-400);
  font-size: 13.5px;
  pointer-events: none;
}

.form-input, .form-textarea, .form-select {
  width: 100%;
  font-family: 'DM Sans', sans-serif;
  font-size: 13.5px;
  color: var(--text-900);
  border: 1.5px solid var(--border);
  border-radius: var(--r-sm);
  background: var(--white);
  transition: var(--t);
  outline: none;
}

.form-input, .form-select {
  height: 42px;
  padding: 0 14px;
}

.form-textarea {
  padding: 12px 14px;
  resize: vertical;
  min-height: 88px;
  line-height: 1.55;
}

.input-wrap .form-input {
  padding-left: 38px;
}

.form-input:focus, .form-textarea:focus, .form-select:focus {
  border-color: var(--blue);
  box-shadow: 0 0 0 3.5px rgba(88,151,254,.12);
  background: var(--white);
}

.form-input.error, .form-textarea.error, .form-select.error {
  border-color: var(--rose);
  box-shadow: 0 0 0 3px rgba(244,63,94,.1);
}

.form-error {
  font-size: 11.5px;
  color: var(--rose);
  font-weight: 500;
  display: none;
}

.form-error.show {
  display: block;
}

.file-upload-area {
  border: 2px dashed var(--border);
  border-radius: var(--r);
  padding: 32px;
  text-align: center;
  background: var(--bg);
  transition: var(--t);
  cursor: pointer;
  position: relative;
}

.file-upload-area:hover {
  border-color: var(--blue-200);
  background: var(--blue-50);
}

.file-upload-content {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 12px;
}

.file-upload-content i {
  font-size: 32px;
  color: var(--blue);
  margin-bottom: 8px;
}

.file-upload-content span {
  font-size: 14px;
  font-weight: 600;
  color: var(--text-700);
}

.file-upload-hint {
  font-size: 12px;
  color: var(--text-400);
  margin: 0;
}

.file-upload-result {
  display: flex;
  align-items: center;
  gap: 12px;
  padding: 16px 20px;
  background: rgba(16,185,129,.1);
  border-radius: var(--r);
  border: 1px solid rgba(16,185,129,.2);
}

.file-upload-result i {
  color: var(--emerald);
  font-size: 20px;
}

.file-upload-result span {
  flex: 1;
  font-size: 13px;
  font-weight: 500;
  color: var(--text-700);
}

.file-remove {
  width: 24px;
  height: 24px;
  border-radius: 6px;
  border: none;
  background: rgba(244,63,94,.1);
  color: var(--rose);
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  transition: all 0.2s ease;
  font-size: 12px;
}

.file-remove:hover {
  background: rgba(244,63,94,.2);
  transform: scale(1.1);
}

.modal-footer {
  padding: 0 28px 24px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 10px;
}

.mf-left {
  font-size: 12px;
  color: var(--text-300);
}

.mf-right {
  display: flex;
  gap: 9px;
}

.btn {
  padding: 10px 20px;
  border-radius: var(--r-sm);
  font-size: 13.5px;
  font-weight: 600;
  border: none;
  cursor: pointer;
  transition: var(--t);
  display: inline-flex;
  align-items: center;
  gap: 8px;
  font-family: 'DM Sans', sans-serif;
}

.btn-ghost {
  background: var(--white);
  color: var(--text-600);
  border: 1.5px solid var(--border);
}

.btn-ghost:hover {
  background: var(--bg);
  border-color: var(--border-light);
}

.btn-primary {
  background: var(--blue);
  color: white;
  border: 1.5px solid var(--blue);
}

.btn-primary:hover {
  background: var(--blue-dark);
  border-color: var(--blue-dark);
}
</style>
<div class="overlay" id="uploadModal" onclick="closeOnOverlay(event,'uploadModal')">
  <div class="modal" id="formModal" onclick="event.stopPropagation()">
    <div class="modal-head">
      <div class="modal-title-wrap">
        <div class="modal-eyebrow"><i class="fa-solid fa-upload"></i> <span id="modalEyebrow">Production Management</span></div>
        <div class="modal-title" id="modalTitle">Upload Production</div>
        <div class="modal-subtitle" id="modalSubtitle">Upload video production untuk content task</div>
      </div>
      <button class="modal-close" onclick="closeModal('uploadModal')"><i class="fa-solid fa-xmark"></i></button>
    </div>
    <div class="modal-body">
      <div class="modal-divider"></div>
      <form id="uploadForm" onsubmit="submitUploadForm(event)" novalidate>
        <input type="hidden" id="editId" value=""/>
        <div class="form-grid">
          <!-- Content Task -->
          <div class="form-group full">
            <label class="form-label">Judul Konten <span class="req">*</span></label>
            <div class="input-wrap">
              <i class="fa-solid fa-video"></i>
              <input class="form-input" id="fJudul" type="text" placeholder="Judul konten..." readonly/>
            </div>
            <span class="form-error" id="errJudul">Judul konten wajib diisi.</span>
          </div>
          
          <!-- Brand -->
          <div class="form-group">
            <label class="form-label">Brand</label>
            <div class="input-wrap">
              <i class="fa-solid fa-tag"></i>
              <input class="form-input" id="fBrand" type="text" placeholder="Nama brand..." readonly/>
            </div>
          </div>
          
          <!-- Version -->
          <div class="form-group">
            <label class="form-label">Versi Video <span class="req">*</span></label>
            <div class="input-wrap">
              <i class="fa-solid fa-code-branch"></i>
              <input class="form-input" id="fVersion" type="text" placeholder="Contoh: v1.0, v2.1"/>
            </div>
            <span class="form-error" id="errVersion">Versi video wajib diisi.</span>
          </div>
          
          <!-- Duration -->
          <div class="form-group">
            <label class="form-label">Durasi Final <span class="req">*</span></label>
            <div class="input-wrap">
              <i class="fa-solid fa-clock"></i>
              <input class="form-input" id="fDuration" type="text" placeholder="Contoh: 3:45"/>
            </div>
            <span class="form-error" id="errDuration">Durasi final wajib diisi.</span>
          </div>
          
          <!-- Production Notes -->
          <div class="form-group full">
            <label class="form-label">Catatan Produksi <span class="hint">— Opsional, tambahkan catatan jika diperlukan</span></label>
            <textarea class="form-textarea" id="fNotes" placeholder="Catatan produksi..."></textarea>
          </div>
          
          <!-- File Upload -->
          <div class="form-group full">
            <label class="form-label">File Video <span class="req">*</span></label>
            <div class="file-upload-area" id="fileUploadArea" onclick="document.getElementById('videoFile').click()">
              <div class="file-upload-content" id="fileUploadContent">
                <i class="fa-solid fa-cloud-upload-alt"></i>
                <span>Click to upload atau drag & drop file video di sini</span>
                <p class="file-upload-hint">MP4, MOV, AVI (Max. 100MB)</p>
              </div>
              <input type="file" id="videoFile" accept="video/*" style="display: none;" onchange="handleFileSelect(event)"/>
              <div class="file-upload-result" id="fileUploadResult" style="display: none;">
                <i class="fa-solid fa-check-circle"></i>
                <span id="fileName"></span>
                <button type="button" class="file-remove" onclick="removeFile()">
                  <i class="fa-solid fa-times"></i>
                </button>
              </div>
            </div>
            <span class="form-error" id="errFile">File video wajib diupload.</span>
          </div>
        </div>
      </form>
    </div>
    <div class="modal-footer">
      <div class="mf-left"><i class="fa-solid fa-asterisk" style="font-size:8px"></i> Wajib diisi</div>
      <div class="mf-right">
        <button class="btn btn-ghost" onclick="closeModal('uploadModal')">Batal</button>
        <button class="btn btn-primary" id="submitBtn" onclick="submitUploadForm(event)">
          <i class="fa-solid fa-upload"></i> Upload Production
        </button>
      </div>
    </div>
  </div>
</div>

<script>
// Simple modal functions - inline to avoid conflicts
function openUploadModal() {
  console.log('Opening modal...');
  const modal = document.getElementById('uploadModal');
  if (modal) {
    modal.classList.add('open');
    document.body.style.overflow = 'hidden';
  } else {
    console.error('Modal not found!');
  }
}

function closeUploadModal() {
  console.log('Closing modal...');
  const modal = document.getElementById('uploadModal');
  if (modal) {
    modal.style.display = 'none';
    document.body.style.overflow = 'auto';
  }
}

// Close modal when clicking outside
document.addEventListener('click', function(event) {
  const modal = document.getElementById('uploadModal');
  if (event.target === modal) {
    closeUploadModal();
  }
});

// File upload functionality
function setupFileUpload() {
  const fileInput = document.getElementById('video_file');
  const fileResult = document.getElementById('fileResult');
  const fileName = document.getElementById('fileName');
  const fileLabel = document.querySelector('.file-upload-label');
  
  if (fileInput) {
    fileInput.addEventListener('change', function(e) {
      const file = e.target.files[0];
      if (file) {
        fileName.textContent = file.name;
        fileResult.style.display = 'flex';
        fileLabel.style.display = 'none';
      }
    });
  }
}

function removeFile() {
  const fileInput = document.getElementById('video_file');
  const fileResult = document.getElementById('fileResult');
  const fileLabel = document.querySelector('.file-upload-label');
  
  fileInput.value = '';
  fileResult.style.display = 'none';
  fileLabel.style.display = 'block';
}

// Initialize when page loads
document.addEventListener('DOMContentLoaded', function() {
  console.log('Page loaded - setting up...');
  setupFileUpload();
  
  // Auto test modal
  setTimeout(function() {
    console.log('Auto testing modal...');
    openUploadModal();
  }, 2000);
});

// Video Preview Functions
function previewVideo(id, title, version, duration, fileVideo) {
  console.log('Previewing video:', { id, title, version, duration, fileVideo });
  
  // Set modal data
  document.getElementById('modalTitle').textContent = title;
  document.getElementById('modalVersion').textContent = version;
  document.getElementById('modalDuration').textContent = duration;
  
  // Set video source
  const videoPlayer = document.getElementById('videoPlayer');
  if (fileVideo && videoPlayer) {
    // Construct video path
    const videoPath = fileVideo.startsWith('http') 
      ? fileVideo 
      : `/storage/${fileVideo}`;
    
    videoPlayer.src = videoPath;
    videoPlayer.load(); // Reload video with new source
  }
  
  // Show modal
  const videoModal = document.getElementById('videoModal');
  if (videoModal) {
    videoModal.style.display = 'flex';
    document.body.style.overflow = 'hidden';
  }
}

function closeVideoModal() {
  console.log('Closing video modal...');
  
  const videoModal = document.getElementById('videoModal');
  const videoPlayer = document.getElementById('videoPlayer');
  
  if (videoModal) {
    videoModal.style.display = 'none';
  }
  
  if (videoPlayer) {
    videoPlayer.pause();
    videoPlayer.src = '';
  }
  
  document.body.style.overflow = 'auto';
}

// Close video modal when clicking outside
document.addEventListener('click', function(event) {
  const videoModal = document.getElementById('videoModal');
  if (event.target === videoModal) {
    closeVideoModal();
  }
});

// Keyboard shortcuts
document.addEventListener('keydown', function(event) {
  // ESC key to close modals
  if (event.key === 'Escape') {
    closeVideoModal();
    closeUploadModal();
  }
});

// Enhanced Download Function
function handleDownload(event, productionId) {
  event.preventDefault();
  
  const downloadBtn = event.currentTarget;
  const originalHref = downloadBtn.href;
  const originalIcon = downloadBtn.innerHTML;
  
  // Show loading state
  downloadBtn.classList.add('loading');
  downloadBtn.innerHTML = '<i class="fa-solid fa-spinner"></i>';
  downloadBtn.style.pointerEvents = 'none';
  
  // Create temporary link for download
  const tempLink = document.createElement('a');
  tempLink.href = originalHref;
  tempLink.download = ''; // Let browser determine filename
  document.body.appendChild(tempLink);
  
  // Trigger download
  tempLink.click();
  
  // Clean up
  setTimeout(() => {
    document.body.removeChild(tempLink);
    downloadBtn.classList.remove('loading');
    downloadBtn.innerHTML = originalIcon;
    downloadBtn.style.pointerEvents = 'auto';
  }, 2000);
  
  console.log('Downloading production:', productionId);
}

// Auto-attach download handlers
document.addEventListener('DOMContentLoaded', function() {
  const downloadButtons = document.querySelectorAll('.btn-download');
  downloadButtons.forEach(btn => {
    btn.addEventListener('click', function(e) {
      const productionId = this.getAttribute('href').match(/\/(\d+)$/)?.[1];
      if (productionId) {
        handleDownload(e, productionId);
      }
    });
  });
});

// Bulk Actions Functions
function toggleSelectAll() {
  const selectAll = document.getElementById('selectAll');
  const checkboxes = document.querySelectorAll('.row-checkbox');
  
  checkboxes.forEach(checkbox => {
    checkbox.checked = selectAll.checked;
  });
  
  updateBulkActions();
}

function updateBulkActions() {
  const checkedBoxes = document.querySelectorAll('.row-checkbox:checked');
  const bulkActions = document.getElementById('bulkActions');
  const selectAll = document.getElementById('selectAll');
  
  // Show/hide bulk actions
  if (checkedBoxes.length > 0) {
    bulkActions.style.display = 'flex';
  } else {
    bulkActions.style.display = 'none';
  }
  
  // Update select all checkbox state
  const allCheckboxes = document.querySelectorAll('.row-checkbox');
  selectAll.checked = allCheckboxes.length === checkedBoxes.length && checkedBoxes.length > 0;
  
  // Update count
  const countSpan = document.getElementById('selectedCount');
  if (countSpan) {
    countSpan.textContent = checkedBoxes.length;
  }
}

function getSelectedIds() {
  const checkedBoxes = document.querySelectorAll('.row-checkbox:checked');
  return Array.from(checkedBoxes).map(cb => cb.value);
}

function bulkAction(action) {
  const selectedIds = getSelectedIds();
  
  if (selectedIds.length === 0) {
    alert('Please select at least one item');
    return;
  }
  
  console.log(`Bulk ${action} for IDs:`, selectedIds);
  
  if (action === 'revision') {
    bulkRequestRevision(selectedIds);
  } else if (action === 'approve') {
    bulkApprove(selectedIds);
  }
}

function bulkRequestRevision(ids) {
  if (!confirm(`Request revision for ${ids.length} selected item(s)?`)) {
    return;
  }
  
  // Show loading state
  showBulkLoading('Requesting revision...');
  
  // Simulate API call
  setTimeout(() => {
    // Update status in UI
    ids.forEach(id => {
      const row = document.querySelector(`tr[data-id="${id}"]`);
      if (row) {
        const statusCell = row.querySelector('.pill');
        if (statusCell) {
          statusCell.className = 'pill p-revision';
          statusCell.innerHTML = '<span class="pill-dot"></span>Need Revision';
        }
      }
    });
    
    hideBulkLoading();
    showBulkSuccess(`${ids.length} item(s) sent for revision`);
    clearSelection();
  }, 1500);
}

function bulkApprove(ids) {
  if (!confirm(`Approve ${ids.length} selected item(s)?`)) {
    return;
  }
  
  // Show loading state
  showBulkLoading('Approving items...');
  
  // Simulate API call
  setTimeout(() => {
    // Update status in UI
    ids.forEach(id => {
      const row = document.querySelector(`tr[data-id="${id}"]`);
      if (row) {
        const statusCell = row.querySelector('.pill');
        if (statusCell) {
          statusCell.className = 'pill p-pub';
          statusCell.innerHTML = '<span class="pill-dot"></span>Published';
        }
      }
    });
    
    hideBulkLoading();
    showBulkSuccess(`${ids.length} item(s) approved successfully`);
    clearSelection();
  }, 1500);
}

function showBulkLoading(message) {
  const bulkActions = document.getElementById('bulkActions');
  bulkActions.innerHTML = `
    <div class="bulk-loading">
      <i class="fa-solid fa-spinner fa-spin"></i>
      ${message}
    </div>
  `;
}

function hideBulkLoading() {
  location.reload(); // Reload to restore original bulk actions
}

function showBulkSuccess(message) {
  // Create success notification
  const notification = document.createElement('div');
  notification.className = 'bulk-notification success';
  notification.innerHTML = `
    <i class="fa-solid fa-check-circle"></i>
    ${message}
  `;
  document.body.appendChild(notification);
  
  // Remove after 3 seconds
  setTimeout(() => {
    document.body.removeChild(notification);
  }, 3000);
}

function clearSelection() {
  // Clear all checkboxes
  document.querySelectorAll('.row-checkbox').forEach(cb => cb.checked = false);
  document.getElementById('selectAll').checked = false;
  updateBulkActions();
}
</script>

@endsection

@push('styles')
<style>
/* Page Subtitle */
.page-subtitle {
  font-size: 14px;
  color: var(--text-500);
  margin-top: 4px;
  margin-bottom: 20px;
}

/* Primary Button */
.btn-primary {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  padding: 10px 16px;
  background: linear-gradient(135deg, var(--blue), var(--blue-600));
  color: white;
  border: none;
  border-radius: var(--r-sm);
  font-size: 13px;
  font-weight: 600;
  cursor: pointer;
  transition: var(--t);
  box-shadow: 0 3px 10px rgba(88,151,254,.35);
}
.btn-primary:hover {
  transform: translateY(-2px);
  box-shadow: var(--s2);
}

/* Action Buttons */
.action-buttons {
  display: flex;
  align-items: center;
  gap: 6px;
}

.btn-action {
  width: 32px;
  height: 32px;
  border-radius: var(--r-xs);
  border: 1px solid var(--border);
  background: var(--white);
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  transition: var(--t);
  font-size: 12px;
  color: var(--text-500);
  text-decoration: none;
}
.btn-action:hover {
  transform: scale(1.05);
  border-color: var(--blue-200);
  background: var(--blue-50);
  color: var(--blue);
}

.btn-preview-sm:hover { background: rgba(139,92,246,.1); color: var(--violet); border-color: var(--violet); }
.btn-download:hover { background: rgba(16,185,129,.1); color: var(--emerald); border-color: var(--emerald); }
.btn-review:hover { background: rgba(245,158,11,.1); color: var(--amber); border-color: var(--amber); }

/* Preview Button in Table */
.btn-preview {
  padding: 4px 8px;
  border-radius: var(--r-xs);
  border: 1px solid var(--border);
  background: var(--white);
  color: var(--text-500);
  font-size: 11px;
  cursor: pointer;
  transition: var(--t);
  display: inline-flex;
  align-items: center;
  gap: 4px;
}
.btn-preview:hover {
  background: var(--blue-50);
  color: var(--blue);
  border-color: var(--blue-200);
}

/* Modal Styles */
.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(0,0,0,0.5);
  backdrop-filter: blur(4px);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 1000;
  animation: fadeIn 0.3s ease;
}

.modal-content {
  background: var(--white);
  border-radius: var(--r);
  box-shadow: var(--s3);
  width: 90%;
  max-width: 700px;
  max-height: 90vh;
  overflow: hidden;
  animation: slideUp 0.4s ease;
}

.modal-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 20px;
  border-bottom: 1px solid var(--border);
}

.modal-title {
  display: flex;
  align-items: center;
  gap: 8px;
  font-size: 16px;
  font-weight: 700;
  color: var(--text-900);
}

.modal-title i {
  color: var(--blue);
}

.modal-close {
  width: 32px;
  height: 32px;
  border-radius: var(--r-xs);
  border: 1px solid var(--border);
  background: var(--white);
  color: var(--text-500);
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  transition: var(--t);
}
.modal-close:hover {
  background: var(--blue-50);
  color: var(--rose);
  border-color: var(--blue-200);
}

.modal-body {
  padding: 20px;
  max-height: calc(90vh - 80px);
  overflow-y: auto;
}

/* Video Info */
.video-info {
  margin-bottom: 16px;
}

.video-meta {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 16px;
}

.meta-item {
  display: flex;
  flex-direction: column;
  gap: 4px;
}

.meta-item label {
  font-size: 11px;
  font-weight: 600;
  color: var(--text-400);
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

.meta-item span {
  font-size: 13px;
  font-weight: 600;
  color: var(--text-900);
}

/* Video Player */
.video-player {
  margin-top: 16px;
}

.video-player video {
  width: 100%;
  max-height: 400px;
  background: #000;
}

/* Form Styles */
.form-group {
  margin-bottom: 16px;
}

.form-group label {
  display: block;
  font-size: 13px;
  font-weight: 600;
  color: var(--text-700);
  margin-bottom: 6px;
}

.form-group input,
.form-group select,
.form-group textarea {
  width: 100%;
  padding: 10px 12px;
  border: 1px solid var(--border);
  border-radius: var(--r-sm);
  font-size: 13px;
  color: var(--text-900);
  background: var(--white);
  transition: var(--t);
}
.form-group input:focus,
.form-group select:focus,
.form-group textarea:focus {
  outline: none;
  border-color: var(--blue);
  box-shadow: 0 0 0 3px rgba(88,151,254,.1);
}

.form-group textarea {
  resize: vertical;
  min-height: 80px;
}

.form-group .text-muted {
  display: block;
  margin-top: 4px;
  font-size: 11px;
  color: var(--text-400);
}

.modal-actions {
  display: flex;
  align-items: center;
  justify-content: flex-end;
  gap: 12px;
  margin-top: 24px;
  padding-top: 16px;
  border-top: 1px solid var(--border);
}

.btn-secondary {
  padding: 10px 16px;
  border: 1px solid var(--border);
  background: var(--white);
  color: var(--text-700);
  border-radius: var(--r-sm);
  font-size: 13px;
  font-weight: 600;
  cursor: pointer;
  transition: var(--t);
}
.btn-secondary:hover {
  background: var(--blue-50);
  color: var(--text-900);
  border-color: var(--blue-200);
}

/* Animations */
@keyframes fadeIn {
  from { opacity: 0; }
  to { opacity: 1; }
}

@keyframes slideUp {
  from { opacity: 0; transform: translateY(20px); }
  to { opacity: 1; transform: translateY(0); }
}

/* Text utilities */
.text-muted {
  color: var(--text-400);
}
.text-center {
  text-align: center;
}
.py-4 {
  padding-top: 16px;
  padding-bottom: 16px;
}

/* Alert Messages */
.alert {
  display: flex;
  align-items: center;
  gap: 10px;
  padding: 12px 16px;
  border-radius: var(--r-sm);
  margin-bottom: 20px;
  font-size: 13px;
  font-weight: 500;
}

.alert-success {
  background: rgba(16,185,129,.1);
  color: var(--emerald);
  border: 1px solid rgba(16,185,129,.2);
}

.alert-error {
  background: rgba(239,68,68,.1);
  color: #ef4444;
  border: 1px solid rgba(239,68,68,.2);
}

/* Upload Modal Styles - Modern SaaS Dashboard */
.modal-overlay-upload {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(0, 0, 0, 0.5);
  backdrop-filter: blur(4px);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 1000;
  padding: 20px;
  animation: fadeIn 0.3s ease;
}

.modal-content-upload {
  background: white;
  border-radius: 16px;
  box-shadow: 0 25px 60px rgba(0, 0, 0, 0.15);
  width: 100%;
  max-width: 520px;
  max-height: 85vh;
  overflow: hidden;
  animation: modalSlideUp 0.4s ease;
  position: relative;
}

@keyframes fadeIn {
  from { opacity: 0; }
  to { opacity: 1; }
}

@keyframes modalSlideUp {
  from {
    opacity: 0;
    transform: translateY(20px) scale(0.95);
  }
  to {
    opacity: 1;
    transform: translateY(0) scale(1);
  }
}

/* Modal Header - Clean Design */
.modal-header-upload {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 28px 28px 20px;
}

.modal-title-upload {
  display: flex;
  align-items: center;
  gap: 16px;
  flex: 1;
}

.modal-icon-upload {
  width: 48px;
  height: 48px;
  background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
  border-radius: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 18px;
  color: white;
  box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
}

.modal-text-upload h3 {
  font-size: 18px;
  font-weight: 700;
  color: #1e293b;
  margin: 0;
  margin-bottom: 4px;
}

.modal-text-upload p {
  font-size: 13px;
  color: #64748b;
  margin: 0;
  font-weight: 400;
}

.modal-close-upload {
  width: 36px;
  height: 36px;
  border-radius: 10px;
  border: 1px solid #e2e8f0;
  background: white;
  color: #64748b;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  transition: all 0.2s ease;
  font-size: 14px;
}

.modal-close-upload:hover {
  background: #f8fafc;
  color: #1e293b;
  border-color: #cbd5e1;
  transform: scale(1.05);
}

.modal-divider {
  height: 1px;
  background: #e2e8f0;
  margin: 0 28px;
}

/* Modal Body */
.modal-body-upload {
  padding: 28px;
  max-height: calc(85vh - 180px);
  overflow-y: auto;
}

/* Form Styles - Modern */
.form-group-upload {
  margin-bottom: 18px;
}

.form-label-upload {
  display: block;
  font-size: 13px;
  font-weight: 600;
  color: #475569;
  margin-bottom: 8px;
}

.form-input-upload {
  width: 100%;
  height: 44px;
  border: 1px solid #e2e8f0;
  border-radius: 10px;
  padding: 0 14px;
  font-size: 14px;
  color: #1e293b;
  background: white;
  transition: all 0.2s ease;
  box-sizing: border-box;
}

.form-input-upload:focus {
  outline: none;
  border-color: #3b82f6;
  box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
  transform: translateY(-1px);
}

.form-input-upload::placeholder {
  color: #94a3b8;
  font-weight: 400;
}

.form-textarea-upload {
  width: 100%;
  min-height: 90px;
  border: 1px solid #e2e8f0;
  border-radius: 10px;
  padding: 12px 14px;
  font-size: 14px;
  color: #1e293b;
  background: white;
  transition: all 0.2s ease;
  resize: vertical;
  font-family: inherit;
  line-height: 1.5;
  box-sizing: border-box;
}

.form-textarea-upload:focus {
  outline: none;
  border-color: #3b82f6;
  box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
  transform: translateY(-1px);
}

.form-textarea-upload::placeholder {
  color: #94a3b8;
  font-weight: 400;
}

/* Select Styling */
select.form-input-upload {
  cursor: pointer;
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%2364748b'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'/%3E%3C/svg%3E");
  background-position: right 14px center;
  background-repeat: no-repeat;
  background-size: 20px;
  padding-right: 44px;
  appearance: none;
}

/* File Upload Styling */
.file-upload-wrapper {
  position: relative;
}

.file-upload-input {
  position: absolute;
  opacity: 0;
  width: 0;
  height: 0;
  pointer-events: none;
}

.file-upload-label {
  display: block;
  border: 1px dashed #cbd5e1;
  border-radius: 10px;
  padding: 24px;
  text-align: center;
  cursor: pointer;
  transition: all 0.2s ease;
  background: #fafbfc;
}

.file-upload-label:hover {
  border-color: #3b82f6;
  background: #f8fafc;
}

.file-upload-icon {
  margin-bottom: 12px;
}

.file-upload-icon i {
  font-size: 32px;
  color: #3b82f6;
}

.file-upload-text {
  display: flex;
  flex-direction: column;
  gap: 4px;
}

.file-upload-main {
  font-size: 14px;
  font-weight: 600;
  color: #1e293b;
}

.file-upload-sub {
  font-size: 12px;
  color: #64748b;
  font-weight: 400;
}

.file-upload-result {
  display: none;
  align-items: center;
  gap: 12px;
  padding: 16px;
  background: #f0f9ff;
  border: 1px solid #bae6fd;
  border-radius: 10px;
  margin-top: 12px;
}

.file-upload-result i {
  color: #0284c7;
  font-size: 20px;
}

.file-upload-result span {
  flex: 1;
  font-size: 13px;
  font-weight: 500;
  color: #0c4a6e;
}

.file-remove {
  width: 24px;
  height: 24px;
  border-radius: 6px;
  border: none;
  background: #fee2e2;
  color: #dc2626;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  transition: all 0.2s ease;
  font-size: 12px;
}

.file-remove:hover {
  background: #fecaca;
  transform: scale(1.1);
}

/* Modal Actions */
.modal-actions-upload {
  display: flex;
  align-items: center;
  justify-content: flex-end;
  gap: 12px;
  margin-top: 24px;
  padding-top: 20px;
  border-top: 1px solid #e2e8f0;
}

/* Button Styles - Modern */
.btn-cancel-upload {
  padding: 12px 20px;
  border: 1px solid #e2e8f0;
  background: white;
  color: #475569;
  border-radius: 10px;
  font-size: 14px;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.2s ease;
}

.btn-cancel-upload:hover {
  background: #f8fafc;
  border-color: #cbd5e1;
  transform: translateY(-1px);
}

.btn-submit-upload {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  padding: 12px 24px;
  background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
  color: white;
  border: none;
  border-radius: 10px;
  font-size: 14px;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.2s ease;
  box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
}

.btn-submit-upload:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 20px rgba(59, 130, 246, 0.4);
  background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
}

.btn-submit-upload:disabled {
  opacity: 0.6;
  cursor: not-allowed;
  transform: none;
  box-shadow: 0 4px 12px rgba(59, 130, 246, 0.2);
}

/* Responsive Design */
@media (max-width: 640px) {
  .modal-content-upload {
    max-width: 90vw;
    margin: 0 10px;
  }
  
  .modal-header-upload,
  .modal-body-upload {
    padding: 20px;
  }
  
  .modal-divider {
    margin: 0 20px;
  }
  
  .modal-title-upload {
    gap: 12px;
  }
  
  .modal-icon-upload {
    width: 40px;
    height: 40px;
    font-size: 16px;
  }
  
  .modal-text-upload h3 {
    font-size: 16px;
  }
  
  .modal-actions-upload {
    flex-direction: column;
    gap: 8px;
  }
  
  .btn-cancel-upload,
  .btn-submit-upload {
    width: 100%;
    justify-content: center;
  }
}
</style>
@endpush

<style>
/* Modal CSS - Required for modal to work */
.modal-overlay-upload {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(0, 0, 0, 0.5);
  backdrop-filter: blur(4px);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 1000;
  padding: 20px;
}

.modal-content-upload {
  background: white;
  border-radius: 16px;
  box-shadow: 0 25px 60px rgba(0, 0, 0, 0.15);
  width: 100%;
  max-width: 520px;
  max-height: 85vh;
  overflow: hidden;
  position: relative;
}

.modal-header-upload {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 28px 28px 20px;
}

.modal-title-upload {
  display: flex;
  align-items: center;
  gap: 16px;
  flex: 1;
}

.modal-icon-upload {
  width: 48px;
  height: 48px;
  background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
  border-radius: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 18px;
  color: white;
  box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
}

.modal-text-upload h3 {
  font-size: 18px;
  font-weight: 700;
  color: #1e293b;
  margin: 0;
  margin-bottom: 4px;
}

.modal-text-upload p {
  font-size: 13px;
  color: #64748b;
  margin: 0;
  font-weight: 400;
}

.modal-close-upload {
  width: 36px;
  height: 36px;
  border-radius: 10px;
  border: 1px solid #e2e8f0;
  background: white;
  color: #64748b;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  transition: all 0.2s ease;
  font-size: 14px;
}

.modal-close-upload:hover {
  background: #f8fafc;
  color: #1e293b;
  border-color: #cbd5e1;
  transform: scale(1.05);
}

.modal-divider {
  height: 1px;
  background: #e2e8f0;
  margin: 0 28px;
}

.modal-body-upload {
  padding: 28px;
  max-height: calc(85vh - 180px);
  overflow-y: auto;
}

.form-group-upload {
  margin-bottom: 18px;
}

.form-label-upload {
  display: block;
  font-size: 13px;
  font-weight: 600;
  color: #475569;
  margin-bottom: 8px;
}

.form-input-upload {
  width: 100%;
  height: 44px;
  border: 1px solid #e2e8f0;
  border-radius: 10px;
  padding: 0 14px;
  font-size: 14px;
  color: #1e293b;
  background: white;
  transition: all 0.2s ease;
  box-sizing: border-box;
}

.form-input-upload:focus {
  outline: none;
  border-color: #3b82f6;
  box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
  transform: translateY(-1px);
}

.form-textarea-upload {
  width: 100%;
  min-height: 90px;
  border: 1px solid #e2e8f0;
  border-radius: 10px;
  padding: 12px 14px;
  font-size: 14px;
  color: #1e293b;
  background: white;
  transition: all 0.2s ease;
  resize: vertical;
  font-family: inherit;
  line-height: 1.5;
  box-sizing: border-box;
}

.form-textarea-upload:focus {
  outline: none;
  border-color: #3b82f6;
  box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
  transform: translateY(-1px);
}

.modal-actions-upload {
  display: flex;
  align-items: center;
  justify-content: flex-end;
  gap: 12px;
  margin-top: 24px;
  padding-top: 20px;
  border-top: 1px solid #e2e8f0;
}

.btn-cancel-upload {
  padding: 12px 20px;
  border: 1px solid #e2e8f0;
  background: white;
  color: #475569;
  border-radius: 10px;
  font-size: 14px;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.2s ease;
}

.btn-cancel-upload:hover {
  background: #f8fafc;
  border-color: #cbd5e1;
  transform: translateY(-1px);
}

.btn-submit-upload {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  padding: 12px 24px;
  background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
  color: white;
  border: none;
  border-radius: 10px;
  font-size: 14px;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.2s ease;
  box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
}

.btn-submit-upload:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 20px rgba(59, 130, 246, 0.4);
  background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
}

/* File Upload Styles */
.file-upload-wrapper {
  position: relative;
}

.file-upload-input {
  position: absolute;
  opacity: 0;
  width: 0;
  height: 0;
  pointer-events: none;
}

.file-upload-label {
  display: block;
  border: 1px dashed #cbd5e1;
  border-radius: 10px;
  padding: 24px;
  text-align: center;
  cursor: pointer;
  transition: all 0.2s ease;
  background: #fafbfc;
}

.file-upload-label:hover {
  border-color: #3b82f6;
  background: #f8fafc;
}

.file-upload-icon {
  margin-bottom: 12px;
}

.file-upload-icon i {
  font-size: 32px;
  color: #3b82f6;
}

.file-upload-text {
  display: flex;
  flex-direction: column;
  gap: 4px;
}

.file-upload-main {
  font-size: 14px;
  font-weight: 600;
  color: #1e293b;
}

.file-upload-sub {
  font-size: 12px;
  color: #64748b;
  font-weight: 400;
}

.file-upload-result {
  display: none;
  align-items: center;
  gap: 12px;
  padding: 16px;
  background: #f0f9ff;
  border: 1px solid #bae6fd;
  border-radius: 10px;
  margin-top: 12px;
}

.file-upload-result i {
  color: #0284c7;
  font-size: 20px;
}

.file-upload-result span {
  flex: 1;
  font-size: 13px;
  font-weight: 500;
  color: #0c4a6e;
}

.file-remove {
  width: 24px;
  height: 24px;
  border-radius: 6px;
  border: none;
  background: #fee2e2;
  color: #dc2626;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  transition: all 0.2s ease;
  font-size: 12px;
}

.file-remove:hover {
  background: #fecaca;
  transform: scale(1.1);
}

/* Video Modal Styles */
.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(0,0,0,0.5);
  backdrop-filter: blur(4px);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 1000;
  animation: fadeIn 0.3s ease;
}

.modal-content {
  background: var(--white);
  border-radius: var(--r);
  box-shadow: var(--s3);
  width: 90%;
  max-width: 700px;
  max-height: 90vh;
  overflow: hidden;
  animation: slideUp 0.4s ease;
}

.modal-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 20px;
  border-bottom: 1px solid var(--border);
}

.modal-title {
  display: flex;
  align-items: center;
  gap: 8px;
  font-size: 16px;
  font-weight: 700;
  color: var(--text-900);
}

.modal-title i {
  color: var(--blue);
}

.modal-close {
  width: 32px;
  height: 32px;
  border-radius: var(--r-xs);
  border: 1px solid var(--border);
  background: var(--white);
  color: var(--text-500);
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  transition: var(--t);
}
.modal-close:hover {
  background: var(--blue-50);
  color: var(--rose);
  border-color: var(--blue-200);
}

.modal-body {
  padding: 20px;
  max-height: calc(90vh - 80px);
  overflow-y: auto;
}

/* Video Info */
.video-info {
  margin-bottom: 16px;
}

.video-meta {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 16px;
}

.meta-item {
  display: flex;
  flex-direction: column;
  gap: 4px;
}

.meta-item label {
  font-size: 11px;
  font-weight: 600;
  color: var(--text-400);
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

.meta-item span {
  font-size: 13px;
  font-weight: 600;
  color: var(--text-900);
}

/* Video Player */
.video-player {
  margin-top: 16px;
}

.video-player video {
  width: 100%;
  max-height: 400px;
  background: #000;
  border-radius: 8px;
}

/* Enhanced Action Buttons */
.action-buttons {
  display: flex;
  align-items: center;
  gap: 6px;
}

.btn-action {
  width: 32px;
  height: 32px;
  border-radius: var(--r-xs);
  border: 1px solid var(--border);
  background: var(--white);
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  transition: var(--t);
  font-size: 12px;
  color: var(--text-500);
  text-decoration: none;
  position: relative;
  overflow: hidden;
}

.btn-action:hover {
  transform: scale(1.05);
  box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.btn-action:active {
  transform: scale(0.95);
}

.btn-preview-sm:hover { 
  background: rgba(139,92,246,.1); 
  color: var(--violet); 
  border-color: var(--violet); 
}

.btn-download:hover { 
  background: rgba(16,185,129,.1); 
  color: var(--emerald); 
  border-color: var(--emerald); 
}

.btn-review:hover { 
  background: rgba(245,158,11,.1); 
  color: var(--amber); 
  border-color: var(--amber); 
}

/* Loading state for download */
.btn-download.loading {
  pointer-events: none;
  opacity: 0.6;
}

.btn-download.loading::after {
  content: '';
  position: absolute;
  width: 12px;
  height: 12px;
  border: 2px solid var(--emerald);
  border-top-color: transparent;
  border-radius: 50%;
  animation: spin 0.8s linear infinite;
}

@keyframes spin {
  to { transform: rotate(360deg); }
}

/* Bulk Actions Styles */
.bulk-actions {
  display: none;
  align-items: center;
  gap: 12px;
  margin-left: auto;
  flex-shrink: 0;
}

.btn-bulk {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  padding: 10px 16px;
  border: none;
  border-radius: 8px;
  font-size: 13px;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.2s ease;
  text-decoration: none;
  white-space: nowrap;
}

.btn-revision {
  background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
  color: white;
  box-shadow: 0 2px 8px rgba(245, 158, 11, 0.3);
}

.btn-revision:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(245, 158, 11, 0.4);
}

.btn-approve {
  background: linear-gradient(135deg, #10b981 0%, #059669 100%);
  color: white;
  box-shadow: 0 2px 8px rgba(16, 185, 129, 0.3);
}

.btn-approve:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(16, 185, 129, 0.4);
}

/* Checkbox Styles */
input[type="checkbox"] {
  width: 18px;
  height: 18px;
  accent-color: #3b82f6;
  cursor: pointer;
  transition: all 0.2s ease;
}

input[type="checkbox"]:hover {
  transform: scale(1.1);
}

input[type="checkbox"]:checked {
  accent-color: #3b82f6;
}

/* Custom checkbox styling untuk browser compatibility */
input[type="checkbox"] {
  -webkit-appearance: none;
  -moz-appearance: none;
  appearance: none;
  border: 2px solid #e2e8f0;
  border-radius: 4px;
  position: relative;
  transition: all 0.2s ease;
}

input[type="checkbox"]:checked {
  background: #3b82f6;
  border-color: #3b82f6;
}

input[type="checkbox"]:checked::after {
  content: '✓';
  position: absolute;
  top: -2px;
  left: 3px;
  color: white;
  font-size: 14px;
  font-weight: bold;
  font-family: Arial, sans-serif;
}

input[type="checkbox"]:hover {
  border-color: #3b82f6;
  box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

/* Table with checkbox */
table th:first-child,
table td:first-child {
  text-align: center;
  vertical-align: middle;
}

/* Loading State */
.bulk-loading {
  display: flex;
  align-items: center;
  gap: 8px;
  padding: 8px 16px;
  background: #f3f4f6;
  border-radius: 8px;
  font-size: 13px;
  color: #64748b;
}

.fa-spin {
  animation: spin 1s linear infinite;
}

/* Bulk Notification */
.bulk-notification {
  position: fixed;
  top: 20px;
  right: 20px;
  display: flex;
  align-items: center;
  gap: 12px;
  padding: 16px 20px;
  background: white;
  border-radius: 12px;
  box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
  z-index: 2000;
  animation: slideInRight 0.3s ease;
  min-width: 300px;
}

.bulk-notification.success {
  border-left: 4px solid #10b981;
}

.bulk-notification i {
  font-size: 18px;
  color: #10b981;
}

.bulk-notification span {
  font-size: 14px;
  font-weight: 600;
  color: #1e293b;
}

@keyframes slideInRight {
  from {
    opacity: 0;
    transform: translateX(100px);
  }
  to {
    opacity: 1;
    transform: translateX(0);
  }
}

/* Enhanced Table Header */
.sec-head {
  display: flex;
  align-items: center;
  justify-content: space-between;
  flex-wrap: wrap;
  gap: 16px;
}

/* Responsive Bulk Actions */
@media (max-width: 768px) {
  .bulk-actions {
    flex-direction: column;
    width: 100%;
    margin-top: 12px;
  }
  
  .btn-bulk {
    width: 100%;
    justify-content: center;
  }
  
  .bulk-notification {
    right: 10px;
    left: 10px;
    min-width: auto;
  }
}
</style>

<!-- JavaScript for Upload Production Modal -->
<script>
// Modal helpers
function openModal(id) { 
  document.getElementById(id).classList.add('open'); 
  document.body.style.overflow = 'hidden'; 
}

function closeModal(id) { 
  document.getElementById(id).classList.remove('open'); 
  document.body.style.overflow = ''; 
}

function closeOnOverlay(e, id) { 
  if (e.target === document.getElementById(id)) closeModal(id); 
}

// File upload handlers
function handleFileSelect(event) {
  const file = event.target.files[0];
  if (file) {
    const fileUploadContent = document.getElementById('fileUploadContent');
    const fileUploadResult = document.getElementById('fileUploadResult');
    const fileName = document.getElementById('fileName');
    
    // Update UI to show selected file
    fileUploadContent.style.display = 'none';
    fileUploadResult.style.display = 'flex';
    fileName.textContent = file.name;
    
    // Store file for form submission
    window.selectedFile = file;
  }
}

function removeFile() {
  const fileUploadContent = document.getElementById('fileUploadContent');
  const fileUploadResult = document.getElementById('fileUploadResult');
  const fileInput = document.getElementById('videoFile');
  
  // Reset UI
  fileUploadContent.style.display = 'flex';
  fileUploadResult.style.display = 'none';
  fileInput.value = '';
  window.selectedFile = null;
}

// Form submission
function submitUploadForm(event) {
  event.preventDefault();
  
  if (!validateUploadForm()) return;
  
  const btn = document.getElementById('submitBtn');
  btn.innerHTML = '<i class="fa-solid fa-circle-notch spin"></i> Uploading...';
  btn.disabled = true;
  
  // Create FormData for file upload
  const formData = new FormData();
  formData.append('video_file', window.selectedFile);
  formData.append('version', document.getElementById('fVersion').value);
  formData.append('final_duration', document.getElementById('fDuration').value);
  formData.append('production_notes', document.getElementById('fNotes').value);
  
  // Simulate upload (replace with actual fetch later)
  setTimeout(() => {
    btn.innerHTML = '<i class="fa-solid fa-upload"></i> Upload Production';
    btn.disabled = false;
    closeModal('uploadModal');
    showUploadSuccess('Video production berhasil diupload!');
    
    // Reset form
    document.getElementById('uploadForm').reset();
    removeFile();
  }, 2000);
}

// Validation
function validateUploadForm() {
  let isValid = true;
  
  // Validate version
  const version = document.getElementById('fVersion');
  if (!version.value.trim()) {
    version.classList.add('error');
    document.getElementById('errVersion').classList.add('show');
    isValid = false;
  } else {
    version.classList.remove('error');
    document.getElementById('errVersion').classList.remove('show');
  }
  
  // Validate duration
  const duration = document.getElementById('fDuration');
  if (!duration.value.trim()) {
    duration.classList.add('error');
    document.getElementById('errDuration').classList.add('show');
    isValid = false;
  } else {
    duration.classList.remove('error');
    document.getElementById('errDuration').classList.remove('show');
  }
  
  // Validate file
  if (!window.selectedFile) {
    document.getElementById('errFile').classList.add('show');
    isValid = false;
  } else {
    document.getElementById('errFile').classList.remove('show');
  }
  
  return isValid;
}

// Success notification
function showUploadSuccess(message) {
  // Create success notification
  const notification = document.createElement('div');
  notification.className = 'bulk-notification success';
  notification.innerHTML = `
    <i class="fa-solid fa-check-circle"></i>
    <span>${message}</span>
  `;
  
  document.body.appendChild(notification);
  
  // Auto remove after 3 seconds
  setTimeout(() => {
    notification.remove();
  }, 3000);
}

// Clear errors on input
document.addEventListener('DOMContentLoaded', function() {
  ['fVersion', 'fDuration'].forEach(id => {
    const element = document.getElementById(id);
    if (element) {
      element.addEventListener('input', function() {
        this.classList.remove('error');
        const errId = 'err' + id.charAt(1).toUpperCase() + id.slice(2);
        const errElement = document.getElementById(errId);
        if (errElement) {
          errElement.classList.remove('show');
        }
      });
    }
  });
});
</script>
