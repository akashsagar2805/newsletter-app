<?php

namespace App\Http\Controllers;

use App\Jobs\SendNewsletterJob;
use App\Models\Newsletter;
use App\Models\User;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    public function index()
    {
        $newsletters = Newsletter::all();

        foreach ($newsletters as $newsletter) {
            $newsletters = Newsletter::withCount(['users as total_users', 'sentUsers as sent_count'])
                ->get();
        }

        return view('newsletters.index', compact('newsletters'));
    }

    public function create()
    {
        return view('newsletters.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'scheduled_at' => 'required|date|after:now',
        ]);

        $newsletter = Newsletter::create($validated + ['process_status' => 'pending']);
        return redirect()->route('newsletters.index')->with('success', 'Newsletter created successfully.');
    }

    public function start(Newsletter $newsletter)
    {
        $newsletter->update(['process_status' => 'started']);

        $users = User::whereDoesntHave('newsletters', function ($query) use ($newsletter) {
            $query->where('newsletter_id', $newsletter->id)
                ->where('is_sent', true);
        })->get();

        foreach ($users as $user) {
            $newsletter->users()->attach($user->id, [
                'is_sent' => false,
            ]);
        }

        foreach ($users as $index => $user) {
            SendNewsletterJob::dispatch($newsletter, $user)
                ->delay(now()->addMinutes($index * 5));
        }

        return redirect()->route('newsletters.index')
            ->with('success', 'Newsletter has been started successfully!');
    }
}
