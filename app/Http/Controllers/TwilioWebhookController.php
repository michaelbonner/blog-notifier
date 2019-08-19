<?php

namespace App\Http\Controllers;

use App\Models\TwilioWebhook;
use App\Models\Unsubscriber;
use Illuminate\Http\Request;

class TwilioWebhookController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $twilioWebhook = TwilioWebhook::create([
            'data' => $request->all()
        ]);

        if ($twilioWebhook->isRequestingUnsubscribe()) {
            BlogUser::where('notify_via', 'sms')
                ->where('notify_location', $twilioWebhook->data['From'])
                ->get()
                ->each(function ($blogUser) {
                    $twilio = new Twilio(
                        config('services.twilio.account_id'),
                        config('services.twilio.token'),
                        config('services.twilio.number')
                    );
                    $twilio->message(
                        $twilioWebhook->data['From'],
                        "You will no longer receive text messages from Blog Notifier. Thank you for using our application."
                    );
                })
                ->delete();
        }

        return 'success';
    }
}
