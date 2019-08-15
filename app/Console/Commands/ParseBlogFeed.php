<?php

namespace App\Console\Commands;

use Aloha\Twilio\Twilio;
use App\Jobs\NewBlogPost;
use App\Models\Blog;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use willvincent\Feeds\Facades\FeedsFacade;

class ParseBlogFeed extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'feed:parse';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parse the blog feeds';

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
        Blog::each(function ($blog) {
            if (config('app.debug')) {
                $this->line('Deleting a post');
                $blog->posts->sortBy('created_at')->last()->delete();
            }

            $this->line('Parsing feed: ' . $blog->name);
            $feed = FeedsFacade::make($blog->feed_url);
            foreach ($feed->get_items() as $item) {
                if ($blog->posts()->where('guid', $item->get_id())->count()) {
                    continue;
                }

                $postDate = Carbon::parse($item->get_date());

                $post = $blog->posts()->create([
                    'guid' => $item->get_id(),
                    'created_at' => $postDate,
                ]);

                if ($postDate->diffInDays(Carbon::now()) > 1) {
                    continue;
                }

                $post->blog->users->each(function ($user) use ($post, $item) {
                    $twilio = new Twilio(
                        config('services.twilio.account_id'),
                        config('services.twilio.token'),
                        config('services.twilio.number')
                    );
                    $twilio->message(
                        $user->pivot->notify_location,
                        "New blog post:\n" . $post->blog->name . "\n" . $item->get_title() . "\n" . $post->guid
                    );
                });
            }
        });
    }
}
