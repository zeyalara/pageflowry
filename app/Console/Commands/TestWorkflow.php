<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ContentTask;
use App\Models\Production;

class TestWorkflow extends Command
{
    protected $signature = 'test:workflow';
    protected $description = 'Test workflow connection between Production, Revision, and Approval';

    public function handle()
    {
        $this->info('Testing workflow connection...');
        
        // Update some tasks to different statuses
        $task2 = ContentTask::find(2);
        if ($task2) {
            $task2->update(['status' => 'under_review']);
            $this->info('Task 2 updated to under_review');
            
            // Create production record
            Production::create([
                'content_task_id' => 2,
                'judul_konten' => $task2->judul_konten,
                'versi_video' => 'v1.0',
                'durasi_final' => '2:30',
                'catatan_produksi' => 'Test production notes',
                'file_video' => 'productions/sample_video.mp4',
                'status' => 'production'
            ]);
            $this->info('Production record created for task 2');
        }
        
        $task4 = ContentTask::find(4);
        if ($task4) {
            $task4->update(['status' => 'ready_for_approval']);
            $this->info('Task 4 updated to ready_for_approval');
        }
        
        // Show current status
        $this->info("\nCurrent Content Tasks Status:");
        $tasks = ContentTask::with('productions')->get();
        foreach ($tasks as $task) {
            $production = $task->productions->first();
            $this->line("ID: {$task->id} - {$task->judul_konten} - Status: {$task->status}" . 
                ($production ? " - Production: {$production->versi_video}" : " - No Production"));
        }
        
        $this->info("\nWorkflow should show:");
        $this->info("- Production: All tasks (4 tasks)");
        $this->info("- Revision: All tasks (4 tasks) - should show task 2 with under_review status");
        $this->info("- Approval: All tasks (4 tasks) - should show task 4 with ready_for_approval status");
        
        return Command::SUCCESS;
    }
}
