<?php

namespace App\Http\Controllers\CustomerPanel\Auth;

use Auth;
use Password;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class ForgotPasswordController extends Controller
{
    use SendsPasswordResetEmails;

    /**
     * Only guests for "customer" guard are allowed except
     * for logout.
     * 
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:customer');
    }

    /**
     * Show the reset email form.
     * 
     * @return \Illuminate\Http\Response
     */
    public function showLinkRequestForm(){
        return view('customer-panel.auth.forget_password');
    }

    /**
     * password broker for customer guard.
     * 
     * @return \Illuminate\Contracts\Auth\PasswordBroker
     */
    public function broker(){
        return Password::broker('customers');
    }

    /**
     * Get the guard to be used during authentication
     * after password reset.
     * 
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    public function guard(){
        return Auth::guard('customer');
    }
}