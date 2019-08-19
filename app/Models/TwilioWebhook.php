<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TwilioWebhook extends Model
{
    protected $guarded = [];

    protected $casts = [
        'data' => 'array'
    ];

    public function isRequestingUnsubscribe()
    {
        return strstr($this->data['Body'], 'stop') ? true : false;
    }
}
