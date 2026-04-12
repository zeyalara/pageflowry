@extends('layouts.admin')

@section('page-title', 'Dashboard')

@section('content')
<div style="display:flex;align-items:center;justify-content:space-between;gap:14px;flex-wrap:wrap;">
  <div>
    <div style="font-size:18px;font-weight:800;color:var(--text-900);letter-spacing:-.3px;">Dashboard</div>
    <div style="font-size:12px;color:var(--text-400);margin-top:4px;">
      Data real dari database · Akun: <span style="color:var(--blue);font-weight:600;">{{ $user->email }}</span>
    </div>
  </div>
  <div style="display:flex;gap:10px;flex-wrap:wrap;">
    <button class="qa-btn" style="width:auto;text-decoration:none;color:inherit;background:none;border:none;cursor:pointer;" onclick="openCreateModal()">
      <div class="qa-ic" style="background:linear-gradient(135deg,var(--blue),var(--blue-600));color:#fff;"><i class="fa-solid fa-plus"></i></div>
      <div class="qa-text">
        <div class="qa-label">Buat Tugas Konten</div>
        <div class="qa-sub">Daftar Tugas Konten</div>
      </div>
      <i class="fa-solid fa-chevron-right qa-arr"></i>
    </button>
    <a href="{{ route('brands.index') }}" class="qa-btn" style="width:auto;text-decoration:none;color:inherit;">
      <div class="qa-ic" style="background:linear-gradient(135deg,var(--emerald),#059669);color:#fff;"><i class="fa-solid fa-tag"></i></div>
      <div class="qa-text">
        <div class="qa-label">Brand</div>
        <div class="qa-sub">Kelola brand</div>
      </div>
      <i class="fa-solid fa-chevron-right qa-arr"></i>
    </a>
    <a href="{{ route('publishing.index') }}" class="qa-btn" style="width:auto;text-decoration:none;color:inherit;">
      <div class="qa-ic" style="background:linear-gradient(135deg,var(--amber),#d97706);color:#fff;"><i class="fa-solid fa-paper-plane"></i></div>
      <div class="qa-text">
        <div class="qa-label">Published</div>
        <div class="qa-sub">Lihat konten yang sudah publish</div>
      </div>
      <i class="fa-solid fa-chevron-right qa-arr"></i>
    </a>
  </div>
</div>

<div class="stat-row" style="grid-template-columns:repeat(auto-fit,minmax(200px,1fr));">
  <a class="stat-card sc-blue" style="text-decoration:none;color:inherit;" href="{{ route('content-tasks.index') }}">
    <div class="stat-ic"><i class="fa-solid fa-list-check"></i></div>
    <div class="stat-val">{{ $stats['total_briefs'] ?? 0 }}</div>
    <div class="stat-lbl">Total Tugas (Daftar Tugas Konten)</div>
  </a>
  <a class="stat-card sc-vio" style="text-decoration:none;color:inherit;" href="{{ route('brands.index') }}">
    <div class="stat-ic"><i class="fa-solid fa-tag"></i></div>
    <div class="stat-val">{{ $stats['total_brands'] ?? 0 }}</div>
    <div class="stat-lbl">Total Brand</div>
  </a>
  <a class="stat-card sc-org" style="text-decoration:none;color:inherit;" href="{{ route('production.index') }}">
    <div class="stat-ic"><i class="fa-solid fa-film"></i></div>
    <div class="stat-val">{{ $stats['in_production'] ?? 0 }}</div>
    <div class="stat-lbl">In Production</div>
  </a>
  <a class="stat-card sc-vio" style="text-decoration:none;color:inherit;" href="{{ route('revision.index') }}">
    <div class="stat-ic"><i class="fa-solid fa-eye"></i></div>
    <div class="stat-val">{{ $stats['under_review'] ?? 0 }}</div>
    <div class="stat-lbl">Under Review</div>
  </a>
  <a class="stat-card sc-red" style="text-decoration:none;color:inherit;" href="{{ route('revision.index') }}">
    <div class="stat-ic"><i class="fa-solid fa-triangle-exclamation"></i></div>
    <div class="stat-val">{{ $stats['need_revision'] ?? 0 }}</div>
    <div class="stat-lbl">Need Revision</div>
  </a>
  <a class="stat-card sc-amb" style="text-decoration:none;color:inherit;" href="{{ route('publishing.index') }}">
    <div class="stat-ic"><i class="fa-solid fa-paper-plane"></i></div>
    <div class="stat-val">{{ $stats['ready_to_publish'] ?? 0 }}</div>
    <div class="stat-lbl">Ready to Publish</div>
  </a>
  <a class="stat-card sc-em" style="text-decoration:none;color:inherit;" href="{{ route('publishing.index') }}">
    <div class="stat-ic"><i class="fa-solid fa-circle-check"></i></div>
    <div class="stat-val">{{ $stats['published'] ?? 0 }}</div>
    <div class="stat-lbl">Published</div>
  </a>
      </div>

<div class="table-row" style="grid-template-columns:repeat(auto-fit,minmax(340px,1fr));">
      <div class="card tbl-card">
        <div class="sec-head" style="margin-bottom:0">
          <div class="sec-title"><i class="fa-solid fa-calendar-xmark"></i> Deadline Produksi Terdekat</div>
      <a class="sec-link" href="{{ route('content-tasks.index') }}">Semua <i class="fa-solid fa-arrow-right" style="font-size:10px"></i></a>
        </div>
        <table>
          <thead>
            <tr>
              <th>Judul Konten</th>
              <th>Deadline</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
        @forelse ($upcomingProduction as $row)
          <tr>
            <td>
              <span class="td-name">{{ $row->title }}</span>
              <span class="td-brand">{{ $row->brand->name ?? 'No Brand' }}</span>
            </td>
            <td class="td-date">
              <i class="fa-regular fa-calendar"></i>
              {{ optional($row->production_deadline)->format('d M Y') }}
            </td>
            <td>
              @php
                $s = $row->status ?? '';
                $pill = match ($s) {
                  'In Production' => 'p-prod',
                  'Under Review' => 'p-review',
                  'Need Revision' => 'p-revision',
                  'Ready to Publish' => 'p-ready',
                  'Published' => 'p-pub',
                  default => 'p-prod',
                };
              @endphp
              <span class="pill {{ $pill }}"><span class="pill-dot"></span>{{ $s ?: '-' }}</span>
            </td>
            </tr>
        @empty
          <tr><td colspan="3" style="color:var(--text-400);padding:14px 10px;">Belum ada data.</td></tr>
        @endforelse
          </tbody>
        </table>
      </div>

      <div class="card tbl-card">
        <div class="sec-head" style="margin-bottom:0">
          <div class="sec-title"><i class="fa-solid fa-paper-plane"></i> Jadwal Publish Terdekat</div>
      <a class="sec-link" href="{{ route('publishing.index') }}">Semua <i class="fa-solid fa-arrow-right" style="font-size:10px"></i></a>
        </div>
        <table>
          <thead>
            <tr>
              <th>Judul Konten</th>
              <th>Tanggal</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
        @forelse ($upcomingPublish as $row)
          <tr>
            <td>
              <span class="td-name">{{ $row->title }}</span>
              <span class="td-brand">{{ $row->brand->name ?? 'No Brand' }}</span>
            </td>
            <td class="td-date">
              <i class="fa-regular fa-calendar"></i>
              {{ optional($row->publish_deadline)->format('d M Y') }}
            </td>
            <td>
              @php
                $s = $row->status ?? '';
                $pill = match ($s) {
                  'Ready to Publish' => 'p-ready',
                  'Published' => 'p-pub',
                  'Need Revision' => 'p-revision',
                  'Under Review' => 'p-review',
                  'In Production' => 'p-prod',
                  default => 'p-ready',
                };
              @endphp
              <span class="pill {{ $pill }}"><span class="pill-dot"></span>{{ $s ?: '-' }}</span>
            </td>
            </tr>
        @empty
          <tr><td colspan="3" style="color:var(--text-400);padding:14px 10px;">Belum ada data.</td></tr>
        @endforelse
          </tbody>
        </table>
      </div>
    </div>

<div class="bottom-row" style="grid-template-columns:repeat(auto-fit,minmax(340px,1fr));">
      <div class="card act-card">
        <div class="sec-head" style="margin-bottom:0">
      <div class="sec-title"><i class="fa-solid fa-clock-rotate-left"></i> Aktivitas Terbaru (DB)</div>
      <a class="sec-link" href="{{ route('content-tasks.index') }}">Semua <i class="fa-solid fa-arrow-right" style="font-size:10px"></i></a>
        </div>
        <div class="act-list">
      @forelse ($recentUploads as $p)
          <div class="act-item">
            <div class="act-dot ad-blue"><i class="fa-solid fa-cloud-arrow-up"></i></div>
            <div class="act-body">
            <div class="act-name">Upload video</div>
            <div class="act-detail">
              {{ $p->contentTask->judul_konten ?? '-' }}
              · {{ $p->contentTask->brand->name ?? 'No Brand' }}
              @if($p->versi_video) · v{{ $p->versi_video }} @endif
            </div>
          </div>
          <div class="act-time">{{ optional($p->created_at)->diffForHumans() }}</div>
            </div>
      @empty
        @forelse ($recentBriefs as $b)
          <div class="act-item">
            <div class="act-dot ad-vio"><i class="fa-solid fa-file-circle-plus"></i></div>
            <div class="act-body">
              <div class="act-name">Brief dibuat</div>
              <div class="act-detail">{{ $b->title }} · {{ $b->brand->name ?? 'No Brand' }}</div>
            </div>
            <div class="act-time">{{ optional($b->created_at)->diffForHumans() }}</div>
          </div>
        @empty
          <div style="color:var(--text-400);padding:12px 8px;">Belum ada aktivitas.</div>
        @endforelse
      @endforelse
        </div>
      </div>

      <div class="card qa-card">
    <div class="sec-title"><i class="fa-solid fa-bolt"></i> Quick Links</div>
        <div class="qa-list">
      <a class="qa-btn qa-1" href="{{ route('content-tasks.index') }}" style="text-decoration:none;color:inherit;">
            <div class="qa-ic"><i class="fa-solid fa-plus"></i></div>
            <div class="qa-text">
              <div class="qa-label">Konten</div>
          <div class="qa-sub">Daftar Tugas Konten</div>
            </div>
            <i class="fa-solid fa-chevron-right qa-arr"></i>
      </a>
      <a class="qa-btn qa-2" href="{{ route('brands.index') }}" style="text-decoration:none;color:inherit;">
            <div class="qa-ic"><i class="fa-solid fa-tag"></i></div>
            <div class="qa-text">
          <div class="qa-label">Brand Management</div>
          <div class="qa-sub">Tambah & kelola brand</div>
            </div>
            <i class="fa-solid fa-chevron-right qa-arr"></i>
      </a>
      <a class="qa-btn qa-3" href="{{ route('publishing.index') }}" style="text-decoration:none;color:inherit;">
        <div class="qa-ic"><i class="fa-solid fa-paper-plane"></i></div>
            <div class="qa-text">
          <div class="qa-label">Publishing</div>
          <div class="qa-sub">Konten siap publish</div>
            </div>
            <i class="fa-solid fa-chevron-right qa-arr"></i>
      </a>
        </div>
              </div>
            </div>

<!-- MODAL STRUCTURE -->
<style>
/* Modal Styles - Fixed z-index and centering for sidebar */
.overlay{
  position:fixed;top:0;left:0;width:100%;height:100%;
  background:rgba(0,0,0,0.4);backdrop-filter:blur(4px);
  opacity:0;pointer-events:none;transition:opacity .25s;
  z-index:9999;
  display: flex;
  align-items: center;
  justify-content: center;
  padding:20px;
}
.overlay.open{opacity:1;pointer-events:all}
.modal{
  background:var(--white);border-radius:20px;width:100%;
  box-shadow:0 8px 40px rgba(88,151,254,.20),0 0 0 1px rgba(88,151,254,.08);
  transform:scale(.97);
  transition:transform .3s cubic-bezier(.34,1.56,.64,1),opacity .25s;
  opacity:0;max-height:90vh;overflow-y:auto;
  position:relative;z-index:10000;
  margin: auto;
}
.overlay.open .modal{transform:scale(1);opacity:1}

/* Wizard Modal */
.wiz-modal{max-width:800px}
.wiz-prog{padding:26px 28px 0;display:flex;align-items:flex-start}
.wstep{flex:1;display:flex;flex-direction:column;align-items:center;position:relative}
.wstep:not(:last-child)::after{
  content:'';position:absolute;top:20px;left:50%;width:100%;height:2px;
  background:var(--border);z-index:1
}
.wstep::before{content:attr(data-step);width:40px;height:40px;border-radius:50%;background:var(--border);border:2px solid var(--border);display:flex;align-items:center;justify-content:center;font-weight:700;font-size:14px;color:var(--text-400);transition:var(--tr);z-index:2}
.wstep.active::before{background:var(--blue);border-color:var(--blue);color:#fff}
.wstep.done::before{background:var(--emerald);border-color:var(--emerald);color:#fff}
.wstep-label{margin-top:8px;font-size:12px;font-weight:600;color:var(--text-500);text-align:center;white-space:nowrap}

.mhd{padding:20px 28px;display:flex;align-items:flex-start;justify-content:space-between}
.meyebrow{font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.8px;color:var(--text-400);display:flex;align-items:center;gap:6px}
.mtitle{font-size:22px;font-weight:800;color:var(--text-900);letter-spacing:-.4px;margin-top:4px}
.msub{font-size:13px;color:var(--text-500);margin-top:6px}
.mclose{width:32px;height:32px;border-radius:8px;border:none;background:var(--text-100);color:var(--text-500);cursor:pointer;transition:var(--tr);display:flex;align-items:center;justify-content:center}
.mclose:hover{background:var(--text-200);color:var(--text-700)}

.mbody{padding:0 28px 28px}
.spanel{display:none}
.spanel.show{display:block}
.shd{display:flex;align-items:flex-start;gap:12px;margin-bottom:20px}
.shd-bar{width:4px;height:24px;background:var(--blue);border-radius:2px;flex-shrink:0}
.shd-title{font-size:16px;font-weight:700;color:var(--text-900);margin-bottom:2px}
.shd-sub{font-size:13px;color:var(--text-500)}

.fg{margin-bottom:20px}
.fg3{display:grid;grid-template-columns:1fr 1fr 1fr;gap:16px}
.flbl{display:block;font-size:13px;font-weight:600;color:var(--text-700);margin-bottom:6px}
.req{color:var(--rose)}
.ftxt{width:100%;padding:10px 14px;border:1.5px solid var(--border);border-radius:var(--r-sm);font-family:'DM Sans',sans-serif;font-size:13px;color:var(--text-900);resize:none;outline:none;transition:var(--tr)}
.ftxt:focus{border-color:var(--blue);box-shadow:0 0 0 3px rgba(88,151,254,.12)}
.char-cnt{font-size:11px;color:var(--text-400);margin-top:4px;text-align:right}
.ferr{font-size:12px;color:var(--rose);margin-top:4px;display:none}
.ferr.show{display:block}

.ico-wrap{position:relative}
.ico-wrap i{position:absolute;left:14px;top:50%;transform:translateY(-50%);color:var(--text-400);font-size:13px}
.finp{width:100%;padding:10px 14px 10px 38px;border:1.5px solid var(--border);border-radius:var(--r-sm);font-family:'DM Sans',sans-serif;font-size:13px;color:var(--text-900);outline:none;transition:var(--tr)}
.finp:focus{border-color:var(--blue);box-shadow:0 0 0 3px rgba(88,151,254,.12)}
.fsel-f{width:100%;padding:10px 14px;border:1.5px solid var(--border);border-radius:var(--r-sm);font-family:'DM Sans',sans-serif;font-size:13px;color:var(--text-900);outline:none;transition:var(--tr);appearance:none;background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6'%3E%3Cpath d='M0 0l5 6 5-6z' fill='%238fa3c4'/%3E%3C/svg%3E");background-repeat:no-repeat;background-position:right 12px center}
.fsel-f:focus{border-color:var(--blue);box-shadow:0 0 0 3px rgba(88,151,254,.12)}

.mfoot{padding:20px 28px 28px;border-top:1px solid var(--border);display:flex;align-items:center;justify-content:space-between}
.mfoot-btns{display:flex;gap:9px}

/* Button Styles */
.btn{
  display:inline-flex;align-items:center;gap:7px;padding:0 18px;height:40px;
  border-radius:var(--r-sm);font-family:'DM Sans',sans-serif;
  font-size:13.5px;font-weight:600;cursor:pointer;transition:var(--tr);
  border:none;outline:none;white-space:nowrap;
}
.btn-primary{background:linear-gradient(135deg,var(--blue),var(--blue-600));color:#fff;box-shadow:0 3px 12px rgba(88,151,254,.35)}
.btn-primary:hover{transform:translateY(-2px);box-shadow:0 6px 20px rgba(88,151,254,.4)}
.btn-primary:active{transform:scale(.97)}
.btn-ghost{background:var(--white);color:var(--text-500);border:1.5px solid var(--border)}
.btn-ghost:hover{background:var(--blue-50);color:var(--blue);border-color:var(--blue-200)}
.btn-ghost:active{transform:scale(.97)}
</style>

<!-- MODAL - CREATE/EDIT BRIEF (7-Step Wizard) -->
<div class="overlay" id="ovWizard" onclick="bgClose(event,'ovWizard')">
<div class="modal wiz-modal" onclick="event.stopPropagation()">

  <!-- Progress Bar -->
  <div class="wiz-prog" id="wizProg"></div>

  <!-- Header -->
  <div class="mhd" style="margin-top:20px">
    <div>
      <div class="meyebrow"><i class="fa-solid fa-file-pen"></i> <span id="wizEyebrow">Create Brief</span></div>
      <div class="mtitle" id="wizTitle">Buat Tugas Konten Baru</div>
      <div class="msub">Langkah <b id="wizStepNum">1</b> dari 7 - <span id="wizStepName">Deskripsi Tugas</span></div>
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
        <textarea class="ftxt" id="fDesc" rows="7" placeholder="Contoh: Membuat konten video edukasi skincare singkat berdurasi 30-60 detik untuk platform TikTok. Fokus pada manfaat serum Vitamin C brand GlowSkin. Tone komunikasi friendly dan relatable untuk audiens usia 18-30 tahun yang aktif di media sosial..."></textarea>
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
      </div>
      <div class="fg">
        <label class="flbl">Durasi Target <span class="req">*</span></label>
        <div class="ico-wrap"><i class="fa-solid fa-stopwatch"></i>
          <input class="finp" id="fDuration" type="text" placeholder="Contoh: 30-60 detik"/>
        </div>
        <div class="ferr" id="eDuration">Durasi target wajib diisi.</div>
      </div>
    </div>

    <!-- Add remaining steps 3-7 here... -->
    <!-- STEP 3: Deadline & Timeline -->
    <div class="spanel" id="sp3">
      <div class="shd">
        <div class="shd-bar"></div>
        <div>
          <div class="shd-title">Deadline & Timeline</div>
          <div class="shd-sub">Set timeline untuk produksi dan publishing</div>
        </div>
      </div>
      <div class="fg3">
        <div class="fg">
          <label class="flbl">Deadline Produksi <span class="req">*</span></label>
          <input class="finp" id="fProdDeadline" type="date"/>
          <div class="ferr" id="eProdDeadline">Deadline produksi wajib diisi.</div>
        </div>
        <div class="fg">
          <label class="flbl">Deadline Publish <span class="req">*</span></label>
          <input class="finp" id="fPubDeadline" type="date"/>
          <div class="ferr" id="ePubDeadline">Deadline publish wajib diisi.</div>
        </div>
      </div>
    </div>

    <!-- STEP 4: Target Audience -->
    <div class="spanel" id="sp4">
      <div class="shd">
        <div class="shd-bar"></div>
        <div>
          <div class="shd-title">Target Audience</div>
          <div class="shd-sub">Siapa target audiens untuk konten ini?</div>
        </div>
      </div>
      <div class="fg">
        <label class="flbl">Target Audience <span class="req">*</span></label>
        <textarea class="ftxt" id="fTargetAudience" rows="4" placeholder="Contoh: Wanita usia 18-30 tahun, tinggal di kota besar, interest dalam skincare routine, aktif di TikTok dan Instagram..."></textarea>
        <div class="ferr" id="eTargetAudience">Target audience wajib diisi.</div>
      </div>
    </div>

    <!-- STEP 5: Key Message -->
    <div class="spanel" id="sp5">
      <div class="shd">
        <div class="shd-bar"></div>
        <div>
          <div class="shd-title">Key Message</div>
          <div class="shd-sub">Pesan utama yang ingin disampaikan</div>
        </div>
      </div>
      <div class="fg">
        <label class="flbl">Key Message <span class="req">*</span></label>
        <textarea class="ftxt" id="fKeyMessage" rows="4" placeholder="Contoh: Serum Vitamin C GlowSkin membantu mencerahkan kulit dan mengurangi dark spots dalam 2 minggu..."></textarea>
        <div class="ferr" id="eKeyMessage">Key message wajib diisi.</div>
      </div>
    </div>

    <!-- STEP 6: Visual Direction -->
    <div class="spanel" id="sp6">
      <div class="shd">
        <div class="shd-bar"></div>
        <div>
          <div class="shd-title">Visual Direction</div>
          <div class="shd-sub">Arahan visual untuk produksi konten</div>
        </div>
      </div>
      <div class="fg">
        <label class="flbl">Visual Direction <span class="req">*</span></label>
        <textarea class="ftxt" id="fVisualDirection" rows="4" placeholder="Contoh: Background clean dengan produk sebagai focal point. Lighting bright dan natural. Color palette soft pastel..."></textarea>
        <div class="ferr" id="eVisualDirection">Visual direction wajib diisi.</div>
      </div>
    </div>

    <!-- STEP 7: Assignment -->
    <div class="spanel" id="sp7">
      <div class="shd">
        <div class="shd-bar"></div>
        <div>
          <div class="shd-title">Assignment</div>
          <div class="shd-sub">Assign ke creator (opsional)</div>
        </div>
      </div>
      <div class="fg">
        <label class="flbl">Email Creator</label>
        <div class="ico-wrap"><i class="fa-solid fa-envelope"></i>
          <input class="finp" id="fCreatorEmail" type="email" placeholder="opsional"/>
        </div>
      </div>
    </div>

  </div>

  <div class="mfoot">
    <div></div>
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

<script>
// Modal Functions - Copy from brief/index.blade.php
let wizStep = 1;
const TOTAL_STEPS = 7;
const STEP_NAMES = ['Deskripsi Tugas', 'Informasi Dasar', 'Deadline & Timeline', 'Target Audience', 'Key Message', 'Visual Direction', 'Assignment'];

function openCreateModal() {
  wizStep = 1;
  resetForm();
  updateWizard();
  openModal('ovWizard');
}

function openModal(id) {
  document.getElementById(id).classList.add('open');
  document.body.style.overflow = 'hidden';
}

function closeModal(id) {
  document.getElementById(id).classList.remove('open');
  document.body.style.overflow = '';
}

function bgClose(e, id) {
  if (e.target === e.currentTarget) closeModal(id);
}

function updateWizard() {
  // Update progress bar
  const prog = document.getElementById('wizProg');
  prog.innerHTML = '';
  for (let i = 1; i <= TOTAL_STEPS; i++) {
    const step = document.createElement('div');
    step.className = 'wstep';
    step.setAttribute('data-step', i);
    if (i < wizStep) step.classList.add('done');
    if (i === wizStep) step.classList.add('active');
    step.innerHTML = `<div class="wstep-label">${STEP_NAMES[i-1]}</div>`;
    prog.appendChild(step);
  }
  
  // Update panels
  document.querySelectorAll('.spanel').forEach(p => p.classList.remove('show'));
  document.getElementById(`sp${wizStep}`).classList.add('show');
  
  // Update header
  document.getElementById('wizStepNum').textContent = wizStep;
  document.getElementById('wizStepName').textContent = STEP_NAMES[wizStep-1];
  
  // Update buttons
  document.getElementById('btnPrev').style.display = wizStep === 1 ? 'none' : 'block';
  const btnNext = document.getElementById('btnNext');
  btnNext.innerHTML = wizStep === TOTAL_STEPS ? 
    '<i class="fa-solid fa-check"></i> Simpan' : 
    'Selanjutnya <i class="fa-solid fa-arrow-right"></i>';
}

function wizNext() {
  if (validateStep()) {
    if (wizStep === TOTAL_STEPS) {
      submitForm();
    } else {
      wizStep++;
      updateWizard();
    }
  }
}

function wizPrev() {
  wizStep--;
  updateWizard();
}

function validateStep() {
  let valid = true;
  const currentPanel = document.getElementById(`sp${wizStep}`);
  currentPanel.querySelectorAll('.req').forEach(req => {
    const field = req.closest('.fg').querySelector('input, textarea, select');
    if (!field.value.trim()) {
      const errId = 'e' + field.id.substring(1);
      document.getElementById(errId).classList.add('show');
      valid = false;
    }
  });
  return valid;
}

function resetForm() {
  document.querySelectorAll('.ftxt, .finp, .fsel-f').forEach(field => field.value = '');
  document.querySelectorAll('.ferr').forEach(err => err.classList.remove('show'));
}

function submitForm() {
  // Create a hidden form and submit it
  const form = document.createElement('form');
  form.method = 'POST';
  form.action = '{{ route("content-tasks.store") }}';
  
  // Add CSRF token
  const csrfInput = document.createElement('input');
  csrfInput.type = 'hidden';
  csrfInput.name = '_token';
  csrfInput.value = '{{ csrf_token() }}';
  form.appendChild(csrfInput);
  
  // Add form fields
  const fields = {
    'description': document.getElementById('fDesc').value,
    'title': document.getElementById('fTitle').value,
    'brand_id': document.getElementById('fBrand').value,
    'platform': document.getElementById('fPlatform').value,
    'content_format': document.getElementById('fFormat').value,
    'target_duration': document.getElementById('fDuration').value,
    'production_deadline': document.getElementById('fProdDeadline').value,
    'publish_deadline': document.getElementById('fPubDeadline').value,
    'target_audience': document.getElementById('fTargetAudience').value,
    'key_message': document.getElementById('fKeyMessage').value,
    'visual_direction': document.getElementById('fVisualDirection').value,
    'creator_email': document.getElementById('fCreatorEmail').value
  };
  
  Object.keys(fields).forEach(key => {
    const input = document.createElement('input');
    input.type = 'hidden';
    input.name = key;
    input.value = fields[key];
    form.appendChild(input);
  });
  
  // Submit the form
  document.body.appendChild(form);
  form.submit();
}

// Format options based on platform
function updateFormatOptions() {
  const platform = document.getElementById('fPlatform').value;
  const formatSelect = document.getElementById('fFormat');
  
  formatSelect.innerHTML = '<option value="">Pilih format...</option>';
  
  const formats = {
    'Instagram': ['Reels', 'Story', 'Post', 'Carousel'],
    'TikTok': ['Video', 'Story'],
    'YouTube': ['Shorts', 'Video'],
    'Lainnya': ['Video', 'Image', 'Carousel', 'Story']
  };
  
  if (platform && formats[platform]) {
    formats[platform].forEach(format => {
      const option = document.createElement('option');
      option.value = format;
      option.textContent = format;
      formatSelect.appendChild(option);
    });
  }
}

// Character counter
document.getElementById('fDesc')?.addEventListener('input', function() {
  const count = this.value.length;
  document.getElementById('ccDesc').textContent = `${count} / 500 karakter`;
});

// ESC key to close modal
document.addEventListener('keydown', e => {
  if (e.key === 'Escape') {
    const openModal = document.querySelector('.overlay.open');
    if (openModal) closeModal(openModal.id);
  }
});
</script>

@endsection

