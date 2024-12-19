<?php

namespace App\Console\Commands;

use App\Jobs\SendNewsletterJob;
use App\Models\Newsletter;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ProcessScheduledNewsletters extends Command
{
    protected $signature = 'newsletters:process';
    protected $description = 'Process and dispatch newsletters scheduled at the current time';

    public function handle()
    {
        $now = Carbon::now();
        $newsletters = Newsletter::where('process_status', 'started')
            ->where('scheduled_at', '>=', $now)
            ->get();

        foreach ($newsletters as $newsletter) {
            $users = \App\Models\User::all();
            foreach ($users as $index => $user) {
                SendNewsletterJob::dispatch($newsletter, $user)
                    ->delay(now()->addSeconds(5 * $index));
            }


            $this->checkIfNewsletterCompleted($newsletter);
        }

        $this->info('Newsletters processed successfully.');
    }

    private function checkIfNewsletterCompleted(Newsletter $newsletter)
    {
        $usersNotSentCount = $newsletter->users()->wherePivot('is_sent', false)->count();

        if ($usersNotSentCount === 0) {
            $newsletter->update(['process_status' => 'completed']);
        }
    }
}
