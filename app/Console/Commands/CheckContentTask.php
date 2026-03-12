<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ContentTask;

class CheckContentTask extends Command
{
    protected $signature = 'check:content-task';
    protected $description = 'Check content tasks in database';

    public function handle()
    {
        $count = ContentTask::count();
        $this->info("Total Content Tasks: " . $count);
        
        $tasks = ContentTask::take(5)->get(['id', 'judul_konten', 'status', 'brand_id']);
        
        if ($tasks->isEmpty()) {
            $this->error("No content tasks found!");
        } else {
            foreach ($tasks as $task) {
                $this->line("ID: {$task->id}, Title: {$task->judul_konten}, Status: {$task->status}, Brand ID: {$task->brand_id}");
            }
        }
        
        return Command::SUCCESS;
    }
}
