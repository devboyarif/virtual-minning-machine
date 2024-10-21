<?php

namespace App\Http\Controllers;

use App\Models\VMM;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VMMController extends Controller
{
    public function create(){
        return view('admin.vmm-create');
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'lifetime' => 'required|integer',
            'minimum_invest' => 'required|numeric',
            'distribute_coin' => 'required|numeric',
            'execution_time' => 'required|integer',
            'preparation_time' => 'required|integer',
            'start_time' => 'required|date',
            'type' => 'required|in:draft,active',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        }


        try {
            VMM::create([
                'title' => $request->title,
                'lifetime' => $request->lifetime,
                'minimum_invest' => $request->minimum_invest,
                'distribute_coin' => $request->distribute_coin,
                'execution_time' => $request->execution_time,
                'preparation_time' => $request->preparation_time,
                'start_time' => $request->start_time,
                'type' => $request->type,
            ]);

            return redirect()->back()->with('success', 'VMM created successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong'. $e->getMessage());
        }
    }

    public function changeStatus(Request $request, VMM $vmm){
        try {
            $vmm->type = $request->status;
            $vmm->save();

            return redirect()->back()->with('success', 'Status changed successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong'. $e->getMessage());
        }
    }
}
