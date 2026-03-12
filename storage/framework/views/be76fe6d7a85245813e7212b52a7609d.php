<?php $__env->startSection('page-title', 'Analytics Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <h1>Analytics Dashboard</h1>
    <p>Analisis performa konten dan engagement</p>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon" style="background: rgba(88, 151, 254, 0.1); color: var(--blue);">
            <i class="fa-solid fa-eye"></i>
        </div>
        <div class="stat-content">
            <div class="stat-number">1.2M</div>
            <div class="stat-label">Total Views</div>
            <div class="stat-change positive">+12.5%</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background: rgba(16, 185, 129, 0.1); color: var(--emerald);">
            <i class="fa-solid fa-heart"></i>
        </div>
        <div class="stat-content">
            <div class="stat-number">89.5K</div>
            <div class="stat-label">Total Likes</div>
            <div class="stat-change positive">+8.3%</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background: rgba(139, 92, 246, 0.1); color: var(--violet);">
            <i class="fa-solid fa-share"></i>
        </div>
        <div class="stat-content">
            <div class="stat-number">23.7K</div>
            <div class="stat-label">Total Shares</div>
            <div class="stat-change positive">+15.2%</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background: rgba(245, 158, 11, 0.1); color: var(--amber);">
            <i class="fa-solid fa-percentage"></i>
        </div>
        <div class="stat-content">
            <div class="stat-number">7.4%</div>
            <div class="stat-label">Engagement Rate</div>
            <div class="stat-change positive">+2.1%</div>
        </div>
    </div>
</div>

<div class="content-grid">
    <div class="content-card">
        <div class="card-header">
            <h3>Performa Platform</h3>
        </div>
        <div class="card-body">
            <div class="platform-stats">
                <div class="platform-item">
                    <div class="platform-icon ig">
                        <i class="fa-brands fa-instagram"></i>
                    </div>
                    <div class="platform-info">
                        <div class="platform-name">Instagram</div>
                        <div class="platform-views">523K views</div>
                    </div>
                </div>
                <div class="platform-item">
                    <div class="platform-icon tt">
                        <i class="fa-brands fa-tiktok"></i>
                    </div>
                    <div class="platform-info">
                        <div class="platform-name">TikTok</div>
                        <div class="platform-views">892K views</div>
                    </div>
                </div>
                <div class="platform-item">
                    <div class="platform-icon yt">
                        <i class="fa-brands fa-youtube"></i>
                    </div>
                    <div class="platform-info">
                        <div class="platform-name">YouTube</div>
                        <div class="platform-views">234K views</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="content-card">
        <div class="card-header">
            <h3>Top Performing Content</h3>
        </div>
        <div class="card-body">
            <div class="content-list">
                <div class="content-item">
                    <div class="content-rank">1</div>
                    <div class="content-info">
                        <div class="content-title">Summer Campaign 2024</div>
                        <div class="content-metrics">245K views • 12.3K likes</div>
                    </div>
                </div>
                <div class="content-item">
                    <div class="content-rank">2</div>
                    <div class="content-info">
                        <div class="content-title">Product Launch Teaser</div>
                        <div class="content-metrics">189K views • 8.7K likes</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp444\htdocs\laravel\pageflowry\resources\views/admin/analytics/index.blade.php ENDPATH**/ ?>