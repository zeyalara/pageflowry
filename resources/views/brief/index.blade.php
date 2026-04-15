@extends('layouts.admin')

@section('page-title', 'Daftar Tugas Konten')

@push('styles')
<style>
/* ─────────────────────────────────────────
   PAGE HEADER
───────────────────────────────────────── */
.pg-header{display:flex;align-items:center;justify-content:space-between;gap:16px;animation:fadeUp .35s ease both}
.pg-heading{font-size:22px;font-weight:800;color:var(--text-900);letter-spacing:-.5px;margin-bottom:3px}
.pg-sub{font-size:13px;color:var(--text-400)}

/* ─────────────────────────────────────────
   MODERN STAT CARDS (Glassmorphism)
───────────────────────────────────────── */
.stats-row {
  display: grid;
  grid-template-columns: repeat(5, 1fr);
  gap: 20px;
  margin-bottom: 32px;
}
.sc {
  position: relative;
  background: rgba(255, 255, 255, 0.7);
  backdrop-filter: blur(10px);
  -webkit-backdrop-filter: blur(10px);
  border: 1px solid rgba(255, 255, 255, 0.4);
  border-radius: 24px;
  padding: 24px;
  display: flex;
  flex-direction: column;
  transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
  cursor: default;
  overflow: hidden;
  box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.07);
  animation: fadeUp 0.6s ease both;
  animation-delay: calc(var(--i, 0) * 0.1s);
}
.sc:hover {
  transform: translateY(-8px) scale(1.02);
  box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
  background: rgba(255, 255, 255, 0.9);
  border-color: rgba(255, 255, 255, 0.8);
}
.sc::after {
  content: '';
  position: absolute;
  top: -50%;
  left: -50%;
  width: 200%;
  height: 200%;
  background: radial-gradient(circle, rgba(255,255,255,0.3) 0%, transparent 70%);
  opacity: 0;
  transition: opacity 0.4s;
  pointer-events: none;
}
.sc:hover::after {
  opacity: 1;
}

.sc-icon-box {
  width: 54px;
  height: 54px;
  border-radius: 18px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 22px;
  margin-bottom: 16px;
  transition: all 0.4s ease;
  position: relative;
  z-index: 2;
}
.sc:hover .sc-icon-box {
  transform: rotate(10deg) scale(1.1);
}

.sc-num {
  font-size: 36px;
  font-weight: 850;
  color: var(--text-900);
  line-height: 1;
  margin-bottom: 6px;
  letter-spacing: -1.5px;
  position: relative;
  z-index: 2;
}
.sc-label {
  font-size: 14px;
  font-weight: 700;
  color: var(--text-600);
  margin-bottom: 4px;
  position: relative;
  z-index: 2;
}
.sc-sub {
  font-size: 11px;
  font-weight: 600;
  color: var(--text-400);
  display: flex;
  align-items: center;
  gap: 5px;
  position: relative;
  z-index: 2;
}
.sc-sub i { font-size: 10px; }

/* Color Themes */
.sc-b { --accent: #3b82f6; --bg-soft: rgba(59, 130, 246, 0.1); }
.sc-o { --accent: #f59e0b; --bg-soft: rgba(245, 158, 11, 0.1); }
.sc-v { --accent: #8b5cf6; --bg-soft: rgba(139, 92, 246, 0.1); }
.sc-r { --accent: #f43f5e; --bg-soft: rgba(244, 63, 94, 0.1); }
.sc-g { --accent: #10b981; --bg-soft: rgba(16, 185, 129, 0.1); }

.sc .sc-icon-box {
  background: var(--bg-soft);
  color: var(--accent);
  box-shadow: inset 0 0 0 1px rgba(255,255,255,0.4);
}
.sc:hover .sc-icon-box {
  background: var(--accent);
  color: #fff;
  box-shadow: 0 8px 16px -4px var(--bg-soft);
}

/* Abstract Shape Decorations */
.sc-shape {
  position: absolute;
  right: -20px;
  bottom: -20px;
  width: 100px;
  height: 100px;
  background: var(--accent);
  filter: blur(40px);
  opacity: 0.1;
  border-radius: 50%;
  transition: all 0.5s ease;
}
.sc:hover .sc-shape {
  transform: scale(1.5);
  opacity: 0.2;
}

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
   TABLE CARD
═══════════════════════════════════════ */
.table-card {
  background: var(--white); border-radius: var(--r);
  border: 1px solid var(--border); box-shadow: var(--s1);
  overflow: visible;
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

/* TABLE WRAPPER - Clean and functional */
.table-wrapper { 
  overflow-x: auto; 
  border-radius: 0 0 var(--r) var(--r); 
  background: var(--white); 
  position: relative; 
  border: 1px solid var(--border); 
}

/* Ensure the table takes full width and has a proper layout */
.ktable { 
  width: 100%; 
  border-collapse: separate; 
  border-spacing: 0;
  table-layout: auto;
}

.ktable thead th {
  position: sticky;
  top: 0;
  z-index: 20;
  background: var(--bg);
  padding: 14px 16px;
  font-size: 11px;
  font-weight: 700;
  text-transform: uppercase;
  color: var(--text-300);
  border-bottom: 1px solid var(--border);
  box-shadow: 0 1px 0 var(--border);
  text-align: left;
}

.ktable tbody tr {
  background: var(--white);
  transition: var(--t);
  cursor: pointer;
}
.ktable tbody tr:hover { background: var(--blue-50); }

.ktable tbody td {
  padding: 14px 16px;
  border-bottom: 1px solid var(--border-light);
  vertical-align: middle;
  font-size: 13px;
  color: var(--text-700);
}

/* Status Pill with Dot (Matching Brand Management) */
.status-pill {
  display: inline-flex; align-items: center; gap: 6px;
  padding: 5px 12px; border-radius: 99px;
  font-size: 11.5px; font-weight: 700;
  white-space: nowrap; user-select: none;
}
.status-dot { width: 6px; height: 6px; border-radius: 50%; flex-shrink: 0; }

.sp-prod     { background: rgba(255,120,73,.1); color: #c2440f; } .sp-prod .status-dot { background: #c2440f; }
.sp-review   { background: rgba(139,92,246,.1); color: #5b21b6; } .sp-review .status-dot { background: #5b21b6; }
.sp-revision { background: rgba(244,63,94,.1);  color: #9f1239; } .sp-revision .status-dot { background: #9f1239; }
.sp-ready    { background: rgba(245,158,11,.1); color: #92400e; } .sp-ready .status-dot { background: #92400e; }
.sp-pub      { background: rgba(16,185,129,.1); color: #065f46; } .sp-pub .status-dot { background: #065f46; }

.task-title{font-size:13.5px;font-weight:700;color:var(--text-900);margin-bottom:1px}
.task-desc{font-size:11px;color:var(--text-400)}
.brand-info .brand-name{font-weight:600;color:var(--text-700)}
.brand-info .brand-pic{font-size:11px;color:var(--text-400)}
.platform-info{display:flex;align-items:center;gap:8px}
.plat-ig{color:#9d174d}.plat-tt{color:#14532d}.plat-yt{color:#991b1b}
.status{display:inline-flex;align-items:center;gap:5px;padding:4px 11px;border-radius:99px;font-size:11px;font-weight:700;white-space:nowrap}
.p-prod{background:rgba(255,120,73,.1);color:#c2440f}
.p-review{background:rgba(139,92,246,.1);color:#5b21b6}
.p-revision{background:rgba(244,63,94,.1);color:#9f1239}
.p-ready{background:rgba(245,158,11,.1);color:#92400e}
.p-pub{background:rgba(16,185,129,.1);color:#065f46}

.actions{display:flex;gap:6px;align-items:center}
.btn-action{width:32px;height:32px;border-radius:8px;border:none;background:var(--blue-50);color:var(--blue);font-size:13px;cursor:pointer;transition:var(--t);display:flex;align-items:center;justify-content:center}
.btn-action:hover{background:var(--blue-100);transform:scale(1.08)}
.btn-action[title="Edit"]{background:rgba(245,158,11,.10);color:var(--amber)}
.btn-action[title="Edit"]:hover{background:rgba(245,158,11,.2)}
.btn-action.btn-delete{background:rgba(244,63,94,.10);color:var(--rose)}
.btn-action.btn-delete:hover{background:rgba(244,63,94,.2)}

/* ─────────────────────────────────────────
   PAGINATION
───────────────────────────────────────── */
.pagi{display:flex;align-items:center;justify-content:space-between;padding:14px 20px;border-top:1px solid var(--border-light)}
.pagi-info{font-size:12.5px;color:var(--text-400)}.pagi-info b{color:var(--text-700)}
.pagi-btns{display:flex;gap:4px}
.pb{width:32px;height:32px;border-radius:8px;border:1.5px solid var(--border);background:var(--white);font-family:'DM Sans',sans-serif;font-size:12.5px;font-weight:600;color:var(--text-500);cursor:pointer;transition:var(--t);display:flex;align-items:center;justify-content:center}
.pb:hover:not(:disabled){border-color:var(--blue-200);background:var(--blue-50);color:var(--blue)}
.pb.on{background:var(--blue);border-color:var(--blue);color:#fff;box-shadow:0 2px 8px rgba(88,151,254,.3)}
.pb:disabled{opacity:.35;cursor:not-allowed}

/* ─────────────────────────────────────────
   OVERLAY + MODAL BASE
───────────────────────────────────────── */
.overlay{
  position:fixed;inset:0;background:rgba(13,21,38,.45);backdrop-filter:blur(4px);
  z-index:500;display:flex;align-items:center;justify-content:center;
  opacity:0;pointer-events:none;transition:opacity .25s;padding:20px;
}
.overlay.open{opacity:1;pointer-events:all}
.modal{
  background:var(--white);border-radius:20px;width:100%;
  box-shadow:var(--s3),0 0 0 1px rgba(88,151,254,.08);
  transform:translateY(24px) scale(.97);
  transition:transform .3s cubic-bezier(.34,1.56,.64,1),opacity .25s;
  opacity:0;max-height:90vh;overflow-y:auto;
}
.overlay.open .modal{transform:translateY(0) scale(1);opacity:1}

/* ─────────────────────────────────────────
   WIZARD MODAL
───────────────────────────────────────── */
.wiz-modal{max-width:800px}
.wiz-prog{padding:26px 28px 0;display:flex;align-items:flex-start}
.wstep{flex:1;display:flex;flex-direction:column;align-items:center;position:relative}
.wstep:not(:last-child)::after{
  content:'';position:absolute;top:17px;
  left:calc(50% + 20px);right:calc(-50% + 20px);
  height:2px;background:var(--border);z-index:0;transition:background .3s;
}
.wstep.done:not(:last-child)::after{background:var(--emerald)}
.wdot{
  width:36px;height:36px;border-radius:12px;
  border:2px solid var(--border);background:var(--white);
  display:flex;align-items:center;justify-content:center;
  font-size:13px;font-weight:800;color:var(--text-400);
  transition:all .3s cubic-bezier(.34,1.56,.64,1);z-index:1;position:relative;
}
.wstep.active .wdot{
  border-color:var(--blue);background:var(--blue);color:#fff;
  transform: scale(1.1);
  box-shadow:0 4px 12px rgba(88,151,254,.3);
}
.wstep.done .wdot{border-color:var(--emerald);background:var(--emerald);color:#fff}
.wlbl{font-size:10px;font-weight:700;color:var(--text-300);margin-top:8px;text-align:center;line-height:1.2;transition:var(--t)}
.wstep.active .wlbl{color:var(--blue);transform:translateY(2px)}
.wstep.done .wlbl{color:var(--emerald)}

.mhd{padding:20px 28px 0;display:flex;align-items:flex-start;justify-content:space-between}
.meyebrow{font-size:11px;font-weight:700;letter-spacing:1px;text-transform:uppercase;color:var(--blue);display:flex;align-items:center;gap:6px;margin-bottom:4px}
.mtitle{font-size:20px;font-weight:800;color:var(--text-900);letter-spacing:-.4px}
.msub{font-size:13px;color:var(--text-400);margin-top:3px}
.mclose{width:36px;height:36px;border-radius:10px;border:none;background:var(--bg);cursor:pointer;transition:var(--t);display:flex;align-items:center;justify-content:center;color:var(--text-400);font-size:15px;flex-shrink:0}
.mclose:hover{background:rgba(244,63,94,.1);color:var(--rose)}
.mbody{padding:22px 28px}
.mdiv{height:1px;background:var(--border-light);margin:4px 0 20px}
.spanel{display:none;flex-direction:column;gap:16px;animation:fadeUp .3s ease both}
.spanel.show{display:flex}
.shd{display:flex;align-items:flex-start;gap:9px;margin-bottom:4px}
.shd-bar{width:3px;min-width:3px;height:22px;border-radius:3px;background:var(--blue);margin-top:1px}
.shd-title{font-size:13.5px;font-weight:800;color:var(--text-900)}
.shd-sub{font-size:12px;color:var(--text-400);margin-top:2px;line-height:1.4}

.fg2{display:grid;grid-template-columns:1fr 1fr;gap:16px}
.fg3{display:grid;grid-template-columns:1fr 1fr 1fr;gap:16px}
.fg{display:flex;flex-direction:column;gap:6px}
.flbl{font-size:12.5px;font-weight:700;color:var(--text-700);display:flex;align-items:center;gap:5px}
.req{color:var(--rose)}
.hint-lbl{font-size:11px;font-weight:400;color:var(--text-300);margin-left:2px}
.finp,.ftxt,.fsel-f{
  width:100%;font-family:'DM Sans',sans-serif;font-size:13.5px;
  color:var(--text-900);border:1.5px solid var(--border);
  border-radius:var(--r-sm);background:var(--white);transition:var(--t);outline:none;
}
.finp,.fsel-f{height:42px;padding:0 14px}
.ftxt{padding:12px 14px;resize:vertical;line-height:1.55}
.fsel-f{
  appearance:none;cursor:pointer;
  background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6'%3E%3Cpath d='M0 0l5 6 5-6z' fill='%238fa3c4'/%3E%3C/svg%3E");
  background-repeat:no-repeat;background-position:right 14px center;
}
.finp::placeholder,.ftxt::placeholder{color:var(--text-300)}
.finp:focus,.ftxt:focus,.fsel-f:focus{border-color:var(--blue);box-shadow:0 0 0 3.5px rgba(88,151,254,.12)}
.finp.err,.ftxt.err,.fsel-f.err{border-color:var(--rose);box-shadow:0 0 0 3px rgba(244,63,94,.1)}
.ferr{font-size:11.5px;color:var(--rose);font-weight:500;display:none}
.ferr.show{display:block}
.ico-wrap{position:relative}
.ico-wrap>i{position:absolute;left:13px;top:50%;transform:translateY(-50%);color:var(--text-400);font-size:13px;pointer-events:none}
.ico-wrap .finp{padding-left:38px}
.unit-wrap{position:relative}
.unit-wrap .finp{padding-right:52px}
.unit{position:absolute;right:14px;top:50%;transform:translateY(-50%);font-size:12px;font-weight:700;color:var(--text-400);pointer-events:none}
.char-cnt{font-size:11px;color:var(--text-300);text-align:right;margin-top:3px}
.char-cnt.over{color:var(--rose)}

/* Info Box */
.info-box{
  background:rgba(88,151,254,.05);
  border:1px solid rgba(88,151,254,.15);
  border-radius:12px;
  padding:14px 16px;
}
.info-box-ttl{
  font-size:12px;
  font-weight:700;
  color:var(--blue);
  margin-bottom:6px;
  display:flex;
  align-items:center;
  gap:6px;
}
.info-box-txt{
  font-size:12px;
  color:var(--text-500);
  line-height:1.6;
}

.assign-box{border:1.5px dashed var(--border);border-radius:var(--r-sm);padding:20px;background:var(--bg);transition:var(--t)}
.assign-box:focus-within{border-color:var(--blue);background:var(--blue-50)}
.assign-hint{font-size:11.5px;color:var(--text-400);margin-top:10px;display:flex;align-items:flex-start;gap:6px;line-height:1.45}
.assign-hint i{color:var(--blue);flex-shrink:0;margin-top:2px}
.summary-card{
  background:linear-gradient(to bottom right, var(--bg), var(--white));
  border-radius:16px;
  padding:20px;
  border:1px solid var(--border);
  box-shadow: var(--s1);
}
.summary-ttl{
  font-size:13px;
  font-weight:800;
  color:var(--text-900);
  margin-bottom:16px;
  display:flex;
  align-items:center;
  gap:8px;
  padding-bottom:12px;
  border-bottom: 1px solid var(--border-light);
}
.sumrow{
  display:flex;
  align-items:center;
  justify-content:space-between;
  font-size:13px;
  color:var(--text-500);
  padding:8px 0;
}
.sumrow:not(:last-child){
  border-bottom:1px dashed var(--border-light);
}
.sumrow b{
  color:var(--blue);
  font-weight:700;
  text-align:right;
  max-width:60%;
  white-space:nowrap;
  overflow:hidden;
  text-overflow:ellipsis;
}
.mfoot{padding:0 28px 24px;display:flex;align-items:center;justify-content:space-between;gap:10px;border-top:1px solid var(--border-light);padding-top:16px;margin-top:4px}
.mfoot-info{font-size:12px;color:var(--text-400)}.mfoot-info b{color:var(--text-700)}
.mfoot-btns{display:flex;gap:9px}

/* ─────────────────────────────────────────
   DETAIL MODAL
───────────────────────────────────────── */
.det-modal{max-width:720px}
.det-hero{padding:24px 28px 0;display:flex;align-items:flex-start;gap:16px}
.det-ic{width:52px;height:52px;border-radius:14px;display:flex;align-items:center;justify-content:center;font-size:20px;color:#fff;flex-shrink:0}
.det-title{font-size:19px;font-weight:800;color:var(--text-900);letter-spacing:-.4px;line-height:1.2}
.det-meta{display:flex;align-items:center;flex-wrap:wrap;gap:7px;margin-top:8px}
.wf-bar{padding:16px 28px 0;display:flex;align-items:center;gap:0;overflow-x:auto}
.wf-step{display:flex;flex-direction:column;align-items:center;gap:4px;min-width:72px;flex-shrink:0}
.wf-dot{width:28px;height:28px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:10px;transition:var(--t)}
.wf-done .wf-dot{background:var(--emerald);color:#fff}
.wf-active .wf-dot{background:var(--blue);color:#fff;box-shadow:0 0 0 3px rgba(88,151,254,.2)}
.wf-pending .wf-dot{background:var(--border);color:var(--text-400)}
.wf-lbl{font-size:9px;font-weight:600;text-align:center;line-height:1.3;color:var(--text-400)}
.wf-done .wf-lbl{color:var(--emerald)}
.wf-active .wf-lbl{color:var(--blue)}
.wf-arr{font-size:10px;color:var(--text-300);margin:0 2px;padding-bottom:14px;flex-shrink:0}
.det-body{padding:16px 28px 0}
.det-tabs{display:flex;border-bottom:1px solid var(--border);margin-bottom:16px}
.dtab{padding:10px 16px;font-size:13px;font-weight:600;color:var(--text-400);cursor:pointer;border-bottom:2.5px solid transparent;transition:var(--t)}
.dtab:hover{color:var(--text-700)}
.dtab.on{color:var(--blue);border-bottom-color:var(--blue)}
.dpanel{display:none;flex-direction:column;gap:12px;animation:fadeUp .25s ease both;padding-bottom:4px}
.dpanel.show{display:flex}
.drow{display:grid;grid-template-columns:1fr 1fr;gap:12px}
.df{display:flex;flex-direction:column;gap:3px}
.df.full{grid-column:1/-1}
.df-lbl{font-size:10.5px;font-weight:700;text-transform:uppercase;letter-spacing:.6px;color:var(--text-300)}
.df-val{font-size:13px;font-weight:500;color:var(--text-700);line-height:1.5}
.df-val.dim{font-weight:400;color:var(--text-500)}
.df-val.accent{color:var(--blue);font-size:12.5px}
.df-val.italic{font-style:italic;color:var(--text-500)}
.df-tag{display:inline-flex;background:var(--blue-50);color:var(--blue);font-size:11.5px;font-weight:600;padding:3px 9px;border-radius:99px;margin-right:4px;margin-bottom:4px}

/* ─────────────────────────────────────────
   DELETE MODAL
───────────────────────────────────────── */
.del-modal{max-width:420px}
.del-ic-wrap{width:60px;height:60px;border-radius:16px;background:rgba(244,63,94,.1);display:flex;align-items:center;justify-content:center;font-size:24px;color:var(--rose);margin:0 auto 16px}

/* ─────────────────────────────────────────
   TOAST
───────────────────────────────────────── */
.toast-wrap{position:fixed;bottom:28px;right:28px;z-index:999;display:flex;flex-direction:column;gap:10px;pointer-events:none}
.toast{
  display:flex;align-items:center;gap:11px;padding:13px 18px;
  border-radius:12px;background:var(--text-900);color:#fff;
  font-size:13px;font-weight:500;box-shadow:0 8px 32px rgba(13,21,38,.25);
  transform:translateX(110%);transition:transform .35s cubic-bezier(.34,1.56,.64,1);
  pointer-events:all;min-width:250px;max-width:380px;
}
.toast.show{transform:translateX(0)}
.t-ic{width:28px;height:28px;border-radius:8px;flex-shrink:0;display:flex;align-items:center;justify-content:center;font-size:13px}
.t-s .t-ic{background:rgba(16,185,129,.2);color:var(--emerald)}
.t-w .t-ic{background:rgba(245,158,11,.2);color:var(--amber)}
.t-e .t-ic{background:rgba(244,63,94,.2);color:var(--rose)}

@keyframes fadeUp{from{opacity:0;transform:translateY(14px)}to{opacity:1;transform:translateY(0)}}
@keyframes spin{to{transform:rotate(360deg)}}
.spin{display:inline-block;animation:spin .7s linear infinite}

/* ═══════════════════════════════════════
   PRINT STYLES
═══════════════════════════════════════ */
@media print {
  /* Hide navigation, sidebar, and non-essential UI */
  nav, .sidebar, .sidebar-wrap, .sb-wrap, .header, .toolbar, .btn, .view-toggle, .row-actions, .modal, .overlay, .tch-right, .pg-header, .stats-row, .pagi {
    display: none !important;
  }

  /* Reset page margins and background */
  body {
    background: white !important;
    margin: 0 !important;
    padding: 0 !important;
  }

  .main-content, .content, .body {
    margin: 0 !important;
    padding: 0 !important;
    width: 100% !important;
  }

  /* Expand the table to full width */
  .table-card {
    box-shadow: none !important;
    border: none !important;
    width: 100% !important;
  }

  .ktable {
    width: 100% !important;
    border: 1px solid #eee !important;
  }

  .ktable th, .ktable td {
    border: 1px solid #eee !important;
  }

  /* Ensure colors and text are visible */
  .status-pill {
    -webkit-print-color-adjust: exact;
    print-color-adjust: exact;
    border: 1px solid #ccc !important;
  }

  /* Show a print header */
  .table-card::before {
    content: "PAGEFLOWRY - DAFTAR TUGAS KONTEN";
    display: block;
    font-size: 20px;
    font-weight: bold;
    text-align: center;
    margin-bottom: 20px;
    color: #0d1526;
  }
}
</style>
@endpush

@section('content')
<!-- PAGE HEADER -->
<div class="pg-header">
  <div>
    <div class="pg-heading">Daftar Tugas Konten</div>
    <div class="pg-sub">Kelola seluruh brief dan tugas konten untuk semua brand</div>
  </div>
  <div class="toolbar-spacer"></div>
  <button class="btn btn-primary" onclick="openCreate()">
    <i class="fa-solid fa-plus"></i> Buat Tugas Konten
  </button>
</div>

<!-- STAT CARDS -->
<div class="stats-row">
  <div class="sc sc-b" style="--i:0">
    <div class="sc-shape"></div>
    <div class="sc-icon-box"><i class="fa-solid fa-layer-group"></i></div>
    <div class="sc-num" id="sc-total">0</div>
    <div class="sc-label">Total Tugas</div>
    <div class="sc-sub"><i class="fa-solid fa-circle-check"></i> Semua tugas</div>
  </div>
  <div class="sc sc-o" style="--i:1">
    <div class="sc-shape"></div>
    <div class="sc-icon-box"><i class="fa-solid fa-spinner"></i></div>
    <div class="sc-num" id="sc-prod">0</div>
    <div class="sc-label">In Production</div>
    <div class="sc-sub"><i class="fa-solid fa-clock"></i> Sedang berjalan</div>
  </div>
  <div class="sc sc-v" style="--i:2">
    <div class="sc-shape"></div>
    <div class="sc-icon-box"><i class="fa-solid fa-magnifying-glass"></i></div>
    <div class="sc-num" id="sc-review">0</div>
    <div class="sc-label">Under Review</div>
    <div class="sc-sub"><i class="fa-solid fa-eye"></i> Sedang direview</div>
  </div>
  <div class="sc sc-r" style="--i:3">
    <div class="sc-shape"></div>
    <div class="sc-icon-box"><i class="fa-solid fa-exclamation-triangle"></i></div>
    <div class="sc-num" id="sc-revision">0</div>
    <div class="sc-label">Need Revision</div>
    <div class="sc-sub"><i class="fa-solid fa-rotate-left"></i> Perlu revisi</div>
  </div>
  <div class="sc sc-g" style="--i:4">
    <div class="sc-shape"></div>
    <div class="sc-icon-box"><i class="fa-solid fa-check-double"></i></div>
    <div class="sc-num" id="sc-pub">0</div>
    <div class="sc-label">Published</div>
    <div class="sc-sub"><i class="fa-solid fa-paper-plane"></i> Sudah publish</div>
  </div>
</div>

<!-- TOOLBAR -->
<div class="toolbar">
  <div class="search-wrap">
    <i class="fa-solid fa-magnifying-glass"></i>
    <input class="search-input" id="srchInput" type="text" placeholder="Cari judul atau brand..." oninput="applyFilter()"/>
  </div>
  <select class="filter-select" id="fltStatus" onchange="applyFilter()">
    <option value="">Semua Status</option>
    <option value="In Production">In Production</option>
    <option value="Under Review">Under Review</option>
    <option value="Need Revision">Need Revision</option>
    <option value="Ready to Publish">Ready to Publish</option>
    <option value="Published">Published</option>
  </select>
  <select class="filter-select" id="fltPlatform" onchange="applyFilter()">
    <option value="">Semua Platform</option>
    <option value="Instagram">Instagram</option>
    <option value="TikTok">TikTok</option>
    <option value="YouTube">YouTube</option>
  </select>
  <select class="filter-select" id="fltBrand" onchange="applyFilter()">
    <option value="">Semua Brand</option>
    @if(isset($brands) && $brands->count() > 0)
      @foreach($brands as $brand)
        <option value="{{ $brand->id }}">{{ $brand->name }}</option>
      @endforeach
    @endif
  </select>
  <div class="toolbar-spacer"></div>
  <div style="display:flex; gap:8px;">
    <a href="{{ route('content-tasks.export-pdf') }}" class="btn btn-ghost" style="text-decoration:none;">
      <i class="fa-solid fa-file-pdf"></i> Export PDF
    </a>
    <button class="btn btn-ghost" onclick="window.print()" title="Cetak Halaman">
      <i class="fa-solid fa-print"></i> Print
    </button>
  </div>
</div>

<!-- TABLE CARD -->
<div class="table-card">
  <div class="table-card-head">
    <div class="tch-left">
      <span class="tch-title">Daftar Tugas Konten</span>
      <span class="tch-count" id="tblCount">{{ $contentBriefs->count() }} tugas</span>
    </div>
  </div>
  <div class="table-wrapper">
    <table class="ktable">
      <thead>
        <tr>
          <th style="width:25%">Judul Konten</th>
          <th style="width:15%">Brand</th>
          <th style="width:15%">Platform</th>
          <th style="width:15%">Deadline</th>
          <th style="width:15%">Status</th>
          <th style="width:15%; text-align:right">Aksi</th>
        </tr>
      </thead>
      <tbody id="tblBody">
        @if(isset($contentBriefs) && $contentBriefs->count() > 0)
          @foreach($contentBriefs as $brief)
            <tr onclick="openDetail({{ $brief->id }})">
              <td>
                <div class="task-title">{{ $brief->title }}</div>
                <div class="task-desc">{{ Str::limit($brief->description ?? '-', 50) }}</div>
              </td>
              <td>
                <div class="brand-info">
                  <div class="brand-name">{{ $brief->brand->name ?? '-' }}</div>
                  <div class="brand-pic">{{ $brief->brand->pic ?? '-' }}</div>
                </div>
              </td>
              <td>
                <div class="platform-info">
                  <i class="fa-brands {{ $brief->platform === 'Instagram' ? 'fa-instagram plat-ig' : ($brief->platform === 'TikTok' ? 'fa-tiktok plat-tt' : 'fa-youtube plat-yt') }}"></i>
                  <span>{{ $brief->platform }}</span>
                </div>
              </td>
              <td>
                <div class="prod-deadline">{{ $brief->production_deadline ? \Carbon\Carbon::parse($brief->production_deadline)->format('d M Y') : '-' }}</div>
              </td>
              <td>
                @php
                  $s = $brief->status;
                  $sp = $s === 'In Production' ? 'sp-prod' : ($s === 'Under Review' ? 'sp-review' : ($s === 'Need Revision' ? 'sp-revision' : ($s === 'Published' ? 'sp-pub' : 'sp-ready')));
                @endphp
                <span class="status-pill {{ $sp }}">
                  <span class="status-dot"></span>
                  {{ $s }}
                </span>
              </td>
              <td onclick="event.stopPropagation()" style="text-align:right">
                <div class="actions" style="justify-content:flex-end">
                  <button class="btn-action" onclick="openDetail({{ $brief->id }})" title="Detail"><i class="fa-solid fa-eye"></i></button>
                  <button class="btn-action" onclick="openEdit({{ $brief->id }})" title="Edit"><i class="fa-solid fa-edit"></i></button>
                  <button class="btn-action btn-delete" onclick="openDel({{ $brief->id }})" title="Delete"><i class="fa-solid fa-trash"></i></button>
                </div>
              </td>
            </tr>
          @endforeach
        @else
          <tr class="empty-row"><td colspan="6"><div class="empty-ic"><i class="fa-solid fa-search"></i></div>Tidak ada tugas ditemukan</td></tr>
        @endif
      </tbody>
    </table>
  </div>
  <div class="pagi">
    <div class="pagi-info">Menampilkan <b id="pgFrom">1</b>–<b id="pgTo">{{ $contentBriefs->count() }}</b> dari <b id="pgTotal">{{ $contentBriefs->count() }}</b> tugas</div>
    <div class="pagi-btns" id="pgBtns"></div>
  </div>
</div>

<!-- ════════════ MODALS ════════════ -->

<!-- WIZARD CREATE/EDIT -->
<div class="overlay" id="ovWizard" onclick="bgClose(event,'ovWizard')">
<div class="modal wiz-modal" onclick="event.stopPropagation()">
  <div class="wiz-prog" id="wizProg"></div>
  <div class="mhd" style="margin-top:20px">
    <div>
      <div class="meyebrow"><i class="fa-solid fa-file-pen"></i> <span id="wizEyebrow">Create Brief</span></div>
      <div class="mtitle" id="wizTitle">Buat Tugas Konten Baru</div>
      <div class="msub">Langkah <b id="wizStepNum">1</b> dari 7 — <span id="wizStepName">Deskripsi Tugas</span></div>
    </div>
    <button class="mclose" onclick="closeModal('ovWizard')"><i class="fa-solid fa-xmark"></i></button>
  </div>
  <div class="mbody">
    <div class="mdiv"></div>
    
    <!-- STEP 1: DESKRIPSI -->
    <div class="spanel show" id="sp1">
      <div class="shd">
        <div class="shd-bar"></div>
        <div>
          <div class="shd-title">Deskripsi Tugas</div>
          <div class="shd-sub">Berikan gambaran umum mengenai konten yang ingin dibuat agar tim produksi memahami konteksnya.</div>
        </div>
      </div>
      <div class="fg">
        <label class="flbl">Deskripsi Tugas Konten <span class="req">*</span></label>
        <textarea class="ftxt" id="fDesc" rows="7" placeholder="Jelaskan apa tujuan utama konten ini, misalnya: 'Membuat video edukasi singkat mengenai fitur terbaru aplikasi untuk meningkatkan pemahaman pengguna...'"></textarea>
        <div class="char-cnt" id="ccDesc">0 / 500 karakter</div>
        <div class="ferr" id="eDesc">Deskripsi tugas wajib diisi untuk memberikan gambaran awal.</div>
      </div>
      <div class="info-box" style="margin-top: 8px;">
        <div class="info-box-ttl"><i class="fa-solid fa-circle-info"></i> Tips</div>
        <div class="info-box-txt">Deskripsi yang jelas membantu Creator memahami visi Anda dengan lebih baik sejak awal.</div>
      </div>
    </div>

    <!-- STEP 2: INFORMASI DASAR -->
    <div class="spanel" id="sp2">
      <div class="shd">
        <div class="shd-bar"></div>
        <div>
          <div class="shd-title">Informasi Dasar</div>
          <div class="shd-sub">Detail teknis dan jadwal produksi konten.</div>
        </div>
      </div>
      <div class="fg">
        <label class="flbl">Judul Konten <span class="req">*</span></label>
        <div class="ico-wrap">
          <i class="fa-solid fa-heading"></i>
          <input class="finp" id="fTitle" type="text" placeholder="Contoh: Tutorial Penggunaan Fitur Chat"/>
        </div>
        <div class="ferr" id="eTitle">Judul konten diperlukan untuk identifikasi tugas.</div>
      </div>
      <div class="fg3">
        <div class="fg">
          <label class="flbl">Brand <span class="req">*</span></label>
          <select class="fsel-f" id="fBrand">
            <option value="">Pilih brand...</option>
            @foreach($brands as $brand) 
              <option value="{{ $brand->id }}" data-name="{{ $brand->name }}">{{ $brand->name }}</option> 
            @endforeach
          </select>
          <div class="ferr" id="eBrand">Pilih salah satu brand.</div>
        </div>
        <div class="fg">
          <label class="flbl">Platform <span class="req">*</span></label>
          <select class="fsel-f" id="fPlatform" onchange="updateFormatOptions()">
            <option value="">Pilih...</option>
            <option>Instagram</option>
            <option>TikTok</option>
            <option>YouTube</option>
          </select>
          <div class="ferr" id="ePlatform">Tentukan platform tujuan.</div>
        </div>
        <div class="fg">
          <label class="flbl">Format <span class="req">*</span></label>
          <select class="fsel-f" id="fFormat">
            <option value="">Pilih...</option>
          </select>
          <div class="ferr" id="eFormat">Pilih format konten.</div>
        </div>
        <div class="fg">
          <label class="flbl">Durasi <span class="req">*</span></label>
          <div class="ico-wrap">
            <i class="fa-solid fa-stopwatch"></i>
            <input class="finp" id="fDuration" type="text" placeholder="Misal: 30s atau 1m"/>
          </div>
          <div class="ferr" id="eDuration">Durasi target wajib diisi.</div>
        </div>
        <div class="fg">
          <label class="flbl">Deadline Prod <span class="req">*</span></label>
          <input class="finp" id="fDeadProd" type="date"/>
          <div class="ferr" id="eDeadProd">Batas waktu produksi.</div>
        </div>
        <div class="fg">
          <label class="flbl">Deadline Pub <span class="req">*</span></label>
          <input class="finp" id="fDeadPub" type="date"/>
          <div class="ferr" id="eDeadPub">Batas waktu tayang.</div>
        </div>
      </div>
    </div>

    <!-- STEP 3: STRATEGI -->
    <div class="spanel" id="sp3">
      <div class="shd">
        <div class="shd-bar"></div>
        <div>
          <div class="shd-title">Strategi Konten</div>
          <div class="shd-sub">Tentukan tujuan dan kepada siapa konten ini ditujukan.</div>
        </div>
      </div>
      <div class="fg">
        <label class="flbl">Objective <span class="req">*</span></label>
        <select class="fsel-f" id="fObjective">
          <option value="">Pilih tujuan utama...</option>
          <option>Peningkatan Awareness</option>
          <option>Penyampaian Informasi</option>
          <option>Peningkatan Engagement</option>
          <option>Pembangunan Kepercayaan</option>
          <option>Mendorong Konversi</option>
          <option>Menjaga Loyalitas Audiens</option>
        </select>
        <div class="ferr" id="eObjective">Tujuan konten wajib dipilih.</div>
      </div>
      <div class="fg">
        <label class="flbl">Target Audience <span class="req">*</span></label>
        <textarea class="ftxt" id="fAudience" rows="3" placeholder="Siapa yang ingin Anda jangkau? Contoh: 'Gen Z, usia 18-25, tertarik dengan teknologi...'"></textarea>
        <div class="ferr" id="eAudience">Jelaskan target audiens Anda.</div>
      </div>
      <div class="fg">
        <label class="flbl">Key Message <span class="req">*</span></label>
        <textarea class="ftxt" id="fKeyMsg" rows="3" placeholder="Pesan utama yang harus diingat penonton. Contoh: 'Aplikasi ini adalah solusi termudah untuk manajemen keuangan harian.'"></textarea>
        <div class="ferr" id="eKeyMsg">Pesan utama tidak boleh kosong.</div>
      </div>
    </div>

    <!-- STEP 4: KREATIF -->
    <div class="spanel" id="sp4">
      <div class="shd">
        <div class="shd-bar"></div>
        <div>
          <div class="shd-title">Creative Direction</div>
          <div class="shd-sub">Panduan visual dan alur cerita konten.</div>
        </div>
      </div>
      <div class="fg">
        <label class="flbl">Hook <span class="req">*</span></label>
        <div class="ico-wrap">
          <i class="fa-solid fa-magnet"></i>
          <input class="finp" id="fHook" type="text" placeholder="Kalimat pembuka yang menarik perhatian dalam 3 detik pertama..."/>
        </div>
        <div class="ferr" id="eHook">Hook sangat penting untuk retensi penonton.</div>
      </div>
      <div class="fg">
        <label class="flbl">Storyline <span class="req">*</span></label>
        <textarea class="ftxt" id="fStory" rows="4" placeholder="Garis besar alur cerita dari awal sampai akhir..."></textarea>
        <div class="ferr" id="eStory">Alur cerita diperlukan sebagai panduan Creator.</div>
      </div>
      <div class="fg">
        <label class="flbl">Visual Direction <span class="req">*</span></label>
        <textarea class="ftxt" id="fVisual" rows="3" placeholder="Gaya visual, warna dominan, atau referensi pengambilan gambar..."></textarea>
        <div class="ferr" id="eVisual">Panduan visual membantu hasil akhir sesuai ekspektasi.</div>
      </div>
    </div>

    <!-- STEP 5: COPYWRITING -->
    <div class="spanel" id="sp5">
      <div class="shd">
        <div class="shd-bar"></div>
        <div>
          <div class="shd-title">Copywriting</div>
          <div class="shd-sub">Teks pelengkap konten untuk meningkatkan interaksi.</div>
        </div>
      </div>
      <div class="fg">
        <label class="flbl">Caption <span class="req">*</span></label>
        <textarea class="ftxt" id="fCaption" rows="5" placeholder="Tuliskan caption yang akan diposting bersama konten ini..."></textarea>
        <div class="char-cnt" id="ccCaption">0 / 2200</div>
        <div class="ferr" id="eCaption">Caption wajib diisi.</div>
      </div>
      <div class="fg2">
        <div class="fg">
          <label class="flbl">Call to Action (CTA) <span class="req">*</span></label>
          <div class="ico-wrap">
            <i class="fa-solid fa-bullhorn"></i>
            <input class="finp" id="fCta" type="text" placeholder="Misal: Klik link di bio!"/>
          </div>
          <div class="ferr" id="eCta">CTA mengarahkan tindakan audiens.</div>
        </div>
        <div class="fg">
          <label class="flbl">Hashtags <span class="req">*</span></label>
          <div class="ico-wrap">
            <i class="fa-solid fa-hashtag"></i>
            <input class="finp" id="fHashtag" type="text" placeholder="#bisnis #edukasi #tips"/>
          </div>
          <div class="ferr" id="eHashtag">Gunakan hashtag relevan untuk jangkauan luas.</div>
        </div>
      </div>
    </div>

    <!-- STEP 6: KPI -->
    <div class="spanel" id="sp6">
      <div class="shd">
        <div class="shd-bar"></div>
        <div>
          <div class="shd-title">KPI Target</div>
          <div class="shd-sub">Target performa yang ingin dicapai dari konten ini.</div>
        </div>
      </div>
      <div class="fg2">
        <div class="fg">
          <label class="flbl">Target Views <span class="req">*</span></label>
          <div class="unit-wrap">
            <i class="fa-solid fa-chart-line" style="position: absolute; left: 13px; top: 50%; transform: translateY(-50%); color: var(--text-400); font-size: 13px; z-index: 1;"></i>
            <input class="finp" id="fViews" type="number" style="padding-left: 38px;" placeholder="0"/>
            <span class="unit">views</span>
          </div>
          <div class="ferr" id="eViews">Tentukan target penayangan.</div>
        </div>
        <div class="fg">
          <label class="flbl">Target Engagement <span class="req">*</span></label>
          <div class="unit-wrap">
            <i class="fa-solid fa-heart" style="position: absolute; left: 13px; top: 50%; transform: translateY(-50%); color: var(--text-400); font-size: 13px; z-index: 1;"></i>
            <input class="finp" id="fEngage" type="number" step="0.1" style="padding-left: 38px;" placeholder="0.0"/>
            <span class="unit">%</span>
          </div>
          <div class="ferr" id="eEngage">Tentukan target interaksi.</div>
        </div>
      </div>
      <div class="info-box" style="margin-top: 12px; background: rgba(139, 92, 246, 0.05); border-color: rgba(139, 92, 246, 0.2);">
        <div class="info-box-ttl" style="color: var(--violet);"><i class="fa-solid fa-bullseye"></i> Pengukuran</div>
        <div class="info-box-txt">Target KPI membantu tim mengevaluasi efektivitas konten setelah dipublikasikan.</div>
      </div>
    </div>

    <!-- STEP 7: ASSIGN -->
    <div class="spanel" id="sp7">
      <div class="shd">
        <div class="shd-bar"></div>
        <div>
          <div class="shd-title">Finalisasi & Assign</div>
          <div class="shd-sub">Tinjau kembali ringkasan dan tentukan siapa yang akan mengerjakan tugas ini.</div>
        </div>
      </div>
      <div class="assign-box">
        <div class="fg">
          <label class="flbl">Email Creator <span class="hint-lbl">— Opsional</span></label>
          <div class="ico-wrap">
            <i class="fa-solid fa-user-plus"></i>
            <input class="finp" id="fCreator" type="email" placeholder="alamat-email@creator.com"/>
          </div>
          <div class="assign-hint">
            <i class="fa-solid fa-circle-info"></i>
            <div>Creator akan menerima email undangan untuk mengerjakan tugas ini jika alamat email didaftarkan.</div>
          </div>
          
          <!-- Fitur Copy Link (Hanya muncul saat Edit) -->
          <div id="copyLinkContainer" style="display:none; margin-top:16px; padding:12px; background:var(--bg); border:1px solid var(--border); border-radius:var(--r-sm);">
            <div style="font-size:12px; color:var(--text-600); margin-bottom:10px;">
              Jika email tidak terkirim atau ingin lebih cepat, Anda bisa langsung menyalin link brief menggunakan tombol Copy Link.
            </div>
            <div style="display:flex; align-items:center; gap:10px;">
              <button type="button" class="btn btn-ghost" onclick="copyBriefLink()" style="height:32px; font-size:13px; padding:0 12px;">
                <i class="fa-solid fa-copy"></i> Copy Link
              </button>
              <span id="copyFeedback" style="color:var(--emerald); font-size:12px; font-weight:600; display:none;">
                <i class="fa-solid fa-check"></i> Link berhasil disalin
              </span>
            </div>
            <input type="hidden" id="fBriefToken" value="" />
          </div>
        </div>
      </div>
      <div class="summary-card" style="margin-top: 16px;">
        <div class="summary-ttl"><i class="fa-solid fa-clipboard-check"></i> Ringkasan Brief</div>
        <div id="wizSummary"></div>
      </div>
    </div>
  </div>
  <div class="mfoot">
    <div class="mfoot-info">Langkah <b id="wizCurr">1</b> dari 7</div>
    <div class="mfoot-btns">
      <button class="btn btn-ghost" id="btnPrev" onclick="wizPrev()" style="display:none"><i class="fa-solid fa-arrow-left"></i> Kembali</button>
      <button class="btn btn-ghost" onclick="closeModal('ovWizard')">Batal</button>
      <button class="btn btn-primary" id="btnNext" onclick="wizNext()">Selanjutnya <i class="fa-solid fa-arrow-right"></i></button>
    </div>
  </div>
</div>
</div>

<!-- DETAIL MODAL -->
<div class="overlay" id="ovDetail" onclick="bgClose(event,'ovDetail')">
<div class="modal det-modal" onclick="event.stopPropagation()">
  <div class="mhd" style="padding:24px 28px 0"><div></div><button class="mclose" onclick="closeModal('ovDetail')"><i class="fa-solid fa-xmark"></i></button></div>
  <div class="det-hero" id="detHero"></div>
  <div class="wf-bar" id="wfBar"></div>
  <div class="det-body"><div class="det-tabs" id="detTabs"></div><div id="detPanels"></div></div>
  <div class="mfoot"><div></div><div class="mfoot-btns"><button class="btn btn-ghost" onclick="closeModal('ovDetail')">Tutup</button><button class="btn btn-primary" id="detEditBtn"><i class="fa-solid fa-pen"></i> Edit Brief</button></div></div>
</div>
</div>

<!-- DELETE MODAL -->
<div class="overlay" id="ovDel" onclick="bgClose(event,'ovDel')">
<div class="modal del-modal" onclick="event.stopPropagation()">
  <div class="mbody" style="text-align:center;padding:32px 28px 8px"><div class="del-ic-wrap"><i class="fa-solid fa-trash-can"></i></div><div style="font-size:18px;font-weight:800;color:var(--text-900)">Hapus Tugas?</div><div id="delMsg" style="font-size:13.5px;color:var(--text-500);margin-top:8px"></div></div>
  <div class="mfoot" style="justify-content:center"><button class="btn btn-ghost" onclick="closeModal('ovDel')">Batal</button><button class="btn btn-danger" id="delConfirmBtn"><i class="fa-solid fa-trash-can"></i> Ya, Hapus</button></div>
</div>
</div>

<div class="toast-wrap" id="toastWrap"></div>
@endsection

@push('scripts')
<script>
/* ── DATA & CONSTANTS ───────────────────── */
const COLORS = ['#5897fe','#10b981','#f59e0b','#8b5cf6','#f43f5e'];
const PLAT_ICON = { Instagram:'fa-instagram', TikTok:'fa-tiktok', YouTube:'fa-youtube' };
const PLAT_CLS = { Instagram:'plat-ig', TikTok:'plat-tt', YouTube:'plat-yt' };
const STATUS_CLS = { 'In Production':'p-prod','Under Review':'p-review','Need Revision':'p-revision','Published':'p-pub','Ready to Publish':'p-ready' };
const STEP_NAMES = ['Deskripsi Tugas','Informasi Dasar','Strategi Konten','Creative Direction','Copywriting','KPI Target','Assign Creator'];
const WF_STEPS = ['Brief Dibuat', 'In Production', 'Under Review', 'Need Revision', 'Ready to Publish', 'Published'];
const STATUS_IDX = { 'In Production': 1, 'Under Review': 2, 'Need Revision': 3, 'Ready to Publish': 4, 'Published': 5 };

let db = {!! $contentBriefs->map(function($b){
  return [
    'id'=>$b->id,'title'=>$b->title,'description'=>$b->description,'platform'=>$b->platform,'status'=>$b->status,
    'brand_name'=>$b->brand->name ?? '-','brand'=>$b->brand_id,'format'=>$b->content_format,'duration'=>$b->target_duration, 'token'=>$b->token,
    'deadProd'=>$b->production_deadline ? $b->production_deadline->format('Y-m-d') : null,
    'deadPub'=>$b->publish_deadline ? $b->publish_deadline->format('Y-m-d') : null,
    'objective'=>$b->objective,'audience'=>$b->target_audience,'keyMsg'=>$b->key_message,
    'hook'=>$b->hook,'story'=>$b->storyline,'visual'=>$b->visual_direction,
    'caption'=>$b->caption,'cta'=>$b->cta,'hashtag'=>$b->hashtags,
    'views'=>(int)$b->target_views,'engage'=>(float)$b->target_engagement,'creator'=>$b->creator_email
  ];
})->toJson() !!};

let filtered = [...db];
let curStep = 1;
const NSTEPS = 7;
let editId = null;
let delId = null;

/* ── INIT ───────────────────────────────── */
document.addEventListener('DOMContentLoaded', () => {
  buildWizProg();
  renderStats();
  renderTable();
  addCharCounter('fDesc', 'ccDesc', 500);
  addCharCounter('fCaption', 'ccCaption', 2200);
});

/* ── HELPERS ────────────────────────────── */
const col = id => COLORS[id % COLORS.length];
const get = id => document.getElementById(id)?.value || '';
const set = (id, v) => { if(document.getElementById(id)) document.getElementById(id).value = v || ''; };
const fmtDate = d => d ? new Date(d).toLocaleDateString('id-ID',{day:'2-digit',month:'short',year:'numeric'}) : '—';
const pill = s => `<span class="status-pill ${STATUS_CLS[s] || 'sp-ready'}"><span class="status-dot"></span>${s}</span>`;

/* ── CORE LOGIC ─────────────────────────── */
function buildWizProg(){
  const labs = ['Deskripsi','Info','Strategi','Creative','Copy','KPI','Assign'];
  document.getElementById('wizProg').innerHTML = labs.map((l,i)=>`<div class="wstep" id="ws${i+1}"><div class="wdot" id="wd${i+1}">${i+1}</div><div class="wlbl">${l}</div></div>`).join('');
}

function renderStats(){
  const s = {
    total: db.length,
    prod: db.filter(k=>k.status==='In Production').length,
    review: db.filter(k=>k.status==='Under Review').length,
    revision: db.filter(k=>k.status==='Need Revision').length,
    pub: db.filter(k=>k.status==='Published').length
  };
  Object.keys(s).forEach(k => { if(document.getElementById('sc-'+k)) document.getElementById('sc-'+k).textContent = s[k]; });
}

function renderTable(){
  const tbody = document.getElementById('tblBody');
  if(!tbody) return;
  if(filtered.length === 0){
    tbody.innerHTML = '<tr><td colspan="6" style="text-align:center;padding:40px;color:var(--text-400)">Tidak ada data tugas konten</td></tr>';
    document.getElementById('tblCount').textContent = '0 tugas';
    return;
  }
  
  tbody.innerHTML = filtered.map(k => `
    <tr onclick="openDetail(${k.id})">
      <td><div class="task-title">${k.title}</div><div class="task-desc">${k.description?.substring(0,45)}...</div></td>
      <td><div class="brand-info"><div class="brand-name">${k.brand_name}</div></div></td>
      <td><div class="platform-info"><i class="fa-brands ${PLAT_ICON[k.platform]} ${PLAT_CLS[k.platform]}"></i><span>${k.platform}</span></div></td>
      <td>${fmtDate(k.deadProd)}</td>
      <td>${pill(k.status)}</td>
      <td onclick="event.stopPropagation()" style="text-align:right">
        <div class="actions" style="justify-content:flex-end">
          <button class="btn-action" onclick="openDetail(${k.id})" title="Detail"><i class="fa-solid fa-eye"></i></button>
          <button class="btn-action" onclick="openEdit(${k.id})" title="Edit"><i class="fa-solid fa-edit"></i></button>
          <button class="btn-action btn-delete" onclick="openDel(${k.id})" title="Delete"><i class="fa-solid fa-trash"></i></button>
        </div>
      </td>
    </tr>
  `).join('');
  document.getElementById('tblCount').textContent = `${filtered.length} tugas`;
}

function applyFilter(){
  const q = get('srchInput').toLowerCase();
  const st = get('fltStatus');
  const pl = get('fltPlatform');
  const br = get('fltBrand');
  filtered = db.filter(k => 
    (k.title.toLowerCase().includes(q) || k.brand_name.toLowerCase().includes(q)) &&
    (!st || k.status === st) && (!pl || k.platform === pl) && (!br || String(k.brand) === br)
  );
  renderTable();
}

/* ── MODALS ─────────────────────────────── */
function openModal(id){ document.getElementById(id).classList.add('open'); document.body.style.overflow='hidden'; }
function closeModal(id){ document.getElementById(id).classList.remove('open'); document.body.style.overflow=''; }
function bgClose(e,id){ if(e.target.id===id) closeModal(id); }

function openCreate(){ editId=null; curStep=1; document.getElementById('copyLinkContainer').style.display='none'; resetForm(); updateWizUI(); openModal('ovWizard'); }
function openEdit(id){
  const k = db.find(x=>x.id == id); if(!k) return;
  editId=id; curStep=1; resetForm();
  
  // Explicit mapping to ensure all fields are filled
  set('fDesc', k.description);
  set('fTitle', k.title);
  set('fBrand', k.brand);
  set('fPlatform', k.platform);
  
  // Update format options based on platform before setting the value
  const platform = k.platform;
  const formatSelect = document.getElementById('fFormat');
  if (formatSelect) {
    formatSelect.innerHTML = '<option value="">Pilih...</option>';
    const opts = { 
      Instagram: ['IG Feed', 'IG Reels', 'IG Story'], 
      TikTok: ['Video Vertikal', 'Carousel'], 
      YouTube: ['Video Panjang', 'Shorts'] 
    };
    if (opts[platform]) {
      opts[platform].forEach(o => formatSelect.add(new Option(o, o)));
    }
    formatSelect.value = k.format || '';
  }

  set('fDuration', k.duration);
  set('fDeadProd', k.deadProd);
  set('fDeadPub', k.deadPub);
  set('fObjective', k.objective);
  set('fAudience', k.audience);
  set('fKeyMsg', k.keyMsg);
  set('fHook', k.hook);
  set('fStory', k.story);
  set('fVisual', k.visual);
  set('fCaption', k.caption);
  set('fCta', k.cta);
  set('fHashtag', k.hashtag);
  set('fViews', k.views);
  set('fEngage', k.engage);
  set('fCreator', k.creator);
  set('fBriefToken', k.token);
  document.getElementById('copyLinkContainer').style.display = 'block';
  
  updateWizUI(); 
  openModal('ovWizard');
}

function resetForm(){
  document.querySelectorAll('.finp, .ftxt, .fsel-f').forEach(el => { 
    el.value=''; 
    el.classList.remove('err'); 
  });
  document.querySelectorAll('.ferr').forEach(el => el.classList.remove('show'));
}

/* ── WIZARD ─────────────────────────────── */
function validateStep(s){
  let ok = true;
  const err = (id, show) => {
    const el = document.getElementById('f'+id);
    const msg = document.getElementById('e'+id);
    if(el) el.classList.toggle('err', show);
    if(msg) msg.classList.toggle('show', show);
    if(show) ok = false;
  };

  if(s===1) err('Desc', !get('fDesc'));
  if(s===2){
    err('Title', !get('fTitle'));
    err('Brand', !get('fBrand'));
    err('Platform', !get('fPlatform'));
    err('Format', !get('fFormat'));
    err('Duration', !get('fDuration'));
    err('DeadProd', !get('fDeadProd'));
    err('DeadPub', !get('fDeadPub'));
  }
  if(s===3){
    err('Objective', !get('fObjective'));
    err('Audience', !get('fAudience'));
    err('KeyMsg', !get('fKeyMsg'));
  }
  if(s===4){
    err('Hook', !get('fHook'));
    err('Story', !get('fStory'));
    err('Visual', !get('fVisual'));
  }
  if(s===5){
    err('Caption', !get('fCaption'));
    err('Cta', !get('fCta'));
    err('Hashtag', !get('fHashtag'));
  }
  if(s===6){
    err('Views', !get('fViews'));
    err('Engage', !get('fEngage'));
  }
  return ok;
}

function updateWizUI(){
  for(let i=1;i<=NSTEPS;i++){
    const panel = document.getElementById('sp'+i);
    if(panel) panel.classList.toggle('show', i===curStep);
    
    const ws = document.getElementById('ws'+i);
    const wd = document.getElementById('wd'+i);
    if(ws && wd){
      ws.classList.remove('active','done');
      if(i<curStep){ 
        ws.classList.add('done'); 
        wd.innerHTML='<i class="fa-solid fa-check"></i>'; 
      }
      else if(i===curStep){ 
        ws.classList.add('active'); 
        wd.textContent=i; 
      }
      else wd.textContent=i;
    }
  }
  
  document.getElementById('wizStepNum').textContent = curStep;
  document.getElementById('wizCurr').textContent = curStep;
  document.getElementById('wizStepName').textContent = STEP_NAMES[curStep-1];
  document.getElementById('btnPrev').style.display = curStep>1 ? '' : 'none';
  document.getElementById('btnNext').innerHTML = curStep===NSTEPS 
    ? (editId ? '<i class="fa-solid fa-floppy-disk"></i> Update Brief' : '<i class="fa-solid fa-floppy-disk"></i> Simpan Brief') 
    : 'Selanjutnya <i class="fa-solid fa-arrow-right"></i>';
    
  if(curStep===NSTEPS) buildSummary();
}

function buildSummary(){
  const s = [
    ['Judul', get('fTitle')],
    ['Brand', document.querySelector('#fBrand option:checked')?.text || '-'],
    ['Platform', get('fPlatform')],
    ['Deadline Prod', fmtDate(get('fDeadProd'))],
    ['Deadline Pub', fmtDate(get('fDeadPub'))]
  ];
  document.getElementById('wizSummary').innerHTML = s.map(([l,v])=>`<div class="sumrow"><span>${l}</span><b>${v}</b></div>`).join('');
}

function wizNext(){
  if(!validateStep(curStep)) return;
  
  if(curStep < NSTEPS){ 
    curStep++; 
    updateWizUI(); 
    return; 
  }
  
  const btn = document.getElementById('btnNext'); 
  const originalHtml = btn.innerHTML;
  btn.disabled=true; 
  btn.innerHTML='<i class="fa-solid fa-spinner spin"></i> Menyimpan...';
  
  const data = {
    title:get('fTitle'), 
    description:get('fDesc'), 
    brand_id:get('fBrand'), 
    platform:get('fPlatform'), 
    content_format:get('fFormat'),
    target_duration:get('fDuration'), 
    production_deadline:get('fDeadProd'), 
    publish_deadline:get('fDeadPub'),
    objective:get('fObjective'), 
    target_audience:get('fAudience'), 
    key_message:get('fKeyMsg'),
    hook:get('fHook'), 
    storyline:get('fStory'), 
    visual_direction:get('fVisual'),
    caption:get('fCaption'), 
    cta:get('fCta'), 
    hashtags:get('fHashtag'),
    target_views:get('fViews'), 
    target_engagement:get('fEngage'), 
    creator_email:get('fCreator')
  };
  
  const url = editId ? `/content-briefs/${editId}` : '/content-briefs';
  const method = editId ? 'PUT' : 'POST';
  
  fetch(url, {
    method: method,
    headers: { 
      'Content-Type':'application/json', 
      'X-CSRF-TOKEN': '{{ csrf_token() }}', 
      'Accept':'application/json' 
    },
    body: JSON.stringify(data)
  })
  .then(r => r.json())
  .then(res => {
    if(res.success){
      toast('s', res.message);
      
      if (!editId && res.share_token) {
        document.getElementById('fBriefToken').value = res.share_token;
        document.getElementById('copyLinkContainer').style.display = 'block';
        
        document.getElementById('wizTitle').innerHTML = '<span style="color:var(--emerald)"><i class="fa-solid fa-check-circle"></i> Brief Berhasil Disimpan</span>';
        document.getElementById('wizStepName').textContent = 'Anda bisa membagikan link brief sekarang';
        
        const btnNext = document.getElementById('btnNext');
        btnNext.innerHTML = '<i class="fa-solid fa-check"></i> Selesai';
        btnNext.onclick = function() { window.location.reload(); };
        btnNext.disabled = false;
        
        const btnPrev = document.getElementById('btnPrev');
        if (btnPrev) btnPrev.style.display = 'none';
        
        // Disable form inputs to prevent further changes
        document.querySelectorAll('.finp, .ftxt, .fsel-f').forEach(el => el.disabled = true);
      } else {
        setTimeout(() => window.location.reload(), 1000);
      }
    } else {
      toast('e', res.message || 'Gagal menyimpan data');
      btn.disabled=false; 
      btn.innerHTML=originalHtml;
      
      if(res.errors){
        Object.keys(res.errors).forEach(key => {
          toast('e', res.errors[key][0]);
        });
      }
    }
  })
  .catch(err => {
    console.error('Error saving brief:', err);
    toast('e', 'Terjadi kesalahan sistem');
    btn.disabled=false; 
    btn.innerHTML=originalHtml;
  });
}
function wizPrev(){ if(curStep>1){ curStep--; updateWizUI(); } }

function copyBriefLink() {
  const token = document.getElementById('fBriefToken').value;
  if (!token) return;
  const link = `{{ url('/brief') }}/${token}`;
  navigator.clipboard.writeText(link).then(() => {
    const fb = document.getElementById('copyFeedback');
    fb.style.display = 'inline-block';
    setTimeout(() => fb.style.display = 'none', 2000);
  });
}

/* ── DETAIL ─────────────────────────────── */
function openDetail(id){
  const k = db.find(x=>x.id == id); if(!k) return;
  
  const iconCls = PLAT_ICON[k.platform] ? `fa-brands ${PLAT_ICON[k.platform]}` : 'fa-solid fa-file-lines';
  
  // Update Hero section
  document.getElementById('detHero').innerHTML = `
    <div class="det-ic" style="background:${col(k.id)}">
      <i class="${iconCls}"></i>
    </div>
    <div>
      <div class="det-title">${k.title || 'Tanpa Judul'}</div>
      <div class="det-meta">
        <span class="df-tag">${k.brand_name || '-'}</span>
        <span class="df-tag" style="background:var(--bg);color:var(--text-500)">${k.platform || '-'}</span>
        ${pill(k.status)}
      </div>
    </div>
  `;
  
  // Update Workflow Bar
  const idx = STATUS_IDX[k.status] || 0;
  document.getElementById('wfBar').innerHTML = WF_STEPS.map((s,i)=>`
    ${i>0?'<div class="wf-arr"><i class="fa-solid fa-chevron-right"></i></div>':''}
    <div class="wf-step ${i<idx?'wf-done':i===idx?'wf-active':'wf-pending'}">
      <div class="wf-dot"><i class="fa-solid fa-circle"></i></div>
      <div class="wf-lbl">${s}</div>
    </div>
  `).join('');
  
  // Update Tabs
  document.getElementById('detTabs').innerHTML = ['Brief','Strategi','Kreatif','Copywriting','Target KPI'].map((t,i)=>`
    <div class="dtab ${i===0?'on':''}" onclick="switchTab(${i},this)">${t}</div>
  `).join('');
  
  // Update Panels
  document.getElementById('detPanels').innerHTML = [
    // Tab 1: Brief
    `<div class="dpanel show">
      <div class="drow">
        <div class="df"><div class="df-lbl">Format</div><div class="df-val">${k.format || '-'}</div></div>
        <div class="df"><div class="df-lbl">Durasi</div><div class="df-val">${k.duration || '-'}</div></div>
        <div class="df"><div class="df-lbl">Deadline Prod</div><div class="df-val">${fmtDate(k.deadProd)}</div></div>
        <div class="df"><div class="df-lbl">Deadline Pub</div><div class="df-val">${fmtDate(k.deadPub)}</div></div>
        <div class="df full"><div class="df-lbl">Deskripsi</div><div class="df-val dim">${k.description || '-'}</div></div>
        <div class="df full"><div class="df-lbl">Creator Email</div><div class="df-val accent">${k.creator || 'Belum diassign'}</div></div>
      </div>
    </div>`,
    // Tab 2: Strategi
    `<div class="dpanel">
      <div class="df"><div class="df-lbl">Objective</div><div class="df-val">${k.objective || '-'}</div></div>
      <div class="df"><div class="df-lbl">Target Audience</div><div class="df-val dim">${k.audience || '-'}</div></div>
      <div class="df full"><div class="df-lbl">Key Message</div><div class="df-val dim">${k.keyMsg || '-'}</div></div>
    </div>`,
    // Tab 3: Kreatif
    `<div class="dpanel">
      <div class="df full"><div class="df-lbl">Hook</div><div class="df-val italic">"${k.hook || '-'}"</div></div>
      <div class="df full"><div class="df-lbl">Storyline</div><div class="df-val dim">${k.story || '-'}</div></div>
      <div class="df full"><div class="df-lbl">Visual Direction</div><div class="df-val dim">${k.visual || '-'}</div></div>
    </div>`,
    // Tab 4: Copywriting
    `<div class="dpanel">
      <div class="df full"><div class="df-lbl">Caption</div><div class="df-val dim" style="white-space:pre-wrap">${k.caption || '-'}</div></div>
      <div class="df"><div class="df-lbl">CTA</div><div class="df-val">${k.cta || '-'}</div></div>
      <div class="df"><div class="df-lbl">Hashtags</div><div class="df-val accent">${k.hashtag || '-'}</div></div>
    </div>`,
    // Tab 5: KPI
    `<div class="dpanel">
      <div class="drow">
        <div class="df"><div class="df-lbl">Target Views</div><div class="df-val">${(k.views || 0).toLocaleString()} views</div></div>
        <div class="df"><div class="df-lbl">Target Engagement</div><div class="df-val">${(k.engage || 0)}%</div></div>
      </div>
    </div>`
  ].join('');
  
  const editBtn = document.getElementById('detEditBtn');
  if(editBtn) {
    editBtn.onclick = () => { closeModal('ovDetail'); openEdit(id); };
  }
  openModal('ovDetail');
}
function switchTab(i,el){ document.querySelectorAll('.dtab').forEach(t=>t.classList.remove('on')); el.classList.add('on'); document.querySelectorAll('.dpanel').forEach((p,idx)=>p.classList.toggle('show',i===idx)); }

/* ── DELETE ─────────────────────────────── */
function openDel(id){ const k=db.find(x=>x.id == id); delId=id; document.getElementById('delMsg').textContent=`Hapus "${k.title}"?`; openModal('ovDel'); }
document.getElementById('delConfirmBtn').onclick = () => {
  const btn = document.getElementById('delConfirmBtn');
  btn.disabled = true;
  btn.innerHTML = '<i class="fa-solid fa-spinner spin"></i> Menghapus...';
  
  fetch(`/content-briefs/${delId}`, { 
    method:'DELETE', 
    headers:{
      'X-CSRF-TOKEN':'{{ csrf_token() }}',
      'Accept':'application/json'
    } 
  })
  .then(r => r.json())
  .then(res => {
    if(res.success) window.location.reload();
    else {
      toast('e', res.message || 'Gagal menghapus brief');
      btn.disabled = false;
      btn.innerHTML = 'Ya, Hapus';
    }
  })
  .catch(err => {
    toast('e', 'Terjadi kesalahan koneksi');
    btn.disabled = false;
    btn.innerHTML = 'Ya, Hapus';
  });
};

/* ── UTILS ──────────────────────────────── */
function updateFormatOptions(){
  const p = get('fPlatform'), f = document.getElementById('fFormat'); f.innerHTML='<option value="">Pilih...</option>';
  const opts = { Instagram:['IG Feed','IG Reels','IG Story'], TikTok:['Video Vertikal','Carousel'], YouTube:['Video Panjang','Shorts'] };
  if(opts[p]) opts[p].forEach(o => f.add(new Option(o,o)));
}
function addCharCounter(id,cid,max){ const el=document.getElementById(id); if(!el) return; el.oninput=()=>{ const l=el.value.length; document.getElementById(cid).textContent=`${l}/${max}`; document.getElementById(cid).classList.toggle('over',l>max); }; }
function toast(t,m){ const w=document.getElementById('toastWrap'), e=document.createElement('div'); e.className=`toast t-${t} show`; e.innerHTML=m; w.appendChild(e); setTimeout(()=>e.remove(),3000); }
</script>
@endpush
