<?php

use App\Http\Controllers\UploadController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Auth\RegisterController;
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
use App\Http\Controllers\SNSController;

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

// booking
Route::get('/evbs/checkEventVenueAvailability/{eventVenue}/{startDate}/{endDate}', [BookingController::class, 'checkEventVenueAvailability']);
Route::get('/evbs/bookings/add-guest-booking', [BookingController::class, 'addGuestBooking']);
Route::get('/evbs/bookings/add-venue-blocking', [BookingController::class, 'addVenueBlocking']);
Route::post('/evbs/bookings/create-guest-booking', [BookingController::class, 'createGuestBooking']);
Route::post('/evbs/bookings/create-venue-blocking', [BookingController::class, 'createVenueBlocking']);
Route::get('/evbs/bookings/guest-bookings', [BookingController::class, 'viewAllGuestBookings']);
Route::get('/evbs/bookings/venue-blockings', [BookingController::class, 'viewAllVenueBlockings']);
Route::get('/evbs/bookings/guest-booking/{booking}', [BookingController::class, 'viewGuestBooking']);
Route::get('/evbs/bookings/venue-blocking/{booking}', [BookingController::class, 'viewVenueBlocking']);
Route::get('/evbs/bookings/{booking}/edit-guest-booking', [BookingController::class, 'editGuestBooking']);
Route::get('/evbs/bookings/{booking}/edit-venue-blocking', [BookingController::class, 'editVenueBlocking']);
Route::patch('/evbs/bookings/{booking}/update-guest-booking', [BookingController::class, 'updateGuestBooking']);
Route::patch('/evbs/bookings/{booking}/update-venue-blocking', [BookingController::class, 'updateVenueBlocking']);
Route::patch('/evbs/bookings/{booking}/confirm-guest-booking', [BookingController::class, 'confirmGuestBooking']);
Route::patch('/evbs/bookings/{booking}/confirm-venue-blocking', [BookingController::class, 'confirmVenueBlocking']);
Route::patch('/evbs/bookings/{booking}/cancel-guest-booking', [BookingController::class, 'cancelGuestBooking']);
Route::patch('/evbs/bookings/{booking}/cancel-venue-blocking', [BookingController::class, 'cancelVenueBlocking']);
Route::delete('/evbs/bookings/{booking}/delete-guest-booking', [BookingController::class, 'deleteGuestBooking']);
Route::delete('/evbs/bookings/{booking}/delete-venue-blocking', [BookingController::class, 'deleteVenueBlocking']);

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
Route::patch('/evbs/event-venues/{eventVenue}/delete-single-event-venue-image', [EventVenueController::class, 'deleteSingleEventVenueImage']);
Route::patch('/evbs/event-venues/{eventVenue}/delete-all-event-venue-images', [EventVenueController::class, 'deleteAllEventVenueImages']);
Route::delete('/evbs/event-venues/{eventVenue}/delete', [EventVenueController::class, 'delete']);

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

/* ========================================
Event Venue Owner
======================================== */
// register account
Route::get('/event-venue-owner/register', [RegisterController::class, 'displayEventVenueOwnerRegistrationForm']);
Route::post('/event-venue-owner/register', [RegisterController::class, 'eventVenueOwnerAccountRegistration']);

/* ========================================
Guest
======================================== */
// register account
Route::get('/register', [RegisterController::class, 'displayGuestRegistrationForm']);
Route::post('/register', [RegisterController::class, 'guestAccountRegistration']);

// login
Route::get('/login', [LoginController::class, 'displayGuestLoginForm']);
Route::post('/login', [LoginController::class, 'guestLogin']);

// logout
Route::get('/logout', [LogoutController::class, 'guestLogout']);

// forgot password & reset password
Route::get('/forgot-password', [ForgotPasswordController::class, 'displayGuestForgotPasswordForm']);
Route::post('/forgot-password', [ForgotPasswordController::class, 'guestForgotPassword']);
Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'displayGuestResetPasswordForm'])->name('displayGuestResetPasswordForm');
Route::post('/reset-password', [ForgotPasswordController::class, 'guestResetPassword']);

// profile
Route::get('/profile', [ProfileController::class, 'viewGuestProfile']);
Route::get('/profile/edit-profile', [ProfileController::class, 'editGuestProfile']);
Route::patch('/profile/update-profile', [ProfileController::class, 'updateGuestProfile']);
Route::get('/profile/change-password', [ProfileController::class, 'editGuestPassword']);
Route::patch('/profile/update-password', [ProfileController::class, 'updateGuestPassword']);

// home & event venue
Route::get('/', [EventVenueController::class, 'viewEventVenue']);
Route::get('/event-type', [EventVenueController::class, 'viewSpecificEventTypeVenue']);
Route::get('/event-venue', [EventVenueController::class, 'searchEventVenue']);

// booking
Route::get('/make-booking/{eventVenue}', [BookingController::class, 'makeBooking']);
Route::post('/place-booking', [BookingController::class, 'placeBooking']);
Route::get('/bookings', [BookingController::class, 'viewAllBookings']);
Route::get('/bookings/{booking}', [BookingController::class, 'viewBooking']);
Route::patch('/cancel-booking/{booking}', [BookingController::class, 'cancelBooking']);
//todo testing
// Route::post('/execute-controller', 'SNSController@sendSMS')->name('execute-controller');


// Route::post('/aaa', [SNSController::class, 'sendSMS']);

Route::get('/sms', [SNSController::class, 'sendSMS']);

// Route::post('/upload', 'UploadController@upload')->name('upload');
Route::post('/upload', [UploadController::class, 'upload'])->name('upload');
