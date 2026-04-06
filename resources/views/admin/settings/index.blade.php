@extends('layouts.admin')

@section('page-title', 'Settings')

@section('content')
<div style="display:flex;align-items:center;justify-content:space-between;gap:14px;flex-wrap:wrap;">
    <div>
        <div style="font-size:20px;font-weight:800;color:var(--text-900);letter-spacing:-.3px;">Settings</div>
        <div style="font-size:12px;color:var(--text-400);margin-top:4px;">Kelola profil akun dan keamanan login.</div>
    </div>
</div>

@if (session('success'))
    <div style="background:rgba(16,185,129,.1);color:#065f46;border:1px solid rgba(16,185,129,.3);border-radius:10px;padding:10px 12px;font-size:13px;">
        <i class="fa-solid fa-circle-check" style="margin-right:6px;"></i>{{ session('success') }}
    </div>
@endif

@if ($errors->any())
    <div style="background:rgba(239,68,68,.1);color:#991b1b;border:1px solid rgba(239,68,68,.3);border-radius:10px;padding:10px 12px;font-size:13px;">
        <i class="fa-solid fa-triangle-exclamation" style="margin-right:6px;"></i>
        Mohon cek kembali data yang diisi.
    </div>
@endif

<form method="POST" action="{{ route('settings.update') }}" class="card" style="padding:18px;border:1px solid var(--border);border-radius:var(--r);background:var(--white);box-shadow:var(--s1);">
    @csrf
    @method('PUT')

    <div id="profil-akun" class="sec-head" style="margin-bottom:16px;scroll-margin-top:88px;">
        <div class="sec-title"><i class="fa-solid fa-user-gear"></i> Profil Akun</div>
    </div>

    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(280px,1fr));gap:14px;">
        <div>
            <label for="name" style="display:block;font-size:12px;font-weight:700;color:var(--text-700);margin-bottom:6px;">Nama</label>
            <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required
                style="width:100%;height:42px;padding:0 12px;border:1.5px solid var(--border);border-radius:10px;outline:none;">
            @error('name')
                <div style="font-size:12px;color:#b91c1c;margin-top:5px;">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="email" style="display:block;font-size:12px;font-weight:700;color:var(--text-700);margin-bottom:6px;">Email</label>
            <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required
                style="width:100%;height:42px;padding:0 12px;border:1.5px solid var(--border);border-radius:10px;outline:none;">
            @error('email')
                <div style="font-size:12px;color:#b91c1c;margin-top:5px;">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div style="margin-top:16px;">
        <label style="display:block;font-size:12px;font-weight:700;color:var(--text-700);margin-bottom:6px;">Role</label>
        <div style="height:42px;display:flex;align-items:center;padding:0 12px;border:1.5px solid var(--border-light);border-radius:10px;background:#f8fbff;color:var(--text-500);font-size:13px;">
            {{ ucfirst($user->role ?? 'user') }}
        </div>
    </div>

    <div id="keamanan-akun" class="sec-head" style="margin:22px 0 12px;scroll-margin-top:88px;">
        <div class="sec-title"><i class="fa-solid fa-lock"></i> Ubah Password</div>
    </div>

    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(280px,1fr));gap:14px;">
        <div>
            <label for="password" style="display:block;font-size:12px;font-weight:700;color:var(--text-700);margin-bottom:6px;">Password Baru</label>
            <input id="password" name="password" type="password"
                style="width:100%;height:42px;padding:0 12px;border:1.5px solid var(--border);border-radius:10px;outline:none;">
            @error('password')
                <div style="font-size:12px;color:#b91c1c;margin-top:5px;">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="password_confirmation" style="display:block;font-size:12px;font-weight:700;color:var(--text-700);margin-bottom:6px;">Konfirmasi Password Baru</label>
            <input id="password_confirmation" name="password_confirmation" type="password"
                style="width:100%;height:42px;padding:0 12px;border:1.5px solid var(--border);border-radius:10px;outline:none;">
        </div>
    </div>

    <div style="font-size:12px;color:var(--text-400);margin-top:8px;">
        Kosongkan password jika tidak ingin mengubah password.
    </div>

    <div style="display:flex;justify-content:flex-end;margin-top:18px;">
        <button type="submit" class="qa-btn qa-1" style="width:auto;text-decoration:none;color:inherit;">
            <div class="qa-ic"><i class="fa-solid fa-floppy-disk"></i></div>
            <div class="qa-text">
                <div class="qa-label">Simpan Perubahan</div>
                <div class="qa-sub">Update profil akun</div>
            </div>
        </button>
    </div>
</form>
@endsection
