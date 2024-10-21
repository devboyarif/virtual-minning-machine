<?php

namespace App\Console\Commands;

use App\Models\VMM;
use App\Jobs\VMMRunningJob;
use Illuminate\Console\Command;
use App\Jobs\DistributeCoinsJob;

class CheckVMMTime extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'checkVmmTime';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check VMM time and start the VMM';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $vmm = VMM::where('start_time', '>=', now())
                ->where('type', 'active')
                ->first();

        info('vmm from scheduler');

        if ($vmm) {
            // change status to in preparation
            $vmm->type = 'in_preparation';
            $vmm->save();

            dispatch(new VMMRunningJob($vmm->id))->delay(now()->addMinutes($vmm->preparation_time));
        }
    }
}
