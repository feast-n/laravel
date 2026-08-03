<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MataPelajaran;

class MataPelajaranSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['nama_pelajaran' => 'Matematika'],
            ['nama_pelajaran' => 'Bahasa Indonesia'],
            ['nama_pelajaran' => 'Bahasa Inggris'],
            ['nama_pelajaran' => 'IPA'],
            ['nama_pelajaran' => 'IPS'],
        ];

        foreach ($data as $item) {
            MataPelajaran::create($item);
        }
    }
}
