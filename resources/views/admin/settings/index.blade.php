@extends('layouts.admin')

@section('page-title', 'System Settings')

@section('content')
<div class="page-header">
    <h1>System Settings</h1>
    <p>Konfigurasi sistem dan pengaturan aplikasi</p>
</div>

<div class="content-grid">
    <div class="content-card">
        <div class="card-header">
            <h3>General Settings</h3>
        </div>
        <div class="card-body">
            <form class="settings-form">
                <div class="form-group">
                    <label for="app-name">Application Name</label>
                    <input type="text" id="app-name" class="form-control" value="Pageflowry">
                </div>
                <div class="form-group">
                    <label for="app-email">Admin Email</label>
                    <input type="email" id="app-email" class="form-control" value="admin@pageflowry.com">
                </div>
                <div class="form-group">
                    <label for="timezone">Timezone</label>
                    <select id="timezone" class="form-control">
                        <option value="Asia/Jakarta" selected>Asia/Jakarta (GMT+7)</option>
                        <option value="Asia/Singapore">Asia/Singapore (GMT+8)</option>
                        <option value="UTC">UTC (GMT+0)</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="date-format">Date Format</label>
                    <select id="date-format" class="form-control">
                        <option value="Y-m-d" selected>2024-01-15</option>
                        <option value="d/m/Y">15/01/2024</option>
                        <option value="m/d/Y">01/15/2024</option>
                    </select>
                </div>
            </form>
        </div>
    </div>

    <div class="content-card">
        <div class="card-header">
            <h3>Notification Settings</h3>
        </div>
        <div class="card-body">
            <form class="settings-form">
                <div class="form-group">
                    <label class="checkbox-label">
                        <input type="checkbox" checked>
                        <span class="checkmark"></span>
                        Email notifications for new content
                    </label>
                </div>
                <div class="form-group">
                    <label class="checkbox-label">
                        <input type="checkbox" checked>
                        <span class="checkmark"></span>
                        Email notifications for approval requests
                    </label>
                </div>
                <div class="form-group">
                    <label class="checkbox-label">
                        <input type="checkbox">
                        <span class="checkmark"></span>
                        SMS notifications
                    </label>
                </div>
                <div class="form-group">
                    <label class="checkbox-label">
                        <input type="checkbox" checked>
                        <span class="checkmark"></span>
                        Push notifications
                    </label>
                </div>
            </form>
        </div>
    </div>

    <div class="content-card">
        <div class="card-header">
            <h3>Security Settings</h3>
        </div>
        <div class="card-body">
            <form class="settings-form">
                <div class="form-group">
                    <label for="session-timeout">Session Timeout (minutes)</label>
                    <input type="number" id="session-timeout" class="form-control" value="120">
                </div>
                <div class="form-group">
                    <label class="checkbox-label">
                        <input type="checkbox" checked>
                        <span class="checkmark"></span>
                        Require strong passwords
                    </label>
                </div>
                <div class="form-group">
                    <label class="checkbox-label">
                        <input type="checkbox" checked>
                        <span class="checkmark"></span>
                        Two-factor authentication
                    </label>
                </div>
                <div class="form-group">
                    <label class="checkbox-label">
                        <input type="checkbox">
                        <span class="checkmark"></span>
                        IP whitelist
                    </label>
                </div>
            </form>
        </div>
    </div>

    <div class="content-card">
        <div class="card-header">
            <h3>Backup Settings</h3>
        </div>
        <div class="card-body">
            <form class="settings-form">
                <div class="form-group">
                    <label for="backup-frequency">Backup Frequency</label>
                    <select id="backup-frequency" class="form-control">
                        <option value="daily">Daily</option>
                        <option value="weekly" selected>Weekly</option>
                        <option value="monthly">Monthly</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="backup-retention">Retention Period (days)</label>
                    <input type="number" id="backup-retention" class="form-control" value="30">
                </div>
                <div class="form-group">
                    <label class="checkbox-label">
                        <input type="checkbox" checked>
                        <span class="checkmark"></span>
                        Auto backup enabled
                    </label>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="form-actions">
    <button class="btn btn-primary">
        <i class="fa-solid fa-save"></i>
        Save Settings
    </button>
    <button class="btn btn-ghost">
        <i class="fa-solid fa-undo"></i>
        Reset to Default
    </button>
</div>
@endsection
