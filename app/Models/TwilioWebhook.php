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
        if (empty($this->data['Body'])) {
            return false;
        }
        return preg_match('/stop/i', $this->data['Body']);
    }
}
