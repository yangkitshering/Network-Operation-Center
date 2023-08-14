<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SmsController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\ApprovalController;
use App\Http\Controllers\UserController;

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

// routes for authenticated users with role (user & admin)
Route::middleware(['auth', 'verified'])->group(function(){
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::get('/registration', [AdminController::class, 'register'])->name('registration');
    Route::post('/save', [AdminController::class, 'save'])->name('save');
    Route::get('/view-request/{id}', [AdminController::class, 'viewRequest']);
});

// routes only for authenticated role (user)
Route::middleware(['auth', 'verified','role:user'])->group(function(){
    Route::get('/ticket', [UserController::class, 'ticket'])->name('ticket');
    Route::post('/raiseTicket', [UserController::class, 'saveTicket'])->name('saveTicket');
    Route::get('/my_request', [UserController::class, 'my_request'])->name('user_request');
    Route::put('/exited/{id}', [UserController::class, 'exit_now'])->name('exit-now');
});

// routes only for authenticated role (admin)
Route::middleware(['auth', 'verified', 'role:admin'])->group(function(){
    Route::put('/process_request/{id}', [AdminController::class, 'processRequest'])->name('approve_reject');
    // Route::get('/pendingList', [AdminController::class, 'index'])->name('pendingList');
    Route::get('/pendingList', [AdminController::class, 'pending'])->name('pendingList');
    Route::get('/approvedList', [AdminController::class, 'approved'])->name('approvedList');
    Route::get('/ticketList', [AdminController::class, 'displayTicket'])->name('showTickets');
    Route::get('/ticketView/{id}', [AdminController::class, 'viewTicket']);
    Route::put('/closeTicket/{id}', [AdminController::class, 'ticketClose'])->name('ticket-close');

    Route::get('/manage_users', [AdminController::class, 'manage'])->name('manage-user');
    Route::get('manage_users/{id}', [AdminController::class, 'edit_user']);
    Route::post('manage_users/{id}', [AdminController::class, 'update_user']) -> name('user-update');
    Route::delete('manage_users/{id}', [AdminController::class, 'delete_user']);
});

//Approval route on clicking the mail link
Route::get('/approval_reject', [ApprovalController::class, 'process'])->name('approval.process');

//exit route on clicking the mail link
Route::get('/exit-entry', [Controller::class, 'user_redirect_to_login'])->name('exit.redirect');
// Route::get('/exit-entry/{id}', [Controller::class, 'exit'])->name('exit');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
   
});

//auth routes
require __DIR__.'/auth.php';

//for users unauthenticated only
// Route::post('/save_request', [HomeController::class, 'save_request'])->name('save.register');
Route::get('/feedback', [HomeController::class, 'feedback'])->name('feedback');
Route::post('/save_feedback', [HomeController::class, 'saveFeedback'])->name('save-feedback');


//SMS &mail
// Route::get('/sms', [SmsController::class, 'sms']);
// Route::get('send-mail', [MailController::class, 'index']);

// Route::get ('/user', [HomeController::class, 'index'])->name('user');
// Route::group(['middleware'=> 'role:admin'], function(){
//     Route::get ('/admin', [AdminController::class, 'index'])->name('admin');
    
// });