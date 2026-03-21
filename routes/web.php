<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return redirect()->route('dashboard');
});


Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    //accounts
    Route::get('/accounts', [AccountController::class, 'index'])->name('accounts.index');
    Route::post('/accounts', [AccountController::class,'store'])->name('accounts.store');

    Route::get('/accounts/{account}', [AccountController::class, 'show'])->name('accounts.show');
    //deposit and withdraw
    Route::get('/accounts/{account}/deposit', [AccountController::class, 'deposit'])->name('account.deposit');
    Route::post('/accounts/{account}/deposit', [AccountController::class, 'deposit'])->name('account.deposit.store');
    //withdraws
    Route::get('/accounts/{account}/withdraw', [AccountController::class, 'withdraw'])->name('account.withdraw');
    Route::post('/accounts/{account}/withdraw', [AccountController::class, 'withdraw'])->name('account.withdraw.store');
    //transfer
    Route::get('/accounts/{account}/transfer', [AccountController::class, 'transfer'])->name('account.transfer');
    Route::post('/accounts/{account}/transfer', [AccountController::class, 'transferStore'])->name('account.transfer.store');
    //payments
    Route::get('/payments', [PaymentController::class, 'index'])->name('payment.index');
    Route::get('/payments/create', [PaymentController::class, 'create'])->name('payment.create');
    Route::post('/payments', [PaymentController::class, 'store'])->name('payment.store');
    Route::get('/payments/{payment}', [PaymentController::class, 'show'])->name('payment.show');
    Route::get('/payments/{payment}/edit', [PaymentController::class, 'edit'])->name('payment.edit');
    Route::put('/payments/{payment}', [PaymentController::class, 'update'])->name('payment.update');
    Route::delete('/payments/{payment}', [PaymentController::class, 'destroy'])->name('payment.destroy');
});

require __DIR__.'/auth.php';
