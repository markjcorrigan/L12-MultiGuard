<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\ResetPassword;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

final class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    } // End method

    public function login()
    {
        return view('admin.admin_login');
    } // End method

    public function login_submit(Request $request)
    {
        $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        $inputs = $request->all();
        $data = [
            'username' => $inputs['username'],
            'password' => $inputs['password'],
        ];

        if (Auth::guard('admin')->attempt($data)) {
            return redirect()->route('admin_dashboard');
        } else {
            return redirect()->route('admin_login')->with('error', 'Invalid login credentials!  Please try again.');
        }

        // dd($request->all());
    } // End method

    public function admin_logout()
    {
        Auth::guard('admin')->logout();

        return redirect()->route('admin_login')->with('success', 'Admin logged out successfully!');
    } // End method

    public function forgot_password()
    {
        return view('admin.admin_forgot_password');
    } // End method

    public function forgot_password_submit(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],

        ]);
        // dd($request->all());

        $admin = Admin::where('email', $request->email)->first();
        if (! $admin) {
            return redirect()->back()->with('error', 'Admin with provided email does not exist!');
        }
        $token = hash('sha256', time());
        $admin->token = $token;
        $admin->update();

        $pResetLink = url('admin/password-reset/'.$token.'/'.$request->email);
        $subject = 'Reset Admin Password';
        $info = [
            'user' => $admin['username'],
            'pResetLink' => $pResetLink,
        ];
        Mail::to($request->email)->send(new ResetPassword($subject, $info));

        return redirect()->back()->with('success', 'We have sent a password reset link to your email. Please check your email.  If you do not find the email in your inbox, please check your spam folder.');

    } // End method

    public function admin_reset_password($token, $email)
    {
        $admin = Admin::where('email', $email)->where('token', $token)->first();
        if (! $admin) {
            return redirect()->route('admin_login')->with('error', 'Your reset password token is expired!  Please start ove.');
        } else {
            return view('admin.reset_password', compact('token', 'email'));
        }

    } // End method

    public function admin_reset_password_submit(Request $request, $token, $email)
    {
        $request->validate([
            'password' => ['required'],
            'confirm_password' => ['required', 'same:password'],
        ]);
        // dd($request->all());

        $admin = Admin::where('email', $email)->where('token', $token)->first();
        if (Hash::check($request->password, $admin->password)) {
            return redirect()->back()->with('error', 'You cannot use your old password again!');
        }

        $admin->password = Hash::make($request->password);
        $admin->token = '';
        $admin->update();

        return redirect()->route('admin_login')->with('success', 'Your password is reset!  You can now login with your new password.');
    } // End method
}
