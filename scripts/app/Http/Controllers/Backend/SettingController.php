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
}
