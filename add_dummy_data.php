<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

$status = $kernel->handle(
    $input = new Symfony\Component\Console\Input\ArgvInput,
    new Symfony\Component\Console\Output\ConsoleOutput
);

echo "=== MENAMBAHKAN DATA DUMMY UNTUK USER ID: 11 ===\n";

// 1. Buat Brands jika belum ada
$brands = [
    ['name' => 'ALESHABEAUTY', 'pic' => 'Alya Mutia', 'contact' => 'alya@alesha.com', 'target_market' => 'Women 18-35', 'tone' => 'Elegant,Feminine', 'status' => 'Active', 'user_id' => 11],
    ['name' => 'HUWA', 'pic' => 'Budi Santoso', 'contact' => 'budi@huwa.com', 'target_market' => 'Men 16-30', 'tone' => 'Masculine,Bold', 'status' => 'Active', 'user_id' => 11],
];

foreach ($brands as $brandData) {
    $existingBrand = \App\Models\Brand::where('user_id', 11)->where('name', $brandData['name'])->first();
    if (!$existingBrand) {
        $brand = \App\Models\Brand::create($brandData);
        echo "✅ Brand dibuat: {$brand->name} (ID: {$brand->id})\n";
    } else {
        echo "ℹ️  Brand sudah ada: {$existingBrand->name} (ID: {$existingBrand->id})\n";
    }
}

// 2. Buat Content Briefs
$contentBriefs = [
    [
        'title' => 'Konten Promo Skincare',
        'description' => 'Konten promosi untuk produk skincare terbaru dengan fokus pada benefits dan ingredients',
        'brand_id' => \App\Models\Brand::where('user_id', 11)->where('name', 'ALESHABEAUTY')->first()->id,
        'platform' => 'Instagram',
        'content_format' => 'Video',
        'target_duration' => '60',
        'production_deadline' => '2024-04-15',
        'publish_deadline' => '2024-04-20',
        'status' => 'In Production',
        'user_id' => 11,
    ],
    [
        'title' => 'Review Produk Makeup',
        'description' => 'Review mendalam tentang produk makeup dari brand ternama dengan swatches dan aplikasi',
        'brand_id' => \App\Models\Brand::where('user_id', 11)->where('name', 'HUWA')->first()->id,
        'platform' => 'Instagram',
        'content_format' => 'Video',
        'target_duration' => '45',
        'production_deadline' => '2024-04-18',
        'publish_deadline' => '2024-04-25',
        'status' => 'Under Review',
        'user_id' => 11,
    ],
    [
        'title' => 'Campaign Launching',
        'description' => 'Konten campaign peluncuran produk baru dengan teaser dan announcement',
        'brand_id' => \App\Models\Brand::where('user_id', 11)->where('name', 'ALESHABEAUTY')->first()->id,
        'platform' => 'YouTube',
        'content_format' => 'Video',
        'target_duration' => '90',
        'production_deadline' => '2024-04-10',
        'publish_deadline' => '2024-04-30',
        'status' => 'Published',
        'user_id' => 11,
    ],
];

foreach ($contentBriefs as $briefData) {
    $existingBrief = \App\Models\ContentBrief::where('user_id', 11)->where('title', $briefData['title'])->first();
    if (!$existingBrief) {
        $brief = \App\Models\ContentBrief::create($briefData);
        echo "✅ Content Brief dibuat: {$brief->title} (ID: {$brief->id})\n";
    } else {
        echo "ℹ️  Content Brief sudah ada: {$existingBrief->title} (ID: {$existingBrief->id})\n";
    }
}

echo "\n=== SELESAI ===\n";
echo "✅ Total Brands: " . \App\Models\Brand::where('user_id', 11)->count() . "\n";
echo "✅ Total Content Briefs: " . \App\Models\ContentBrief::where('user_id', 11)->count() . "\n";
echo "✅ Semua data terhubung dengan user_id: 11 (alyaww@gmail.com)\n";

$kernel->terminate($input, $status);
