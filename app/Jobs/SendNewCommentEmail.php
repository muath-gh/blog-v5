<?php

namespace App\Jobs;

use App\Mail\NewCommentAdded;
use App\Models\Comment;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class SendNewCommentEmail implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(public Comment $comment)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $to = "gharablipro2017@gmail.com";
        Mail::to($to)->send(new NewCommentAdded($this->comment));

    }
}
