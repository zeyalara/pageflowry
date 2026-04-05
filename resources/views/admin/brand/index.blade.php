<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width,initial-scale=1.0"/>
<title>Pageflowry — Brand Management</title>
<link rel="preconnect" href="https://fonts.googleapis.com"/>
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700;0,9..40,800;1,9..40,400&display=swap" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet"/>
<style>
/* ─────────────────────────────────────────
   RESET & TOKENS
───────────────────────────────────────── */
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
+:root{
  --blue:#5897fe; --blue-6:#3a7bfe; --blue-7:#2563eb;
  --blue-50:#eff6ff; --blue-100:#dbeafe; --blue-200:#bfdbfe;
  --white:#fff; --bg:#f4f7fe; --border:#e8eef9; --blight:#f0f5ff;
  --t9:#0d1526; --t7:#2d3f5e; --t5:#5c7099; --t4:#8fa3c4; --t3:#b8cae4;
  --orange:#ff7849; --violet:#8b5cf6; --emerald:#10b981;
  --rose:#f43f5e; --amber:#f59e0b; --cyan:#06b6d4;
  --sidebar:240px; --topbar:66px; --r:16px; --rs:10px;
  --s1:0 1px 3px rgba(13,21,38,.05),0 4px 16px rgba(88,151,254,.06);
  --s2:0 4px 24px rgba(88,151,254,.13);
  --s3:0 8px 48px rgba(88,151,254,.22);
  --tr:.2s cubic-bezier(.4,0,.2,1);
}
html,body{height:100%;font-family:'DM Sans',sans-serif;background:var(--bg);color:var(--t9);font-size:14px;line-height:1.5;-webkit-font-smoothing:antialiased}
::-webkit-scrollbar{width:5px;height:5px}
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
  padding:20px 20px 18px;display:flex;align-items:center;gap:10px;
  border-bottom:1px solid var(--blight);flex-shrink:0;
}
.sb-mark{
  width:32px;height:32px;border-radius:8px;flex-shrink:0;
  background:linear-gradient(135deg,var(--blue),var(--blue-6));
  display:flex;align-items:center;justify-content:center;
}
.sb-mark svg{width:15px;height:15px}
.sb-name{font-size:1rem;font-weight:800;color:var(--blue);letter-spacing:-.5px;line-height:1}
.sb-name em{color:var(--t9);font-style:normal}
.sb-nav{padding:14px 12px;flex:1}
.sb-sec{font-size:10px;font-weight:700;letter-spacing:1.1px;text-transform:uppercase;color:var(--t3);padding:12px 10px 6px}
.sb-item{
  display:flex;align-items:center;gap:10px;padding:9.5px 12px;
  border-radius:var(--rs);cursor:pointer;transition:var(--tr);
  font-size:13.5px;font-weight:500;color:var(--t5);
  text-decoration:none;position:relative;margin-bottom:1px;
}
.sb-item:hover{background:var(--blue-50);color:var(--blue-6)}
.sb-item.active{background:var(--blue-50);color:var(--blue);font-weight:600}
.sb-item.active::before{
  content:'';position:absolute;left:0;top:22%;bottom:22%;
  width:3px;border-radius:0 3px 3px 0;background:var(--blue);
}
.sb-ic{
  width:28px;height:28px;border-radius:8px;
  display:flex;align-items:center;justify-content:center;
  font-size:12.5px;flex-shrink:0;transition:var(--tr);
}
.sb-item.active .sb-ic{background:var(--blue);color:#fff;box-shadow:0 3px 10px rgba(88,151,254,.35)}
.sb-item:not(.active) .sb-ic{color:var(--t4)}
.sb-item:hover:not(.active) .sb-ic{background:var(--blue-100);color:var(--blue)}
.sb-badge{margin-left:auto;background:var(--rose);color:#fff;font-size:10px;font-weight:700;padding:1px 6px;border-radius:99px;line-height:1.6}
.sb-foot{padding:14px 12px;border-top:1px solid var(--blight);flex-shrink:0}
.sb-user{display:flex;align-items:center;gap:10px;padding:10px 12px;border-radius:var(--rs);background:var(--blue-50);cursor:pointer;transition:var(--tr)}
.sb-user:hover{background:var(--blue-100)}
.sb-ava{width:34px;height:34px;border-radius:50%;background:linear-gradient(135deg,var(--blue),var(--blue-6));display:flex;align-items:center;justify-content:center;color:#fff;font-size:12px;font-weight:700;flex-shrink:0}

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
.sc-e {border-top:2.5px solid var(--emerald)}.sc-e::after{background:var(--emerald)}
.sc-ic{width:36px;height:36px;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:14px;margin-bottom:12px}
.sc-b .sc-ic{background:rgba(88,151,254,.1);color:var(--blue)}
.sc-o .sc-ic{background:rgba(255,120,73,.1);color:var(--orange)}
.sc-v .sc-ic{background:rgba(139,92,246,.1);color:var(--violet)}
.sc-r .sc-ic{background:rgba(244,63,94,.1);color:var(--rose)}
.sc-e .sc-ic{background:rgba(16,185,129,.1);color:var(--emerald)}
.sc-num{font-size:26px;font-weight:800;color:var(--t9);line-height:1;margin-bottom:4px;letter-spacing:-.4px}
.sc-label{font-size:12px;font-weight:500;color:var(--t4)}
.sc-sub{font-size:11px;font-weight:600;margin-top:7px;display:flex;align-items:center;gap:3px}
.s-up{color:var(--emerald)}.s-w{color:var(--amber)}.s-dn{color:var(--rose)}

/* ─────────────────────────────────────────
   CONTENT CARD
───────────────────────────────────────── */
.content-card{background:var(--white);border-radius:var(--r);border:1px solid var(--border);box-shadow:var(--s1);overflow:hidden;animation:fadeUp .45s .15s ease both}
.card-header{display:flex;align-items:center;justify-content:space-between;padding:18px 22px 16px;border-bottom:1px solid var(--blight)}
.card-title{font-size:14px;font-weight:700;color:var(--t7)}
.card-actions{display:flex;gap:8px}
.card-body{padding:20px 22px}

/* ─────────────────────────────────────────
   BUTTONS
───────────────────────────────────────── */
.btn{
  display:inline-flex;align-items:center;gap:7px;padding:0 18px;height:40px;
  border-radius:var(--rs);font-family:'DM Sans',sans-serif;
  font-size:13.5px;font-weight:600;cursor:pointer;transition:var(--tr);
  border:none;outline:none;white-space:nowrap;
}
.btn-primary{background:linear-gradient(135deg,var(--blue),var(--blue-6));color:#fff;box-shadow:0 3px 12px rgba(88,151,254,.35)}
.btn-primary:hover{transform:translateY(-2px);box-shadow:0 6px 20px rgba(88,151,254,.4)}
.btn-primary:active{transform:scale(.97)}
.btn-ghost{background:var(--white);color:var(--t5);border:1.5px solid var(--border)}
.btn-ghost:hover{background:var(--blue-50);color:var(--blue);border-color:var(--blue-200)}

/* ─────────────────────────────────────────
   TABLE
───────────────────────────────────────── */
.table-responsive{overflow-x:auto}
.data-table{width:100%;border-collapse:collapse}
.data-table thead th{
  font-size:10.5px;font-weight:700;text-transform:uppercase;letter-spacing:.65px;
  color:var(--t3);padding:12px 16px;text-align:left;
  background:var(--bg);border-bottom:1px solid var(--border);white-space:nowrap;
}
.data-table tbody tr{border-bottom:1px solid var(--blight);transition:var(--tr)}
.data-table tbody tr:last-child{border-bottom:none}
.data-table tbody tr:hover{background:var(--blue-50)}
.data-table tbody td{padding:13px 16px;font-size:13px;color:var(--t7);vertical-align:middle}

/* ─────────────────────────────────────────
   ANIMATIONS
───────────────────────────────────────── */
@keyframes fadeUp{from{opacity:0;transform:translateY(14px)}to{opacity:1;transform:translateY(0)}}
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

<!-- ═══════ SIDEBAR ═══════ -->
<aside class="sidebar">
  <div class="sb-logo">
    <div class="sb-mark">
      <svg viewBox="0 0 24 24" fill="none"><path d="M13 2L4.5 13.5H11L10 22L20.5 9.5H14L13 2Z" fill="white" stroke="white" stroke-width="1.5" stroke-linejoin="round"/></svg>
    </div>
    <div class="sb-name">Page<em>flowry</em></div>
  </div>
  <nav class="sb-nav">
    <div class="sb-sec">Overview</div>
    <a class="sb-item" href="{{ route('admin.dashboard') }}"><span class="sb-ic"><i class="fa-solid fa-house"></i></span>Dashboard</a>
    <div class="sb-sec">Manajemen</div>
    <a class="sb-item active" href="{{ route('brands.index') }}"><span class="sb-ic"><i class="fa-solid fa-tag"></i></span>Brand Management</a>
    <a class="sb-item" href="{{ route('content-tasks.index') }}"><span class="sb-ic"><i class="fa-solid fa-list-check"></i></span>Daftar Tugas Konten</a>
    <div class="sb-sec">Workflow</div>
    <a class="sb-item" href="{{ route('production.index') }}"><span class="sb-ic"><i class="fa-solid fa-film"></i></span>Production</a>
    <a class="sb-item" href="{{ route('revision.index', 1) }}"><span class="sb-ic"><i class="fa-solid fa-rotate-left"></i></span>Revision<span class="sb-badge">4</span></a>
    <a class="sb-item" href="{{ route('approval.index') }}"><span class="sb-ic"><i class="fa-solid fa-circle-check"></i></span>Approval</a>
    <a class="sb-item" href="{{ route('publishing.index') }}"><span class="sb-ic"><i class="fa-solid fa-paper-plane"></i></span>Publishing</a>
    <div class="sb-sec">Laporan</div>
    <a class="sb-item" href="{{ route('analytics.index') }}"><span class="sb-ic"><i class="fa-solid fa-chart-line"></i></span>Analytics</a>
    <a class="sb-item" href="{{ route('report.index') }}"><span class="sb-ic"><i class="fa-solid fa-file-lines"></i></span>Report</a>
    <div class="sb-sec">Lainnya</div>
    <a class="sb-item" href="{{ route('settings.index') }}"><span class="sb-ic"><i class="fa-solid fa-gear"></i></span>Settings</a>
  </nav>
  <div class="sb-foot">
    <div class="sb-user">
      <div class="sb-ava">{{ auth()->check() ? $authInitials : 'U' }}</div>
      <div style="flex:1;min-width:0">
        <div style="font-size:12.5px;font-weight:600;color:var(--t7);white-space:nowrap;overflow:hidden;text-overflow:ellipsis">{{ auth()->user()->name ?? 'Guest User' }}</div>
        <div style="font-size:11px;color:var(--blue);font-weight:500">{{ auth()->check() ? ucfirst(auth()->user()->role ?? 'guest') : 'Guest' }}</div>
      </div>
      <i class="fa-solid fa-ellipsis-vertical" style="color:var(--t3);font-size:12px"></i>
    </div>
  </div>
</aside>

<!-- ═══════ MAIN ═══════ -->
<div class="main">

  <header class="topbar">
    <div>
      <div class="tb-title">Brand Management</div>
      <div class="tb-crumb">
        <i class="fa-solid fa-house" style="font-size:10px"></i>
        <i class="fa-solid fa-chevron-right" style="font-size:9px;color:var(--t3)"></i>
        <span>Brand Management</span>
      </div>
    </div>
    <div class="tb-right">
      <div class="tb-btn"><i class="fa-regular fa-bell"></i><span class="tb-dot"></span></div>
      <div class="tb-btn"><i class="fa-regular fa-envelope"></i></div>
      <div class="tb-div"></div>
      <div class="tb-av">{{ auth()->check() ? $authInitials : 'U' }}</div>
    </div>
  </header>

  <div class="body">

    <!-- PAGE HEADER -->
    <div class="pg-header">
      <div>
        <div class="pg-heading">Brand Management</div>
        <div class="pg-sub">Kelola daftar brand dan informasi PIC</div>
      </div>
      <button class="btn btn-primary" onclick="openModal('brandOverlay')">
        <i class="fa-solid fa-plus"></i> Tambah Brand
      </button>
    </div>

    <!-- STAT CARDS -->
    <div class="stats-row">
      <div class="sc sc-b" style="--i:0">
        <div class="sc-ic"><i class="fa-solid fa-tag"></i></div>
        <div class="sc-num">22</div>
        <div class="sc-label">Total Brand</div>
        <div class="sc-sub s-up"><i class="fa-solid fa-arrow-trend-up"></i> +3 minggu ini</div>
      </div>
      <div class="sc sc-o" style="--i:1">
        <div class="sc-ic"><i class="fa-solid fa-check-circle"></i></div>
        <div class="sc-num">18</div>
        <div class="sc-label">Brand Aktif</div>
        <div class="sc-sub s-w"><i class="fa-solid fa-circle"></i> Sedang berjalan</div>
      </div>
      <div class="sc sc-v" style="--i:2">
        <div class="sc-ic"><i class="fa-solid fa-user"></i></div>
        <div class="sc-num">15</div>
        <div class="sc-label">PIC Terdaftar</div>
        <div class="sc-sub s-up"><i class="fa-solid fa-user-plus"></i> +2 minggu ini</div>
      </div>
    </div>

    <!-- CONTENT CARD -->
    <div class="content-card">
      <div class="card-header">
        <h3 class="card-title">Daftar Brand</h3>
        <div class="card-actions">
          <a href="{{ route('brands.export-pdf') }}" class="btn btn-ghost" style="text-decoration:none;color:inherit;">
            <i class="fa-solid fa-file-pdf"></i> Export PDF
          </a>
          <button class="btn btn-primary" onclick="openModal('brandOverlay')">
            <i class="fa-solid fa-plus"></i> Tambah Brand
          </button>
        </div>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="data-table">
            <thead>
              <tr>
                <th>Nama Brand</th>
                <th>PIC</th>
                <th>Status</th>
                <th>Tanggal Dibuat</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td><strong>GlowSkin</strong></td>
                <td>Sarah Amanda</td>
                <td><span style="background: rgba(16,185,129,.1); color: #065f46; padding: 4px 8px; border-radius: 12px; font-size: 11px; font-weight: 600;">Aktif</span></td>
                <td>2024-01-15</td>
                <td>
                  <button class="btn btn-ghost btn-sm"><i class="fa-solid fa-edit"></i></button>
                  <button class="btn btn-ghost btn-sm"><i class="fa-solid fa-trash"></i></button>
                </td>
              </tr>
              <tr>
                <td><strong>BeautyHaus</strong></td>
                <td>Rina Pratiwi</td>
                <td><span style="background: rgba(16,185,129,.1); color: #065f46; padding: 4px 8px; border-radius: 12px; font-size: 11px; font-weight: 600;">Aktif</span></td>
                <td>2024-01-10</td>
                <td>
                  <button class="btn btn-ghost btn-sm"><i class="fa-solid fa-edit"></i></button>
                  <button class="btn btn-ghost btn-sm"><i class="fa-solid fa-trash"></i></button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

  </div><!-- /body -->
</div><!-- /main -->
</div><!-- /shell -->

<script>
function openModal(modalId) {
  // Modal functionality
  console.log('Open modal:', modalId);
}
</script>
</body>
</html>
