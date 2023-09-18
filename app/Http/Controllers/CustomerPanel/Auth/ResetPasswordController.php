<?php

namespace App\Http\Controllers\CustomerPanel\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Password;
use Illuminate\Foundation\Auth\ResetsPasswords;

class ResetPasswordController extends Controller
{


    /**
     * This will do all the heavy lifting
     * for resetting the password.
     */
    use ResetsPasswords;

     /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/customer';

    /**
     * Only guests for "customer" guard are allowed except
     * for logout.
     * 
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('guest:customer');
    }

    /**
     * Show the reset password form.
     * 
     * @param  \Illuminate\Http\Request $request
     * @param  string|null  $token
     * @return \Illuminate\Http\Response
     */
    public function showResetForm(Request $request, $token = null){
        return view('customer-panel.auth.reset_password',[
            'token' => $token
        ]);
    }

    /**
     * Get the broker to be used during password reset.
     *
     * @return \Illuminate\Contracts\Auth\PasswordBroker
     */
    protected function broker(){
        return Password::broker('customers');
    }

    /**
     * Get the guard to be used during password reset.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard(){
        return Auth::guard('customer');
    }
}
