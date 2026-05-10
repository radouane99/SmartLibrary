<?php

namespace App\Console\Commands;

use App\Models\Emprunt;
use App\Mail\LateBookNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class SendLateBookNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'library:notify-late-books';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send email notifications to users who have overdue book returns.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Checking for late books...');

        $lateEmprunts = Emprunt::with(['user', 'livre'])
            ->where('dateRetour', '<', Carbon::today()->toDateString())
            ->get();

        if ($lateEmprunts->isEmpty()) {
            $this->info('No late books found today.');
            return;
        }

        $count = 0;
        foreach ($lateEmprunts as $emprunt) {
            if ($emprunt->user && $emprunt->user->email) {
                Mail::to($emprunt->user->email)->send(new LateBookNotification($emprunt));
                $count++;
            }
        }

        $this->info("Successfully sent {$count} late book notifications.");
    }
}
