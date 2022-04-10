<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Post::create([
            'id' => 1,
            'title' => 'First post',
            'content' => '[
                {
                    "key": "first_layout",
                    "layout": "wysiwyg",
                    "attributes": {
                        "title": "Hello there",
                        "content": "Testing"
                    }
                },
                {
                    "key": "second_layout",
                    "layout": "video",
                    "attributes": {
                        "title": "Lorem ipsum",
                        "video": "1234567890",
                        "caption": "Test caption",
                        "thumbnail": "CnXb4ONF0YpDP8OaZ6ct5volOmaaDHW9WsUNToxF.png"
                    }
                }
            ]'
        ]);
    }
}
