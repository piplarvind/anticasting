<?php

namespace Piplmodules\SendingCountry\Controllers;

use Illuminate\Http\Request;
use Piplmodules\SendingCountry\Controllers\SendingCountryApiController as API;
use Piplmodules\SendingCountry\Models\SendingCountry;
use Piplmodules\PaymentMethod\Models\PaymentMethod;
use Illuminate\Support\Collection;


class SendingCountryController extends SendingCountryApiController {
    /*
      |--------------------------------------------------------------------------
      | Piplmodules SendingCountry Controller
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
        $items = $this->api->listSendingCountry($request);
        return view('SendingCountry::sendingcountry.index', compact('items'));
    }

    /**
     * @param
     * @return
     */
    public function create(Request $request)
    {
        $payment_methods = PaymentMethod::where(['status'=>1])->get();
        $items = new SendingCountry();
        return view('SendingCountry::sendingcountry.create-edit', compact('items','payment_methods'));
    }

    /**
     * @param
     * @return
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'country_name' =>  'required|unique:sending_countries,country_name',
                'flag'  =>  'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'country_iso_code' => 'required|max:3',
                'phone_code' => 'required|numeric',
                'currency' => 'required|max:3',
                'payment_methods'  =>  'required'
            ]
        );
        $store = $this->api->storeSendingCountry($request);
        $store = $store->getData();
        if (isset($store->errors)) {
            return back()->withInput()->withErrors($store->errors);
        }

        request()->session()->flash('alert-class', 'alert-success');
        request()->session()->flash('alert-success', $store->message);

        if ($request->back) {
            return back();
        }
        return redirect(route('admin.country.send'));
    }

    /**
     * @param
     * @return
     */
    public function edit($id)
    {
        $item = SendingCountry::findOrFail($id);
        $edit = 1;
        $payment_methods = PaymentMethod::where(['status'=>1])->get();
        return view('SendingCountry::sendingcountry.create-edit', compact('item', 'edit', 'payment_methods'));
    }

    /**
     * @param
     * @return
     */
    public function update(Request $request,$id)
    {
        $request->validate(
            [
                'country_name' =>  'required|unique:sending_countries,country_name,'.$id,
                'flag'  =>  'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'country_iso_code' => 'required|max:3',
                'phone_code' => 'required|numeric',
                'currency' => 'required|max:3',
                'payment_methods'  =>  'required'
            ]
        );
        $update = $this->api->updateSendingCountry($request, $id);
        $update = $update->getData();

        if (isset($update->errors)) {
            return back()->withInput()->withErrors($update->errors);
        }

        request()->session()->flash('alert-success', $update->message);

        if ($request->back) {
            return back();
        }
        return redirect()->route('admin.country.send');
    }

    /**
     * Delete single topic
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     *
     */
    public function delete($id)
    {
        $sendingcountry = SendingCountry::find($id);
        if (isset($sendingcountry)) {
            $sendingcountry->delete();
            request()->session()->flash('alert-success', 'Country deleted successfully.');
        } else {
            request()->session()->flash('alert-danger', 'No record found for selected item.');
        }
        return redirect()->route('admin.country.send');
    }

    /**
     * @param
     * @return
     */
    public function confirmDelete($role, $id)
    {
        $item = SendingCountry::findOrFail($id);
        return view('SendingCountry::sendingcountry.confirm-delete', compact('item'));
    }

    /**
     * @param
     * @return
     */
    public function bulkOperations(Request $request)
    {
        if ($request->ids) {
            $items = SendingCountry::whereIn('id', $request->ids)->get();
            if ($items->count()) {
                foreach ($items as $item) {
                    // Do something with your model by filter operation
                    if ($request->operation && $request->operation === 'activate') {
                        $item->status = true;
                        $item->updated_by = auth()->user()->id;
                        $item->save();
                        request()->session()->flash('alert-success', trans('Core::operations.activated_successfully'));
                    } elseif ($request->operation && $request->operation === 'deactivate') {
                        $item->status = false;
                        $item->updated_by = auth()->user()->id;
                        $item->save();
                        request()->session()->flash('alert-success', trans('Core::operations.deactivated_successfully'));
                    }
                }
            }
        } else {
            request()->session()->flash('alert-danger', trans('Core::operations.nothing_selected'));
        }
        return back();
    }

    //change sendingcountry status
    public function changeSendingCountryStatus(Request $request)
    {
        if ($request->id != "") {
            $sendingcountry = SendingCountry::find($request->id);
            if (isset($sendingcountry)) {
                $sendingcountry->status = $request->status;
                $sendingcountry->save();
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
