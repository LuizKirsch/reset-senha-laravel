<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'login_action'])->name('user.login_action');

//logout
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/forgot-password', [AuthController::class, 'forgot_pass'])->middleware('guest')->name('password.request');

Route::post('/forgot-password', [AuthController::class, 'send_reset_link'])->middleware('guest')->name('password.email');

Route::get('/reset-password/{token}', [AuthController::class, 'show_reset_form'])->middleware('guest')->name('password.reset');

Route::post('/reset-password', [AuthController::class, 'reset_password'])->middleware('guest')->name('password.update');
