<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>Pageflowry — Dashboard</title>
<link rel="preconnect" href="https://fonts.googleapis.com"/>
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700;0,9..40,800;1,9..40,400&display=swap" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>

<style>
/* ═══════════════════════════════════════════════
   TOKENS
═══════════════════════════════════════════════ */
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

:root {
  /* brand */
  --blue:        #5897fe;
  --blue-600:    #3a7bfe;
  --blue-700:    #2563eb;
  --blue-50:     #eff6ff;
  --blue-100:    #dbeafe;
  --blue-200:    #bfdbfe;

  /* neutrals */
  --white:       #ffffff;
  --bg:          #f4f7fe;
  --surface:     #ffffff;
  --border:      #e8eef9;
  --border-light:#f0f5ff;

  --text-900:    #0d1526;
  --text-700:    #2d3f5e;
  --text-500:    #5c7099;
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

  /* shadows */
  --s1: 0 1px 3px rgba(13,21,38,.05), 0 4px 16px rgba(88,151,254,.06);
  --s2: 0 4px 24px rgba(88,151,254,.12);
  --s3: 0 8px 40px rgba(88,151,254,.20);

  /* transitions */
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

/* ═══════════════════════════════════════════════
   LAYOUT SHELL
═══════════════════════════════════════════════ */
.shell {
  display: flex;
  height: 100vh;
  overflow: hidden;
}

/* ═══════════════════════════════════════════════
   SIDEBAR
═══════════════════════════════════════════════ */
.sidebar {
  width: var(--sidebar);
  min-width: var(--sidebar);
  height: 100vh;
  background: var(--white);
  border-right: 1px solid var(--border);
  display: flex;
  flex-direction: column;
  overflow-y: auto;
  overflow-x: hidden;
  z-index: 200;
}

.sb-logo {
  padding: 20px 20px 18px;
  display: flex;
  align-items: center;
  gap: 10px;
  border-bottom: 1px solid var(--border-light);
  flex-shrink: 0;
}

.sb-logo-mark {
  width: 32px;
  height: 32px;
  border-radius: 8px;
  background: linear-gradient(135deg, var(--blue), var(--blue-600));
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
}
.sb-logo-mark svg { width: 15px; height: 15px; }

.sb-logo-name {
  font-size: 1rem;
  font-weight: 800;
  color: var(--blue);
  letter-spacing: -0.5px;
  line-height: 1;
}
.sb-logo-name em {
  color: var(--text-900);
  font-style: normal;
}

.sb-nav {
  padding: 14px 12px;
  flex: 1;
}

.sb-group-label {
  font-size: 10px;
  font-weight: 700;
  letter-spacing: 1.1px;
  text-transform: uppercase;
  color: var(--text-300);
  padding: 12px 10px 6px;
}

.sb-item {
  display: flex;
  align-items: center;
  gap: 10px;
  padding: 9.5px 12px;
  border-radius: var(--r-sm);
  cursor: pointer;
  transition: var(--t);
  font-size: 13.5px;
  font-weight: 500;
  color: var(--text-500);
  text-decoration: none;
  position: relative;
  margin-bottom: 1px;
  white-space: nowrap;
}
.sb-item:hover {
  background: var(--blue-50);
  color: var(--blue-600);
}
.sb-item.active {
  background: var(--blue-50);
  color: var(--blue);
  font-weight: 600;
}
.sb-item.active::before {
  content: '';
  position: absolute;
  left: 0; top: 22%; bottom: 22%;
  width: 3px;
  border-radius: 0 3px 3px 0;
  background: var(--blue);
}
.sb-item .icon-wrap {
  width: 28px;
  height: 28px;
  border-radius: 8px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 12.5px;
  flex-shrink: 0;
  transition: var(--t);
}
.sb-item.active .icon-wrap {
  background: var(--blue);
  color: #fff;
  box-shadow: 0 3px 10px rgba(88,151,254,.35);
}
.sb-item:not(.active) .icon-wrap {
  background: transparent;
  color: var(--text-400);
}
.sb-item:hover:not(.active) .icon-wrap {
  background: var(--blue-100);
  color: var(--blue);
}

.sb-badge {
  margin-left: auto;
  background: var(--rose);
  color: #fff;
  font-size: 10px;
  font-weight: 700;
  padding: 1px 6px;
  border-radius: 99px;
  line-height: 1.6;
}

.sb-footer {
  padding: 14px 12px;
  border-top: 1px solid var(--border-light);
  flex-shrink: 0;
}
.sb-user {
  display: flex;
  align-items: center;
  gap: 10px;
  padding: 10px 12px;
  border-radius: var(--r-sm);
  background: var(--blue-50);
  cursor: pointer;
  transition: var(--t);
}
.sb-user:hover { background: var(--blue-100); }
.sb-avatar {
  width: 34px;
  height: 34px;
  border-radius: 50%;
  background: linear-gradient(135deg, var(--blue), var(--blue-600));
  display: flex;
  align-items: center;
  justify-content: center;
  color: #fff;
  font-size: 12px;
  font-weight: 700;
  flex-shrink: 0;
}
.sb-user-info { flex: 1; min-width: 0; }
.sb-user-name {
  font-size: 12.5px;
  font-weight: 600;
  color: var(--text-700);
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}
.sb-user-role {
  font-size: 11px;
  color: var(--blue);
  font-weight: 500;
}

/* ═══════════════════════════════════════════════
   MAIN PANEL
═══════════════════════════════════════════════ */
.main {
  flex: 1;
  display: flex;
  flex-direction: column;
  overflow: hidden;
  min-width: 0;
}

/* ═══════════════════════════════════════════════
   TOPBAR
═══════════════════════════════════════════════ */
.topbar {
  height: var(--topbar);
  min-height: var(--topbar);
  background: var(--white);
  border-bottom: 1px solid var(--border);
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 0 28px;
  gap: 16px;
  flex-shrink: 0;
  z-index: 100;
}

.tb-left {}
.tb-page {
  font-family: 'DM Sans', sans-serif;
  font-size: 18px;
  font-weight: 800;
  color: var(--text-900);
  line-height: 1.1;
  letter-spacing: -.4px;
}
.tb-breadcrumb {
  font-size: 12px;
  color: var(--text-400);
  margin-top: 2px;
  display: flex;
  align-items: center;
  gap: 5px;
}
.tb-breadcrumb span { color: var(--blue); font-weight: 500; }

.tb-right {
  display: flex;
  align-items: center;
  gap: 8px;
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
  top: 7px; right: 7px;
  width: 7px; height: 7px;
  border-radius: 50%;
  background: var(--rose);
  border: 1.5px solid #fff;
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
.tb-avatar-btn:hover { transform: scale(1.05); box-shadow: var(--s3); }

.tb-divider {
  width: 1px;
  height: 24px;
  background: var(--border);
  margin: 0 4px;
}

/* ═══════════════════════════════════════════════
   SCROLL BODY
═══════════════════════════════════════════════ */
.body {
  flex: 1;
  overflow-y: auto;
  padding: 24px 28px 48px;
  display: flex;
  flex-direction: column;
  gap: 22px;
}

/* ═══════════════════════════════════════════════
   SECTION HEADER
═══════════════════════════════════════════════ */
.sec-head {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 14px;
}
.sec-title {
  font-size: 13px;
  font-weight: 700;
  color: var(--text-700);
  display: flex;
  align-items: center;
  gap: 7px;
  font-family: 'DM Sans', sans-serif;
  letter-spacing: -.1px;
}
.sec-title i {
  font-size: 12px;
  color: var(--blue);
  width: 22px; height: 22px;
  background: var(--blue-50);
  border-radius: 6px;
  display: flex;
  align-items: center;
  justify-content: center;
}
.sec-link {
  font-size: 12px;
  font-weight: 600;
  color: var(--blue);
  text-decoration: none;
  display: flex;
  align-items: center;
  gap: 4px;
  transition: var(--t);
}
.sec-link:hover { color: var(--blue-600); gap: 7px; }

/* ═══════════════════════════════════════════════
   STAT CARDS — 7 COLUMN
═══════════════════════════════════════════════ */
.stat-row {
  display: grid;
  grid-template-columns: repeat(7, 1fr);
  gap: 14px;
}

.stat-card {
  background: var(--white);
  border-radius: var(--r);
  padding: 18px 16px 16px;
  border: 1px solid var(--border);
  box-shadow: var(--s1);
  cursor: pointer;
  transition: var(--t);
  animation: fadeSlide .5s ease both;
  animation-delay: calc(var(--i,0) * 60ms);
  position: relative;
  overflow: hidden;
}
.stat-card::after {
  content: '';
  position: absolute;
  bottom: -18px; right: -18px;
  width: 64px; height: 64px;
  border-radius: 50%;
  opacity: .07;
  transition: var(--t);
}
.stat-card:hover {
  transform: translateY(-4px);
  box-shadow: var(--s2);
  border-color: var(--blue-200);
}
.stat-card:hover::after { opacity: .14; }

/* per-card color overrides */
.sc-blue  { border-top: 2.5px solid var(--blue);    } .sc-blue::after  { background: var(--blue); }
.sc-rose  { border-top: 2.5px solid var(--rose);    } .sc-rose::after  { background: var(--rose); }
.sc-org   { border-top: 2.5px solid var(--orange);  } .sc-org::after   { background: var(--orange); }
.sc-vio   { border-top: 2.5px solid var(--violet);  } .sc-vio::after   { background: var(--violet); }
.sc-red   { border-top: 2.5px solid #ef4444;        } .sc-red::after   { background: #ef4444; }
.sc-amb   { border-top: 2.5px solid var(--amber);   } .sc-amb::after   { background: var(--amber); }
.sc-em    { border-top: 2.5px solid var(--emerald); } .sc-em::after    { background: var(--emerald); }

.stat-ic {
  width: 36px; height: 36px;
  border-radius: 10px;
  display: flex; align-items: center; justify-content: center;
  font-size: 14px;
  margin-bottom: 12px;
}
.sc-blue .stat-ic  { background: rgba(88,151,254,.1);  color: var(--blue);    }
.sc-rose .stat-ic  { background: rgba(244,63,94,.10);  color: var(--rose);    }
.sc-org  .stat-ic  { background: rgba(255,120,73,.10); color: var(--orange);  }
.sc-vio  .stat-ic  { background: rgba(139,92,246,.10); color: var(--violet);  }
.sc-red  .stat-ic  { background: rgba(239,68,68,.10);  color: #ef4444;        }
.sc-amb  .stat-ic  { background: rgba(245,158,11,.10); color: var(--amber);   }
.sc-em   .stat-ic  { background: rgba(16,185,129,.10); color: var(--emerald); }

.stat-val {
  font-family: 'DM Sans', sans-serif;
  font-size: 26px;
  font-weight: 800;
  color: var(--text-900);
  line-height: 1;
  margin-bottom: 5px;
  letter-spacing: -.5px;
}
.stat-lbl {
  font-size: 11.5px;
  font-weight: 500;
  color: var(--text-400);
  line-height: 1.3;
}
.stat-trend {
  margin-top: 8px;
  font-size: 11px;
  font-weight: 600;
  display: flex;
  align-items: center;
  gap: 3px;
}
.trend-up   { color: var(--emerald); }
.trend-warn { color: var(--amber); }
.trend-down { color: #ef4444; }

/* ═══════════════════════════════════════════════
   GRADIENT MINI CARDS — 4 column
═══════════════════════════════════════════════ */
.mini-row {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 14px;
}

.mini-card {
  border-radius: var(--r);
  padding: 20px;
  color: #fff;
  position: relative;
  overflow: hidden;
  cursor: pointer;
  transition: var(--t);
  animation: fadeSlide .5s .15s ease both;
}
.mini-card:hover { transform: translateY(-4px); box-shadow: var(--s3); }

.mc-1 { background: linear-gradient(135deg, #5897fe 0%, #2563eb 100%); }
.mc-2 { background: linear-gradient(135deg, #8b5cf6 0%, #6d28d9 100%); }
.mc-3 { background: linear-gradient(135deg, #06b6d4 0%, #0284c7 100%); }
.mc-4 { background: linear-gradient(135deg, #f43f5e 0%, #be123c 100%); }

.mini-card::before {
  content: '';
  position: absolute;
  top: -20px; right: -20px;
  width: 90px; height: 90px;
  border-radius: 50%;
  background: rgba(255,255,255,.1);
}
.mini-card::after {
  content: '';
  position: absolute;
  bottom: -10px; right: 10px;
  width: 55px; height: 55px;
  border-radius: 50%;
  background: rgba(255,255,255,.07);
}

.mini-label { font-size: 12px; font-weight: 500; opacity: .82; margin-bottom: 6px; }
.mini-val {
  font-family: 'DM Sans', sans-serif;
  font-size: 30px;
  font-weight: 800;
  line-height: 1;
  margin-bottom: 5px;
  letter-spacing: -.5px;
}
.mini-sub { font-size: 11.5px; opacity: .72; }
.mini-icon {
  position: absolute;
  bottom: 12px; right: 16px;
  font-size: 28px;
  opacity: .18;
}

/* ═══════════════════════════════════════════════
   CHART ROW
═══════════════════════════════════════════════ */
.chart-row {
  display: grid;
  grid-template-columns: 1fr 300px;
  gap: 14px;
}

.card {
  background: var(--white);
  border-radius: var(--r);
  border: 1px solid var(--border);
  box-shadow: var(--s1);
  padding: 20px;
  animation: fadeSlide .5s .2s ease both;
}

/* line chart card */
.chart-header {
  display: flex;
  align-items: flex-start;
  justify-content: space-between;
}
.chart-meta {}
.chart-big {
  font-family: 'DM Sans', sans-serif;
  font-size: 32px;
  font-weight: 800;
  color: var(--text-900);
  line-height: 1;
  margin-top: 6px;
  letter-spacing: -.6px;
}
.chart-caption { font-size: 12px; color: var(--text-400); margin-top: 3px; }

.tab-group {
  display: flex;
  background: var(--blue-50);
  border-radius: 8px;
  padding: 3px;
  gap: 2px;
}
.tab-btn {
  padding: 5px 13px;
  border-radius: 6px;
  border: none;
  background: transparent;
  font-family: 'DM Sans', sans-serif;
  font-size: 12px;
  font-weight: 600;
  color: var(--text-400);
  cursor: pointer;
  transition: var(--t);
}
.tab-btn.active {
  background: var(--blue);
  color: #fff;
  box-shadow: 0 2px 8px rgba(88,151,254,.3);
}
.tab-btn:hover:not(.active) { color: var(--blue); }

.chart-wrap { margin-top: 16px; height: 168px; position: relative; }

/* donut card */
.donut-card {}
.donut-ring {
  width: 140px; height: 140px;
  margin: 16px auto 0;
  position: relative;
}
.donut-center {
  position: absolute;
  inset: 0;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
}
.donut-num {
  font-family: 'DM Sans', sans-serif;
  font-size: 24px;
  font-weight: 800;
  color: var(--text-900);
  line-height: 1;
}
.donut-note { font-size: 10.5px; color: var(--text-400); margin-top: 2px; }
.donut-legend {
  margin-top: 16px;
  display: flex;
  flex-direction: column;
  gap: 7px;
}
.dl-item {
  display: flex;
  align-items: center;
  justify-content: space-between;
}
.dl-left {
  display: flex;
  align-items: center;
  gap: 7px;
  font-size: 12px;
  color: var(--text-500);
}
.dl-dot {
  width: 8px; height: 8px;
  border-radius: 50%;
  flex-shrink: 0;
}
.dl-pct {
  font-size: 12px;
  font-weight: 700;
  color: var(--text-700);
}
.dl-bar-wrap {
  flex: 1;
  height: 4px;
  background: var(--border);
  border-radius: 99px;
  margin: 0 10px;
  overflow: hidden;
}
.dl-bar {
  height: 100%;
  border-radius: 99px;
  transition: width .8s cubic-bezier(.4,0,.2,1);
}

/* ═══════════════════════════════════════════════
   TABLE ROWS
═══════════════════════════════════════════════ */
.table-row {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 14px;
}

.tbl-card { animation: fadeSlide .5s .25s ease both; }

table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 14px;
}
thead th {
  font-size: 10.5px;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: .7px;
  color: var(--text-300);
  padding: 0 10px 10px;
  text-align: left;
  border-bottom: 1px solid var(--border-light);
}
tbody td {
  padding: 11px 10px;
  font-size: 12.5px;
  color: var(--text-700);
  border-bottom: 1px solid var(--border-light);
  vertical-align: middle;
  transition: var(--t);
}
tbody tr:last-child td { border-bottom: none; }
tbody tr:hover td { background: var(--blue-50); }

.td-name {
  font-weight: 600;
  color: var(--text-900);
  font-size: 12.5px;
  max-width: 140px;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
  display: block;
}
.td-brand {
  font-size: 11.5px;
  color: var(--blue);
  font-weight: 500;
}
.td-date {
  font-size: 12px;
  color: var(--text-500);
  white-space: nowrap;
}
.td-date i { color: var(--blue); margin-right: 4px; font-size: 11px; }

/* ═══════════════════════════════════════════════
   STATUS PILLS
═══════════════════════════════════════════════ */
.pill {
  display: inline-flex;
  align-items: center;
  gap: 5px;
  padding: 4px 10px;
  border-radius: 99px;
  font-size: 11px;
  font-weight: 600;
  white-space: nowrap;
}
.pill-dot { width: 6px; height: 6px; border-radius: 50%; flex-shrink: 0; }

.p-prod     { background: rgba(255,120,73,.10); color: #d45a22; }
.p-prod     .pill-dot { background: var(--orange); }
.p-review   { background: rgba(139,92,246,.10);  color: #6d28d9; }
.p-review   .pill-dot { background: var(--violet); }
.p-revision { background: rgba(239,68,68,.10);   color: #b91c1c; }
.p-revision .pill-dot { background: #ef4444; }
.p-ready    { background: rgba(245,158,11,.10);  color: #92400e; }
.p-ready    .pill-dot { background: var(--amber); }
.p-pub      { background: rgba(16,185,129,.10);  color: #065f46; }
.p-pub      .pill-dot { background: var(--emerald); }

/* ═══════════════════════════════════════════════
   PLATFORM CHIP
═══════════════════════════════════════════════ */
.chip {
  display: inline-flex;
  align-items: center;
  gap: 5px;
  padding: 3px 9px;
  border-radius: 99px;
  font-size: 11px;
  font-weight: 600;
}
.chip-ig { background: #fce7f3; color: #9d174d; }
.chip-tt { background: #f0fdf4; color: #14532d; }
.chip-yt { background: #fef2f2; color: #991b1b; }

/* ═══════════════════════════════════════════════
   BOTTOM ROW — activity + qa
═══════════════════════════════════════════════ */
.bottom-row {
  display: grid;
  grid-template-columns: 1fr 316px;
  gap: 14px;
}

/* Activity */
.act-card { animation: fadeSlide .5s .3s ease both; }
.act-list { margin-top: 14px; }

.act-item {
  display: flex;
  align-items: flex-start;
  gap: 12px;
  padding: 12px 8px;
  border-radius: var(--r-sm);
  cursor: pointer;
  transition: var(--t);
}
.act-item:hover { background: var(--blue-50); }
.act-item + .act-item { border-top: 1px solid var(--border-light); }

.act-dot {
  width: 36px; height: 36px;
  border-radius: 50%;
  display: flex; align-items: center; justify-content: center;
  font-size: 13px;
  flex-shrink: 0;
  margin-top: 1px;
}
.ad-blue  { background: rgba(88,151,254,.12); color: var(--blue);    }
.ad-org   { background: rgba(255,120,73,.12); color: var(--orange);  }
.ad-em    { background: rgba(16,185,129,.12); color: var(--emerald); }
.ad-vio   { background: rgba(139,92,246,.12); color: var(--violet);  }
.ad-rose  { background: rgba(244,63,94,.12);  color: var(--rose);    }

.act-body { flex: 1; min-width: 0; }
.act-name {
  font-size: 13px;
  font-weight: 600;
  color: var(--text-900);
  margin-bottom: 3px;
}
.act-detail {
  font-size: 12px;
  color: var(--text-400);
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}
.act-time {
  font-size: 11px;
  color: var(--text-300);
  flex-shrink: 0;
  padding-top: 3px;
  white-space: nowrap;
}

/* ═══════════════════════════════════════════════
   QUICK ACTION CARD
═══════════════════════════════════════════════ */
.qa-card { animation: fadeSlide .5s .35s ease both; }

.qa-list {
  margin-top: 14px;
  display: flex;
  flex-direction: column;
  gap: 9px;
}

.qa-btn {
  width: 100%;
  display: flex;
  align-items: center;
  gap: 12px;
  padding: 12px 14px;
  border-radius: var(--r-sm);
  border: 1.5px solid var(--border);
  background: var(--white);
  cursor: pointer;
  text-align: left;
  transition: var(--t);
}
.qa-btn:hover {
  border-color: var(--blue-200);
  background: var(--blue-50);
  transform: translateX(4px);
}
.qa-btn:active { transform: scale(.98); }

.qa-ic {
  width: 36px; height: 36px;
  border-radius: 9px;
  display: flex; align-items: center; justify-content: center;
  font-size: 14px;
  flex-shrink: 0;
}
.qa-1 .qa-ic { background: linear-gradient(135deg, var(--blue), var(--blue-600)); color: #fff; box-shadow: 0 3px 10px rgba(88,151,254,.35); }
.qa-2 .qa-ic { background: linear-gradient(135deg, var(--emerald), #059669);       color: #fff; box-shadow: 0 3px 10px rgba(16,185,129,.30); }
.qa-3 .qa-ic { background: linear-gradient(135deg, var(--violet), #6d28d9);        color: #fff; box-shadow: 0 3px 10px rgba(139,92,246,.30); }

.qa-text { flex: 1; }
.qa-label { font-size: 13px; font-weight: 700; color: var(--text-900); }
.qa-sub   { font-size: 11.5px; color: var(--text-400); margin-top: 1px; }
.qa-arr   { color: var(--text-300); font-size: 12px; transition: var(--t); }
.qa-btn:hover .qa-arr { color: var(--blue); transform: translateX(2px); }

/* attention panel */
.attn-panel {
  margin-top: 16px;
  padding-top: 16px;
  border-top: 1px solid var(--border-light);
}
.attn-title {
  font-size: 11.5px;
  font-weight: 700;
  color: var(--text-400);
  text-transform: uppercase;
  letter-spacing: .8px;
  margin-bottom: 10px;
}
.attn-items { display: flex; flex-direction: column; gap: 7px; }
.attn-item {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 9px 12px;
  border-radius: 9px;
  cursor: pointer;
  transition: var(--t);
  font-size: 12.5px;
  font-weight: 600;
  border: 1px solid transparent;
}
.attn-item:hover { transform: translateX(2px); }

.attn-red  { background: rgba(239,68,68,.06);   color: #b91c1c; border-color: rgba(239,68,68,.12); }
.attn-red:hover  { background: rgba(239,68,68,.1);  }
.attn-amb  { background: rgba(245,158,11,.06);  color: #92400e; border-color: rgba(245,158,11,.12); }
.attn-amb:hover  { background: rgba(245,158,11,.1); }
.attn-blue { background: rgba(88,151,254,.06);  color: #1d4ed8; border-color: rgba(88,151,254,.12); }
.attn-blue:hover { background: rgba(88,151,254,.1); }

.attn-left { display: flex; align-items: center; gap: 7px; }
.attn-num {
  min-width: 22px; height: 22px;
  border-radius: 6px;
  display: flex; align-items: center; justify-content: center;
  font-size: 11px; font-weight: 800;
  color: #fff;
}
.attn-red  .attn-num { background: #ef4444; }
.attn-amb  .attn-num { background: var(--amber); }
.attn-blue .attn-num { background: var(--blue); }

/* ═══════════════════════════════════════════════
   ANIMATIONS
═══════════════════════════════════════════════ */
@keyframes fadeSlide {
  from { opacity: 0; transform: translateY(16px); }
  to   { opacity: 1; transform: translateY(0); }
}

</style>
</head>
<body>
<div class="shell">

<!-- ════════════════ SIDEBAR ════════════════ -->
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
    <a class="sb-item active" href="#">
      <span class="icon-wrap"><i class="fa-solid fa-house"></i></span>
      Dashboard
    </a>

    <div class="sb-group-label">Manajemen</div>
    <a class="sb-item" href="#">
      <span class="icon-wrap"><i class="fa-solid fa-tag"></i></span>
      Brand Management
    </a>
    <a class="sb-item" href="#">
      <span class="icon-wrap"><i class="fa-solid fa-list-check"></i></span>
      Daftar Tugas Konten
    </a>

    <div class="sb-group-label">Workflow</div>
    <a class="sb-item" href="#">
      <span class="icon-wrap"><i class="fa-solid fa-film"></i></span>
      Production
    </a>
    <a class="sb-item" href="#">
      <span class="icon-wrap"><i class="fa-solid fa-rotate-left"></i></span>
      Revision
      <span class="sb-badge">4</span>
    </a>
    <a class="sb-item" href="#">
      <span class="icon-wrap"><i class="fa-solid fa-circle-check"></i></span>
      Approval
    </a>
    <a class="sb-item" href="#">
      <span class="icon-wrap"><i class="fa-solid fa-paper-plane"></i></span>
      Publishing
    </a>

    <div class="sb-group-label">Laporan</div>
    <a class="sb-item" href="#">
      <span class="icon-wrap"><i class="fa-solid fa-chart-line"></i></span>
      Analytics
    </a>
    <a class="sb-item" href="#">
      <span class="icon-wrap"><i class="fa-solid fa-file-lines"></i></span>
      Report
    </a>

    <div class="sb-group-label">Lainnya</div>
    <a class="sb-item" href="#">
      <span class="icon-wrap"><i class="fa-solid fa-gear"></i></span>
      Settings
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

<!-- ════════════════ MAIN ════════════════ -->
<div class="main">

  <!-- TOPBAR -->
  <header class="topbar">
    <div class="tb-left">
      <div class="tb-page">Dashboard</div>
      <div class="tb-breadcrumb">
        <i class="fa-solid fa-house" style="font-size:10px"></i>
        <i class="fa-solid fa-chevron-right" style="font-size:9px;color:var(--text-300)"></i>
        <span>Dashboard</span>
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
      <div class="tb-avatar-btn" title="Profil">AM</div>
      <div class="tb-icon-btn" title="Pengaturan">
        <i class="fa-solid fa-sliders"></i>
      </div>
    </div>
  </header>

  <!-- SCROLL BODY -->
  <div class="body">

    <!-- ── 1. STAT CARDS ── -->
    <div>
      <div class="sec-head">
        <div class="sec-title">
          <i class="fa-solid fa-grid-2"></i>
          Ringkasan Sistem
        </div>
        <a class="sec-link" href="#">Lihat detail <i class="fa-solid fa-arrow-right" style="font-size:10px"></i></a>
      </div>
      <div class="stat-row">
        <div class="stat-card sc-blue" style="--i:0">
          <div class="stat-ic"><i class="fa-solid fa-tag"></i></div>
          <div class="stat-val" data-target="12">0</div>
          <div class="stat-lbl">Total Brand</div>
          <div class="stat-trend trend-up"><i class="fa-solid fa-arrow-trend-up"></i> +2 bulan ini</div>
        </div>
        <div class="stat-card sc-rose" style="--i:1">
          <div class="stat-ic"><i class="fa-solid fa-list-check"></i></div>
          <div class="stat-val" data-target="48">0</div>
          <div class="stat-lbl">Total Tugas Konten</div>
          <div class="stat-trend trend-up"><i class="fa-solid fa-arrow-trend-up"></i> +8 minggu ini</div>
        </div>
        <div class="stat-card sc-org" style="--i:2">
          <div class="stat-ic"><i class="fa-solid fa-film"></i></div>
          <div class="stat-val" data-target="10">0</div>
          <div class="stat-lbl">In Production</div>
          <div class="stat-trend trend-warn"><i class="fa-solid fa-circle"></i> Berjalan</div>
        </div>
        <div class="stat-card sc-vio" style="--i:3">
          <div class="stat-ic"><i class="fa-solid fa-magnifying-glass"></i></div>
          <div class="stat-val" data-target="7">0</div>
          <div class="stat-lbl">Under Review</div>
          <div class="stat-trend trend-warn"><i class="fa-solid fa-hourglass-half"></i> Menunggu</div>
        </div>
        <div class="stat-card sc-red" style="--i:4">
          <div class="stat-ic"><i class="fa-solid fa-rotate-left"></i></div>
          <div class="stat-val" data-target="4">0</div>
          <div class="stat-lbl">Need Revision</div>
          <div class="stat-trend trend-down"><i class="fa-solid fa-triangle-exclamation"></i> Perlu aksi</div>
        </div>
        <div class="stat-card sc-amb" style="--i:5">
          <div class="stat-ic"><i class="fa-solid fa-clock"></i></div>
          <div class="stat-val" data-target="6">0</div>
          <div class="stat-lbl">Ready to Publish</div>
          <div class="stat-trend trend-up"><i class="fa-solid fa-check"></i> Siap tayang</div>
        </div>
        <div class="stat-card sc-em" style="--i:6">
          <div class="stat-ic"><i class="fa-solid fa-circle-check"></i></div>
          <div class="stat-val" data-target="21">0</div>
          <div class="stat-lbl">Published</div>
          <div class="stat-trend trend-up"><i class="fa-solid fa-arrow-trend-up"></i> +5 minggu ini</div>
        </div>
      </div>
    </div>

    <!-- ── 2. MINI GRADIENT ── -->
    <div class="mini-row">
      <div class="mini-card mc-1">
        <div class="mini-label">Konten Bulan Ini</div>
        <div class="mini-val">24</div>
        <div class="mini-sub">↑ 18% dari bulan lalu</div>
        <i class="fa-solid fa-photo-film mini-icon"></i>
      </div>
      <div class="mini-card mc-2">
        <div class="mini-label">Rata-rata Engagement</div>
        <div class="mini-val">6.4%</div>
        <div class="mini-sub">Target 5% · Melampaui target</div>
        <i class="fa-solid fa-heart mini-icon"></i>
      </div>
      <div class="mini-card mc-3">
        <div class="mini-label">Total Views Bulan Ini</div>
        <div class="mini-val">182K</div>
        <div class="mini-sub">↑ 31% dari bulan lalu</div>
        <i class="fa-solid fa-eye mini-icon"></i>
      </div>
      <div class="mini-card mc-4">
        <div class="mini-label">Deadline Mendekat</div>
        <div class="mini-val">3</div>
        <div class="mini-sub">Dalam 48 jam ke depan</div>
        <i class="fa-solid fa-calendar-xmark mini-icon"></i>
      </div>
    </div>

    <!-- ── 3. CHARTS ── -->
    <div class="chart-row">
      <!-- Line -->
      <div class="card">
        <div class="chart-header">
          <div class="chart-meta">
            <div class="sec-title"><i class="fa-solid fa-chart-line"></i> Performa Konten</div>
            <div class="chart-big" id="chart-big">48</div>
            <div class="chart-caption">Total konten periode ini</div>
          </div>
          <div class="tab-group">
            <button class="tab-btn" onclick="setTab(this,'daily')">Harian</button>
            <button class="tab-btn" onclick="setTab(this,'weekly')">Mingguan</button>
            <button class="tab-btn active" onclick="setTab(this,'monthly')">Bulanan</button>
          </div>
        </div>
        <div class="chart-wrap">
          <canvas id="lineChart"></canvas>
        </div>
      </div>

      <!-- Donut -->
      <div class="card donut-card">
        <div class="sec-title"><i class="fa-solid fa-chart-pie"></i> Status Distribusi</div>
        <div class="donut-ring">
          <canvas id="donutChart"></canvas>
          <div class="donut-center">
            <div class="donut-num">48</div>
            <div class="donut-note">total</div>
          </div>
        </div>
        <div class="donut-legend">
          <div class="dl-item">
            <div class="dl-left"><span class="dl-dot" style="background:#ff7849"></span>In Production</div>
            <div class="dl-bar-wrap"><div class="dl-bar" style="width:21%;background:#ff7849"></div></div>
            <div class="dl-pct">21%</div>
          </div>
          <div class="dl-item">
            <div class="dl-left"><span class="dl-dot" style="background:#8b5cf6"></span>Under Review</div>
            <div class="dl-bar-wrap"><div class="dl-bar" style="width:15%;background:#8b5cf6"></div></div>
            <div class="dl-pct">15%</div>
          </div>
          <div class="dl-item">
            <div class="dl-left"><span class="dl-dot" style="background:#ef4444"></span>Need Revision</div>
            <div class="dl-bar-wrap"><div class="dl-bar" style="width:8%;background:#ef4444"></div></div>
            <div class="dl-pct">8%</div>
          </div>
          <div class="dl-item">
            <div class="dl-left"><span class="dl-dot" style="background:#f59e0b"></span>Ready to Publish</div>
            <div class="dl-bar-wrap"><div class="dl-bar" style="width:13%;background:#f59e0b"></div></div>
            <div class="dl-pct">13%</div>
          </div>
          <div class="dl-item">
            <div class="dl-left"><span class="dl-dot" style="background:#10b981"></span>Published</div>
            <div class="dl-bar-wrap"><div class="dl-bar" style="width:43%;background:#10b981"></div></div>
            <div class="dl-pct">43%</div>
          </div>
        </div>
      </div>
    </div>

    <!-- ── 4. TABLES ── -->
    <div class="table-row">
      <!-- Deadline Produksi -->
      <div class="card tbl-card">
        <div class="sec-head" style="margin-bottom:0">
          <div class="sec-title"><i class="fa-solid fa-calendar-xmark"></i> Deadline Produksi Terdekat</div>
          <a class="sec-link" href="#">Semua <i class="fa-solid fa-arrow-right" style="font-size:10px"></i></a>
        </div>
        <table>
          <thead>
            <tr>
              <th>Judul Konten</th>
              <th>Brand</th>
              <th>Deadline</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td><span class="td-name">Tutorial Skincare Pagi</span><span class="td-brand">GlowSkin</span></td>
              <td style="display:none"></td>
              <td class="td-date"><i class="fa-regular fa-calendar"></i>09 Mar 2026</td>
              <td><span class="pill p-prod"><span class="pill-dot"></span>In Production</span></td>
            </tr>
            <tr>
              <td><span class="td-name">Review Produk Q1</span><span class="td-brand">BeautyHaus</span></td>
              <td style="display:none"></td>
              <td class="td-date"><i class="fa-regular fa-calendar"></i>10 Mar 2026</td>
              <td><span class="pill p-revision"><span class="pill-dot"></span>Need Revision</span></td>
            </tr>
            <tr>
              <td><span class="td-name">Unboxing Summer</span><span class="td-brand">StyleCo</span></td>
              <td style="display:none"></td>
              <td class="td-date"><i class="fa-regular fa-calendar"></i>11 Mar 2026</td>
              <td><span class="pill p-prod"><span class="pill-dot"></span>In Production</span></td>
            </tr>
            <tr>
              <td><span class="td-name">Tips Makeup Natural</span><span class="td-brand">GlowSkin</span></td>
              <td style="display:none"></td>
              <td class="td-date"><i class="fa-regular fa-calendar"></i>12 Mar 2026</td>
              <td><span class="pill p-review"><span class="pill-dot"></span>Under Review</span></td>
            </tr>
            <tr>
              <td><span class="td-name">GRWM Hari Kerja</span><span class="td-brand">FreshFace</span></td>
              <td style="display:none"></td>
              <td class="td-date"><i class="fa-regular fa-calendar"></i>13 Mar 2026</td>
              <td><span class="pill p-prod"><span class="pill-dot"></span>In Production</span></td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Jadwal Publish -->
      <div class="card tbl-card">
        <div class="sec-head" style="margin-bottom:0">
          <div class="sec-title"><i class="fa-solid fa-paper-plane"></i> Jadwal Publish Terdekat</div>
          <a class="sec-link" href="#">Semua <i class="fa-solid fa-arrow-right" style="font-size:10px"></i></a>
        </div>
        <table>
          <thead>
            <tr>
              <th>Judul Konten</th>
              <th>Platform</th>
              <th>Tanggal</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td><span class="td-name">Morning Skincare</span></td>
              <td><span class="chip chip-ig"><i class="fa-brands fa-instagram"></i> Instagram</span></td>
              <td class="td-date">09 Mar 2026</td>
              <td><span class="pill p-ready"><span class="pill-dot"></span>Ready</span></td>
            </tr>
            <tr>
              <td><span class="td-name">5 Produk Under 100K</span></td>
              <td><span class="chip chip-tt"><i class="fa-brands fa-tiktok"></i> TikTok</span></td>
              <td class="td-date">10 Mar 2026</td>
              <td><span class="pill p-ready"><span class="pill-dot"></span>Ready</span></td>
            </tr>
            <tr>
              <td><span class="td-name">Deep Dive Sunscreen</span></td>
              <td><span class="chip chip-yt"><i class="fa-brands fa-youtube"></i> YouTube</span></td>
              <td class="td-date">11 Mar 2026</td>
              <td><span class="pill p-pub"><span class="pill-dot"></span>Published</span></td>
            </tr>
            <tr>
              <td><span class="td-name">Kolaborasi Brand Special</span></td>
              <td><span class="chip chip-ig"><i class="fa-brands fa-instagram"></i> Instagram</span></td>
              <td class="td-date">12 Mar 2026</td>
              <td><span class="pill p-ready"><span class="pill-dot"></span>Ready</span></td>
            </tr>
            <tr>
              <td><span class="td-name">Honest Review Serum</span></td>
              <td><span class="chip chip-tt"><i class="fa-brands fa-tiktok"></i> TikTok</span></td>
              <td class="td-date">14 Mar 2026</td>
              <td><span class="pill p-ready"><span class="pill-dot"></span>Ready</span></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- ── 5. ACTIVITY + QA ── -->
    <div class="bottom-row">

      <!-- Activity -->
      <div class="card act-card">
        <div class="sec-head" style="margin-bottom:0">
          <div class="sec-title"><i class="fa-solid fa-clock-rotate-left"></i> Aktivitas Terbaru</div>
          <a class="sec-link" href="#">Semua <i class="fa-solid fa-arrow-right" style="font-size:10px"></i></a>
        </div>
        <div class="act-list">
          <div class="act-item">
            <div class="act-dot ad-blue"><i class="fa-solid fa-cloud-arrow-up"></i></div>
            <div class="act-body">
              <div class="act-name">Creator mengupload video</div>
              <div class="act-detail">Kayla · Tutorial Skincare Pagi Hari · v2 diupload</div>
            </div>
            <div class="act-time">2 mnt lalu</div>
          </div>
          <div class="act-item">
            <div class="act-dot ad-org"><i class="fa-solid fa-rotate-left"></i></div>
            <div class="act-body">
              <div class="act-name">Admin memberikan revisi</div>
              <div class="act-detail">Alya Mutia · Review Produk Q1 · deadline 10 Mar</div>
            </div>
            <div class="act-time">18 mnt lalu</div>
          </div>
          <div class="act-item">
            <div class="act-dot ad-em"><i class="fa-solid fa-circle-check"></i></div>
            <div class="act-body">
              <div class="act-name">Konten disetujui (Approved)</div>
              <div class="act-detail">Alya Mutia · Morning Skincare Routine · v3 approved</div>
            </div>
            <div class="act-time">1 jam lalu</div>
          </div>
          <div class="act-item">
            <div class="act-dot ad-vio"><i class="fa-solid fa-paper-plane"></i></div>
            <div class="act-body">
              <div class="act-name">Konten dipublish</div>
              <div class="act-detail">Deep Dive: Sunscreen SPF · YouTube · Published</div>
            </div>
            <div class="act-time">3 jam lalu</div>
          </div>
          <div class="act-item">
            <div class="act-dot ad-blue"><i class="fa-solid fa-file-circle-plus"></i></div>
            <div class="act-body">
              <div class="act-name">Brief baru dibuat</div>
              <div class="act-detail">Alya Mutia · GRWM Hari Kerja · FreshFace</div>
            </div>
            <div class="act-time">5 jam lalu</div>
          </div>
          <div class="act-item">
            <div class="act-dot ad-rose"><i class="fa-solid fa-tag"></i></div>
            <div class="act-body">
              <div class="act-name">Brand baru ditambahkan</div>
              <div class="act-detail">FreshFace · PIC: Dini Rahayu · Status: Active</div>
            </div>
            <div class="act-time">1 hari lalu</div>
          </div>
        </div>
      </div>

      <!-- Quick Action -->
      <div class="card qa-card">
        <div class="sec-title"><i class="fa-solid fa-bolt"></i> Quick Action</div>
        <div class="qa-list">
          <button class="qa-btn qa-1">
            <div class="qa-ic"><i class="fa-solid fa-plus"></i></div>
            <div class="qa-text">
              <div class="qa-label">Buat Tugas Konten</div>
              <div class="qa-sub">Buat brief konten baru</div>
            </div>
            <i class="fa-solid fa-chevron-right qa-arr"></i>
          </button>
          <button class="qa-btn qa-2">
            <div class="qa-ic"><i class="fa-solid fa-tag"></i></div>
            <div class="qa-text">
              <div class="qa-label">Tambah Brand</div>
              <div class="qa-sub">Daftarkan brand baru</div>
            </div>
            <i class="fa-solid fa-chevron-right qa-arr"></i>
          </button>
          <button class="qa-btn qa-3">
            <div class="qa-ic"><i class="fa-solid fa-film"></i></div>
            <div class="qa-text">
              <div class="qa-label">Lihat Production</div>
              <div class="qa-sub">Pantau upload video</div>
            </div>
            <i class="fa-solid fa-chevron-right qa-arr"></i>
          </button>
        </div>

        <div class="attn-panel">
          <div class="attn-title">Perlu Perhatian</div>
          <div class="attn-items">
            <div class="attn-item attn-red">
              <div class="attn-left">
                <i class="fa-solid fa-triangle-exclamation" style="font-size:13px"></i>
                Need Revision
              </div>
              <div class="attn-num">4</div>
            </div>
            <div class="attn-item attn-amb">
              <div class="attn-left">
                <i class="fa-solid fa-clock" style="font-size:13px"></i>
                Deadline 48 Jam
              </div>
              <div class="attn-num">3</div>
            </div>
            <div class="attn-item attn-blue">
              <div class="attn-left">
                <i class="fa-solid fa-paper-plane" style="font-size:13px"></i>
                Siap Publish
              </div>
              <div class="attn-num">6</div>
            </div>
          </div>
        </div>
      </div>

    </div><!-- /bottom-row -->

  </div><!-- /body -->
</div><!-- /main -->
</div><!-- /shell -->

<script>
/* ── TODAY DATE ─────────────────────── */
const d = new Date();
document.getElementById('today-date').textContent =
  d.toLocaleDateString('id-ID', { weekday:'long', day:'numeric', month:'long', year:'numeric' });

/* ── COUNT UP ───────────────────────── */
const counters = document.querySelectorAll('.stat-val[data-target]');
counters.forEach((el, i) => {
  const target = +el.dataset.target;
  let n = 0;
  const tick = () => {
    n = Math.min(n + Math.ceil(target / 25), target);
    el.textContent = n;
    if (n < target) requestAnimationFrame(tick);
  };
  setTimeout(tick, 300 + i * 60);
});

/* ── LINE CHART ─────────────────────── */
const labels = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agt'];
const data = {
  monthly: { prod:[8,12,10,15,9,14,18,10], pub:[5,9,8,12,7,11,15,8], total:'48' },
  weekly:  { prod:[2,4,3,5,2,4,6,3],       pub:[1,3,2,4,2,3,5,2],   total:'22' },
  daily:   { prod:[1,0,2,1,3,1,2,1],       pub:[0,1,1,1,2,0,1,1],   total:'8'  },
};

const lCtx = document.getElementById('lineChart').getContext('2d');

const mkGrad = (ctx, c1, c2) => {
  const g = ctx.createLinearGradient(0, 0, 0, 168);
  g.addColorStop(0, c1); g.addColorStop(1, c2);
  return g;
};

const lineChart = new Chart(lCtx, {
  type: 'line',
  data: {
    labels,
    datasets: [
      {
        label: 'Produksi',
        data: data.monthly.prod,
        borderColor: '#5897fe',
        backgroundColor: mkGrad(lCtx, 'rgba(88,151,254,.20)', 'rgba(88,151,254,0)'),
        tension: .42, fill: true,
        pointBackgroundColor: '#5897fe',
        pointRadius: 3.5, pointHoverRadius: 5.5,
        borderWidth: 2.5,
      },
      {
        label: 'Publish',
        data: data.monthly.pub,
        borderColor: '#10b981',
        backgroundColor: mkGrad(lCtx, 'rgba(16,185,129,.15)', 'rgba(16,185,129,0)'),
        tension: .42, fill: true,
        pointBackgroundColor: '#10b981',
        pointRadius: 3.5, pointHoverRadius: 5.5,
        borderWidth: 2.5,
      },
    ],
  },
  options: {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
      legend: {
        position: 'top',
        align: 'end',
        labels: {
          boxWidth: 10, boxHeight: 10,
          usePointStyle: true,
          font: { size: 11.5, family: 'DM Sans' },
          color: '#5c7099',
          padding: 14,
        },
      },
      tooltip: {
        backgroundColor: 'rgba(13,21,38,.88)',
        titleFont: { size: 12, family: 'DM Sans', weight: '600' },
        bodyFont:  { size: 11.5, family: 'DM Sans' },
        padding: 10, cornerRadius: 9, usePointStyle: true,
        callbacks: { label: c => '  ' + c.dataset.label + ': ' + c.parsed.y + ' konten' },
      },
    },
    scales: {
      x: {
        grid: { display: false },
        ticks: { font: { size: 11, family: 'DM Sans' }, color: '#8fa3c4' },
        border: { display: false },
      },
      y: {
        grid: { color: 'rgba(232,238,249,.8)', drawBorder: false },
        ticks: { font: { size: 11, family: 'DM Sans' }, color: '#8fa3c4', stepSize: 5 },
        border: { display: false },
      },
    },
  },
});

function setTab(btn, mode) {
  document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
  btn.classList.add('active');
  lineChart.data.datasets[0].data = data[mode].prod;
  lineChart.data.datasets[1].data = data[mode].pub;
  lineChart.update();
  document.getElementById('chart-big').textContent = data[mode].total;
}

/* ── DONUT CHART ────────────────────── */
const dCtx = document.getElementById('donutChart').getContext('2d');
new Chart(dCtx, {
  type: 'doughnut',
  data: {
    labels: ['In Production','Under Review','Need Revision','Ready to Publish','Published'],
    datasets: [{
      data: [10, 7, 4, 6, 21],
      backgroundColor: ['#ff7849','#8b5cf6','#ef4444','#f59e0b','#10b981'],
      borderWidth: 0,
      hoverOffset: 8,
    }],
  },
  options: {
    responsive: true,
    maintainAspectRatio: true,
    cutout: '74%',
    plugins: {
      legend: { display: false },
      tooltip: {
        backgroundColor: 'rgba(13,21,38,.88)',
        bodyFont: { size: 12, family: 'DM Sans' },
        padding: 10, cornerRadius: 9,
      },
    },
  },
});

/* ── SIDEBAR ACTIVE ─────────────────── */
document.querySelectorAll('.sb-item').forEach(el => {
  el.addEventListener('click', function () {
    document.querySelectorAll('.sb-item').forEach(x => x.classList.remove('active'));
    this.classList.add('active');
  });
});

/* ── QA BUTTON FEEDBACK ─────────────── */
document.querySelectorAll('.qa-btn').forEach(btn => {
  btn.addEventListener('click', () => {
    btn.style.transform = 'scale(.96)';
    setTimeout(() => btn.style.transform = '', 150);
  });
});
</script>
</body>
</html>