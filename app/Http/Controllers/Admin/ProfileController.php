<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileRequest;
use App\Http\Requests\PasswordRequest;
use Illuminate\Support\Facades\Hash;



class ProfileController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        view()->share('site', (object) [
            'title' =>  __('labels.profile')
        ]);
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function edit()
    {
        return view('admin.profile.edit', [ 'current_page' => './' ]);
    }

    /**
     * Update the profile
     *
     * @param  \App\Http\Requests\ProfileRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ProfileRequest $request)
    {
        auth()->user()->update($request->all());

        return back()->withStatus(__('messages.profile_updated'));
    }

    /**
     * Change the password
     *
     * @param  \App\Http\Requests\PasswordRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function password(PasswordRequest $request)
    {
        auth()->user()->update(['password' => Hash::make($request->get('password'))]);

        return back()->withPasswordStatus(__('messages.password_updated'));
    }

    public function uploadImage(Request $request)
    {

        $folderPath = public_path('uploads/user/');

        @unlink($folderPath.auth()->user()->image);

        $image_parts = explode(";base64,", $request->image);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);
        $file_name = uniqid() . '.png';
        $file = $folderPath . $file_name;

        file_put_contents($file, $image_base64);

        auth()->user()->update(['image' => $file_name ]);


        return response()->json(['success'=>'success', 'file' => $file, 'url'   => asset('uploads/user/'.$file_name) ]);
    }

}
