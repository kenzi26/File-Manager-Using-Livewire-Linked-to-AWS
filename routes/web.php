<?php

use App\Livewire\User\Login;
use App\Livewire\User\Register;

use App\Livewire\Admin\Category;
use App\Livewire\User\Dashboard;
use App\Livewire\Admin\ApproveUser;
use Illuminate\Support\Facades\Route;
use App\Livewire\Admin\Login as AdminLogin;
use App\Livewire\Admin\Dashboard as AdminDashboard;




/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

;




Route::get('/', Register::class)->name('user.register');
Route::get('/login', Login::class)->name('user.login');
Route::get('/user/dashboard', Dashboard::class)->name('user.dashboard');

Route::middleware(['guest:admin'])->group(function () {
    Route::get('/admin/login', AdminLogin::class)->name('admin.login');
});


Route::middleware(['auth:admin'])->group(function () {
    Route::get('/admin/dashboard', AdminDashboard::class)->name('admin.dashboard');
    Route::get('/admin/category', Category::class)->name('admin.category');
    Route::get('/admin/users', ApproveUser::class)->name('admin.users');
    
});



