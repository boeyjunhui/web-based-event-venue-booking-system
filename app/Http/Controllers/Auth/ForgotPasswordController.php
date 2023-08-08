<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\XRayController;

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

    protected $xRayController;
    public function __construct(XRayController $xRayController)
    {
        $this->xRayController = $xRayController;
    }

    /* ========================================
    Super Admin & Event Venue Owner
    ======================================== */

    // forgot password form
    public function displayForgotPasswordForm()
    {
        if (session('user_role') == "Super Admin" || session('user_role') == "Event Venue Owner") {
            return redirect('/evbs/dashboard');
        } else {
            return view('auth.management-system.forgot-password');
        }
    }

    // send reset password email
    public function forgotPassword(Request $request)
    {
        if (session('user_role') == "Super Admin" || session('user_role') == "Event Venue Owner") {
            return redirect('/evbs/dashboard');
        } else {
            $data = request()->validate([
                'email' => 'required|email'
            ]);

            // check if email exists, if exists, send a reset password email, else return an error message
            $this->xRayController->begin();
            $this->xRayController->startRds();

            $superAdminQuery = DB::table('super_admins')
                ->where('super_admins.email', $data['email']);
            $superAdmin = $superAdminQuery->first();

            $this->xRayController->addRdsQuery($superAdminQuery->toSql());

            $eventVenueOwnerQuery = DB::table('event_venue_owners')
                ->where('event_venue_owners.email', $data['email']);
            $eventVenueOwner = $eventVenueOwnerQuery->first();
            $this->xRayController->addRdsQuery($eventVenueOwnerQuery->toSql());

            $this->xRayController->end();

            $this->xRayController->submit();
            if ($superAdmin != "" || $eventVenueOwner != "") {
                $token = Str::random(64);

                DB::table('password_resets')
                    ->insert([
                        'id' => Str::random(30),
                        'email' => $data['email'],
                        'token' => $token,
                        'status' => 1,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);

                if ($superAdmin != "") {
                    Mail::send('emails.management-system.forgot-password', ['token' => $token, 'name' => $superAdmin->first_name . ' ' . $superAdmin->last_name], function ($message) use ($request) {
                        $message->to($request->email);
                        $message->subject('Reset Password');
                    });
                } else if ($eventVenueOwner != "") {
                    Mail::send('emails.management-system.forgot-password', ['token' => $token, 'name' => $eventVenueOwner->first_name . ' ' . $eventVenueOwner->last_name], function ($message) use ($request) {
                        $message->to($request->email);
                        $message->subject('Reset Password');
                    });
                }

                return back()->with('success', 'An email with a reset password link is sent to ' . $data['email'] . '.');
            } else {
                return back()->with('error', 'Failed to send reset password email! ' . $data['email'] . ' does not exist!');
            }
        }
    }

    // reset password form
    public function displayResetPasswordForm($token)
    {
        if (session('user_role') == "Super Admin" || session('user_role') == "Event Venue Owner") {
            return redirect('/evbs/dashboard');
        } else {
            return view('auth.management-system.reset-password', ['token' => $token]);
        }
    }

    // reset password
    public function resetPassword(Request $request)
    {
        if (session('user_role') == "Super Admin" || session('user_role') == "Event Venue Owner") {
            return redirect('/evbs/dashboard');
        } else {
            $data = request()->validate(
                [
                    'email' => 'required|email',
                    'password' => 'required|min:8|confirmed',
                    'password_confirmation' => 'required'
                ],
                [
                    'password.required' => 'The new password field is required.',
                    'password.confirmed' => 'The new password does not match.',
                    'password_confirmation.required' => 'The confirm new password field is required.'
                ]
            );
            $this->xRayController->begin();
            $this->xRayController->startRds();
            $emailTokenStatusQuery = DB::table('password_resets')
                ->where('password_resets.email', $request->email)
                ->where('password_resets.token', $request->token)
                ->where('password_resets.status', 0);

            $emailTokenStatus = $emailTokenStatusQuery->first();
            $this->xRayController->addRdsQuery($emailTokenStatusQuery->toSql());

            $validEmailTokenQuery = DB::table('password_resets')
                ->where('password_resets.email', $request->email)
                ->where('password_resets.token', $request->token)
                ->where('password_resets.status', 1);
            $validEmailToken = $validEmailTokenQuery->first();
            $this->xRayController->addRdsQuery($validEmailTokenQuery->toSql());
            $this->xRayController->end();

            $this->xRayController->submit();

            if ($emailTokenStatus) {
                return back()->withInput()->with('error', 'This reset password link has been used!');
            } else if (!$validEmailToken) {
                return back()->withInput()->with('error', 'Invalid email and token!');
            } else {

                $superAdmin = DB::table('super_admins')
                    ->where('super_admins.email', $data['email'])
                    ->first();

                if ($superAdmin) {
                    DB::table('super_admins')
                        ->where('super_admins.email', $data['email'])
                        ->update([
                            'password' => Hash::make($data['password']),
                            'updated_at' => now()
                        ]);
                }

                $eventVenueOwner = DB::table('event_venue_owners')
                    ->where('event_venue_owners.email', $data['email'])
                    ->first();

                if ($eventVenueOwner) {
                    DB::table('event_venue_owners')
                        ->where('event_venue_owners.email', $data['email'])
                        ->update([
                            'password' => Hash::make($data['password']),
                            'updated_at' => now()
                        ]);
                }

                DB::table('password_resets')
                    ->where('password_resets.email', $data['email'])
                    ->where('password_resets.token', $request->token)
                    ->update([
                        'status' => 0,
                        'updated_at' => now()
                    ]);

                return redirect('/evbs/login')->with('success', 'Your password has been changed successfully, you may sign in with your new password!');
            }
        }
    }

    /* ========================================
    Guest
    ======================================== */
    // forgot password form
    public function displayGuestForgotPasswordForm()
    {
        if (session('user_role') == "Guest") {
            return redirect('/');
        } else {
            return view('auth.booking-system.forgot-password');
        }
    }

    // send reset password email
    public function guestForgotPassword(Request $request)
    {
        if (session('user_role') == "Guest") {
            return redirect('/');
        } else {
            $data = request()->validate([
                'email' => 'required|email'
            ]);

            // check if email exists, if exists, send a reset password email, else return an error message
            $this->xRayController->begin();
            $this->xRayController->startRds();
            $query = DB::table('guests')
                ->where('guests.email', $data['email']);
            $guest = $query->first();
            $this->xRayController->addRdsQuery($query->toSql());

            $this->xRayController->end();

            $this->xRayController->submit();
            if ($guest != "") {
                $token = Str::random(64);
                $this->xRayController->begin();
                $this->xRayController->startRds();
                $query = DB::table('password_resets')
                    ->insert([
                        'id' => Str::random(30),
                        'email' => $data['email'],
                        'token' => $token,
                        'status' => 1,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                $this->xRayController->addRdsQuery($query->toSql());

                $this->xRayController->end();

                $this->xRayController->submit();
                Mail::send('emails.booking-system.forgot-password', ['token' => $token, 'name' => $guest->first_name . ' ' . $guest->last_name], function ($message) use ($request) {
                    $message->to($request->email);
                    $message->subject('Reset Password');
                });

                return back()->with('success', 'An email with a reset password link is sent to ' . $data['email'] . '.');
            } else {
                return back()->with('error', 'Failed to send reset password email! ' . $data['email'] . ' does not exist!');
            }
        }
    }

    // reset password form
    public function displayGuestResetPasswordForm($token)
    {
        if (session('user_role') == "Guest") {
            return redirect('/');
        } else {
            return view('auth.booking-system.reset-password', ['token' => $token]);
        }
    }

    // reset password
    public function guestResetPassword(Request $request)
    {
        if (session('user_role') == "Guest") {
            return redirect('/');
        } else {
            $data = request()->validate(
                [
                    'email' => 'required|email',
                    'password' => 'required|min:8|confirmed',
                    'password_confirmation' => 'required'
                ],
                [
                    'password.required' => 'The new password field is required.',
                    'password.confirmed' => 'The new password does not match.',
                    'password_confirmation.required' => 'The confirm new password field is required.'
                ]
            );
            $this->xRayController->begin();
            $this->xRayController->startRds();
            $emailTokenStatusQuery = DB::table('password_resets')
                ->where('password_resets.email', $request->email)
                ->where('password_resets.token', $request->token)
                ->where('password_resets.status', 0);
            $emailTokenStatus = $emailTokenStatusQuery->first();

            $this->xRayController->addRdsQuery($emailTokenStatusQuery->toSql());

            $validEmailTokenQuery = DB::table('password_resets')
                ->where('password_resets.email', $request->email)
                ->where('password_resets.token', $request->token)
                ->where('password_resets.status', 1)
                ->first();
            $validEmailToken = $validEmailTokenQuery->first();

            $this->xRayController->addRdsQuery($validEmailTokenQuery->toSql());
    
            if ($emailTokenStatus) {
                $this->xRayController->end();

                $this->xRayController->submit();
                return back()->withInput()->with('error', 'This reset password link has been used!');
            } else if (!$validEmailToken) {
                $this->xRayController->end();

                $this->xRayController->submit();
                return back()->withInput()->with('error', 'Invalid email and token!');
            } else {
                //todo xray
                $guest = DB::table('guests')
                    ->where('guests.email', $data['email'])
                    ->first();

                if ($guest) {
                    DB::table('guests')
                        ->where('guests.email', $data['email'])
                        ->update([
                            'password' => Hash::make($data['password']),
                            'updated_at' => now()
                        ]);
                }

                DB::table('password_resets')
                    ->where('password_resets.email', $data['email'])
                    ->where('password_resets.token', $request->token)
                    ->update([
                        'status' => 0,
                        'updated_at' => now()
                    ]);

                    $this->xRayController->end();

                    $this->xRayController->submit();
                return redirect('/login')->with('success', 'Your password has been changed successfully, you may sign in with your new password!');
            }
        }
    }
}