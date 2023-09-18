<?php

namespace App\Http\Controllers\CustomerPanel\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Customer;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class RegisterController extends Controller
{

    public function show()
    {
        return view('customer-panel.auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
          'name'      => 'required|min:3',
          'email'     => 'required|unique:customers',
          'password'  => 'required|min:6',
          'agree_terms' =>  'required|in:agreed',
          'g-recaptcha-response'  =>  'recaptcha'
        ]);

        $data = $request->except(['password']);
        $data['password'] = Hash::make($request->get('password'));

        $file_name = uniqid().'.jpg';
        Storage::disk('uploads')->copy('customer/default.jpg', 'customer/'.$file_name);
        $data['image'] = $file_name;

        Customer::create($data);

        return redirect()->route('customer.login')->with('success', __('New customer created sucessfully'));
     }

}
