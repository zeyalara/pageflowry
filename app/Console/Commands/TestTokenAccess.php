<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class TestTokenAccess extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:token-access';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test token-based access system for content briefs';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Testing Token-Based Access System...');
        
        // Get a brief from database
        $brief = \App\Models\ContentBrief::first();
        if (!$brief) {
            $this->error('No brief found in database');
            return 1;
        }
        
        $this->info('Brief found: ' . $brief->title);
        $this->info('Brief ID: ' . $brief->id);
        $this->info('User ID: ' . $brief->user_id);
        
        // Generate or get public token
        $token = $brief->getPublicToken();
        $this->info('Public Token: ' . $token);
        
        // Generate public URL
        $publicUrl = $brief->publicViewUrl();
        $this->info('Public URL: ' . $publicUrl);
        
        // Test if token is saved in database
        $savedBrief = \App\Models\ContentBrief::where('share_token', $token)->first();
        if ($savedBrief) {
            $this->info('SUCCESS: Token saved in database');
        } else {
            $this->error('ERROR: Token not found in database');
        }
        
        // Test route exists
        $routeExists = \Illuminate\Support\Facades\Route::has('brief.public');
        $this->info('Route brief.public exists: ' . ($routeExists ? 'YES' : 'NO'));
        
        // Test if controller method exists
        $controller = new \App\Http\Controllers\ContentBriefController();
        $methodExists = method_exists($controller, 'showByToken');
        $this->info('Controller method showByToken exists: ' . ($methodExists ? 'YES' : 'NO'));
        
        // Test if view exists
        $viewExists = view()->exists('public.brief');
        $this->info('View public.brief exists: ' . ($viewExists ? 'YES' : 'NO'));
        
        // Test URL structure
        $expectedUrl = config('app.url') . '/brief/' . $token;
        $this->info('Expected URL: ' . $expectedUrl);
        
        if ($publicUrl === $expectedUrl) {
            $this->info('SUCCESS: URL structure is correct');
        } else {
            $this->error('ERROR: URL structure mismatch');
        }
        
        $this->info('');
        $this->info('Token-Based Access System is ready!');
        $this->info('Access URL: ' . $publicUrl);
        $this->info('Format: /brief/{token}');
        
        return 0;
    }
}
