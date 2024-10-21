<?php

namespace App\Http\Controllers;

use App\Models\VMM;
use App\Models\Investment;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Enums\TransactionType;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class InvestmentController extends Controller
{
    public function invest(Request $request){
        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        }

        try {
            $balance = auth()->user()->balance;
            $vmm = VMM::findOrFail($request->vmm_id);

            // check if the minimum investment amount is less than the investment amount
            if ($vmm->minimum_invest > $request->amount) {
                return redirect()->back()->with('error', 'Minimum investment amount is '.$vmm->minimum_invest);
            }

            // check if the maximum investment amount is greater than the investment amount
            if ($balance < $request->amount) {
                return redirect()->back()->with('error', 'Insufficient balance');
            }

            // check if the vmm active or not
            if ($vmm->type !== 'active') {
                return redirect()->back()->with('error', "You can't invest now");
            }

            DB::beginTransaction();

            // Create or update investment
            $investment = Investment::where('user_id', auth()->id())
            ->where('vmm_id', $vmm->id)
            ->first();

            if ($investment) {
                $investment->increment('amount', $request->amount);
            }else {
                Investment::create([
                    'user_id' => auth()->id(),
                    'vmm_id' => $vmm->id,
                    'amount' => $request->amount
                ]);
            }

            // deduct the investment amount from the user's balance
            auth()->user()->update([
                'balance' => $balance - $request->amount,
            ]);

            // create a transaction
            Transaction::create([
                'user_id' => auth()->id(),
                'vmm_id' => $vmm->id,
                'amount' => $request->amount,
                'type' => TransactionType::Investment,
            ]);

            DB::commit();

            return redirect()->back()->with('success', 'Investment successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Something went wrong:'. $e->getMessage());
        }
    }
}
