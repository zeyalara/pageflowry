<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ViewLog extends Command
{
    protected $signature = 'view:log {lines=20}';
    protected $description = 'View last lines of Laravel log';

    public function handle()
    {
        $lines = $this->argument('lines');
        $logFile = storage_path('logs/laravel.log');
        
        if (!file_exists($logFile)) {
            $this->error("Log file not found: {$logFile}");
            return Command::FAILURE;
        }
        
        $content = file_get_contents($logFile);
        $allLines = explode("\n", $content);
        $lastLines = array_slice($allLines, -$lines);
        
        foreach ($lastLines as $line) {
            $this->line($line);
        }
        
        return Command::SUCCESS;
    }
}
