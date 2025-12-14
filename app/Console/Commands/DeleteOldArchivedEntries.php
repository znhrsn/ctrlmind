<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DeleteOldArchivedEntries extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:delete-old-archived-entries';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        JournalEntry::where('archived', true)
            ->where('archived_at', '<', now()->subDays(30))
            ->delete();

        $this->info('Old archived entries deleted successfully.');
    }
}