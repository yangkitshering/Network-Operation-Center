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


// --- Index/Landing Page ----
Route::get('/', [Controller::class, 'index'])->name('index');

//admin only routes
Route::middleware(['auth', 'verified'])->group(function(){
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::put('/approval_mail/{id}', [AdminController::class, 'approve'])->name('approve_reject');

    Route::get('/registration', [AdminController::class, 'register'])->name('registration');
    Route::get('/pendingList', [AdminController::class, 'index'])->name('pendingList');
    Route::get('/approvedList', [AdminController::class, 'approved'])->name('approvedList');
    Route::post('/save', [AdminController::class, 'save_request'])->name('save');

});

//Approval route on clicking the mail link
Route::get('/approval_reject', [ApprovalController::class, 'process'])->name('approval.process');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
   
});

//auth routes
require __DIR__.'/auth.php';

//for users only
Route::post('/save_request', [HomeController::class, 'save_request'])->name('save.register');
Route::get('/feedback', [HomeController::class, 'feedback'])->name('feedback');
Route::post('/save_feedback', [HomeController::class, 'saveFeedback'])->name('save-feedback');


//SMS &mail
// Route::get('/sms', [SmsController::class, 'sms']);
// Route::get('send-mail', [MailController::class, 'index']);

// Route::get ('/user', [HomeController::class, 'index'])->name('user');
// Route::group(['middleware'=> 'role:admin'], function(){
//     Route::get ('/admin', [AdminController::class, 'index'])->name('admin');
    
// });