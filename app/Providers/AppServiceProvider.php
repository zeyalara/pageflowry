<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Force mailer to 'smtp' or 'mail' if currently set to 'log' in production
        // This helps if the hosting environment .env is not properly updated from .env.example
        if (config('mail.default') === 'log' && app()->environment('production')) {
            // Try SMTP first (assuming it might be configured but default is log)
            config(['mail.default' => 'smtp']);
            
            // If SMTP host is still 'mailpit' or 'localhost' (default Laravel values), 
            // fallback to 'mail' (PHP mail() function) which often works on shared hosting
            $smtpHost = config('mail.mailers.smtp.host');
            if (in_array($smtpHost, ['mailpit', 'localhost', '127.0.0.1', 'smtp.mailtrap.io'])) {
                config(['mail.default' => 'mail']);
            }
        }
    }
}
