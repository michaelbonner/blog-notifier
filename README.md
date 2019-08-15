# Blog Notifier

My parents are on a mission, and my family wants notifications about when they post a new blog post. This is just a way to accomplish that.


## Getting Started

1. Clone this repo
1. Copy .env.example to .env and configure the .env values
1. Run `composer install`
1. Run `php artisan key:generate`
1. Run `php artisan migrate`
1. Run `php artisan db:seed` to get some data to work with (Optional)