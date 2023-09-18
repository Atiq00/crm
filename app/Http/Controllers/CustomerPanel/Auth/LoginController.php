<?php

namespace App\Http\Controllers\CustomerPanel\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function show()
    {
        return view('customer-panel.auth.login');
    }

    public function authenticate(Request $request)
    {
        $request->validate([
            'email'     => 'required|exists:customers',
            'password'  => 'required|min:6',
            'g-recaptcha-response'  =>  'recaptcha'
        ]);

        // dd($request->get('g-recaptcha-response'));

        $credentials  = $request->only('email', 'password');

        if (Auth::guard('customer')->attempt($credentials , ( $request->remember ?? false ))) {
            return redirect()->route('customer.my-account');
        }else{
            return back()->withErrors(['password', 'Invalid Password'])->withInput();
        }
    }

    public function logout()
    {
        Session::flush();
        Auth::guard('customer')->logout();
        // dd( redirect()->back()->getTargetUrl() );
        return back();
    }
}
