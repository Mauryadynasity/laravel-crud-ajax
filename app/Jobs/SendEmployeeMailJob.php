<?php

namespace App\Jobs;

use App\Mail\EmployeeRegisteredMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class SendEmployeeMailJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(public $user) {}

    public function handle(): void
    {
        Mail::to($this->user->email)
            ->queue(new EmployeeRegisteredMail($this->user));
    }
}
