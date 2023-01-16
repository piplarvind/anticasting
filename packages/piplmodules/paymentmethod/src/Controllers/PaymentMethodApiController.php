<?php

namespace Piplmodules\PaymentMethod\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Piplmodules\PaymentMethod\Models\PaymentMethod;
use App\Helpers\GeneralHelper;

use Response;
use Auth;
use Validator;

class PaymentMethodApiController extends Controller {
    /*
      |--------------------------------------------------------------------------
      | Piplmodules PaymentMethod API Controller
      |--------------------------------------------------------------------------
      |
     */

    /**
     *
     *
     * @param
     * @return
     */


    public function updateValidation($request, $id)
    {
        $rules['payment_method_name'] = 'required|unique:payment_methods,payment_method_name,'.$id;
        return \Validator::make($request->all(), $rules);
    }

    /**
     *
     *
     * @param
     * @return
     */
    public function listPaymentMethod(Request $request) {
        $item = PaymentMethod::FilterPaymentMethodName()
            ->FilterStatus()
            ->orderBy('payment_method_name', 'asc')
            ->paginate($request->get('paginate'));
        $item->appends($request->except('page'));
        return $item;
    }

    /**
     * @param
     * @return
     */
    public function storePaymentMethod(Request $request)
    {
    
        $item = new PaymentMethod();

        $author = auth()->user()->id;
        $item->payment_method_name = $request->payment_method_name;
        $item->slug = GeneralHelper::seoUrl($request->payment_method_name);

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
    public function updatePaymentMethod(Request $request, $id)
    {
        //dd($request->all());
        
        $item = PaymentMethod::find($id);

        $item->payment_method_name = $request->payment_method_name;
        $item->slug = GeneralHelper::seoUrl($request->payment_method_name);

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
