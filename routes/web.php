<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController; //追加-----------------------------

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//以下を追加-----------------ログインしていないと不可にする-----------------ここから
Route::middleware('auth')->group(function(){
    // ログイン後の画面
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
}); // -------------------------------------------------------------------ここまで

require __DIR__.'/auth.php';
