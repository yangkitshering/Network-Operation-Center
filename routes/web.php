<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SmsController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\ApprovalController;

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


// --- Index Page ----
Route::get('/', [Controller::class, 'index'])->name('index');

//admin only routes
Route::middleware(['auth', 'verified'])->group(function(){
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::put('/approval_mail/{id}', [AdminController::class, 'approve'])->name('approve_reject');

});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    
});

//auth routes
require __DIR__.'/auth.php';

//admin only routes
Route::get ('/user', [HomeController::class, 'index'])->name('user');
Route::group(['middleware'=> 'role:admin'], function(){
    Route::get ('/admin', [AdminController::class, 'index'])->name('admin');
    
});

Route::get('/sms', [SmsController::class, 'sms']);
Route::get('send-mail', [MailController::class, 'index']);
Route::get('/approval_reject', [ApprovalController::class, 'process'])->name('approval.process');