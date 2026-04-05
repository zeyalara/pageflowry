<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('content_tasks', function (Blueprint $table) {
            $table->foreignId('user_id')
                ->nullable()
                ->after('id')
                ->constrained('users')
                ->onDelete('cascade');
        });

        // Backfill: tie existing tasks to the creator (if present).
        DB::table('content_tasks')
            ->whereNull('user_id')
            ->whereNotNull('creator_id')
            ->update(['user_id' => DB::raw('creator_id')]);

        // If there is only one user in the system, assign remaining nulls to that user.
        $onlyUser = User::query()->select('id')->orderBy('id')->get();
        if ($onlyUser->count() === 1) {
            DB::table('content_tasks')
                ->whereNull('user_id')
                ->update(['user_id' => $onlyUser->first()->id]);
        }
    }

    public function down(): void
    {
        Schema::table('content_tasks', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
};

