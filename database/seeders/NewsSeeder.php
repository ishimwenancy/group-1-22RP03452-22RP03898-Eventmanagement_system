<?php

namespace Database\Seeders;

use App\Models\News;
use App\Models\User;
use Illuminate\Database\Seeder;

class NewsSeeder extends Seeder
{
    public function run()
    {
        $admin = User::where('role', 'admin')->first();
        if (!$admin) {
            $this->command->error('Admin user not found. Please run AdminSeeder first.');
            return;
        }

        $news = [
            [
                'title' => 'Welcome to Event Manager',
                'excerpt' => 'Discover our new event management platform designed to make event planning and booking easier than ever.',
                'content' => 'We are excited to announce the launch of our new event management platform. This platform is designed to help you discover, plan, and book events with ease. Whether you\'re looking to attend a conference, workshop, or social gathering, our platform has something for everyone.',
                'author_id' => $admin->id,
                'is_published' => true,
                'published_at' => now()
            ],
            [
                'title' => 'Upcoming Feature: Mobile App',
                'excerpt' => 'Stay tuned for our upcoming mobile app that will make event management even more convenient.',
                'content' => 'We\'re working hard on developing a mobile app that will bring all the features of our platform to your smartphone. Soon you\'ll be able to manage your events on the go, receive real-time notifications, and more.',
                'author_id' => $admin->id,
                'is_published' => true,
                'published_at' => now()
            ],
            [
                'title' => 'Event Planning Tips',
                'excerpt' => 'Learn the best practices for planning successful events from our experienced team.',
                'content' => 'Planning an event can be challenging, but with the right approach, it can be a smooth and enjoyable process. In this article, we share some of our top tips for planning successful events, from choosing the right venue to managing registrations.',
                'author_id' => $admin->id,
                'is_published' => false,
                'published_at' => null
            ]
        ];

        foreach ($news as $article) {
            News::create($article);
        }
    }
}
