<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory(9)->create();

        // $user = User::factory(9)->create();

        $user = User::factory()->create([
            "name" => 'George Hazboun',
            'email' => 'georgehazboun1997@gmail.com',
            'isAdmin' => '1'
        ]);



        Post::factory(6)->create();

        Comment::factory(6)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);


    }
}
