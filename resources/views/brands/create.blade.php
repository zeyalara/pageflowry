<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width,initial-scale=1.0"/>
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Pageflowry — Tambah Brand</title>
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
.tb-title{font-size:18px;font-weight:800;color:var(--text-900);letter-spacing:-.4px;line-height:1.1}
.tb-crumb{font-size:12px;color:var(--text-400);margin-top:2px;display:flex;align-items:center;gap:5px}
.tb-crumb span{color:var(--blue);font-weight:500}
.tb-right{display:flex;align-items:center;gap:8px}
.tb-btn{
  width:38px;height:38px;border-radius:var(--rs);border:1px solid var(--border);
  background:var(--white);display:flex;align-items:center;justify-content:center;
  cursor:pointer;transition:var(--t);color:var(--text-600);font-size:15px;position:relative;
}
.tb-icon-btn:hover{background:var(--blue-50);color:var(--blue);border-color:var(--blue-200)}
.tb-notif-dot{position:absolute;top:7px;right:7px;width:7px;height:7px;border-radius:50%;background:var(--rose);border:1.5px solid #fff}
.tb-divider{width:1px;height:24px;background:var(--border);margin:0 4px}

/* Header dropdown (notifikasi/pesan) */
.header-dropdown--wide{min-width:320px;max-width:min(380px,calc(100vw-24px))}
.header-dd-head{padding:10px 14px 6px;font-size:11px;font-weight:800;text-transform:uppercase;letter-spacing:.06em;color:var(--text-400);border-bottom:1px solid var(--border-light)}
.header-dd-empty{padding:12px 14px;font-size:12px;color:var(--text-600);line-height:1.45}
.header-dd-item{align-items:flex-start!important;gap:10px!important;padding:10px 12px!important}
.header-dd-ic{width:32px;height:32px;border-radius:8px;background:var(--blue-50);color:var(--blue);display:flex;align-items:center;justify-content:center;flex-shrink:0;font-size:13px}
.header-dd-body{flex:1;min-width:0;display:flex;flex-direction:column;gap:2px}
.header-dd-title{font-size:13px;font-weight:700;color:var(--text-900)}
.header-dd-sub{font-size:11px;color:var(--text-400)}
.header-dd-badge{flex-shrink:0;min-width:22px;height:22px;padding:0 7px;border-radius:999px;background:rgba(244,63,94,.14);color:#b91c1c;font-size:11px;font-weight:800;display:flex;align-items:center;justify-content:center}

/* Dropdown base style (samakan dengan halaman lain) */
.profile-dropdown{position:absolute;top:100%;right:0;background:#fff;border-radius:8px;box-shadow:0 4px 12px rgba(0,0,0,0.15);min-width:180px;z-index:1000;opacity:0;visibility:hidden;transform:translateY(-10px);transition:all .25s ease;margin-top:5px}
.profile-dropdown.show{opacity:1;visibility:visible;transform:translateY(0)}
.dropdown-item{display:flex;align-items:center;gap:10px;padding:12px 16px;color:#1A2740;text-decoration:none;font-size:13px;transition:background .2s ease}
.dropdown-item:hover{background:#f8f9fa}
.tb-avatar-btn{width:38px;height:38px;border-radius:var(--r-sm);background:linear-gradient(145deg,var(--blue),var(--blue-600));display:flex;align-items:center;justify-content:center;color:#fff;font-size:13px;font-weight:700;cursor:pointer}

/* ─────────────────────────────────────────
   CONTENT
───────────────────────────────────────── */
.content{flex:1;overflow-y:auto;padding:28px;background:var(--bg);min-height:0}
.page-head{display:flex;align-items:center;justify-content:space-between;margin-bottom:24px;gap:20px}
.ph-title{font-size:20px;font-weight:800;color:var(--text-900);letter-spacing:-.5px}
.ph-actions{display:flex;align-items:center;gap:12px}
.btn{
  padding:10px 20px;border-radius:var(--rs);border:none;font-size:13px;font-weight:600;
  cursor:pointer;transition:var(--t);display:inline-flex;align-items:center;gap:8px;
  text-decoration:none;
}
.btn-primary{background:linear-gradient(135deg,var(--blue),var(--blue-600));color:#fff}
.btn-primary:hover{transform:translateY(-1px);box-shadow:0 4px 16px rgba(88,151,254,.3)}
.btn-secondary{background:var(--white);color:var(--text-600);border:1px solid var(--border)}
.btn-secondary:hover{background:var(--blue-50);color:var(--blue);border-color:var(--blue-200)}

/* ────────────────────────────────────
   FORM CARD
────────────────────────────────── */
.fcard{background:var(--white);border-radius:var(--r);border:1px solid var(--border);box-shadow:var(--s1);overflow:hidden;animation:fadeUp .45s .15s ease both;max-width:800px;margin:0 auto}
.fcard-head{display:flex;align-items:center;justify-content:space-between;padding:18px 22px 16px;border-bottom:1px solid var(--border-light)}
.fch-l{display:flex;align-items:center;gap:10px}
.fch-title{font-size:14px;font-weight:700;color:var(--text-700)}
.fcard-body{padding:24px}
.form-grid{display:grid;grid-template-columns:1fr 1fr;gap:20px}
.form-group{display:flex;flex-direction:column;gap:6px}
.form-group.full{grid-column:1/-1}
.form-label{font-size:13px;font-weight:600;color:var(--text-700)}
.form-input{
  padding:12px 16px;border-radius:var(--rs);border:1px solid var(--border);
  font-size:14px;color:var(--text-900);background:var(--white);
  transition:var(--t);font-family:inherit;
}
.form-input:focus{outline:none;border-color:var(--blue);box-shadow:0 0 0 3px rgba(88,151,254,.1)}
.form-textarea{min-height:80px;resize:vertical}
.form-select{background-image:url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");background-position:right 12px center;background-repeat:no-repeat;background-size:16px 16px;padding-right:40px}
.form-actions{display:flex;gap:12px;justify-content:flex-end;margin-top:24px;padding-top:20px;border-top:1px solid var(--border-light)}
.error-message{font-size:12px;color:var(--rose);margin-top:2px}

/* ─────────────────────────────────────────
   ALERTS
───────────────────────────────────────── */
.alert{display:flex;align-items:center;gap:10px;padding:12px 16px;border-radius:var(--r);margin-bottom:16px;font-size:13px;font-weight:500}
.alert-success{background:#f0fdf4;color:#166534;border:1px solid #bbf7d0}
.alert-error{background:#fef2f2;color:#991b1b;border:1px solid #fecaca}

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
  $uid = auth()->id();
  $authUser = auth()->user();
  $authInitials = 'U';

  if ($authUser) {
    $username = trim((string) ($authUser->username ?? ''));
    if ($username !== '') {
      $authInitials = mb_strtoupper(mb_strlen($username) >= 2 ? mb_substr($username, 0, 1).mb_substr($username, 1, 1) : mb_substr($username, 0, 1).mb_substr($username, 0, 1));
    } else {
      $authName = trim((string) ($authUser->name ?? ''));
      $parts = $authName !== '' ? (preg_split('/\s+/u', $authName, -1, PREG_SPLIT_NO_EMPTY) ?: []) : [];
      if (count($parts) >= 2) {
        $authInitials = mb_strtoupper(mb_substr($parts[0], 0, 1).mb_substr($parts[count($parts)-1], 0, 1));
      } elseif (count($parts) === 1) {
        $w = $parts[0];
        $authInitials = mb_strtoupper(mb_strlen($w) >= 2 ? mb_substr($w, 0, 1).mb_substr($w, 1, 1) : mb_substr($w, 0, 1).mb_substr($w, 0, 1));
      } else {
        $local = explode('@', (string) ($authUser->email ?? ''))[0] ?? '';
        if ($local !== '') {
          $authInitials = mb_strtoupper(mb_strlen($local) >= 2 ? mb_substr($local, 0, 1).mb_substr($local, 1, 1) : mb_substr($local, 0, 1).mb_substr($local, 0, 1));
        }
      }
    }
  }

  $notifRevision = $uid ? \App\Models\ContentTask::where('user_id', $uid)->where('status', 'need_revision')->count() : 0;
  $notifApproval = $uid ? \App\Models\ContentTask::where('user_id', $uid)->where('status', 'under_review')->count() : 0;
  $notifPublish  = $uid ? \App\Models\ContentTask::where('user_id', $uid)->where('status', 'ready_to_publish')->count() : 0;
  $notifTotal = $notifRevision + $notifApproval + $notifPublish;

  $deadlineSoonDays = 2;
  $today = \Carbon\Carbon::today();
  $soonLimit = (clone $today)->addDays($deadlineSoonDays)->endOfDay();

  $deadlineSoon = $uid
    ? \App\Models\ContentBrief::where('user_id', $uid)
        ->whereNotIn('status', ['Published'])
        ->where(function ($q) use ($today, $soonLimit) {
          $q->whereBetween('production_deadline', [$today, $soonLimit])
            ->orWhereBetween('publish_deadline', [$today, $soonLimit]);
        })
        ->orderByRaw("LEAST(COALESCE(production_deadline, '2999-12-31'), COALESCE(publish_deadline, '2999-12-31')) asc")
        ->limit(6)
        ->get(['id','title','production_deadline','publish_deadline'])
    : collect();

  $deadlineOverdue = $uid
    ? \App\Models\ContentBrief::where('user_id', $uid)
        ->whereNotIn('status', ['Published'])
        ->where(function ($q) use ($today) {
          $q->whereDate('production_deadline', '<', $today)
            ->orWhereDate('publish_deadline', '<', $today);
        })
        ->orderByRaw("LEAST(COALESCE(production_deadline, '2999-12-31'), COALESCE(publish_deadline, '2999-12-31')) asc")
        ->limit(6)
        ->get(['id','title','production_deadline','publish_deadline'])
    : collect();

  $deadlineSoonCount = $deadlineSoon->count();
  $deadlineOverdueCount = $deadlineOverdue->count();

  $msgNeedRevision = $uid ? \App\Models\ContentTask::where('user_id', $uid)->where('status','need_revision')->latest()->limit(5)->get(['judul_konten','revision_note']) : collect();
  $msgTotal = $msgNeedRevision->count() + $deadlineSoonCount + $deadlineOverdueCount + $notifApproval + $notifPublish;
@endphp

<div class="shell">
  <!-- ═══════ SIDEBAR ═══════ -->
  <aside class="sidebar">
    <div class="sb-logo">
      <div class="sb-logo-mark">
        <svg viewBox="0 0 18 18" fill="none">
          <rect x="1" y="1" width="7" height="7" rx="2" fill="white"/>
          <rect x="10" y="1" width="7" height="7" rx="2" fill="white" opacity="0.5"/>
          <rect x="1" y="10" width="7" height="7" rx="2" fill="white" opacity="0.5"/>
          <rect x="10" y="10" width="7" height="7" rx="2" fill="white"/>
        </svg>
      </div>
      <span class="sb-logo-name">PAGE<em>FLOWRY</em></span>
    </div>

    <nav class="sb-nav">
      <div class="sb-group-label">Dashboard</div>
      <a class="sb-item {{ request()->is('creator/dashboard') ? 'active' : '' }}" href="{{ route('creator.dashboard') }}">
        <span class="icon-wrap"><i class="fa-solid fa-house"></i></span>
        <span>Dashboard</span>
      </a>

      <div class="sb-group-label">Kelola Konten</div>
      <a class="sb-item {{ request()->is('brief*') ? 'active' : '' }}" href="{{ route('brief.index') }}">
        <span class="icon-wrap"><i class="fa-solid fa-clipboard-list"></i></span>
        <span>Content Brief</span>
      </a>
      <a class="sb-item {{ request()->is('brands*') ? 'active' : '' }}" href="{{ route('brands.index') }}">
        <span class="icon-wrap"><i class="fa-solid fa-tag"></i></span>
        <span>Brand Management</span>
      </a>

      <div class="sb-group-label">Proses Konten</div>
      <a class="sb-item" href="/production">
        <span class="icon-wrap"><i class="fa-solid fa-play"></i></span>
        <span>Production</span>
      </a>
      <a class="sb-item" href="/revision">
        <span class="icon-wrap"><i class="fa-solid fa-rotate-left"></i></span>
        <span>Revision</span>
        @if($notifRevision > 0)<span class="sb-badge">{{ $notifRevision }}</span>@endif
      </a>
      <a class="sb-item" href="/publishing">
        <span class="icon-wrap"><i class="fa-solid fa-upload"></i></span>
        <span>Publishing</span>
        @if($notifPublish > 0)<span class="sb-badge">{{ $notifPublish }}</span>@endif
      </a>

      <div class="sb-group-label">Laporan</div>
      <a class="sb-item" href="{{ route('analytics.index') }}">
        <span class="icon-wrap"><i class="fa-solid fa-chart-line"></i></span>
        <span>Analytics</span>
      </a>
      <a class="sb-item" href="{{ route('report.index') }}">
        <span class="icon-wrap"><i class="fa-solid fa-file-lines"></i></span>
        <span>Report</span>
      </a>

      <div class="sb-group-label">Lainnya</div>
      <a class="sb-item" href="{{ route('settings.index') }}">
        <span class="icon-wrap"><i class="fa-solid fa-gear"></i></span>
        <span>Settings</span>
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
        <div class="tb-title">Tambah Brand</div>
        <div class="tb-crumb">
          <i class="fa-solid fa-house" style="font-size:10px"></i>
          <i class="fa-solid fa-chevron-right" style="font-size:9px;color:var(--text-300)"></i>
          <a href="{{ route('brands.index') }}" style="color:var(--text-400)">Brand Management</a>
          <i class="fa-solid fa-chevron-right" style="font-size:9px;color:var(--text-300)"></i>
          <span>Tambah Brand</span>
          &nbsp;·&nbsp; <span id="today-date"></span>
        </div>
      </div>
      <div class="tb-right">
        <div class="tb-menu-wrap" style="position:relative;display:inline-block;">
          <button type="button" class="tb-icon-btn" id="tbNotifBtn" title="Notifikasi" aria-expanded="false" aria-haspopup="true" onclick="toggleHeaderMenu(event, 'notifDropdown', this)">
            <i class="fa-regular fa-bell"></i>
            @if(($notifTotal ?? 0) > 0)<span class="tb-notif-dot"></span>@endif
          </button>
          <div class="header-dropdown header-dropdown--wide" id="notifDropdown" style="display:none;">
            <div class="header-dd-head">Notifikasi</div>
            @if($msgTotal > 0)
              @if($deadlineOverdueCount > 0)
                @foreach($deadlineOverdue as $item)
                  <div class="header-dd-item">
                    <div class="header-dd-ic"><i class="fa-solid fa-triangle-exclamation"></i></div>
                    <div class="header-dd-body">
                      <div class="header-dd-title">Deadline Terlewat</div>
                      <div class="header-dd-sub">{{ $item->title }}</div>
                    </div>
                    <div class="header-dd-badge">!</div>
                  </div>
                @endforeach
              @endif
              @if($deadlineSoonCount > 0)
                @foreach($deadlineSoon as $item)
                  <div class="header-dd-item">
                    <div class="header-dd-ic"><i class="fa-solid fa-clock"></i></div>
                    <div class="header-dd-body">
                      <div class="header-dd-title">Deadline Mendekat</div>
                      <div class="header-dd-sub">{{ $item->title }}</div>
                    </div>
                    <div class="header-dd-badge">{{ \Carbon\Carbon::parse(min($item->production_deadline, $item->publish_deadline))->diffInDays() }}h</div>
                  </div>
                @endforeach
              @endif
              @if($notifRevision > 0)
                <div class="header-dd-item">
                  <div class="header-dd-ic"><i class="fa-solid fa-rotate-left"></i></div>
                  <div class="header-dd-body">
                    <div class="header-dd-title">Revisi Diperlukan</div>
                    <div class="header-dd-sub">{{ $notifRevision }} konten butuh revisi</div>
                  </div>
                  <div class="header-dd-badge">{{ $notifRevision }}</div>
                </div>
              @endif
              @if($notifApproval > 0)
                <div class="header-dd-item">
                  <div class="header-dd-ic"><i class="fa-solid fa-eye"></i></div>
                  <div class="header-dd-body">
                    <div class="header-dd-title">Menunggu Approval</div>
                    <div class="header-dd-sub">{{ $notifApproval }} konten menunggu approval</div>
                  </div>
                  <div class="header-dd-badge">{{ $notifApproval }}</div>
                </div>
              @endif
              @if($notifPublish > 0)
                <div class="header-dd-item">
                  <div class="header-dd-ic"><i class="fa-solid fa-upload"></i></div>
                  <div class="header-dd-body">
                    <div class="header-dd-title">Siap Publish</div>
                    <div class="header-dd-sub">{{ $notifPublish }} konten siap dipublish</div>
                  </div>
                  <div class="header-dd-badge">{{ $notifPublish }}</div>
                </div>
              @endif
            @else
              <div class="header-dd-empty">Tidak ada notifikasi baru</div>
            @endif
          </div>
        </div>
        <div class="tb-divider"></div>
        <button type="button" class="tb-avatar-btn" onclick="toggleHeaderMenu(event, 'profileDropdown', this)">{{ auth()->check() ? $authInitials : 'U' }}</button>
        <div class="profile-dropdown" id="profileDropdown" style="display:none;">
          <a class="dropdown-item" href="{{ route('settings.index') }}">
            <i class="fa-solid fa-gear"></i>
            <span>Settings</span>
          </a>
          <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="fa-solid fa-right-from-bracket"></i>
            <span>Logout</span>
          </a>
        </div>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
          @csrf
        </form>
      </div>
    </header>

    <!-- ═══════ CONTENT ═══════ -->
    <div class="content">
      @if(session('error'))
        <div class="alert alert-error">
          <i class="fa-solid fa-exclamation-circle"></i>
          {{ session('error') }}
        </div>
      @endif

      <div class="page-head">
        <h1 class="ph-title">Tambah Brand Baru</h1>
        <div class="ph-actions">
          <a href="{{ route('brands.index') }}" class="btn btn-secondary">
            <i class="fa-solid fa-arrow-left"></i>
            Kembali
          </a>
        </div>
      </div>

      <div class="fcard">
        <div class="fcard-head">
          <div class="fch-l">
            <div class="fch-title">Form Tambah Brand</div>
          </div>
        </div>
        <div class="fcard-body">
          <form action="{{ route('brands.store') }}" method="POST">
            @csrf

            <div class="form-grid">
              <div class="form-group">
                <label class="form-label" for="name">Nama Brand *</label>
                <input type="text" id="name" name="name" class="form-input" value="{{ old('name') }}" required>
                @error('name')
                  <div class="error-message">{{ $message }}</div>
                @enderror
              </div>

              <div class="form-group">
                <label class="form-label" for="pic">PIC (Person In Charge) *</label>
                <input type="text" id="pic" name="pic" class="form-input" value="{{ old('pic') }}" required>
                @error('pic')
                  <div class="error-message">{{ $message }}</div>
                @enderror
              </div>

              <div class="form-group">
                <label class="form-label" for="contact">Kontak *</label>
                <input type="text" id="contact" name="contact" class="form-input" value="{{ old('contact') }}" required>
                @error('contact')
                  <div class="error-message">{{ $message }}</div>
                @enderror
              </div>

              <div class="form-group">
                <label class="form-label" for="status">Status *</label>
                <select id="status" name="status" class="form-input form-select" required>
                  <option value="">Pilih Status</option>
                  <option value="Active" {{ old('status') == 'Active' ? 'selected' : '' }}>Active</option>
                  <option value="Non Active" {{ old('status') == 'Non Active' ? 'selected' : '' }}>Non Active</option>
                </select>
                @error('status')
                  <div class="error-message">{{ $message }}</div>
                @enderror
              </div>

              <div class="form-group full">
                <label class="form-label" for="target_market">Target Market *</label>
                <textarea id="target_market" name="target_market" class="form-input form-textarea" required>{{ old('target_market') }}</textarea>
                @error('target_market')
                  <div class="error-message">{{ $message }}</div>
                @enderror
              </div>

              <div class="form-group full">
                <label class="form-label" for="tone">Tone & Voice *</label>
                <textarea id="tone" name="tone" class="form-input form-textarea" required>{{ old('tone') }}</textarea>
                @error('tone')
                  <div class="error-message">{{ $message }}</div>
                @enderror
              </div>
            </div>

            <div class="form-actions">
              <button type="submit" class="btn btn-primary">
                <i class="fa-solid fa-save"></i>
                Simpan Brand
              </button>
              <a href="{{ route('brands.index') }}" class="btn btn-secondary">Batal</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
function toggleHeaderMenu(event, menuId, button) {
  event.stopPropagation();
  const menu = document.getElementById(menuId);
  const isVisible = menu.style.display === 'block';

  // Hide all dropdowns first
  document.querySelectorAll('.header-dropdown, .profile-dropdown').forEach(d => {
    d.style.display = 'none';
  });

  // Toggle the clicked menu
  menu.style.display = isVisible ? 'none' : 'block';

  // Update aria-expanded
  button.setAttribute('aria-expanded', !isVisible);
}

// Close dropdowns when clicking outside
document.addEventListener('click', function(event) {
  if (!event.target.closest('.tb-menu-wrap')) {
    document.querySelectorAll('.header-dropdown, .profile-dropdown').forEach(d => {
      d.style.display = 'none';
    });
    document.querySelectorAll('[aria-expanded]').forEach(btn => {
      btn.setAttribute('aria-expanded', 'false');
    });
  }
});

// Set today's date
document.getElementById('today-date').textContent = new Date().toLocaleDateString('id-ID', {
  weekday: 'long',
  year: 'numeric',
  month: 'long',
  day: 'numeric'
});
</script>
</body>
</html>