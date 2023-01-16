<?php

namespace Piplmodules\Testimonial\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Piplmodules\Testimonial\Models\Testimonial;

use Response;
use Auth;
use Validator;

class TestimonialApiController extends Controller {
    /*
      |--------------------------------------------------------------------------
      | Piplmodules Testimonial API Controller
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
        $rules['client_name'] = 'required';
        $rules['testimonial'] = 'required';
        $rules['rating'] = 'required|integer|lte:5|gte:1';
        $rules['order'] = 'required|integer';

        return \Validator::make($request->all(), $rules);
    }

    /**
     *
     *
     * @param
     * @return
     */
    public function listTestimonial(Request $request) {
        $testimonials = Testimonial::FilterClientName()
            ->FilterStatus()
            ->orderBy('order', 'asc')
            ->paginate($request->get('paginate'));
        $testimonials->appends($request->except('page'));
        return $testimonials;
    }

    /**
     * @param
     * @return
     */
    public function storeTestimonial(Request $request)
    {
        $testimonial = new Testimonial();

        $author = auth()->user()->id;
        $testimonial->client_name = $request->client_name;
        $testimonial->status = false;
        if ($request->status) {
            $testimonial->status = true;
        }

        $testimonial->testimonial = $request->testimonial;
        $testimonial->rating = $request->rating;
        $testimonial->order = $request->order;
        $testimonial->save();

        $response = ['message' => trans('Core::operations.saved_successfully')];
        return response()->json($response, 201);
    }

    /**
     *
     *
     * @param
     * @return
     */
    public function updateTestimonial(Request $request, $id)
    {
        $testimonial = Testimonial::find($id);

        $testimonial->client_name = $request->client_name;
        $testimonial->status = false;
        if ($request->status) {
            $testimonial->status = true;
        }

        $testimonial->testimonial = $request->testimonial;
        $testimonial->rating = $request->rating;
        $testimonial->order = $request->order;
        $testimonial->save();

        $response = ['message' => trans('Core::operations.updated_successfully')];
        return response()->json($response, 201);
    }


}
