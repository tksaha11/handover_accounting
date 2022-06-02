<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LoginRegController;
use App\Http\Controllers\AccountsController;




Route::get('store-reg-form',[LoginRegController::class,'regForm'])->name('store-reg-form');
Route::post('store-reg',[LoginRegController::class,'storeReg'])->name('store-reg');


Route::get('store-login-form',[LoginRegController::class,'loginForm'])->name('store-login-form');
Route::post('store-login',[LoginRegController::class,'storeLogin'])->name('store-login');
Route::get('store-logout',[LoginRegController::class,'storeLogout'])->name('store-logout');



Route::group(['middleware'=>['StoreLoginCheck']],function(){

    Route::get('/',[AccountsController::class,'acc_transection'])->name('dashboard');

    //accounting
    Route::get('my-accounts',[AccountsController::class,'MyAccounts'])->name('accounts');
    Route::post('daily-acc_transection',[AccountsController::class,'acc_transection'])->name('daily-acc_transection');


});



Route::get('testNagad',[TestNagadController::class,'index']);

Route::get('/clear', function() {
    $exitCode = Artisan::call('cache:clear');
    $exitCode2 = Artisan::call('view:clear');
    // return what you want
});

