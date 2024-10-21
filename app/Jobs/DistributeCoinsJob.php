<?php

namespace App\Jobs;

use App\Models\VMM;
use App\Models\User;
use App\Models\Investment;
use App\Models\Transaction;
use App\Enums\TransactionType;
use App\Enums\TransactionStatus;
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
        info('vmm from distributeCoinsJob');

        $vmm = VMM::find($this->vmmId);

        if ($vmm && $vmm->type === 'running') {
            $winner = $this->selectWinner($vmm);

            if ($winner) {
                $coinAmount = $this->calculateCoinDistribution($vmm);

                $this->createTransaction($winner['user_id'], $coinAmount, $vmm->id);
            }
        }
    }

    protected function selectWinner($vmm)
    {
        info('vmm from selectWinner');

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

        info('Winner is user id' . $winner['user_id']);

        return $winner;
    }

    protected function getWeightedRandomWinner($participants)
    {
        info('vmm from getWeightedRandomWinner');

        $random = mt_rand(0, 10000) / 10000;
        $vmm_weight = 0;

        foreach ($participants as $participant) {
            $vmm_weight += $participant['weight'];
            if ($random <= $vmm_weight) {
                return $participant;
            }
        }

        return $participants->first();
    }

    protected function calculateCoinDistribution($vmm)
    {
        info('vmm from calculateCoinDistribution');

        $totalCoins = $vmm->distribute_coin;
        $executionRounds = $vmm->lifetime * 60 / $vmm->execution_time;

        $coinsPerRound = floor($totalCoins / $executionRounds);

        return $coinsPerRound;
    }

    protected function createTransaction($userId, $coins, $vmmId)
    {
        info('vmm from createTransaction and increment coins');

        // create transaction
        Transaction::create([
            'user_id' => $userId,
            'vmm_id' => $vmmId,
            'amount' => $coins,
            'type' => TransactionType::Winning,
            'status' => TransactionStatus::Approved
        ]);

        // increment user's coins
        $user = User::find($userId);
        $user->increment('vmm_coins', $coins);
    }
}
