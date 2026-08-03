<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('blogs')->insert([
            [
                'title' => 'Why Lead Generation is Key for Business Growth',
                'sub_content' => 'A small river named Duden flows by their place and supplies it with the necessary regelialia.',
                'content' => 'A small river named Duden flows by their place and supplies it with the necessary regelialia. It is a paradisematic country, in which roasted parts of sentences fly into your mouth.',
                'date' => '2019-06-21',
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Why Lead Generation is Key for Business Growth',
                'sub_content' => 'A small river named Duden flows by their place and supplies it with the necessary regelialia.',
                'content' => 'A small river named Duden flows by their place and supplies it with the necessary regelialia. It is a paradisematic country, in which roasted parts of sentences fly into your mouth.',
                'date' => '2019-06-21',
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Why Lead Generation is Key for Business Growth',
                'sub_content' => 'A small river named Duden flows by their place and supplies it with the necessary regelialia.',
                'content' => 'A small river named Duden flows by their place and supplies it with the necessary regelialia. It is a paradisematic country, in which roasted parts of sentences fly into your mouth.',
                'date' => '2019-06-21',
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
