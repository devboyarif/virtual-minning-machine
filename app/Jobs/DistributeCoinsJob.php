<?php

namespace App\Jobs;

use App\Enums\TransactionStatus;
use App\Enums\TransactionType;
use App\Models\VMM;
use App\Models\Investment;
use App\Models\Transaction;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class DistributeCoinsJob implements ShouldQueue
{
    use Queueable;

    protected $vmmId;

    public function __construct($vmmId)
    {
        $this->vmmId = $vmmId;
    }

    public function handle()
    {
        $vmm = VMM::find($this->vmmId);

        if ($vmm && $vmm->type === 'running') {
            $winner = $this->selectWinner($vmm);

            if ($winner) {
                $coinAmount = $this->calculateCoinDistribution($vmm);

                $this->createTransaction($winner['user_id'], $coinAmount);
            }
        }
    }

    protected function selectWinner($vmm)
    {
        $participants = Investment::where('vmm_id', $vmm->id)->get();

        $totalInvestment = $participants->sum('amount');

        $weightedParticipants = $participants->map(function ($participant) use ($totalInvestment) {
            $weight = $participant->amount / $totalInvestment;
            return [
                'id' => $participant->id,
                'user_id' => $participant->user_id,
                'weight' => $weight
            ];
        });

        $winner = $this->getWeightedRandomWinner($weightedParticipants);

        return $winner;
    }

    protected function getWeightedRandomWinner($participants)
    {
        $random = mt_rand(0, 10000) / 10000;
        $cumulativeWeight = 0;

        foreach ($participants as $participant) {
            $cumulativeWeight += $participant['weight'];
            if ($random <= $cumulativeWeight) {
                return $participant;
            }
        }

        return $participants->first();
    }

    protected function calculateCoinDistribution($vmm)
    {
        $totalCoins = $vmm->distribute_coin;
        $executionRounds = $vmm->lifetime * 60 / $vmm->execution_time;

        $coinsPerRound = floor($totalCoins / $executionRounds);

        return $coinsPerRound;
    }

    protected function createTransaction($userId, $coins)
    {
        Transaction::create([
            'user_id' => $userId,
            'amount' => $coins,
            'type' => TransactionType::Winning,
            'status' => TransactionStatus::Approved,
        ]);
    }
}
