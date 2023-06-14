<?php

namespace App\Listeners;

use App\Events\CommentCreated;
use App\Mail\ApproveComment;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendCommentApprovalMail
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(CommentCreated $event): void
    {
        $adminMails = User::all()->where("is_admin", 1)->pluck('email');
        Mail::to($adminMails)->send(new ApproveComment($event->comment));
    }
}
