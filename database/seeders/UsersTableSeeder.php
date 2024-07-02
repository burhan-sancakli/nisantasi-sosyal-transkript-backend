<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $activities = [
            ['id' => 1, 'parent_id' => null, 'name' => 'Projeler', 'description' => 'açıklama', 'score' => 40],
        ];
        foreach ($activities as $activity) {
            DB::table('activities')->insert([
                'id' => $activity['id'],
                'parent_id' => $activity['parent_id'],
                'name' => $activity['name'],
                'description' => $activity['description'],
                'score' => $activity['score'],
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
