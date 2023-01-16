<?php

namespace Piplmodules\Settings\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;
use Piplmodules\Settings\Models\Setting;
use App\Helpers\GlobalValues;
use DB;
use Lang;

class SettingsController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     *
     * @return View
     */
    public function editInformation()
    {
        $site_title = GlobalValues::get('site_title');
        $site_email = GlobalValues::get('site_email');
        $contact_email = GlobalValues::get('contact_email');
        $address = GlobalValues::get('address');
        $phone = GlobalValues::get('phone');

        return view('Settings::info', compact('site_title',
            'site_email',
            'contact_email',
            'phone',
            'address'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateMainInfo(Request $request)
    {

        $request->validate(
            [
                'site_title' => 'required',
                'site_email' => 'required|email|regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix',
                'contact_email' => 'nullable|email|regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix',
                'phone' => 'required',
                'address' => 'required'
            ]
        );
        $name = $request->site_title;
        $email = $request->site_email;
        $phone = $request->phone;
        $address = $request->address;
        $contact_email = $request->contact_email;


        $nameSetting = Setting::find(1);
        $emailSetting = Setting::find(2);
        $phoneSetting = Setting::find(3);
        $addressSetting = Setting::find(4);
        $contact_emailSetting = Setting::find(5);



//dd($addressSetting);
        $nameSetting->value = $name;
        $emailSetting->value = $email;
        $phoneSetting->value = $phone;
        $addressSetting->value = $address;
        $contact_emailSetting->value = $contact_email;


        $nameSetting->save();
        $emailSetting->save();
        $phoneSetting->save();
        $addressSetting->save();
        $contact_emailSetting->save();

        request()->session()->flash('alert-success', "Record updated successfully");
        return back();
    }



}
