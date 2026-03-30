<?php

// Halaman untuk melihat email yang dikirim (untuk testing)
$logFile = storage_path('logs/laravel.log');
$logContent = file_exists($logFile) ? file_get_contents($logFile) : '';

// Extract email content dari log
$emails = [];
$lines = explode("\n", $logContent);
$currentEmail = null;
$inEmailContent = false;

foreach ($lines as $line) {
    if (strpos($line, 'creator notification email sent') !== false) {
        if ($currentEmail) {
            $emails[] = $currentEmail;
        }
        $currentEmail = [
            'timestamp' => substr($line, 1, 19),
            'info' => json_decode(substr($line, strpos($line, '{')), true),
            'content' => ''
        ];
        $inEmailContent = true;
    } elseif ($inEmailContent && strpos($line, '<!DOCTYPE html>') !== false) {
        $currentEmail['content'] = $line;
        $inEmailContent = false;
    } elseif ($inEmailContent && trim($line)) {
        $currentEmail['content'] .= $line;
    }
}

if ($currentEmail) {
    $emails[] = $currentEmail;
}

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Log Viewer - Pageflowry</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .email-preview {
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            overflow: hidden;
        }
        .email-content {
            max-height: 600px;
            overflow-y: auto;
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="container mx-auto p-6">
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h1 class="text-2xl font-bold text-gray-800 mb-6">📧 Email Log Viewer</h1>
            
            <?php if (empty($emails)): ?>
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                    <p class="text-yellow-800">📭 Belum ada email yang dikirim.</p>
                    <p class="text-sm text-yellow-600 mt-2">Buat brief baru dengan email creator untuk mengirim email.</p>
                </div>
            <?php else: ?>
                <?php foreach (array_reverse($emails) as $index => $email): ?>
                    <div class="email-preview mb-6">
                        <div class="bg-gray-50 p-4 border-b">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="font-semibold text-gray-800">Email #<?= $index + 1 ?></h3>
                                    <p class="text-sm text-gray-600">📅 <?= $email['timestamp'] ?></p>
                                    <p class="text-sm text-blue-600">📧 Ke: <?= $email['info']['creator_email'] ?></p>
                                    <p class="text-sm text-green-600">✅ Status: Terkirim (Log)</p>
                                </div>
                                <button onclick="toggleEmail(<?= $index ?>)" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">
                                    Lihat Email
                                </button>
                            </div>
                        </div>
                        <div id="email-<?= $index ?>" class="email-content bg-white p-4" style="display: none;">
                            <?= $email['content'] ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
            
            <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
                <h3 class="font-semibold text-blue-800 mb-2">📝 Catatan:</h3>
                <ul class="text-sm text-blue-700 space-y-1">
                    <li>• Email saat ini menggunakan <strong>log driver</strong> (disimpan di file log)</li>
                    <li>• Untuk mengirim email nyata, update .env dengan SMTP configuration</li>
                    <li>• Gunakan Gmail App Password untuk authentication</li>
                    <li>• Setelah setup, email akan terkirim ke inbox creator</li>
                </ul>
            </div>
        </div>
    </div>

    <script>
        function toggleEmail(index) {
            const emailDiv = document.getElementById('email-' + index);
            emailDiv.style.display = emailDiv.style.display === 'none' ? 'block' : 'none';
        }
    </script>
</body>
</html>
