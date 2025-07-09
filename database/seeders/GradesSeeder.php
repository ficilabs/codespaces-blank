<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Grade;

class GradesSeeder extends Seeder
{
    public function run(): void
    {
        Grade::insert([
            ['name' => 'X'],
            ['name' => 'XI'],
            ['name' => 'XII'],
        ]);
    }
}
