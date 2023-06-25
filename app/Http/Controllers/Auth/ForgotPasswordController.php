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

    // forgot password form
    public function displayForgotPasswordForm()
    {
        return view('auth.internal-user.forgot-password');
    }

    // send reset password email
    public function forgotPassword(Request $request)
    {
        //
    }

    // reset password form
    public function displayResetPasswordForm()
    {
        return view('auth/internal-user.reset-password');
    }

    // reset password
    public function resetPassword(Request $request)
    {
        //
    }
}
