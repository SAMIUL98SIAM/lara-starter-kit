<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function general()
    {
        return view('backend.settings.general');
    }
    public function generalUpdate(Request $request)
    {
        $this->validate($request,[
            'site_title'=> 'string|min:2|max:255' ,
            'site_description'=> 'nullable|string|min:2|max:255' ,
            'site_address'=> 'nullable|string|min:2|max:255' ,
        ]);

        Setting::updateOrCreate(['name'=>'site_title'],['value'=>$request->get('site_title')]);
        //update env
        Artisan::call("env:set APP_NAME='". $request->site_title ."'");
        Setting::updateOrCreate(['name'=>'site_description'],['value'=>$request->get('site_description')]);
        Setting::updateOrCreate(['name'=>'site_address'],['value'=>$request->get('site_address')]);
        notify()->success('Settings Updated','Success');
        return back();
    }



    public function appearence()
    {
        return view('backend.settings.appearence');
    }

    /**
     * Update Appearance
     * @param UpdateAppearanceRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function appearenceUpdate(Request $request)
    {
        $this->validate($request,[
            'site_logo'=> 'nullable|image' ,
            'site_favicon'=> 'nullable|image' ,
        ]);

        if ($request->hasFile('site_logo')) {
            $this->deleteOldLogo(setting('settings.site_logo'));
            Setting::updateOrCreate(
                ['name'=>'site_logo'],
                ['value'=>Storage::disk('public')->putFile('logos', $request->file('site_logo'))]
            );
        }


        if ($request->hasFile('site_favicon')) {
            $this->deleteOldLogo(setting('settings.site_favicon'));
            Setting::updateOrCreate(
                ['name'=>'site_favicon'],
                ['value'=>Storage::disk('public')->putFile('logos', $request->file('site_favicon'))]
            );
        }
        notify()->success('Settings Successfully Updated.','Success');
        return back();
    }

    /**
     * Delete old logos from storage
     * @param $path
     */
    private function deleteOldLogo($path)
    {
        Storage::disk('public')->delete($path);
    }




    public function mail()
    {
        return view('backend.settings.mail');
    }

    /**
     * Update Appearance
     * @param UpdateAppearanceRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function mailUpdate(Request $request)
    {
        $this->validate($request,[
            'mail_mailer'=> 'string|max:255',
            'mail_host'=> 'nullable|string|max:255',
            'mail_port'=> 'nullable|string|max:255',
            'mail_username'=> 'nullable|string|max:255',
            'mail_password'=> 'nullable|string|max:255',
            'mail_encryption'=> 'nullable|string|max:255',
            'mail_from_address'=> 'nullable|string|max:255',
            'mail_from_name'=> 'nullable|string|max:255',
        ]);
         // Update .env mail settings

        Setting::updateOrCreate(['name'=>'mail_mailer'],['value'=>$request->get('mail_mailer')]);
        Artisan::call("env:set MAIL_MAILER='". $request->mail_mailer ."'");

        Setting::updateOrCreate(['name'=>'mail_host'],['value'=>$request->get('mail_host')]);
        Artisan::call("env:set MAIL_HOST='". $request->mail_host ."'");

        Setting::updateOrCreate(['name'=>'mail_port'],['value'=>$request->get('mail_port')]);
        Artisan::call("env:set MAIL_PORT='". $request->mail_port ."'");

        Setting::updateOrCreate(['name'=>'mail_username'],['value'=>$request->get('mail_username')]);
        Artisan::call("env:set MAIL_USERNAME='". $request->mail_username ."'");

        Setting::updateOrCreate(['name'=>'mail_password'],['value'=>$request->get('mail_password')]);
        Artisan::call("env:set MAIL_PASSWORD='". $request->mail_password ."'");

        Setting::updateOrCreate(['name'=>'mail_encryption'],['value'=>$request->get('mail_encryption')]);
        Artisan::call("env:set MAIL_ENCRYPTION='". $request->mail_encryption ."'");

        Setting::updateOrCreate(['name'=>'mail_from_address'],['value'=>$request->get('mail_from_address')]);
        Artisan::call("env:set MAIL_FROM_ADDRESS='". $request->mail_from_address ."'");

        Setting::updateOrCreate(['name'=>'mail_from_name'],['value'=>$request->get('mail_from_name')]);
        Artisan::call("env:set MAIL_FROM_NAME='". $request->mail_from_name ."'");

        notify()->success('Settings Successfully Updated.','Success');
        return back();
    }


    public function socialite()
    {
        return view('backend.settings.socialite');
    }

    /**
     * Update Appearance
     * @param UpdateAppearanceRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function socialiteUpdate(Request $request)
    {
        $this->validate($request,[
            'facebook_client_id' => 'string|nullable',
            'facebook_client_secret' => 'string|nullable',

            'google_client_id' => 'string|nullable',
            'google_client_secret' => 'string|nullable',

            'github_client_id' => 'string|nullable',
            'github_client_secret' => 'string|nullable',
        ]);
        // Update .env mail settings

        Setting::updateOrCreate(['name'=>'facebook_client_id'],['value'=>$request->get('facebook_client_id')]);
        Artisan::call("env:set FACEBOOK_CLIENT_ID='". $request->facebook_client_id ."'");
        Setting::updateOrCreate(['name'=>'facebook_client_secret'],['value'=>$request->get('facebook_client_secret')]);
        Artisan::call("env:set FACEBOOK_CLIENT_SECRET='". $request->facebook_client_secret ."'");


        Setting::updateOrCreate(['name'=>'google_client_id'],['value'=>$request->get('google_client_id')]);
        Artisan::call("env:set GOOGLE_CLIENT_ID='". $request->google_client_id ."'");
        Setting::updateOrCreate(['name'=>'google_client_secret'],['value'=>$request->get('google_client_secret')]);
        Artisan::call("env:set GOOGLE_CLIENT_SECRET='". $request->google_client_secret ."'");


        Setting::updateOrCreate(['name'=>'github_client_id'],['value'=>$request->get('github_client_id')]);
        Artisan::call("env:set GITHUB_CLIENT_ID='". $request->github_client_id ."'");
        Setting::updateOrCreate(['name'=>'github_client_secret'],['value'=>$request->get('github_client_secret')]);
        Artisan::call("env:set GITHUB_CLIENT_SECRET='". $request->github_client_secret ."'");

        notify()->success('Settings Successfully Updated.','Success');
        return back();
    }



}
