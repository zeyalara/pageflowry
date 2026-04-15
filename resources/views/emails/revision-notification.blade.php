<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifikasi Revisi Konten</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px; background-color: #f4f4f4; }
        .container { background-color: #ffffff; border-radius: 10px; padding: 30px; box-shadow: 0 0 20px rgba(0,0,0,0.1); }
        .header { text-align: center; border-bottom: 2px solid #f59e0b; padding-bottom: 20px; margin-bottom: 30px; }
        .header h1 { color: #f59e0b; margin: 0; font-size: 28px; }
        .content { margin-bottom: 30px; }
        .task-info { background-color: #fffbeb; border-left: 4px solid #f59e0b; padding: 20px; margin: 20px 0; border-radius: 5px; }
        .task-info h3 { color: #d97706; margin-top: 0; }
        .cta-button { display: inline-block; background-color: #f59e0b; color: white; padding: 15px 30px; text-decoration: none; border-radius: 5px; font-weight: bold; margin: 20px 0; text-align: center; }
        .footer { text-align: center; margin-top: 30px; padding-top: 20px; border-top: 1px solid #e5e7eb; color: #6b7280; font-size: 14px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🔄 Revisi Diperlukan</h1>
            <p>Ada beberapa perbaikan yang diperlukan untuk konten Anda</p>
        </div>

        <div class="content">
            <div class="task-info">
                <h3>📝 Detail Tugas & Revisi</h3>
                <p><strong>Judul Konten:</strong> {{ $data['title'] }}</p>
                <p><strong>Brand:</strong> {{ $data['brand'] }}</p>
                <p><strong>Catatan Revisi:</strong><br>{{ $data['revision_note'] }}</p>
                <p><strong>Deadline Revisi:</strong> {{ $data['deadline'] }}</p>
            </div>

            <p>Silakan klik tombol di bawah ini untuk melihat brief lengkap dan mengunggah hasil revisi Anda:</p>
            
            <div style="text-align: center;">
                <a href="{{ $data['upload_link'] }}" class="cta-button">Upload Hasil Revisi</a>
            </div>

            <p>Jika Anda memiliki pertanyaan, silakan hubungi admin melalui email ini.</p>
        </div>

        <div class="footer">
            <p>© {{ date('Y') }} PageFlowry - Sistem Manajemen Konten</p>
        </div>
    </div>
</body>
</html>
