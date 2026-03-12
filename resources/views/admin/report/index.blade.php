@extends('layouts.admin')

@section('page-title', 'Report Management')

@section('content')
<div class="page-header">
    <h1>Report Management</h1>
    <p>Generate dan download laporan performa konten</p>
</div>

<div class="content-card">
    <div class="card-header">
        <h3>Generate Report</h3>
    </div>
    <div class="card-body">
        <form class="report-form">
            <div class="form-row">
                <div class="form-group">
                    <label for="report-type">Tipe Report</label>
                    <select id="report-type" class="form-control">
                        <option value="">Pilih Tipe Report</option>
                        <option value="monthly">Bulanan</option>
                        <option value="quarterly">Kuartalan</option>
                        <option value="yearly">Tahunan</option>
                        <option value="custom">Custom Range</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="date-from">Dari Tanggal</label>
                    <input type="date" id="date-from" class="form-control">
                </div>
                <div class="form-group">
                    <label for="date-to">Sampai Tanggal</label>
                    <input type="date" id="date-to" class="form-control">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="platform">Platform</label>
                    <select id="platform" class="form-control">
                        <option value="">Semua Platform</option>
                        <option value="instagram">Instagram</option>
                        <option value="tiktok">TikTok</option>
                        <option value="youtube">YouTube</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="brand">Brand</label>
                    <select id="brand" class="form-control">
                        <option value="">Semua Brand</option>
                        <option value="brand-a">Brand A</option>
                        <option value="brand-b">Brand B</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="format">Format</label>
                    <select id="format" class="form-control">
                        <option value="pdf">PDF</option>
                        <option value="excel">Excel</option>
                        <option value="csv">CSV</option>
                    </select>
                </div>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="fa-solid fa-file-download"></i>
                    Generate Report
                </button>
                <button type="button" class="btn btn-ghost">
                    <i class="fa-solid fa-refresh"></i>
                    Reset
                </button>
            </div>
        </form>
    </div>
</div>

<div class="content-card">
    <div class="card-header">
        <h3>Recent Reports</h3>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Nama Report</th>
                        <th>Tipe</th>
                        <th>Period</th>
                        <th>Generated</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Monthly Performance Report</td>
                        <td>Bulanan</td>
                        <td>Jan 2024</td>
                        <td>2024-01-31 15:30</td>
                        <td><span class="status-badge success">Completed</span></td>
                        <td>
                            <button class="btn btn-sm btn-primary">Download</button>
                        </td>
                    </tr>
                    <tr>
                        <td>Q4 2023 Summary</td>
                        <td>Kuartalan</td>
                        <td>Oct-Dec 2023</td>
                        <td>2024-01-02 10:15</td>
                        <td><span class="status-badge success">Completed</span></td>
                        <td>
                            <button class="btn btn-sm btn-primary">Download</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
