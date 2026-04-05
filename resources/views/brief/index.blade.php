<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width,initial-scale=1.0"/>
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Pageflowry — Daftar Tugas Konten</title>
<link rel="preconnect" href="https://fonts.googleapis.com"/>
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700;0,9..40,800;1,9..40,400&display=swap" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet"/>
<style>
/* ─────────────────────────────────────────
   RESET & TOKENS
───────────────────────────────────────── */
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
:root{
  /* primary */
  --blue:        #5897fe;
  --blue-600:    #3a7bfe;
  --blue-700:    #2563eb;
  --blue-50:     #eff6ff;
  --blue-100:    #dbeafe;
  --blue-200:    #bfdbfe;

  /* neutral */
  --white:        #ffffff;
  --bg:           #f4f7fe;
  --border:       #e8eef9;
  --border-light: #f0f5ff;

  /* text */
  --text-900:    #0d1526;
  --text-700:    #2d3f5e;
  --text-600:    #5c7099;
  --text-400:    #8fa3c4;
  --text-300:    #b8cae4;

  /* accents */
  --orange:      #ff7849;
  --violet:      #8b5cf6;
  --emerald:     #10b981;
  --rose:        #f43f5e;
  --amber:       #f59e0b;
  --cyan:        #06b6d4;

  /* sizes */
  --sidebar:     240px;
  --topbar:      66px;
  --r:           16px;
  --r-sm:        10px;
  --r-xs:        7px;
  --rs:          10px;

  /* shadows */
  --s1: 0 1px 3px rgba(13,21,38,.05), 0 4px 16px rgba(88,151,254,.06);
  --s2: 0 4px 24px rgba(88,151,254,.12);
  --s3: 0 8px 40px rgba(88,151,254,.20);

  /* transitions */
  --t: .2s cubic-bezier(.4,0,.2,1);
}
html,body{height:100%;font-family:'DM Sans',sans-serif;background:var(--bg);color:var(--text-900);font-size:14px;line-height:1.5;-webkit-font-smoothing:antialiased}
::-webkit-scrollbar{width:4px;height:4px}
::-webkit-scrollbar-track{background:transparent}
::-webkit-scrollbar-thumb{background:var(--blue-200);border-radius:99px}
::-webkit-scrollbar-thumb:hover{background:var(--blue)}

/* ─────────────────────────────────────────
   SHELL
───────────────────────────────────────── */
.shell{display:flex;height:100vh;overflow:hidden}

/* ─────────────────────────────────────────
   SIDEBAR
───────────────────────────────────────── */
.sidebar{
  width:var(--sidebar);min-width:var(--sidebar);height:100vh;
  background:var(--white);border-right:1px solid var(--border);
  display:flex;flex-direction:column;overflow-y:auto;z-index:200;
}
.sb-logo{
  padding:20px 20px 18px;
  display:flex;
  align-items:center;
  gap:10px;
  border-bottom:1px solid var(--border-light);
  flex-shrink:0;
}
.sb-logo-mark{
  width:32px;height:32px;border-radius:8px;flex-shrink:0;
  background:linear-gradient(135deg,var(--blue),var(--blue-600));
  display:flex;align-items:center;justify-content:center;
}
.sb-logo-mark svg{width:15px;height:15px}
.sb-logo-name{font-size:1rem;font-weight:800;color:var(--blue);letter-spacing:-.5px;line-height:1}
.sb-logo-name em{color:var(--text-900);font-style:normal}
.sb-nav {
  padding: 14px 12px;
  flex: 1;
}
.sb-group-label{font-size:10px;font-weight:700;letter-spacing:1.1px;text-transform:uppercase;color:var(--text-300);padding:12px 10px 6px}
.sb-item{
  display:flex;align-items:center;gap:10px;padding:9.5px 12px;
  border-radius:var(--r-sm);cursor:pointer;transition:var(--t);
  font-size:13.5px;font-weight:500;color:var(--text-600);
  text-decoration:none;position:relative;margin-bottom:1px;
}
.sb-item:hover{background:var(--blue-50);color:var(--blue-600)}
.sb-item.active{background:var(--blue-50);color:var(--blue);font-weight:600}
.sb-item.active::before{
  content:'';position:absolute;left:0;top:22%;bottom:22%;
  width:3px;border-radius:0 3px 3px 0;background:var(--blue);
}
.icon-wrap{
  width:28px;height:28px;border-radius:8px;
  display:flex;align-items:center;justify-content:center;
  font-size:12.5px;flex-shrink:0;transition:var(--t);
}
.sb-item.active .icon-wrap{background:var(--blue);color:#fff;box-shadow:0 3px 10px rgba(88,151,254,.35)}
.sb-item:not(.active) .icon-wrap{color:var(--text-400)}
.sb-item:hover:not(.active) .icon-wrap{background:var(--blue-100);color:var(--blue)}
.sb-badge{margin-left:auto;background:var(--rose);color:#fff;font-size:10px;font-weight:700;padding:1px 6px;border-radius:99px;line-height:1.6}
.sb-footer{padding:14px 12px;border-top:1px solid var(--border-light);flex-shrink:0}
.sb-user{display:flex;align-items:center;gap:10px;padding:10px 12px;border-radius:var(--r-sm);background:var(--blue-50);cursor:pointer;transition:var(--t)}
.sb-user:hover{background:var(--blue-100)}
.sb-avatar{width:34px;height:34px;border-radius:50%;background:linear-gradient(135deg,var(--blue),var(--blue-600));display:flex;align-items:center;justify-content:center;color:#fff;font-size:12px;font-weight:700;flex-shrink:0}
.sb-user-info{flex:1;min-width:0}
.sb-user-name{font-size:12.5px;font-weight:600;color:var(--text-700);white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
.sb-user-role{font-size:11px;color:var(--blue);font-weight:500}

/* ─────────────────────────────────────────
   MAIN
───────────────────────────────────────── */
.main{flex:1;display:flex;flex-direction:column;overflow:hidden;min-width:0}
.topbar{
  height:var(--topbar);min-height:var(--topbar);background:var(--white);
  border-bottom:1px solid var(--border);
  display:flex;align-items:center;justify-content:space-between;
  padding:0 28px;gap:16px;flex-shrink:0;z-index:100;
}
.tb-title{font-size:18px;font-weight:800;color:var(--t9);letter-spacing:-.4px;line-height:1.1}
.tb-crumb{font-size:12px;color:var(--t4);margin-top:2px;display:flex;align-items:center;gap:5px}
.tb-crumb span{color:var(--blue);font-weight:500}
.tb-right{display:flex;align-items:center;gap:8px}
.tb-btn{
  width:38px;height:38px;border-radius:var(--rs);border:1px solid var(--border);
  background:var(--white);display:flex;align-items:center;justify-content:center;
  cursor:pointer;transition:var(--tr);color:var(--t5);font-size:15px;position:relative;
}
.tb-btn:hover{background:var(--blue-50);color:var(--blue);border-color:var(--blue-200)}
.tb-dot{position:absolute;top:7px;right:7px;width:7px;height:7px;border-radius:50%;background:var(--rose);border:1.5px solid #fff}
.tb-av{
  width:38px;height:38px;border-radius:var(--rs);
  background:linear-gradient(145deg,var(--blue),var(--blue-6));
  display:flex;align-items:center;justify-content:center;
  color:#fff;font-size:13px;font-weight:700;cursor:pointer;
  box-shadow:0 3px 12px rgba(88,151,254,.35);transition:var(--tr);
}
.tb-av:hover{transform:scale(1.05)}
.tb-div{width:1px;height:24px;background:var(--border);margin:0 4px}

/* Dashboard topbar classes */
.tb-left {
  display: flex;
  flex-direction: column;
  gap: 2px;
}
.tb-page {
  font-size: 18px;
  font-weight: 800;
  color: var(--text-900);
  letter-spacing: -0.4px;
  line-height: 1.1;
}
.tb-breadcrumb {
  font-size: 12px;
  color: var(--text-400);
  display: flex;
  align-items: center;
  gap: 5px;
}
.tb-breadcrumb span {
  color: var(--blue);
  font-weight: 500;
}
.tb-icon-btn {
  width: 38px;
  height: 38px;
  border-radius: var(--r-sm);
  border: 1px solid var(--border);
  background: var(--white);
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  transition: var(--t);
  color: var(--text-500);
  font-size: 15px;
  position: relative;
}
.tb-icon-btn:hover {
  background: var(--blue-50);
  color: var(--blue);
  border-color: var(--blue-200);
}
.tb-notif-dot {
  position: absolute;
  top: 7px;
  right: 7px;
  width: 7px;
  height: 7px;
  border-radius: 50%;
  background: var(--rose);
  border: 1.5px solid #fff;
}
.tb-divider {
  width: 1px;
  height: 24px;
  background: var(--border);
  margin: 0 4px;
}
.tb-avatar-btn {
  width: 38px;
  height: 38px;
  border-radius: var(--r-sm);
  background: linear-gradient(145deg, var(--blue), var(--blue-600));
  display: flex;
  align-items: center;
  justify-content: center;
  color: #fff;
  font-size: 13px;
  font-weight: 700;
  cursor: pointer;
  box-shadow: 0 3px 12px rgba(88,151,254,.35);
  transition: var(--t);
}
.tb-avatar-btn:hover {
  transform: scale(1.05);
}

/* ─────────────────────────────────────────
   BODY / SCROLL AREA
───────────────────────────────────────── */
.body{flex:1;overflow-y:auto;padding:26px 28px 60px;display:flex;flex-direction:column;gap:20px}

/* ─────────────────────────────────────────
   PAGE HEADER
───────────────────────────────────────── */
.pg-header{display:flex;align-items:center;justify-content:space-between;gap:16px;animation:fadeUp .35s ease both}
.pg-header-left{}
.pg-heading{font-size:22px;font-weight:800;color:var(--t9);letter-spacing:-.5px;margin-bottom:3px}
.pg-sub{font-size:13px;color:var(--t4)}

/* ─────────────────────────────────────────
   STAT CARDS
───────────────────────────────────────── */
.stats-row{display:grid;grid-template-columns:repeat(5,1fr);gap:14px}
.sc{
  background:var(--white);border-radius:var(--r);border:1px solid var(--border);
  box-shadow:var(--s1);padding:18px 16px;cursor:default;transition:var(--tr);
  animation:fadeUp .4s ease both;animation-delay:calc(var(--i,0)*55ms);
  position:relative;overflow:hidden;
}
.sc:hover{transform:translateY(-3px);box-shadow:var(--s2);border-color:var(--blue-200)}
.sc::after{content:'';position:absolute;bottom:-14px;right:-14px;width:60px;height:60px;border-radius:50%;opacity:.07;transition:var(--tr)}
.sc:hover::after{opacity:.16}
.sc-b {border-top:2.5px solid var(--blue)}.sc-b::after{background:var(--blue)}
.sc-o {border-top:2.5px solid var(--orange)}.sc-o::after{background:var(--orange)}
.sc-v {border-top:2.5px solid var(--violet)}.sc-v::after{background:var(--violet)}
.sc-r {border-top:2.5px solid var(--rose)}.sc-r::after{background:var(--rose)}
.sc-g {border-top:2.5px solid var(--emerald)}.sc-g::after{background:var(--emerald)}
.sc-ic{width:36px;height:36px;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:14px;margin-bottom:12px}
.sc-b .sc-ic{background:rgba(88,151,254,.1);color:var(--blue)}
.sc-o .sc-ic{background:rgba(255,120,73,.1);color:var(--orange)}
.sc-v .sc-ic{background:rgba(139,92,246,.1);color:var(--violet)}
.sc-r .sc-ic{background:rgba(244,63,94,.1);color:var(--rose)}
.sc-g .sc-ic{background:rgba(16,185,129,.1);color:var(--emerald)}
.sc-num{font-size:26px;font-weight:800;color:var(--t9);line-height:1;margin-bottom:4px;letter-spacing:-.4px}
.sc-label{font-size:12px;font-weight:500;color:var(--t4)}
.sc-sub{font-size:11px;font-weight:600;margin-top:7px;display:flex;align-items:center;gap:3px}
.s-up{color:var(--emerald)}.s-w{color:var(--amber)}.s-dn{color:var(--rose)}

/* ─────────────────────────────────────────
   TOOLBAR
───────────────────────────────────────── */
.toolbar{display:flex;align-items:center;gap:10px;flex-wrap:wrap;animation:fadeUp .4s .1s ease both}
.srch-wrap{flex:1;max-width:320px;position:relative}
.srch-wrap i{position:absolute;left:13px;top:50%;transform:translateY(-50%);color:var(--t4);font-size:13px;pointer-events:none}
.srch{
  width:100%;height:40px;padding:0 14px 0 38px;
  border:1.5px solid var(--border);border-radius:var(--rs);
  background:var(--white);font-family:'DM Sans',sans-serif;
  font-size:13.5px;color:var(--t9);transition:var(--tr);outline:none;
}
.srch::placeholder{color:var(--t3)}
.srch:focus{border-color:var(--blue);box-shadow:0 0 0 3px rgba(88,151,254,.12)}
.fsel{
  height:40px;padding:0 32px 0 14px;border:1.5px solid var(--border);
  border-radius:var(--rs);background:var(--white);
  font-family:'DM Sans',sans-serif;font-size:13px;font-weight:500;
  color:var(--t5);cursor:pointer;outline:none;transition:var(--tr);
  appearance:none;
  background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6'%3E%3Cpath d='M0 0l5 6 5-6z' fill='%238fa3c4'/%3E%3C/svg%3E");
  background-repeat:no-repeat;background-position:right 12px center;
}
.fsel:focus{border-color:var(--blue);box-shadow:0 0 0 3px rgba(88,151,254,.12)}
.sp{flex:1}
.btn{
  display:inline-flex;align-items:center;gap:7px;padding:0 18px;height:40px;
  border-radius:var(--rs);font-family:'DM Sans',sans-serif;
  font-size:13.5px;font-weight:600;cursor:pointer;transition:var(--tr);
  border:none;outline:none;white-space:nowrap;
}
.btn-primary{background:linear-gradient(135deg,var(--blue),var(--blue-600));color:#fff;box-shadow:0 3px 12px rgba(88,151,254,.35)}
.btn-primary:hover{transform:translateY(-2px);box-shadow:0 6px 20px rgba(88,151,254,.4)}
.btn-primary:active{transform:scale(.97)}
.btn-ghost{background:var(--white);color:var(--t5);border:1.5px solid var(--border)}
.btn-ghost:hover{background:var(--blue-50);color:var(--blue);border-color:var(--blue-200)}
.btn-danger{background:rgba(244,63,94,.08);color:var(--rose);border:1.5px solid rgba(244,63,94,.18)}
.btn-danger:hover{background:rgba(244,63,94,.14)}
.btn-sm{height:34px;padding:0 14px;font-size:12.5px}

/* ─────/* Action Buttons Styling */
.actions {
  display: flex;
  gap: 6px;
  align-items: center;
}

.btn-action {
  width: 32px;
  height: 32px;
  border-radius: var(--r-sm);
  border: 1px solid var(--border);
  background: var(--white);
  color: var(--t5);
  font-size: 13px;
  cursor: pointer;
  transition: var(--tr);
  display: flex;
  align-items: center;
  justify-content: center;
  position: relative;
}

.btn-action:hover {
  background: var(--blue-50);
  color: var(--blue);
  border-color: var(--blue-200);
  transform: translateY(-1px);
  box-shadow: 0 2px 8px rgba(88,151,254,0.15);
}

.btn-action:active {
  transform: scale(0.95);
}

.btn-action.btn-delete {
  color: var(--rose);
  border-color: rgba(244,63,94,0.2);
}

.btn-action.btn-delete:hover {
  background: rgba(244,63,94,0.08);
  color: var(--rose);
  border-color: rgba(244,63,94,0.3);
}

.btn-action i {
  font-size: 13px;
  transition: var(--tr);
}

/* ────────────────────────────────────
   TABLE CARD
────────────────────────────────── */
.tcard{background:var(--white);border-radius:var(--r);border:1px solid var(--border);box-shadow:var(--s1);overflow:hidden;animation:fadeUp .45s .15s ease both;display:flex;flex-direction:column;min-height:600px}
.tcard-head{display:flex;align-items:center;justify-content:space-between;padding:18px 22px 16px;border-bottom:1px solid var(--blight)}
.tch-l{display:flex;align-items:center;gap:10px}
.tch-title{font-size:14px;font-weight:700;color:var(--t7)}
.tch-cnt{font-size:11.5px;font-weight:700;background:var(--blue-50);color:var(--blue);padding:2px 9px;border-radius:99px}
.tcard-body{flex:1;overflow-y:auto;min-height:0}
.ktable{width:100%;border-collapse:collapse}
.ktable thead th{
  font-size:10.5px;font-weight:700;text-transform:uppercase;letter-spacing:.65px;
  color:var(--t3);padding:12px 16px;text-align:left;
  background:var(--bg);border-bottom:1px solid var(--border);white-space:nowrap;
}
.ktable tbody tr{border-bottom:1px solid var(--blight);transition:var(--tr);cursor:pointer}
.ktable tbody tr:last-child{border-bottom:none}
.ktable tbody tr:hover{background:var(--blue-50)}
.ktable tbody tr:hover .row-acts{opacity:1}
.ktable tbody td{padding:13px 16px;font-size:13px;color:var(--t7);vertical-align:middle}
.tc-wrap{display:flex;align-items:center;gap:11px}
.tc-icon{width:38px;height:38px;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:15px;flex-shrink:0;color:#fff}
.tc-title{font-size:13.5px;font-weight:700;color:var(--t9);margin-bottom:1px;max-width:200px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
.tc-sub{font-size:11px;color:var(--t4)}
.brand-tag{display:inline-flex;align-items:center;gap:5px;background:var(--blue-50);color:var(--blue);font-size:11.5px;font-weight:600;padding:3px 9px;border-radius:99px}
.plat{display:inline-flex;align-items:center;gap:5px;padding:4px 10px;border-radius:99px;font-size:11px;font-weight:600}
.plat-ig{background:#fce7f3;color:#9d174d}
.plat-tt{background:#f0fdf4;color:#14532d}
.plat-yt{background:#fef2f2;color:#991b1b}
.dl{font-size:12px;font-weight:600;display:flex;align-items:center;gap:5px}
.dl-ok{color:var(--t5)}.dl-w{color:var(--amber)}.dl-hot{color:var(--rose)}
.pill{display:inline-flex;align-items:center;gap:5px;padding:4px 11px;border-radius:99px;font-size:11px;font-weight:700;white-space:nowrap}
.pdot{width:6px;height:6px;border-radius:50%;flex-shrink:0}
.p-prod{background:rgba(255,120,73,.1);color:#c2440f}.p-prod .pdot{background:var(--orange)}
.p-review{background:rgba(139,92,246,.1);color:#5b21b6}.p-review .pdot{background:var(--violet)}
.p-revision{background:rgba(244,63,94,.1);color:#9f1239}.p-revision .pdot{background:var(--rose)}
.p-ready{background:rgba(245,158,11,.1);color:#92400e}.p-ready .pdot{background:var(--amber)}
.p-pub{background:rgba(16,185,129,.1);color:#065f46}.p-pub .pdot{background:var(--emerald)}
.row-acts{display:flex;align-items:center;gap:5px;opacity:0;transition:var(--tr)}
.ab{width:32px;height:32px;border-radius:8px;border:none;display:flex;align-items:center;justify-content:center;font-size:13px;cursor:pointer;transition:var(--tr)}
.ab-d{background:var(--blue-50);color:var(--blue)}.ab-d:hover{background:var(--blue-100);transform:scale(1.1)}
.ab-e{background:rgba(245,158,11,.1);color:var(--amber)}.ab-e:hover{background:rgba(245,158,11,.2);transform:scale(1.1)}
.ab-x{background:rgba(244,63,94,.1);color:var(--rose)}.ab-x:hover{background:rgba(244,63,94,.2);transform:scale(1.1)}
.empty-row td{text-align:center;padding:60px 20px}
.empty-ic{width:60px;height:60px;border-radius:16px;background:var(--blue-50);display:flex;align-items:center;justify-content:center;font-size:22px;color:var(--blue);margin:0 auto 12px}

/* ─────────────────────────────────────────
   PAGINATION
───────────────────────────────────────── */
.pagi{display:flex;align-items:center;justify-content:space-between;padding:14px 20px;border-top:1px solid var(--blight)}
.pagi-info{font-size:12.5px;color:var(--t4)}.pagi-info b{color:var(--t7)}
.pagi-btns{display:flex;gap:4px}
.pb{width:32px;height:32px;border-radius:8px;border:1.5px solid var(--border);background:var(--white);font-family:'DM Sans',sans-serif;font-size:12.5px;font-weight:600;color:var(--t5);cursor:pointer;transition:var(--tr);display:flex;align-items:center;justify-content:center}
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
  left:calc(50% + 18px);right:calc(-50% + 18px);
  height:2px;background:var(--border);z-index:0;transition:background .3s;
}
.wstep.done:not(:last-child)::after{background:var(--emerald)}
.wdot{
  width:34px;height:34px;border-radius:50%;
  border:2.5px solid var(--border);background:var(--white);
  display:flex;align-items:center;justify-content:center;
  font-size:12px;font-weight:700;color:var(--t4);
  transition:var(--tr);z-index:1;position:relative;
}
.wstep.active .wdot{border-color:var(--blue);background:var(--blue);color:#fff;box-shadow:0 0 0 4px rgba(88,151,254,.14)}
.wstep.done .wdot{border-color:var(--emerald);background:var(--emerald);color:#fff}
.wlbl{font-size:9.5px;font-weight:600;color:var(--t3);margin-top:6px;text-align:center;line-height:1.3}
.wstep.active .wlbl{color:var(--blue)}
.wstep.done .wlbl{color:var(--emerald)}
.mhd{padding:20px 28px 0;display:flex;align-items:flex-start;justify-content:space-between}
.meyebrow{font-size:11px;font-weight:700;letter-spacing:1px;text-transform:uppercase;color:var(--blue);display:flex;align-items:center;gap:6px;margin-bottom:4px}
.mtitle{font-size:20px;font-weight:800;color:var(--t9);letter-spacing:-.4px}
.msub{font-size:13px;color:var(--t4);margin-top:3px}
.mclose{width:36px;height:36px;border-radius:10px;border:none;background:var(--bg);cursor:pointer;transition:var(--tr);display:flex;align-items:center;justify-content:center;color:var(--t4);font-size:15px;flex-shrink:0}
.mclose:hover{background:rgba(244,63,94,.1);color:var(--rose)}
.mbody{padding:22px 28px}
.mdiv{height:1px;background:var(--blight);margin:4px 0 20px}
.spanel{display:none;flex-direction:column;gap:16px;animation:fadeUp .3s ease both}
.spanel.show{display:flex}
.shd{display:flex;align-items:flex-start;gap:9px;margin-bottom:4px}
.shd-bar{width:3px;min-width:3px;height:22px;border-radius:3px;background:var(--blue);margin-top:1px}
.shd-title{font-size:13.5px;font-weight:800;color:var(--t9)}
.shd-sub{font-size:12px;color:var(--t4);margin-top:2px;line-height:1.4}
/* form grid */
.fg2{display:grid;grid-template-columns:1fr 1fr;gap:16px}
.fg3{display:grid;grid-template-columns:1fr 1fr 1fr;gap:16px}
.fg{display:flex;flex-direction:column;gap:6px}
.flbl{font-size:12.5px;font-weight:700;color:var(--t7);display:flex;align-items:center;gap:5px}
.req{color:var(--rose)}
.hint-lbl{font-size:11px;font-weight:400;color:var(--t3);margin-left:2px}
.finp,.ftxt,.fsel-f{
  width:100%;font-family:'DM Sans',sans-serif;font-size:13.5px;
  color:var(--t9);border:1.5px solid var(--border);
  border-radius:var(--rs);background:var(--white);transition:var(--tr);outline:none;
}
.finp,.fsel-f{height:42px;padding:0 14px}
.ftxt{padding:12px 14px;resize:vertical;line-height:1.55}
.fsel-f{
  appearance:none;cursor:pointer;
  background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6'%3E%3Cpath d='M0 0l5 6 5-6z' fill='%238fa3c4'/%3E%3C/svg%3E");
  background-repeat:no-repeat;background-position:right 14px center;
}
.finp::placeholder,.ftxt::placeholder{color:var(--t3)}
.finp:focus,.ftxt:focus,.fsel-f:focus{border-color:var(--blue);box-shadow:0 0 0 3.5px rgba(88,151,254,.12)}
.finp.err,.ftxt.err,.fsel-f.err{border-color:var(--rose);box-shadow:0 0 0 3px rgba(244,63,94,.1)}
.ferr{font-size:11.5px;color:var(--rose);font-weight:500;display:none}
.ferr.show{display:block}
.ico-wrap{position:relative}
.ico-wrap>i{position:absolute;left:13px;top:50%;transform:translateY(-50%);color:var(--t4);font-size:13px;pointer-events:none}
.ico-wrap .finp{padding-left:38px}
.unit-wrap{position:relative}
.unit-wrap .finp{padding-right:52px}
.unit{position:absolute;right:14px;top:50%;transform:translateY(-50%);font-size:12px;font-weight:700;color:var(--t4);pointer-events:none}
.char-cnt{font-size:11px;color:var(--t3);text-align:right;margin-top:3px}
.char-cnt.over{color:var(--rose)}
.info-box{background:var(--blue-50);border:1px solid var(--blue-200);border-radius:var(--rs);padding:14px 16px}
.info-box-ttl{font-size:12px;font-weight:700;color:var(--blue);margin-bottom:6px;display:flex;align-items:center;gap:6px}
.info-box-txt{font-size:12px;color:var(--t5);line-height:1.6}
.assign-box{border:1.5px dashed var(--border);border-radius:var(--rs);padding:20px;background:var(--bg);transition:var(--tr)}
.assign-box:focus-within{border-color:var(--blue);background:var(--blue-50)}
.assign-hint{font-size:11.5px;color:var(--t4);margin-top:10px;display:flex;align-items:flex-start;gap:6px;line-height:1.45}
.assign-hint i{color:var(--blue);flex-shrink:0;margin-top:2px}
.summary-card{background:var(--bg);border-radius:var(--rs);padding:16px;border:1px solid var(--border)}
.summary-ttl{font-size:12.5px;font-weight:700;color:var(--t7);margin-bottom:12px;display:flex;align-items:center;gap:6px}
.sumrow{display:flex;align-items:center;justify-content:space-between;font-size:12.5px;color:var(--t4);padding:5px 0;border-bottom:1px solid var(--blight)}
.sumrow:last-child{border-bottom:none}
.sumrow b{color:var(--t7);font-weight:600;text-align:right;max-width:55%;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
.mfoot{padding:0 28px 24px;display:flex;align-items:center;justify-content:space-between;gap:10px;border-top:1px solid var(--blight);padding-top:16px;margin-top:4px}
.mfoot-info{font-size:12px;color:var(--t4)}.mfoot-info b{color:var(--t7)}
.mfoot-btns{display:flex;gap:9px}

/* ─────────────────────────────────────────
   DETAIL MODAL
───────────────────────────────────────── */
.det-modal{max-width:720px}
.det-hero{padding:24px 28px 0;display:flex;align-items:flex-start;gap:16px}
.det-ic{width:52px;height:52px;border-radius:14px;display:flex;align-items:center;justify-content:center;font-size:20px;color:#fff;flex-shrink:0}
.det-title{font-size:19px;font-weight:800;color:var(--t9);letter-spacing:-.4px;line-height:1.2}
.det-meta{display:flex;align-items:center;flex-wrap:wrap;gap:7px;margin-top:8px}
.wf-bar{padding:16px 28px 0;display:flex;align-items:center;gap:0;overflow-x:auto}
.wf-step{display:flex;flex-direction:column;align-items:center;gap:4px;min-width:72px;flex-shrink:0}
.wf-dot{width:28px;height:28px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:10px;transition:var(--tr)}
.wf-done .wf-dot{background:var(--emerald);color:#fff}
.wf-active .wf-dot{background:var(--blue);color:#fff;box-shadow:0 0 0 3px rgba(88,151,254,.2)}
.wf-pending .wf-dot{background:var(--border);color:var(--t4)}
.wf-lbl{font-size:9px;font-weight:600;text-align:center;line-height:1.3;color:var(--t4)}
.wf-done .wf-lbl{color:var(--emerald)}
.wf-active .wf-lbl{color:var(--blue)}
.wf-arr{font-size:10px;color:var(--t3);margin:0 2px;padding-bottom:14px;flex-shrink:0}
.det-body{padding:16px 28px 0}
.det-tabs{display:flex;border-bottom:1px solid var(--border);margin-bottom:16px}
.dtab{padding:10px 16px;font-size:13px;font-weight:600;color:var(--t4);cursor:pointer;border-bottom:2.5px solid transparent;transition:var(--tr)}
.dtab:hover{color:var(--t7)}
.dtab.on{color:var(--blue);border-bottom-color:var(--blue)}
.dpanel{display:none;flex-direction:column;gap:12px;animation:fadeUp .25s ease both;padding-bottom:4px}
.dpanel.show{display:flex}
.drow{display:grid;grid-template-columns:1fr 1fr;gap:12px}
.df{display:flex;flex-direction:column;gap:3px}
.df.full{grid-column:1/-1}
.df-lbl{font-size:10.5px;font-weight:700;text-transform:uppercase;letter-spacing:.6px;color:var(--t3)}
.df-val{font-size:13px;font-weight:500;color:var(--t7);line-height:1.5}
.df-val.dim{font-weight:400;color:var(--t5)}
.df-val.accent{color:var(--blue);font-size:12.5px}
.df-val.italic{font-style:italic;color:var(--t5)}
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
  border-radius:12px;background:var(--t9);color:#fff;
  font-size:13px;font-weight:500;box-shadow:0 8px 32px rgba(13,21,38,.25);
  transform:translateX(110%);transition:transform .35s cubic-bezier(.34,1.56,.64,1);
  pointer-events:all;min-width:250px;max-width:380px;
}
.toast.show{transform:translateX(0)}
.t-ic{width:28px;height:28px;border-radius:8px;flex-shrink:0;display:flex;align-items:center;justify-content:center;font-size:13px}
.t-s .t-ic{background:rgba(16,185,129,.2);color:var(--emerald)}
.t-w .t-ic{background:rgba(245,158,11,.2);color:var(--amber)}
.t-e .t-ic{background:rgba(244,63,94,.2);color:var(--rose)}

/* ─────────────────────────────────────────
   ANIMATIONS
───────────────────────────────────────── */
@keyframes fadeUp{from{opacity:0;transform:translateY(14px)}to{opacity:1;transform:translateY(0)}}
@keyframes spin{to{transform:rotate(360deg)}}
.spin{display:inline-block;animation:spin .7s linear infinite}
</style>
</head>
<body>
@php
  $authName = auth()->user()->name ?? '';
  $authParts = preg_split('/\s+/', trim($authName)) ?: [];
  $authFirst = $authParts[0] ?? 'U';
  $authSecond = $authParts[1] ?? $authFirst;
  $authInitials = strtoupper(substr($authFirst, 0, 1) . substr($authSecond, 0, 1));
@endphp
<div class="shell">

<!-- ══════════════ SIDEBAR ══════════════ -->
<aside class="sidebar">
  <div class="sb-logo">
    <div class="sb-logo-mark">
      <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M13 2L4.5 13.5H11L10 22L20.5 9.5H14L13 2Z" fill="white" stroke="white" stroke-width="1.5" stroke-linejoin="round"/>
      </svg>
    </div>
    <div class="sb-logo-name">Page<em>flowry</em></div>
  </div>

  <nav class="sb-nav">
    <div class="sb-group-label">Overview</div>
    <a class="sb-item" href="{{ route('admin.dashboard') }}">
      <span class="icon-wrap"><i class="fa-solid fa-house"></i></span>
      Dashboard
    </a>

    <div class="sb-group-label">Manajemen</div>
    <a class="sb-item" href="{{ route('brands.index') }}">
      <span class="icon-wrap"><i class="fa-solid fa-tag"></i></span>
      Brand Management
    </a>
    <a class="sb-item active" href="{{ route('content-tasks.index') }}">
      <span class="icon-wrap"><i class="fa-solid fa-list-check"></i></span>
      Daftar Tugas Konten
    </a>

    <div class="sb-group-label">Workflow</div>
    <a class="sb-item" href="{{ route('production.index') }}">
      <span class="icon-wrap"><i class="fa-solid fa-film"></i></span>
      Production
    </a>
    <a class="sb-item" href="{{ route('revision.index', 1) }}">
      <span class="icon-wrap"><i class="fa-solid fa-rotate-left"></i></span>
      Revision
      <span class="sb-badge">4</span>
    </a>
    <a class="sb-item" href="{{ route('approval.index') }}">
      <span class="icon-wrap"><i class="fa-solid fa-circle-check"></i></span>
      Approval
    </a>
    <a class="sb-item" href="{{ route('publishing.index') }}">
      <span class="icon-wrap"><i class="fa-solid fa-paper-plane"></i></span>
      Publishing
    </a>

    <div class="sb-group-label">Laporan</div>
    <a class="sb-item" href="{{ route('analytics.index') }}">
      <span class="icon-wrap"><i class="fa-solid fa-chart-line"></i></span>
      Analytics
    </a>
    <a class="sb-item" href="{{ route('report.index') }}">
      <span class="icon-wrap"><i class="fa-solid fa-file-lines"></i></span>
      Report
    </a>

    <div class="sb-group-label">Lainnya</div>
    <a class="sb-item" href="{{ route('settings.index') }}">
      <span class="icon-wrap"><i class="fa-solid fa-gear"></i></span>
      Settings
    </a>
  </nav>

  <div class="sb-footer">
    <div class="sb-user">
      <div class="sb-avatar">{{ auth()->check() ? $authInitials : 'U' }}</div>
      <div class="sb-user-info">
        <div class="sb-user-name">{{ auth()->user()->name ?? 'Guest User' }}</div>
        <div class="sb-user-role">{{ auth()->check() ? ucfirst(auth()->user()->role ?? 'guest') : 'Guest' }}</div>
      </div>
      <i class="fa-solid fa-ellipsis-vertical" style="color:var(--text-300);font-size:12px"></i>
    </div>
  </div>
</aside>

<!-- ═══════ MAIN ═══════ -->
<div class="main">

  <header class="topbar">
    <div class="tb-left">
      <div class="tb-page">Daftar Tugas Konten</div>
      <div class="tb-breadcrumb">
        <i class="fa-solid fa-house" style="font-size:10px"></i>
        <i class="fa-solid fa-chevron-right" style="font-size:9px;color:var(--text-300)"></i>
        <span>Daftar Tugas Konten</span>
        &nbsp;·&nbsp; <span id="today-date"></span>
      </div>
    </div>
    <div class="tb-right">
      <div class="tb-icon-btn" title="Notifikasi">
        <i class="fa-regular fa-bell"></i>
        <span class="tb-notif-dot"></span>
      </div>
      <div class="tb-icon-btn" title="Pesan">
        <i class="fa-regular fa-envelope"></i>
      </div>
      <div class="tb-divider"></div>
      <div class="tb-avatar-btn" title="Profil">{{ auth()->check() ? $authInitials : 'U' }}</div>
      <div class="tb-icon-btn" title="Pengaturan">
        <i class="fa-solid fa-sliders"></i>
      </div>
    </div>
  </header>

  <div class="body">

    <!-- PAGE HEADER -->
    <div class="pg-header">
      <div>
        <div class="pg-heading">Daftar Tugas Konten</div>
        <div class="pg-sub">Kelola seluruh brief dan tugas konten untuk semua brand</div>
      </div>
      <button class="btn btn-primary" onclick="openCreate()">
        <i class="fa-solid fa-plus"></i> Buat Tugas Konten
      </button>
    </div>

    <!-- STAT CARDS -->
    <div class="stats-row">
      <div class="sc sc-b" style="--i:0">
        <div class="sc-ic"><i class="fa-solid fa-layer-group"></i></div>
        <div class="sc-num">{{ $stats['total'] ?? 0 }}</div>
        <div class="sc-label">Total Tugas</div>
        <div class="sc-sub s-b"><i class="fa-solid fa-check-circle"></i> Semua tugas</div>
      </div>
      <div class="sc sc-o" style="--i:1">
        <div class="sc-ic"><i class="fa-solid fa-spinner"></i></div>
        <div class="sc-num">{{ $stats['in_production'] ?? 0 }}</div>
        <div class="sc-label">In Production</div>
        <div class="sc-sub s-w"><i class="fa-solid fa-circle"></i> Sedang berjalan</div>
      </div>
      <div class="sc sc-v" style="--i:2">
        <div class="sc-ic"><i class="fa-solid fa-magnifying-glass"></i></div>
        <div class="sc-num">{{ $stats['under_review'] ?? 0 }}</div>
        <div class="sc-label">Under Review</div>
        <div class="sc-sub s-b"><i class="fa-solid fa-check-circle"></i> Sedang direview</div>
      </div>
      <div class="sc sc-r" style="--i:3">
        <div class="sc-ic"><i class="fa-solid fa-exclamation-triangle"></i></div>
        <div class="sc-num">{{ $stats['need_revision'] ?? 0 }}</div>
        <div class="sc-label">Need Revision</div>
        <div class="sc-sub s-r"><i class="fa-solid fa-times-circle"></i> Perlu revisi</div>
      </div>
      <div class="sc sc-g" style="--i:4">
        <div class="sc-ic"><i class="fa-solid fa-check-double"></i></div>
        <div class="sc-num">{{ $stats['published'] ?? 0 }}</div>
        <div class="sc-label">Published</div>
        <div class="sc-sub s-g"><i class="fa-solid fa-check-circle"></i> Sudah publish</div>
      </div>
    </div>

    <!-- TOOLBAR -->
    <div class="toolbar">
      <div class="srch-wrap">
        <i class="fa-solid fa-magnifying-glass"></i>
        <input class="srch" id="srchInput" type="text" placeholder="Cari judul atau brand..." oninput="applyFilter()"/>
      </div>
      <select class="fsel" id="fltStatus" onchange="applyFilter()">
        <option value="">Semua Status</option>
        <option value="In Production">In Production</option>
        <option value="Under Review">Under Review</option>
        <option value="Need Revision">Need Revision</option>
        <option value="Ready to Publish">Ready to Publish</option>
        <option value="Published">Published</option>
      </select>
      <select class="fsel" id="fltPlatform" onchange="applyFilter()">
        <option value="">Semua Platform</option>
        <option value="Instagram">Instagram</option>
        <option value="TikTok">TikTok</option>
        <option value="YouTube">YouTube</option>
      </select>
      <select class="fsel" id="fltBrand" onchange="applyFilter()">
        <option value="">Semua Brand</option>
        @if(isset($brands) && $brands->count() > 0)
          @foreach($brands as $brand)
            <option value="{{ $brand->id }}">{{ $brand->name }}</option>
          @endforeach
        @endif
      </select>
      <div class="sp"></div>
      <a href="{{ route('content-tasks.export-pdf') }}" class="btn btn-ghost btn-sm" style="text-decoration:none;color:inherit;display:inline-flex;align-items:center;gap:6px;">
        <i class="fa-solid fa-file-pdf"></i> Export PDF
      </a>
    </div>

    <!-- TABLE CARD -->
    <div class="tcard">
      <div class="tcard-head">
        <div class="tch-l">
          <span class="tch-title">Daftar Tugas Konten</span>
          <span class="tch-cnt" id="tblCount">{{ $contentBriefs->count() }} tugas</span>
        </div>
      </div>
      <div class="tcard-body">
        <table class="ktable">
          <thead>
            <tr>
              <th>Judul Konten</th>
              <th>Brand</th>
              <th>Platform</th>
              <th>Deadline Produksi</th>
              <th>Status</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody id="tblBody">
            @if(isset($contentBriefs) && $contentBriefs->count() > 0)
              @foreach($contentBriefs as $brief)
                <tr>
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
                      <i class="fa-brands {{ $brief->platform === 'Instagram' ? 'fa-instagram' : ($brief->platform === 'TikTok' ? 'fa-tiktok' : 'fa-youtube') }} {{ $brief->platform === 'Instagram' ? 'plat-ig' : ($brief->platform === 'TikTok' ? 'plat-tt' : 'plat-yt') }}"></i>
                      <span>{{ $brief->platform }}</span>
                    </div>
                  </td>
                  <td>
                    <div class="deadline-info">
                      <div class="prod-deadline">{{ $brief->production_deadline ? \Carbon\Carbon::parse($brief->production_deadline)->format('d M Y') : '-' }}</div>
                    </div>
                  </td>
                  <td>
                    <span class="status {{ $brief->status === 'In Production' ? 'p-prod' : ($brief->status === 'Under Review' ? 'p-review' : ($brief->status === 'Need Revision' ? 'p-revision' : ($brief->status === 'Published' ? 'p-pub' : 'p-review'))) }}">{{ $brief->status }}</span>
                  </td>
                  <td>
                    <div class="actions">
                      <button class="btn-action" onclick="openDetail({{ $brief->id }})" title="Detail">
                        <i class="fa-solid fa-eye"></i>
                      </button>
                      <button class="btn-action" onclick="openEdit({{ $brief->id }})" title="Edit">
                        <i class="fa-solid fa-edit"></i>
                      </button>
                      <button class="btn-action btn-delete" onclick="openDel({{ $brief->id }})" title="Delete">
                        <i class="fa-solid fa-trash"></i>
                      </button>
                    </div>
                  </td>
                </tr>
              @endforeach
            @else
              <tr>
                <td colspan="6" style="text-align: center; padding: 40px; color: var(--text-400);">
                  <i class="fa-solid fa-search"></i> Tidak ada tugas ditemukan
                </td>
              </tr>
            @endif
          </tbody>
        </table>
      </div>
      <div class="pagi" id="pagiBar">
        <div class="pagi-info">Menampilkan <b id="pgFrom">{{ isset($contentBriefs) && $contentBriefs->count() > 0 ? '1' : '0' }}</b>–<b id="pgTo">{{ $contentBriefs->count() }}</b> dari <b id="pgTotal">{{ $contentBriefs->count() }}</b> tugas</div>
        <div class="pagi-btns" id="pgBtns"></div>
      </div>
    </div>

  </div><!-- /body -->
</div><!-- /main -->
</div><!-- /shell -->

<!-- ═══════════════════════════════════════════
     MODAL — CREATE/EDIT BRIEF (7-Step Wizard)
═══════════════════════════════════════════ -->
<div class="overlay" id="ovWizard" onclick="bgClose(event,'ovWizard')">
<div class="modal wiz-modal" onclick="event.stopPropagation()">

  <!-- Progress Bar -->
  <div class="wiz-prog" id="wizProg"></div>

  <!-- Header -->
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

    <!-- STEP 1: Deskripsi Tugas -->
    <div class="spanel show" id="sp1">
      <div class="shd">
        <div class="shd-bar"></div>
        <div>
          <div class="shd-title">Deskripsi Tugas</div>
          <div class="shd-sub">Gambaran umum tugas konten yang harus dibuat oleh creator</div>
        </div>
      </div>
      <div class="fg">
        <label class="flbl">Deskripsi Tugas Konten <span class="req">*</span></label>
        <textarea class="ftxt" id="fDesc" rows="7" placeholder="Contoh: Membuat konten video edukasi skincare singkat berdurasi 30–60 detik untuk platform TikTok. Fokus pada manfaat serum Vitamin C brand GlowSkin. Tone komunikasi friendly dan relatable untuk audiens usia 18–30 tahun yang aktif di media sosial..."></textarea>
        <div class="char-cnt" id="ccDesc">0 / 500 karakter</div>
        <div class="ferr" id="eDesc">Deskripsi tugas wajib diisi.</div>
      </div>
    </div>

    <!-- STEP 2: Informasi Dasar -->
    <div class="spanel" id="sp2">
      <div class="shd">
        <div class="shd-bar"></div>
        <div>
          <div class="shd-title">Informasi Dasar</div>
          <div class="shd-sub">Detail teknis konten yang akan diproduksi</div>
        </div>
      </div>
      <div class="fg">
        <label class="flbl">Judul Konten <span class="req">*</span></label>
        <div class="ico-wrap"><i class="fa-solid fa-heading"></i>
          <input class="finp" id="fTitle" type="text" placeholder="Judul yang deskriptif dan mudah diidentifikasi..."/>
        </div>
        <div class="ferr" id="eTitle">Judul konten wajib diisi.</div>
      </div>
      <div class="fg3">
        <div class="fg">
          <label class="flbl">Brand <span class="req">*</span></label>
          @if(isset($brands) && $brands->count() > 0)
            <select class="fsel-f" id="fBrand">
              <option value="">Pilih brand...</option>
              @foreach($brands as $brand)
                <option value="{{ $brand->id }}" data-name="{{ $brand->name }}" data-pic="{{ $brand->pic }}">{{ $brand->name }} - {{ $brand->pic }}</option>
              @endforeach
            </select>
          @else
            <select class="fsel-f" id="fBrand" disabled>
              <option value="">Tidak ada brand aktif</option>
            </select>
            <div style="margin-top: 8px; padding: 8px 12px; background: rgba(245,158,11,.1); border-left: 3px solid var(--amber); border-radius: 6px; font-size: 12px; color: #92400e;">
              <i class="fa-solid fa-exclamation-triangle" style="margin-right: 6px;"></i>
              Tidak ada brand aktif. Silakan buat brand baru atau aktifkan brand yang sudah ada di Brand Management.
            </div>
          @endif
          <div class="ferr" id="eBrand">Brand wajib dipilih.</div>
        </div>
        <div class="fg">
          <label class="flbl">Platform <span class="req">*</span></label>
          <select class="fsel-f" id="fPlatform" onchange="updateFormatOptions()">
            <option value="">Pilih platform...</option>
            <option value="Instagram">Instagram</option>
            <option value="TikTok">TikTok</option>
            <option value="YouTube">YouTube</option>
            <option value="Lainnya">Platform Lain</option>
          </select>
          <div class="ferr" id="ePlatform">Platform wajib dipilih.</div>
        </div>
        <div class="fg">
          <label class="flbl">Format Konten <span class="req">*</span></label>
          <select class="fsel-f" id="fFormat">
            <option value="">Pilih platform terlebih dahulu...</option>
          </select>
          <div class="ferr" id="eFormat">Format konten wajib dipilih.</div>
        </div>
        <div class="fg">
          <label class="flbl">Durasi Target <span class="req">*</span></label>
          <div class="ico-wrap"><i class="fa-solid fa-stopwatch"></i>
            <input class="finp" id="fDuration" type="text" placeholder="Contoh: 30–60 detik"/>
          </div>
          <div class="ferr" id="eDuration">Durasi target wajib diisi.</div>
        </div>
        <div class="fg">
          <label class="flbl">Deadline Produksi <span class="req">*</span></label>
          <input class="finp" id="fDeadProd" type="date"/>
          <div class="ferr" id="eDeadProd">Deadline produksi wajib diisi.</div>
        </div>
        <div class="fg">
          <label class="flbl">Deadline Publish <span class="req">*</span></label>
          <input class="finp" id="fDeadPub" type="date"/>
          <div class="ferr" id="eDeadPub">Deadline publish wajib diisi.</div>
        </div>
      </div>
    </div>

    <!-- STEP 3: Strategi Konten -->
    <div class="spanel" id="sp3">
      <div class="shd">
        <div class="shd-bar"></div>
        <div>
          <div class="shd-title">Strategi Konten</div>
          <div class="shd-sub">Tujuan, audiens, dan pesan utama konten</div>
        </div>
      </div>
      <div class="fg">
        <label class="flbl">Objective <span class="req">*</span></label>
        <select class="fsel-f" id="fObjective">
          <option value="">Pilih objective...</option>
          <option>Brand Awareness</option><option>Product Education</option>
          <option>Sales Conversion</option><option>Community Engagement</option>
          <option>Lead Generation</option><option>Brand Loyalty</option><option>Event Promotion</option>
        </select>
        <div class="ferr" id="eObjective">Objective wajib dipilih.</div>
      </div>
      <div class="fg">
        <label class="flbl">Target Audience <span class="req">*</span></label>
        <textarea class="ftxt" id="fAudience" rows="3" placeholder="Contoh: Wanita usia 18–30 tahun, tertarik skincare, aktif di media sosial, mencari produk yang terjangkau..."></textarea>
        <div class="ferr" id="eAudience">Target audience wajib diisi.</div>
      </div>
      <div class="fg">
        <label class="flbl">Key Message <span class="req">*</span> <span class="hint-lbl">— Satu kalimat inti yang ingin penonton ingat</span></label>
        <textarea class="ftxt" id="fKeyMsg" rows="3" placeholder="Contoh: Serum Vitamin C GlowSkin membantu meratakan warna kulit dan memberikan efek glowing dalam 7 hari pemakaian rutin..."></textarea>
        <div class="ferr" id="eKeyMsg">Key message wajib diisi.</div>
      </div>
    </div>

    <!-- STEP 4: Creative Direction -->
    <div class="spanel" id="sp4">
      <div class="shd">
        <div class="shd-bar"></div>
        <div>
          <div class="shd-title">Creative Direction</div>
          <div class="shd-sub">Panduan kreatif untuk eksekusi konten</div>
        </div>
      </div>
      <div class="fg">
        <label class="flbl">Hook <span class="req">*</span> <span class="hint-lbl">— Kalimat/visual pembuka yang langsung menarik perhatian</span></label>
        <div class="ico-wrap"><i class="fa-solid fa-bolt"></i>
          <input class="finp" id="fHook" type="text" placeholder='Contoh: "POV: akhirnya nemu serum yang beneran works dalam seminggu!"'/>
        </div>
        <div class="ferr" id="eHook">Hook wajib diisi.</div>
      </div>
      <div class="fg">
        <label class="flbl">Storyline <span class="req">*</span></label>
        <textarea class="ftxt" id="fStory" rows="4" placeholder="Ceritakan alur konten secara kronologis. Contoh: Buka dengan hook → tampilkan before state → demo pemakaian produk → reveal hasil → CTA..."></textarea>
        <div class="ferr" id="eStory">Storyline wajib diisi.</div>
      </div>
      <div class="fg">
        <label class="flbl">Visual Direction <span class="req">*</span> <span class="hint-lbl">— Panduan warna, suasana, angle, dan estetika visual</span></label>
        <textarea class="ftxt" id="fVisual" rows="3" placeholder="Contoh: Tone warna soft pastel dengan aksen mint, pencahayaan natural dari jendela, background clean putih/krem, close-up product..."></textarea>
        <div class="ferr" id="eVisual">Visual direction wajib diisi.</div>
      </div>
    </div>

    <!-- STEP 5: Copywriting -->
    <div class="spanel" id="sp5">
      <div class="shd">
        <div class="shd-bar"></div>
        <div>
          <div class="shd-title">Copywriting</div>
          <div class="shd-sub">Teks caption, ajakan bertindak, dan hashtag</div>
        </div>
      </div>
      <div class="fg">
        <label class="flbl">Caption <span class="req">*</span></label>
        <textarea class="ftxt" id="fCaption" rows="5" placeholder="Tulis caption lengkap untuk postingan ini. Gunakan emoji dan tone sesuai brand..."></textarea>
        <div class="char-cnt" id="ccCaption">0 / 2200 karakter</div>
        <div class="ferr" id="eCaption">Caption wajib diisi.</div>
      </div>
      <div class="fg2">
        <div class="fg">
          <label class="flbl">CTA (Call to Action) <span class="req">*</span></label>
          <div class="ico-wrap"><i class="fa-solid fa-bullseye"></i>
            <input class="finp" id="fCta" type="text" placeholder="Contoh: Kunjungi link di bio!"/>
          </div>
          <div class="ferr" id="eCta">CTA wajib diisi.</div>
        </div>
        <div class="fg">
          <label class="flbl">Hashtag <span class="req">*</span></label>
          <div class="ico-wrap"><i class="fa-solid fa-hashtag"></i>
            <input class="finp" id="fHashtag" type="text" placeholder="#skincare #glowskin #review"/>
          </div>
          <div class="ferr" id="eHashtag">Hashtag wajib diisi.</div>
        </div>
      </div>
    </div>

    <!-- STEP 6: KPI Target -->
    <div class="spanel" id="sp6">
      <div class="shd">
        <div class="shd-bar"></div>
        <div>
          <div class="shd-title">KPI Target</div>
          <div class="shd-sub">Ukuran keberhasilan yang ingin dicapai konten ini</div>
        </div>
      </div>
      <div class="fg2">
        <div class="fg">
          <label class="flbl">Target Views <span class="req">*</span></label>
          <div class="unit-wrap">
            <input class="finp" id="fViews" type="number" min="0" placeholder="50000"/>
            <span class="unit">views</span>
          </div>
          <div class="ferr" id="eViews">Target views wajib diisi.</div>
        </div>
        <div class="fg">
          <label class="flbl">Target Engagement Rate <span class="req">*</span></label>
          <div class="unit-wrap">
            <input class="finp" id="fEngage" type="number" min="0" max="100" step="0.1" placeholder="5.0"/>
            <span class="unit">%</span>
          </div>
          <div class="ferr" id="eEngage">Target engagement wajib diisi.</div>
        </div>
      </div>
      <div class="info-box">
        <div class="info-box-ttl"><i class="fa-solid fa-circle-info"></i> Benchmark KPI Per Platform</div>
        <div class="info-box-txt">
          <b>Instagram Reels</b>: Engagement rata-rata 3–5%, views tergantung jumlah followers.<br/>
          <b>TikTok</b>: Engagement rata-rata 5–9%, potensi viral lebih tinggi untuk akun baru.<br/>
          <b>YouTube</b>: Engagement rata-rata 2–4%, watch time dan retention menjadi metrik utama.
        </div>
      </div>
    </div>

    <!-- STEP 7: Assign Creator -->
    <div class="spanel" id="sp7">
      <div class="shd">
        <div class="shd-bar"></div>
        <div>
          <div class="shd-title">Assign Creator</div>
          <div class="shd-sub">Tentukan siapa yang mengerjakan produksi konten ini</div>
        </div>
      </div>
      <div class="assign-box">
        <div style="width:42px;height:42px;border-radius:12px;background:var(--blue-50);display:flex;align-items:center;justify-content:center;font-size:17px;color:var(--blue);margin-bottom:10px">
          <i class="fa-solid fa-user-pen"></i>
        </div>
        <div style="font-size:13.5px;font-weight:700;color:var(--t9);margin-bottom:4px">Kirim Brief ke Content Creator</div>
        <div style="font-size:12px;color:var(--t4);margin-bottom:14px;line-height:1.5">Isi email creator untuk mengirimkan link brief unik. Kosongkan jika admin yang mengerjakan sendiri.</div>
        <div class="fg">
          <label class="flbl">Email Content Creator <span class="hint-lbl">— Opsional</span></label>
          <div class="ico-wrap"><i class="fa-solid fa-envelope"></i>
            <input class="finp" id="fCreator" type="email" placeholder="creator@email.com (kosongkan = admin kerjakan sendiri)"/>
          </div>
          <div style="font-size:11px;color:var(--t4);margin-top:8px;line-height:1.45;">
            Jika diisi, sistem akan <strong>mengirim email otomatis</strong> ke alamat ini saat kamu menekan <strong>Simpan Brief</strong> (tanpa tombol tambahan).
          </div>
        </div>
        <div class="assign-hint">
          <i class="fa-solid fa-circle-info"></i>
          Setelah disimpan, sistem akan mengirim email berisi link brief unik ke creator. Creator dapat mengakses form, mengisi ide tambahan, dan mengupload video tanpa perlu login ke sistem.
        </div>
      </div>
      <div class="summary-card">
        <div class="summary-ttl"><i class="fa-solid fa-file-lines" style="color:var(--blue)"></i> Ringkasan Brief</div>
        <div id="wizSummary"></div>
      </div>
    </div>

  </div><!-- /mbody -->

  <div class="mfoot">
    <div class="mfoot-info">Langkah <b id="wizCurr">1</b> dari <b>7</b></div>
    <div class="mfoot-btns">
      <button class="btn btn-ghost" id="btnPrev" onclick="wizPrev()" style="display:none">
        <i class="fa-solid fa-arrow-left"></i> Kembali
      </button>
      <button class="btn btn-ghost" onclick="closeModal('ovWizard')">Batal</button>
      <button class="btn btn-primary" id="btnNext" onclick="wizNext()">
        Selanjutnya <i class="fa-solid fa-arrow-right"></i>
      </button>
    </div>
  </div>

</div>
</div>

<!-- ═══════════════════════════════════════════
     MODAL — DETAIL KONTEN
═══════════════════════════════════════════ -->
<div class="overlay" id="ovDetail" onclick="bgClose(event,'ovDetail')">
<div class="modal det-modal" onclick="event.stopPropagation()">

  <div class="mhd" style="padding:24px 28px 0">
    <div></div>
    <button class="mclose" onclick="closeModal('ovDetail')"><i class="fa-solid fa-xmark"></i></button>
  </div>

  <div class="det-hero" id="detHero"></div>

  <!-- Workflow Bar -->
  <div class="wf-bar" id="wfBar"></div>

  <div class="det-body">
    <div class="det-tabs" id="detTabs"></div>
    <div id="detPanels"></div>
  </div>

  <div class="mfoot">
    <div></div>
    <div class="mfoot-btns">
      <button class="btn btn-ghost" onclick="closeModal('ovDetail')">Tutup</button>
      <button class="btn btn-primary" id="detEditBtn">
        <i class="fa-solid fa-pen"></i> Edit Brief
      </button>
    </div>
  </div>

</div>
</div>

<!-- ═══════════════════════════════════════════
     MODAL — DELETE CONFIRM
═══════════════════════════════════════════ -->
<div class="overlay" id="ovDel" onclick="bgClose(event,'ovDel')">
<div class="modal del-modal" onclick="event.stopPropagation()">
  <div class="mbody" style="text-align:center;padding:32px 28px 8px">
    <div class="del-ic-wrap"><i class="fa-solid fa-trash-can"></i></div>
    <div style="font-size:18px;font-weight:800;color:var(--t9);margin-bottom:8px">Hapus Tugas Konten?</div>
    <div id="delMsg" style="font-size:13.5px;color:var(--t5);line-height:1.6"></div>
  </div>
  <div class="mfoot" style="justify-content:center;padding-top:8px">
    <button class="btn btn-ghost" style="min-width:100px" onclick="closeModal('ovDel')">Batal</button>
    <button class="btn btn-danger" style="min-width:110px" id="delConfirmBtn">
      <i class="fa-solid fa-trash-can"></i> Ya, Hapus
    </button>
  </div>
</div>
</div>

<!-- TOAST CONTAINER -->
<div class="toast-wrap" id="toastWrap"></div>

<!-- ═══════════════════════════════════════════
     JAVASCRIPT
═══════════════════════════════════════════ -->
<script>
/* ══════════════════════════════════════
   DATA
══════════════════════════════════════ */
const COLORS = ['#5897fe','#10b981','#f59e0b','#8b5cf6','#f43f5e','#06b6d4','#ff7849','#3b82f6','#ec4899'];
const PLAT_ICON = { Instagram:'fa-instagram', TikTok:'fa-tiktok', YouTube:'fa-youtube' };
const PLAT_CLS  = { Instagram:'plat-ig', TikTok:'plat-tt', YouTube:'plat-yt' };
const STATUS_CLS = {
  'In Production':'p-prod','Under Review':'p-review',
  'Need Revision':'p-revision','Ready to Publish':'p-ready','Published':'p-pub'
};
const STEP_NAMES = ['Deskripsi Tugas','Informasi Dasar','Strategi Konten','Creative Direction','Copywriting','KPI Target','Assign Creator'];
const WF_STEPS  = ['Brief Dibuat','In Production','Under Review','Need Revision','Ready to Publish','Published'];
const STATUS_IDX = {'In Production':1,'Under Review':2,'Need Revision':3,'Ready to Publish':4,'Published':5};

// Initial database data for client-side features (filter, pagination, detail modal).
// Keep schema aligned with openDetail()/prefillForm().
let db = {!! $contentBriefs->map(function ($brief) {
  $brand = $brief->brand;
  return [
    'id' => $brief->id,
    'title' => $brief->title,
    'description' => $brief->description,
    'platform' => $brief->platform,
    'production_deadline' => $brief->production_deadline ? $brief->production_deadline->format('Y-m-d') : null,
    'status' => $brief->status,
    'brand' => $brief->brand_id,
    'brand_name' => $brand ? $brand->name : null,
    'brand_pic' => $brand ? $brand->pic : null,
    'format' => $brief->content_format,
    'duration' => $brief->target_duration,
    'deadProd' => $brief->production_deadline ? $brief->production_deadline->format('Y-m-d') : null,
    'deadPub' => $brief->publish_deadline ? $brief->publish_deadline->format('Y-m-d') : null,
    'objective' => $brief->objective,
    'audience' => $brief->target_audience,
    'keyMsg' => $brief->key_message,
    'hook' => $brief->hook,
    'story' => $brief->storyline,
    'visual' => $brief->visual_direction,
    'caption' => $brief->caption,
    'cta' => $brief->cta,
    'hashtag' => $brief->hashtags,
    'views' => $brief->target_views !== null ? (int) $brief->target_views : 0,
    'engage' => $brief->target_engagement !== null ? (float) $brief->target_engagement : 0,
    'creator' => $brief->creator_email ?: null,
  ];
})->values()->toJson() !!};
let nextId  = 1;
let filtered = [];
let page     = 1;
const PER    = Number.MAX_SAFE_INTEGER;
let delId    = null;
let editId   = null;
let curStep  = 1;
const NSTEPS = 7;

/* ══════════════════════════════════════
   HELPERS
══════════════════════════════════════ */
const col    = id => COLORS[(id - 1) % COLORS.length];
const fmtDate = d => { if (!d) return '—'; const dt = new Date(d + 'T00:00:00'); return dt.toLocaleDateString('id-ID',{day:'2-digit',month:'short',year:'numeric'}); };
const dlCls  = d => { if (!d) return 'dl-ok'; const diff = (new Date(d) - new Date()) / 86400000; return diff < 0 ? 'dl-hot' : diff < 4 ? 'dl-hot' : diff < 7 ? 'dl-w' : 'dl-ok'; };

function pill(s) {
  const c = STATUS_CLS[s] || '';
  return `<span class="pill ${c}"><span class="pdot"></span>${s}</span>`;
}
function platChip(p) {
  const ic  = PLAT_ICON[p] || 'fa-globe';
  const cls = PLAT_CLS[p]  || '';
  return `<span class="plat ${cls}"><i class="fa-brands ${ic}"></i> ${p}</span>`;
}

/* ══════════════════════════════════════
   INIT
══════════════════════════════════════ */
document.addEventListener('DOMContentLoaded', () => {
  buildWizProg();
  renderStats();
  filtered = [...db];
  renderTable();

  // Char counters
  addCharCounter('fDesc',    'ccDesc',    500);
  addCharCounter('fCaption', 'ccCaption', 2200);

  // Today date
  const d = new Date();
  document.getElementById('today-date').textContent =
    d.toLocaleDateString('id-ID', { weekday:'long', day:'numeric', month:'long', year:'numeric' });

  // Sidebar active link - REMOVED to allow navigation

  // Keyboard shortcuts
  document.addEventListener('keydown', e => {
    if (e.key === 'Escape') {
      ['ovWizard','ovDetail','ovDel'].forEach(id => {
        if (document.getElementById(id).classList.contains('open')) closeModal(id);
      });
    }
    if ((e.metaKey || e.ctrlKey) && e.key === 'k') {
      e.preventDefault();
      document.getElementById('srchInput').focus();
    }
    if ((e.metaKey || e.ctrlKey) && e.key === 'n') {
      if (!document.getElementById('ovWizard').classList.contains('open')) {
        e.preventDefault(); openCreate();
      }
    }
  });

  // Clear err on input
  document.addEventListener('input', e => {
    if (e.target.matches('.finp,.ftxt,.fsel-f')) e.target.classList.remove('err');
  });
});

/* ══════════════════════════════════════
   STATS
══════════════════════════════════════ */
function renderStats() {
  const counts = {
    total:    db.length,
    prod:     db.filter(k => k.status === 'In Production').length,
    review:   db.filter(k => k.status === 'Under Review').length,
    revision: db.filter(k => k.status === 'Need Revision').length,
    pub:      db.filter(k => k.status === 'Published').length,
  };
  Object.entries(counts).forEach(([key, val]) => {
    animateNum(document.getElementById('sc-' + key), val);
  });
}
function animateNum(el, target) {
  if (!el) return;
  let n = 0;
  const step = () => { n = Math.min(n + Math.ceil(target / 22), target); el.textContent = n; if (n < target) requestAnimationFrame(step); };
  setTimeout(step, 300);
}

/* ══════════════════════════════════════
   FILTER + RENDER TABLE (AJAX Real-Time)
══════════════════════════════════════ */
function applyFilter() {
  const q  = document.getElementById('srchInput').value.trim().toLowerCase();
  const st = document.getElementById('fltStatus').value;
  const pl = document.getElementById('fltPlatform').value;
  const br = document.getElementById('fltBrand').value;
  
  // DEBUG: Log filter values
  console.log('🔍 Filter Applied:', { search: q, status: st, platform: pl, brand: br });
  
  // Get CSRF token
  const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
  
  // DEBUG: Check CSRF token
  console.log('🔐 CSRF Token Check:', {
    metaTag: !!document.querySelector('meta[name="csrf-token"]'),
    tokenValue: csrfToken ? csrfToken.substring(0, 20) + '...' : 'NOT FOUND',
    tokenLength: csrfToken ? csrfToken.length : 0
  });
  
  if (!csrfToken) {
    console.error('❌ CSRF token not found');
    alert('CSRF token not found! Please refresh the page.');
    return;
  }
  
  // Show loading state
  const tableBody = document.querySelector('#tblBody');
  if (tableBody) {
    tableBody.innerHTML = '<tr><td colspan="6" style="text-align: center; padding: 40px;"><i class="fa-solid fa-circle-notch spin"></i> Mencari data...</td></tr>';
  }
  
  // DEBUG: Log request details
  const requestData = {
    search: q,
    status: st,
    platform: pl,
    brand: br
  };
  console.log('📤 Request Data:', requestData);
  console.log('🌐 Fetch URL:', '/content-briefs/search');
  console.log('🔐 Request Headers:', {
    'Content-Type': 'application/json',
    'X-CSRF-TOKEN': csrfToken ? 'PRESENT' : 'MISSING',
    'Accept': 'application/json'
  });
  
  // Send AJAX request to server for real-time filtering
  fetch('/content-briefs/search', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': csrfToken,
      'Accept': 'application/json'
    },
    body: JSON.stringify(requestData)
  })
  .then(response => {
    console.log('📥 Response Status:', response.status);
    console.log('📥 Response Headers:', response.headers);
    
    if (!response.ok) {
      console.error('❌ Response not OK:', response.status, response.statusText);
      throw new Error(`HTTP ${response.status}: ${response.statusText}`);
    }
    return response.json();
  })
  .then(data => {
    console.log('📊 Response Data:', data);
    if (data.success) {
      // Update table with filtered data
      renderTableFromDatabase(data.data);
      
      // Update statistics
      updateStats(data.stats);
      
      console.log('✅ Filter applied:', { search: q, status: st, platform: pl, brand: br, results: data.data.length });
    } else {
      console.error('❌ Server returned success:false:', data.message);
      throw new Error(data.message || 'Server returned error');
    }
  })
  .catch(error => {
    console.error('❌ Filter error:', error);
    console.error('❌ Error stack:', error.stack);
    
    // Show error state
    const tableBody = document.querySelector('#tblBody');
    if (tableBody) {
      tableBody.innerHTML = '<tr><td colspan="6" style="text-align: center; padding: 40px; color: var(--rose);"><i class="fa-solid fa-triangle-exclamation"></i> Gagal memfilter data. Silakan coba lagi.<br><small>Detail: ' + error.message + '</small></td></tr>';
    }
  });
}

// Render table from database data
function renderTableFromDatabase(contentBriefs) {
  const tableBody = document.querySelector('#tblBody');
  if (!tableBody) return;
  
  if (contentBriefs.length === 0) {
    tableBody.innerHTML = '<tr><td colspan="6" style="text-align: center; padding: 40px; color: var(--text-400);"><i class="fa-solid fa-search"></i> Data tidak ditemukan</td></tr>';
    return;
  }
  
  const rows = contentBriefs.map(brief => {
    const platIcon = PLAT_ICON[brief.platform] || 'fa-globe';
    const platCls = PLAT_CLS[brief.platform] || 'plat-other';
    const statusCls = STATUS_CLS[brief.status] || 'p-review';
    
    return `
      <tr>
        <td>
          <div class="task-title">${brief.title}</div>
          <div class="task-desc">${brief.description ? (brief.description.length > 50 ? brief.description.substring(0, 50) + '...' : brief.description) : '-'}</div>
        </td>
        <td>
          <div class="brand-info">
            <div class="brand-name">${brief.brand_name || brief.brand?.name || '-'}</div>
            <div class="brand-pic">${brief.brand_pic || brief.brand?.pic || '-'}</div>
          </div>
        </td>
        <td>
          <div class="platform-info">
            <i class="fa-brands ${platIcon} ${platCls}"></i>
            <span>${brief.platform}</span>
          </div>
        </td>
        <td>
          <div class="deadline-info">
            <div class="prod-deadline">${brief.production_deadline ? formatDate(brief.production_deadline) : '-'}</div>
          </div>
        </td>
        <td>
          <span class="status ${statusCls}">${brief.status}</span>
        </td>
        <td>
          <div class="actions">
            <button class="btn-action" onclick="openDetail(${brief.id})" title="Detail">
              <i class="fa-solid fa-eye"></i>
            </button>
            <button class="btn-action" onclick="openEdit(${brief.id})" title="Edit">
              <i class="fa-solid fa-edit"></i>
            </button>
            <button class="btn-action btn-delete" onclick="openDel(${brief.id})" title="Delete">
              <i class="fa-solid fa-trash"></i>
            </button>
          </div>
        </td>
      </tr>
    `;
  }).join('');
  
  tableBody.innerHTML = rows;
}

// Update statistics
function updateStats(stats) {
  // Update header count
  const headerCount = document.getElementById('tblCount');
  if (headerCount) {
    headerCount.textContent = stats.total + ' tugas';
  }
  
  // Update statistics cards
  document.querySelector('.sc-b .sc-num').textContent = stats.total || 0;
  document.querySelector('.sc-o .sc-num').textContent = stats.in_production || 0;
  document.querySelector('.sc-v .sc-num').textContent = stats.under_review || 0;
  document.querySelector('.sc-r .sc-num').textContent = stats.need_revision || 0;
  document.querySelector('.sc-g .sc-num').textContent = stats.published || 0;
}

// Format date helper
function formatDate(dateString) {
  const date = new Date(dateString);
  return date.toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' });
}

function mk(html, disabled, on, onClick) {
  const b = document.createElement('button');
  b.className = 'pb';
  b.innerHTML = html;
  if (on) b.classList.add('on');
  if (disabled) b.disabled = true;
  if (!disabled && typeof onClick === 'function') b.addEventListener('click', onClick);
  return b;
}

function renderTable() {
  const total = filtered.length;
  const rows = total > 0 ? filtered : [];
  renderTableFromDatabase(rows);

  const pgFrom = document.getElementById('pgFrom');
  const pgTo = document.getElementById('pgTo');
  const pgTotal = document.getElementById('pgTotal');
  if (pgFrom) pgFrom.textContent = total > 0 ? '1' : '0';
  if (pgTo) pgTo.textContent = String(total);
  if (pgTotal) pgTotal.textContent = String(total);

  const cont = document.getElementById('pgBtns');
  if (cont) cont.innerHTML = '';
}

/* ══════════════════════════════════════
   DETAIL MODAL
══════════════════════════════════════ */
function openDetail(id) {
  const k = db.find(x => x.id === id);
  if (!k) return;

  // Hero
  document.getElementById('detHero').innerHTML = `
    <div class="det-ic" style="background:${col(k.id)}">
      <i class="fa-brands ${PLAT_ICON[k.platform] || 'fa-globe'}"></i>
    </div>
    <div style="flex:1;min-width:0">
      <div class="det-title">${k.title}</div>
      <div class="det-meta">
        <span class="brand-tag"><i class="fa-solid fa-tag" style="font-size:9px"></i>${k.brand_name || k.brand || '-'}</span>
        ${platChip(k.platform)}
        ${pill(k.status)}
        ${k.creator
          ? `<span style="font-size:11.5px;color:var(--t4);display:flex;align-items:center;gap:4px"><i class="fa-solid fa-user-pen" style="color:var(--blue)"></i>${k.creator}</span>`
          : `<span style="font-size:11.5px;color:var(--amber);display:flex;align-items:center;gap:4px"><i class="fa-solid fa-user-shield"></i>Admin kerjakan sendiri</span>`}
      </div>
    </div>`;

  // Workflow bar
  const idx = STATUS_IDX[k.status] || 0;
  document.getElementById('wfBar').innerHTML = WF_STEPS.map((s, i) => `
    ${i > 0 ? '<div class="wf-arr"><i class="fa-solid fa-chevron-right"></i></div>' : ''}
    <div class="wf-step ${i < idx ? 'wf-done' : i === idx ? 'wf-active' : 'wf-pending'}">
      <div class="wf-dot"><i class="fa-solid ${i===0?'fa-file-pen':i===1?'fa-film':i===2?'fa-magnifying-glass':i===3?'fa-rotate-left':i===4?'fa-check':'fa-paper-plane'}" style="font-size:9px"></i></div>
      <div class="wf-lbl">${s}</div>
    </div>`).join('');

  // Tabs & Panels
  const tabs   = ['Brief Dasar','Strategi','Creative Direction','Copywriting & KPI'];
  const panels = [
    // Panel 0: Brief Dasar
    `<div class="drow">
      <div class="df"><div class="df-lbl">Format</div><div class="df-val">${k.format}</div></div>
      <div class="df"><div class="df-lbl">Durasi Target</div><div class="df-val">${k.duration}</div></div>
      <div class="df"><div class="df-lbl">Deadline Produksi</div><div class="df-val ${dlCls(k.deadProd)}">${fmtDate(k.deadProd)}</div></div>
      <div class="df"><div class="df-lbl">Deadline Publish</div><div class="df-val">${fmtDate(k.deadPub)}</div></div>
    </div>`,
    // Panel 1: Strategi
    `<div class="df"><div class="df-lbl">Objective</div><div class="df-val"><span class="df-tag">${k.objective}</span></div></div>
     <div class="df"><div class="df-lbl">Target Audience</div><div class="df-val dim">${k.audience}</div></div>
     <div class="df"><div class="df-lbl">Key Message</div><div class="df-val dim">${k.keyMsg}</div></div>`,
    // Panel 2: Creative Direction
    `<div class="df"><div class="df-lbl">Hook</div><div class="df-val italic">"${k.hook}"</div></div>
     <div class="df"><div class="df-lbl">Storyline</div><div class="df-val dim">${k.story}</div></div>
     <div class="df"><div class="df-lbl">Visual Direction</div><div class="df-val dim">${k.visual}</div></div>`,
    // Panel 3: Copywriting & KPI
    `<div class="df full"><div class="df-lbl">Caption</div><div class="df-val dim">${k.caption}</div></div>
     <div class="drow">
       <div class="df"><div class="df-lbl">CTA</div><div class="df-val">${k.cta}</div></div>
       <div class="df"><div class="df-lbl">Hashtag</div><div class="df-val accent">${k.hashtag}</div></div>
       <div class="df"><div class="df-lbl">Target Views</div><div class="df-val">${k.views.toLocaleString('id-ID')} views</div></div>
       <div class="df"><div class="df-lbl">Target Engagement</div><div class="df-val">${k.engage}%</div></div>
     </div>`,
  ];

  document.getElementById('detTabs').innerHTML = tabs.map((t, i) =>
    `<div class="dtab${i === 0 ? ' on' : ''}" onclick="switchDetTab(${i}, this)">${t}</div>`
  ).join('');

  document.getElementById('detPanels').innerHTML = panels.map((p, i) =>
    `<div class="dpanel${i === 0 ? ' show' : ''}">${p}</div>`
  ).join('');

  document.getElementById('detEditBtn').onclick = () => { closeModal('ovDetail'); openEdit(id); };
  openModal('ovDetail');
}

function switchDetTab(idx, el) {
  document.querySelectorAll('.dtab').forEach(t => t.classList.remove('on'));
  el.classList.add('on');
  document.querySelectorAll('.dpanel').forEach((p, i) => p.classList.toggle('show', i === idx));
}

/* ══════════════════════════════════════
   WIZARD — OPEN CREATE / EDIT
══════════════════════════════════════ */
function openCreate() {
  editId  = null;
  curStep = 1;
  resetForm();
  document.getElementById('wizEyebrow').textContent = 'Create Brief';
  document.getElementById('wizTitle').textContent   = 'Buat Tugas Konten Baru';
  updateWizUI();
  openModal('ovWizard');
}

function openEdit(id) {
  const k = db.find(x => x.id === id);
  if (!k) return;
  editId  = id;
  curStep = 1;
  resetForm();
  prefillForm(k);
  document.getElementById('wizEyebrow').textContent = 'Edit Brief';
  document.getElementById('wizTitle').textContent   = 'Edit Tugas Konten';
  updateWizUI();
  openModal('ovWizard');
}

function prefillForm(k) {
  set('fDesc',      k.description || '');
  set('fTitle',     k.title);
  setSel('fBrand',    k.brand);
  setSel('fPlatform', k.platform);
  setSel('fFormat',   k.format);
  set('fDuration',  k.duration);
  set('fDeadProd',  k.deadProd);
  set('fDeadPub',   k.deadPub);
  setSel('fObjective', k.objective);
  set('fAudience',  k.audience);
  set('fKeyMsg',    k.keyMsg);
  set('fHook',      k.hook);
  set('fStory',     k.story);
  set('fVisual',    k.visual);
  set('fCaption',   k.caption);
  set('fCta',       k.cta);
  set('fHashtag',   k.hashtag);
  set('fViews',     k.views);
  set('fEngage',    k.engage);
  set('fCreator',   k.creator);
  updateCharCounter('fDesc', 'ccDesc', 500);
  updateCharCounter('fCaption', 'ccCaption', 2200);
}

function resetForm() {
  const ids = ['fDesc','fTitle','fDuration','fDeadProd','fDeadPub','fAudience','fKeyMsg','fHook','fStory','fVisual','fCaption','fCta','fHashtag','fViews','fEngage','fCreator'];
  ids.forEach(id => { const el = document.getElementById(id); if (el) { el.value = ''; el.classList.remove('err'); } });
  ['fBrand','fPlatform','fFormat','fObjective'].forEach(id => { const el = document.getElementById(id); if (el) { el.value = ''; el.classList.remove('err'); } });
  document.querySelectorAll('.ferr').forEach(e => e.classList.remove('show'));
  updateCharCounter('fDesc', 'ccDesc', 500);
  updateCharCounter('fCaption', 'ccCaption', 2200);
}

const get    = id => (document.getElementById(id) || {}).value || '';
const set    = (id, v) => { const el = document.getElementById(id); if (el) el.value = v || ''; };
const setSel = (id, v) => { const el = document.getElementById(id); if (el) el.value = v || ''; };

/* ══════════════════════════════════════
   WIZARD — PROGRESS UI
══════════════════════════════════════ */
function buildWizProg() {
  const labels = ['Deskripsi','Info Dasar','Strategi','Creative','Copy','KPI','Assign'];
  document.getElementById('wizProg').innerHTML = labels.map((l, i) =>
    `<div class="wstep" id="ws${i+1}">
       <div class="wdot" id="wd${i+1}">${i+1}</div>
       <div class="wlbl">${l}</div>
     </div>`
  ).join('');
}

function updateWizUI() {
  for (let i = 1; i <= NSTEPS; i++) {
    const panel = document.getElementById('sp' + i);
    const ws    = document.getElementById('ws' + i);
    const wd    = document.getElementById('wd' + i);
    if (!panel || !ws || !wd) continue;
    panel.classList.toggle('show', i === curStep);
    ws.classList.remove('active', 'done');
    if (i < curStep)      { ws.classList.add('done');   wd.innerHTML = '<i class="fa-solid fa-check" style="font-size:10px"></i>'; }
    else if (i === curStep) { ws.classList.add('active'); wd.textContent = i; }
    else                  { wd.textContent = i; }
  }
  document.getElementById('wizStepNum').textContent  = curStep;
  document.getElementById('wizCurr').textContent     = curStep;
  document.getElementById('wizStepName').textContent = STEP_NAMES[curStep - 1];
  document.getElementById('btnPrev').style.display   = curStep > 1 ? '' : 'none';
  const btnNext = document.getElementById('btnNext');
  if (curStep === NSTEPS) {
    btnNext.innerHTML = '<i class="fa-solid fa-floppy-disk"></i> Simpan Brief';
    buildSummary();
  } else {
    btnNext.innerHTML = 'Selanjutnya <i class="fa-solid fa-arrow-right"></i>';
  }
}

function buildSummary() {
  const rows = [
    ['Judul Konten',     get('fTitle')    || '—'],
    ['Brand',            get('fBrand')    || '—'],
    ['Platform',         get('fPlatform') || '—'],
    ['Format',           get('fFormat')   || '—'],
    ['Deadline Produksi',fmtDate(get('fDeadProd'))],
    ['Deadline Publish', fmtDate(get('fDeadPub'))],
    ['Target Views',     (+get('fViews')||0).toLocaleString('id-ID') + ' views'],
    ['Target Engagement',(get('fEngage')||'0') + '%'],
    ['Creator',          get('fCreator') || 'Admin (kerjakan sendiri)'],
  ];
  document.getElementById('wizSummary').innerHTML = rows.map(([l,v]) =>
    `<div class="sumrow"><span>${l}</span><b>${v}</b></div>`
  ).join('');
}

/* ══════════════════════════════════════
   WIZARD — VALIDATORS
══════════════════════════════════════ */
function reqField(fId, eId, msg) {
  const el = document.getElementById(fId);
  const ok = el && el.value.trim();
  if (!ok) { el && el.classList.add('err'); showErr(eId, msg); }
  else     { el && el.classList.remove('err'); hideErr(eId); }
  return !!ok;
}
function reqSel(fId, eId, msg) {
  const el = document.getElementById(fId);
  const ok = el && el.value;
  if (!ok) showErr(eId, msg); else hideErr(eId);
  return !!ok;
}
const showErr = (id, msg) => { const e = document.getElementById(id); if (e) { e.textContent = msg; e.classList.add('show'); } };
const hideErr = id => { const e = document.getElementById(id); if (e) e.classList.remove('show'); };

const VALIDATORS = {
  1: () => reqField('fDesc','eDesc','Deskripsi tugas wajib diisi.'),
  2: () => [
    reqField('fTitle','eTitle','Judul konten wajib diisi.'),
    reqSel('fBrand','eBrand','Brand wajib dipilih.'),
    reqSel('fPlatform','ePlatform','Platform wajib dipilih.'),
    reqSel('fFormat','eFormat','Format konten wajib dipilih.'),
    reqField('fDuration','eDuration','Durasi target wajib diisi.'),
    reqField('fDeadProd','eDeadProd','Deadline produksi wajib diisi.'),
    reqField('fDeadPub','eDeadPub','Deadline publish wajib diisi.'),
  ].every(Boolean),
  3: () => [
    reqSel('fObjective','eObjective','Objective wajib dipilih.'),
    reqField('fAudience','eAudience','Target audience wajib diisi.'),
    reqField('fKeyMsg','eKeyMsg','Key message wajib diisi.'),
  ].every(Boolean),
  4: () => [
    reqField('fHook','eHook','Hook wajib diisi.'),
    reqField('fStory','eStory','Storyline wajib diisi.'),
    reqField('fVisual','eVisual','Visual direction wajib diisi.'),
  ].every(Boolean),
  5: () => [
    reqField('fCaption','eCaption','Caption wajib diisi.'),
    reqField('fCta','eCta','CTA wajib diisi.'),
    reqField('fHashtag','eHashtag','Hashtag wajib diisi.'),
  ].every(Boolean),
  6: () => [
    reqField('fViews','eViews','Target views wajib diisi.'),
    reqField('fEngage','eEngage','Target engagement wajib diisi.'),
  ].every(Boolean),
  7: () => true,
};

/* ══════════════════════════════════════
   WIZARD — NAVIGATION
══════════════════════════════════════ */
function wizNext() {
  if (!VALIDATORS[curStep]()) return;
  if (curStep < NSTEPS) { curStep++; updateWizUI(); return; }
  
  // SAVE TO DATABASE
  const btn = document.getElementById('btnNext');
  btn.disabled = true;
  btn.innerHTML = '<i class="fa-solid fa-circle-notch spin"></i> Menyimpan...';
  
  // Get form data - Mapping yang benar
  const formData = {
    // Informasi Dasar - Step 2
    title: get('fTitle').trim(),
    description: get('fDesc').trim(),
    brand_id: get('fBrand'), // Foreign key ke brands table
    platform: get('fPlatform'),
    content_format: get('fFormat'),
    target_duration: get('fDuration').trim(),
    production_deadline: get('fDeadProd'),
    publish_deadline: get('fDeadPub'),
    
    // Strategi Konten - Step 3
    objective: get('fObjective'),
    target_audience: get('fAudience').trim(),
    key_message: get('fKeyMsg').trim(),
    
    // Brief Kreatif - Step 4
    hook: get('fHook').trim(),
    storyline: get('fStory').trim(),
    visual_direction: get('fVisual').trim(),
    
    // Konten & Publishing - Step 5
    caption: get('fCaption').trim(),
    cta: get('fCta').trim(),
    hashtags: get('fHashtag').trim(),
    
    // Target KPI - Step 6
    target_views: get('fViews'),
    target_engagement: get('fEngage'),
    
    // Assign & Summary - Step 7
    creator_email: get('fCreator').trim() || null,
  };
  
  // Get CSRF token from meta tag
  const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
  
  if (!csrfToken) {
    toast('e', 'CSRF Token tidak ditemukan. Silakan refresh halaman.');
    btn.disabled = false;
    btn.innerHTML = '<i class="fa-solid fa-floppy-disk"></i> Simpan Brief';
    return;
  }
  
  // Send data to database via AJAX
  const url = editId ? `/content-briefs/${editId}` : '/content-briefs';
  const method = editId ? 'PUT' : 'POST';
  
  fetch(url, {
    method: method,
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': csrfToken,
      'Accept': 'application/json'
    },
    body: JSON.stringify(formData)
  })
  .then(response => {
    console.log('Response status:', response.status);
    
    if (!response.ok) {
      if (response.status === 419) {
        throw new Error('CSRF Token mismatch. Silakan refresh halaman dan coba lagi.');
      }
      return response.json().then(data => {
        throw new Error(data.message || 'Terjadi kesalahan saat menyimpan data');
      });
    }
    return response.json();
  })
  .then(data => {
    console.log('Response data:', data);
    
    if (data.success) {
      // Success - show notification and redirect
      toast('s', data.message);
      
      // Show email status feedback
      if (data.creator_email) {
        setTimeout(() => {
          if (data.email_sent) {
            toast('s', `📧 ${data.email_status}`);
          } else {
            toast('w', `⚠️ ${data.email_status}`);
          }
          if (data.mail_config_hint) {
            setTimeout(() => toast('w', data.mail_config_hint), 2200);
          }
        }, 1500);
      } else {
        setTimeout(() => {
          toast('i', 'Tugas akan dikerjakan oleh admin (tidak ada email creator).');
        }, 1500);
      }
      
      // Close modal
      closeModal('ovWizard');
      
      // Reset button
      btn.disabled = false;
      btn.innerHTML = '<i class="fa-solid fa-floppy-disk"></i> Simpan Brief';
      editId = null;
      
      // Redirect setelah toast (email otomatis saat simpan — tidak perlu klik lain)
      const redirectMs = data.creator_email ? 2400 : 1200;
      setTimeout(() => {
        window.location.href = '/content-briefs';
      }, redirectMs);
      
      console.log('Data berhasil disimpan ke database:', data.data);
    } else {
      throw new Error(data.message || 'Terjadi kesalahan');
    }
  })
  .catch(error => {
    console.error('Error saving data:', error);
    
    // Show error notification
    toast('e', error.message || 'Terjadi kesalahan saat menyimpan data');
    
    // Reset button
    btn.disabled = false;
    btn.innerHTML = '<i class="fa-solid fa-floppy-disk"></i> Simpan Brief';
  });
}

function wizPrev() {
  if (curStep > 1) { curStep--; updateWizUI(); }
}

/* ══════════════════════════════════════
   DELETE
══════════════════════════════════════ */
function openDel(id) {
  const k = db.find(x => x.id === id);
  if (!k) return;
  delId = id;
  document.getElementById('delMsg').innerHTML = `Kamu akan menghapus tugas konten <b>"${k.title}"</b>. Semua data brief akan terhapus secara permanen dan tidak bisa dikembalikan.`;
  document.getElementById('delConfirmBtn').onclick = doDelete;
  openModal('ovDel');
}

function doDelete() {
  const btn = document.getElementById('delConfirmBtn');
  btn.disabled = true;
  btn.innerHTML = '<i class="fa-solid fa-circle-notch spin"></i>';
  
  // Get CSRF token
  const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
  
  if (!csrfToken) {
    toast('e', 'CSRF token tidak ditemukan. Silakan refresh halaman.');
    btn.disabled = false;
    btn.innerHTML = '<i class="fa-solid fa-trash-can"></i> Ya, Hapus';
    return;
  }
  
  // Send AJAX request to delete from database
  fetch(`/content-briefs/${delId}`, {
    method: 'DELETE',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': csrfToken,
      'Accept': 'application/json'
    }
  })
  .then(response => {
    if (!response.ok) {
      throw new Error('Gagal menghapus data');
    }
    return response.json();
  })
  .then(data => {
    if (data.success) {
      // Remove from client-side arrays
      const k = db.find(x => x.id === delId);
      db = db.filter(x => x.id !== delId);
      filtered = filtered.filter(x => x.id !== delId);
      
      // Update table and stats
      renderTable();
      renderStats();
      
      // Close modal and show success message
      closeModal('ovDel');
      toast('s', `"${k?.title}" berhasil dihapus.`);
      
      // Reset button
      btn.disabled = false;
      btn.innerHTML = '<i class="fa-solid fa-trash-can"></i> Ya, Hapus';
      delId = null;
      
      // Refresh page to show updated data
      setTimeout(() => {
        window.location.reload();
      }, 1000);
    } else {
      throw new Error(data.message || 'Gagal menghapus data');
    }
  })
  .catch(error => {
    console.error('Delete error:', error);
    toast('e', 'Gagal menghapus data. Silakan coba lagi.');
    
    // Reset button
    btn.disabled = false;
    btn.innerHTML = '<i class="fa-solid fa-trash-can"></i> Ya, Hapus';
  });
}

/* ══════════════════════════════════════
   MODAL UTILS
══════════════════════════════════════ */
function openModal(id)  { document.getElementById(id).classList.add('open');    document.body.style.overflow = 'hidden'; }
function closeModal(id) { document.getElementById(id).classList.remove('open'); document.body.style.overflow = ''; }
function bgClose(e, id) { if (e.target === document.getElementById(id)) closeModal(id); }

/* ══════════════════════════════════════
   TOAST
══════════════════════════════════════ */
function toast(type, msg) {
  const icons = { s:'fa-circle-check', w:'fa-triangle-exclamation', e:'fa-circle-exclamation' };
  const el = document.createElement('div');
  el.className = `toast t-${type}`;
  el.innerHTML = `<div class="t-ic"><i class="fa-solid ${icons[type]}"></i></div>${msg}`;
  document.getElementById('toastWrap').appendChild(el);
  requestAnimationFrame(() => requestAnimationFrame(() => el.classList.add('show')));
  setTimeout(() => { el.classList.remove('show'); setTimeout(() => el.remove(), 450); }, 3800);
}

/* ══════════════════════════════════════
   CHAR COUNTERS
══════════════════════════════════════ */
function addCharCounter(inputId, counterId, max) {
  const el = document.getElementById(inputId);
  if (!el) return;
  el.addEventListener('input', () => updateCharCounter(inputId, counterId, max));
  updateCharCounter(inputId, counterId, max);
}
function updateCharCounter(inputId, counterId, max) {
  const el  = document.getElementById(inputId);
  const cnt = document.getElementById(counterId);
  if (!el || !cnt) return;
  const len = el.value.length;
  cnt.textContent = `${len} / ${max} karakter`;
  cnt.classList.toggle('over', len > max);
}

/* ══════════════════════════════════════
   BRAND SEARCH FUNCTIONALITY
══════════════════════════════════════ */
function initBrandSearch() {
  const brandSelect = document.getElementById('fBrand');
  if (!brandSelect) return;
  
  // Convert select to searchable dropdown if there are many brands
  const options = Array.from(brandSelect.options);
  if (options.length <= 10) return; // Only enable search if there are many brands
  
  // Create searchable dropdown
  const wrapper = document.createElement('div');
  wrapper.style.position = 'relative';
  wrapper.style.display = 'inline-block';
  wrapper.style.width = '100%';
  
  const searchInput = document.createElement('input');
  searchInput.type = 'text';
  searchInput.className = 'fsel-f';
  searchInput.placeholder = 'Cari brand...';
  searchInput.style.position = 'relative';
  searchInput.style.zIndex = '10';
  
  const dropdown = document.createElement('div');
  dropdown.style.position = 'absolute';
  dropdown.style.top = '100%';
  dropdown.style.left = '0';
  dropdown.style.right = '0';
  dropdown.style.background = 'white';
  dropdown.style.border = '1px solid var(--border)';
  dropdown.style.borderRadius = 'var(--r-sm)';
  dropdown.style.maxHeight = '200px';
  dropdown.style.overflowY = 'auto';
  dropdown.style.zIndex = '20';
  dropdown.style.display = 'none';
  dropdown.style.boxShadow = 'var(--s1)';
  
  // Add options to dropdown
  options.forEach(option => {
    if (option.value === '') return; // Skip placeholder
    
    const item = document.createElement('div');
    item.style.padding = '8px 12px';
    item.style.cursor = 'pointer';
    item.style.borderBottom = '1px solid var(--border-light)';
    item.style.fontSize = '13px';
    item.style.fontFamily = 'DM Sans, sans-serif';
    item.innerHTML = option.textContent;
    
    item.addEventListener('click', () => {
      searchInput.value = option.textContent;
      brandSelect.value = option.value;
      dropdown.style.display = 'none';
      
      // Trigger change event
      const event = new Event('change', { bubbles: true });
      brandSelect.dispatchEvent(event);
    });
    
    item.addEventListener('mouseenter', () => {
      item.style.background = 'var(--blue-50)';
    });
    
    item.addEventListener('mouseleave', () => {
      item.style.background = 'white';
    });
    
    dropdown.appendChild(item);
  });
  
  // Search functionality
  searchInput.addEventListener('input', () => {
    const query = searchInput.value.toLowerCase();
    const items = dropdown.children;
    
    Array.from(items).forEach(item => {
      const text = item.textContent.toLowerCase();
      item.style.display = text.includes(query) ? 'block' : 'none';
    });
    
    dropdown.style.display = 'block';
  });
  
  // Show/hide dropdown
  searchInput.addEventListener('focus', () => {
    dropdown.style.display = 'block';
  });
  
  document.addEventListener('click', (e) => {
    if (!wrapper.contains(e.target)) {
      dropdown.style.display = 'none';
    }
  });
  
  // Replace original select
  brandSelect.style.display = 'none';
  brandSelect.parentNode.insertBefore(wrapper, brandSelect);
  wrapper.appendChild(searchInput);
  wrapper.appendChild(dropdown);
  wrapper.appendChild(brandSelect);
}

// Initialize brand search when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
  initBrandSearch();
});

/* ══════════════════════════════════════
   DYNAMIC FORMAT OPTIONS BASED ON PLATFORM
══════════════════════════════════════ */
function updateFormatOptions() {
  const platformSelect = document.getElementById('fPlatform');
  const formatSelect = document.getElementById('fFormat');
  
  if (!platformSelect || !formatSelect) return;
  
  const selectedPlatform = platformSelect.value;
  
  // Clear current options
  formatSelect.innerHTML = '<option value="">Pilih format...</option>';
  
  // Define format options per platform
  const formatOptions = {
    'Instagram': [
      { value: 'IG Feed', text: 'IG Feed (Foto/Carousel)' },
      { value: 'IG Reels', text: 'IG Reels (Video)' },
      { value: 'IG Story', text: 'IG Story' }
    ],
    'TikTok': [
      { value: 'Video Vertikal', text: 'Video Vertikal (9:16) – 3 detik hingga 10 menit' },
      { value: 'Carousel', text: 'Carousel (Foto Slide + Musik)' },
      { value: 'Teks Statis', text: 'Teks Statis' }
    ],
    'YouTube': [
      { value: 'Video Panjang', text: 'Video Panjang (16:9)' },
      { value: 'YouTube Shorts', text: 'YouTube Shorts (9:16)' },
      { value: 'Postingan Komunitas', text: 'Postingan Komunitas (Gambar / Teks / Poll)' }
    ],
    'Lainnya': [
      { value: 'Teks', text: 'Teks' },
      { value: 'Foto', text: 'Foto' },
      { value: 'Video', text: 'Video (termasuk short video seperti reels)' },
      { value: 'Tautan', text: 'Tautan (link post)' },
      { value: 'Fitur Interaktif', text: 'Fitur interaktif (polling, event, dll)' }
    ]
  };
  
  // Add options based on selected platform
  if (selectedPlatform && formatOptions[selectedPlatform]) {
    formatOptions[selectedPlatform].forEach(option => {
      const optionElement = document.createElement('option');
      optionElement.value = option.value;
      optionElement.textContent = option.text;
      formatSelect.appendChild(optionElement);
    });
  } else {
    // Default option when no platform selected
    const defaultOption = document.createElement('option');
    defaultOption.value = '';
    defaultOption.textContent = 'Pilih platform terlebih dahulu...';
    defaultOption.disabled = true;
    formatSelect.appendChild(defaultOption);
  }
  
  // Reset format selection when platform changes
  formatSelect.value = '';
  
  // Log for debugging
  console.log('Platform changed to:', selectedPlatform);
  console.log('Available formats:', formatOptions[selectedPlatform] || []);
}
</script>
</body>
</html>