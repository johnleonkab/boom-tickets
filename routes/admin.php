<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\TicketController;
use App\Http\Controllers\Admin\TicketsController;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('test/event', function(){
    return view('admin.events.event-component');
});


Route::get('login', [AdminAuthController::class, 'getLogin'])->name('adminLogin');
Route::post('login', [AdminAuthController::class, 'postLogin'])->name('adminLoginPost');
Route::get('logout', [AdminAuthController::class, 'logout'])->name('adminLogout');
Route::get('setpassword', [AdminAuthController::class, 'getSetPassword'])->name('setPassword');
Route::post('setpassword', [AdminAuthController::class, 'SetPassword'])->name('setPasswordPost');


Route::group(['middleware' =>  ['adminauth', 'checkAdminPermission:payments_permission']], function () {
    Route::get('payments',  [AdminController::class, 'getStripeData']);
});


Route::group(['middleware' => 'adminauth'], function () {
	// Admin Dashboard
	Route::get('dashboard',[AdminController::class, 'dashboard'])->name('dashboard');	

Route::prefix('stripe')->group(function () {
    Route::get('/create', [AdminController::class, 'CreateStripeAccount']);
});

    Route::group(['middleware' =>  'checkAdminPermission:events_permission'], function () {
        Route::get('events', [EventController::class, 'loadEvents']);
        Route::prefix('event')->group(function () {
            Route::get('new', [EventController::class, 'showNewEventTemplate']);
            Route::post('new', [EventController::class, 'NewEvent']);
            Route::post('update', [EventController::class, 'UpdateEvent']);
            Route::post('delete', [EventController::class, 'deleteEvent']);
            Route::get('publish', [EventController::class, 'publishEvent']);
    
            Route::get('/{event_slug}', [EventController::class, 'loadSingleEvent'])->name('showEvent');
        });
    
    
        Route::get('event/{event_slug}/tickets', function($event_slug){
            return \Session::get('success');
        });
        Route::prefix('ticket')->group(function () {
            Route::get('new', [TicketsController::class, 'CreateUpdateTicket']);
            Route::get('update', [TicketsController::class, 'CreateUpdateTicket']);
            Route::post('delete', [TicketsController::class, 'DeleteTicket']);
    
        });
    });
    
    


});



