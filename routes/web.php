<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdminLoginController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\QrCodeController;
use App\Http\Controllers\StripeTest;
use App\Http\Controllers\User\EventsController;
use App\Http\Controllers\User\VenueController;
use App\Http\Controllers\FollowerController;
use App\Http\Controllers\MasterAdminController;
use App\Http\Controllers\NotificationsController;
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

Route::get('masterAdmin/organization', [MasterAdminController::class, 'CreateUpdateOrganization']);
Route::get('masterAdmin/venue', [MasterAdminController::class, 'CreateUpdateVenue']);

Route::get('/', function () {
    return view('index', ['pageTitle'=> 'Inicio']);
});

//Route::get('/generate-qrcode', [QrCodeController::class, 'index']);


Route::get('/test', function () {
    return view('test', ['pageTitle' => 'lajjfhsda']);
});

Route::get('/events',[EventsController::class, 'index'] /*function(){
    return view('events.index', ['pageTitle' => 'Eventos']);
} */);
Route::prefix('/event')->group(function () {
    Route::post('/search', [EventsController::class, 'SearchEvent']);
    Route::get('/{event_slug}', [EventsController::class, 'ShowSingleEvent']);
});


Route::get('/venues',[VenueController::class, 'index'] /*function(){
    return view('events.index', ['pageTitle' => 'Eventos']);
} */);
Route::prefix('/venue')->group(function () {
    Route::post('/search', [VenueController::class, 'SearchVenue']);
    Route::get('/location', [VenueController::class, 'LocationBased']);
    Route::get('/{venue_slug}', [VenueController::class, 'ShowSingleVenue']);
});

Route::get('feed', function(){
    return view('feed.index', ['pageTitle' => 'Feed']);
});
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    
});

Route::get('testStripe', [StripeTest::class, 'Test']);

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::post('follow', [FollowerController::class, 'Follow']);
Route::post('unfollow', [FollowerController::class, 'UnFollow']);
Route::post('notifications/show', [NotificationsController::class, 'ShowNotifications']);
Route::post('notifications/share', [NotificationsController::class, 'Share']);
Route::post('feed/search', [NotificationsController::class, 'SearchNotifications']);

Route::post('ShowDynamicToast', [NotificationsController::class, 'ShowToast']);

Route::get('auth/google', [LoginController::class, 'redirect']);

Route::get('google/callback', [LoginController::class, 'signinGoogle']);