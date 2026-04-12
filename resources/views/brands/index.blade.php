@extends('layouts.admin')

@section('page-title', 'Brand Management')

@push('styles')
<style>
/* ═══════════════════════════════════════
   STAT MINI CARDS
═══════════════════════════════════════ */
.brand-stats {
  display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 14px;
}
.bstat {
  background: var(--white); border-radius: var(--r);
  border: 1px solid var(--border); box-shadow: var(--s1);
  padding: 18px 20px; cursor: pointer; transition: var(--t);
  animation: fadeUp .45s ease both;
  animation-delay: calc(var(--i,0) * 55ms);
  position: relative; overflow: hidden;
}
.bstat:hover { transform: translateY(-3px); box-shadow: var(--s2); border-color: var(--blue-200); }
.bstat::after {
  content: ''; position: absolute;
  bottom: -14px; right: -14px;
  width: 60px; height: 60px; border-radius: 50%; opacity: .08;
  transition: var(--t);
}
.bstat:hover::after { opacity: .15; }
.bstat-blue  { border-top: 2.5px solid var(--blue);    } .bstat-blue::after  { background: var(--blue); }
.bstat-em    { border-top: 2.5px solid var(--emerald); } .bstat-em::after    { background: var(--emerald); }
.bstat-amb   { border-top: 2.5px solid var(--amber);   } .bstat-amb::after   { background: var(--amber); }
.bstat-rose  { border-top: 2.5px solid var(--rose);    } .bstat-rose::after  { background: var(--rose); }

.bstat-ic {
  width: 36px; height: 36px; border-radius: 10px;
  display: flex; align-items: center; justify-content: center;
  font-size: 14px; margin-bottom: 12px;
}
.bstat-blue .bstat-ic  { background: rgba(88,151,254,.1);  color: var(--blue);    }
.bstat-em   .bstat-ic  { background: rgba(16,185,129,.1);  color: var(--emerald); }
.bstat-amb  .bstat-ic  { background: rgba(245,158,11,.1);  color: var(--amber);   }
.bstat-rose .bstat-ic  { background: rgba(244,63,94,.1);   color: var(--rose);    }

.bstat-num {
  font-size: 26px; font-weight: 800; color: var(--text-900);
  line-height: 1; margin-bottom: 4px; letter-spacing: -.4px;
}
.bstat-lbl { font-size: 12px; font-weight: 500; color: var(--text-400); }
.bstat-sub { font-size: 11px; font-weight: 600; margin-top: 7px; display: flex; align-items: center; gap: 3px; }
.sub-up   { color: var(--emerald); }
.sub-warn { color: var(--amber); }

/* ═══════════════════════════════════════
   TOOLBAR (search + filter + add)
═══════════════════════════════════════ */
.toolbar {
  display: flex; align-items: center; gap: 12px;
  animation: fadeUp .45s .1s ease both;
}
.search-wrap {
  flex: 1; max-width: 380px;
  position: relative;
}
.search-wrap i {
  position: absolute; left: 13px; top: 50%; transform: translateY(-50%);
  color: var(--text-400); font-size: 13.5px; pointer-events: none;
}
.search-input {
  width: 100%; height: 40px;
  padding: 0 14px 0 38px;
  border: 1.5px solid var(--border);
  border-radius: var(--r-sm);
  background: var(--white);
  font-family: 'DM Sans', sans-serif;
  font-size: 13.5px; color: var(--text-900);
  transition: var(--t); outline: none;
}
.search-input::placeholder { color: var(--text-300); }
.search-input:focus { border-color: var(--blue); box-shadow: 0 0 0 3px rgba(88,151,254,.12); }

.filter-select {
  height: 40px; padding: 0 14px;
  border: 1.5px solid var(--border);
  border-radius: var(--r-sm);
  background: var(--white);
  font-family: 'DM Sans', sans-serif;
  font-size: 13px; font-weight: 500; color: var(--text-500);
  cursor: pointer; outline: none; transition: var(--t);
  appearance: none; padding-right: 32px;
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6'%3E%3Cpath d='M0 0l5 6 5-6z' fill='%238fa3c4'/%3E%3C/svg%3E");
  background-repeat: no-repeat; background-position: right 12px center;
}
.filter-select:focus { border-color: var(--blue); box-shadow: 0 0 0 3px rgba(88,151,254,.12); }

.toolbar-spacer { flex: 1; }

.btn {
  display: inline-flex; align-items: center; gap: 7px;
  padding: 0 18px; height: 40px; border-radius: var(--r-sm);
  font-family: 'DM Sans', sans-serif;
  font-size: 13.5px; font-weight: 600;
  cursor: pointer; transition: var(--t); border: none; outline: none;
}
.btn-primary {
  background: linear-gradient(135deg, var(--blue), var(--blue-600));
  color: #fff;
  box-shadow: 0 3px 12px rgba(88,151,254,.35);
}
.btn-primary:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(88,151,254,.4); }
.btn-primary:active { transform: scale(.97); }

.btn-ghost {
  background: var(--white); color: var(--text-500);
  border: 1.5px solid var(--border);
}
.btn-ghost:hover { background: var(--blue-50); color: var(--blue); border-color: var(--blue-200); }

.btn-danger {
  background: rgba(244,63,94,.08); color: var(--rose);
  border: 1.5px solid rgba(244,63,94,.18);
}
.btn-danger:hover { background: rgba(244,63,94,.15); }

/* ═══════════════════════════════════════
   BRAND TABLE CARD
═══════════════════════════════════════ */
.table-card {
  background: var(--white); border-radius: var(--r);
  border: 1px solid var(--border); box-shadow: var(--s1);
  overflow: hidden;
  animation: fadeUp .45s .15s ease both;
  display: flex;
  flex-direction: column;
}

.table-card-head {
  display: flex; align-items: center; justify-content: space-between;
  padding: 18px 22px 16px;
  border-bottom: 1px solid var(--border-light);
}
.tch-left { display: flex; align-items: center; gap: 10px; }
.tch-title { font-size: 14px; font-weight: 700; color: var(--text-700); letter-spacing: -.1px; }
.tch-count {
  font-size: 11.5px; font-weight: 700;
  background: var(--blue-50); color: var(--blue);
  padding: 2px 9px; border-radius: 99px;
}
.tch-right { display: flex; align-items: center; gap: 8px; }

/* view toggle */
.view-toggle {
  display: flex; background: var(--bg);
  border-radius: 8px; padding: 3px; gap: 2px;
}
.vt-btn {
  width: 32px; height: 32px; border-radius: 6px; border: none;
  background: transparent; cursor: pointer;
  display: flex; align-items: center; justify-content: center;
  font-size: 13px; color: var(--text-400); transition: var(--t);
}
.vt-btn.active { background: var(--white); color: var(--blue); box-shadow: var(--s1); }
.vt-btn:hover:not(.active) { color: var(--blue); }

/* TABLE WRAPPER - Clean and functional */
.table-wrapper {
  height: auto;
  max-height: 500px;
  overflow-y: auto;
}

/* TABLE */
.brand-table { width: 100%; border-collapse: collapse; }
.brand-table thead th {
  font-size: 11px; font-weight: 700; text-transform: uppercase;
  letter-spacing: .65px; color: var(--text-300);
  padding: 12px 16px; text-align: left;
  background: var(--bg);
  border-bottom: 1px solid var(--border);
  white-space: nowrap;
}
.brand-table tbody tr {
  border-bottom: 1px solid var(--border-light);
  transition: var(--t); cursor: pointer;
}
.brand-table tbody tr:last-child { border-bottom: none; }
.brand-table tbody tr:hover { background: var(--blue-50); }
.brand-table tbody tr:hover .row-actions { opacity: 1; }
.brand-table tbody td {
  padding: 14px 16px; font-size: 13px; color: var(--text-700);
  vertical-align: middle;
}

/* brand name cell */
.brand-cell { display: flex; align-items: center; gap: 12px; }
.brand-avatar {
  width: 38px; height: 38px; border-radius: 10px;
  display: flex; align-items: center; justify-content: center;
  font-size: 14px; font-weight: 800; color: #fff; flex-shrink: 0;
  text-transform: uppercase;
}
.brand-name-text { font-size: 13.5px; font-weight: 700; color: var(--text-900); }
.brand-created { font-size: 11px; color: var(--text-400); margin-top: 1px; }

/* pic cell */
.pic-cell { display: flex; align-items: center; gap: 8px; }
.pic-ava {
  width: 28px; height: 28px; border-radius: 50%;
  background: var(--blue-100);
  display: flex; align-items: center; justify-content: center;
  font-size: 10.5px; font-weight: 700; color: var(--blue); flex-shrink: 0;
}
.pic-name { font-size: 13px; font-weight: 500; }

/* content count badge */
.content-count {
  display: inline-flex; align-items: center; gap: 4px;
  font-size: 12.5px; font-weight: 700; color: var(--text-700);
}
.content-count i { font-size: 11px; color: var(--blue); }

/* status pill */
.status-pill {
  display: inline-flex; align-items: center; gap: 6px;
  padding: 5px 12px; border-radius: 99px;
  font-size: 11.5px; font-weight: 700;
  white-space: nowrap; user-select: none;
}
.status-dot { width: 6px; height: 6px; border-radius: 50%; flex-shrink: 0; }
.sp-active   { background: rgba(16,185,129,.10); color: #065f46; }
.sp-active   .status-dot { background: var(--emerald); }
.sp-inactive { background: rgba(148,163,184,.12); color: var(--text-500); }
.sp-inactive .status-dot { background: var(--text-400); }

/* row actions */
.row-actions {
  display: flex; align-items: center; gap: 5px;
  opacity: 0; transition: var(--t);
}
.act-btn {
  width: 32px; height: 32px; border-radius: 8px; border: none;
  display: flex; align-items: center; justify-content: center;
  font-size: 13px; cursor: pointer; transition: var(--t);
}
.act-detail { background: var(--blue-50);           color: var(--blue);    }
.act-edit   { background: rgba(245,158,11,.10);     color: var(--amber);   }
.act-del    { background: rgba(244,63,94,.10);      color: var(--rose);    }
.act-detail:hover { background: var(--blue-100); transform: scale(1.08); }
.act-edit:hover   { background: rgba(245,158,11,.2); transform: scale(1.08); }
.act-del:hover    { background: rgba(244,63,94,.2);  transform: scale(1.08); }

/* ═══════════════════════════════════════
   MODAL OVERLAY
═══════════════════════════════════════ */
.overlay {
  position: fixed; inset: 0;
  background: rgba(13,21,38,.45);
  backdrop-filter: blur(4px);
  z-index: 500;
  display: flex; align-items: center; justify-content: center;
  opacity: 0; pointer-events: none;
  transition: opacity .25s ease;
}
.overlay.open { opacity: 1; pointer-events: all; }

/* ═══════════════════════════════════════
   MODAL — FORM TAMBAH / EDIT BRAND
═══════════════════════════════════════ */
.modal {
  background: var(--white); border-radius: 20px;
  width: 100%; max-width: 600px;
  box-shadow: var(--s3), 0 0 0 1px rgba(88,151,254,.08);
  transform: translateY(24px) scale(.97);
  transition: transform .3s cubic-bezier(.34,1.56,.64,1), opacity .25s ease;
  opacity: 0;
  max-height: 90vh; overflow-y: auto;
}
.overlay.open .modal { transform: translateY(0) scale(1); opacity: 1; }

.modal-head {
  padding: 24px 28px 0;
  display: flex; align-items: flex-start; justify-content: space-between;
}
.modal-title-wrap {}
.modal-eyebrow {
  font-size: 11px; font-weight: 700; letter-spacing: 1px;
  text-transform: uppercase; color: var(--blue);
  display: flex; align-items: center; gap: 6px; margin-bottom: 4px;
}
.modal-title { font-size: 20px; font-weight: 800; color: var(--text-900); letter-spacing: -.4px; }
.modal-subtitle { font-size: 13px; color: var(--text-400); margin-top: 3px; }

.modal-close {
  width: 36px; height: 36px; border-radius: 10px; border: none;
  background: var(--bg); cursor: pointer; transition: var(--t);
  display: flex; align-items: center; justify-content: center;
  color: var(--text-400); font-size: 15px; flex-shrink: 0;
  margin-top: 2px;
}
.modal-close:hover { background: rgba(244,63,94,.1); color: var(--rose); }

.modal-body { padding: 24px 28px; }

.modal-divider { height: 1px; background: var(--border-light); margin: 4px 0 20px; }

/* FORM GRID */
.form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
.form-grid .full { grid-column: 1 / -1; }

.form-group { display: flex; flex-direction: column; gap: 6px; }
.form-label {
  font-size: 12.5px; font-weight: 700; color: var(--text-700);
  display: flex; align-items: center; gap: 5px;
}
.form-label .req { color: var(--rose); font-size: 13px; }
.form-label .hint {
  font-size: 11px; font-weight: 400; color: var(--text-300);
  margin-left: 2px;
}

.form-input, .form-textarea, .form-select {
  width: 100%;
  font-family: 'DM Sans', sans-serif;
  font-size: 13.5px; color: var(--text-900);
  border: 1.5px solid var(--border);
  border-radius: var(--r-sm);
  background: var(--white);
  transition: var(--t); outline: none;
}
.form-input, .form-select { height: 42px; padding: 0 14px; }
.form-textarea { padding: 12px 14px; resize: vertical; min-height: 88px; line-height: 1.55; }
.form-select {
  appearance: none;
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6'%3E%3Cpath d='M0 0l5 6 5-6z' fill='%238fa3c4'/%3E%3C/svg%3E");
  background-repeat: no-repeat; background-position: right 14px center;
  cursor: pointer;
}
.form-input::placeholder, .form-textarea::placeholder { color: var(--text-300); }
.form-input:focus, .form-textarea:focus, .form-select:focus {
  border-color: var(--blue);
  box-shadow: 0 0 0 3.5px rgba(88,151,254,.12);
  background: var(--white);
}
.form-input.error, .form-textarea.error, .form-select.error {
  border-color: var(--rose);
  box-shadow: 0 0 0 3px rgba(244,63,94,.1);
}
.form-error { font-size: 11.5px; color: var(--rose); font-weight: 500; display: none; }
.form-error.show { display: block; }

/* input with icon */
.input-wrap { position: relative; }
.input-wrap i {
  position: absolute; left: 13px; top: 50%; transform: translateY(-50%);
  color: var(--text-400); font-size: 13.5px; pointer-events: none;
}
.input-wrap .form-input { padding-left: 38px; }

/* tone chips */
.tone-chips { display: flex; flex-wrap: wrap; gap: 7px; margin-top: 2px; }
.tone-chip {
  padding: 5px 12px; border-radius: 99px; border: 1.5px solid var(--border);
  font-size: 12px; font-weight: 600; color: var(--text-500);
  cursor: pointer; transition: var(--t); background: var(--white);
  user-select: none;
}
.tone-chip:hover { border-color: var(--blue-200); color: var(--blue); background: var(--blue-50); }
.tone-chip.selected {
  background: var(--blue); color: #fff; border-color: var(--blue);
  box-shadow: 0 2px 8px rgba(88,151,254,.3);
}

/* status toggle */
.status-toggle { display: flex; gap: 10px; margin-top: 2px; }
.st-option {
  flex: 1; padding: 10px 14px; border-radius: var(--r-sm);
  border: 1.5px solid var(--border); cursor: pointer; transition: var(--t);
  display: flex; align-items: center; gap: 8px;
  font-size: 13px; font-weight: 600; color: var(--text-500);
  user-select: none;
}
.st-option:hover { border-color: var(--blue-200); background: var(--blue-50); }
.st-dot { width: 8px; height: 8px; border-radius: 50%; }
.st-active  .st-dot { background: var(--emerald); }
.st-inactive .st-dot { background: var(--text-400); }
.st-option.selected.st-active {
  border-color: var(--emerald); background: rgba(16,185,129,.06);
  color: #065f46;
}
.st-option.selected.st-inactive {
  border-color: var(--text-300); background: var(--bg); color: var(--text-500);
}

/* modal footer */
.modal-footer {
  padding: 0 28px 24px;
  display: flex; align-items: center; justify-content: space-between;
  gap: 10px;
}
.mf-left { font-size: 12px; color: var(--text-300); }
.mf-right { display: flex; gap: 9px; }

/* ═══════════════════════════════════════
   MODAL — DETAIL BRAND
═══════════════════════════════════════ */
.detail-modal { max-width: 520px; }
.detail-hero {
  padding: 28px 28px 0;
  display: flex; align-items: center; gap: 16px;
}
.detail-avatar {
  width: 60px; height: 60px; border-radius: 16px;
  display: flex; align-items: center; justify-content: center;
  font-size: 22px; font-weight: 800; color: #fff; flex-shrink: 0;
}
.detail-name { font-size: 20px; font-weight: 800; color: var(--text-900); letter-spacing: -.4px; }
.detail-meta { font-size: 12.5px; color: var(--text-400); margin-top: 4px; display: flex; gap: 12px; }
.detail-body { padding: 20px 28px; }
.detail-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; margin-top: 16px; }
.detail-item {}
.detail-item-label { font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: .6px; color: var(--text-300); margin-bottom: 4px; }
.detail-item-value { font-size: 13px; font-weight: 600; color: var(--text-700); line-height: 1.4; }
.detail-item.full { grid-column: 1 / -1; }
.detail-tone-tags { display: flex; flex-wrap: wrap; gap: 6px; margin-top: 4px; }
.detail-tone-tag {
  padding: 3px 10px; border-radius: 99px;
  background: var(--blue-50); color: var(--blue);
  font-size: 11.5px; font-weight: 600;
}

/* content mini chart */
.content-bar { display: flex; flex-direction: column; gap: 6px; margin-top: 8px; }
.cb-row { display: flex; align-items: center; gap: 8px; }
.cb-label { font-size: 11.5px; color: var(--text-500); width: 90px; flex-shrink: 0; }
.cb-track { flex: 1; height: 6px; background: var(--border); border-radius: 99px; overflow: hidden; }
.cb-fill { height: 100%; border-radius: 99px; transition: width 1s cubic-bezier(.4,0,.2,1); }
.cb-num { font-size: 11.5px; font-weight: 700; color: var(--text-700); width: 24px; text-align: right; }

/* ═══════════════════════════════════════
   MODAL — DELETE CONFIRM
═══════════════════════════════════════ */
.delete-modal { max-width: 420px; }
.delete-icon-wrap {
  width: 60px; height: 60px; border-radius: 16px;
  background: rgba(244,63,94,.1);
  display: flex; align-items: center; justify-content: center;
  font-size: 24px; color: var(--rose); margin: 0 auto 16px;
}

/* ═══════════════════════════════════════
   TOAST NOTIFICATION
═══════════════════════════════════════ */
.toast-container {
  position: fixed; bottom: 28px; right: 28px;
  z-index: 900; display: flex; flex-direction: column; gap: 10px;
  pointer-events: none;
}
.toast {
  display: flex; align-items: center; gap: 11px;
  padding: 13px 18px; border-radius: 12px;
  background: var(--text-900); color: #fff;
  font-size: 13px; font-weight: 500;
  box-shadow: 0 8px 32px rgba(13,21,38,.25);
  transform: translateX(110%);
  transition: transform .35s cubic-bezier(.34,1.56,.64,1);
  pointer-events: all; min-width: 260px;
}
.toast.show { transform: translateX(0); }
.toast-ic {
  width: 28px; height: 28px; border-radius: 8px; flex-shrink: 0;
  display: flex; align-items: center; justify-content: center; font-size: 13px;
}
.toast-success .toast-ic { background: rgba(16,185,129,.2); color: var(--emerald); }
.toast-warn    .toast-ic { background: rgba(245,158,11,.2); color: var(--amber); }
.toast-error   .toast-ic { background: rgba(244,63,94,.2);  color: var(--rose); }

/* ═══════════════════════════════════════
   EMPTY STATE
═══════════════════════════════════════ */
.empty-state {
  padding: 60px 20px;
  display: flex; flex-direction: column; align-items: center; gap: 12px;
  display: none;
}
.empty-state.show { display: flex; }
.empty-ic {
  width: 64px; height: 64px; border-radius: 18px;
  background: var(--blue-50);
  display: flex; align-items: center; justify-content: center;
  font-size: 24px; color: var(--blue);
}
.empty-title { font-size: 15px; font-weight: 700; color: var(--text-700); }
.empty-sub { font-size: 13px; color: var(--text-400); text-align: center; }

/* ═══════════════════════════════════════
   ANIMATIONS
═══════════════════════════════════════ */
@keyframes fadeUp {
  from { opacity: 0; transform: translateY(14px); }
  to   { opacity: 1; transform: translateY(0); }
}
@keyframes spin {
  to { transform: rotate(360deg); }
}
.spin { animation: spin .7s linear infinite; display: inline-block; }
</style>
@endpush

@section('content')
<!-- BODY -->
<div class="body">

  <!-- STAT CARDS -->
  <div class="brand-stats">
    <div class="bstat bstat-blue" style="--i:0">
      <div class="bstat-ic"><i class="fa-solid fa-tag"></i></div>
      <div class="bstat-num" data-target="{{ $brands->count() }}">0</div>
      <div class="bstat-lbl">Total Brand</div>
      <div class="bstat-sub sub-up"><i class="fa-solid fa-arrow-trend-up"></i> +{{ $brands->where('created_at', '>=', now()->subMonth())->count() }} bulan ini</div>
    </div>
    <div class="bstat bstat-em" style="--i:1">
      <div class="bstat-ic"><i class="fa-solid fa-circle-dot"></i></div>
      <div class="bstat-num" data-target="{{ $brands->where('status', 'Active')->count() }}">0</div>
      <div class="bstat-lbl">Brand Aktif</div>
      <div class="bstat-sub sub-up"><i class="fa-solid fa-check"></i> Berjalan</div>
    </div>
    <div class="bstat bstat-amb" style="--i:2">
      <div class="bstat-ic"><i class="fa-solid fa-circle-pause"></i></div>
      <div class="bstat-num" data-target="{{ $brands->where('status', 'Non Active')->count() }}">0</div>
      <div class="bstat-lbl">Brand Non-Aktif</div>
      <div class="bstat-sub sub-warn"><i class="fa-solid fa-minus"></i> Tidak aktif</div>
    </div>
    <div class="bstat bstat-rose" style="--i:3">
      <div class="bstat-ic"><i class="fa-solid fa-photo-film"></i></div>
      <div class="bstat-num" data-target="{{ $brands->sum('contents_count') ?? 0 }}">0</div>
      <div class="bstat-lbl">Total Konten</div>
      <div class="bstat-sub sub-up"><i class="fa-solid fa-arrow-trend-up"></i> +{{ $brands->where('created_at', '>=', now()->subMonth())->sum('contents_count') ?? 0 }} bulan ini</div>
    </div>
  </div>

  <!-- TOOLBAR -->
  <div class="toolbar">
    <div class="search-wrap">
      <i class="fa-solid fa-magnifying-glass"></i>
      <input class="search-input" id="searchInput" type="text" placeholder="Cari nama brand, PIC, kontak..."/>
    </div>
    <select class="filter-select" id="filterStatus" onchange="filterTable()">
      <option value="">Semua Status</option>
      <option value="active">Active</option>
      <option value="inactive">Non Active</option>
    </select>
    <div class="toolbar-spacer"></div>
    <a href="{{ route('brands.export-pdf') }}" class="btn btn-ghost" style="text-decoration:none;color:inherit;display:inline-flex;align-items:center;gap:7px;">
      <i class="fa-solid fa-file-pdf"></i> Export PDF
    </a>
    <button class="btn btn-primary" onclick="openAddModal()">
      <i class="fa-solid fa-plus"></i> Tambah Brand
    </button>
  </div>

  <!-- TABLE CARD -->
  <div class="table-card">
    <div class="table-card-head">
      <div class="tch-left">
        <div class="tch-title">Daftar Brand</div>
        <div class="tch-count" id="brandCount">{{ $brands->count() }} brand</div>
      </div>
      <div class="tch-right">
        <div class="view-toggle">
          <button class="vt-btn active" id="btnList" onclick="switchView('list')" title="List view">
            <i class="fa-solid fa-list"></i>
          </button>
          <button class="vt-btn" id="btnGrid" onclick="switchView('grid')" title="Grid view">
            <i class="fa-solid fa-grid-2"></i>
          </button>
        </div>
      </div>
    </div>

    <!-- LIST VIEW -->
    <div id="listView">
      <div class="table-wrapper">
        <table class="brand-table">
          <thead>
            <tr>
              <th style="width:28%">Nama Brand</th>
              <th style="width:18%">PIC</th>
              <th style="width:18%">Kontak</th>
              <th style="width:12%">Jumlah Konten</th>
              <th style="width:12%">Status</th>
              <th style="width:12%">Aksi</th>
            </tr>
          </thead>
          <tbody id="brandTableBody">
            @foreach($brands as $brand)
            <tr onclick="openDetail({{ $brand->id }})">
              <td>
                <div class="brand-cell">
                  <div class="brand-avatar" style="background:#5897fe">{{ $brand->name ? strtoupper(substr($brand->name, 0, 2)) : '??' }}</div>
                  <div>
                    <div class="brand-name-text">{{ $brand->name ?: 'Unnamed Brand' }}</div>
                    <div class="brand-created">Dibuat {{ $brand->created_at ? $brand->created_at->format('M Y') : 'Unknown' }}</div>
                  </div>
                </div>
              </td>
              <td>
                <div class="pic-cell">
                  <div class="pic-ava">{{ $brand->pic ? strtoupper(substr($brand->pic, 0, 2)) : '??' }}</div>
                  <span class="pic-name">{{ $brand->pic ?: 'No PIC' }}</span>
                </div>
              </td>
              <td style="color:var(--text-500);font-size:12.5px">{{ $brand->contact ?: 'No Contact' }}</td>
              <td>
                <span class="content-count"><i class="fa-solid fa-film"></i> {{ $brand->contents_count ?? 0 }} konten</span>
              </td>
              <td>
                <span class="status-pill {{ $brand->status === 'Active' ? 'sp-active' : 'sp-inactive' }}">
                  <span class="status-dot"></span>{{ $brand->status ?: 'Unknown' }}
                </span>
              </td>
              <td onclick="event.stopPropagation()">
                <div class="row-actions">
                  <button class="act-btn act-detail" onclick="openDetail({{ $brand->id }})" title="Detail"><i class="fa-solid fa-eye"></i></button>
                  <button class="act-btn act-edit"   onclick="openEdit({{ $brand->id }})"   title="Edit"><i class="fa-solid fa-pen"></i></button>
                  <button class="act-btn act-del"    onclick="openDelete({{ $brand->id }})" title="Hapus"><i class="fa-solid fa-trash-can"></i></button>
                </div>
              </td>
            </tr>
            @endforeach
            {{-- Show final count --}}
            <tr style="background: #f8f9fa; font-weight: bold;">
              <td colspan="6" style="text-align: center; padding: 5px; font-size: 12px;">
                Total brands displayed: {{ $brands->count() }} | Database count: {{ $brands->count() }}
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="empty-state" id="emptyState">
        <div class="empty-ic"><i class="fa-solid fa-tag"></i></div>
        <div class="empty-title">Tidak ada brand ditemukan</div>
        <div class="empty-sub">Coba ubah kata kunci pencarian atau filter yang digunakan.</div>
      </div>
    </div>

    <!-- GRID VIEW -->
    <div class="brand-grid" id="gridView"></div>

  </div>

</div><!-- /body -->

<!-- ════════════ MODAL: ADD / EDIT ════════════ -->
<div class="overlay" id="formOverlay" onclick="closeOnOverlay(event,'formOverlay')">
  <div class="modal" id="formModal" onclick="event.stopPropagation()">
    <div class="modal-head">
      <div class="modal-title-wrap">
        <div class="modal-eyebrow"><i class="fa-solid fa-tag"></i> <span id="modalEyebrow">Brand Management</span></div>
        <div class="modal-title" id="modalTitle">Tambah Brand Baru</div>
        <div class="modal-subtitle" id="modalSubtitle">Isi data brand untuk ditambahkan ke sistem</div>
      </div>
      <button class="modal-close" onclick="closeModal('formOverlay')"><i class="fa-solid fa-xmark"></i></button>
    </div>
    <div class="modal-body">
      <div class="modal-divider"></div>
      <form id="brandForm" onsubmit="submitForm(event)" novalidate>
        <input type="hidden" id="editId" value=""/>
        <div class="form-grid">
          <!-- Nama Brand -->
          <div class="form-group full">
            <label class="form-label">Nama Brand <span class="req">*</span></label>
            <div class="input-wrap">
              <i class="fa-solid fa-tag"></i>
              <input class="form-input" id="fName" type="text" placeholder="Contoh: GlowSkin, BeautyHaus..."/>
            </div>
            <span class="form-error" id="errName">Nama brand wajib diisi.</span>
          </div>
          <!-- PIC -->
          <div class="form-group">
            <label class="form-label">PIC / Penanggung Jawab <span class="req">*</span></label>
            <div class="input-wrap">
              <i class="fa-solid fa-user"></i>
              <input class="form-input" id="fPic" type="text" placeholder="Nama penanggung jawab"/>
            </div>
            <span class="form-error" id="errPic">PIC wajib diisi.</span>
          </div>
          <!-- Kontak -->
          <div class="form-group">
            <label class="form-label">Kontak <span class="req">*</span></label>
            <div class="input-wrap">
              <i class="fa-solid fa-phone"></i>
              <input class="form-input" id="fContact" type="text" placeholder="No. HP / Email kontak"/>
            </div>
            <span class="form-error" id="errContact">Kontak wajib diisi.</span>
          </div>
          <!-- Target Market -->
          <div class="form-group full">
            <label class="form-label">Target Market <span class="req">*</span> <span class="hint">— Deskripsikan audiens utama brand</span></label>
            <textarea class="form-textarea" id="fTarget" placeholder="Contoh: Wanita usia 18–35 tahun, tertarik dunia kecantikan dan perawatan kulit..."></textarea>
            <span class="form-error" id="errTarget">Target market wajib diisi.</span>
          </div>
          <!-- Tone Komunikasi -->
          <div class="form-group full">
            <label class="form-label">Tone Komunikasi <span class="req">*</span> <span class="hint">— Pilih satu atau lebih</span></label>
            <div class="tone-chips" id="toneChips">
              <span class="tone-chip" onclick="toggleTone(this)" data-val="Friendly">Friendly</span>
              <span class="tone-chip" onclick="toggleTone(this)" data-val="Professional">Professional</span>
              <span class="tone-chip" onclick="toggleTone(this)" data-val="Playful">Playful</span>
              <span class="tone-chip" onclick="toggleTone(this)" data-val="Inspirational">Inspirational</span>
              <span class="tone-chip" onclick="toggleTone(this)" data-val="Educational">Educational</span>
              <span class="tone-chip" onclick="toggleTone(this)" data-val="Luxury">Luxury</span>
              <span class="tone-chip" onclick="toggleTone(this)" data-val="Casual">Casual</span>
              <span class="tone-chip" onclick="toggleTone(this)" data-val="Bold">Bold</span>
            </div>
            <span class="form-error" id="errTone">Pilih minimal satu tone komunikasi.</span>
          </div>
          <!-- Status -->
          <div class="form-group full">
            <label class="form-label">Status Brand <span class="req">*</span></label>
            <div class="status-toggle">
              <div class="st-option st-active selected" id="stActive" onclick="selectStatus('Active')">
                <span class="st-dot"></span> Active
              </div>
              <div class="st-option st-inactive" id="stInactive" onclick="selectStatus('Non Active')">
                <span class="st-dot"></span> Non Active
              </div>
            </div>
            <input type="hidden" id="fStatus" value="Active"/>
          </div>
        </div>
      </form>
    </div>
    <div class="modal-footer">
      <div class="mf-left"><i class="fa-solid fa-asterisk" style="font-size:8px"></i> Wajib diisi</div>
      <div class="mf-right">
        <button class="btn btn-ghost" onclick="closeModal('formOverlay')">Batal</button>
        <button class="btn btn-primary" id="submitBtn" onclick="submitForm(event)">
          <i class="fa-solid fa-floppy-disk"></i> Simpan Brand
        </button>
      </div>
    </div>
  </div>
</div>

<!-- ════════════ MODAL: DETAIL ════════════ -->
<div class="overlay" id="detailOverlay" onclick="closeOnOverlay(event,'detailOverlay')">
  <div class="modal detail-modal" onclick="event.stopPropagation()">
    <div class="modal-head" style="padding:24px 28px 0">
      <div></div>
      <button class="modal-close" onclick="closeModal('detailOverlay')"><i class="fa-solid fa-xmark"></i></button>
    </div>
    <div class="detail-hero" id="detailHero"></div>
    <div class="detail-body" id="detailBody"></div>
    <div class="modal-footer">
      <div></div>
      <div class="mf-right">
        <button class="btn btn-ghost" onclick="closeModal('detailOverlay')">Tutup</button>
        <button class="btn btn-primary" id="detailEditBtn"><i class="fa-solid fa-pen"></i> Edit Brand</button>
      </div>
    </div>
  </div>
</div>

<!-- ════════════ MODAL: DELETE ════════════ -->
<div class="overlay" id="deleteOverlay" onclick="closeOnOverlay(event,'deleteOverlay')">
  <div class="modal delete-modal" onclick="event.stopPropagation()">
    <div class="modal-body" style="text-align:center;padding:32px 28px 8px">
      <div class="delete-icon-wrap"><i class="fa-solid fa-trash-can"></i></div>
      <div style="font-size:18px;font-weight:800;color:var(--text-900);margin-bottom:8px">Hapus Brand?</div>
      <div id="deleteMsg" style="font-size:13.5px;color:var(--text-500);line-height:1.55"></div>
    </div>
    <div class="modal-footer" style="justify-content:center;gap:10px">
      <button class="btn btn-ghost" style="min-width:100px" onclick="closeModal('deleteOverlay')">Batal</button>
      <button class="btn btn-danger" style="min-width:100px" id="confirmDeleteBtn"><i class="fa-solid fa-trash-can"></i> Hapus</button>
    </div>
  </div>
</div>

<!-- TOASTS -->
<div class="toast-container" id="toastContainer"></div>
@endsection

@push('scripts')
<script>
/* ════════════════════════════════════════
   DATA FROM DATABASE
════════════════════════════════════════ */
const BRAND_COLORS = [
  '#5897fe','#10b981','#f59e0b','#8b5cf6',
  '#f43f5e','#06b6d4','#ff7849','#3b82f6',
  '#ec4899','#14b8a6','#6366f1','#84cc16',
];

let brands = @json($brands);
// Process brands data to ensure consistent structure
brands = brands.map(brand => {
  try {
    return {
      id: brand.id,
      name: brand.name || '',
      pic: brand.pic || '',
      contact: brand.contact || '',
      target: brand.target_market || '',
      tone: brand.tone ? (Array.isArray(brand.tone) ? brand.tone : String(brand.tone).split(',')) : [],
      status: brand.status || 'Active',
      contents: brand.contents || 0,
      published: brand.published_count || 0,
      onProgress: brand.in_progress_count || 0,
      created: brand.created || 'Unknown'
    };
  } catch (error) {
    console.error('Error processing brand:', brand, error);
    return {
      id: brand.id || 0,
      name: 'Error Brand',
      pic: 'Error',
      contact: 'Error',
      target: '',
      tone: [],
      status: 'Active',
      contents: 0,
      published: 0,
      onProgress: 0,
      created: 'Unknown'
    };
  }
}).filter(brand => brand && brand.id); // Filter out null/undefined brands

console.log('Processed brands from database:', brands);
console.log('Total brands from database:', brands.length);
let nextId = {{ $brands->max('id') + 1 }};
let currentPage = 1;
const perPage = 1000; // Set to high number to show all brands
let filteredBrands = [...brands];
let currentView = 'list';
let deleteTargetId = null;

/* ══════════════════════════════════════════
   INIT
══════════════════════════════════════════ */
window.addEventListener('DOMContentLoaded', () => {
  animateCounters();
  
  // Initialize statistics on page load
  updateStats();
  
  // Enable real-time search functionality
  const searchInput = document.getElementById('searchInput');
  if (searchInput) {
    searchInput.addEventListener('input', filterTable);
    console.log('Real-time search event listener attached');
  } else {
    console.error('Search input not found!');
  }
  
  // Enable status filter functionality
  const filterStatus = document.getElementById('filterStatus');
  if (filterStatus) {
    filterStatus.addEventListener('change', filterTable);
    console.log('Status filter event listener attached');
  } else {
    console.error('Status filter not found!');
  }
  
  // Enable renderTable for dynamic updates
  renderTable();
  
  // Debug table-wrapper
  const tableWrapper = document.querySelector('.table-wrapper');
  console.log('Table wrapper element:', tableWrapper);
  console.log('Table wrapper styles:', {
    height: tableWrapper ? window.getComputedStyle(tableWrapper).height : 'not found',
    overflowY: tableWrapper ? window.getComputedStyle(tableWrapper).overflowY : 'not found',
    scrollHeight: tableWrapper ? tableWrapper.scrollHeight : 'not found',
    clientHeight: tableWrapper ? tableWrapper.clientHeight : 'not found'
  });
});

/* ══════════════════════════════════════════
   COUNT UP
══════════════════════════════════════════ */
function animateCounters() {
  document.querySelectorAll('[data-target]').forEach((el, i) => {
    const target = +el.dataset.target;
    let n = 0;
    const tick = () => {
      n = Math.min(n + Math.ceil(target / 25), target);
      el.textContent = n;
      if (n < target) requestAnimationFrame(tick);
    };
    setTimeout(tick, 300 + i * 60);
  });
}

/* ══════════════════════════════════════════
   COLOR HELPER
══════════════════════════════════════════ */
function brandColor(id) { return BRAND_COLORS[(id - 1) % BRAND_COLORS.length]; }
function brandInitials(name) { return name.split(' ').slice(0,2).map(w=>w[0]).join('').toUpperCase(); }

/* ══════════════════════════════════════════
   REAL-TIME SEARCH & FILTER
══════════════════════════════════════════ */
function filterTable() {
  console.log('=== REAL-TIME SEARCH & FILTER CALLED ===');
  
  // Get search query and status filter
  const searchQuery = document.getElementById('searchInput').value.toLowerCase().trim();
  const statusFilter = document.getElementById('filterStatus').value;
  
  console.log('Search query:', searchQuery);
  console.log('Status filter:', statusFilter);
  
  // Filter brands based on search and status
  filteredBrands = brands.filter(brand => {
    // Search filter (nama brand, PIC, kontak)
    const matchesSearch = !searchQuery || 
      brand.name.toLowerCase().includes(searchQuery) ||
      brand.pic.toLowerCase().includes(searchQuery) ||
      brand.contact.toLowerCase().includes(searchQuery);
    
    // Status filter
    const matchesStatus = !statusFilter || 
      (statusFilter === 'active' && brand.status === 'Active') ||
      (statusFilter === 'inactive' && brand.status === 'Non Active');
    
    return matchesSearch && matchesStatus;
  });
  
  console.log('Filtered results:', filteredBrands.length, 'of', brands.length);
  
  // Update UI immediately - no reload needed
  renderTable();
  updateStats();
  
  // Update search results info
  updateSearchInfo(searchQuery, statusFilter);
  
  console.log('=== SEARCH & FILTER COMPLETE ===');
}

function updateSearchInfo(searchQuery, statusFilter) {
  // Update brand count to show filtered results
  const brandCountEl = document.getElementById('brandCount');
  if (brandCountEl) {
    const count = filteredBrands.length;
    const total = brands.length;
    brandCountEl.textContent = count + ' brand' + (count < total ? ` (dari ${total})` : '');
  }
  
  // Show/hide empty state
  const emptyState = document.getElementById('emptyState');
  const tableBody = document.getElementById('brandTableBody');
  
  if (filteredBrands.length === 0) {
    console.log('No results found, showing empty state');
    if (emptyState) emptyState.classList.add('show');
    if (tableBody) tableBody.innerHTML = '';
  } else {
    console.log('Results found, hiding empty state');
    if (emptyState) emptyState.classList.remove('show');
  }
  
  // Log search summary
  if (searchQuery || statusFilter) {
    console.log(`Search: "${searchQuery}" | Filter: "${statusFilter}" | Results: ${filteredBrands.length}`);
  }
}

/* ══════════════════════════════════════════
   RENDER TABLE - Display All Database Data
══════════════════════════════════════════ */
function renderTable() {
  console.log('renderTable called - Displaying all database data');
  console.log('Total brands in database:', brands.length);
  console.log('Filtered brands for display:', filteredBrands.length);
  
  // Update brand count in header
  const brandCountEl = document.getElementById('brandCount');
  if (brandCountEl) {
    const count = filteredBrands.length;
    const total = brands.length;
    brandCountEl.textContent = count + ' brand' + (count < total ? ` (dari ${total})` : '');
    console.log('Brand count updated:', count + ' brand' + (count < total ? ` (dari ${total})` : ''));
  }

  // Get table elements
  const tbody = document.getElementById('brandTableBody');
  const emptyState = document.getElementById('emptyState');
  
  console.log('Table elements found:', { tbody: !!tbody, emptyState: !!emptyState });

  // Display all filtered brands (no pagination - show all data)
  if (filteredBrands.length === 0) {
    console.log('No brands to display, showing empty state');
    if (tbody) tbody.innerHTML = '';
    if (emptyState) {
      emptyState.classList.add('show');
      emptyState.innerHTML = `
        <div class="empty-ic"><i class="fa-solid fa-search"></i></div>
        <div class="empty-title">Data tidak ditemukan</div>
        <div class="empty-sub">Coba ubah kata kunci pencarian atau filter yang digunakan.</div>
      `;
    }
  } else {
    console.log('Displaying', filteredBrands.length, 'brands in table');
    if (emptyState) emptyState.classList.remove('show');
    
    // Generate table HTML for all brands
    const tableHTML = filteredBrands.map((brand, index) => {
      return `
        <tr onclick="openDetail(${brand.id})">
          <td>
            <div class="brand-cell">
              <div class="brand-avatar" style="background:${brandColor(brand.id)}">${brandInitials(brand.name)}</div>
              <div>
                <div class="brand-name-text">${brand.name || 'Unnamed Brand'}</div>
                <div class="brand-created">Dibuat ${brand.created || 'Unknown'}</div>
              </div>
            </div>
          </td>
          <td>
            <div class="pic-cell">
              <div class="pic-ava">${brand.pic ? brand.pic.split(' ').slice(0,2).map(w=>w[0]).join('').toUpperCase() : '??'}</div>
              <span class="pic-name">${brand.pic || 'No PIC'}</span>
            </div>
          </td>
          <td style="color:var(--text-500);font-size:12.5px">${brand.contact || 'No Contact'}</td>
          <td>
            <span class="content-count"><i class="fa-solid fa-film"></i> ${brand.contents || 0} konten</span>
          </td>
          <td>
            <span class="status-pill ${brand.status === 'Active' ? 'sp-active' : 'sp-inactive'}">
              <span class="status-dot"></span>${brand.status || 'Unknown'}
            </span>
          </td>
          <td onclick="event.stopPropagation()">
            <div class="row-actions">
              <button class="act-btn act-detail" onclick="openDetail(${brand.id})" title="Detail"><i class="fa-solid fa-eye"></i></button>
              <button class="act-btn act-edit"   onclick="openEdit(${brand.id})"   title="Edit"><i class="fa-solid fa-pen"></i></button>
              <button class="act-btn act-del"    onclick="openDelete(${brand.id})" title="Hapus"><i class="fa-solid fa-trash-can"></i></button>
            </div>
          </td>
        </tr>
      `;
    }).join('');
    
    if (tbody) {
      tbody.innerHTML = tableHTML;
    }
  }
}

/* ══════════════════════════════════════════
   RENDER GRID
══════════════════════════════════════════ */
function renderGrid(page) {
  const grid = document.getElementById('gridView');
  if (!page.length) { grid.innerHTML = ''; return; }
  grid.innerHTML = page.map(b => `
    <div class="grid-card" onclick="openDetail(${b.id})">
      <div class="gc-head">
        <div class="gc-brand">
          <div class="gc-avatar" style="background:${brandColor(b.id)}">${brandInitials(b.name)}</div>
          <div>
            <div class="gc-name">${b.name}</div>
            <div class="gc-date">Dibuat ${b.created}</div>
          </div>
        </div>
        <span class="status-pill ${b.status==='Active'?'sp-active':'sp-inactive'}">
          <span class="status-dot"></span>${b.status}
        </span>
      </div>
      <div class="gc-divider"></div>
      <div class="gc-row"><span class="gc-label">PIC</span><span class="gc-value">${b.pic}</span></div>
      <div class="gc-row"><span class="gc-label">Kontak</span><span class="gc-value" style="font-size:12px">${b.contact}</span></div>
      <div class="gc-row"><span class="gc-label">Konten</span><span class="gc-value">${b.contents} konten</span></div>
      <div class="gc-row"><span class="gc-label">Tone</span><span class="gc-value tone-text">${b.tone.join(', ')}</span></div>
      <div class="grid-actions" onclick="event.stopPropagation()">
        <button class="act-btn act-detail" onclick="openDetail(${b.id})"><i class="fa-solid fa-eye"></i> <span>Detail</span></button>
        <button class="act-btn act-edit"   onclick="openEdit(${b.id})">  <i class="fa-solid fa-pen"></i> <span>Edit</span></button>
        <button class="act-btn act-del"    onclick="openDelete(${b.id})"><i class="fa-solid fa-trash-can"></i> <span>Hapus</span></button>
      </div>
    </div>
  `).join('');
}

/* ══════════════════════════════════════════
   VIEW TOGGLE
══════════════════════════════════════════ */
function switchView(v) {
  currentView = v;
  document.getElementById('btnList').classList.toggle('active', v==='list');
  document.getElementById('btnGrid').classList.toggle('active', v==='grid');
  document.getElementById('listView').style.display  = v==='list' ? '' : 'none';
  const grid = document.getElementById('gridView');
  grid.classList.toggle('show', v==='grid');
  if (v==='grid') renderGrid(filteredBrands);
}

/* ══════════════════════════════════════════
   MODAL HELPERS
══════════════════════════════════════════ */
function openModal(id)  { document.getElementById(id).classList.add('open'); document.body.style.overflow = 'hidden'; }
function closeModal(id) { document.getElementById(id).classList.remove('open'); document.body.style.overflow = ''; }
function closeOnOverlay(e, id) { if (e.target === document.getElementById(id)) closeModal(id); }

/* ══════════════════════════════════════════
   FORM — ADD
══════════════════════════════════════════ */
function openAddModal() {
  document.getElementById('editId').value = '';
  document.getElementById('modalEyebrow').textContent = 'Tambah Brand';
  document.getElementById('modalTitle').textContent   = 'Tambah Brand Baru';
  document.getElementById('modalSubtitle').textContent = 'Isi data brand untuk ditambahkan ke sistem';
  document.getElementById('submitBtn').innerHTML = '<i class="fa-solid fa-floppy-disk"></i> Simpan Brand';
  resetForm();
  openModal('formOverlay');
}

/* ══════════════════════════════════════════
   FORM — EDIT
══════════════════════════════════════════ */
function openEdit(id) {
  closeModal('detailOverlay');
  const b = brands.find(x => x.id === id);
  if (!b) return;
  document.getElementById('editId').value = id;
  document.getElementById('modalEyebrow').textContent = 'Edit Brand';
  document.getElementById('modalTitle').textContent   = 'Edit Brand';
  document.getElementById('modalSubtitle').textContent = `Mengubah data brand: ${b.name}`;
  document.getElementById('submitBtn').innerHTML = '<i class="fa-solid fa-floppy-disk"></i> Update Brand';

  resetForm();
  document.getElementById('fName').value    = b.name;
  document.getElementById('fPic').value     = b.pic;
  document.getElementById('fContact').value = b.contact;
  document.getElementById('fTarget').value  = b.target;
  document.getElementById('fStatus').value  = b.status;

  // tone chips
  document.querySelectorAll('.tone-chip').forEach(chip => {
    chip.classList.toggle('selected', b.tone.includes(chip.dataset.val));
  });

  // status
  selectStatus(b.status);
  openModal('formOverlay');
}

/* ══════════════════════════════════════════
   FORM — RESET
══════════════════════════════════════════ */
function resetForm() {
  ['fName','fPic','fContact','fTarget'].forEach(id => {
    const el = document.getElementById(id);
    el.value = '';
    el.classList.remove('error');
  });
  document.querySelectorAll('.form-error').forEach(e => e.classList.remove('show'));
  document.querySelectorAll('.tone-chip').forEach(c => c.classList.remove('selected'));
  selectStatus('Active');
}

/* ══════════════════════════════════════════
   TONE CHIP
══════════════════════════════════════════ */
function toggleTone(chip) {
  chip.classList.toggle('selected');
  document.getElementById('errTone').classList.remove('show');
}

/* ══════════════════════════════════════════
   STATUS SELECT
══════════════════════════════════════════ */
function selectStatus(val) {
  document.getElementById('fStatus').value = val;
  document.getElementById('stActive').classList.toggle('selected',   val === 'Active');
  document.getElementById('stInactive').classList.toggle('selected', val === 'Non Active');
}

/* ══════════════════════════════════════════
   FORM SUBMIT
══════════════════════════════════════════ */
function submitForm(e) {
  e.preventDefault();
  const btn = document.getElementById('submitBtn');
  btn.innerHTML = '<i class="fa-solid fa-circle-notch spin"></i> Menyimpan...';
  btn.disabled = true;

  try {
    const editId = document.getElementById('editId').value;
    const isEditMode = editId && editId !== '' && editId !== '0';
    
    const name = document.getElementById('fName').value.trim();
    const pic = document.getElementById('fPic').value.trim();
    const contact = document.getElementById('fContact').value.trim();
    const target = document.getElementById('fTarget').value.trim();
    const toneChips = document.querySelectorAll('.tone-chip.selected');
    const tone = Array.from(toneChips).map(c => c.dataset.val || c.textContent).join(',');
    const status = document.getElementById('fStatus').value;
    
    if (!name || !pic || !contact || !target) {
      showToast('error', 'Nama Brand, PIC, Kontak, dan Target Market wajib diisi!');
      resetButton();
      return;
    }
    
    const brandData = {
      name: name,
      pic: pic,
      contact: contact,
      target_market: target,
      tone: tone || 'Modern',
      status: status
    };

    if (isEditMode) {
      submitEditToDatabase(editId, brandData, btn);
    } else {
      submitAddToDatabase(brandData, btn);
    }

  } catch (error) {
    showToast('error', 'Terjadi kesalahan saat menyimpan brand: ' + error.message);
    resetButton();
  }
}

function submitEditToDatabase(editId, brandData, btn) {
  const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
  closeModal('formOverlay');

  fetch(`/brands/${editId}`, {
    method: 'PUT',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': csrfToken,
      'Accept': 'application/json'
    },
    body: JSON.stringify({
      _method: 'PUT',
      ...brandData
    })
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      const idx = brands.findIndex(b => b.id === parseInt(editId));
      if (idx !== -1) {
        brands[idx] = {
          id: data.brand.id,
          name: data.brand.name,
          pic: data.brand.pic,
          contact: data.brand.contact,
          target: data.brand.target_market,
          tone: data.brand.tone ? data.brand.tone.split(',') : [],
          status: data.brand.status,
          contents: data.brand.contents || 0,
          created: brands[idx].created
        };
      }
      filterTable();
      showToast('success', `Brand "${data.brand.name}" berhasil diperbarui!`);
    } else {
      showToast('error', 'Gagal memperbarui brand: ' + (data.message || 'Unknown error'));
    }
    resetButton();
  })
  .catch(error => {
    showToast('error', 'Kesalahan koneksi: ' + error.message);
    resetButton();
  });
}

function submitAddToDatabase(brandData, btn) {
  const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
  closeModal('formOverlay');

  fetch('/brands', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': csrfToken,
      'Accept': 'application/json'
    },
    body: JSON.stringify(brandData)
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      const newBrand = {
        id: data.brand.id,
        name: data.brand.name,
        pic: data.brand.pic,
        contact: data.brand.contact,
        target: data.brand.target_market,
        tone: data.brand.tone ? data.brand.tone.split(',') : [],
        status: data.brand.status,
        contents: 0,
        created: new Date().toLocaleDateString('id-ID', { month: 'short', year: 'numeric' })
      };
      brands.unshift(newBrand);
      filterTable();
      showToast('success', `Brand "${data.brand.name}" berhasil ditambahkan!`);
    } else {
      showToast('error', 'Gagal menambah brand: ' + (data.message || 'Unknown error'));
    }
    resetButton();
  })
  .catch(error => {
    showToast('error', 'Kesalahan koneksi: ' + error.message);
    resetButton();
  });
}

function resetButton() {
  const btn = document.getElementById('submitBtn');
  if (btn) {
    btn.innerHTML = '<i class="fa-solid fa-floppy-disk"></i> Simpan Brand';
    btn.disabled = false;
  }
}

/* ══════════════════════════════════════════
   DETAIL
══════════════════════════════════════════ */
function openDetail(id) {
  const b = brands.find(x => x.id === id);
  if (!b) return;

  const hero = document.getElementById('detailHero');
  hero.innerHTML = `
    <div class="detail-avatar" style="background:${brandColor(b.id)}">${brandInitials(b.name)}</div>
    <div>
      <div class="detail-name">${b.name}</div>
      <div class="detail-meta">
        <span><i class="fa-solid fa-calendar-day"></i> Dibuat ${b.created}</span>
        <span class="status-pill ${b.status==='Active'?'sp-active':'sp-inactive'}"><span class="status-dot"></span>${b.status}</span>
      </div>
    </div>
  `;

  const body = document.getElementById('detailBody');
  body.innerHTML = `
    <div class="detail-grid">
      <div class="detail-item"><div class="detail-item-label">PIC</div><div class="detail-item-value">${b.pic}</div></div>
      <div class="detail-item"><div class="detail-item-label">Kontak</div><div class="detail-item-value">${b.contact}</div></div>
      <div class="detail-item full"><div class="detail-item-label">Target Market</div><div class="detail-item-value">${b.target}</div></div>
      <div class="detail-item full">
        <div class="detail-item-label">Tone Komunikasi</div>
        <div class="detail-tone-tags">${b.tone.map(t=>`<span class="detail-tone-tag">${t}</span>`).join('')}</div>
      </div>
      <div class="detail-item full">
        <div class="detail-item-label">Statistik Konten</div>
        <div class="content-bar">
          <div class="cb-row"><div class="cb-label">Published</div><div class="cb-track"><div class="cb-fill" style="width:${b.contents?Math.round(b.published/b.contents*100):0}%;background:var(--emerald)"></div></div><div class="cb-num">${b.published}</div></div>
          <div class="cb-row"><div class="cb-label">On Progress</div><div class="cb-track"><div class="cb-fill" style="width:${b.contents?Math.round(b.onProgress/b.contents*100):0}%;background:var(--blue)"></div></div><div class="cb-num">${b.onProgress}</div></div>
        </div>
      </div>
    </div>
  `;

  document.getElementById('detailEditBtn').onclick = () => openEdit(b.id);
  openModal('detailOverlay');
}

/* ══════════════════════════════════════════
   DELETE
══════════════════════════════════════════ */
function openDelete(id) {
  const b = brands.find(x => x.id === id);
  if (!b) return;
  deleteTargetId = id;
  document.getElementById('deleteMsg').innerHTML = `Apakah Anda yakin ingin menghapus brand <strong>${b.name}</strong>? Tindakan ini tidak dapat dibatalkan.`;
  document.getElementById('confirmDeleteBtn').onclick = confirmDelete;
  openModal('deleteOverlay');
}

function confirmDelete() {
  if (!deleteTargetId) return;
  const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
  
  fetch(`/brands/${deleteTargetId}`, {
    method: 'DELETE',
    headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' }
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      brands = brands.filter(b => b.id !== deleteTargetId);
      filterTable();
      showToast('success', 'Brand berhasil dihapus');
      closeModal('deleteOverlay');
    } else {
      showToast('error', 'Gagal menghapus brand');
    }
  })
  .catch(() => showToast('error', 'Kesalahan koneksi'));
}

/* ══════════════════════════════════════════
   STATS
══════════════════════════════════════════ */
function updateStats() {
  // Stats update logic could be added here if needed to be dynamic without page reload
}

/* ══════════════════════════════════════════
   TOAST
══════════════════════════════════════════ */
function showToast(type, msg) {
  const c = document.getElementById('toastContainer');
  const t = document.createElement('div');
  t.className = `toast toast-${type}`;
  const icon = type==='success'?'check-circle':(type==='error'?'circle-xmark':'triangle-exclamation');
  t.innerHTML = `<div class="toast-ic"><i class="fa-solid fa-${icon}"></i></div><div class="toast-msg">${msg}</div>`;
  c.appendChild(t);
  setTimeout(() => t.classList.add('show'), 100);
  setTimeout(() => { t.classList.remove('show'); setTimeout(() => t.remove(), 400); }, 4000);
}
</script>
@endpush
