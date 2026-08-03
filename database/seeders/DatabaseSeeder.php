<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Student;
use App\Models\MataPelajaran;
use App\Models\Blog;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User Admin Default untuk login utama
        User::create([
            'name' => 'Admin Utama',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('12345678'),
            'role' => 'admin',
        ]);

        // Generate masing-masing 500 dummy records
        User::factory(500)->create();
        Student::factory(500)->create();
        MataPelajaran::factory(500)->create();
        Blog::factory(500)->create();
    }
}
