@extends('layouts.admin')

@section('page-title', 'Production')

@push('styles')
<style>
/* ═══════════════════════════════════════
   DESIGN SYSTEM - Consistent with Brand Management
═══════════════════════════════════════ */
:root {
  --blue:         #5897fe;
  --blue-600:     #3a7bfe;
  --blue-700:     #2563eb;
  --blue-50:      #eff6ff;
  --blue-100:     #dbeafe;
  --blue-200:     #bfdbfe;

  --white:        #ffffff;
  --bg:           #f4f7fe;
  --border:       #e8eef9;
  --border-light: #f0f5ff;

  --text-900:     #0d1526;
  --text-700:     #2d3f5e;
  --text-500:     #5c7099;
  --text-400:     #8fa3c4;
  --text-300:     #b8cae4;

  --orange:       #ff7849;
  --violet:       #8b5cf6;
  --emerald:      #10b981;
  --rose:         #f43f5e;
  --amber:        #f59e0b;

  --r:            16px;
  --r-sm:         10px;

  --s1: 0 1px 3px rgba(13,21,38,.05), 0 4px 16px rgba(88,151,254,.06);
  --s2: 0 4px 24px rgba(88,151,254,.13);

  --t: .2s cubic-bezier(.4,0,.2,1);
}

/* Header & actions - Consistent with Brand Management */
.page-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 16px;
}
.page-header-title {
  font-family: 'DM Sans', sans-serif;
  font-size: 22px;
  font-weight: 800;
  letter-spacing: -.5px;
  color: var(--text-900);
}
.page-subtitle {
  font-family: 'DM Sans', sans-serif;
  font-size: 13px;
  color: var(--text-400);
  margin-top: 2px;
}

/* Buttons - Consistent with Brand Management */
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
.btn-primary:active {
  transform: scale(.97);
}
.btn-ghost {
  background: var(--white);
  color: var(--text-500);
  border: 1.5px solid var(--border);
}
.btn-ghost:hover {
  background: var(--blue-50);
  color: var(--blue);
  border-color: var(--blue-200);
}
.btn-danger {
  background: rgba(244,63,94,.08);
  color: var(--rose);
  border: 1.5px solid rgba(244,63,94,.18);
}
.btn-danger:hover {
  background: rgba(244,63,94,.15);
}

/* Section headers - Consistent with Brand Management */
.sec-head {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 16px;
}
.sec-title {
  font-family: 'DM Sans', sans-serif;
  font-size: 16px;
  font-weight: 700;
  color: var(--text-900);
  display: flex;
  align-items: center;
  gap: 8px;
}
.sec-title i {
  color: var(--blue);
  font-size: 14px;
}
.sec-head-compact {
  margin-bottom: 0;
}

/* Table overflow fixes - Consistent with Brand Management */
.tbl-card {
  overflow-x: auto;
}
.tbl-card table {
  width: 1170px;
  table-layout: fixed;
  min-width: 100%;
  border-collapse: collapse;
}
.tbl-card thead th {
  font-family: 'DM Sans', sans-serif;
  font-size: 11px;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: .65px;
  color: var(--text-300);
  padding: 12px 16px;
  text-align: left;
  background: var(--bg);
  border-bottom: 1px solid var(--border);
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}
.tbl-card tbody tr {
  border-bottom: 1px solid var(--border-light);
  transition: var(--t);
}
.tbl-card tbody tr:last-child {
  border-bottom: none;
}
.tbl-card tbody tr:hover {
  background: var(--blue-50);
}
.tbl-card tbody td {
  font-family: 'DM Sans', sans-serif;
  font-size: 13px;
  color: var(--text-700);
  padding: 14px 16px;
  vertical-align: middle;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}
.tbl-card .action-buttons {
  min-width: 140px;
  display: flex;
  gap: 5px;
  flex-wrap: nowrap;
}

/* Table cell styles - Consistent with Brand Management */
.td-name {
  font-family: 'DM Sans', sans-serif;
  font-size: 13.5px;
  font-weight: 700;
  color: var(--text-900);
}
.td-brand {
  font-family: 'DM Sans', sans-serif;
  font-size: 13px;
  font-weight: 500;
  color: var(--text-700);
}
.td-version {
  font-family: 'DM Sans', sans-serif;
  font-size: 12.5px;
  font-weight: 600;
  color: var(--text-500);
}
.td-duration {
  font-family: 'DM Sans', sans-serif;
  font-size: 12.5px;
  color: var(--text-500);
}

/* Action buttons - Consistent with Brand Management */
.action-buttons {
  display: flex;
  align-items: center;
  gap: 5px;
}
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
  font-size: 12px;
}
.btn-action:hover {
  background: var(--blue);
  color: white;
  border-color: var(--blue);
  transform: translateY(-1px);
}
.btn-action.btn-download:hover {
  background: rgba(16,185,129,.90);
  border-color: var(--emerald);
}
.btn-action.btn-upload:hover {
  background: rgba(245,158,11,.90);
  border-color: var(--amber);
}

/* Modal - Consistent with Brand Management */
.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(13,21,38,.4);
  backdrop-filter: blur(4px);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 9999;
  opacity: 0;
  visibility: hidden;
  transition: var(--t);
}
.modal-overlay.show {
  opacity: 1;
  visibility: visible;
}
.modal {
  background: var(--white);
  border-radius: var(--r);
  box-shadow: var(--s2);
  max-width: 500px;
  width: 90%;
  max-height: 90vh;
  overflow-y: auto;
  transform: scale(.95) translateY(20px);
  transition: var(--t);
}
.modal-overlay.show .modal {
  transform: scale(1) translateY(0);
}
.modal-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 20px 24px 16px;
  border-bottom: 1px solid var(--border-light);
}
.modal-eyebrow {
  font-family: 'DM Sans', sans-serif;
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
  font-family: 'DM Sans', sans-serif;
  font-size: 20px;
  font-weight: 800;
  color: var(--text-900);
  letter-spacing: -.4px;
}
.modal-subtitle {
  font-family: 'DM Sans', sans-serif;
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
  margin: 20px 0;
}

/* Form - Consistent with Brand Management */
.form-group {
  margin-bottom: 20px;
}
.form-label {
  font-family: 'DM Sans', sans-serif;
  font-size: 13px;
  font-weight: 600;
  color: var(--text-700);
  margin-bottom: 8px;
  display: block;
}
.form-input {
  width: 100%;
  padding: 10px 14px;
  border: 1.5px solid var(--border);
  border-radius: var(--r-sm);
  font-family: 'DM Sans', sans-serif;
  font-size: 13px;
  color: var(--text-900);
  background: var(--white);
  transition: var(--t);
}
.form-input:focus {
  outline: none;
  border-color: var(--blue);
  box-shadow: 0 0 0 3px rgba(88,151,254,.1);
}
.form-input::placeholder {
  color: var(--text-400);
}
.form-select {
  width: 100%;
  padding: 10px 14px;
  border: 1.5px solid var(--border);
  border-radius: var(--r-sm);
  font-family: 'DM Sans', sans-serif;
  font-size: 13px;
  color: var(--text-900);
  background: var(--white);
  transition: var(--t);
  cursor: pointer;
}
.form-select:focus {
  outline: none;
  border-color: var(--blue);
  box-shadow: 0 0 0 3px rgba(88,151,254,.1);
}

/* Empty state - Consistent with Brand Management */
.empty-state {
  text-align: center;
  padding: 48px 24px;
}
.empty-state-content {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 8px;
}
.empty-state i {
  font-size: 48px;
  opacity: 0.3;
  color: var(--text-400);
}
.empty-title {
  font-family: 'DM Sans', sans-serif;
  font-size: 16px;
  font-weight: 600;
  color: var(--text-500);
}
.empty-desc {
  font-family: 'DM Sans', sans-serif;
  font-size: 13px;
  color: var(--text-400);
}

/* Pill styles */
.pill {
  display: inline-flex;
  align-items: center;
  gap: 4px;
  font-family: 'DM Sans', sans-serif;
  font-size: 10px;
  font-weight: 700;
  padding: 4px 8px;
  border-radius: 99px;
  white-space: nowrap;
}
.pill-dot {
  width: 4px;
  height: 4px;
  border-radius: 50%;
}

/* Text muted */
.text-muted {
  color: var(--text-400);
  font-size: 12px;
}

/* Table notes */
.td-notes {
  font-size: 12px;
  color: var(--text-500);
}

/* Responsive - Consistent with Brand Management */
@media (max-width: 768px) {
  .page-header {
    flex-direction: column;
    align-items: flex-start;
    gap: 12px;
  }
  .sec-head {
    flex-direction: column;
    align-items: flex-start;
    gap: 12px;
  }
  .tbl-card {
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
  }
  .modal {
    width: 95%;
    margin: 20px;
  }
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
.p-pending {
  background: rgba(239, 68, 68, 0.1);
  color: #ef4444;
  border: 1px solid rgba(239, 68, 68, 0.2);
}
.p-pending .pill-dot {
  background: #ef4444;
}

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

/* New status styles */
.p-approved {
  background: rgba(34, 197, 94, 0.1);
  color: #22c55e;
  border: 1px solid rgba(34, 197, 94, 0.2);
}
.p-approved .pill-dot {
  background: #22c55e;
}

.p-revision {
  background: rgba(245, 158, 11, 0.1);
  color: #f59e0b;
  border: 1px solid rgba(245, 158, 11, 0.2);
}
.p-revision .pill-dot {
  background: #f59e0b;
}

.p-rejected {
  background: rgba(239, 68, 68, 0.1);
  color: #ef4444;
  border: 1px solid rgba(239, 68, 68, 0.2);
}
.p-rejected .pill-dot {
  background: #ef4444;
}

/* Action button styles */
.btn-action.btn-revision {
  background: rgba(245, 158, 11, 0.1);
  color: #f59e0b;
  border-color: rgba(245, 158, 11, 0.2);
}
.btn-action.btn-revision:hover {
  background: #f59e0b;
  color: #fff;
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
    <div class="stat-lbl">In Production</div>
  </div>
  <div class="stat-card sc-amb" style="--i:2">
    <div class="stat-ic"><i class="fa-solid fa-eye"></i></div>
    <div class="stat-val">{{ $stats['under_review'] ?? 0 }}</div>
    <div class="stat-lbl">Under Review</div>
  </div>
  <div class="stat-card sc-em" style="--i:3">
    <div class="stat-ic"><i class="fa-solid fa-paper-plane"></i></div>
    <div class="stat-val">{{ $stats['ready_to_publish'] ?? 0 }}</div>
    <div class="stat-lbl">Ready to Publish</div>
  </div>
</div>

<div class="card tbl-card">
  <div class="sec-head sec-head-compact">
    <div class="sec-title">
      <i class="fa-solid fa-film"></i>
      Daftar Production
    </div>
    <button class="btn btn-primary" onclick="openUploadModal()">
      <i class="fa-solid fa-plus"></i> Upload Video Produksi
    </button>
  </div>
  <table>
    <thead>
      <tr>
        <th style="width: 50px;">ID</th>
        <th style="width: 180px;">Nama Brief</th>
        <th style="width: 180px;">Nama Task</th>
        <th style="width: 120px;">File</th>
        <th style="width: 100px;">Status</th>
        <th style="width: 120px;">Tanggal Upload</th>
        <th style="width: 100px;">Aksi</th>
      </tr>
    </thead>
    <tbody>
      @forelse($productions as $index => $production)
        @php
          $statusMap = [
            'production' => ['label' => 'Production', 'class' => 'p-in-production'],
            'pending' => ['label' => 'Pending', 'class' => 'p-pending'],
            'in_review' => ['label' => 'In Review', 'class' => 'p-under-review'],
            'need_revision' => ['label' => 'Need Revision', 'class' => 'p-revision'],
            'ready_to_publish' => ['label' => 'Ready to Publish', 'class' => 'p-ready-to-publish'],
            'published' => ['label' => 'Published', 'class' => 'p-published'],
            'under_review' => ['label' => 'Under Review', 'class' => 'p-under-review'],
            'approved' => ['label' => 'Approved', 'class' => 'p-approved'],
            'revision' => ['label' => 'Need Revision', 'class' => 'p-revision'],
            'rejected' => ['label' => 'Rejected', 'class' => 'p-rejected'],
          ];
          $s = $statusMap[$production->status] ?? ['label' => ucfirst($production->status), 'class' => 'p-prod'];
          $rowNumber = $index + 1;
        @endphp
        <tr>
          <td>{{ $rowNumber }}</td>
          <td>
            <span class="td-name">{{ optional($production->brief)->title ?? '-' }}</span>
          </td>
          <td>
            <span class="td-brand">{{ optional($production->simpleTask)->title ?? optional($production->task)->judul_konten ?? '-' }}</span>
          </td>
          <td>
            @if($production->file_video)
              <span class="td-file"><i class="fa-solid fa-video"></i> Video</span>
            @else
              <span class="text-muted">-</span>
            @endif
          </td>
          <td>
            <span class="pill {{ $s['class'] }}">
              <span class="pill-dot"></span>
              {{ $s['label'] }}
            </span>
          </td>
          <td>{{ $production->created_at->format('d M Y H:i') }}</td>
          <td>
            <div class="action-buttons">
              @if($production->file_video)
                <button class="btn-action" onclick="previewVideo({{ $production->id }})" title="Preview">
                  <i class="fa-solid fa-eye"></i>
                </button>
                <a href="{{ route('production.download', $production->id) }}" class="btn-action" title="Download">
                  <i class="fa-solid fa-download"></i>
                </a>
                <button type="button" class="btn-action btn-revision" onclick="openRevisionModal({{ $production->id }}, '{{ addslashes(optional($production->brief)->title ?? 'Production') }}')" title="Revision">
                  <i class="fa-solid fa-rotate-left"></i>
                </button>
              @endif
            </div>
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="7" class="empty-state">
            <div class="empty-state-content">
              <i class="fa-solid fa-film"></i>
              <div class="empty-title">Belum ada production</div>
              <div class="empty-desc">Upload production dari halaman brief publik</div>
            </div>
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
              <div class="file-input-hint">Semua format video yang bisa dipilih di dialog unggah (filter Video)</div>
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
    <div class="modal-head">
      <div class="modal-title-wrap">
        <div class="modal-eyebrow"><i class="fa-solid fa-eye"></i> Preview</div>
        <div class="modal-title" id="previewModalTitle">Video Production</div>
        <div class="modal-subtitle">Preview video yang diupload creator</div>
      </div>
      <button class="modal-close" type="button" onclick="closeModal('previewOverlay')">
        <i class="fa-solid fa-xmark"></i>
      </button>
    </div>
    <div class="modal-body" style="padding: 0;">
      <div id="previewContent" style="background: #000; min-height: 300px; max-height: 500px; display: flex; align-items: center; justify-content: center; overflow: hidden;">
        <!-- Video preview content will be inserted here -->
      </div>
    </div>
    <div class="modal-footer">
      <div class="mf-left">
        <i class="fa-solid fa-info-circle" style="font-size:10px"></i> Video akan diputar otomatis
      </div>
      <div class="mf-right">
        <button class="btn-ghost" type="button" onclick="closeModal('previewOverlay')">Tutup</button>
        <button id="previewDownloadBtn" class="btn btn-primary" style="display: none;">
          <i class="fa-solid fa-download"></i> Download
        </button>
      </div>
    </div>
  </div>
</div>

<!-- Revision Confirmation Modal -->
<div class="overlay" id="revisionOverlay" onclick="closeOnOverlay(event, 'revisionOverlay')">
  <div class="modal" onclick="event.stopPropagation()">
    <div class="modal-head">
      <div class="modal-title-wrap">
        <div class="modal-eyebrow"><i class="fa-solid fa-rotate-left"></i> Revision</div>
        <div class="modal-title">Kirim ke Revisi</div>
        <div class="modal-subtitle">Production membutuhkan perbaikan</div>
      </div>
      <button class="modal-close" type="button" onclick="closeModal('revisionOverlay')">
        <i class="fa-solid fa-xmark"></i>
      </button>
    </div>
    <div class="modal-body" style="text-align:center; padding: 32px;">
      <div style="font-size: 48px; color: #f59e0b; margin-bottom: 16px;">
        <i class="fa-solid fa-exclamation-circle"></i>
      </div>
      <p style="font-size: 16px; color: var(--text-700); margin: 0 0 8px 0; font-weight: 500;" id="revisionProductionTitle">Production Title</p>
      <p style="font-size: 14px; color: var(--text-500); margin: 0;">Apakah Anda yakin ingin mengirim production ini ke revisi?</p>
    </div>
    <div class="modal-footer">
      <div class="mf-left"></div>
      <div class="mf-right">
        <button class="btn-ghost" type="button" onclick="closeModal('revisionOverlay')">Batal</button>
        <form method="POST" action="" id="revisionForm" style="display:inline;">
          @csrf
          <button class="btn btn-warning" type="submit" style="background: #f59e0b; border-color: #f59e0b; color: #fff;">
            <i class="fa-solid fa-rotate-left"></i> Kirim ke Revisi
          </button>
        </form>
      </div>
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
  if (modalId === 'uploadOverlay') {
    resetForm();
  }
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

  const uploadOverlay = document.getElementById('uploadOverlay');
  const submitBtn = uploadOverlay?.querySelector('.mf-right .btn-primary') || event.target;
  const originalText = submitBtn.innerHTML;
  submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Menyiapkan upload...';
  submitBtn.disabled = true;

  const csrfMeta = document.querySelector('meta[name="csrf-token"]');
  const csrfToken = csrfMeta ? csrfMeta.getAttribute('content') : '';
  formData.append('_token', csrfToken);

  const url = '{{ route("production.store") }}';

  // fetch tidak punya progress upload — file video besar terlihat "loading terus".
  const xhr = new XMLHttpRequest();
  xhr.open('POST', url, true);
  xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
  xhr.setRequestHeader('Accept', 'application/json');
  if (csrfToken) {
    xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken);
  }
  xhr.timeout = 0;

  xhr.upload.onprogress = function (e) {
    if (e.lengthComputable && e.total > 0) {
      const pct = Math.min(100, Math.round((e.loaded / e.total) * 100));
      submitBtn.innerHTML = '<i class="fa-solid fa-cloud-arrow-up"></i> Mengupload ' + pct + '%';
    } else {
      submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Mengupload...';
    }
  };

  xhr.onload = function () {
    const contentType = xhr.getResponseHeader('content-type') || '';
    let data = null;
    if (contentType.includes('application/json')) {
      try {
        data = JSON.parse(xhr.responseText);
      } catch (err) {
        console.error('Invalid JSON response', err);
      }
    }

    if (xhr.status >= 200 && xhr.status < 300 && data && data.success) {
      closeModal('uploadOverlay');
      window.location.reload();
      return;
    }

    if (data && data.message) {
      alert('Upload gagal: ' + data.message);
    } else if (xhr.status === 413) {
      alert('File terlalu besar untuk server (413). Naikkan post_max_size & upload_max_filesize di php.ini (atau public/.user.ini), dan di Nginx: client_max_body_size — lihat deploy/nginx-upload-limits.conf.');
    } else if (!contentType.includes('application/json') && xhr.responseText) {
      console.error('Server returned non-JSON:', xhr.responseText.substring(0, 300));
      alert('Server mengembalikan halaman error (bukan JSON). Cek log server atau ukuran/time limit upload.');
    } else {
      alert('Upload gagal (HTTP ' + xhr.status + '). Coba lagi atau periksa koneksi.');
    }

    submitBtn.innerHTML = originalText;
    submitBtn.disabled = false;
  };

  xhr.onerror = function () {
    alert('Koneksi terputus saat upload. Periksa jaringan atau coba file lebih kecil.');
    submitBtn.innerHTML = originalText;
    submitBtn.disabled = false;
  };

  xhr.onabort = function () {
    submitBtn.innerHTML = originalText;
    submitBtn.disabled = false;
  };

  xhr.send(formData);
}

function openRevisionModal(productionId, productionTitle) {
  const form = document.getElementById('revisionForm');
  const titleEl = document.getElementById('revisionProductionTitle');
  
  // Set form action
  form.action = `/admin/production/${productionId}/revision`;
  
  // Set title
  if (titleEl) {
    titleEl.textContent = productionTitle;
  }
  
  // Open modal
  document.getElementById('revisionOverlay').classList.add('open');
}

function previewVideo(productionId) {
  const previewContent = document.getElementById('previewContent');
  const downloadBtn = document.getElementById('previewDownloadBtn');
  const modalTitle = document.getElementById('previewModalTitle');
  
  // Show loading
  previewContent.innerHTML = '<div style="text-align:center;padding:40px;color:#fff;"><i class="fa-solid fa-spinner fa-spin"></i> Loading...</div>';
  document.getElementById('previewOverlay').classList.add('open');
  
  // Fetch production data
  fetch(`/admin/production/preview/${productionId}`)
    .then(res => res.json())
    .then(data => {
      if (data.error) {
        previewContent.innerHTML = `<div style="text-align:center;padding:40px;color:#ef4444;"><i class="fa-solid fa-exclamation-circle"></i> ${data.error}</div>`;
        downloadBtn.style.display = 'none';
        return;
      }
      
      // Update modal title
      if (modalTitle) {
        modalTitle.textContent = data.title;
      }
      
      // Create preview content based on file type
      console.log('File path:', data.file_path, 'Is video:', data.is_video);
      
      let mediaHtml = '';
      if (data.is_video) {
        mediaHtml = `<video id="previewVideo" controls autoplay muted playsinline preload="metadata" style="max-width: 100%; max-height: 500px; width: 100%; height: auto; background: #000;" crossorigin="anonymous">
          <source src="${data.file_path}" type="video/mp4">
          Browser Anda tidak mendukung video player.
        </video>`;
      } else if (data.is_image) {
        mediaHtml = `<img src="${data.file_path}" style="max-width: 100%; max-height: 500px; width: 100%; object-fit: contain;" alt="${data.file_name}" crossorigin="anonymous">`;
      } else {
        mediaHtml = `<div style="text-align:center;padding:40px;color:#fff;"><i class="fa-solid fa-file"></i> ${data.file_name}</div>`;
      }
      
      previewContent.innerHTML = mediaHtml;
      
      // Explicitly play video after DOM insertion
      if (data.is_video) {
        const video = document.getElementById('previewVideo');
        if (video) {
          video.muted = true;
          video.volume = 0;
          
          video.addEventListener('canplay', () => {
            console.log('Video can play, attempting autoplay');
            video.play().catch(e => console.log('Play failed:', e));
          }, { once: true });
          
          video.addEventListener('loadedmetadata', () => {
            console.log('Metadata loaded, duration:', video.duration);
            video.play().catch(e => console.log('Metadata play failed:', e));
          }, { once: true });
          
          video.addEventListener('error', (e) => {
            console.error('Video error:', e, video.error);
          });
        }
      }
      
      // Setup download button
      downloadBtn.style.display = 'inline-flex';
      downloadBtn.onclick = function() {
        window.location.href = `/admin/production/download/${productionId}`;
      };
    })
    .catch(err => {
      previewContent.innerHTML = `<div style="text-align:center;padding:40px;color:#ef4444;"><i class="fa-solid fa-exclamation-circle"></i> Gagal memuat preview</div>`;
      downloadBtn.style.display = 'none';
    });
}

</script>
@endpush
