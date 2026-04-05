<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class MailTestCommand extends Command
{
    protected $signature = 'mail:test {email : Inbox untuk tes SMTP saja (bukan konfigurasi penerima tetap)}';

    protected $description = 'Tes koneksi SMTP (.env). Email creator asli tetap dari form brief, bukan dari sini.';

    public function handle(): int
    {
        $to = $this->argument('email');

        $this->line('Mailer aktif: <fg=cyan>'.config('mail.default').'</>');
        $this->line('Host: <fg=cyan>'.(config('mail.mailers.smtp.host') ?? '—').'</> Port: <fg=cyan>'.(config('mail.mailers.smtp.port') ?? '—').'</>');
        $this->line('User: <fg=cyan>'.(config('mail.mailers.smtp.username') ? '(terisi)' : '(KOSONG — wajib diisi)').'</>');
        $this->line('From: <fg=cyan>'.config('mail.from.address').'</>');
        $this->newLine();

        if (config('mail.default') === 'log') {
            $this->warn('MAIL_MAILER=log → email hanya ke file storage/logs, BUKAN ke inbox.');
            $this->warn('Ubah .env: MAIL_MAILER=smtp lalu php artisan config:clear');

            return 1;
        }

        $user = config('mail.mailers.smtp.username');
        if (! $user || str_contains((string) $user, 'youremail') || str_contains((string) $user, 'your-email')) {
            $this->error('MAIL_USERNAME masih placeholder atau kosong. Isi email Gmail / SMTP asli di .env');
            $this->line('Gmail: pakai App Password (bukan password login biasa).');

            return 1;
        }

        try {
            Mail::raw(
                "Ini email tes dari Pageflowry.\r\n\r\nJika pesan ini masuk inbox, SMTP sudah benar.\r\nWaktu: ".now()->toDateTimeString(),
                function ($message) use ($to) {
                    $message->to($to)
                        ->subject('Tes email Pageflowry — SMTP OK');
                }
            );

            $this->info('Berhasil mengirim. Cek inbox / folder Spam di: '.$to);

            return 0;
        } catch (\Throwable $e) {
            $this->error('Gagal mengirim: '.$e->getMessage());
            $this->newLine();
            $this->line('Hal yang sering salah:');
            $this->line('  • Password Gmail harus App Password (Google → Keamanan → Sandi aplikasi).');
            $this->line('  • MAIL_FROM_ADDRESS harus sama dengan MAIL_USERNAME untuk Gmail.');
            $this->line('  • Setelah ubah .env: php artisan config:clear');
            $this->line('  • Firewall/antivirus memblokir port 587 — coba jaringan lain.');
            $this->line('  • Windows SSL: coba tambah di .env MAIL_VERIFY_PEER=false lalu config:clear (hanya untuk tes).');

            return 1;
        }
    }
}
