<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CommonController;

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

// loading index/landing Page
Route::get('/', [Controller::class, 'index'])->name('index');
//Approval route on clicking the mail link
Route::get('/redirect-login', [Controller::class, 'process'])->name('approval.process');

// routes only for authenticated role user
Route::middleware(['auth', 'verified','role:user'])->group(function(){
    Route::get('/registration', [UserController::class, 'register'])->name('registration');
    Route::post('/save', [UserController::class, 'save'])->name('save');
    Route::get('/my_request', [UserController::class, 'my_request'])->name('user_request');
    Route::get('/ticket', [UserController::class, 'ticket'])->name('ticket');
    Route::post('/raiseTicket', [UserController::class, 'saveTicket'])->name('saveTicket');
    
    Route::get('manage_users/add_user/{id}', [UserController::class, 'edit_adduser']);
    Route::post('manage_users/edit_adduser/{id}', [UserController::class, 'update_adduser']) -> name('useradd-update');

});

// routes only for authenticated role admin
Route::middleware(['auth', 'verified', 'role:admin'])->group(function(){
    Route::put('/process_request/{id}', [AdminController::class, 'processRequest'])->name('approve_reject');
    Route::get('/user_pending', [AdminController::class, 'pending_user'])->name('user-pending');
    Route::get('/user_pending/{id}', [AdminController::class, 'view_user'])->name('user-view');

    Route::get('manage_users/{id}', [AdminController::class, 'edit_user']);
    Route::post('manage_users/{id}', [AdminController::class, 'update_user']) -> name('user-update');

    Route::put('user_pending/{id}', [AdminController::class, 'user_approve_reject'])->name('user-approval-reject');
    // Route::put('user_action/{id}', [AdminController::class, 'user_approve_reject'])->name('user-action');
    Route::get('/pendingList', [AdminController::class, 'pending'])->name('pendingList');
    Route::get('/ticketList', [AdminController::class, 'displayTicket'])->name('showTickets');
    Route::get('/ticketView/{id}', [AdminController::class, 'viewTicket']);
    Route::put('/closeTicket/{id}', [AdminController::class, 'ticketClose'])->name('ticket-close'); 

    //setting routes
    Route::get('/app_setting', [AdminController::class, 'setting'])->name('manage-setting');
    Route::get ('/add_dc', [AdminController::class, 'add_dc'])->name('add_dc');
    Route::post('/save_dc', [AdminController::class, 'save_dc'])->name('save_dc');

    Route::get ('/add_racklist', [AdminController::class, 'add_racklist'])->name('add_racklist');
    Route::post('/save_racklist', [AdminController::class, 'save_racklist'])->name('save_racklist');

    Route::get ('/add_organization', [AdminController::class, 'add_organization'])->name('add_organization');
    Route::post('/save_organization', [AdminController::class, 'save_organization'])->name('save_organization');

    Route::get ('/add_focal', [AdminController::class, 'add_focal'])->name('add_focal');
    Route::post('/save_focal', [AdminController::class, 'save_focal'])->name('save_focal');

    Route::get ('/edit_dc/{id}', [AdminController::class, 'edit_dc'])->name('edit-dc');
    Route::get ('/edit_org/{id}', [AdminController::class, 'edit_org'])->name('edit-org');
    Route::get ('/edit_rack/{id}', [AdminController::class, 'edit_rack'])->name('edit-rack');
    Route::get ('/edit_focal/{id}', [AdminController::class, 'edit_focal'])->name('edit-focal');

    Route::delete('delete_dc/{id}', [AdminController::class, 'delete_dc']);
    Route::delete('delete_org/{id}', [AdminController::class, 'delete_org']);
    Route::delete('delete_rack/{id}', [AdminController::class, 'delete_rack']);
    Route::delete('delete_focal/{id}', [AdminController::class, 'delete_focal']);
});

// routes for authenticated users with role user & admin
Route::middleware(['auth', 'verified'])->group(function(){
    Route::get('/dashboard', [CommonController::class, 'index'])->name('dashboard');
    Route::get('/approvedList', [AdminController::class, 'approved'])->name('approvedList');
    Route::get('/view-request/{id}', [CommonController::class, 'viewRequest']);
    Route::get('/manage_users', [CommonController::class, 'manage'])->name('manage-user');
    Route::put('/exited/{id}', [AdminController::class, 'exit_now'])->name('exit-now');

    //add new user routes
    Route::get('/add_user', [CommonController::class, 'add'])->name('add_user');
    Route::post('/save_user', [CommonController::class, 'add_user'])->name('save_user');

    Route::delete('manage_users/{id}', [CommonController::class, 'delete_user']);
    Route::delete('manage_users/delete_adduser/{id}', [CommonController::class, 'delete_user']);

    Route::get('/passwordChange', [UserController::class, 'change_pwd'])->name('change-pwd');
    Route::post('/savePassword', [UserController::class, 'save_pwd'])->name('save_password');
});

    //auth routes
    require __DIR__.'/auth.php';

    //routes for feedback
    Route::get('/feedback', [HomeController::class, 'feedback'])->name('feedback');
    Route::post('/save_feedback', [HomeController::class, 'saveFeedback'])->name('save-feedback');

//profile route
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});