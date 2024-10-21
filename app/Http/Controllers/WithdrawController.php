<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Enums\TransactionType;
use App\Enums\TransactionStatus;
use Illuminate\Support\Facades\Validator;

class WithdrawController extends Controller
{
    public function withdrawCoin(){
        $withdrawRequests = Transaction::where('user_id', auth()->id())
                                ->where('type', TransactionType::Withdrawal)
                                ->where('status', TransactionStatus::Pending)
                                ->get();

        return view('user.withdraw-coin', [
            'withdrawRequests' => $withdrawRequests
        ]);
    }

    public function withdrawCoinRequest(Request $request){
        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        }

        try {
            $balance = auth()->user()->vmm_coins;

            // Check if the withdrawal amount is greater than the user's balance
            if ($balance < $request->amount) {
                return redirect()->back()->with('error', 'Insufficient balance');
            }

            // Create a withdrawal request
            Transaction::create([
                'user_id' => auth()->id(),
                'amount' => $request->amount,
                'type' => TransactionType::Withdrawal,
                'status' => TransactionStatus::Pending,
            ]);

            return redirect()->back()->with('success', 'Withdrawal request sent successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong:'. $e->getMessage());
        }
    }

    public function withdrawRequest(){
        $withdrawRequests = Transaction::with('user')
            ->where('type', TransactionType::Withdrawal)
            ->where('status', TransactionStatus::Pending)
            ->get();

        return view('admin.withdraw-request', [
            'withdrawRequests' => $withdrawRequests
        ]);
    }

    public function withdrawApprove(Transaction $transaction){
        try {
            $transaction->update([
                'status' => TransactionStatus::Approved
            ]);

            // Deduct the withdrawal coin from the user's balance
            $user = $transaction->user;
            $user->decrement('vmm_coins', $transaction->amount);

            return redirect()->back()->with('success', 'Withdrawal request approved successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong:'. $e->getMessage());
        }
    }

    public function withdrawReject(Transaction $transaction){
        try {
            $transaction->update([
                'status' => TransactionStatus::Rejected
            ]);

            return redirect()->back()->with('success', 'Withdrawal request rejected successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong:'. $e->getMessage());
        }

    }
}
