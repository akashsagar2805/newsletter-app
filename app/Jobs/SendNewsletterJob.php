<?php

namespace App\Jobs;

use App\Models\User;
use App\Models\Newsletter;
use App\Mail\NewsletterMail;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendNewsletterJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $newsletter;
    public $user;

    public function __construct(Newsletter $newsletter, User $user)
    {
        $this->newsletter = $newsletter;
        $this->user = $user;
    }

    public function handle()
    {
        Mail::to($this->user->email)->send(new NewsletterMail($this->newsletter));

        $this->newsletter->users()->updateExistingPivot($this->user->id, [
            'is_sent' => true,
        ]);

        $this->checkIfNewsletterCompleted($this->newsletter);
    }

    private function checkIfNewsletterCompleted(Newsletter $newsletter)
    {
        $usersNotSentCount = $newsletter->users()->wherePivot('is_sent', false)->count();

        if ($usersNotSentCount === 0) {
            $newsletter->update(['process_status' => 'completed']);
        }
    }
}
