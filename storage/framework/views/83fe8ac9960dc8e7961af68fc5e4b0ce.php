<?php $__env->startSection('page-title','Dashboard'); ?>

<?php $__env->startSection('content'); ?>

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
              <td><span class="pill p-review"><span class="pill-dot"></span>Under Review</span></td>
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
              <td><span class="pill p-review"><span class="pill-dot"></span>Under Review</span></td>
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
              <td><span class="pill p-review"><span class="pill-dot"></span>Under Review</span></td>
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

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\pageflowry\resources\views/dashboard/admin.blade.php ENDPATH**/ ?>