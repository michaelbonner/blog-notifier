<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class BlogUser extends Pivot
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function blog()
    {
        return $this->belongsTo(Blog::class);
    }
}
