<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Student;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Student::insert([
        //     [
        //         'name' => 'pandu',
        //         'email' => 'pandu@gmail.com',
        //         'phone' => '085155161156',
        //         'address' => 'jakpus',
        //     ],
        //     [
        //         'name' => 'rex',
        //         'email' => 'rex@gmail.com',
        //         'phone' => '089630747656',
        //         'address' => 'jakut',
        //     ],
        // ]);
        Student::factory(50)->create();
    }
}
