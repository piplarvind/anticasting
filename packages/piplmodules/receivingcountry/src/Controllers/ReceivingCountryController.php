<?php

namespace Piplmodules\ReceivingCountry\Controllers;

use Illuminate\Http\Request;
use Piplmodules\ReceivingCountry\Controllers\ReceivingCountryApiController as API;
use Piplmodules\ReceivingCountry\Models\ReceivingCountry;
use Piplmodules\PaymentMethod\Models\PaymentMethod;


class ReceivingCountryController extends ReceivingCountryApiController {
    /*
      |--------------------------------------------------------------------------
      | Piplmodules ReceivingCountry Controller
      |--------------------------------------------------------------------------
      |
      | This controller handles Users for the application.
      |
     */
    public function __construct() {
        $this->api = new API;
    }

    /**
     * @param
     * @return
     */
    public function index(Request $request) {
        $request->request->add(['paginate' => 20]);
        $items = $this->api->listReceivingCountry($request);
        return view('ReceivingCountry::receivingcountry.index', compact('items'));
    }

    /**
     * @param
     * @return
     */
    public function create(Request $request)
    {
        $payment_methods = PaymentMethod::where(['status'=>1])->get();
        return view('ReceivingCountry::receivingcountry.create-edit', compact('payment_methods'));
    }

    /**
     * @param
     * @return
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'country_name' =>  'required|unique:receiving_countries,country_name',
                'flag'  =>  'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'country_iso_code' => 'required|max:3',
                'phone_code'=>  'required|numeric',
                'currency' => 'required|max:3',
                'payment_methods'  =>  'required'
            ]
        );
        $store = $this->api->storeReceivingCountry($request);
        $store = $store->getData();
        if (isset($store->errors)) {
            return back()->withInput()->withErrors($store->errors);
        }

        request()->session()->flash('alert-class', 'alert-success');
        request()->session()->flash('message', $store->message);

        if ($request->back) {
            return back();
        }
        return redirect(route('admin.country.receive'));
    }

    /**
     * @param
     * @return
     */
    public function edit($id)
    {
        $item = ReceivingCountry::findOrFail($id);
        $edit = 1;
        $payment_methods = PaymentMethod::where(['status'=>1])->get();
        return view('ReceivingCountry::receivingcountry.create-edit', compact('item', 'edit', 'payment_methods'));
    }

    /**
     * @param
     * @return
     */
    public function update(Request $request,$id)
    {
        $request->validate(
            [
                'country_name' =>  'required|unique:receiving_countries,country_name,'.$id,
                'flag'  =>  'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'country_iso_code' => 'required|max:3',
                'phone_code'=>  'required|numeric',
                'currency' => 'required|max:3',
                'payment_methods'  =>  'required'
            ]
        );
        $update = $this->api->updateReceivingCountry($request, $id);
        $update = $update->getData();

        if (isset($update->errors)) {
            return back()->withInput()->withErrors($update->errors);
        }

        request()->session()->flash('alert-class', 'alert-success');
        request()->session()->flash('message', $update->message);

        if ($request->back) {
            return back();
        }
        return redirect()->route('admin.country.receive');
    }

    /**
     * Delete single topic
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     *
     */
    public function delete($id)
    {
        $receivingcountry = ReceivingCountry::find($id);
        if (isset($receivingcountry)) {
            $receivingcountry->delete();
            request()->session()->flash('alert-class', 'alert-success');
            request()->session()->flash('message', 'Country deleted successfully.');
        } else {
            request()->session()->flash('alert-class', 'alert-info');
            request()->session()->flash('message', 'No record found for selected item.');
        }
        return redirect()->route('admin.country.receive');
    }

    /**
     * @param
     * @return
     */
    public function confirmDelete($role, $id)
    {
        $item = ReceivingCountry::findOrFail($id);
        return view('ReceivingCountry::receivingcountry.confirm-delete', compact('item'));
    }

    /**
     * @param
     * @return
     */
    public function bulkOperations(Request $request)
    {
        if ($request->ids) {
            $items = ReceivingCountry::whereIn('id', $request->ids)->get();
            if ($items->count()) {
                foreach ($items as $item) {
                    // Do something with your model by filter operation
                    if ($request->operation && $request->operation === 'activate') {
                        $item->status = true;
                        $item->updated_by = auth()->user()->id;
                        $item->save();
                        request()->session()->flash('message', trans('Core::operations.activated_successfully'));
                    } elseif ($request->operation && $request->operation === 'deactivate') {
                        $item->status = false;
                        $item->updated_by = auth()->user()->id;
                        $item->save();
                        request()->session()->flash('message', trans('Core::operations.deactivated_successfully'));
                    }
                }
            }
            request()->session()->flash('alert-class', 'alert-success');
        } else {
            request()->session()->flash('alert-class', 'alert-warning');
            request()->session()->flash('message', trans('Core::operations.nothing_selected'));
        }
        return back();
    }

    //change receivingcountry status
    public function changeReceivingCountryStatus(Request $request)
    {
        if ($request->id != "") {
            $receivingcountry = ReceivingCountry::find($request->id);
            if (isset($receivingcountry)) {
                $receivingcountry->status = $request->status;
                $receivingcountry->save();
                echo json_encode(array("error" => "0"));
            } else {
                echo json_encode(array("error" => "1"));
            }
        } else {
            /* if something going wrong providing error message.  */
            echo json_encode(array("error" => "1"));
        }
    }


}
