<?php

namespace App\Http\Controllers\CustomerPanel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Customer;
use App\Http\Requests\PasswordRequest;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:customer');
    }

    public function profile()
    {
        $customer = Customer::findOrFail( auth()->guard('customer')->user()->id );
        return view('customer-panel.account.profile', compact('customer'));
    }


    public function changePassword()
    {
        $customer = Customer::findOrFail( auth()->guard('customer')->user()->id );
        return view('customer-panel.account.change_password', compact('customer'));
    }

    /**
     * Change the password
     *
     * @param  \App\Http\Requests\PasswordRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updatePassword(Request $request)
    {

    	$validator = \Validator::make($request->all(), [
            'old_password' => ['required', 'min:6'],
            'password' => ['required', 'min:6', 'confirmed', 'different:old_password'],
            'password_confirmation' => ['required', 'min:6'],
        ]);

        $validator->after(function ($validator) use ($request) {
		    if( !Hash::check($request->get('old_password'), auth()->guard('customer')->user()->password) ){
	        	$validator->errors()->add('old_password', __('validation.old_password'));
	        }
		});

        $validator->validate();

        auth()->guard('customer')->user()->update(['password' => Hash::make($request->get('password'))]);

        return back()->withPasswordStatus( __('messages.password_updated') );
    }

    public function updateProfile(Request $request)
    {
    	$request->validate([
          'name'      => 'required|min:3',
          'email'     => 'required|unique:customers,email,'.auth()->guard('customer')->user()->id.',id',
        ]);

        auth()->guard('customer')->user()->update($request->only(['name', 'email']));

        return back()->with('success', __('messages.profile_updated'));
    }

    public function updateProfileImage(Request $request)
    {

        $folderPath = public_path('uploads/customer/');

        @unlink($folderPath.auth()->guard('customer')->user()->image);

        $image_parts = explode(";base64,", $request->image);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);
        $file_name = uniqid() . '.png';
        $file = $folderPath . $file_name;

        file_put_contents($file, $image_base64);

        auth()->guard('customer')->user()->update(['image' => $file_name ]);


        return response()->json(['success'=>'success', 'file' => $file, 'url'   => asset('uploads/customer/'.$file_name) ]);
    }

}
