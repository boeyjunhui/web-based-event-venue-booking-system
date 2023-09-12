<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    /* ========================================
    Super Admin & Event Venue Owner
    ======================================== */
    public function logout()
    {
        Session::flush();
        Auth::logout();
        return redirect('/evbs/login');
    }

    /* ========================================
    Guest
    ======================================== */
    public function guestLogout()
    {
        Session::flush();
        Auth::logout();
        return redirect('/login');
    }
}
