<?php

namespace Database\Seeders;

use App\Models\Job;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class JobSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        for($i = 0; $i < 20; $i++) {
            \DB::table('jobs_titles')->insert([
                'title' => $faker->jobTitle(),
                'description' => $faker->sentence()
            ]);
        }
    }
}
