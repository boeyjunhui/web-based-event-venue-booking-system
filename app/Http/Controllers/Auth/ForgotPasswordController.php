<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /* ========================================
    Super Admin & Event Venue Owner
    ======================================== */
    // forgot password form
    public function displayForgotPasswordForm()
    {
        return view('auth.management-system.forgot-password');
    }

    // send reset password email
    public function forgotPassword(Request $request)
    {
        //
    }

    // reset password form
    public function displayResetPasswordForm()
    {
        return view('auth.management-system.reset-password');
    }

    // reset password
    public function resetPassword(Request $request)
    {
        //
    }

    /* ========================================
    Guest
    ======================================== */
    // forgot password form
    public function displayGuestForgotPasswordForm()
    {
        return view('auth.booking-system.forgot-password');
    }

    // send reset password email
    public function guestForgotPassword(Request $request)
    {
        //
    }

    // reset password form
    public function displayGuestResetPasswordForm()
    {
        return view('auth.booking-system.reset-password');
    }

    // reset password
    public function guestResetPassword(Request $request)
    {
        //
    }
}
