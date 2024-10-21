<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(){
        $transactions = Transaction::where('user_id', auth()->id())
                            ->with('vmm')
                            ->orderBy('created_at', 'desc')
                            ->get();

        return view('user.transaction', compact('transactions'));
    }
}
