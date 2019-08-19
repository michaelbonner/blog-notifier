<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TwilioWebhook extends Model
{
    protected $guarded = [];

    protected $casts = [
        'data' => 'array'
    ];
}
