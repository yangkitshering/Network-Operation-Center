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

    Route::get('/manage_users', [AdminController::class, 'manage'])->name('manage-user');
    Route::get('manage_users/{id}', [AdminController::class, 'edit_user']);
    Route::post('manage_users/{id}', [AdminController::class, 'update_user']) -> name('user-update');
    Route::delete('manage_users/{id}', [AdminController::class, 'delete_user']);

    // Route::get('/view-user/{id}', [AdminController::class, 'view_user']);
});

// routes only for authenticated role (user)
Route::middleware(['auth', 'verified','role:user'])->group(function(){
    Route::get('/ticket', [UserController::class, 'ticket'])->name('ticket');
    Route::post('/raiseTicket', [UserController::class, 'saveTicket'])->name('saveTicket');
    Route::get('/my_request', [UserController::class, 'my_request'])->name('user_request');

    Route::get('manage_users/add_user/{id}', [AdminController::class, 'edit_adduser']);
    Route::post('manage_users/edit_adduser/{id}', [AdminController::class, 'update_adduser']) -> name('useradd-update');
    Route::delete('manage_users/{id}', [AdminController::class, 'delete_adduser']);

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

    Route::get('/user_pending', [AdminController::class, 'pending_user'])->name('user-pending');
    Route::get('/user_pending/{id}', [AdminController::class, 'view_user'])->name('user-view');
    Route::post('user_pending/{id}', [AdminController::class, 'user_approve_reject'])->name('user-approval-reject');
    Route::put('user_action/{id}', [AdminController::class, 'user_approve_reject'])->name('user-action');

    Route::put('/exited/{id}', [AdminController::class, 'exit_now'])->name('exit-now');

    // Route::post('reject_user/{id}', [AdminController::class, 'user_reject'])->name('user-reject');
    
    

    // Route::get('/manage_users', [AdminController::class, 'manage'])->name('manage-user');
    // Route::get('manage_users/{id}', [AdminController::class, 'edit_user']);
    // Route::post('manage_users/{id}', [AdminController::class, 'update_user']) -> name('user-update');
    // Route::delete('manage_users/{id}', [AdminController::class, 'delete_user']);
});

//Approval route on clicking the mail link
Route::get('/approval_reject', [ApprovalController::class, 'process'])->name('approval.process');

//new user approval mail link
Route::get('/newUser_approval', [ApprovalController::class, 'new_user_approve'])->name('newUser.approval');

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

//add user routes
Route::get('/add_user', [AdminController::class, 'add'])->name('add_user');
// Save new user
Route::post('/save_user', [AdminController::class, 'add_user'])->name('save_user');

//SMS &mail
// Route::get('/sms', [SmsController::class, 'sms']);
// Route::get('send-mail', [MailController::class, 'index']);

// Route::get ('/user', [HomeController::class, 'index'])->name('user');
// Route::group(['middleware'=> 'role:admin'], function(){
//     Route::get ('/admin', [AdminController::class, 'index'])->name('admin');
    
// });