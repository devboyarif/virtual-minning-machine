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
        $executionTimeInSeconds = $vmm->execution_time;
        $lifetimeInSeconds = $vmm->lifetime * 60;

        // distribute coins every execution_time interval
        while ($lifetimeInSeconds > 0) {
            dispatch(new DistributeCoinsJob($vmm->id))->delay(now()->addSeconds($executionTimeInSeconds));

            // decrease the lifetime by the execution time
            $lifetimeInSeconds -= $executionTimeInSeconds;
        }

        // mark the VMM as finished after the lifetime
        $vmm->type = 'finished';
        $vmm->save();
    }
}
