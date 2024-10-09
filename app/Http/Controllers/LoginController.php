<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {

        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        $user = DB::table('admin')->where('email', $request->email)->first();

        if ($user) {
            if (Hash::check($request->password, $user->password)) {

                Auth::loginUsingId($user->id);
                return redirect()->intended('dashboard');

            } else {

                return back()->withErrors(['password' => 'Incorrect password']);

            }
            
        } else {
            return back()->withErrors(['email' => 'The provided email does not match any records.']);
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}