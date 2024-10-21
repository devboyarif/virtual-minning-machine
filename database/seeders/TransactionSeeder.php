<?php

namespace Database\Seeders;

use App\Models\VMM;
use App\Models\User;
use App\Models\Transaction;
use App\Enums\TransactionType;
use Illuminate\Database\Seeder;
use App\Enums\TransactionStatus;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create some transactions
        Transaction::create([
            'user_id' => User::first()->id,
            'vmm_id' => VMM::inRandomOrder()->value('id'),
            'amount' => 100,
            'type' => TransactionType::Investment,
            'status' => TransactionStatus::Approved,
        ]);

        Transaction::create([
            'user_id' => User::first()->id,
            'vmm_id' => Vmm::inRandomOrder()->value('id'),
            'amount' => 50,
            'type' => TransactionType::Winning,
            'status' => TransactionStatus::Approved,
        ]);

        Transaction::create([
            'user_id' => User::first()->id,
            'vmm_id' => Vmm::inRandomOrder()->value('id'),
            'amount' => 200,
            'type' => TransactionType::Withdrawal,
            'status' => TransactionStatus::Approved,
        ]);

        Transaction::create([
            'user_id' => User::first()->id,
            'vmm_id' => VMM::inRandomOrder()->value('id'),
            'amount' => 100,
            'type' => TransactionType::Investment,
            'status' => TransactionStatus::Approved,
        ]);

        Transaction::create([
            'user_id' => User::first()->id,
            'vmm_id' => Vmm::inRandomOrder()->value('id'),
            'amount' => 50,
            'type' => TransactionType::Winning,
            'status' => TransactionStatus::Approved,
        ]);

        Transaction::create([
            'user_id' => User::first()->id,
            'vmm_id' => Vmm::inRandomOrder()->value('id'),
            'amount' => 200,
            'type' => TransactionType::Withdrawal,
            'status' => TransactionStatus::Pending,
        ]);
        Transaction::create([
            'user_id' => User::first()->id,
            'vmm_id' => Vmm::inRandomOrder()->value('id'),
            'amount' => 200,
            'type' => TransactionType::Withdrawal,
            'status' => TransactionStatus::Rejected,
        ]);
    }
}
