<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Models\Setting;

use Illuminate\Support\Facades\Mail;
use App\Mail\MailMailableSend;

class SettingsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        view()->share('site', (object) [
            'title' =>  __('labels.settings')
        ]);
        $this->middleware('permission:settings.*');
    }

    /**
     * General Settings.
     *
     * @return \Illuminate\Http\Response
     */
    public function general()
    {
        return view('admin.settings.general');
    }

    /**
     * General Settings Save/Update.
     *
     * @return \Illuminate\Http\Response
     */
    public function generalStore(Request $request)
    {

        $data = $request->only(['site_title', 'site_description']);

        // update logo
        if($request->hasFile('site_logo')){
            $file_name = 'site_logo.png';
            if(setting('site_logo')!='default.png')
                Storage::disk('uploads')->delete( 'logo/'.setting('site_logo') );
            $request->file('site_logo')->storeAs('logo', $file_name, 'uploads');
            $data['site_logo'] = $file_name;
        }

        // update logo
        if($request->hasFile('site_favicon')){
            $file_name = 'favicon.png';
            $request->file('site_favicon')->storeAs('logo', $file_name, 'uploads');
            $data['site_favicon'] = $file_name;
        }

        $this->updateSettings($data);
        
        return back()->with('success', __('messages.settings_updated'));
    }

    /**
     * General Settings Save/Update.
     *
     * @return \Illuminate\Http\Response
     */
    public function generalSocialMediaStore(Request $request)
    {

        $data = $request->only(['social_media_facebook', 'social_media_instagram', 'social_media_twitter', 'social_media_pinterest', 'social_media_youtube', 'social_media_envato']);

        $this->updateSettings($data);
        
        return back()->with('success', __('messages.settings_updated'));
    }

    /**
     * Language Settings.
     *
     * @return \Illuminate\Http\Response
     */
    public function language()
    {
        return view('admin.settings.language');
    }

    /**
     * Language Settings Save/Update.
     *
     * @return \Illuminate\Http\Response
     */
    public function languageStore(Request $request)
    {

        $data = $request->only(['default_lang']);

        $this->updateSettings($data);
        
        return back()->with('success', __('messages.settings_updated'));
    }

    /**
     * API Settings.
     *
     * @return \Illuminate\Http\Response
     */
    public function api()
    {
        return view('admin.settings.api');
    }

    /**
     * API Settings Save/Update.
     *
     * @return \Illuminate\Http\Response
     */
    public function apiStore(Request $request)
    {

        $data = $request->only(['GOOGLE_RECAPTCHA_KEY', 'GOOGLE_RECAPTCHA_SECRET']);

        $data['RECAPTCH_TYPE'] = $request->has('RECAPTCH_TYPE') ? 'GOOGLE' : NULL;

        $this->updateSettings($data);
        
        return back()->with('success', __('messages.settings_updated'));
    }

    /**
     * Frontend Settings.
     *
     * @return \Illuminate\Http\Response
     */
    public function frontend()
    {
        return view('admin.settings.frontend');
    }

    /**
     * Frontend Settings Save/Update.
     *
     * @return \Illuminate\Http\Response
     */
    public function frontendStore(Request $request)
    {

        $data = $request->only(['theme_color', 'theme_color_dark', 'popular_categories']);

        // update logo
        if($request->hasFile('frontend_logo')){
            $file_name = 'frontend_logo.png';
            $request->file('frontend_logo')->storeAs('logo', $file_name, 'uploads');
            $data['frontend_logo'] = $file_name;
        }

        // update dark logo
        if($request->hasFile('frontend_dark_logo')){
            $file_name = 'frontend_dark_logo.png';
            $request->file('frontend_dark_logo')->storeAs('logo', $file_name, 'uploads');
            $data['frontend_dark_logo'] = $file_name;
        }

        // update favicon
        if($request->hasFile('frontend_favicon')){
            $file_name = 'frontend_favicon.png';
            $request->file('frontend_favicon')->storeAs('logo', $file_name, 'uploads');
            $data['frontend_favicon'] = $file_name;
        }

        $this->updateSettings($data);
        
        return back()->with('success', __('messages.settings_updated'));
    }

    /**
     * Frontend Settings Save/Update.
     *
     * @return \Illuminate\Http\Response
     */
    public function frontendHomeStore(Request $request)
    {

        $data = $request->only(['home_max_articles', 'home_featured_categories']);

        

        // update favicon
        if($request->hasFile('frontend_home_header')){
            $file_name = 'frontend_home_header.'.$request->file('frontend_home_header')->getClientOriginalExtension();
            $request->file('frontend_home_header')->storeAs('', $file_name, 'uploads');
            $data['frontend_home_header'] = $file_name;
        }

        // dd($data);

        $this->updateSettings($data);
        
        return back()->with('success', __('messages.settings_updated'));
    }

    /**
     * Ticket Settings.
     *
     * @return \Illuminate\Http\Response
     */
    public function ticket()
    {
        return view('admin.settings.ticket');
    }

    /**
     * Ticket Settings Save/Update.
     *
     * @return \Illuminate\Http\Response
     */
    public function ticketStore(Request $request)
    {

        $data = $request->only(['ticket_default_assigned_user_id']);
        
        $data['auto_assign_user']  =  $request->has('auto_assign_user') ? 'yes' : 'no';
        
        $data['USER_REOPEN_ISSUE']  =  $request->has('USER_REOPEN_ISSUE') ? 'yes' : 'no';
        $data['CUSTOMER_CLOSE_TICKET']  =  $request->has('CUSTOMER_CLOSE_TICKET') ? 'yes' : 'no';

        $this->updateSettings($data);
        
        return back()->with('success', __('messages.settings_updated'));
    }

    /**
     * Email Settings.
     *
     * @return \Illuminate\Http\Response
     */
    public function email()
    {
        return view('admin.settings.email');
    }

    /**
     * Email Settings Save/Update.
     *
     * @return \Illuminate\Http\Response
     */
    public function emailStore(Request $request)
    {

        $data = $request->only(['mail_driver', 'mail_host', 'mail_port', 'mail_from_address', 'mail_from_name', 'mail_encryption', 'mail_username', 'mail_password']);
        
        $this->updateSettings($data);
        
        return back()->with('success', __('messages.settings_updated'));
    }

    /**
     * Email Settings Save/Update.
     *
     * @return \Illuminate\Http\Response
     */
    public function emailSettingStore(Request $request)
    {
        // email/whentosend

        $data = [];
        
        $data['EMAIL_USER_TICKET_CREATE_CUSTOMER']  =  $request->has('EMAIL_USER_TICKET_CREATE_CUSTOMER') ? 'yes' : 'no';
        $data['EMAIL_USER_TICKET_CREATE_AGENT']  =  $request->has('EMAIL_USER_TICKET_CREATE_AGENT') ? 'yes' : 'no';
        $data['EMAIL_TICKET_CUSTOMER_REPLIED']  =  $request->has('EMAIL_TICKET_CUSTOMER_REPLIED') ? 'yes' : 'no';
        $data['EMAIL_TICKET_AGENT_REPLIED']  =  $request->has('EMAIL_TICKET_AGENT_REPLIED') ? 'yes' : 'no';
        
        $this->updateSettings($data);
        
        return back()->with('success', __('messages.settings_updated'));
    }

    /**
     * Email Settings Save/Update.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendTestMail(Request $request)
    {

        $email = $request->get('email');

        Mail::send('admin.emails.template', [ 'emailBody' => "This is a test email sent by system" ], function($message) use ($email) {
            $message->to($email)->subject('Test Email');
         });
        
        return back()->with('success', __('messages.test_email_sent'));
    }

    /**
     * Email Settings.
     *
     * @return \Illuminate\Http\Response
     */
    public function emailTemplates()
    {
        $email_templates = (new \App\Models\EmailTemplate())->all();
        return view('admin.emails.index', compact('email_templates'));
    }

    /**
     * Email Settings.
     *
     * @return \Illuminate\Http\Response
     */
    public function emailTemplateEdit($id)
    {
        $template = (new \App\Models\EmailTemplate())->find($id);
        return view('admin.emails.edit', compact('template'));
    }

    /**
     * Email Settings Save/Update.
     *
     * @return \Illuminate\Http\Response
     */
    public function emailTemplateUpdate(Request $request, $id)
    {

        \App\Models\EmailTemplate::find($id)->update($request->only(['subject', 'body']));
        
        // die( $request->body );
        
        return redirect()->route('settings.email_templates')->with('success', __('messages.email_template_updated'));
    }


    /**
     * Ticket Settings Save/Update.
     *
     * @return \Illuminate\Http\Response
     */
    private function updateSettings($data)
    {

        foreach($data as $key => $val){
        	$setting = Setting::where('key', $key);
        	if( $setting->exists() )
        		$setting->first()->update(['value' => $val]);
        }

    }



}
