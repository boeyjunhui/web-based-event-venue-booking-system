<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\ForgotPasswordController;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\EventVenueOwnerController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\EventTypeController;
use App\Http\Controllers\EventVenueController;
use App\Http\Controllers\BookingController;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

/* ========================================
Super Admin & Event Venue Owner
======================================== */
// login
Route::get('/evbs/login', [LoginController::class, 'displayLoginForm']);
Route::post('/evbs/login', [LoginController::class, 'login']);

Route::get('/evbs/dashboard', function () {
    return view('dashboard.dashboard');
})->middleware('auth:super_admin');

// logout
Route::get('/evbs/logout', [LogoutController::class, 'logout']);

// forgot password & reset password
Route::get('/evbs/forgot-password', [ForgotPasswordController::class, 'displayForgotPasswordForm']);
Route::post('/evbs/forgot-password', [ForgotPasswordController::class, 'forgotPassword']);
Route::get('/evbs/reset-password/{token}', [ForgotPasswordController::class, 'displayResetPasswordForm'])->name('displayResetPasswordForm');
Route::post('/evbs/reset-password', [ForgotPasswordController::class, 'resetPassword']);

// dashboard
Route::get('/evbs/dashboard', [DashboardController::class, 'dashboard']);

// profile
Route::get('/evbs/profile', [ProfileController::class, 'view']);
Route::get('/evbs/profile/edit-profile', [ProfileController::class, 'edit']);
Route::patch('/evbs/profile/update-profile', [ProfileController::class, 'update']);
Route::get('/evbs/profile/change-password', [ProfileController::class, 'editPassword']);
Route::patch('/evbs/profile/update-password', [ProfileController::class, 'updatePassword']);

// super admin
Route::get('/evbs/super-admins/add', [SuperAdminController::class, 'add']);
Route::post('/evbs/super-admins/create', [SuperAdminController::class, 'create']);
Route::get('/evbs/super-admins', [SuperAdminController::class, 'viewAll']);
Route::get('/evbs/super-admins/{superAdmin}', [SuperAdminController::class, 'view']);
Route::get('/evbs/super-admins/{superAdmin}/edit', [SuperAdminController::class, 'edit']);
Route::patch('/evbs/super-admins/{superAdmin}/update', [SuperAdminController::class, 'update']);
Route::get('/evbs/super-admins/{superAdmin}/change-password', [SuperAdminController::class, 'editPassword']);
Route::patch('/evbs/super-admins/{superAdmin}/update-password', [SuperAdminController::class, 'updatePassword']);
Route::patch('/evbs/super-admins/{superAdmin}/activate', [SuperAdminController::class, 'activate']);
Route::patch('/evbs/super-admins/{superAdmin}/deactivate', [SuperAdminController::class, 'deactivate']);
Route::delete('/evbs/super-admins/{superAdmin}/delete', [SuperAdminController::class, 'delete']);

// event venue owner
Route::get('/evbs/event-venue-owners/add', [EventVenueOwnerController::class, 'add']);
Route::post('/evbs/event-venue-owners/create', [EventVenueOwnerController::class, 'create']);
Route::get('/evbs/event-venue-owners', [EventVenueOwnerController::class, 'viewAll']);
Route::get('/evbs/event-venue-owners/{eventVenueOwner}', [EventVenueOwnerController::class, 'view']);
Route::get('/evbs/event-venue-owners/{eventVenueOwner}/edit', [EventVenueOwnerController::class, 'edit']);
Route::patch('/evbs/event-venue-owners/{eventVenueOwner}/update', [EventVenueOwnerController::class, 'update']);
Route::get('/evbs/event-venue-owners/{eventVenueOwner}/change-password', [EventVenueOwnerController::class, 'editPassword']);
Route::patch('/evbs/event-venue-owners/{eventVenueOwner}/update-password', [EventVenueOwnerController::class, 'updatePassword']);
Route::patch('/evbs/event-venue-owners/{eventVenueOwner}/activate', [EventVenueOwnerController::class, 'activate']);
Route::patch('/evbs/event-venue-owners/{eventVenueOwner}/deactivate', [EventVenueOwnerController::class, 'deactivate']);
Route::delete('/evbs/event-venue-owners/{eventVenueOwner}/delete', [EventVenueOwnerController::class, 'delete']);

// guest
Route::get('/evbs/guests/add', [GuestController::class, 'add']);
Route::post('/evbs/guests/create', [GuestController::class, 'create']);
Route::get('/evbs/guests', [GuestController::class, 'viewAll']);
Route::get('/evbs/guests/{guest}', [GuestController::class, 'view']);
Route::get('/evbs/guests/{guest}/edit', [GuestController::class, 'edit']);
Route::patch('/evbs/guests/{guest}/update', [GuestController::class, 'update']);
Route::get('/evbs/guests/{guest}/change-password', [GuestController::class, 'editPassword']);
Route::patch('/evbs/guests/{guest}/update-password', [GuestController::class, 'updatePassword']);
Route::patch('/evbs/guests/{guest}/activate', [GuestController::class, 'activate']);
Route::patch('/evbs/guests/{guest}/deactivate', [GuestController::class, 'deactivate']);
Route::delete('/evbs/guests/{guest}/delete', [GuestController::class, 'delete']);

// event type
Route::get('/evbs/event-types/add', [EventTypeController::class, 'add']);
Route::post('/evbs/event-types/create', [EventTypeController::class, 'create']);
Route::get('/evbs/event-types', [EventTypeController::class, 'viewAll']);
Route::get('/evbs/event-types/{eventType}/edit', [EventTypeController::class, 'edit']);
Route::patch('/evbs/event-types/{eventType}/update', [EventTypeController::class, 'update']);
Route::patch('/evbs/event-types/{eventType}/activate', [EventTypeController::class, 'activate']);
Route::patch('/evbs/event-types/{eventType}/deactivate', [EventTypeController::class, 'deactivate']);
Route::delete('/evbs/event-types/{eventType}/delete', [EventTypeController::class, 'delete']);

// event venue
Route::get('/evbs/event-venues/add', [EventVenueController::class, 'add']);
Route::post('/evbs/event-venues/create', [EventVenueController::class, 'create']);
Route::get('/evbs/event-venues', [EventVenueController::class, 'viewAll']);
Route::get('/evbs/event-venues/{guest}', [EventVenueController::class, 'view']);
Route::get('/evbs/event-venues/{eventVenue}/edit', [EventVenueController::class, 'edit']);
Route::patch('/evbs/event-venues/{eventVenue}/update', [EventVenueController::class, 'update']);
Route::patch('/evbs/event-venues/{eventVenue}/activate', [EventVenueController::class, 'activate']);
Route::patch('/evbs/event-venues/{eventVenue}/deactivate', [EventVenueController::class, 'deactivate']);
Route::delete('/evbs/event-venues/{eventVenue}/delete', [EventVenueController::class, 'delete']);

// booking
Route::get('/evbs/bookings/add', [BookingController::class, 'add']);
Route::post('/evbs/bookings/create', [BookingController::class, 'create']);
Route::get('/evbs/bookings', [BookingController::class, 'viewAll']);
Route::get('/evbs/bookings/{booking}', [BookingController::class, 'view']);
Route::get('/evbs/bookings/{booking}/edit', [BookingController::class, 'edit']);
Route::patch('/evbs/bookings/{booking}/update', [BookingController::class, 'update']);
Route::delete('/evbs/bookings/{booking}/delete', [BookingController::class, 'delete']);

/* ========================================
Guest
======================================== */

