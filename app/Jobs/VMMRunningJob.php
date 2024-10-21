<?php

namespace App\Jobs;

use App\Models\VMM;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class VMMRunningJob implements ShouldQueue
{
    use Queueable;

    protected $vmmId;

    public function __construct($vmmId)
    {
        $this->vmmId = $vmmId;
    }

    public function handle()
    {
        info('vmm from vmmrunningjob');

        $vmm = VMM::find($this->vmmId);

        if ($vmm && $vmm->type === 'in_preparation') {
            // change status to running
            $vmm->type = 'running';
            $vmm->save();

            // distribute coins
            $this->scheduleCoinDistribution($vmm);
        }
    }

    protected function scheduleCoinDistribution($vmm)
    {
        info('vmm from scheduleCoinDistribution');

        $executionTimeInSeconds = $vmm->execution_time;
        $lifetimeInSeconds = $vmm->lifetime * 60;
        $totalDelay = 0;

        while ($lifetimeInSeconds > 0) {
            dispatch(new DistributeCoinsJob($vmm->id))->delay(now()->addSeconds($totalDelay));

            $totalDelay += $executionTimeInSeconds;
            $lifetimeInSeconds -= $executionTimeInSeconds;
        }

        dispatch(function () use ($vmm) {
            info('vmm finished');

            $vmm->type = 'finished';
            $vmm->save();
        })->delay(now()->addSeconds($totalDelay));
    }

}
