<?php

use App\Models\Blog;
use App\Models\User;
use Illuminate\Database\Seeder;

class BlogsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Blog::class, 10)->create()->each(function ($blog) {
            $blog->users()->attach(User::inRandomOrder()->first(), [
                'notify_via' => 'sms',
                'notify_location' => '+18018315287'
            ]);
        });
    }
}
