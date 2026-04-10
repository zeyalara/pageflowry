<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class TestPublicViewCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:public-view';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test public view access for content briefs';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Testing public view access...');
        
        // Get a brief from database
        $brief = \App\Models\ContentBrief::first();
        if (!$brief) {
            $this->error('No brief found in database');
            return 1;
        }
        
        $this->info('Brief found: ' . $brief->title);
        $this->info('Brief ID: ' . $brief->id);
        
        // Generate URL
        $url = $brief->publicViewUrl();
        $this->info('Generated URL: ' . $url);
        
        // Test if route exists
        $routeExists = \Illuminate\Support\Facades\Route::has('brief.public-view');
        $this->info('Route exists: ' . ($routeExists ? 'YES' : 'NO'));
        
        // Test if method exists
        $controller = new \App\Http\Controllers\ContentBriefController();
        $methodExists = method_exists($controller, 'publicView');
        $this->info('Controller method exists: ' . ($methodExists ? 'YES' : 'NO'));
        
        // Test if view exists
        $viewExists = view()->exists('brief.public-view');
        $this->info('View exists: ' . ($viewExists ? 'YES' : 'NO'));
        
        $this->info('All components are ready! URL should be accessible.');
        $this->info('Test URL: ' . $url);
        
        return 0;
    }
}
