<?php

namespace App\Modules\Settings\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\GlobalVariable;
use App\Modules\Settings\Models\Setting;
class SettingsController extends Controller
{

    /**
     * Display the module welcome screen
     *
     * @return \Illuminate\Http\Response
     */
    public function SettingMainInfo()
    {
        $site_title = GlobalVariable::get('site_title');
        $site_url = GlobalVariable::get('site_url');
        $address = GlobalVariable::get('address');
        $site_email = GlobalVariable::get('site_email');
       
       
        return view("Settings::index",compact(
            'site_title',
            'site_url',
            'address',
            'site_email',
        ));
    }
    public function UpdateSettingMainInfo(Request $request){

         $request->validate([
           'site_title'=>'required',  
           'site_url'=>'required',  
           'address'=>'required',  
           'site_email'=>'required',  

         ],[
            'site_title.required'=>'Please enter site title',
            'site_url.required'=>'Please enter site url',
            'address.required'=>'Please enter site address',
            'site_email.required'=>'Please enter site email',
         ]
        );
        $site_title = Setting::find(1);
        $site_email = Setting::find(2);
        $address = Setting::find(3);
        $site_url = Setting::find(4);

        $site_title->value = $request->site_title;
        $site_email->value = $request->site_email;
        $address->value = $request->address;
        $site_url->value = $request->site_url;

        $site_title->save();
        $site_email->save();
        $address->save();
        $site_url->save();
        return redirect()->back()->with('message','Setting Updated Successfully.');
    }

}
