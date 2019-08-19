<?php

namespace App\Http\Controllers;

use Aloha\Twilio\Twilio;
use App\Models\BlogUser;
use App\Models\TwilioWebhook;
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
                ->delete();
        }

        return 'success';
    }
}
