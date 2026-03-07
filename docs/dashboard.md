# Dashboard Creator Documentation

## Tujuan Fitur

Dashboard Creator adalah halaman utama untuk content creator yang menampilkan:
- Personalized greeting dengan nama user
- Statistik workflow konten real-time
- Overview aktivitas harian
- Akses cepat ke fitur-fitur utama
- Visualisasi data dengan illustrasi modern

## Alur Kerja Fitur

1. **Authentication**: User login melalui middleware CreatorMiddleware
2. **Data Loading**: Controller mengambil data statistik dari database
3. **Display**: Blade template menampilkan data dengan SaaS-style design
4. **Interaction**: User dapat berinteraksi dengan stat cards dan navigasi

## File Kode yang Digunakan

### 1. Controller
**File**: `app/Http/Controllers/DashboardController.php`

```php
class DashboardController extends Controller
{
    public function creator()
    {
        // Middleware memastikan hanya creator yang bisa akses
        $user = auth()->user();
        
        // Mengambil data statistik untuk dashboard
        $stats = [
            'total_brands' => Brand::where('user_id', $user->id)->count(),
            'total_contents' => Content::where('user_id', $user->id)->count(),
            'in_production' => Content::where('user_id', $user->id)->where('status', 'In Production')->count(),
            'under_review' => Content::where('user_id', $user->id)->where('status', 'Under Review')->count(),
            'need_revision' => Content::where('user_id', $user->id)->where('status', 'Need Revision')->count(),
            'ready_to_publish' => Content::where('user_id', $user->id)->where('status', 'Ready to Publish')->count(),
            'published' => Content::where('user_id', $user->id)->where('status', 'Published')->count(),
        ];
        
        // Mengambil data deadline terdekat
        $deadlines = Content::where('user_id', $user->id)
            ->where('status', '!=', 'Published')
            ->orderBy('deadline', 'asc')
            ->take(5)
            ->get();
            
        // Mengambil aktivitas terbaru
        $activities = []; // Implementasi aktivitas log
        
        return view('dashboard.creator', compact('user', 'stats', 'deadlines', 'activities'));
    }
}
```

**Fungsi Controller**:
- `creator()`: Method utama yang menampilkan dashboard creator
- **Authentication**: Mengambil user yang sedang login
- **Statistics**: Menghitung data berdasarkan user_id dan status
- **Deadlines**: Mengambil konten dengan deadline terdekat
- **Activities**: Menampilkan log aktivitas user

### 2. Route
**File**: `routes/web.php`

```php
// Dashboard Routes
Route::middleware(['auth', 'creator'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'creator'])->name('dashboard.creator');
});
```

**Fungsi Route**:
- **Middleware**: `auth` dan `creator` memastikan user sudah login dan role creator
- **Grouping**: Mengelompokkan route terkait dashboard
- **Naming**: `dashboard.creator` untuk referensi di view

### 3. Middleware
**File**: `app/Http/Middleware/CreatorMiddleware.php`

```php
class CreatorMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Memeriksa apakah user sudah login
        if (!auth()->check()) {
            return redirect()->route('login');
        }
        
        // Memeriksa apakah user memiliki role 'creator'
        if (auth()->user()->role !== 'creator') {
            return redirect()->route('login'); // atau halaman forbidden
        }
        
        return $next($request);
    }
}
```

**Fungsi Middleware**:
- **Authentication**: Memastikan user sudah login
- **Authorization**: Memeriksa role user (creator)
- **Redirect**: Mengalihkan user tidak sah ke login

### 4. View
**File**: `resources/views/dashboard/creator.blade.php`

**Struktur Utama**:
```html
<!DOCTYPE html>
<html>
<head>
    <!-- Meta tags, CSS, dan assets -->
</head>
<body>
    <div class="app-container">
        <!-- Sidebar Navigation -->
        <aside class="sidebar">
            <!-- Logo dan menu navigasi -->
        </aside>
        
        <!-- Main Content Area -->
        <main class="main-content">
            <!-- Navbar dengan user info -->
            <header class="navbar">
                <!-- User avatar dan logout -->
            </header>
            
            <div class="content">
                <!-- Hero Section dengan personalized greeting -->
                <div class="hero-section saas">
                    <h1>Selamat datang, {{ $user->name }}</h1>
                    <!-- Stats cards -->
                </div>
                
                <!-- Enhanced Stats Section -->
                <div class="enhanced-stats-section saas">
                    <!-- 7 stat cards dengan icons -->
                </div>
                
                <!-- Deadline Table -->
                <div class="section-card">
                    <!-- Tabel deadline terdekat -->
                </div>
                
                <!-- Recent Activities -->
                <div class="section-card">
                    <!-- Log aktivitas terbaru -->
                </div>
            </div>
        </main>
    </div>
</body>
</html>
```

**Komponen View**:
- **Sidebar**: Navigasi utama dengan active states
- **Hero Section**: Personalized greeting dan 3 stat cards utama
- **Stats Section**: 7 cards detail untuk setiap status konten
- **Deadline Table**: Tabel konten dengan deadline terdekat
- **Activities**: Log aktivitas user terbaru

**CSS Classes**:
- `.hero-section.saas`: Hero section dengan SaaS design
- `.stat-card.saas`: Stat cards dengan hover effects
- `.table.enhanced`: Tabel dengan modern styling
- `.sidebar`: Navigation dengan active state indicators

## Penjelasan Kode

### Data Flow
1. **Request**: User mengakses `/dashboard`
2. **Middleware**: `CreatorMiddleware` memvalidasi authentication dan role
3. **Controller**: `DashboardController@creator` mengambil data user
4. **Database**: Query ke tabel `brands` dan `contents` berdasarkan `user_id`
5. **View**: Blade template merender data dengan responsive design
6. **Response**: HTML complete dengan styling SaaS

### Security Features
- **Authentication**: Middleware memastikan user sudah login
- **Authorization**: Role-based access control
- **Data Isolation**: Hanya data user yang bersangkutan ditampilkan
- **CSRF Protection**: Form submissions menggunakan CSRF token

### UI/UX Features
- **Personalization**: Menampilkan nama user di greeting
- **Real-time Stats**: Data langsung dari database
- **Responsive Design**: Mobile-friendly layout
- **Modern SaaS Style**: Clean, professional appearance
- **Interactive Elements**: Hover effects dan smooth transitions

### Performance Considerations
- **Efficient Queries**: Menggunakan `where()` dengan `user_id` untuk filtering
- **Limited Data**: `take(5)` untuk deadline, prevent overload
- **Caching**: Bisa ditambahkan cache untuk statistics
- **Optimized Assets**: CSS dan JavaScript yang efficient

## Cara Penggunaan

1. **Access**: User login sebagai creator dan akses `/dashboard`
2. **Overview**: Melihat statistik dan greeting personal
3. **Navigation**: Menggunakan sidebar untuk akses fitur lain
4. **Monitoring**: Memantau deadline dan aktivitas terbaru

## Troubleshooting

### Common Issues
- **Access Denied**: Periksa middleware dan role user
- **Empty Stats**: Pastikan data ada di database
- **CSS Issues**: Verifikasi path assets dan CSS compilation

### Debug Tips
- Check `auth()->user()` untuk user data
- Log query results untuk debugging
- Inspect browser console untuk JavaScript errors
- Verify middleware registration di `app/Http/Kernel.php`
