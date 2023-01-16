<?php

namespace Piplmodules\Testimonial\Controllers;

use Illuminate\Http\Request;
use Piplmodules\Testimonial\Controllers\TestimonialApiController as API;
use Piplmodules\Testimonial\Models\Testimonial;


class TestimonialController extends TestimonialApiController {
    /*
      |--------------------------------------------------------------------------
      | Piplmodules Testimonial Controller
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
        $items = $this->api->listTestimonial($request);
        return view('Testimonial::testimonial.index', compact('items'));
    }

    /**
     * @param
     * @return
     */
    public function create(Request $request)
    {
        return view('Testimonial::testimonial.create-edit');
    }

    /**
     * @param
     * @return
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'client_name' =>  'required',
                'testimonial'  =>  'required',
                'rating'  =>  'required|integer|lte:5|gte:1',
                'order'  =>  'required|integer',
            ]
        );
        $store = $this->api->storeTestimonial($request);
        $store = $store->getData();
        if (isset($store->errors)) {
            return back()->withInput()->withErrors($store->errors);
        }
        request()->session()->flash('alert-success', $store->message);

        if ($request->back) {
            return back();
        }
        return redirect(route('admin.testimonials'));
    }

    /**
     * @param
     * @return
     */
    public function edit($id)
    {
        $item = Testimonial::findOrFail($id);
        $edit = 1;
        return view('Testimonial::testimonial.create-edit', compact('item', 'edit'));
    }

    /**
     * @param
     * @return
     */
    public function update(Request $request,$id)
    {
        $request->validate(
            [
                'client_name' =>  'required',
                'testimonial'  =>  'required',
                'rating'  =>  'required|integer|lte:5|gte:1',
                'order'  =>  'required|integer',
            ]
        );
        $update = $this->api->updateTestimonial($request, $id);
        $update = $update->getData();

        if (isset($update->errors)) {
            return back()->withInput()->withErrors($update->errors);
        }
        request()->session()->flash('alert-success', $update->message);

        if ($request->back) {
            return back();
        }
        return redirect()->route('admin.testimonials');
    }

    /**
     * Delete single topic
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     *
     */
    public function delete($id)
    {
        $testimonial = Testimonial::find($id);
        if (isset($testimonial)) {
            $testimonial->delete();
            request()->session()->flash('alert-success', 'Testimonial deleted successfully.');
        } else {
            request()->session()->flash('alert-danger', 'No record found for selected item.');
        }
        return redirect()->route('admin.testimonials');
    }

    /**
     * @param
     * @return
     */
    public function confirmDelete($role, $id)
    {
        $item = Testimonial::findOrFail($id);
        return view('Testimonial::testimonial.confirm-delete', compact('item'));
    }

    /**
     * @param
     * @return
     */
    public function bulkOperations(Request $request)
    {
        if ($request->ids) {
            $items = Testimonial::whereIn('id', $request->ids)->get();
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
        if ($request->testimonial_id != "") {
            $topic = Testimonial::find($request->testimonial_id);
            
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
