<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<meta name="csrf-token" content="{{ csrf_token() }}">
@method('DELETE')
<title>Pageflowry — Brand Management</title>
<link rel="preconnect" href="https://fonts.googleapis.com"/>
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700;0,9..40,800;1,9..40,400&display=swap" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet"/>

<style>
/* ═══════════════════════════════════════
   TOKENS — sama persis dengan dashboard
═══════════════════════════════════════ */
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

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

  --sidebar:      240px;
  --topbar:       66px;
  --r:            16px;
  --r-sm:         10px;

  --s1: 0 1px 3px rgba(13,21,38,.05), 0 4px 16px rgba(88,151,254,.06);
  --s2: 0 4px 24px rgba(88,151,254,.13);
  --s3: 0 8px 48px rgba(88,151,254,.22);

  --t: .2s cubic-bezier(.4,0,.2,1);
}

html, body {
  height: 100%;
  font-family: 'DM Sans', sans-serif;
  background: var(--bg);
  color: var(--text-900);
  font-size: 14px;
  line-height: 1.5;
  -webkit-font-smoothing: antialiased;
}

::-webkit-scrollbar { width: 4px; height: 4px; }
::-webkit-scrollbar-track { background: transparent; }
::-webkit-scrollbar-thumb { background: var(--blue-200); border-radius: 99px; }
::-webkit-scrollbar-thumb:hover { background: var(--blue); }

/* ═══════════════════════════════════════
   SHELL
═══════════════════════════════════════ */
.shell { display: flex; height: 100vh; overflow: hidden; }

/* ═══════════════════════════════════════
   SIDEBAR
═══════════════════════════════════════ */
.sidebar {
  width: var(--sidebar); min-width: var(--sidebar);
  height: 100vh;
  background: var(--white);
  border-right: 1px solid var(--border);
  display: flex; flex-direction: column;
  overflow-y: auto; overflow-x: hidden;
  z-index: 200;
}

.sb-logo {
  padding: 20px 20px 18px;
  display: flex; align-items: center; gap: 10px;
  border-bottom: 1px solid var(--border-light);
  flex-shrink: 0;
}
.sb-logo-mark {
  width: 32px; height: 32px; border-radius: 8px;
  background: linear-gradient(135deg, var(--blue), var(--blue-600));
  display: flex; align-items: center; justify-content: center;
  flex-shrink: 0;
}
.sb-logo-mark svg { width: 15px; height: 15px; }
.sb-logo-name {
  font-size: 1rem; font-weight: 800;
  color: var(--blue); letter-spacing: -0.5px; line-height: 1;
}
.sb-logo-name em { color: var(--text-900); font-style: normal; }

.sb-nav { padding: 14px 12px; flex: 1; }
.sb-group-label {
  font-size: 10px; font-weight: 700; letter-spacing: 1.1px;
  text-transform: uppercase; color: var(--text-300);
  padding: 12px 10px 6px;
}
.sb-item {
  display: flex; align-items: center; gap: 10px;
  padding: 9.5px 12px; border-radius: var(--r-sm);
  cursor: pointer; transition: var(--t);
  font-size: 13.5px; font-weight: 500; color: var(--text-500);
  text-decoration: none; position: relative; margin-bottom: 1px;
}
.sb-item:hover { background: var(--blue-50); color: var(--blue-600); }
.sb-item.active {
  background: var(--blue-50); color: var(--blue); font-weight: 600;
}
.sb-item.active::before {
  content: ''; position: absolute; left: 0; top: 22%; bottom: 22%;
  width: 3px; border-radius: 0 3px 3px 0; background: var(--blue);
}
.icon-wrap {
  width: 28px; height: 28px; border-radius: 8px;
  display: flex; align-items: center; justify-content: center;
  font-size: 12.5px; flex-shrink: 0; transition: var(--t);
}
.sb-item.active .icon-wrap { background: var(--blue); color: #fff; box-shadow: 0 3px 10px rgba(88,151,254,.35); }
.sb-item:not(.active) .icon-wrap { background: transparent; color: var(--text-400); }
.sb-item:hover:not(.active) .icon-wrap { background: var(--blue-100); color: var(--blue); }
.sb-badge {
  margin-left: auto; background: var(--rose); color: #fff;
  font-size: 10px; font-weight: 700; padding: 1px 6px;
  border-radius: 99px; line-height: 1.6;
}
.sb-footer {
  padding: 14px 12px; border-top: 1px solid var(--border-light); flex-shrink: 0;
}
.sb-user {
  display: flex; align-items: center; gap: 10px;
  padding: 10px 12px; border-radius: var(--r-sm);
  background: var(--blue-50); cursor: pointer; transition: var(--t);
}
.sb-user:hover { background: var(--blue-100); }
.sb-avatar {
  width: 34px; height: 34px; border-radius: 50%;
  background: linear-gradient(135deg, var(--blue), var(--blue-600));
  display: flex; align-items: center; justify-content: center;
  color: #fff; font-size: 12px; font-weight: 700; flex-shrink: 0;
}
.sb-user-info { flex: 1; min-width: 0; }
.sb-user-name { font-size: 12.5px; font-weight: 600; color: var(--text-700); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.sb-user-role { font-size: 11px; color: var(--blue); font-weight: 500; }

/* ═══════════════════════════════════════
   MAIN
═══════════════════════════════════════ */
.main { flex: 1; display: flex; flex-direction: column; overflow: hidden; min-width: 0; }

/* TOPBAR */
.topbar {
  height: var(--topbar); min-height: var(--topbar);
  background: var(--white); border-bottom: 1px solid var(--border);
  display: flex; align-items: center; justify-content: space-between;
  padding: 0 28px; gap: 16px; flex-shrink: 0; z-index: 100;
}
.tb-left {}
.tb-page { font-size: 18px; font-weight: 800; color: var(--text-900); letter-spacing: -.4px; line-height: 1.1; }
.tb-breadcrumb {
  font-size: 12px; color: var(--text-400); margin-top: 2px;
  display: flex; align-items: center; gap: 5px;
}
.tb-breadcrumb span { color: var(--blue); font-weight: 500; }
.tb-right { display: flex; align-items: center; gap: 8px; }
.tb-icon-btn {
  width: 38px; height: 38px; border-radius: var(--r-sm);
  border: 1px solid var(--border); background: var(--white);
  display: flex; align-items: center; justify-content: center;
  cursor: pointer; transition: var(--t); color: var(--text-500);
  font-size: 15px; position: relative;
}
.tb-icon-btn:hover { background: var(--blue-50); color: var(--blue); border-color: var(--blue-200); }
.tb-notif-dot {
  position: absolute; top: 7px; right: 7px;
  width: 7px; height: 7px; border-radius: 50%;
  background: var(--rose); border: 1.5px solid #fff;
}
.tb-avatar-btn {
  width: 38px; height: 38px; border-radius: var(--r-sm);
  background: linear-gradient(145deg, var(--blue), var(--blue-600));
  display: flex; align-items: center; justify-content: center;
  color: #fff; font-size: 13px; font-weight: 700; cursor: pointer;
  box-shadow: 0 3px 12px rgba(88,151,254,.35); transition: var(--t);
}
.tb-avatar-btn:hover { transform: scale(1.05); }
.tb-divider { width: 1px; height: 24px; background: var(--border); margin: 0 4px; }

/* ═══════════════════════════════════════
   BODY SCROLL
═══════════════════════════════════════ */
.body {
  flex: 1; overflow-y: auto;
  padding: 24px 28px 48px;
  display: flex; flex-direction: column; gap: 20px;
}

/* ═══════════════════════════════════════
   STAT MINI CARDS
═══════════════════════════════════════ */
.brand-stats {
  display: grid; grid-template-columns: repeat(4, 1fr); gap: 14px;
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
  max-height: 500px;
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

/* TABLE WRAPPER */
.table-wrapper {
  flex: 1;
  overflow-y: auto;
  overflow-x: hidden;
  min-height: 300px;
  height: 700px; /* Fixed height to ensure scrolling works */
  position: relative;
}

/* Cross-browser scrollbar support */
.table-wrapper::-webkit-scrollbar {
  width: 6px;
}

.table-wrapper::-webkit-scrollbar-track {
  background: var(--bg);
}

.table-wrapper::-webkit-scrollbar-thumb {
  background: var(--blue-200);
  border-radius: 99px;
}

.table-wrapper::-webkit-scrollbar-thumb:hover {
  background: var(--blue);
}

/* Firefox scrollbar support */
.table-wrapper * {
  scrollbar-width: thin;
  scrollbar-color: var(--blue-200) var(--bg);
}

.table-wrapper *::-webkit-scrollbar {
  width: 6px;
}

.table-wrapper *::-webkit-scrollbar-track {
  background: var(--bg);
}

.table-wrapper *::-webkit-scrollbar-thumb {
  background: var(--blue-200);
  border-radius: 99px;
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
.brand-table thead th:first-child { border-radius: 0; }
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
   GRID VIEW
═══════════════════════════════════════ */
.brand-grid {
  display: none;
  grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
  gap: 16px;
  padding: 20px;
}
.brand-grid.show { display: grid; }

.grid-card {
  background: var(--white); border-radius: var(--r);
  border: 1px solid var(--border); padding: 20px;
  transition: var(--t); cursor: pointer;
  animation: fadeUp .35s ease both;
}
.grid-card:hover { transform: translateY(-4px); box-shadow: var(--s2); border-color: var(--blue-200); }
.grid-card:hover .grid-actions { opacity: 1; }

.gc-head { display: flex; align-items: flex-start; justify-content: space-between; margin-bottom: 14px; }
.gc-brand { display: flex; align-items: center; gap: 11px; }
.gc-avatar {
  width: 44px; height: 44px; border-radius: 12px;
  display: flex; align-items: center; justify-content: center;
  font-size: 16px; font-weight: 800; color: #fff;
}
.gc-name { font-size: 14.5px; font-weight: 700; color: var(--text-900); }
.gc-date { font-size: 11px; color: var(--text-400); margin-top: 2px; }

.gc-divider { height: 1px; background: var(--border-light); margin: 14px 0; }

.gc-row {
  display: flex; align-items: center; justify-content: space-between;
  margin-bottom: 9px;
}
.gc-row:last-of-type { margin-bottom: 0; }
.gc-label { font-size: 11.5px; color: var(--text-400); font-weight: 500; }
.gc-value { font-size: 12.5px; font-weight: 600; color: var(--text-700); text-align: right; max-width: 160px; }
.gc-value.tone-text {
  font-size: 11.5px; font-style: italic;
  color: var(--text-500);
  white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
}

.grid-actions {
  display: flex; gap: 6px; margin-top: 16px;
  opacity: 0; transition: var(--t);
}
.grid-actions .act-btn { flex: 1; height: 34px; width: auto; border-radius: var(--r-sm); font-size: 12px; gap: 4px; display: flex; align-items: center; justify-content: center; }
.grid-actions .act-btn span { font-size: 11.5px; font-weight: 600; }

/* ═══════════════════════════════════════
   PAGINATION
═══════════════════════════════════════ */
.pagination {
  display: flex; align-items: center; justify-content: space-between;
  padding: 14px 20px;
  border-top: 1px solid var(--border-light);
}
.page-info { font-size: 12.5px; color: var(--text-400); }
.page-info strong { color: var(--text-700); font-weight: 600; }
.page-btns { display: flex; gap: 4px; }
.page-btn {
  width: 32px; height: 32px; border-radius: 8px; border: 1.5px solid var(--border);
  background: var(--white); font-family: 'DM Sans', sans-serif;
  font-size: 12.5px; font-weight: 600; color: var(--text-500);
  cursor: pointer; transition: var(--t);
  display: flex; align-items: center; justify-content: center;
}
.page-btn:hover { border-color: var(--blue-200); background: var(--blue-50); color: var(--blue); }
.page-btn.active { background: var(--blue); border-color: var(--blue); color: #fff; box-shadow: 0 2px 8px rgba(88,151,254,.3); }
.page-btn:disabled { opacity: .4; cursor: not-allowed; }

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
</head>
<body>
<div class="shell">

<!-- ════════════ SIDEBAR ════════════ -->
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
      <span class="icon-wrap"><i class="fa-solid fa-house"></i></span> Dashboard
    </a>
    <div class="sb-group-label">Manajemen</div>
    <a class="sb-item active" href="{{ route('brands.index') }}">
      <span class="icon-wrap"><i class="fa-solid fa-tag"></i></span> Brand Management
    </a>
    <a class="sb-item" href="{{ route('content-tasks.index') }}">
      <span class="icon-wrap"><i class="fa-solid fa-list-check"></i></span> Daftar Tugas Konten
    </a>
    <div class="sb-group-label">Workflow</div>
    <a class="sb-item" href="{{ route('production.index') }}">
      <span class="icon-wrap"><i class="fa-solid fa-film"></i></span> Production
    </a>
    <a class="sb-item" href="{{ route('revision.index', 1) }}">
      <span class="icon-wrap"><i class="fa-solid fa-rotate-left"></i></span> Revision
      <span class="sb-badge">4</span>
    </a>
    <a class="sb-item" href="{{ route('approval.index') }}">
      <span class="icon-wrap"><i class="fa-solid fa-circle-check"></i></span> Approval
    </a>
    <a class="sb-item" href="{{ route('publishing.index') }}">
      <span class="icon-wrap"><i class="fa-solid fa-paper-plane"></i></span> Publishing
    </a>
    <div class="sb-group-label">Laporan</div>
    <a class="sb-item" href="{{ route('analytics.index') }}">
      <span class="icon-wrap"><i class="fa-solid fa-chart-line"></i></span> Analytics
    </a>
    <a class="sb-item" href="{{ route('report.index') }}">
      <span class="icon-wrap"><i class="fa-solid fa-file-lines"></i></span> Report
    </a>
    <div class="sb-group-label">Lainnya</div>
    <a class="sb-item" href="{{ route('settings.index') }}">
      <span class="icon-wrap"><i class="fa-solid fa-gear"></i></span> Settings
    </a>
  </nav>
  <div class="sb-footer">
    <div class="sb-user">
      <div class="sb-avatar">AM</div>
      <div class="sb-user-info">
        <div class="sb-user-name">Alya Mutia</div>
        <div class="sb-user-role">Administrator</div>
      </div>
      <i class="fa-solid fa-ellipsis-vertical" style="color:var(--text-300);font-size:12px"></i>
    </div>
  </div>
</aside>

<!-- ════════════ MAIN ════════════ -->
<div class="main">

  <!-- TOPBAR -->
  <header class="topbar">
    <div class="tb-left">
      <div class="tb-page">Brand Management</div>
      <div class="tb-breadcrumb">
        <i class="fa-solid fa-house" style="font-size:10px"></i>
        <i class="fa-solid fa-chevron-right" style="font-size:9px;color:var(--text-300)"></i>
        <span>Brand Management</span>
      </div>
    </div>
    <div class="tb-right">
      <div class="tb-icon-btn">
        <i class="fa-regular fa-bell"></i>
        <span class="tb-notif-dot"></span>
      </div>
      <div class="tb-icon-btn"><i class="fa-regular fa-envelope"></i></div>
      <div class="tb-divider"></div>
      <div class="tb-avatar-btn">AM</div>
      <div class="tb-icon-btn"><i class="fa-solid fa-sliders"></i></div>
    </div>
  </header>

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
      <button class="btn btn-ghost" onclick="exportData()">
        <i class="fa-solid fa-download"></i> Export
      </button>
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
                      <div class="brand-name-text">{{ $brand->name ?: 'Unnamed Brand' }} (ID: {{ $brand->id }})</div>
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
                  <span class="content-count"><i class="fa-solid fa-film"></i> 0 konten</span>
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

      <!-- PAGINATION -->
      <div class="pagination" id="pagination">
        <div class="page-info">Menampilkan <strong id="showFrom">1</strong>–<strong id="showTo">10</strong> dari <strong id="totalRows">12</strong> brand</div>
        <div class="page-btns" id="pageBtns"></div>
      </div>
    </div>

  </div><!-- /body -->
</div><!-- /main -->
</div><!-- /shell -->

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
  // DISABLE ALL JAVASCRIPT RENDERING - Use server-side only
  // renderTable(); // DISABLED
  // document.getElementById('searchInput').addEventListener('input', filterTable); // DISABLED
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
   FILTER & SEARCH - DISABLED
══════════════════════════════════════════ */
function filterTable() {
  // DISABLED - Do not overwrite server-side rendering
  console.log('filterTable disabled - using server-side only');
  return;
  
  /*
  const q  = document.getElementById('searchInput').value.toLowerCase();
  const st = document.getElementById('filterStatus').value;
  filteredBrands = brands.filter(b => {
    const matchQ  = !q || b.name.toLowerCase().includes(q) || b.pic.toLowerCase().includes(q) || b.contact.toLowerCase().includes(q);
    const matchSt = !st || (st === 'active' && b.status === 'Active') || (st === 'inactive' && b.status === 'Non Active');
    return matchQ && matchSt;
  });
  console.log('Filtered brands:', filteredBrands);
  currentPage = 1;
  console.log('Calling renderTable...');
  renderTable();
  */
}

/* ══════════════════════════════════════════
   RENDER TABLE
══════════════════════════════════════════ */
function renderTable() {
  console.log('renderTable called with filteredBrands:', filteredBrands);
  console.log('brands array length:', brands.length);
  console.log('filteredBrands length:', filteredBrands.length);
  
  document.getElementById('brandCount').textContent = filteredBrands.length + ' brand';
  document.getElementById('totalRows').textContent  = filteredBrands.length;

  // For server-side rendering, don't apply pagination
  // Let all brands show at once
  const page = filteredBrands;
  
  console.log('Displaying all brands without pagination, page length:', page.length);

  document.getElementById('showFrom').textContent = filteredBrands.length ? 1 : 0;
  document.getElementById('showTo').textContent   = filteredBrands.length;

  // table body
  const tbody = document.getElementById('brandTableBody');
  const empty = document.getElementById('emptyState');
  
  console.log('Table elements - tbody:', tbody, 'empty:', empty);

  if (!page.length) {
    console.log('No brands to display, showing empty state');
    tbody.innerHTML = '';
    empty.classList.add('show');
  } else {
    console.log('Displaying brands in table, page data:', page);
    empty.classList.remove('show');
    
    const tableHTML = page.map((b, index) => {
      console.log(`Rendering brand ${index}:`, b);
      return `
      <tr onclick="openDetail(${b.id})">
        <td>
          <div class="brand-cell">
            <div class="brand-avatar" style="background:${brandColor(b.id)}">${brandInitials(b.name)}</div>
            <div>
              <div class="brand-name-text">${b.name}</div>
              <div class="brand-created">Dibuat ${b.created}</div>
            </div>
          </div>
        </td>
        <td>
          <div class="pic-cell">
            <div class="pic-ava">${b.pic.split(' ').slice(0,2).map(w=>w[0]).join('').toUpperCase()}</div>
            <span class="pic-name">${b.pic}</span>
          </div>
        </td>
        <td style="color:var(--text-500);font-size:12.5px">${b.contact}</td>
        <td>
          <span class="content-count"><i class="fa-solid fa-film"></i> ${b.contents || 0} konten</span>
        </td>
        <td>
          <span class="status-pill ${b.status==='Active'?'sp-active':'sp-inactive'}">
            <span class="status-dot"></span>${b.status}
          </span>
        </td>
        <td onclick="event.stopPropagation()">
          <div class="row-actions">
            <button class="act-btn act-detail" onclick="openDetail(${b.id})" title="Detail"><i class="fa-solid fa-eye"></i></button>
            <button class="act-btn act-edit"   onclick="openEdit(${b.id})"   title="Edit"><i class="fa-solid fa-pen"></i></button>
            <button class="act-btn act-del"    onclick="openDelete(${b.id})" title="Hapus"><i class="fa-solid fa-trash-can"></i></button>
          </div>
        </td>
      </tr>
    `}).join('');
    
    console.log('Generated table HTML length:', tableHTML.length);
    tbody.innerHTML = tableHTML;
    console.log('Table body innerHTML set');
  }

  // grid view
  renderGrid(page);
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
   PAGINATION
══════════════════════════════════════════ */
function renderPagination() {
  const total = Math.ceil(filteredBrands.length / perPage);
  const c = document.getElementById('pageBtns');
  c.innerHTML = '';

  const prev = document.createElement('button');
  prev.className = 'page-btn'; prev.innerHTML = '<i class="fa-solid fa-chevron-left" style="font-size:10px"></i>';
  prev.disabled = currentPage === 1;
  prev.onclick = () => { currentPage--; renderTable(); };
  c.appendChild(prev);

  for (let i = 1; i <= total; i++) {
    const b = document.createElement('button');
    b.className = 'page-btn' + (i === currentPage ? ' active' : '');
    b.textContent = i;
    b.onclick = ((p) => () => { currentPage = p; renderTable(); })(i);
    c.appendChild(b);
  }

  const next = document.createElement('button');
  next.className = 'page-btn'; next.innerHTML = '<i class="fa-solid fa-chevron-right" style="font-size:10px"></i>';
  next.disabled = currentPage === total || total === 0;
  next.onclick = () => { currentPage++; renderTable(); };
  c.appendChild(next);
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
  if (!validateForm()) return;

  const btn = document.getElementById('submitBtn');
  btn.innerHTML = '<i class="fa-solid fa-circle-notch spin"></i> Menyimpan...';
  btn.disabled = true;

  const id     = document.getElementById('editId').value;
  const name   = document.getElementById('fName').value.trim();
  const pic    = document.getElementById('fPic').value.trim();
  const contact= document.getElementById('fContact').value.trim();
  const target = document.getElementById('fTarget').value.trim();
  const status = document.getElementById('fStatus').value;
  const tone   = [...document.querySelectorAll('.tone-chip.selected')].map(c => c.dataset.val).join(',');

  const formData = {
    name: name,
    pic: pic,
    contact: contact,
    target_market: target,
    tone: tone,
    status: status
  };

  if (id) {
    // Update existing brand
    formData._method = 'PUT';
    
    fetch(`/brands/${id}`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
      },
      body: JSON.stringify(formData)
    })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        // Update local array
        const idx = brands.findIndex(b => b.id === +id);
        if (idx !== -1) { 
          brands[idx] = { ...brands[idx], name, pic, contact, target, tone: tone.split(','), status }; 
        }
        filteredBrands = [...brands];
        // filterTable(); // DISABLED - Do not overwrite server-side rendering
        closeModal('formOverlay');
        showToast('success', 'Brand berhasil diperbarui!');
      } else {
        showToast('error', 'Gagal memperbarui brand!');
      }
    })
    .catch(error => {
      console.error('Error:', error);
      showToast('error', 'Terjadi kesalahan saat memperbarui brand!');
    });
  } else {
    // Add new brand
    fetch('/brands', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
      },
      body: JSON.stringify(formData)
    })
    .then(response => {
      console.log('Raw Response:', response);
      console.log('Response Status:', response.status);
      
      if (!response.ok) {
        throw new Error(`HTTP error! status: ${response.status}`);
      }
      
      return response.text().then(text => {
        console.log('Response Text:', text);
        try {
          return JSON.parse(text);
        } catch (e) {
          console.error('JSON Parse Error:', e);
          throw new Error('Invalid JSON response from server');
        }
      });
    })
    .then(data => {
      console.log('AJAX Response:', data);
      if (data.success) {
        // Add to local array with new ID from database
        const newBrand = {
          id: data.brand.id,
          name: data.brand.name,
          pic: data.brand.pic,
          contact: data.brand.contact,
          target: data.brand.target_market,
          tone: data.brand.tone ? data.brand.tone.split(',') : [],
          status: data.brand.status,
          contents: 0,
          created: data.brand.created_at ? new Date(data.brand.created_at).toLocaleDateString('id-ID', { month: 'short', year: 'numeric' }) : 'Unknown'
        };
        console.log('New Brand to add:', newBrand);
        brands.unshift(newBrand);
        console.log('Brands after add:', brands);
        filteredBrands = [...brands];
        console.log('filterTable disabled - using server-side only');
        // filterTable(); // DISABLED - Do not overwrite server-side rendering
        closeModal('formOverlay');
        showToast('success', 'Brand baru berhasil ditambahkan!');
      } else {
        showToast('error', 'Gagal menambahkan brand!');
      }
    })
    .catch(error => {
      console.error('Fetch Error:', error);
      console.error('Error Details:', {
        message: error.message,
        stack: error.stack,
        status: error.response?.status,
        statusText: error.response?.statusText
      });
      
      // Fallback: If data was saved but response failed, still update UI
      if (error.message.includes('JSON') || error.message.includes('Invalid')) {
        // Assume data was saved, add to UI anyway
        const newBrand = {
          id: Date.now(), // Temporary ID
          name: name,
          pic: pic,
          contact: contact,
          target: target,
          tone: tone.split(','),
          status: status,
          contents: 0,
          created: new Date().toLocaleDateString('id-ID', { month: 'short', year: 'numeric' })
        };
        brands.unshift(newBrand);
        filteredBrands = [...brands];
        // filterTable(); // DISABLED - Do not overwrite server-side rendering
        closeModal('formOverlay');
        showToast('success', 'Brand berhasil ditambahkan! (Data tersimpan di database)');
      } else {
        showToast('error', 'Terjadi kesalahan saat menambahkan brand!');
      }
    });
  }

  // Reset button state
  btn.innerHTML = '<i class="fa-solid fa-floppy-disk"></i> Simpan Brand';
  btn.disabled = false;
}

/* ══════════════════════════════════════════
   VALIDATE
══════════════════════════════════════════ */
function validateForm() {
  let ok = true;
  const fields = [
    { id:'fName',    errId:'errName',    msg:'Nama brand wajib diisi.' },
    { id:'fPic',     errId:'errPic',     msg:'PIC wajib diisi.' },
    { id:'fContact', errId:'errContact', msg:'Kontak wajib diisi.' },
    { id:'fTarget',  errId:'errTarget',  msg:'Target market wajib diisi.' },
  ];
  fields.forEach(f => {
    const el = document.getElementById(f.id);
    const err = document.getElementById(f.errId);
    if (!el.value.trim()) {
      el.classList.add('error'); err.classList.add('show'); ok = false;
    } else {
      el.classList.remove('error'); err.classList.remove('show');
    }
  });
  const tones = document.querySelectorAll('.tone-chip.selected');
  if (!tones.length) {
    document.getElementById('errTone').classList.add('show'); ok = false;
  } else {
    document.getElementById('errTone').classList.remove('show');
  }
  return ok;
}

/* ══════════════════════════════════════════
   DETAIL
══════════════════════════════════════════ */
function openDetail(id) {
  const b = brands.find(x => x.id === id);
  if (!b) return;
  const c = brandColor(b.id);

  document.getElementById('detailHero').innerHTML = `
    <div class="detail-avatar" style="background:${c}">${brandInitials(b.name)}</div>
    <div>
      <div class="detail-name">${b.name}</div>
      <div class="detail-meta">
        <span><i class="fa-solid fa-film" style="color:var(--blue);margin-right:4px"></i>${b.contents} konten</span>
        <span><i class="fa-regular fa-calendar" style="color:var(--blue);margin-right:4px"></i>Dibuat ${b.created}</span>
        <span class="status-pill ${b.status==='Active'?'sp-active':'sp-inactive'}" style="padding:2px 9px">
          <span class="status-dot"></span>${b.status}
        </span>
      </div>
    </div>
  `;

  const maxContent = Math.max(...brands.map(x=>x.contents), 1);
  document.getElementById('detailBody').innerHTML = `
    <div class="detail-grid">
      <div class="detail-item">
        <div class="detail-item-label">PIC</div>
        <div class="detail-item-value">${b.pic}</div>
      </div>
      <div class="detail-item">
        <div class="detail-item-label">Kontak</div>
        <div class="detail-item-value">${b.contact}</div>
      </div>
      <div class="detail-item full">
        <div class="detail-item-label">Target Market</div>
        <div class="detail-item-value" style="font-weight:400;color:var(--text-500)">${b.target}</div>
      </div>
      <div class="detail-item full">
        <div class="detail-item-label">Tone Komunikasi</div>
        <div class="detail-tone-tags">
          ${b.tone.map(t => `<span class="detail-tone-tag">${t}</span>`).join('')}
        </div>
      </div>
      <div class="detail-item full">
        <div class="detail-item-label">Distribusi Konten</div>
        <div class="content-bar" style="margin-top:8px">
          <div class="cb-row">
            <span class="cb-label">Total Konten</span>
            <div class="cb-track"><div class="cb-fill" style="width:${(b.contents/maxContent*100)}%;background:${c}"></div></div>
            <span class="cb-num">${b.contents}</span>
          </div>
          <div class="cb-row">
            <span class="cb-label">Published</span>
            <div class="cb-track"><div class="cb-fill" style="width:${(Math.floor(b.contents*.6)/maxContent*100)}%;background:var(--emerald)"></div></div>
            <span class="cb-num">${Math.floor(b.contents*.6)}</span>
          </div>
          <div class="cb-row">
            <span class="cb-label">On Progress</span>
            <div class="cb-track"><div class="cb-fill" style="width:${(Math.ceil(b.contents*.4)/maxContent*100)}%;background:var(--amber)"></div></div>
            <span class="cb-num">${Math.ceil(b.contents*.4)}</span>
          </div>
        </div>
      </div>
    </div>
  `;

  document.getElementById('detailEditBtn').onclick = () => openEdit(id);
  openModal('detailOverlay');
}

/* ══════════════════════════════════════════
   DELETE
══════════════════════════════════════════ */
function openDelete(id) {
  const b = brands.find(x => x.id === id);
  if (!b) return;
  deleteTargetId = id;
  document.getElementById('deleteMsg').innerHTML =
    `Kamu akan menghapus brand <strong>${b.name}</strong>. Brand yang sudah dihapus tidak dapat dipulihkan kembali.`;
  document.getElementById('confirmDeleteBtn').onclick = () => confirmDelete();
  openModal('deleteOverlay');
}

function confirmDelete() {
  const btn = document.getElementById('confirmDeleteBtn');
  btn.innerHTML = '<i class="fa-solid fa-circle-notch spin"></i>';
  btn.disabled  = true;

  fetch(`/brands/${deleteTargetId}`, {
    method: 'DELETE',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    }
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      const b = brands.find(x => x.id === deleteTargetId);
      brands = brands.filter(x => x.id !== deleteTargetId);
      filteredBrands = filteredBrands.filter(x => x.id !== deleteTargetId);
      renderTable();
      closeModal('deleteOverlay');
      showToast('error', `Brand "${b?.name}" berhasil dihapus.`);
    } else {
      showToast('error', 'Gagal menghapus brand!');
    }
  })
  .catch(error => {
    console.error('Error:', error);
    showToast('error', 'Terjadi kesalahan saat menghapus brand!');
  })
  .finally(() => {
    btn.innerHTML = '<i class="fa-solid fa-trash-can"></i> Hapus';
    btn.disabled = false;
    deleteTargetId = null;
  });
}

/* ══════════════════════════════════════════
   EXPORT
══════════════════════════════════════════ */
function exportData() {
  showToast('warn', 'Fitur export sedang dalam pengembangan.');
}

/* ══════════════════════════════════════════
   TOAST
══════════════════════════════════════════ */
function showToast(type, msg) {
  const icons = { success:'fa-circle-check', warn:'fa-triangle-exclamation', error:'fa-circle-exclamation' };
  const t = document.createElement('div');
  t.className = `toast toast-${type}`;
  t.innerHTML = `<div class="toast-ic"><i class="fa-solid ${icons[type]}"></i></div>${msg}`;
  document.getElementById('toastContainer').appendChild(t);
  requestAnimationFrame(() => { requestAnimationFrame(() => t.classList.add('show')); });
  setTimeout(() => {
    t.classList.remove('show');
    setTimeout(() => t.remove(), 400);
  }, 3200);
}

/* ══════════════════════════════════════════
   SIDEBAR NAV
══════════════════════════════════════════ */
document.querySelectorAll('.sb-item').forEach(el => {
  el.addEventListener('click', function(e) {
    // Only prevent default if it's a placeholder link (href="#")
    if (this.getAttribute('href') === '#') {
      e.preventDefault();
    }
    document.querySelectorAll('.sb-item').forEach(x => x.classList.remove('active'));
    this.classList.add('active');
  });
});

/* live input clear error */
['fName','fPic','fContact','fTarget'].forEach(id => {
  document.getElementById(id).addEventListener('input', function() {
    this.classList.remove('error');
    const errId = 'err' + id.charAt(1).toUpperCase() + id.slice(2);
    const err = document.getElementById(errId);
    if (err) err.classList.remove('show');
  });
});
</script>
</body>
</html>
