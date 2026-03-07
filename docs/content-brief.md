# Content Brief Documentation

## Tujuan Fitur

Content Brief adalah fitur untuk mengelola brief/konsep konten sebelum production:
- Create, Read, Update, Delete (CRUD) content briefs
- Manage workflow dari brief sampai publish
- Assign brands ke briefs
- Track status progress konten
- Collaborative content planning dengan structured data

## Alur Kerja Fitur

1. **Brief Creation**: Membuat brief baru dengan structured sections
2. **Brief Management**: Edit, update, dan delete briefs
3. **Status Tracking**: Monitor progress dari brief ke publish
4. **Brand Assignment**: Menghubungkan brief dengan brand
5. **Content Production**: Workflow dari brief ke konten jadi

## File Kode yang Digunakan

### 1. Controller
**File**: `app/Http/Controllers/ContentBriefController.php`

```php
class ContentBriefController extends Controller
{
    public function index()
    {
        // Mengambil semua briefs milik user
        $briefs = ContentBrief::where('user_id', auth()->id())
            ->with('brand') // Eager loading brand relation
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('brief.index', compact('briefs'));
    }
    
    public function create()
    {
        // Mengambil brands untuk dropdown
        $brands = Brand::where('user_id', auth()->id())->get();
        
        return view('brief.create', compact('brands'));
    }
    
    public function store(Request $request)
    {
        // Validasi input brief
        $validated = $request->validate([
            // Informasi Dasar
            'brand_id' => 'required|exists:brands,id',
            'title' => 'required|string|max:255',
            'content_type' => 'required|in:Social Media, Blog, Video, Infographic, Podcast',
            'target_audience' => 'required|string|max:255',
            'content_purpose' => 'required|string',
            
            // Strategi
            'key_message' => 'required|string',
            'tone_of_voice' => 'required|in:Professional, Casual, Formal, Friendly, Humorous',
            'content_angle' => 'required|string',
            
            // Creative
            'visual_style' => 'required|string',
            'color_palette' => 'required|string',
            'visual_references' => 'nullable|string',
            
            // Copywriting
            'headline' => 'required|string|max:255',
            'key_points' => 'required|array',
            'call_to_action' => 'required|string',
            
            // KPI Target
            'target_engagement' => 'nullable|integer|min:0',
            'target_reach' => 'nullable|integer|min:0',
            'target_conversion' => 'nullable|integer|min:0',
            'deadline' => 'required|date|after:today',
            'status' => 'required|in:Draft,Active,In Progress,Review,Approved,Completed',
        ]);
        
        // Menambahkan user_id
        $validated['user_id'] = auth()->id();
        
        // Simpan brief baru
        ContentBrief::create($validated);
        
        return redirect()->route('brief.index')
            ->with('success', 'Content brief berhasil dibuat!');
    }
    
    public function edit(ContentBrief $brief)
    {
        // Policy check: memastikan user pemilik brief
        $this->authorize('update', $brief);
        
        // Mengambil brands untuk dropdown
        $brands = Brand::where('user_id', auth()->id())->get();
        
        return view('brief.edit', compact('brief', 'brands'));
    }
    
    public function update(Request $request, ContentBrief $brief)
    {
        // Policy check
        $this->authorize('update', $brief);
        
        // Validasi input (sama dengan store)
        $validated = $request->validate([
            // ... validation rules sama dengan store
        ]);
        
        // Update brief
        $brief->update($validated);
        
        return redirect()->route('brief.index')
            ->with('success', 'Content brief berhasil diperbarui!');
    }
    
    public function show(ContentBrief $brief)
    {
        // Policy check
        $this->authorize('view', $brief);
        
        // Load brand relation
        $brief->load('brand');
        
        return view('brief.show', compact('brief'));
    }
    
    public function destroy(ContentBrief $brief)
    {
        // Policy check
        $this->authorize('delete', $brief);
        
        // Hapus brief
        $brief->delete();
        
        return redirect()->route('brief.index')
            ->with('success', 'Content brief berhasil dihapus!');
    }
}
```

**Fungsi Controller**:
- `index()`: Daftar briefs dengan pagination dan brand relation
- `create()`: Form create brief dengan brand options
- `store()`: Proses simpan brief dengan structured validation
- `edit()`: Form edit brief dengan data existing
- `update()`: Proses update brief
- `show()`: Detail brief dengan brand information
- `destroy()`: Hapus brief dengan authorization

### 2. Route
**File**: `routes/web.php`

```php
// Content Brief Routes
Route::middleware(['auth', 'creator'])->group(function () {
    Route::get('/brief', [ContentBriefController::class, 'index'])->name('brief.index');
    Route::get('/brief/create', [ContentBriefController::class, 'create'])->name('brief.create');
    Route::post('/brief', [ContentBriefController::class, 'store'])->name('brief.store');
    Route::get('/brief/{brief}/edit', [ContentBriefController::class, 'edit'])->name('brief.edit');
    Route::put('/brief/{brief}', [ContentBriefController::class, 'update'])->name('brief.update');
    Route::get('/brief/{brief}', [ContentBriefController::class, 'show'])->name('brief.show');
    Route::delete('/brief/{brief}', [ContentBriefController::class, 'destroy'])->name('brief.destroy');
});
```

**Fungsi Route**:
- **RESTful Pattern**: Standard CRUD routes
- **Middleware**: Authentication dan authorization
- **Model Binding**: Automatic model resolution
- **Naming**: Consistent route naming convention

### 3. Model
**File**: `app/Models/ContentBrief.php`

```php
class ContentBrief extends Model
{
    use HasFactory;
    
    protected $fillable = [
        // Informasi Dasar
        'brand_id', 'title', 'content_type', 'target_audience', 'content_purpose', 'user_id',
        
        // Strategi
        'key_message', 'tone_of_voice', 'content_angle',
        
        // Creative
        'visual_style', 'color_palette', 'visual_references',
        
        // Copywriting
        'headline', 'key_points', 'call_to_action',
        
        // KPI Target
        'target_engagement', 'target_reach', 'target_conversion', 'deadline', 'status'
    ];
    
    protected $casts = [
        'key_points' => 'array', // JSON field untuk array
        'deadline' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    
    // Relasi ke user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    // Relasi ke brand
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
    
    // Relasi ke contents (jika ada)
    public function contents()
    {
        return $this->hasMany(Content::class);
    }
}
```

**Fungsi Model**:
- **Structured Data**: Fillable fields terorganisir per section
- **JSON Casting**: `key_points` sebagai array
- **Relations**: `user()` dan `brand()` untuk data relationships
- **Date Handling**: Proper casting untuk deadline

### 4. Migration
**File**: `database/migrations/2026_03_06_084527_create_content_briefs_table.php`

```php
class CreateContentBriefsTable extends Migration
{
    public function up()
    {
        Schema::create('content_briefs', function (Blueprint $table) {
            $table->id();
            
            // Foreign Keys
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('brand_id')->nullable()->constrained()->onDelete('set null');
            
            // Informasi Dasar
            $table->string('title');
            $table->enum('content_type', ['Social Media', 'Blog', 'Video', 'Infographic', 'Podcast']);
            $table->string('target_audience');
            $table->text('content_purpose');
            
            // Strategi
            $table->text('key_message');
            $table->enum('tone_of_voice', ['Professional', 'Casual', 'Formal', 'Friendly', 'Humorous']);
            $table->text('content_angle');
            
            // Creative
            $table->string('visual_style');
            $table->string('color_palette');
            $table->text('visual_references')->nullable();
            
            // Copywriting
            $table->string('headline');
            $table->json('key_points'); // Array dari key points
            $table->text('call_to_action');
            
            // KPI Target
            $table->integer('target_engagement')->nullable();
            $table->integer('target_reach')->nullable();
            $table->integer('target_conversion')->nullable();
            $table->date('deadline');
            $table->enum('status', ['Draft', 'Active', 'In Progress', 'Review', 'Approved', 'Completed']);
            
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('content_briefs');
    }
}
```

**Fungsi Migration**:
- **Structured Schema**: Fields terorganisir per section brief
- **Data Types**: Enum untuk pilihan tetap, JSON untuk array
- **Foreign Keys**: Relasi ke users dan brands tables
- **Constraints**: Cascade delete untuk user, set null untuk brand

### 5. View Files

#### Index View
**File**: `resources/views/brief/index.blade.php`

**Komponen Utama**:
```html
<!-- Hero Section dengan Stats -->
<div class="brief-header-section saas">
    <div class="header-content">
        <div class="header-text">
            <h1>Content Brief</h1>
            <p>Kelola konsep dan strategi konten sebelum produksi.</p>
            <div class="header-stats">
                <div class="header-stat">
                    <div class="header-number">{{ $briefs->count() }}</div>
                    <div class="header-label">Total Brief</div>
                </div>
                <div class="header-stat">
                    <div class="header-number">{{ $briefs->where('status', 'Active')->count() }}</div>
                    <div class="header-label">Active</div>
                </div>
                <div class="header-stat">
                    <div class="header-number">{{ $briefs->where('status', 'Completed')->count() }}</div>
                    <div class="header-label">Completed</div>
                </div>
            </div>
        </div>
        <div class="header-illustration">
            <!-- SVG workflow illustration -->
        </div>
    </div>
</div>

<!-- Action Button -->
<div class="header-section">
    <a href="{{ route('brief.create') }}" class="btn-primary">
        <svg>...</svg>
        Buat Brief Baru
    </a>
</div>

<!-- Enhanced Table Card -->
<div class="table-card">
    @if($briefs->count() > 0)
        <table class="table enhanced">
            <thead>
                <tr>
                    <th>Judul</th>
                    <th>Brand</th>
                    <th>Tipe Konten</th>
                    <th>Status</th>
                    <th>Deadline</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($briefs as $brief)
                <tr>
                    <td>
                        <div class="brief-title">
                            {{ $brief->title }}
                        </div>
                    </td>
                    <td>
                        <span class="brand-tag">{{ $brief->brand->name ?? 'No Brand' }}</span>
                    </td>
                    <td>
                        <span class="content-type-badge">{{ $brief->content_type }}</span>
                    </td>
                    <td>
                        <span class="status-badge status-{{ Str::slug($brief->status) }}">
                            {{ $brief->status }}
                        </span>
                    </td>
                    <td>{{ $brief->deadline->format('d M Y') }}</td>
                    <td>
                        <div class="action-buttons">
                            <a href="{{ route('brief.show', $brief) }}" class="btn-view">Lihat</a>
                            <a href="{{ route('brief.edit', $brief) }}" class="btn-edit">Edit</a>
                            <form method="POST" action="{{ route('brief.destroy', $brief) }}" onsubmit="return confirm('Apakah Anda yakin?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-delete">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        
        <!-- Pagination -->
        {{ $briefs->links() }}
    @else
        <!-- Empty state -->
    @endif
</div>
```

#### Create/Edit View
**File**: `resources/views/brief/create.blade.php`

**Form Structure**:
```html
<div class="brief-form-container">
    <form method="POST" action="{{ route('brief.store') }}">
        @csrf
        
        <!-- Section 1: Informasi Dasar -->
        <div class="form-section">
            <div class="section-header">
                <h3>📋 Informasi Dasar</h3>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="brand_id">Brand *</label>
                    <select id="brand_id" name="brand_id" required>
                        <option value="">Pilih Brand</option>
                        @foreach($brands as $brand)
                            <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>
                                {{ $brand->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="title">Judul Brief *</label>
                    <input type="text" id="title" name="title" value="{{ old('title') }}" required>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="content_type">Tipe Konten *</label>
                    <select id="content_type" name="content_type" required>
                        <option value="">Pilih Tipe</option>
                        <option value="Social Media">Social Media</option>
                        <option value="Blog">Blog</option>
                        <option value="Video">Video</option>
                        <option value="Infographic">Infographic</option>
                        <option value="Podcast">Podcast</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="target_audience">Target Audience *</label>
                    <input type="text" id="target_audience" name="target_audience" value="{{ old('target_audience') }}" required>
                </div>
            </div>
            
            <div class="form-group full-width">
                <label for="content_purpose">Tujuan Konten *</label>
                <textarea id="content_purpose" name="content_purpose" required>{{ old('content_purpose') }}</textarea>
            </div>
        </div>
        
        <!-- Section 2: Strategi -->
        <div class="form-section">
            <div class="section-header">
                <h3>🎯 Strategi</h3>
            </div>
            
            <div class="form-group full-width">
                <label for="key_message">Key Message *</label>
                <textarea id="key_message" name="key_message" required>{{ old('key_message') }}</textarea>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="tone_of_voice">Tone of Voice *</label>
                    <select id="tone_of_voice" name="tone_of_voice" required>
                        <option value="">Pilih Tone</option>
                        <option value="Professional">Professional</option>
                        <option value="Casual">Casual</option>
                        <option value="Formal">Formal</option>
                        <option value="Friendly">Friendly</option>
                        <option value="Humorous">Humorous</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="content_angle">Content Angle *</label>
                    <input type="text" id="content_angle" name="content_angle" value="{{ old('content_angle') }}" required>
                </div>
            </div>
        </div>
        
        <!-- Section 3: Creative -->
        <div class="form-section">
            <div class="section-header">
                <h3>🎨 Creative</h3>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="visual_style">Visual Style *</label>
                    <input type="text" id="visual_style" name="visual_style" value="{{ old('visual_style') }}" required>
                </div>
                
                <div class="form-group">
                    <label for="color_palette">Color Palette *</label>
                    <input type="text" id="color_palette" name="color_palette" value="{{ old('color_palette') }}" required>
                </div>
            </div>
            
            <div class="form-group full-width">
                <label for="visual_references">Visual References</label>
                <textarea id="visual_references" name="visual_references">{{ old('visual_references') }}</textarea>
            </div>
        </div>
        
        <!-- Section 4: Copywriting -->
        <div class="form-section">
            <div class="section-header">
                <h3>✍️ Copywriting</h3>
            </div>
            
            <div class="form-group full-width">
                <label for="headline">Headline *</label>
                <input type="text" id="headline" name="headline" value="{{ old('headline') }}" required>
            </div>
            
            <div class="form-group full-width">
                <label for="key_points">Key Points *</label>
                <div id="key_points_container">
                    <div class="key-point-item">
                        <input type="text" name="key_points[]" value="{{ old('key_points.0') ?? '' }}" required>
                    </div>
                    <div class="key-point-item">
                        <input type="text" name="key_points[]" value="{{ old('key_points.1') ?? '' }}" required>
                    </div>
                    <div class="key-point-item">
                        <input type="text" name="key_points[]" value="{{ old('key_points.2') ?? '' }}" required>
                    </div>
                </div>
                <button type="button" onclick="addKeyPoint()">+ Tambah Point</button>
            </div>
            
            <div class="form-group full-width">
                <label for="call_to_action">Call to Action *</label>
                <textarea id="call_to_action" name="call_to_action" required>{{ old('call_to_action') }}</textarea>
            </div>
        </div>
        
        <!-- Section 5: KPI Target -->
        <div class="form-section">
            <div class="section-header">
                <h3>📊 KPI Target</h3>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="target_engagement">Target Engagement</label>
                    <input type="number" id="target_engagement" name="target_engagement" value="{{ old('target_engagement') }}" min="0">
                </div>
                
                <div class="form-group">
                    <label for="target_reach">Target Reach</label>
                    <input type="number" id="target_reach" name="target_reach" value="{{ old('target_reach') }}" min="0">
                </div>
                
                <div class="form-group">
                    <label for="target_conversion">Target Conversion</label>
                    <input type="number" id="target_conversion" name="target_conversion" value="{{ old('target_conversion') }}" min="0">
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="deadline">Deadline *</label>
                    <input type="date" id="deadline" name="deadline" value="{{ old('deadline') }}" required>
                </div>
                
                <div class="form-group">
                    <label for="status">Status *</label>
                    <select id="status" name="status" required>
                        <option value="Draft">Draft</option>
                        <option value="Active">Active</option>
                        <option value="In Progress">In Progress</option>
                        <option value="Review">Review</option>
                        <option value="Approved">Approved</option>
                        <option value="Completed">Completed</option>
                    </select>
                </div>
            </div>
        </div>
        
        <!-- Form Actions -->
        <div class="form-actions">
            <a href="{{ route('brief.index') }}" class="btn-secondary">Batal</a>
            <button type="submit" class="btn-primary">
                {{ $brief ? 'Update' : 'Simpan' }} Brief
            </button>
        </div>
    </form>
</div>
```

## Penjelasan Kode

### Data Flow
1. **Index Request**: User akses `/brief`
2. **Authentication**: Middleware validasi user
3. **Query**: Controller ambil briefs dengan brand relation
4. **Structured Data**: Brief fields terorganisir per section
5. **View**: Blade template render dengan section cards
6. **CRUD Operations**: Complete workflow dari brief ke content

### Form Structure
- **5 Sections**: Informasi Dasar, Strategi, Creative, Copywriting, KPI Target
- **Validation**: Comprehensive validation per field type
- **Dynamic Fields**: Key points dengan add/remove functionality
- **Brand Integration**: Dropdown brands milik user
- **Status Management**: Enum untuk workflow tracking

### Security Features
- **Authentication**: Middleware protection
- **Authorization**: Policy untuk ownership validation
- **CSRF Protection**: Token untuk form security
- **Input Validation**: Comprehensive validation rules
- **SQL Injection**: Eloquent ORM protection

### UI/UX Features
- **Section Cards**: Setiap section dalam card terpisah
- **Progressive Disclosure**: Informasi terstruktur dan tidak overwhelming
- **Visual Hierarchy**: Icons dan headers untuk setiap section
- **Responsive Design**: Mobile-friendly form layout
- **Status Indicators**: Color-coded badges untuk status
- **Interactive Elements**: Dynamic key points management

## Cara Penggunaan

### Create Brief
1. Klik "Buat Brief Baru" di index
2. Isi section 1: Informasi Dasar (brand, judul, tipe konten)
3. Isi section 2: Strategi (message, tone, angle)
4. Isi section 3: Creative (visual style, colors, references)
5. Isi section 4: Copywriting (headline, key points, CTA)
6. Isi section 5: KPI Target (engagement, reach, conversion)
7. Set deadline dan status
8. Klik "Simpan Brief"

### Edit Brief
1. Klik "Edit" di brief yang diinginkan
2. Form terisi dengan data existing
3. Update informasi di section yang diperlukan
4. Klik "Update Brief"

### Track Progress
1. Lihat status brief di table index
2. Update status sesuai progress production
3. Monitor deadline untuk time management
4. View detail brief untuk informasi lengkap

## Troubleshooting

### Common Issues
- **Validation Failed**: Periksa required fields dan format
- **Brand Not Found**: Pastikan brand sudah dibuat
- **Array Fields**: Key points harus diisi sesuai format
- **Date Validation**: Deadline harus setelah hari ini

### Debug Tips
- Check `auth()->id()` untuk authentication
- Log validation errors dengan `$errors->all()`
- Inspect array fields dengan `dd($request->key_points)`
- Verify relation loading dengan `->with('brand')`
- Check migration status dengan `php artisan migrate:status`
