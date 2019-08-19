<?php

namespace App\Http\Controllers;

use App\TwilioWebhook;
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
        TwilioWebhook::create([
            'data' => $request->all()
        ]);
        return 'success';
    }
}
