<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Investment;
use App\Models\VMM;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class InvestmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vmms = VMM::all();

        foreach ($vmms as $vmm) {
            Investment::create([
                'amount' => 100,
                'user_id' => User::first()->id,
                'vmm_id' => $vmm->id,
            ]);
        }
    }
}
