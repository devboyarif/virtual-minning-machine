<?php

namespace App\Http\Controllers;

use App\Enums\VMMStatus;
use App\Models\VMM;

class DashboardController extends Controller
{
    public function dashboard(){
        $role = auth()->user()->role;
        $view = $role->value == 'admin' ? 'admin.dashboard' : 'user.dashboard';

        $data = [];
        if($role->value == 'user'){
            $data['vmms'] = VMM::where('type', '!=', VMMStatus::Draft)
                                ->where('type', '!=', VMMStatus::Finished)
                                ->with('investments')
                                ->latest()
                                ->get()
                                ->map(function($vmm){
                                    $investment = $vmm->investments->where('user_id', auth()->id())->first();

                                    if($investment){
                                        $vmm->my_investment = $investment->amount;
                                    }else{
                                        $vmm->my_investment = 0;
                                    }

                                    return $vmm;
                                });
        }else {
            $data['vmms'] = VMM::latest()->get();
        }

        return view($view, $data);
    }
}
