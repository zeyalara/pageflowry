@extends('layouts.admin')

@section('page-title', 'Revision')

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
.form-group {
  display: flex;
  flex-direction: column;
  margin-bottom: 16px;
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
.form-input:disabled,
.form-select:disabled {
  background: var(--bg);
  cursor: not-allowed;
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
.p-under-review {
  background: rgba(250, 204, 21, 0.1);
  color: #facc15;
  border: 1px solid rgba(250, 204, 21, 0.2);
}
.p-under-review .pill-dot {
  background: #facc15;
}
.p-need-revision {
  background: rgba(239, 68, 68, 0.1);
  color: #ef4444;
  border: 1px solid rgba(239, 68, 68, 0.2);
}
.p-need-revision .pill-dot {
  background: #ef4444;
}
.p-terevisi {
  background: rgba(16, 185, 129, 0.1);
  color: #10b981;
  border: 1px solid rgba(16, 185, 129, 0.2);
}
.p-terevisi .pill-dot {
  background: #10b981;
}

/* Action Buttons */
.btn-action {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  width: 28px;
  height: 28px;
  border-radius: 5px;
  border: 1px solid var(--border);
  background: var(--white);
  color: var(--text-500);
  cursor: pointer;
  transition: var(--t);
  font-size: 10px;
}
.btn-action:hover {
  background: var(--blue);
  color: white;
  border-color: var(--blue);
  transform: translateY(-1px);
}

/* ─────────────────────────────────────────
   MODERN FILE UPLOAD
───────────────────────────────────────── */
.file-drop-zone {
  border: 2px dashed var(--border);
  border-radius: 12px;
  padding: 32px 20px;
  text-align: center;
  background: var(--bg);
  transition: all .2s ease;
  cursor: pointer;
  position: relative;
  overflow: hidden;
}
.file-drop-zone:hover, .file-drop-zone.dragover {
  border-color: var(--blue);
  background: rgba(88,151,254,.05);
}
.file-drop-zone i {
  font-size: 32px;
  color: var(--blue);
  margin-bottom: 12px;
  display: block;
}
.file-drop-name {
  font-size: 13px;
  font-weight: 600;
  color: var(--text-700);
}
.file-drop-hint {
  font-size: 11px;
  color: var(--text-400);
  margin-top: 4px;
}
.progress-container {
  margin-top: 16px;
  display: none;
}
.progress-bar-wrap {
  height: 6px;
  background: var(--border-light);
  border-radius: 10px;
  overflow: hidden;
}
.progress-bar-fill {
  height: 100%;
  background: var(--blue);
  width: 0%;
  transition: width .2s ease;
}
.progress-text {
  font-size: 11px;
  font-weight: 700;
  color: var(--blue);
  text-align: right;
  margin-top: 6px;
}

/* Table overflow fixes */
.tbl-card {
  overflow-x: auto;
}
.tbl-card table {
  width: 1170px; /* Total width of all columns */
  table-layout: fixed;
  min-width: 100%;
}
.tbl-card th,
.tbl-card td {
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
}
.tbl-card .action-buttons {
  min-width: 140px;
  display: flex;
  gap: 1px;
  flex-wrap: nowrap;
}
.tbl-card .pill {
  font-size: 10px;
  padding: 1px 6px;
  white-space: nowrap;
}
.tbl-card .pill-dot {
  width: 4px;
  height: 4px;
  border-radius: 50%;
}
</style>
@endpush

@section('content')

<div class="page-header">
  <div>
    <div class="page-header-title">Revision</div>
    <div class="page-subtitle">Kelola revisi konten dari produksi</div>
  </div>
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
    <div class="stat-val">{{ $stats['total_review'] ?? 0 }}</div>
    <div class="stat-lbl">Total Review</div>
  </div>
  <div class="stat-card sc-amb" style="--i:1">
    <div class="stat-ic"><i class="fa-solid fa-eye"></i></div>
    <div class="stat-val">{{ $stats['under_review'] ?? 0 }}</div>
    <div class="stat-lbl">Under Review</div>
  </div>
  <div class="stat-card sc-red" style="--i:2">
    <div class="stat-ic"><i class="fa-solid fa-triangle-exclamation"></i></div>
    <div class="stat-val">{{ $stats['need_revision'] ?? 0 }}</div>
    <div class="stat-lbl">Need Revision</div>
  </div>
  <div class="stat-card sc-em" style="--i:3">
    <div class="stat-ic"><i class="fa-solid fa-check-double"></i></div>
    <div class="stat-val">{{ $stats['terevisi'] ?? 0 }}</div>
    <div class="stat-lbl">Terevisi</div>
  </div>
</div>

<div class="card tbl-card">
  <div class="sec-head" style="margin-bottom:0">
    <div class="sec-title">
      <i class="fa-solid fa-list"></i>
      Daftar Revisi Konten
    </div>
  </div>
  <table>
    <thead>
      <tr>
        <th style="width: 40px;">ID</th>
        <th style="width: 180px;">Judul Konten</th>
        <th style="width: 100px;">Brand</th>
        <th style="width: 80px;">Versi</th>
        <th style="width: 150px;">Catatan Produksi</th>
        <th style="width: 150px;">Catatan Revisi</th>
        <th style="width: 100px;">Deadline</th>
        <th style="width: 110px;">Status</th>
        <th style="width: 180px;">Aksi</th>
      </tr>
    </thead>
    <tbody>
      @forelse($contentTasks as $index => $task)
        @php 
          $production = $task->productions->first();
          $statusMap = [
            'under_review' => ['label' => 'Under Review', 'class' => 'p-under-review'],
            'need_revision' => ['label' => 'Need Revision', 'class' => 'p-need-revision'],
            'terevisi' => ['label' => 'Terevisi', 'class' => 'p-terevisi'],
          ];
          $s = $statusMap[$task->status] ?? ['label' => ucfirst(str_replace('_', ' ', $task->status)), 'class' => 'p-prod'];
          $rowNumber = $index + 1;
          
          // Find brief to check creator email
          $brief = \App\Models\ContentBrief::where('user_id', auth()->id())
              ->where('title', $task->judul_konten)
              ->where('brand_id', $task->brand_id)
              ->first();
          $hasCreatorEmail = $brief && $brief->creator_email;
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
            @if($task->revision_note)
              <span class="td-notes" title="{{ $task->revision_note }}">
                {{ Str::limit($task->revision_note, 30) }}
              </span>
            @else
              <span class="text-muted">-</span>
            @endif
          </td>
          <td style="white-space: nowrap; vertical-align: middle;">
            @if($task->revision_deadline)
              <span class="td-date">
                <i class="fa-regular fa-calendar"></i>
                {{ $task->revision_deadline->format('d M Y') }}
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
            <div class="action-buttons" style="display:flex;gap:4px;flex-wrap:nowrap;">
              @if($production && $production->file_video)
                <button class="btn-action" onclick="previewVideo({{ $production->id }}, '{{ addslashes($task->judul_konten) }}', '{{ $production->file_video }}')" title="Preview Video">
                  <i class="fa-solid fa-eye"></i>
                </button>
              @endif

              @if($task->status == 'under_review')
                <button class="btn-action" onclick="openBeriRevisiModal({{ $task->id }}, '{{ addslashes($task->judul_konten) }}')" title="Beri Revisi" style="color: var(--amber);">
                  <i class="fa-solid fa-clock-rotate-left"></i>
                </button>
                <button class="btn-action" onclick="openSendApprovalModal({{ $task->id }}, '{{ addslashes($task->judul_konten) }}')" title="Kirim ke Approval" style="color: var(--emerald);">
                  <i class="fa-solid fa-circle-check"></i>
                </button>
              @elseif($task->status == 'need_revision')
                <button class="btn-action" onclick="openEditRevisiModal({{ $task->id }}, '{{ addslashes($task->judul_konten) }}', '{{ addslashes($task->revision_note ?? '') }}', '{{ $task->revision_deadline?->format('Y-m-d') ?? '' }}')" title="Edit Revisi">
                  <i class="fa-solid fa-edit"></i>
                </button>
                <button class="btn-action" onclick="openUploadRevisiModal({{ $task->id }}, '{{ addslashes($task->judul_konten) }}')" title="Upload Hasil Revisi" style="color: var(--blue);">
                  <i class="fa-solid fa-cloud-arrow-up"></i>
                </button>
                @if($hasCreatorEmail)
                  <button class="btn-action" onclick="notifyRevision({{ $task->id }}, '{{ addslashes($task->judul_konten) }}')" title="Kirim Notifikasi Revisi ke Kreator" style="color: var(--violet);">
                    <i class="fa-solid fa-paper-plane"></i>
                  </button>
                @endif
              @elseif($task->status == 'terevisi')
                <button class="btn-action" onclick="openSendApprovalModal({{ $task->id }}, '{{ addslashes($task->judul_konten) }}')" title="Kirim ke Approval" style="color: var(--emerald);">
                  <i class="fa-solid fa-circle-check"></i>
                </button>
                <button class="btn-action" onclick="openEditRevisiModal({{ $task->id }}, '{{ addslashes($task->judul_konten) }}', '{{ addslashes($task->revision_note ?? '') }}', '{{ $task->revision_deadline?->format('Y-m-d') ?? '' }}')" title="Beri Revisi Lagi" style="color: var(--amber);">
                  <i class="fa-solid fa-clock-rotate-left"></i>
                </button>
              @endif
            </div>
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="10" style="text-align:center;padding:32px 0;color:var(--text-400);">
            <i class="fa-solid fa-list" style="font-size:32px;margin-bottom:10px;opacity:.3;"></i>
            <div style="font-size:15px;font-weight:600;">Belum ada konten untuk direvisi</div>
            <div style="font-size:12.5px;">Upload video produksi terlebih dahulu</div>
          </td>
        </tr>
      @endforelse
    </tbody>
  </table>
</div>

<!-- Modal Beri Revisi -->
<div class="overlay" id="beriRevisiOverlay" onclick="closeOnOverlay(event, 'beriRevisiOverlay')">
  <div class="modal" onclick="event.stopPropagation()">
    <div class="modal-head">
      <div class="modal-title-wrap">
        <div class="modal-eyebrow"><i class="fa-solid fa-clock-rotate-left"></i> Revision</div>
        <div class="modal-title">Beri Revisi</div>
        <div class="modal-subtitle">Tambahkan catatan revisi untuk konten ini</div>
      </div>
      <button class="modal-close" type="button" onclick="closeModal('beriRevisiOverlay')">
        <i class="fa-solid fa-xmark"></i>
      </button>
    </div>
    <div class="modal-body">
      <div class="modal-divider"></div>
      <form id="beriRevisiForm" onsubmit="submitBeriRevisi(event)" novalidate>
        <div class="form-group">
          <label class="form-label">Pilih Content Task</label>
          <input type="text" id="beriRevisiTaskTitle" class="form-input" disabled>
          <input type="hidden" name="content_task_id" id="beriRevisiTaskId">
        </div>

        <div class="form-group">
          <label class="form-label">
            Catatan Revisi <span class="required">*</span>
          </label>
          <textarea name="revision_note" class="form-textarea" placeholder="Tambahkan catatan revisi..." required></textarea>
        </div>

        <div class="form-group">
          <label class="form-label">Deadline Revisi</label>
          <input type="date" name="revision_deadline" class="form-input">
        </div>
      </form>
    </div>
    <div class="modal-footer">
      <div class="mf-left">
        <i class="fa-solid fa-asterisk" style="font-size:8px"></i> Wajib diisi
      </div>
      <div class="mf-right">
        <button class="btn-ghost" type="button" onclick="closeModal('beriRevisiOverlay')">Batal</button>
        <button class="btn btn-primary" type="button" onclick="submitBeriRevisi(event)">
          <i class="fa-solid fa-clock-rotate-left"></i> Beri Revisi
        </button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Edit Revisi -->
<div class="overlay" id="editRevisiOverlay" onclick="closeOnOverlay(event, 'editRevisiOverlay')">
  <div class="modal" onclick="event.stopPropagation()">
    <div class="modal-head">
      <div class="modal-title-wrap">
        <div class="modal-eyebrow"><i class="fa-solid fa-edit"></i> Revision</div>
        <div class="modal-title">Edit Revisi</div>
        <div class="modal-subtitle">Perbarui catatan revisi untuk konten ini</div>
      </div>
      <button class="modal-close" type="button" onclick="closeModal('editRevisiOverlay')">
        <i class="fa-solid fa-xmark"></i>
      </button>
    </div>
    <div class="modal-body">
      <div class="modal-divider"></div>
      <form id="editRevisiForm" onsubmit="submitEditRevisi(event)" novalidate>
        <div class="form-group">
          <label class="form-label">Pilih Content Task</label>
          <input type="text" id="editRevisiTaskTitle" class="form-input" disabled>
          <input type="hidden" name="content_task_id" id="editRevisiTaskId">
        </div>

        <div class="form-group">
          <label class="form-label">
            Catatan Revisi <span class="required">*</span>
          </label>
          <textarea name="revision_note" id="editRevisiNote" class="form-textarea" placeholder="Tambahkan catatan revisi..." required></textarea>
        </div>

        <div class="form-group">
          <label class="form-label">Deadline Revisi</label>
          <input type="date" name="revision_deadline" id="editRevisiDeadline" class="form-input">
        </div>
      </form>
    </div>
    <div class="modal-footer">
      <div class="mf-left">
        <i class="fa-solid fa-asterisk" style="font-size:8px"></i> Wajib diisi
      </div>
      <div class="mf-right">
        <button class="btn-ghost" type="button" onclick="closeModal('editRevisiOverlay')">Batal</button>
        <button class="btn btn-primary" type="button" onclick="submitEditRevisi(event)">
          <i class="fa-solid fa-edit"></i> Update Revisi
        </button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Upload Hasil Revisi -->
<div class="overlay" id="uploadRevisiOverlay" onclick="closeOnOverlay(event, 'uploadRevisiOverlay')">
  <div class="modal" onclick="event.stopPropagation()">
    <div class="modal-head">
      <div class="modal-title-wrap">
        <div class="modal-eyebrow"><i class="fa-solid fa-cloud-arrow-up"></i> Revision</div>
        <div class="modal-title">Upload Hasil Revisi</div>
        <div class="modal-subtitle">Unggah file video/gambar hasil perbaikan</div>
      </div>
      <button class="modal-close" type="button" onclick="closeModal('uploadRevisiOverlay')">
        <i class="fa-solid fa-xmark"></i>
      </button>
    </div>
    <div class="modal-body">
      <div class="modal-divider"></div>
      <form id="uploadRevisiForm" onsubmit="submitUploadRevisi(event)" novalidate>
        <div class="form-group">
          <label class="form-label">Tugas Konten</label>
          <input type="text" id="uploadRevisiTaskTitle" class="form-input" disabled>
          <input type="hidden" name="content_task_id" id="uploadRevisiTaskId">
        </div>

        <div class="form-group">
          <label class="form-label">
            Upload Media Revisi <span class="required">*</span>
          </label>
          <div class="file-drop-zone" id="revDropZone" onclick="document.getElementById('revFileInput').click()">
            <input type="file" name="video_file" id="revFileInput" style="display:none" accept="video/*,image/*" required onchange="handleRevFileSelect(this)">
            <i class="fa-solid fa-cloud-arrow-up"></i>
            <div class="file-drop-name" id="revFileName">Klik atau seret file ke sini</div>
            <div class="file-drop-hint">Video atau Gambar (Maks 500MB)</div>
          </div>
          
          <div class="progress-container" id="revProgressContainer">
            <div class="progress-bar-wrap">
              <div class="progress-bar-fill" id="revProgressBar"></div>
            </div>
            <div class="progress-text" id="revProgressText">0%</div>
          </div>
        </div>
      </form>
    </div>
    <div class="modal-footer">
      <div class="mf-left">
        <i class="fa-solid fa-asterisk" style="font-size:8px"></i> Wajib diisi
      </div>
      <div class="mf-right">
        <button class="btn-ghost" type="button" onclick="closeModal('uploadRevisiOverlay')">Batal</button>
        <button class="btn btn-primary" type="button" onclick="submitUploadRevisi(event)">
          <i class="fa-solid fa-upload"></i> Upload Revisi
        </button>
      </div>
    </div>
  </div>
</div>

<!-- Preview Video Modal -->
<div class="overlay" id="previewOverlay" onclick="closeOnOverlay(event, 'previewOverlay')">
  <div class="modal" onclick="event.stopPropagation()" style="max-width: 800px;">
    <div class="modal-head">
      <div class="modal-title">Preview Video Produksi</div>
      <button class="modal-close" onclick="closeModal('previewOverlay')">
        <i class="fa-solid fa-xmark"></i>
      </button>
    </div>
    <div class="modal-body">
      <div class="modal-divider"></div>
      <div id="previewContent">
        <!-- Video preview content will be inserted here -->
      </div>
    </div>
    <div class="modal-footer">
      <button class="btn-ghost" onclick="closeModal('previewOverlay')">Tutup</button>
    </div>
  </div>
</div>

<!-- Download Confirmation Modal -->
<div class="overlay" id="downloadOverlay" onclick="closeOnOverlay(event, 'downloadOverlay')">
  <div class="modal" onclick="event.stopPropagation()">
    <div class="modal-head">
      <div class="modal-title-wrap">
        <div class="modal-eyebrow"><i class="fa-solid fa-download"></i> Download</div>
        <div class="modal-title">Download Video</div>
        <div class="modal-subtitle">Konfirmasi download video produksi</div>
      </div>
      <button class="modal-close" type="button" onclick="closeModal('downloadOverlay')">
        <i class="fa-solid fa-xmark"></i>
      </button>
    </div>
    <div class="modal-body">
      <div class="modal-divider"></div>
      <div id="downloadContent">
        <!-- Content will be filled by JavaScript -->
      </div>
    </div>
    <div class="modal-footer">
      <div class="mf-left">
        <i class="fa-solid fa-info-circle" style="font-size:8px"></i> Video akan diunduh ke perangkat Anda
      </div>
      <div class="mf-right">
        <button class="btn-ghost" type="button" onclick="closeModal('downloadOverlay')">Batal</button>
        <button class="btn btn-primary" type="button" onclick="confirmDownload()">
          <i class="fa-solid fa-download"></i> Download
        </button>
      </div>
    </div>
  </div>
</div>

<!-- Send To Approval Confirmation Modal -->
<div class="overlay" id="sendApprovalOverlay" onclick="closeOnOverlay(event, 'sendApprovalOverlay')">
  <div class="modal" onclick="event.stopPropagation()">
    <div class="modal-head">
      <div class="modal-title-wrap">
        <div class="modal-eyebrow"><i class="fa-solid fa-circle-check"></i> Approval</div>
        <div class="modal-title">Kirim ke Approval</div>
        <div class="modal-subtitle">Konten akan dipindahkan ke tahap approval</div>
      </div>
      <button class="modal-close" type="button" onclick="closeModal('sendApprovalOverlay')">
        <i class="fa-solid fa-xmark"></i>
      </button>
    </div>
    <div class="modal-body">
      <div class="modal-divider"></div>
      <div id="sendApprovalContent"></div>
    </div>
    <div class="modal-footer">
      <div class="mf-left">
        <i class="fa-solid fa-info-circle" style="font-size:8px"></i> Konten akan dipindahkan ke menu Approval
      </div>
      <div class="mf-right">
        <button class="btn-ghost" type="button" onclick="closeModal('sendApprovalOverlay')">Batal</button>
        <button class="btn btn-primary" type="button" onclick="confirmSendToApproval(event)">
          <i class="fa-solid fa-circle-check"></i> Kirim ke Approval
        </button>
      </div>
    </div>
  </div>
</div>

<!-- Notify Creator Modal -->
<div class="overlay" id="notifyCreatorOverlay" onclick="closeOnOverlay(event, 'notifyCreatorOverlay')">
  <div class="modal" onclick="event.stopPropagation()">
    <div class="modal-head">
      <div class="modal-title-wrap">
        <div class="modal-eyebrow"><i class="fa-solid fa-paper-plane"></i> Email Notification</div>
        <div class="modal-title">Kirim Notifikasi Revisi</div>
        <div class="modal-subtitle">Kreator akan menerima email berisi detail revisi</div>
      </div>
      <button class="modal-close" type="button" onclick="closeModal('notifyCreatorOverlay')">
        <i class="fa-solid fa-xmark"></i>
      </button>
    </div>
    <div class="modal-body">
      <div class="modal-divider"></div>
      <div style="text-align: center; padding: 10px 0;">
        <div style="width: 60px; height: 60px; background: rgba(139, 92, 246, 0.1); color: var(--violet); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 24px; margin: 0 auto 16px;">
          <i class="fa-solid fa-envelope-open-text"></i>
        </div>
        <p style="font-size: 14px; color: var(--text-700); line-height: 1.5; margin-bottom: 8px;">
          Anda akan mengirimkan notifikasi email kepada kreator untuk konten:
        </p>
        <p id="notifyTaskTitle" style="font-weight: 700; color: var(--text-900); font-size: 15px;"></p>
      </div>
    </div>
    <div class="modal-footer">
      <div class="mf-left">
        <i class="fa-solid fa-info-circle" style="font-size:8px"></i> Pastikan catatan revisi sudah benar
      </div>
      <div class="mf-right">
        <button class="btn-ghost" type="button" onclick="closeModal('notifyCreatorOverlay')">Batal</button>
        <button class="btn btn-primary" id="btnConfirmNotify" type="button" style="background: var(--violet); border: none;">
          <i class="fa-solid fa-paper-plane"></i> Kirim Sekarang
        </button>
      </div>
    </div>
  </div>
</div>

@endsection

@push('scripts')
<script>
let pendingApprovalTaskId = null;

function openBeriRevisiModal(taskId, taskTitle) {
  document.getElementById('beriRevisiTaskId').value = taskId;
  document.getElementById('beriRevisiTaskTitle').value = taskTitle;
  document.getElementById('beriRevisiOverlay').classList.add('open');
}

function openEditRevisiModal(taskId, taskTitle, revisionNote, revisionDeadline) {
  document.getElementById('editRevisiTaskId').value = taskId;
  document.getElementById('editRevisiTaskTitle').value = taskTitle;
  document.getElementById('editRevisiNote').value = revisionNote;
  document.getElementById('editRevisiDeadline').value = revisionDeadline;
  document.getElementById('editRevisiOverlay').classList.add('open');
}

function openUploadRevisiModal(taskId, taskTitle) {
  document.getElementById('uploadRevisiTaskId').value = taskId;
  document.getElementById('uploadRevisiTaskTitle').value = taskTitle;
  document.getElementById('revFileName').textContent = 'Klik atau seret file ke sini';
  document.getElementById('revProgressContainer').style.display = 'none';
  document.getElementById('uploadRevisiOverlay').classList.add('open');
}

function handleRevFileSelect(input) {
  const nameEl = document.getElementById('revFileName');
  if (input.files && input.files[0]) {
    nameEl.textContent = input.files[0].name;
    nameEl.style.color = 'var(--blue)';
  }
}

// Drag and Drop support
document.addEventListener('DOMContentLoaded', () => {
  const dropZone = document.getElementById('revDropZone');
  if (dropZone) {
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(name => {
      dropZone.addEventListener(name, e => {
        e.preventDefault();
        e.stopPropagation();
      });
    });

    dropZone.addEventListener('dragenter', () => dropZone.classList.add('dragover'));
    dropZone.addEventListener('dragover', () => dropZone.classList.add('dragover'));
    dropZone.addEventListener('dragleave', () => dropZone.classList.remove('dragover'));
    dropZone.addEventListener('drop', e => {
      dropZone.classList.remove('dragover');
      const files = e.dataTransfer.files;
      if (files.length > 0) {
        const input = document.getElementById('revFileInput');
        input.files = files;
        handleRevFileSelect(input);
      }
    });
  }
});

let pendingNotifyTaskId = null;

function notifyRevision(taskId, taskTitle) {
  pendingNotifyTaskId = taskId;
  document.getElementById('notifyTaskTitle').textContent = taskTitle;
  document.getElementById('notifyCreatorOverlay').classList.add('open');
  
  // Set up click handler for confirm button
  const btn = document.getElementById('btnConfirmNotify');
  btn.onclick = () => confirmNotifyRevision();
}

function confirmNotifyRevision() {
  if (!pendingNotifyTaskId) return;

  const btn = document.getElementById('btnConfirmNotify');
  const originalHtml = btn.innerHTML;
  btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Mengirim...';
  btn.disabled = true;

  fetch(`/admin/revision/${pendingNotifyTaskId}/notify`, {
    method: 'POST',
    headers: {
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
      'Accept': 'application/json'
    }
  })
  .then(res => res.json())
  .then(data => {
    if (data.success) {
      closeModal('notifyCreatorOverlay');
      toast('s', data.message);
      if (data.mail_hint) {
        setTimeout(() => toast('w', data.mail_hint), 1000);
      }
    } else {
      toast('e', data.message);
    }
  })
  .catch(err => {
    console.error(err);
    toast('e', 'Terjadi kesalahan jaringan.');
  })
  .finally(() => {
    btn.innerHTML = originalHtml;
    btn.disabled = false;
    pendingNotifyTaskId = null;
  });
}

function submitUploadRevisi(event) {
  event.preventDefault();
  const form = document.getElementById('uploadRevisiForm');
  const formData = new FormData(form);
  const btn = document.querySelector('#uploadRevisiOverlay .btn-primary');
  
  const fileInput = document.getElementById('revFileInput');
  if (!fileInput.files[0]) {
    toast('w', 'Silakan pilih file terlebih dahulu');
    return;
  }

  const originalHtml = btn.innerHTML;
  btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Mengunggah...';
  btn.disabled = true;

  const progressContainer = document.getElementById('revProgressContainer');
  const progressBar = document.getElementById('revProgressBar');
  const progressText = document.getElementById('revProgressText');
  
  progressContainer.style.display = 'block';

  const xhr = new XMLHttpRequest();
  xhr.open('POST', '{{ route("revision.upload") }}', true);
  xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
  xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
  xhr.setRequestHeader('Accept', 'application/json');

  xhr.upload.onprogress = function(e) {
    if (e.lengthComputable) {
      const percent = Math.round((e.loaded / e.total) * 100);
      progressBar.style.width = percent + '%';
      progressText.textContent = percent + '%';
    }
  };

  xhr.onload = function() {
    let res;
    try {
      res = JSON.parse(xhr.responseText);
    } catch(e) {
      res = { success: false, message: 'Server error' };
    }

    if (xhr.status >= 200 && xhr.status < 300 && res.success) {
      toast('s', res.message);
      setTimeout(() => window.location.reload(), 1500);
    } else {
      toast('e', res.message || 'Gagal mengunggah');
      btn.innerHTML = originalHtml;
      btn.disabled = false;
    }
  };

  xhr.onerror = function() {
    toast('e', 'Koneksi terputus saat upload.');
    btn.innerHTML = originalHtml;
    btn.disabled = false;
  };

  xhr.send(formData);
}

function closeModal(modalId) {
  document.getElementById(modalId).classList.remove('open');
  if (modalId === 'sendApprovalOverlay') {
    pendingApprovalTaskId = null;
  }
  if (modalId === 'notifyCreatorOverlay') {
    pendingNotifyTaskId = null;
  }
  resetForm(modalId);
}

function closeOnOverlay(event, modalId) {
  if (event.target === event.currentTarget) {
    closeModal(modalId);
  }
}

function resetForm(modalId) {
  const formId = modalId === 'beriRevisiOverlay' ? 'beriRevisiForm' : 'editRevisiForm';
  const form = document.getElementById(formId);
  if (form) {
    form.reset();
  }
}

function submitBeriRevisi(event) {
  event.preventDefault();

  const form = document.getElementById('beriRevisiForm');
  const formData = new FormData(form);

  const contentTaskId = formData.get('content_task_id');
  const revisionNote = formData.get('revision_note');

  if (!contentTaskId || !revisionNote) {
    alert('Mohon lengkapi semua field yang wajib diisi');
    return;
  }

  const submitBtn = event.target;
  const originalText = submitBtn.innerHTML;
  submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Menyimpan...';
  submitBtn.disabled = true;

  formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));

  fetch('{{ route("revision.request-revision") }}', {
    method: 'POST',
    headers: {
      'X-Requested-With': 'XMLHttpRequest',
      'Accept': 'application/json'
    },
    body: formData
  })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        toast('s', data.message || 'Revisi berhasil disimpan');
        setTimeout(() => window.location.reload(), 1500);
      } else {
        toast('e', 'Gagal memberi revisi: ' + (data.message || 'Terjadi kesalahan'));
      }
    })
    .catch(error => {
      console.error('Revision error:', error);
      toast('e', 'Terjadi kesalahan saat memberi revisi. Silakan coba lagi.');
    })
    .finally(() => {
      submitBtn.innerHTML = originalText;
      submitBtn.disabled = false;
    });
}

function submitEditRevisi(event) {
  event.preventDefault();

  const form = document.getElementById('editRevisiForm');
  const formData = new FormData(form);

  const contentTaskId = formData.get('content_task_id');
  const revisionNote = formData.get('revision_note');

  if (!contentTaskId || !revisionNote) {
    alert('Mohon lengkapi semua field yang wajib diisi');
    return;
  }

  const submitBtn = event.target;
  const originalText = submitBtn.innerHTML;
  submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Memperbarui...';
  submitBtn.disabled = true;

  formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));

  fetch('{{ route("revision.update-revision") }}', {
    method: 'POST',
    headers: {
      'X-Requested-With': 'XMLHttpRequest',
      'Accept': 'application/json'
    },
    body: formData
  })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        toast('s', data.message || 'Revisi berhasil diperbarui');
        setTimeout(() => window.location.reload(), 1500);
      } else {
        toast('e', 'Gagal memperbarui revisi: ' + (data.message || 'Terjadi kesalahan'));
      }
    })
    .catch(error => {
      console.error('Revision update error:', error);
      toast('e', 'Terjadi kesalahan saat memperbarui revisi.');
    })
    .finally(() => {
      submitBtn.innerHTML = originalText;
      submitBtn.disabled = false;
    });
}

function openSendApprovalModal(taskId, taskTitle) {
  if (!taskId) return;
  pendingApprovalTaskId = taskId;

  const content = `
    <div style="padding: 16px; background: var(--bg); border-radius: 8px; margin-bottom: 16px;">
      <div style="font-weight: 600; color: var(--text-900); margin-bottom: 4px;">${taskTitle || '-'}</div>
      <div style="font-size: 12px; color: var(--text-500);">ID: #${taskId}</div>
    </div>
    <p style="font-size: 14px; color: var(--text-700); margin: 0;">
      Kirim konten ini ke Approval? Konten akan langsung masuk ke halaman Publishing.
    </p>
  `;

  document.getElementById('sendApprovalContent').innerHTML = content;
  document.getElementById('sendApprovalOverlay').classList.add('open');
}

function confirmSendToApproval(event) {
  if (!pendingApprovalTaskId) return;

  const submitBtn = event.target;
  const originalText = submitBtn.innerHTML;
  submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Mengirim...';
  submitBtn.disabled = true;

  fetch('{{ route("revision.send-to-approval") }}', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
      'Accept': 'application/json'
    },
    body: JSON.stringify({ ids: [pendingApprovalTaskId] })
  })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        closeModal('sendApprovalOverlay');
        pendingApprovalTaskId = null;
        toast('s', data.message || 'Konten dikirim ke Approval');
        setTimeout(() => window.location.reload(), 1500);
      } else {
        toast('e', 'Gagal mengirim ke Approval: ' + (data.message || 'Terjadi kesalahan'));
      }
    })
    .catch(error => {
      console.error('Send to approval error:', error);
      toast('e', 'Terjadi kesalahan saat mengirim ke Approval.');
    })
    .finally(() => {
      submitBtn.innerHTML = originalText;
      submitBtn.disabled = false;
    });
}

let currentDownloadUrl = null;
const downloadBaseUrl = '{{ url('/admin/production/download') }}';

function openDownloadModal(productionId, taskTitle, videoFile) {
  currentDownloadUrl = downloadBaseUrl + '/' + productionId;
  
  const content = `
    <div style="padding: 16px; background: var(--bg); border-radius: 8px; margin-bottom: 16px;">
      <div style="font-weight: 600; color: var(--text-900); margin-bottom: 4px;">${taskTitle}</div>
      <div style="font-size: 12px; color: var(--text-500);">Production ID: #${productionId}</div>
      <div style="font-size: 12px; color: var(--text-500); margin-top: 4px;">File: ${videoFile}</div>
    </div>
    <p style="font-size: 14px; color: var(--text-700); margin: 0;">
      Apakah Anda yakin ingin mengunduh video ini?
    </p>
  `;
  
  document.getElementById('downloadContent').innerHTML = content;
  document.getElementById('downloadOverlay').classList.add('open');
}

function confirmDownload() {
  if (!currentDownloadUrl) return;
  
  // Create a temporary link to trigger download
  const link = document.createElement('a');
  link.href = currentDownloadUrl;
  link.download = ''; // Let the server set the filename
  document.body.appendChild(link);
  link.click();
  document.body.removeChild(link);
  
  // Close modal after download starts
  closeModal('downloadOverlay');
  currentDownloadUrl = null;
}

function previewVideo(productionId, taskTitle, videoFile) {
  const previewContent = document.getElementById('previewContent');
  
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
  
  // Open modal
  document.getElementById('previewOverlay').classList.add('open');
}
</script>
@endpush
