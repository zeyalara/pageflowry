@extends('layouts.admin')

@section('page-title', 'Buat Tugas Konten')

@section('content')
<div class="tcard">
    <div class="tch-l">
        <div class="tch-title">Buat Tugas Konten</div>
    </div>
    <div class="tch-cnt">
        <div class="sp">
            <div class="btn btn-primary btn-sm" onclick="window.location.href='{{ route('content-tasks.index') }}'">
                <i class="fa-solid fa-arrow-left"></i> Kembali
            </div>
            <div class="btn btn-primary btn-sm">
                <i class="fa-solid fa-save"></i> Simpan
            </div>
        </div>
    </div>
</div>
<div class="tcard">
    <div class="tcard-head">
        <div class="tch-l">
            <div class="tch-title">Form Brief</div>
        </div>
    </div>
    <div class="tcard-body">
        <form id="briefForm" method="POST" action="{{ route('content-tasks.store') }}">
            @csrf
            
            <!-- Informasi Dasar -->
            <div class="mb-4">
                <label class="form-label">Judul Konten <span class="text-danger">*</span></label>
                <input type="text" name="title" class="form-control" required>
            </div>
            
            <div class="mb-4">
                <label class="form-label">Deskripsi</label>
                <textarea name="description" class="form-control" rows="3"></textarea>
            </div>
            
            <div class="mb-4">
                <label class="form-label">Brand <span class="text-danger">*</span></label>
                <select name="brand_id" class="form-control" required>
                    <option value="">Pilih Brand</option>
                    @foreach($brands ?? [] as $brand)
                        <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="mb-4">
                <label class="form-label">Platform <span class="text-danger">*</span></label>
                <select name="platform" class="form-control" required>
                    <option value="">Pilih Platform</option>
                    <option value="Instagram">Instagram</option>
                    <option value="TikTok">TikTok</option>
                    <option value="YouTube">YouTube</option>
                    <option value="Facebook">Facebook</option>
                    <option value="Twitter">Twitter</option>
                </select>
            </div>
            
            <div class="mb-4">
                <label class="form-label">Format Konten <span class="text-danger">*</span></label>
                <select name="content_format" class="form-control" required>
                    <option value="">Pilih Format</option>
                    <option value="Video">Video</option>
                    <option value="Image">Image</option>
                    <option value="Carousel">Carousel</option>
                    <option value="Reels">Reels</option>
                    <option value="Story">Story</option>
                </select>
            </div>
            
            <div class="mb-4">
                <label class="form-label">Durasi Target <span class="text-danger">*</span></label>
                <input type="text" name="target_duration" class="form-control" placeholder="contoh: 30 detik" required>
            </div>
            
            <div class="mb-4">
                <label class="form-label">Deadline Produksi <span class="text-danger">*</span></label>
                <input type="date" name="production_deadline" class="form-control" required>
            </div>
            
            <div class="mb-4">
                <label class="form-label">Deadline Publish <span class="text-danger">*</span></label>
                <input type="date" name="publish_deadline" class="form-control" required>
            </div>
            
            <div class="mb-4">
                <label class="form-label">Objective <span class="text-danger">*</span></label>
                <select name="objective" class="form-control" required>
                    <option value="">Pilih Objective</option>
                    <option value="Brand Awareness">Brand Awareness</option>
                    <option value="Lead Generation">Lead Generation</option>
                    <option value="Sales">Sales</option>
                    <option value="Engagement">Engagement</option>
                    <option value="Education">Education</option>
                    <option value="Entertainment">Entertainment</option>
                </select>
            </div>
            
            <div class="mb-4">
                <label class="form-label">Target Audience <span class="text-danger">*</span></label>
                <input type="text" name="target_audience" class="form-control" required>
            </div>
            
            <div class="mb-4">
                <label class="form-label">Key Message <span class="text-danger">*</span></label>
                <textarea name="key_message" class="form-control" rows="3" required></textarea>
            </div>
            
            <div class="mb-4">
                <label class="form-label">Hook <span class="text-danger">*</span></label>
                <textarea name="hook" class="form-control" rows="2" required></textarea>
            </div>
            
            <div class="mb-4">
                <label class="form-label">Storyline <span class="text-danger">*</span></label>
                <textarea name="storyline" class="form-control" rows="4" required></textarea>
            </div>
            
            <div class="mb-4">
                <label class="form-label">Visual Direction <span class="text-danger">*</span></label>
                <textarea name="visual_direction" class="form-control" rows="3" required></textarea>
            </div>
            
            <div class="mb-4">
                <label class="form-label">Caption <span class="text-danger">*</span></label>
                <textarea name="caption" class="form-control" rows="4" required></textarea>
            </div>
            
            <div class="mb-4">
                <label class="form-label">CTA <span class="text-danger">*</span></label>
                <input type="text" name="cta" class="form-control" required>
            </div>
            
            <div class="mb-4">
                <label class="form-label">Hashtags <span class="text-danger">*</span></label>
                <textarea name="hashtags" class="form-control" rows="2" required></textarea>
            </div>
            
            <div class="mb-4">
                <label class="form-label">Target Views <span class="text-danger">*</span></label>
                <input type="text" name="target_views" class="form-control" required>
            </div>
            
            <div class="mb-4">
                <label class="form-label">Target Engagement <span class="text-danger">*</span></label>
                <input type="text" name="target_engagement" class="form-control" required>
            </div>
            
            <div class="mb-4">
                <label class="form-label">Email Creator</label>
                <input type="email" name="creator_email" class="form-control" placeholder="opsional">
            </div>
            
            <div class="d-flex gap-3 mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="fa-solid fa-save"></i> Simpan
                </button>
                <button type="button" class="btn btn-ghost" onclick="window.location.href='{{ route('content-tasks.index') }}'">
                    <i class="fa-solid fa-times"></i> Batal
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
