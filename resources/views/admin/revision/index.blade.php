@extends('layouts.admin')

@section('page-title','Revision')

@section('content')

<!-- ── 1. HEADER SECTION ── -->
<div>
  <div class="sec-head">
    <div class="sec-title">
      <i class="fa-solid fa-rotate-left"></i>
      Revision
    </div>
    <button class="btn-primary" onclick="showApproveModal()">
      <i class="fa-solid fa-check"></i>
      Approve Selected
    </button>
  </div>
  <div class="page-subtitle">
    Review dan revisi konten yang perlu diperbaiki
  </div>
</div>

<!-- ── 2. REVISION STATISTICS ── -->
<div>
  <div class="stat-row">
    <div class="stat-card sc-red" style="--i:0">
      <div class="stat-ic"><i class="fa-solid fa-triangle-exclamation"></i></div>
      <div class="stat-val">4</div>
      <div class="stat-lbl">Need Revision</div>
      <div class="stat-trend trend-down"><i class="fa-solid fa-triangle-exclamation"></i> Perlu aksi</div>
    </div>
    <div class="stat-card sc-amb" style="--i:1">
      <div class="stat-ic"><i class="fa-solid fa-clock"></i></div>
      <div class="stat-val">2</div>
      <div class="stat-lbl">In Review</div>
      <div class="stat-trend trend-warn"><i class="fa-solid fa-hourglass-half"></i> Menunggu</div>
    </div>
    <div class="stat-card sc-em" style="--i:2">
      <div class="stat-ic"><i class="fa-solid fa-check"></i></div>
      <div class="stat-val">8</div>
      <div class="stat-lbl">Revised Today</div>
      <div class="stat-trend trend-up"><i class="fa-solid fa-arrow-trend-up"></i> +3 hari ini</div>
    </div>
  </div>
</div>

<!-- ── 3. REVISION TABLE ── -->
<div class="card tbl-card">
  <div class="sec-head" style="margin-bottom:0">
    <div class="sec-title"><i class="fa-solid fa-list"></i> Revision List</div>
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
        <th>Creator</th>
        <th>Revisi Terakhir</th>
        <th>Catatan Revisi</th>
        <th>Deadline</th>
        <th>Status</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>
          <input type="checkbox" class="row-checkbox" value="1">
        </td>
        <td>
          <span class="td-name">Tutorial Skincare Pagi</span>
        </td>
        <td>
          <span class="td-brand">GlowSkin</span>
        </td>
        <td>Kayla</td>
        <td>
          <span class="td-date"><i class="fa-regular fa-calendar"></i>09 Mar 2026</span>
        </td>
        <td>
          <div class="revision-notes">
            <div class="note-item">
              <i class="fa-solid fa-comment"></i>
              Durasi video terlalu pendek, tambah 30 detik
            </div>
            <div class="note-item">
              <i class="fa-solid fa-comment"></i>
              Background perlu lebih terang
            </div>
          </div>
        </td>
        <td>
          <span class="td-date"><i class="fa-regular fa-calendar"></i>10 Mar 2026</span>
        </td>
        <td>
          <span class="pill p-revision">
            <span class="pill-dot"></span>
            Need Revision
          </span>
        </td>
        <td>
          <div class="action-buttons">
            <button class="btn-action btn-preview-sm" onclick="previewContent(1)" title="Preview Konten">
              <i class="fa-solid fa-eye"></i>
            </button>
            <button class="btn-action btn-review" onclick="reviewContent(1)" title="Review">
              <i class="fa-solid fa-comment"></i>
            </button>
            <button class="btn-action btn-download" onclick="downloadContent(1)" title="Download">
              <i class="fa-solid fa-download"></i>
            </button>
          </div>
        </td>
      </tr>
      <tr>
        <td>
          <input type="checkbox" class="row-checkbox" value="2">
        </td>
        <td>
          <span class="td-name">Review Produk Q1</span>
        </td>
        <td>
          <span class="td-brand">BeautyHaus</span>
        </td>
        <td>Sarah</td>
        <td>
          <span class="td-date"><i class="fa-regular fa-calendar"></i>08 Mar 2026</span>
        </td>
        <td>
          <div class="revision-notes">
            <div class="note-item">
              <i class="fa-solid fa-comment"></i>
              Produk tidak terlihat jelas, ganti angle
            </div>
          </div>
        </td>
        <td>
          <span class="td-date"><i class="fa-regular fa-calendar"></i>11 Mar 2026</span>
        </td>
        <td>
          <span class="pill p-amb">
            <span class="pill-dot"></span>
            In Review
          </span>
        </td>
        <td>
          <div class="action-buttons">
            <button class="btn-action btn-preview-sm" onclick="previewContent(2)" title="Preview Konten">
              <i class="fa-solid fa-eye"></i>
            </button>
            <button class="btn-action btn-review" onclick="reviewContent(2)" title="Review">
              <i class="fa-solid fa-comment"></i>
            </button>
            <button class="btn-action btn-download" onclick="downloadContent(2)" title="Download">
              <i class="fa-solid fa-download"></i>
            </button>
          </div>
        </td>
      </tr>
      <tr>
        <td>
          <input type="checkbox" class="row-checkbox" value="3">
        </td>
        <td>
          <span class="td-name">Unboxing Summer</span>
        </td>
        <td>
          <span class="td-brand">StyleCo</span>
        </td>
        <td>Maya</td>
        <td>
          <span class="td-date"><i class="fa-regular fa-calendar"></i>07 Mar 2026</span>
        </td>
        <td>
          <div class="revision-notes">
            <div class="note-item">
              <i class="fa-solid fa-comment"></i>
              Musik terlalu keras, kurangi volume
            </div>
            <div class="note-item">
              <i class="fa-solid fa-comment"></i>
              Tambah caption produk di deskripsi
            </div>
          </div>
        </td>
        <td>
          <span class="td-date"><i class="fa-regular fa-calendar"></i>12 Mar 2026</span>
        </td>
        <td>
          <span class="pill p-revision">
            <span class="pill-dot"></span>
            Need Revision
          </span>
        </td>
        <td>
          <div class="action-buttons">
            <button class="btn-action btn-preview-sm" onclick="previewContent(3)" title="Preview Konten">
              <i class="fa-solid fa-eye"></i>
            </button>
            <button class="btn-action btn-review" onclick="reviewContent(3)" title="Review">
              <i class="fa-solid fa-comment"></i>
            </button>
            <button class="btn-action btn-download" onclick="downloadContent(3)" title="Download">
              <i class="fa-solid fa-download"></i>
            </button>
          </div>
        </td>
      </tr>
    </tbody>
  </table>
</div>

<!-- ── 4. APPROVE MODAL ── -->
<div id="approveModal" class="modal-overlay" style="display: none;">
  <div class="modal-content">
    <div class="modal-header">
      <div class="modal-title">
        <i class="fa-solid fa-check"></i>
        Approve Revision
      </div>
      <button class="modal-close" onclick="closeApproveModal()">
        <i class="fa-solid fa-times"></i>
      </button>
    </div>
    <div class="modal-body">
      <div class="approve-info">
        <div class="info-item">
          <i class="fa-solid fa-info-circle"></i>
          <span>Anda akan menyetujui <strong id="selectedCount">0</strong> konten untuk dipublish.</span>
        </div>
        <div class="info-item">
          <i class="fa-solid fa-exclamation-triangle"></i>
          <span>Setelah disetujui, konten akan langsung masuk ke tahap publishing.</span>
        </div>
      </div>
      <div class="form-group">
        <label for="approveNotes">Catatan Approve (Opsional)</label>
        <textarea id="approveNotes" rows="3" placeholder="Tambahkan catatan untuk creator..."></textarea>
      </div>
      <div class="modal-actions">
        <button type="button" class="btn-secondary" onclick="closeApproveModal()">Batal</button>
        <button type="button" class="btn-primary" onclick="confirmApprove()">
          <i class="fa-solid fa-check"></i>
          Approve & Publish
        </button>
      </div>
    </div>
  </div>
</div>

@endsection

@push('styles')
<style>
/* Revision Notes */
.revision-notes {
  display: flex;
  flex-direction: column;
  gap: 6px;
}

.note-item {
  display: flex;
  align-items: flex-start;
  gap: 6px;
  font-size: 11.5px;
  color: var(--text-600);
  background: var(--blue-50);
  padding: 6px 8px;
  border-radius: var(--r-xs);
  border-left: 3px solid var(--blue);
}

.note-item i {
  color: var(--blue);
  font-size: 10px;
  margin-top: 2px;
  flex-shrink: 0;
}

/* Approve Modal Styles */
.approve-info {
  margin-bottom: 20px;
}

.info-item {
  display: flex;
  align-items: flex-start;
  gap: 10px;
  padding: 12px;
  border-radius: var(--r-sm);
  margin-bottom: 12px;
}

.info-item:first-child {
  background: rgba(16,185,129,.1);
  border: 1px solid rgba(16,185,129,.2);
}

.info-item:last-child {
  background: rgba(245,158,11,.1);
  border: 1px solid rgba(245,158,11,.2);
}

.info-item i {
  color: var(--emerald);
  font-size: 14px;
  flex-shrink: 0;
  margin-top: 1px;
}

.info-item:last-child i {
  color: var(--amber);
}

.info-item span {
  font-size: 12.5px;
  color: var(--text-700);
  line-height: 1.4;
}

/* Checkbox Styles */
input[type="checkbox"] {
  width: 16px;
  height: 16px;
  border: 1px solid var(--border);
  border-radius: var(--r-xs);
  background: var(--white);
  cursor: pointer;
  transition: var(--t);
}

input[type="checkbox"]:checked {
  background: var(--blue);
  border-color: var(--blue);
}

input[type="checkbox"]:checked::after {
  content: '✓';
  color: white;
  font-size: 10px;
  display: block;
  text-align: center;
  line-height: 14px;
}

/* Additional Status Pills */
.p-amb { background: rgba(245,158,11,.10); color: #92400e; }
.p-amb .pill-dot { background: var(--amber); }

.p-review { background: rgba(139,92,246,.10); color: #6d28d9; }
.p-review .pill-dot { background: var(--violet); }

.p-revision { background: rgba(239,68,68,.10); color: #b91c1c; }
.p-revision .pill-dot { background: #ef4444; }

.p-approved { background: rgba(16,185,129,.10); color: #065f46; }
.p-approved .pill-dot { background: var(--emerald); }
</style>
@endpush

@push('scripts')
<script>
// Checkbox functionality
function toggleSelectAll() {
  const selectAll = document.getElementById('selectAll');
  const checkboxes = document.querySelectorAll('.row-checkbox');
  
  checkboxes.forEach(checkbox => {
    checkbox.checked = selectAll.checked;
  });
  
  updateSelectedCount();
}

function updateSelectedCount() {
  const checkboxes = document.querySelectorAll('.row-checkbox:checked');
  document.getElementById('selectedCount').textContent = checkboxes.length;
}

// Add event listeners to all checkboxes
document.addEventListener('DOMContentLoaded', function() {
  const checkboxes = document.querySelectorAll('.row-checkbox');
  checkboxes.forEach(checkbox => {
    checkbox.addEventListener('change', updateSelectedCount);
  });
});

// Modal functions
function showApproveModal() {
  const selectedCount = document.querySelectorAll('.row-checkbox:checked').length;
  if (selectedCount === 0) {
    alert('Pilih minimal 1 konten untuk di-approve');
    return;
  }
  document.getElementById('selectedCount').textContent = selectedCount;
  document.getElementById('approveModal').style.display = 'flex';
}

function closeApproveModal() {
  document.getElementById('approveModal').style.display = 'none';
}

function confirmApprove() {
  // Simulate approve action
  alert('Konten berhasil di-approve dan akan dipublish!');
  closeApproveModal();
  
  // Reset checkboxes
  document.getElementById('selectAll').checked = false;
  const checkboxes = document.querySelectorAll('.row-checkbox');
  checkboxes.forEach(checkbox => {
    checkbox.checked = false;
  });
  updateSelectedCount();
}

// Action functions
function previewContent(id) {
  // Show preview modal or redirect
  alert('Preview content ID: ' + id + '\n\nFitur preview akan menampilkan video/file konten.');
}

function reviewContent(id) {
  // Show review modal with form
  const notes = prompt('Tambahkan catatan review untuk konten ini:');
  if (notes) {
    // Simulate saving review
    alert('Review tersimpan untuk konten ID: ' + id + '\nCatatan: ' + notes);
  }
}

function downloadContent(id) {
  // Simulate download
  alert('Download content ID: ' + id + '\n\nFile akan diunduh ke device Anda.');
}

// Close modal on overlay click
document.getElementById('approveModal').addEventListener('click', function(e) {
  if (e.target === this) {
    closeApproveModal();
  }
});

// Close modal on ESC key
document.addEventListener('keydown', function(e) {
  if (e.key === 'Escape') {
    closeApproveModal();
  }
});
</script>
@endpush
