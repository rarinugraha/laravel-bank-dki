<?php

use App\Enums\Role;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('users.index');
    } else {
        return redirect()->route('login');
    }
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware([
    'role:' . implode(',', [
        Role::ADMIN->value,
        Role::SUPERVISI->value,
        Role::CS->value,
    ])
])->group(function () {
    Route::post('/users/unblock/{id}', [UserController::class, 'unblock'])->name('users.unblock');
    Route::resource('users', UserController::class);
});

Route::middleware([
    'role:' . implode(',', [
        Role::SUPERVISI->value,
        Role::CS->value,
    ])
])->group(function () {
    Route::get('customers', [CustomerController::class, 'index'])->name('customers.index');
});

Route::middleware([
    'role:' . Role::CS->value,
])->group(function () {
    Route::get('customers/create', [CustomerController::class, 'create'])->name('customers.create');
    Route::post('customers', [CustomerController::class, 'store'])->name('customers.store');
});

Route::middleware([
    'role:' . Role::SUPERVISI->value,
])->group(function () {
    Route::post('/customers/approval/{id}', [CustomerController::class, 'approval'])->name('customers.approval');
});
