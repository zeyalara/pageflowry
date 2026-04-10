@extends('layouts.admin')

@section('page-title', 'Brand Management')

@section('content')

<div class="page-header">
  <div>
    <div class="page-header-title">Brand Management</div>
    <div class="page-subtitle">Kelola daftar brand dan informasi PIC</div>
  </div>
  <button class="btn btn-primary" onclick="openAddModal()">
    <i class="fa-solid fa-plus"></i> Tambah Brand
  </button>
</div>

<div class="stat-row">
  <div class="stat-card sc-blue" style="--i:0">
    <div class="stat-ic"><i class="fa-solid fa-tag"></i></div>
    <div class="stat-val">{{ $brands->count() }}</div>
    <div class="stat-lbl">Total Brand</div>
  </div>
  <div class="stat-card sc-em" style="--i:1">
    <div class="stat-ic"><i class="fa-solid fa-circle-dot"></i></div>
    <div class="stat-val">{{ $brands->where('status', 'Active')->count() }}</div>
    <div class="stat-lbl">Brand Aktif</div>
  </div>
  <div class="stat-card sc-amb" style="--i:2">
    <div class="stat-ic"><i class="fa-solid fa-circle-pause"></i></div>
    <div class="stat-val">{{ $brands->where('status', 'Non Active')->count() }}</div>
    <div class="stat-lbl">Brand Non-Aktif</div>
  </div>
  <div class="stat-card sc-rose" style="--i:3">
    <div class="stat-ic"><i class="fa-solid fa-photo-film"></i></div>
    <div class="stat-val">{{ $brands->sum('contents_count') ?? 0 }}</div>
    <div class="stat-lbl">Total Konten</div>
  </div>
</div>

<div class="card tbl-card">
  <div class="sec-head" style="margin-bottom:0;padding:18px 22px 16px;border-bottom:1px solid var(--border-light);">
    <div class="sec-title">
      <i class="fa-solid fa-list"></i>
      Daftar Brand
    </div>
    <button class="btn btn-primary" onclick="openAddModal()">
      <i class="fa-solid fa-plus"></i> Tambah Brand
    </button>
  </div>
  <table class="content-table">
    <thead>
      <tr>
        <th style="width: 25%;">Brand</th>
        <th style="width: 15%;">PIC</th>
        <th style="width: 20%;">Kontak</th>
        <th style="width: 10%;">Konten</th>
        <th style="width: 15%;">Status</th>
        <th style="width: 15%;">Aksi</th>
      </tr>
    </thead>
    <tbody>
      @forelse($brands as $brand)
        @php
          $colors = [
            'rgba(88, 151, 254, 1)',      // Blue
            'rgba(139, 92, 246, 1)',      // Violet
            'rgba(16, 185, 129, 1)',      // Emerald
            'rgba(255, 120, 73, 1)',      // Orange
            'rgba(245, 158, 11, 1)',      // Amber
            'rgba(6, 182, 212, 1)',       // Cyan
            'rgba(236, 72, 153, 1)',      // Pink
            'rgba(168, 85, 247, 1)',      // Purple
          ];
          $colorIndex = ($brand->id - 1) % count($colors);
          $brandColor = $colors[$colorIndex];
        @endphp
        <tr>
          <td style="white-space: nowrap; vertical-align: middle;">
            <div style="display:flex;align-items:center;gap:12px;">
              <div style="width:40px;height:40px;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:14px;font-weight:800;color:#fff;text-transform:uppercase;background:{{ $brandColor }};">
                {{ strtoupper(substr($brand->name, 0, 2)) }}
              </div>
              <div>
                <span class="td-name">{{ $brand->name }}</span>
              </div>
            </div>
          </td>
          <td style="white-space: nowrap; vertical-align: middle;">
            <span class="td-brand">{{ $brand->pic }}</span>
          </td>
          <td style="white-space: nowrap; vertical-align: middle;">{{ $brand->contact }}</td>
          <td style="white-space: nowrap; vertical-align: middle;">{{ $brand->contents_count ?? 0 }}</td>
          <td style="white-space: nowrap; vertical-align: middle;">
            <span class="pill {{ $brand->status === 'Active' ? 'p-in-production' : 'p-under-review' }}">
              <span class="pill-dot"></span>
              {{ $brand->status }}
            </span>
          </td>
          <td style="white-space: nowrap; vertical-align: middle;">
            <div class="action-buttons" style="display:flex;gap:6px;flex-wrap:nowrap;">
              <button class="btn-action" onclick="openDetailModal({{ $brand->id }})" title="Detail">
                <i class="fa-solid fa-eye"></i>
              </button>
              <button class="btn-action" onclick="openEditModal({{ $brand->id }})" title="Edit">
                <i class="fa-solid fa-pen"></i>
              </button>
              <button class="btn-action" onclick="openDeleteModal({{ $brand->id }}, '{{ addslashes($brand->name) }}')" title="Hapus">
                <i class="fa-solid fa-trash"></i>
              </button>
            </div>
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="6" style="text-align:center;padding:48px 16px;color:var(--text-400);">
            <i class="fa-solid fa-list" style="font-size:32px;margin-bottom:10px;opacity:.3;"></i>
            <div style="font-size:15px;font-weight:600;">Belum ada brand</div>
            <div style="font-size:12.5px;">Buat brand pertama untuk memulai</div>
          </td>
        </tr>
      @endforelse
    </tbody>
  </table>
</div>

  <!-- MODALS -->
  <!-- Add/Edit Modal -->
  <div class="overlay" id="brandModal">
    <div class="modal">
      <div class="modal-head">
        <div class="modal-title-wrap">
          <div class="modal-eyebrow">
            <i class="fa-solid fa-tag"></i>
            Brand Management
          </div>
          <div class="modal-title" id="modalTitle">Tambah Brand Baru</div>
          <div class="modal-subtitle" id="modalSubtitle">Lengkapi informasi brand untuk melanjutkan</div>
        </div>
        <button class="modal-close" onclick="closeModal()">
          <i class="fa-solid fa-xmark"></i>
        </button>
      </div>
      <div class="modal-body">
        <form id="brandForm">
          @csrf
          <input type="hidden" id="brandId" name="id">
          <div class="form-grid">
            <div class="form-group">
              <label class="form-label">Nama Brand <span class="req">*</span></label>
              <div class="input-wrap">
                <i class="fa-solid fa-tag"></i>
                <input class="form-input" id="fName" name="name" type="text" placeholder="Masukkan nama brand"/>
              </div>
              <span class="form-error" id="errName">Nama brand wajib diisi.</span>
            </div>
            <div class="form-group">
              <label class="form-label">PIC <span class="req">*</span></label>
              <div class="input-wrap">
                <i class="fa-solid fa-user"></i>
                <input class="form-input" id="fPic" name="pic" type="text" placeholder="Nama penanggung jawab"/>
              </div>
              <span class="form-error" id="errPic">PIC wajib diisi.</span>
            </div>
            <div class="form-group">
              <label class="form-label">Kontak <span class="req">*</span></label>
              <div class="input-wrap">
                <i class="fa-solid fa-phone"></i>
                <input class="form-input" id="fContact" name="contact" type="text" placeholder="Nomor telepon atau email"/>
              </div>
              <span class="form-error" id="errContact">Kontak wajib diisi.</span>
            </div>
            <div class="form-group">
              <label class="form-label">Target Market</label>
              <input class="form-input" id="fTargetMarket" name="target_market" type="text" placeholder="Contoh: Remaja 18-25 tahun"/>
            </div>
            <div class="form-group full">
              <label class="form-label">Deskripsi Brand</label>
              <textarea class="form-textarea" id="fDescription" name="description" placeholder="Deskripsikan brand secara singkat..."></textarea>
            </div>
            <div class="form-group full">
              <label class="form-label">Tone of Voice</label>
              <div class="tone-chips">
                <div class="tone-chip" data-value="professional">Professional</div>
                <div class="tone-chip" data-value="casual">Casual</div>
                <div class="tone-chip" data-value="friendly">Friendly</div>
                <div class="tone-chip" data-value="formal">Formal</div>
                <div class="tone-chip" data-value="humorous">Humorous</div>
                <div class="tone-chip" data-value="inspirational">Inspirational</div>
                <div class="tone-chip" data-value="authoritative">Authoritative</div>
                <div class="tone-chip" data-value="conversational">Conversational</div>
              </div>
              <input type="hidden" id="fToneVoice" name="tone_voice">
            </div>
            <div class="form-group full">
              <label class="form-label">Status <span class="req">*</span></label>
              <div class="status-toggle">
                <div class="st-option st-active selected" data-value="Active">
                  <div class="st-dot"></div>
                  <span>Active</span>
                </div>
                <div class="st-option st-inactive" data-value="Non Active">
                  <div class="st-dot"></div>
                  <span>Non Active</span>
                </div>
              </div>
              <input type="hidden" id="fStatus" name="status" value="Active">
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <div class="mf-left">* Wajib diisi</div>
        <div class="mf-right">
          <button class="btn btn-ghost" onclick="closeModal()">Batal</button>
          <button class="btn btn-primary" id="submitBtn" onclick="submitForm()">
            <i class="fa-solid fa-save"></i>
            Simpan
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- Detail Modal -->
  <div class="overlay" id="detailModal">
    <div class="modal detail-modal">
      <div class="modal-head">
        <div class="modal-title-wrap">
          <div class="modal-eyebrow">
            <i class="fa-solid fa-tag"></i>
            Detail Brand
          </div>
          <div class="modal-title" id="detailTitle">Nama Brand</div>
          <div class="modal-subtitle" id="detailSubtitle">Informasi lengkap brand</div>
        </div>
        <button class="modal-close" onclick="closeDetailModal()">
          <i class="fa-solid fa-xmark"></i>
        </button>
      </div>
      <div class="modal-body">
        <div class="detail-hero">
          <div class="detail-avatar" id="detailAvatar">AB</div>
          <div>
            <div class="detail-name" id="detailName">Nama Brand</div>
            <div class="detail-meta">
              <span id="detailCreated">Dibuat 01 Jan 2024</span>
              <span id="detailStatus">Status: Active</span>
            </div>
          </div>
        </div>
        <div class="detail-body">
          <div class="detail-grid">
            <div class="detail-item">
              <div class="detail-item-label">PIC</div>
              <div class="detail-item-value" id="detailPic">Nama PIC</div>
            </div>
            <div class="detail-item">
              <div class="detail-item-label">KONTAK</div>
              <div class="detail-item-value" id="detailContact">Kontak</div>
            </div>
            <div class="detail-item">
              <div class="detail-item-label">TARGET MARKET</div>
              <div class="detail-item-value" id="detailTargetMarket">Target Market</div>
            </div>
            <div class="detail-item">
              <div class="detail-item-label">TONE OF VOICE</div>
              <div class="detail-item-value" id="detailToneVoice">Tone Voice</div>
            </div>
            <div class="detail-item full">
              <div class="detail-item-label">DESKRIPSI</div>
              <div class="detail-item-value" id="detailDescription">Deskripsi brand</div>
            </div>
          </div>
          <div class="content-bar">
            <div class="cb-row">
              <div class="cb-label">Total Konten</div>
              <div class="cb-track">
                <div class="cb-fill" id="contentFill" style="width: 0%; background: var(--blue);"></div>
              </div>
              <div class="cb-num" id="contentNum">0</div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <div class="mf-right">
          <button class="btn btn-ghost" onclick="closeDetailModal()">Tutup</button>
          <button class="btn btn-primary" id="editFromDetailBtn" onclick="editFromDetail()">
            <i class="fa-solid fa-pen"></i>
            Edit Brand
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- Delete Modal -->
  <div class="overlay" id="deleteModal">
    <div class="modal delete-modal">
      <div class="modal-head">
        <div class="modal-title-wrap">
          <div class="modal-eyebrow">
            <i class="fa-solid fa-triangle-exclamation"></i>
            Hapus Brand
          </div>
          <div class="modal-title">Konfirmasi Hapus</div>
          <div class="modal-subtitle">Tindakan ini tidak dapat dibatalkan</div>
        </div>
        <button class="modal-close" onclick="closeDeleteModal()">
          <i class="fa-solid fa-xmark"></i>
        </button>
      </div>
      <div class="modal-body">
        <div class="delete-icon-wrap">
          <i class="fa-solid fa-trash"></i>
        </div>
        <p style="text-align: center; color: var(--text-700); margin-bottom: 20px;">
          Apakah Anda yakin ingin menghapus brand <strong id="deleteBrandName">Nama Brand</strong>?
          <br><small style="color: var(--text-400);">Semua data terkait akan dihapus secara permanen.</small>
        </p>
      </div>
      <div class="modal-footer">
        <div class="mf-right">
          <button class="btn btn-ghost" onclick="closeDeleteModal()">Batal</button>
          <button class="btn btn-danger" id="confirmDeleteBtn" onclick="confirmDelete()">
            <i class="fa-solid fa-trash"></i>
            Hapus Brand
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- Toast Container -->
  <div class="toast-container" id="toastContainer"></div>

@endsection

@push('styles')
<style>
/* â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•
   DESIGN SYSTEM - Consistent with Brand Management
â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â• */
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

/* Table card - Consistent with Brand Management */
.table-card {
  background: var(--white);
  border-radius: var(--r);
  border: 1px solid var(--border);
  box-shadow: var(--s1);
  overflow: hidden;
}

/* Table - Consistent with Brand Management */
.table-wrapper {
  height: 400px;
  overflow-y: scroll;
}
.content-table {
  width: 100%;
  border-collapse: collapse;
}
.content-table thead th {
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
}
.content-table tbody tr {
  border-bottom: 1px solid var(--border-light);
  transition: var(--t);
  cursor: pointer;
}
.content-table tbody tr:last-child {
  border-bottom: none;
}
.content-table tbody tr:hover {
  background: var(--blue-50);
}
.content-table tbody tr:hover .action-buttons {
  opacity: 1;
}
.content-table tbody td {
  font-family: 'DM Sans', sans-serif;
  font-size: 13px;
  color: var(--text-700);
  padding: 14px 16px;
  vertical-align: middle;
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
.td-status {
  display: inline-flex;
  align-items: center;
  gap: 4px;
  font-family: 'DM Sans', sans-serif;
  font-size: 11.5px;
  font-weight: 700;
  padding: 4px 10px;
  border-radius: 99px;
  white-space: nowrap;
}
.status-published {
  background: rgba(16,185,129,.10);
  color: #065f46;
}
.status-draft {
  background: rgba(148,163,184,.12);
  color: var(--text-500);
}
.status-pending {
  background: rgba(245,158,11,.10);
  color: #92400e;
}

/* Action buttons - Consistent with Brand Management */
.action-buttons {
  display: flex;
  align-items: center;
  gap: 5px;
  opacity: 0;
  transition: var(--t);
}
.btn-action {
  width: 32px;
  height: 32px;
  border-radius: 8px;
  border: none;
  display: flex;
  align-items: center;
  justify-content: center;
  font-family: 'DM Sans', sans-serif;
  font-size: 13px;
  cursor: pointer;
  transition: var(--t);
  background: var(--blue-50);
  color: var(--blue);
}
.btn-action:hover {
  background: var(--blue-100);
  transform: scale(1.08);
}
.btn-action.btn-download {
  background: rgba(16,185,129,.10);
  color: var(--emerald);
}
.btn-action.btn-download:hover {
  background: rgba(16,185,129,.2);
}
.btn-action.btn-upload {
  background: rgba(245,158,11,.10);
  color: var(--amber);
}
.btn-action.btn-upload:hover {
  background: rgba(245,158,11,.2);
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
  color: var(--text-400);
}
.empty-state i {
  font-size: 48px;
  margin-bottom: 16px;
  opacity: 0.3;
}
.empty-state h3 {
  font-family: 'DM Sans', sans-serif;
  font-size: 16px;
  font-weight: 600;
  margin-bottom: 8px;
  color: var(--text-500);
}
.empty-state p {
  font-family: 'DM Sans', sans-serif;
  font-size: 13px;
  color: var(--text-400);
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
  .table-wrapper {
    height: 300px;
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

@push('scripts')
<script>
let brands = @json($brands);

// Process brands data to ensure consistent structure
brands = brands.map(brand => {
  return {
    id: brand.id,
    name: brand.name || '',
    pic: brand.pic || '',
    contact: brand.contact || '',
    target_market: brand.target_market || '',
    description: brand.description || '',
    tone_voice: brand.tone_voice || '',
    status: brand.status || 'Active',
    contents_count: brand.contents_count || 0,
    created_at: brand.created_at,
    updated_at: brand.updated_at
  };
});

// DOM elements
const searchInput = document.getElementById('searchInput');
const filterStatus = document.getElementById('filterStatus');
const tableView = document.getElementById('tableView');
const gridView = document.getElementById('gridView');
const tableViewBtn = document.getElementById('tableViewBtn');
const gridViewBtn = document.getElementById('gridViewBtn');

// Initialize
document.addEventListener('DOMContentLoaded', function() {
  // Set today's date
  const today = new Date();
  const options = { day: 'numeric', month: 'short', year: 'numeric' };
  document.getElementById('today-date').textContent = today.toLocaleDateString('id-ID', options);

  // Setup event listeners
  setupEventListeners();

  // Initial render
  renderTable();
});

// Setup event listeners
function setupEventListeners() {
  searchInput.addEventListener('input', debounce(filterTable, 300));
  filterStatus.addEventListener('change', filterTable);
}

// Debounce function
function debounce(func, wait) {
  let timeout;
  return function executedFunction(...args) {
    const later = () => {
      clearTimeout(timeout);
      func(...args);
    };
    clearTimeout(timeout);
    timeout = setTimeout(later, wait);
  };
}

// Filter table
function filterTable() {
  const searchTerm = searchInput.value.toLowerCase();
  const statusFilter = filterStatus.value;

  const filteredBrands = brands.filter(brand => {
    const matchesSearch = brand.name.toLowerCase().includes(searchTerm) ||
                         brand.pic.toLowerCase().includes(searchTerm) ||
                         brand.contact.toLowerCase().includes(searchTerm);
    const matchesStatus = statusFilter === '' || brand.status.toLowerCase() === statusFilter;
    return matchesSearch && matchesStatus;
  });

  renderTable(filteredBrands);
}

// Render table
function renderTable(filteredBrands = brands) {
  const tbody = tableView.querySelector('.brand-table tbody');
  tbody.innerHTML = '';

  if (filteredBrands.length === 0) {
    tbody.innerHTML = '<tr><td colspan="6" style="text-align: center; padding: 40px; color: var(--text-400);"><i class="fa-solid fa-search" style="font-size: 24px; margin-bottom: 10px; display: block;"></i>Tidak ada brand yang ditemukan</td></tr>';
    return;
  }

  filteredBrands.forEach(brand => {
    const row = document.createElement('tr');
    row.onclick = () => openDetailModal(brand.id);

    const colors = ['#5897fe', '#8b5cf6', '#10b981', '#ff7849', '#f59e0b', '#06b6d4'];
    const gradients = [
      ['#5897fe', '#3a7bfe'], ['#8b5cf6', '#7c3aed'], ['#10b981', '#059669'],
      ['#ff7849', '#f97316'], ['#f59e0b', '#d97706'], ['#06b6d4', '#0891b2']
    ];
    const randomGradient = gradients[Math.floor(Math.random() * gradients.length)];

    row.innerHTML = `
      <td>
        <div class="brand-cell">
          <div class="brand-avatar" style="background: linear-gradient(135deg, ${randomGradient[0]}, ${randomGradient[1]})">
            ${brand.name.substring(0, 2).toUpperCase()}
          </div>
          <div>
            <div class="brand-name-text">${brand.name}</div>
            <div class="brand-created">${new Date(brand.created_at).toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' })}</div>
          </div>
        </div>
      </td>
      <td>
        <div class="pic-cell">
          <div class="pic-ava">${brand.pic.substring(0, 2).toUpperCase()}</div>
          <div class="pic-name">${brand.pic}</div>
        </div>
      </td>
      <td>${brand.contact}</td>
      <td>
        <div class="content-count">
          <i class="fa-solid fa-photo-film"></i>
          ${brand.contents_count}
        </div>
      </td>
      <td>
        <div class="status-pill ${brand.status === 'Active' ? 'sp-active' : 'sp-inactive'}">
          <div class="status-dot"></div>
          ${brand.status}
        </div>
      </td>
      <td>
        <div class="row-actions">
          <button class="act-btn act-detail" onclick="event.stopPropagation(); openDetailModal(${brand.id})" title="Detail">
            <i class="fa-solid fa-eye"></i>
          </button>
          <button class="act-btn act-edit" onclick="event.stopPropagation(); openEditModal(${brand.id})" title="Edit">
            <i class="fa-solid fa-pen"></i>
          </button>
          <button class="act-btn act-del" onclick="event.stopPropagation(); openDeleteModal(${brand.id}, '${brand.name}')" title="Hapus">
            <i class="fa-solid fa-trash"></i>
          </button>
        </div>
      </td>
    `;

    tbody.appendChild(row);
  });
}

// Toggle view
function toggleView(view) {
  if (view === 'table') {
    tableView.style.display = 'block';
    gridView.style.display = 'none';
    tableViewBtn.classList.add('active');
    gridViewBtn.classList.remove('active');
  } else {
    tableView.style.display = 'none';
    gridView.classList.add('show');
    gridViewBtn.classList.add('active');
    tableViewBtn.classList.remove('active');
  }
}

// Modal functions
function openAddModal() {
  document.getElementById('brandId').value = '';
  document.getElementById('modalTitle').textContent = 'Tambah Brand Baru';
  document.getElementById('modalSubtitle').textContent = 'Lengkapi informasi brand untuk melanjutkan';
  document.getElementById('submitBtn').innerHTML = '<i class="fa-solid fa-save"></i> Simpan';

  // Reset form
  document.getElementById('brandForm').reset();
  document.querySelectorAll('.form-error').forEach(el => el.classList.remove('show'));
  document.querySelectorAll('.form-input, .form-textarea').forEach(el => el.classList.remove('error'));

  // Reset tone chips
  document.querySelectorAll('.tone-chip').forEach(chip => chip.classList.remove('selected'));
  document.getElementById('fToneVoice').value = '';

  // Reset status toggle
  document.querySelectorAll('.st-option').forEach(opt => opt.classList.remove('selected'));
  document.querySelector('.st-active').classList.add('selected');
  document.getElementById('fStatus').value = 'Active';

  document.getElementById('brandModal').classList.add('open');
}

function openEditModal(id) {
  const brand = brands.find(b => b.id == id);
  if (!brand) return;

  document.getElementById('brandId').value = brand.id;
  document.getElementById('modalTitle').textContent = 'Edit Brand';
  document.getElementById('modalSubtitle').textContent = 'Perbarui informasi brand';
  document.getElementById('submitBtn').innerHTML = '<i class="fa-solid fa-save"></i> Perbarui';

  // Fill form
  document.getElementById('fName').value = brand.name;
  document.getElementById('fPic').value = brand.pic;
  document.getElementById('fContact').value = brand.contact;
  document.getElementById('fTargetMarket').value = brand.target_market;
  document.getElementById('fDescription').value = brand.description;

  // Set tone voice
  document.querySelectorAll('.tone-chip').forEach(chip => {
    if (chip.dataset.value === brand.tone_voice) {
      chip.classList.add('selected');
    } else {
      chip.classList.remove('selected');
    }
  });
  document.getElementById('fToneVoice').value = brand.tone_voice;

  // Set status
  document.querySelectorAll('.st-option').forEach(opt => opt.classList.remove('selected'));
  if (brand.status === 'Active') {
    document.querySelector('.st-active').classList.add('selected');
  } else {
    document.querySelector('.st-inactive').classList.add('selected');
  }
  document.getElementById('fStatus').value = brand.status;

  document.getElementById('brandModal').classList.add('open');
}

function openDetailModal(id) {
  const brand = brands.find(b => b.id == id);
  if (!brand) return;

  const colors = ['#5897fe', '#8b5cf6', '#10b981', '#ff7849', '#f59e0b', '#06b6d4'];
  const gradients = [
    ['#5897fe', '#3a7bfe'], ['#8b5cf6', '#7c3aed'], ['#10b981', '#059669'],
    ['#ff7849', '#f97316'], ['#f59e0b', '#d97706'], ['#06b6d4', '#0891b2']
  ];
  const randomGradient = gradients[Math.floor(Math.random() * gradients.length)];

  document.getElementById('detailAvatar').style.background = `linear-gradient(135deg, ${randomGradient[0]}, ${randomGradient[1]})`;
  document.getElementById('detailAvatar').textContent = brand.name.substring(0, 2).toUpperCase();
  document.getElementById('detailTitle').textContent = brand.name;
  document.getElementById('detailName').textContent = brand.name;
  document.getElementById('detailCreated').textContent = `Dibuat ${new Date(brand.created_at).toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' })}`;
  document.getElementById('detailStatus').textContent = `Status: ${brand.status}`;

  document.getElementById('detailPic').textContent = brand.pic;
  document.getElementById('detailContact').textContent = brand.contact;
  document.getElementById('detailTargetMarket').textContent = brand.target_market || '-';
  document.getElementById('detailToneVoice').textContent = brand.tone_voice || '-';
  document.getElementById('detailDescription').textContent = brand.description || '-';

  // Animate content bar
  const contentFill = document.getElementById('contentFill');
  const contentNum = document.getElementById('contentNum');
  contentFill.style.width = '0%';
  contentNum.textContent = '0';

  setTimeout(() => {
    const percentage = Math.min((brand.contents_count / 10) * 100, 100); // Assuming max 10 for demo
    contentFill.style.width = `${percentage}%`;
    contentFill.style.background = `linear-gradient(90deg, ${randomGradient[0]}, ${randomGradient[1]})`;
    animateNumber(contentNum, 0, brand.contents_count, 1000);
  }, 300);

  document.getElementById('detailModal').classList.add('open');
}

function openDeleteModal(id, name) {
  document.getElementById('deleteBrandName').textContent = name;
  document.getElementById('confirmDeleteBtn').onclick = () => confirmDelete(id);
  document.getElementById('deleteModal').classList.add('open');
}

function closeModal() {
  document.getElementById('brandModal').classList.remove('open');
}

function closeDetailModal() {
  document.getElementById('detailModal').classList.remove('open');
}

function closeDeleteModal() {
  document.getElementById('deleteModal').classList.remove('open');
}

function editFromDetail() {
  const brandId = brands.find(b => b.name === document.getElementById('detailName').textContent)?.id;
  if (brandId) {
    closeDetailModal();
    openEditModal(brandId);
  }
}

// Form submission
async function submitForm() {
  const formData = new FormData(document.getElementById('brandForm'));
  const brandId = formData.get('id');
  const isEdit = !!brandId;

  // Validate form
  if (!validateForm()) return;

  // Show loading
  const submitBtn = document.getElementById('submitBtn');
  const originalText = submitBtn.innerHTML;
  submitBtn.innerHTML = '<i class="fa-solid fa-spinner spin"></i> Menyimpan...';
  submitBtn.disabled = true;

  try {
    const response = await fetch(`{{ url('brands') }}/${brandId || ''}`, {
      method: isEdit ? 'PUT' : 'POST',
      headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        'Accept': 'application/json',
      },
      body: formData
    });

    const data = await response.json();

    if (response.ok && data.success) {
      showToast('success', isEdit ? 'Brand berhasil diperbarui!' : 'Brand berhasil ditambahkan!');
      closeModal();

      // Reload page to refresh data
      setTimeout(() => {
        window.location.reload();
      }, 1500);
    } else {
      throw new Error(data.message || 'Terjadi kesalahan saat menyimpan brand');
    }
  } catch (error) {
    console.error('Error saving brand:', error);
    showToast('error', error.message || 'Terjadi kesalahan saat menyimpan brand');
  } finally {
    submitBtn.innerHTML = originalText;
    submitBtn.disabled = false;
  }
}

// Delete confirmation
async function confirmDelete(id) {
  const confirmBtn = document.getElementById('confirmDeleteBtn');
  const originalText = confirmBtn.innerHTML;
  confirmBtn.innerHTML = '<i class="fa-solid fa-spinner spin"></i> Menghapus...';
  confirmBtn.disabled = true;

  try {
    const response = await fetch(`{{ url('brands') }}/${id}`, {
      method: 'DELETE',
      headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        'Accept': 'application/json',
      }
    });

    const data = await response.json();

    if (response.ok && data.success) {
      showToast('success', 'Brand berhasil dihapus!');
      closeDeleteModal();

      // Reload page to refresh data
      setTimeout(() => {
        window.location.reload();
      }, 1500);
    } else {
      throw new Error(data.message || 'Terjadi kesalahan saat menghapus brand');
    }
  } catch (error) {
    console.error('Error deleting brand:', error);
    showToast('error', error.message || 'Terjadi kesalahan saat menghapus brand');
  } finally {
    confirmBtn.innerHTML = originalText;
    confirmBtn.disabled = false;
  }
}

// Form validation
function validateForm() {
  let isValid = true;

  // Reset errors
  document.querySelectorAll('.form-error').forEach(el => el.classList.remove('show'));
  document.querySelectorAll('.form-input, .form-textarea').forEach(el => el.classList.remove('error'));

  // Required fields
  const requiredFields = [
    { id: 'fName', errorId: 'errName', message: 'Nama brand wajib diisi.' },
    { id: 'fPic', errorId: 'errPic', message: 'PIC wajib diisi.' },
    { id: 'fContact', errorId: 'errContact', message: 'Kontak wajib diisi.' }
  ];

  requiredFields.forEach(field => {
    const element = document.getElementById(field.id);
    if (!element.value.trim()) {
      document.getElementById(field.errorId).textContent = field.message;
      document.getElementById(field.errorId).classList.add('show');
      element.classList.add('error');
      isValid = false;
    }
  });

  return isValid;
}

// Tone chip selection
document.addEventListener('click', function(e) {
  if (e.target.classList.contains('tone-chip')) {
    document.querySelectorAll('.tone-chip').forEach(chip => chip.classList.remove('selected'));
    e.target.classList.add('selected');
    document.getElementById('fToneVoice').value = e.target.dataset.value;
  }
});

// Status toggle
document.addEventListener('click', function(e) {
  if (e.target.classList.contains('st-option') || e.target.closest('.st-option')) {
    const option = e.target.classList.contains('st-option') ? e.target : e.target.closest('.st-option');
    document.querySelectorAll('.st-option').forEach(opt => opt.classList.remove('selected'));
    option.classList.add('selected');
    document.getElementById('fStatus').value = option.classList.contains('st-active') ? 'Active' : 'Non Active';
  }
});

// Toast notifications
function showToast(type, message) {
  const toastContainer = document.getElementById('toastContainer');
  const toast = document.createElement('div');
  toast.className = `toast toast-${type}`;
  toast.innerHTML = `
    <div class="toast-ic">
      <i class="fa-solid ${type === 'success' ? 'fa-check' : type === 'error' ? 'fa-xmark' : 'fa-exclamation'}"></i>
    </div>
    <div>${message}</div>
  `;

  toastContainer.appendChild(toast);

  setTimeout(() => toast.classList.add('show'), 100);

  setTimeout(() => {
    toast.classList.remove('show');
    setTimeout(() => toast.remove(), 350);
  }, 3000);
}

// Close modals on escape
document.addEventListener('keydown', function(e) {
  if (e.key === 'Escape') {
    closeModal();
    closeDetailModal();
    closeDeleteModal();
  }
});

// Close modals on outside click
document.addEventListener('click', function(e) {
  if (e.target.classList.contains('overlay')) {
    closeModal();
    closeDetailModal();
    closeDeleteModal();
  }
});
</script>
@endpush

