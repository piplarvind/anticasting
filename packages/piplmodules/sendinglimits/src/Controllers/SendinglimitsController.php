<?php

namespace Piplmodules\Sendinglimits\Controllers;

use Illuminate\Http\Request;
use Piplmodules\Sendinglimits\Controllers\SendinglimitsApiController as API;
use Piplmodules\Sendinglimits\Models\Sendinglimit;
use Piplmodules\Sendinglimits\Models\SendingLimitAttribute;

class SendinglimitsController extends SendinglimitsApiController {
    /*
      |--------------------------------------------------------------------------
      | Piplmodules Sendinglimits Controller
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
        $items = $this->api->listSendinglimits($request);
        // dd($items);
        return view('Sendinglimits::sendinglimits.index', compact('items'));
    }


    /**
     * @param
     * @return
     */
    public function create(Request $request)
    {
        return view('Sendinglimits::sendinglimits.create-edit');
    }

    /**
     * @param
     * @return
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'name' =>  'required',
                // 'one_day_price'  =>  'required',
                // 'thirty_day_price'  =>  'required',
                // 'half_yearly_price'  =>  'required',
                'information_needed'  =>  'required',
            ]
        );
        $store = $this->api->storeSendinglimits($request);
        
        

        $store = $store->getData();
        if (isset($store->errors)) {
            return back()->withInput()->withErrors($store->errors);
        }
        request()->session()->flash('alert-success', $store->message);

        if ($request->back) {
            return back();
        }
        return redirect(route('admin.sendlimits'));
    }

    /**
     * @param
     * @return
     */
    public function edit($id)
    {
        $item = SendingLimit::findOrFail($id);
        $edit = 1;
        return view('Sendinglimits::sendinglimits.create-edit', compact('item', 'edit'));
    }

    /**
     * @param
     * @return
     */
    public function update(Request $request,$id)
    {
        $request->validate(
            [
                'name' =>  'required',
                // 'one_day_price'  =>  'required',
                // 'thirty_day_price'  =>  'required',
                // 'half_yearly_price'  =>  'required',
                'information_needed'  =>  'required',
            ]
        );
        $update = $this->api->updateSendinglimits($request, $id);
        $update = $update->getData();

        if (isset($update->errors)) {
            return back()->withInput()->withErrors($update->errors);
        }
        request()->session()->flash('alert-success', $update->message);

        if ($request->back) {
            return back();
        }
        return redirect()->route('admin.sendlimits');
    }


    /**
     * @param
     * @return
     */
    public function attributeList(Request $request) {
        $id = $request->id;
        $tier = SendingLimit::findOrFail($id);
        $items = $this->api->listSendinglimitAttributes($id);
        // dd($items);
        return view('Sendinglimits::sendinglimits.attributes-index', compact('id', 'tier','items'));
    }

    /**
     * @param
     * @return
     */
    public function createAttribute($id)
    {
        $tier = SendingLimit::findOrFail($id);
        return view('Sendinglimits::sendinglimits.create-edit-attribute', compact('id', 'tier'));
    }

    /**
     * @param
     * @return
     */
    public function storeAttribute(Request $request, $id)
    {
        // dd($request->all());
        $request->validate(
            [
                'sending_limit_id'  =>  'required',
                'one_day_price'  =>  'required',
                'thirty_day_price'  =>  'required',
                'half_yearly_price'  =>  'required',
                // 'information_needed'  =>  'required',
            ]
        );
        $store = $this->api->storeSendinglimitAttr($request, $id);
        $store = $store->getData();
        if (isset($store->errors)) {
            return back()->withInput()->withErrors($store->errors);
        }
        request()->session()->flash('alert-success', $store->message);
        if ($request->back) {
            return back();
        }
        return redirect(route('admin.sendlimits.attributes', [$id]));
    }

    /**
     * @param
     * @return
     */
    public function editAttribute($id, $sId)
    {
        $tier = SendingLimit::findOrFail($id);
        $item = SendingLimitAttribute::findOrFail($sId);
        $edit = 1;
        return view('Sendinglimits::sendinglimits.create-edit-attribute', compact('id', 'tier', 'edit', 'item'));
    }

    /**
     * @param
     * @return
     */
    public function updateAttribute(Request $request, $id, $sId)
    {
        $request->validate(
            [
                'sending_limit_id'  =>  'required',
                'one_day_price'  =>  'required',
                'thirty_day_price'  =>  'required',
                'half_yearly_price'  =>  'required',
                // 'information_needed'  =>  'required',
            ]
        );
        $update = $this->api->updateSendinglimitAttr($request, $id, $sId);
        $update = $update->getData();

        if (isset($update->errors)) {
            return back()->withInput()->withErrors($update->errors);
        }
        request()->session()->flash('alert-success', $update->message);

        if ($request->back) {
            return back();
        }
        return redirect()->route('admin.sendlimits.attributes', [$id]);
    }
      /**
     * Delete single topic
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     *
     */
    public function deleteAttribute($id, $sId)
    {

        $sendinglimits = SendingLimitAttribute::find($sId);
        if (isset($sendinglimits)) {
            $sendinglimits->delete();
            request()->session()->flash('alert-success', 'Sendinglimits attribute deleted successfully.');
        } else {
            request()->session()->flash('alert-danger', 'No record found for selected item.');
        }
        return redirect()->route('admin.sendlimits.attributes', [$id]);
    }

    /**
     * Delete single topic
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     *
     */
    public function delete($id)
    {
        $sendinglimits = SendingLimit::find($id);
        if (isset($sendinglimits)) {
            $sendinglimits->delete();
            request()->session()->flash('alert-success', 'Sendinglimits deleted successfully.');
        } else {
            request()->session()->flash('alert-danger', 'No record found for selected item.');
        }
        return redirect()->route('admin.sendlimits');
    }

    /**
     * @param
     * @return
     */
    public function confirmDelete($role, $id)
    {
        $item = SendingLimit::findOrFail($id);
        return view('Sendinglimits::sendinglimits.confirm-delete', compact('item'));
    }

    /**
     * @param
     * @return
     */
    public function bulkOperations(Request $request)
    {
        if ($request->ids) {
            $items = SendingLimit::whereIn('id', $request->ids)->get();
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

    //change topic status
    public function changeStatus(Request $request)
    {
        if ($request->sending_limit_id != "") {
            $topic = SendingLimit::find($request->sending_limit_id);
            
            if (isset($topic)) {
                $topic->status = !$request->status;
                $topic->save();
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
