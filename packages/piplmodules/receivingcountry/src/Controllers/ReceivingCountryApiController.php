<?php

namespace Piplmodules\ReceivingCountry\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Piplmodules\ReceivingCountry\Models\ReceivingCountry;
use App\Helpers\GeneralHelper;

use Response;
use Auth;
use Validator;

class ReceivingCountryApiController extends Controller {
    /*
      |--------------------------------------------------------------------------
      | Piplmodules ReceivingCountry API Controller
      |--------------------------------------------------------------------------
      |
     */

    /**
     *
     *
     * @param
     * @return
     */


    public function updateValidation($request, $old_name="")
    {
        $rules['country_name'] = 'required';
        //$rules['flag'] = 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048';
        //$rules['payment_methods'] = 'required';

        return \Validator::make($request->all(), $rules);
    }

    /**
     *
     *
     * @param
     * @return
     */
    public function listReceivingCountry(Request $request) {
        $item = ReceivingCountry::FilterCountryName()
            ->FilterStatus()
            ->orderBy('country_name', 'asc')
            ->paginate($request->get('paginate'));
        $item->appends($request->except('page'));
        return $item;
    }

    /**
     * @param
     * @return
     */
    public function storeReceivingCountry(Request $request)
    {
    
        $item = new ReceivingCountry();

        $author = auth()->user()->id;
        $item->country_name = $request->country_name;
        $item->slug = GeneralHelper::seoUrl($request->country_name);
        $item->country_iso_code = $request->country_iso_code;
        $item->phone_code = $request->phone_code;
        $item->currency = $request->currency;
        $imageName = time().'.'.$request->flag->extension();       
        $request->flag->move(public_path('country'), $imageName);
        $item->flag = $imageName;

        if(is_array($request->payment_methods)){
            $item->payment_methods = implode(',', $request->payment_methods);
        }
        $item->status = '0';
        if ($request->status) {
            $item->status = '1';
        }
        $item->save();

        $response = ['message' => trans('Core::operations.saved_successfully')];
        return response()->json($response, 201);
    }

    /**
     *
     *
     * @param
     * @return
     */
    public function updateReceivingCountry(Request $request, $id)
    {
        //dd($request->all());
        $item = ReceivingCountry::find($id);

        $item->country_name = $request->country_name;
        $item->slug = GeneralHelper::seoUrl($request->country_name);
        $item->country_iso_code = $request->country_iso_code;
        $item->phone_code = $request->phone_code;
        $item->currency = $request->currency;
        if($request->flag){
            @unlink(public_path('country').'/'.$item->flag);
            $imageName = time().'.'.$request->flag->extension();       
            $request->flag->move(public_path('country'), $imageName);
            $item->flag = $imageName;
        }
        

        $item->status = '0';
        if ($request->status) {
            $item->status = '1';
        }

        if(is_array($request->payment_methods)){
            $item->payment_methods = implode(',', $request->payment_methods);
        }
        $item->save();

        $response = ['message' => trans('Core::operations.updated_successfully')];
        return response()->json($response, 201);
    }


}
