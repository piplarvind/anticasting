<?php

namespace Piplmodules\PaymentMethod\Controllers;

use Illuminate\Http\Request;
use Piplmodules\PaymentMethod\Controllers\PaymentMethodApiController as API;
use Piplmodules\PaymentMethod\Models\PaymentMethod;


class PaymentMethodController extends PaymentMethodApiController {
    /*
      |--------------------------------------------------------------------------
      | Piplmodules PaymentMethod Controller
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
        $items = $this->api->listPaymentMethod($request);
        return view('PaymentMethod::paymentmethod.index', compact('items'));
    }

    /**
     * @param
     * @return
     */
    public function create(Request $request)
    {
        return view('PaymentMethod::paymentmethod.create-edit');
    }

    /**
     * @param
     * @return
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'payment_method_name' =>  'required'
            ]
        );
        $store = $this->api->storePaymentMethod($request);
        $store = $store->getData();
        if (isset($store->errors)) {
            return back()->withInput()->withErrors($store->errors);
        }

        request()->session()->flash('alert-class', 'alert-success');
        request()->session()->flash('message', $store->message);

        if ($request->back) {
            return back();
        }
        return redirect(route('admin.paymentmethod.list'));
    }

    /**
     * @param
     * @return
     */
    public function edit($id)
    {
        $item = PaymentMethod::findOrFail($id);
        $edit = 1;
        $payment_methods = ['CakePHP', 'Laravel','YII', 'Send'];
        $selected_payment = explode(',', $item->payment_methods);
        return view('PaymentMethod::paymentmethod.create-edit', compact('item', 'edit', 'payment_methods','selected_payment'));
    }

    /**
     * @param
     * @return
     */
    public function update(Request $request,$id)
    {
        $request->validate(
            [
                'payment_method_name' =>  'required|unique:payment_methods,payment_method_name,'.$id
            ]
        );
        $update = $this->api->updatePaymentMethod($request, $id);
        $update = $update->getData();

        if (isset($update->errors)) {
            return back()->withInput()->withErrors($update->errors);
        }

        request()->session()->flash('alert-class', 'alert-success');
        request()->session()->flash('message', $update->message);

        if ($request->back) {
            return back();
        }
        return redirect()->route('admin.paymentmethod.list');
    }

    /**
     * Delete single topic
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     *
     */
    public function delete($id)
    {
        $paymentmethod = PaymentMethod::find($id);
        if (isset($paymentmethod)) {
            $paymentmethod->delete();
            request()->session()->flash('alert-class', 'alert-success');
            request()->session()->flash('message', 'Country deleted successfully.');
        } else {
            request()->session()->flash('alert-class', 'alert-info');
            request()->session()->flash('message', 'No record found for selected item.');
        }
        return redirect()->route('admin.paymentmethod.list');
    }

    /**
     * @param
     * @return
     */
    public function confirmDelete($role, $id)
    {
        $item = PaymentMethod::findOrFail($id);
        return view('PaymentMethod::paymentmethod.confirm-delete', compact('item'));
    }

    /**
     * @param
     * @return
     */
    public function bulkOperations(Request $request)
    {
        if ($request->ids) {
            $items = PaymentMethod::whereIn('id', $request->ids)->get();
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

    //change paymentmethod status
    public function changePaymentMethodStatus(Request $request)
    {
        if ($request->id != "") {
            $paymentmethod = PaymentMethod::find($request->id);
            if (isset($paymentmethod)) {
                $paymentmethod->status = $request->status;
                $paymentmethod->save();
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
