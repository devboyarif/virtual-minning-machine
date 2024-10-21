<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WithdrawController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InvestmentController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\VMMController;

Route::get('/', function () {
    return redirect('/dashboard');
});

// =================== Dashboard routes ===================
Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard')->middleware('auth');

// =================== User routes ========================
Route::middleware('auth', 'check.user')->group(function () {
    Route::get('/withdraw/coin', [WithdrawController::class, 'withdrawCoin'])->name('withdraw.coin');
    Route::post('/withdraw/coin/request', [WithdrawController::class, 'withdrawCoinRequest'])->name('withdraw.coin.request');
    Route::get('/transactions', [TransactionController::class, 'index'])->name('transaction');
    Route::post('/investment', [InvestmentController::class, 'invest'])->name('invest.now');
});

// =================== Admin routes =======================
Route::middleware('auth', 'check.admin')->group(function () {
    Route::get('/withdraw/request', [WithdrawController::class, 'withdrawRequest'])->name('withdraw.request');
    Route::post('/withdraw/approve/{transaction}', [WithdrawController::class, 'withdrawApprove'])->name('withdraw.approve');
    Route::post('/withdraw/reject/{transaction}', [WithdrawController::class, 'withdrawReject'])->name('withdraw.reject');

    Route::controller(VMMController::class)->group(function(){
        Route::put('/vmm/status/{vmm}', 'changeStatus')->name('vmm.status');
        Route::get('/vmm/create', 'create')->name('vmm.create');
        Route::post('/vmm/create', 'store')->name('vmm.store');
    });
});

// =================== Profile routes =======================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
