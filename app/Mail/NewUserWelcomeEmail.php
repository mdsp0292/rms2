<?php

namespace App\Mail;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;

class NewUserWelcomeEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(public User $user)
    {
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.user.new',[
            'userName'     => $this->user->first_name,
            'welcomeUrl'   => URL::temporarySignedRoute('welcome', Carbon::now()->addDay(), ['user' => $this->user->id]),
            'urlExpiresIn' => Carbon::now()->addDay()->diffInRealMinutes()
        ])->subject('Welcome');
    }
}
