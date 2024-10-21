<?php

namespace Database\Seeders;

use App\Models\VMM;
use App\Enums\VMMStatus;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class VMMSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        VMM::insert([
            [
                'title' => 'VMM zero',
                'lifetime' => 5,
                'minimum_invest' => 10,
                'distribute_coin' => 50,
                'execution_time' => 10,
                'preparation_time' => 1,
                'start_time' => now()->addDays(1),
                'type' => VMMStatus::Draft,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'VMM 1',
                'lifetime' => 120,
                'minimum_invest' => 200,
                'distribute_coin' => 500,
                'execution_time' => 60,
                'preparation_time' => 30,
                'start_time' => now()->addDays(1),
                'type' => VMMStatus::Draft,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'VMM 2',
                'lifetime' => 90,
                'minimum_invest' => 200,
                'distribute_coin' => 1000,
                'execution_time' => 45,
                'preparation_time' => 20,
                'start_time' => now()->addDays(2),
                'type' => VMMStatus::Active,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'VMM 3',
                'lifetime' => 150,
                'minimum_invest' => 500,
                'distribute_coin' => 250,
                'execution_time' => 90,
                'preparation_time' => 40,
                'start_time' => now()->addDays(3),
                'type' => VMMStatus::Draft,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
