# Brand Management Documentation

## Tujuan Fitur

Brand Management adalah fitur untuk mengelola brand/merek yang digunakan dalam konten production:
- Create, Read, Update, Delete (CRUD) brands
- Assign brands ke user tertentu
- Filter dan search brands
- View detail brand dengan konten terkait
- Modern UI dengan modal konfirmasi

## Alur Kerja Fitur

1. **Index**: Menampilkan daftar semua brands user
2. **Create**: Form untuk menambah brand baru
3. **Edit**: Form untuk mengedit brand existing
4. **Show**: Detail brand dengan konten terkait
5. **Delete**: Menghapus brand dengan konfirmasi modal
6. **Search**: Filter brands berdasarkan nama

## File Kode yang Digunakan

### 1. Controller
**File**: `app/Http/Controllers/BrandController.php`

```php
class BrandController extends Controller
{
    public function index()
    {
        // Mengambil semua brands milik user yang login
        $brands = Brand::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('brands.index', compact('brands'));
    }
    
    public function create()
    {
        // Menampilkan form create brand
        return view('brands.create');
    }
    
    public function store(Request $request)
    {
        // Validasi input brand
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'industry' => 'nullable|string|max:255',
            'website' => 'nullable|url',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        
        // Upload logo jika ada
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('logos', 'public');
            $validated['logo'] = $logoPath;
        }
        
        // Menambahkan user_id ke data
        $validated['user_id'] = auth()->id();
        
        // Simpan brand baru
        Brand::create($validated);
        
        return redirect()->route('brands.index')
            ->with('success', 'Brand berhasil ditambahkan!');
    }
    
    public function edit(Brand $brand)
    {
        // Policy check: memastikan user pemilik brand
        $this->authorize('update', $brand);
        
        return view('brands.edit', compact('brand'));
    }
    
    public function update(Request $request, Brand $brand)
    {
        // Policy check
        $this->authorize('update', $brand);
        
        // Validasi input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'industry' => 'nullable|string|max:255',
            'website' => 'nullable|url',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        
        // Update logo jika ada file baru
        if ($request->hasFile('logo')) {
            // Hapus logo lama
            if ($brand->logo) {
                Storage::delete('public/' . $brand->logo);
            }
            
            $logoPath = $request->file('logo')->store('logos', 'public');
            $validated['logo'] = $logoPath;
        }
        
        // Update brand
        $brand->update($validated);
        
        return redirect()->route('brands.index')
            ->with('success', 'Brand berhasil diperbarui!');
    }
    
    public function show(Brand $brand)
    {
        // Policy check
        $this->authorize('view', $brand);
        
        // Mengambil konten terkait brand
        $contents = Content::where('brand_id', $brand->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('brands.show', compact('brand', 'contents'));
    }
    
    public function destroy(Brand $brand)
    {
        // Policy check
        $this->authorize('delete', $brand);
        
        // Hapus logo jika ada
        if ($brand->logo) {
            Storage::delete('public/' . $brand->logo);
        }
        
        // Hapus brand
        $brand->delete();
        
        return redirect()->route('brands.index')
            ->with('success', 'Brand berhasil dihapus!');
    }
}
```

**Fungsi Controller**:
- `index()`: Daftar brands dengan pagination
- `create()`: Form tambah brand
- `store()`: Proses simpan brand baru
- `edit()`: Form edit brand dengan policy check
- `update()`: Proses update brand
- `show()`: Detail brand dengan konten terkait
- `destroy()`: Hapus brand dengan konfirmasi

### 2. Route
**File**: `routes/web.php`

```php
// Brand Routes
Route::middleware(['auth', 'creator'])->group(function () {
    Route::get('/brands', [BrandController::class, 'index'])->name('brands.index');
    Route::get('/brands/create', [BrandController::class, 'create'])->name('brands.create');
    Route::post('/brands', [BrandController::class, 'store'])->name('brands.store');
    Route::get('/brands/{brand}/edit', [BrandController::class, 'edit'])->name('brands.edit');
    Route::put('/brands/{brand}', [BrandController::class, 'update'])->name('brands.update');
    Route::get('/brands/{brand}', [BrandController::class, 'show'])->name('brands.show');
    Route::delete('/brands/{brand}', [BrandController::class, 'destroy'])->name('brands.destroy');
});
```

**Fungsi Route**:
- **Resource Pattern**: RESTful routes untuk CRUD operations
- **Middleware**: `auth` dan `creator` untuk security
- **Model Binding**: `{brand}` otomatis resolve ke Brand model
- **HTTP Methods**: GET, POST, PUT, DELETE sesuai kebutuhan

### 3. Model
**File**: `app/Models/Brand.php`

```php
class Brand extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name', 'description', 'industry', 'website', 'logo', 'user_id'
    ];
    
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    
    // Relasi ke user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    // Relasi ke contents
    public function contents()
    {
        return $this->hasMany(Content::class);
    }
    
    // Policy registration
    protected static function booted()
    {
        static::addGlobalScope('user', function (Builder $builder) {
            if (auth()->check()) {
                $builder->where('user_id', auth()->id());
            }
        });
    }
}
```

**Fungsi Model**:
- **Fillable**: Fields yang bisa di-mass assign
- **Casts**: Type casting untuk dates
- **Relations**: `user()` dan `contents()` untuk relasi database
- **Global Scope**: Otomatis filter berdasarkan user login

### 4. Policy
**File**: `app/Policies/BrandPolicy.php`

```php
class BrandPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Brand $brand)
    {
        // User bisa lihat brand miliknya sendiri
        return $user->id === $brand->user_id;
    }

    public function update(User $user, Brand $brand)
    {
        // User bisa update brand miliknya sendiri
        return $user->id === $brand->user_id;
    }

    public function delete(User $user, Brand $brand)
    {
        // User bisa hapus brand miliknya sendiri
        return $user->id === $brand->user_id;
    }

    public function create(User $user)
    {
        // User dengan role creator bisa buat brand
        return $user->role === 'creator';
    }
}
```

**Fungsi Policy**:
- **Authorization**: Memastikan user hanya akses brand miliknya
- **Role-based**: Creator bisa create, user hanya bisa akses miliknya
- **Security**: Mencegah unauthorized access

### 5. View Files

#### Index View
**File**: `resources/views/brands/index.blade.php`

**Komponen Utama**:
```html
<!-- Header Section dengan Illustration -->
<div class="brief-header-section saas">
    <div class="header-content">
        <div class="header-text">
            <h1>Brand Management</h1>
            <p>Kelola brand dan identitas visual untuk konten production.</p>
            <!-- Stats cards -->
        </div>
        <div class="header-illustration">
            <!-- SVG illustration -->
        </div>
    </div>
</div>

<!-- Action Button -->
<div class="header-section">
    <a href="{{ route('brands.create') }}" class="btn-primary">
        Tambah Brand Baru
    </a>
</div>

<!-- Enhanced Table Card -->
<div class="table-card">
    @if($brands->count() > 0)
        <table class="table enhanced">
            <thead>
                <tr>
                    <th>Brand</th>
                    <th>Industry</th>
                    <th>Konten</th>
                    <th>Dibuat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($brands as $brand)
                <tr>
                    <td>
                        <div class="brand-info">
                            @if($brand->logo)
                                <img src="{{ asset('storage/' . $brand->logo) }}" alt="{{ $brand->name }}">
                            @endif
                            <span>{{ $brand->name }}</span>
                        </div>
                    </td>
                    <td>{{ $brand->industry ?? '-' }}</td>
                    <td>{{ $brand->contents->count() }}</td>
                    <td>{{ $brand->created_at->format('d M Y') }}</td>
                    <td>
                        <div class="action-buttons">
                            <a href="{{ route('brands.show', $brand) }}" class="btn-view">Lihat</a>
                            <a href="{{ route('brands.edit', $brand) }}" class="btn-edit">Edit</a>
                            <button onclick="openDeleteModal('{{ $brand->id }}', '{{ $brand->name }}')" class="btn-delete">Hapus</button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        
        <!-- Pagination -->
        {{ $brands->links() }}
    @else
        <!-- Empty state -->
    @endif
</div>

<!-- Custom Delete Modal -->
<div id="deleteModal" class="modal-overlay">
    <div class="modal-card">
        <div class="modal-header">
            <h3>Konfirmasi Hapus</h3>
            <button onclick="closeDeleteModal()" class="modal-close">×</button>
        </div>
        <div class="modal-body">
            <p>Apakah Anda yakin ingin menghapus brand "<span id="brandName"></span>"?</p>
            <p class="warning">Tindakan ini tidak dapat dibatalkan.</p>
        </div>
        <div class="modal-footer">
            <button onclick="closeDeleteModal()" class="btn-secondary">Batal</button>
            <form id="deleteForm" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-danger">Hapus</button>
            </form>
        </div>
    </div>
</div>
```

#### Create/Edit View
**File**: `resources/views/brands/create.blade.php` dan `edit.blade.php`

**Form Structure**:
```html
<div class="form-container">
    <form method="POST" action="{{ route('brands.store') }}" enctype="multipart/form-data">
        @csrf
        
        <!-- Brand Name -->
        <div class="form-group">
            <label for="name">Nama Brand *</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" required>
        </div>
        
        <!-- Description -->
        <div class="form-group">
            <label for="description">Deskripsi</label>
            <textarea id="description" name="description">{{ old('description') }}</textarea>
        </div>
        
        <!-- Industry -->
        <div class="form-group">
            <label for="industry">Industri</label>
            <input type="text" id="industry" name="industry" value="{{ old('industry') }}">
        </div>
        
        <!-- Website -->
        <div class="form-group">
            <label for="website">Website</label>
            <input type="url" id="website" name="website" value="{{ old('website') }}">
        </div>
        
        <!-- Logo Upload -->
        <div class="form-group">
            <label for="logo">Logo Brand</label>
            <input type="file" id="logo" name="logo" accept="image/*">
            @if($brand->logo ?? null)
                <div class="current-logo">
                    <img src="{{ asset('storage/' . $brand->logo) }}" alt="Current logo">
                </div>
            @endif
        </div>
        
        <!-- Submit Button -->
        <div class="form-actions">
            <a href="{{ route('brands.index') }}" class="btn-secondary">Batal</a>
            <button type="submit" class="btn-primary">
                {{ $brand ? 'Update' : 'Simpan' }} Brand
            </button>
        </div>
    </form>
</div>
```

## Penjelasan Kode

### Data Flow
1. **Index Request**: User akses `/brands`
2. **Authentication**: Middleware validasi user login
3. **Query**: Controller ambil brands dengan `user_id` filter
4. **Pagination**: Results dipaginate 10 items per page
5. **View**: Blade template render dengan SaaS design
6. **CRUD Operations**: Create, Read, Update, Delete dengan validasi

### Security Features
- **Authentication**: Middleware memastikan user login
- **Authorization**: Policy check untuk ownership validation
- **CSRF Protection**: Form menggunakan CSRF token
- **File Upload**: Validation file type dan size
- **SQL Injection**: Eloquent ORM protection

### File Management
- **Logo Upload**: Storage di `storage/app/public/logos`
- **File Validation**: Mimes dan max size 2MB
- **Old File Cleanup**: Hapus logo lama saat update
- **Public Access**: Asset linking melalui `asset()` helper

### UI/UX Features
- **Modern SaaS Design**: Clean dengan card containers
- **Custom Modal**: JavaScript modal untuk konfirmasi delete
- **Responsive Layout**: Mobile-friendly table dan forms
- **Empty States**: Informasi ketika tidak ada data
- **Loading States**: Skeleton loading bisa ditambahkan
- **Search/Filter**: Bisa ditambahkan untuk brands

## Cara Penggunaan

### Create Brand
1. Klik "Tambah Brand Baru" di index
2. Isi form: nama, deskripsi, industri, website
3. Upload logo (opsional)
4. Klik "Simpan Brand"

### Edit Brand
1. Klik "Edit" di row brand yang diinginkan
2. Form terisi dengan data existing
3. Update informasi yang diperlukan
4. Upload logo baru jika perlu
5. Klik "Update Brand"

### Delete Brand
1. Klik "Hapus" di row brand
2. Modal konfirmasi muncul
3. Konfirmasi untuk menghapus
4. Brand dan logo terhapus dari sistem

## Troubleshooting

### Common Issues
- **Upload Failed**: Periksa file permissions dan storage link
- **Policy Denied**: Pastikan user pemilik brand
- **Pagination Error**: Verifikasi view composer dan links
- **Asset Not Found**: Jalankan `php artisan storage:link`

### Debug Tips
- Check `auth()->id()` untuk user authentication
- Log query results dengan `->toSql()` untuk debugging
- Inspect request data dengan `dd($request->all())`
- Verify policy registration di `AuthServiceProvider`
