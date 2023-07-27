<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /* ========================================
    Super Admin & Event Venue Owner
    ======================================== */
    // login form
    public function displayLoginForm()
    {
        return view('auth.management-system.login');
    }

    // login authentication
    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:8',
            'userRole' => 'required'
        ]);

        if ($request->userRole == "1") {
            $superAdmin = DB::table("super_admins")
                ->select('super_admins.*')
                ->where('super_admins.email', $request->email)
                ->where('super_admins.status', 1)
                ->first();

            if ($superAdmin) {
                if (Auth::guard('super_admin')->attempt($request->only(['email', 'password']), $request->get('remember'))) {
                    session(['user_role' => 'Super Admin']);
                    session(['user' => $superAdmin]);

                    return redirect()->intended('/evbs/dashboard');
                } else {
                    return back()->withInput($request->only('email', 'remember'))->withErrors(['password' => ['The password does not match.']]);
                }
            } else {
                return back()->withInput($request->only('email', 'remember'))->withErrors(['email' => ['This email does not exist.']]);
            }
        } else if ($request->userRole == "2") {
            $eventVenueOwner = DB::table("event_venue_owners")
                ->select('event_venue_owners.*')
                ->where('event_venue_owners.email', $request->email)
                ->where('event_venue_owners.status', 1)
                ->first();

            if ($eventVenueOwner) {
                if (Auth::guard('event_venue_owner')->attempt($request->only(['email', 'password']), $request->get('remember'))) {
                    session(['user_role' => 'Event Venue Owner']);
                    session(['user' => $eventVenueOwner]);

                    return redirect()->intended('/evbs/dashboard');
                } else {
                    return back()->withInput($request->only('email', 'remember'))->withErrors(['password' => ['The password does not match.']]);
                }
            } else {
                return back()->withInput($request->only('email', 'remember'))->withErrors(['email' => ['This email does not exist.']]);
            }
        } else {
            return back();
        }
    }

    /* ========================================
    Guest
    ======================================== */
    // login form
    public function displayGuestLoginForm()
    {
        return view('auth.booking-system.login');
    }

    // login authentication
    public function guestLogin(Request $request)
    {
        //
    }
}
