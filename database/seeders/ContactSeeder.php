<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('contacts')->insert([
            [
                'name' => 'Budi Santoso',
                'email' => 'budi@example.com',
                'subject' => 'Tanya Informasi',
                'message' => 'Halo, saya ingin bertanya mengenai layanan ini.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Siti Rahma',
                'email' => 'siti@example.com',
                'subject' => 'Laporan Kendala',
                'message' => 'Ada kendala saat saya mencoba login tadi pagi.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
