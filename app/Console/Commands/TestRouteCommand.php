<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class TestRouteCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:route';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test route resolution for token-based access';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Testing Route Resolution...');
        
        // Get all routes
        $routes = app('router')->getRoutes();
        
        $found = false;
        foreach ($routes as $route) {
            if ($route->uri() === 'brief/{token}') {
                $this->info('SUCCESS: Route found!');
                $this->info('URI: ' . $route->uri());
                $this->info('Name: ' . $route->getName());
                $this->info('Action: ' . $route->getActionName());
                $this->info('Methods: ' . implode(', ', $route->methods()));
                
                // Check if route has middleware
                $middleware = $route->middleware();
                if (empty($middleware)) {
                    $this->info('Middleware: None (Public Access)');
                } else {
                    $this->info('Middleware: ' . implode(', ', $middleware));
                }
                
                $found = true;
                break;
            }
        }
        
        if (!$found) {
            $this->error('ERROR: Route brief/{token} not found!');
            return 1;
        }
        
        // Test route exists check
        $routeExists = \Illuminate\Support\Facades\Route::has('brief.public');
        $this->info('Route facade check: ' . ($routeExists ? 'YES' : 'NO'));
        
        // Test controller method
        $controller = new \App\Http\Controllers\ContentBriefController();
        $methodExists = method_exists($controller, 'showByToken');
        $this->info('Controller method exists: ' . ($methodExists ? 'YES' : 'NO'));
        
        $this->info('');
        $this->info('Route resolution test completed!');
        
        return 0;
    }
}
