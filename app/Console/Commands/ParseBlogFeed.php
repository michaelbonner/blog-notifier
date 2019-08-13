<?php

namespace App\Console\Commands;

use App\Jobs\NewBlogPost;
use App\Models\Blog;
use Illuminate\Console\Command;
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
            $this->line('Parsing feed: ' . $blog->name);
            $feed = FeedsFacade::make($blog->feed_url);
            foreach ($feed->get_items() as $item) {
                if ($blog->posts()->where('guid', $item->get_id())->count()) {
                    continue;
                }
                $post = $blog->posts()->create([
                    'guid' => $item->get_id()
                ]);
                dispatch(new NewBlogPost($post));
            }
        });
    }
}
