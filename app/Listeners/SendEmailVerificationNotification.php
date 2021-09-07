<?php

namespace App\Listeners;

use App\Events\User\Registered;
use App\Models\EmailVerification;

class SendEmailVerificationNotification
{
    /**
     * Handle the event.
     *
     * @param Registered $event
     *
     * @return void
     */
    public function handle(Registered $event)
    {
        if (!$event->user->hasVerifiedEmail()) {
            /** @var EmailVerification $emailVerification */
            $emailVerification = $event->user->emailVerifications()->create([
                'user_id' => $event->user->id,
                'email' => $event->user->email,
                'verification_code' => rand(1000, 9999),
            ]);

            $event->user->notifyByEmailVerification($emailVerification);

            $emailVerification->sent_at = now();
            $emailVerification->save();
        }
    }
}
