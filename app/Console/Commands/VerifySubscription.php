<?php

namespace App\Console\Commands;

use App\Models\BlogUser;
use App\Services\Twilio;
use Carbon\Carbon;
use Illuminate\Console\Command;

class VerifySubscription extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscription:verify';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        BlogUser::whereNull('verified_at')->each(function ($blogUser) {
            Twilio::sendMessage(
                $blogUser->notify_location,
                "Hey! It's your brother Mike. You'll be getting a text when the parents add a new post to their blog. If you don't want this, just reply stop."
            );
            $blogUser->verified_at = Carbon::now();
            $blogUser->save();
        });
    }
}
