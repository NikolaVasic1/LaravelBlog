<?php

namespace App\Listeners;

use App\Events\PostCreated;
use App\Mail\ApproveComment;
use App\Mail\ApprovePost;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendPostApprovalMail
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
    public function handle(PostCreated $event): void
    {
        $adminMails = User::all()->where("is_admin", 1)->pluck('email');
        Mail::to($adminMails)->send(new ApprovePost($event->post));
    }
}
