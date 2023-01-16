<?php

namespace Piplmodules\Faq\Controllers;

use Illuminate\Http\Request;
use Piplmodules\Faq\Controllers\FaqApiController as API;
use Piplmodules\Faq\Models\Faq;


class FaqController extends FaqApiController {
    /*
      |--------------------------------------------------------------------------
      | Piplmodules Faq Controller
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
        $items = $this->api->listFaq($request);
        return view('Faq::faq.index', compact('items'));
    }

    /**
     * @param
     * @return
     */
    public function create(Request $request)
    {
        return view('Faq::faq.create-edit');
    }

    /**
     * @param
     * @return
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'question' =>  'required',
                'answer'  =>  'required',
                'order'  =>  'required|numeric'
            ]
        );
        $store = $this->api->storeFaq($request);
        $store = $store->getData();
        if (isset($store->errors)) {
            return back()->withInput()->withErrors($store->errors);
        }
        request()->session()->flash('alert-success', $store->message);

        if ($request->back) {
            return back();
        }
        return redirect(route('admin.faq'));
    }

    /**
     * @param
     * @return
     */
    public function edit($id)
    {
        $item = Faq::findOrFail($id);
        $edit = 1;
        return view('Faq::faq.create-edit', compact('item', 'edit'));
    }

    /**
     * @param
     * @return
     */
    public function update(Request $request,$id)
    {
        $request->validate(
            [
                'question' =>  'required',
                'answer'  =>  'required',
                'order'  =>  'required|numeric',
            ]
        );
        $update = $this->api->updateFaq($request, $id);
        $update = $update->getData();

        if (isset($update->errors)) {
            return back()->withInput()->withErrors($update->errors);
        }
        request()->session()->flash('alert-success', $update->message);

        if ($request->back) {
            return back();
        }
        return redirect()->route('admin.faq');
    }

    /**
     * Delete single topic
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     *
     */
    public function delete($id)
    {
        $faq = Faq::find($id);
        if (isset($faq)) {
            $faq->delete();
            request()->session()->flash('alert-success', 'Faq deleted successfully.');
        } else {
            request()->session()->flash('alert-danger', 'No record found for selected item.');
        }
        return redirect()->route('admin.faq');
    }

    /**
     * @param
     * @return
     */
    public function confirmDelete($role, $id)
    {
        $item = Faq::findOrFail($id);
        return view('Faq::faq.confirm-delete', compact('item'));
    }

    /**
     * @param
     * @return
     */
    public function bulkOperations(Request $request)
    {
        if ($request->ids) {
            $items = Faq::whereIn('id', $request->ids)->get();
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
    public function changeTopicStatus(Request $request)
    {
        if ($request->faq_id != "") {
            $topic = Faq::find($request->faq_id);
            if (isset($topic)) {
                $topic->status = $request->status;
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
