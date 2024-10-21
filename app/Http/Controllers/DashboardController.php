<?php

namespace App\Http\Controllers;

use App\Enums\VMMStatus;
use App\Models\VMM;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard(){
        $role = auth()->user()->role;
        $view = $role->value == 'admin' ? 'admin.dashboard' : 'user.dashboard';

        $data = [];
        if($role->value == 'user'){
            $data['vmms'] = VMM::where('type', '!=', VMMStatus::Draft)
                                    ->with('investment')
                                    ->latest()
                                    ->get();
        }

        return view($view, $data);
    }
}
