<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifikasi Tugas Konten Baru</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .container {
            background-color: #ffffff;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #0ea5e9;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .header h1 {
            color: #0ea5e9;
            margin: 0;
            font-size: 28px;
        }
        .content {
            margin-bottom: 30px;
        }
        .task-info {
            background-color: #f8fafc;
            border-left: 4px solid #0ea5e9;
            padding: 20px;
            margin: 20px 0;
            border-radius: 5px;
        }
        .task-info h3 {
            color: #0ea5e9;
            margin-top: 0;
        }
        .task-info p {
            margin: 5px 0;
        }
        .cta-button {
            display: inline-block;
            background-color: #0ea5e9;
            color: white;
            padding: 15px 30px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            margin: 20px 0;
            text-align: center;
        }
        .cta-button:hover {
            background-color: #0284c7;
        }
        .instructions {
            background-color: #fef3c7;
            border: 1px solid #f59e0b;
            padding: 20px;
            border-radius: 5px;
            margin: 20px 0;
        }
        .instructions h3 {
            color: #d97706;
            margin-top: 0;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            color: #6b7280;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📋 Tugas Konten Baru</h1>
            <p>Anda mendapat tugas konten baru untuk dikerjakan</p>
        </div>

        <div class="content">
            <div class="task-info">
                <h3>📝 Informasi Tugas</h3>
                <p><strong>Judul:</strong> {{ $data['title'] ?? 'Tidak ada judul' }}</p>
                <p><strong>Brand:</strong> {{ $data['brand'] ?? 'Tidak ada brand' }}</p>
                <p><strong>Platform:</strong> {{ $data['platform'] ?? 'Tidak ada platform' }}</p>
                <p><strong>Deadline Produksi:</strong> {{ $data['deadline'] ?? 'Tidak ditentukan' }}</p>
            </div>

            <div class="task-info">
                <h3>📋 Detail Konten</h3>
                <p><strong>Deskripsi:</strong></p>
                <p>{{ $data['description'] ?? 'Tidak ada deskripsi' }}</p>
                
                <p><strong>Objective:</strong></p>
                <p>{{ $data['objective'] ?? 'Tidak ada objective' }}</p>
            </div>

            <div class="instructions">
                <h3>� Instruksi Tugas:</h3>
                <ol>
                    <li>Buka link brief lengkap menggunakan tombol di bawah</li>
                    <li>Isi ide tambahan dan kreativitas Anda</li>
                    <li>Upload hasil konten sesuai brief</li>
                    <li>Perhatikan deadline yang telah ditentukan</li>
                </ol>
            </div>
        </div>
        
        <div class="footer">
            <p>Email ini dikirim secara otomatis oleh sistem Pageflowry.</p>
            <p>Jika ada pertanyaan, silakan hubungi admin.</p>
        </div>
    </div>
</body>
</html>
