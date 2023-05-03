<?php
 
namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use App\Models\EmailVerifyHistory;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class VerifyAccount extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function build()
    {
        $site = config('site.name');
        $last = EmailVerifyHistory::where('user_id', $this->user->id)->first();

        return $this->subject("Verify your {$site} account")->view('emails.verify_account')->with([
            'code' => $last->code
        ]);
    }
}
