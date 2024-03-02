<?php

namespace App\Console\Commands\Admin;

use App\Models\ActivityLog;
use Illuminate\Console\Command;

class ActivityLogPrune extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'c:admin:activity.prune {--days=30} {--keep=1000}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Prune the activity log to remove old entries.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $days = $this->option('days');
        $keep = $this->option('keep');

        $totalBefore = ActivityLog::count();
        ActivityLog::where('created_at', '<=', now()->subDays($days))->delete();

        $recordsToKeep = ActivityLog::latest()->take($keep)->get();
        ActivityLog::whereNotIn('id', $recordsToKeep->pluck('id'))->delete();

        $totalAfter = ActivityLog::count();

        $this->info('Activity log has been pruned. Total records deleted: '.($totalBefore - $totalAfter));
    }
}
