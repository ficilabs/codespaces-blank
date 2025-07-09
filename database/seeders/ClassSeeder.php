<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Grade;
use App\Models\ClassGroup; // or `Classroom` if you renamed it

class ClassSeeder extends Seeder
{
    public function run(): void
    {
        $grades = Grade::all();

        foreach ($grades as $grade) {
            for ($i = 1; $i <= 3; $i++) {
                ClassGroup::create([
                    'grade_id' => $grade->id,
                    'group_number' => $i, // e.g. Kelas X-1, X-2, X-3
                ]);
            }
        }
    }
}
