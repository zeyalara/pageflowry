@extends('layouts.admin')

@section('page-title', 'Brand Management')

@section('content')
<div class="page-header">
    <h1>Brand Management</h1>
    <p>Kelola daftar brand dan informasi PIC</p>
</div>

<div class="content-card">
    <div class="card-header">
        <h3>Daftar Brand</h3>
        <div class="card-actions">
            <button class="btn btn-primary">
                <i class="fa-solid fa-plus"></i>
                Tambah Brand
            </button>
        </div>
    </div>
    <div class="card-body">
        <p>Halaman Brand Management berfungsi dengan baik.</p>
        <p>Sidebar navigation harus berfungsi:</p>
        <ul>
            <li>Dashboard → <a href="{{ route('admin.dashboard') }}">Test Dashboard</a></li>
            <li>Daftar Tugas Konten → <a href="{{ route('content-tasks.index') }}">Test Brief</a></li>
            <li>Production → <a href="{{ route('production.index') }}">Test Production</a></li>
        </ul>
    </div>
</div>
@endsection
