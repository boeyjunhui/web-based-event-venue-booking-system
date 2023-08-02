<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    // protected $redirectTo = RouteServiceProvider::HOME;
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    /* ========================================
    Event Venue Owner
    ======================================== */
    // display event venue owner register form
    public function displayEventVenueOwnerRegistrationForm()
    {
        if (session('user_role') == "Event Venue Owner") {
            return redirect('/evbs/dashboard');
        } else {
            return view('auth.booking-system.register-event-venue-owner');
        }
    }

    // register event venue owner account
    public function eventVenueOwnerAccountRegistration(Request $request)
    {
        if (session('user_role') == "Event Venue Owner") {
            return redirect('/evbs/dashboard');
        } else {
            if (session('user_role') == "Event Venue Owner") {
                return redirect('/');
            } else {
                $request->validate(
                    [
                        'firstName' => 'required',
                        'lastName' => 'required',
                        'email' => 'required|email|unique:super_admins,email|unique:event_venue_owners,email|unique:guests,email',
                        'phoneNumber' => 'required',
                        'password' => 'required|min:8|confirmed',
                        'password_confirmation' => 'required',
                        'address' => 'required',
                        'postalCode' => 'required',
                        'city' => 'required',
                        'state' => 'required',
                        'country' => 'required'
                    ],
                    [
                        'password.confirmed' => 'The password does not match.',
                        'password_confirmation.required' => 'The confirm password field is required.'
                    ]
                );

                DB::table('event_venue_owners')
                    ->insert([
                        'id' => Str::random(30),
                        'first_name' => $request->firstName,
                        'last_name' => $request->lastName,
                        'email' => $request->email,
                        'phone_number' => $request->phoneNumber,
                        'password' => Hash::make($request->password),
                        'address' => $request->address,
                        'postal_code' => $request->postalCode,
                        'city' => $request->city,
                        'state' => $request->state,
                        'country' => $request->country,
                        'status' => 1,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);

                return redirect('/evbs/login')->with('success', 'Account registered successfully! You may sign in now.');
            }
        }
    }

    /* ========================================
    Guest
    ======================================== */
    // display guest register form
    public function displayGuestRegistrationForm()
    {
        if (session('user_role') == "Guest") {
            return redirect('/');
        } else {
            return view('auth.booking-system.register-guest');
        }
    }

    // register guest account
    public function guestAccountRegistration(Request $request)
    {
        if (session('user_role') == "Guest") {
            return redirect('/');
        } else {
            if (session('user_role') == "Guest") {
                return redirect('/');
            } else {
                $request->validate(
                    [
                        'firstName' => 'required',
                        'lastName' => 'required',
                        'email' => 'required|email|unique:super_admins,email|unique:event_venue_owners,email|unique:guests,email',
                        'phoneNumber' => 'required',
                        'password' => 'required|min:8|confirmed',
                        'password_confirmation' => 'required'
                    ],
                    [
                        'password.confirmed' => 'The password does not match.',
                        'password_confirmation.required' => 'The confirm password field is required.'
                    ]
                );

                DB::table('guests')
                    ->insert([
                        'id' => Str::random(30),
                        'first_name' => $request->firstName,
                        'last_name' => $request->lastName,
                        'email' => $request->email,
                        'phone_number' => $request->phoneNumber,
                        'password' => Hash::make($request->password),
                        'status' => 1,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);

                return redirect('/login')->with('success', 'Account registered successfully! You may sign in now.');
            }
        }
    }
}
